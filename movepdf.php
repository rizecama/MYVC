#!/usr/bin/php
<?php 
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');

/* START Move Generated PDF to "PropertyDocuments/property Name/Proposal Reports/RFP#XXXXXX" *** anil_22-09-2011 */

$db =& JFactory::getDBO();
//$movetotal_rfps="SELECT * FROM #__cam_rfpinfo where rfp_type = 'closed' and rfp_pdf=0";
//$movetotal_rfps="SELECT * FROM #__cam_rfpinfo where rfp_type = 'closed'";
$movetotal_rfps="SELECT * FROM #__cam_rfpinfo ";
$db->Setquery($movetotal_rfps);
$moverow = $db->loadObjectList();

for($z=0;$z<count($moverow);$z++)
  {
   			//$rfp_id = '351312';
			$rfp_id = $moverow[$z]->id;
			$property_id = $moverow[$z]->property_id;
			$newrfp_id = 'RFP'.$rfp_id;
			
			 $moveproperty_name ="SELECT property_name FROM #__cam_property where id=".$property_id;
			$db->Setquery($moveproperty_name);
			$moveproperty_name = $db->loadResult();
			$moveproperty_name = str_replace(" ", "_", $moveproperty_name);
			 
			 $path = JPATH_SITE;
			 @$dir1=dir($path); 
			while($filename=$dir1->read())
			{
				if($filename!='.'&&$filename!='..')
				{
				$file_ext = substr($filename, strrpos($filename, '.') + 1);
					if($file_ext == 'pdf')
					{
					  $key = JPATH_BASE .DS.'PropertyDocuments'.DS;
					  //echo $key.'<br />';
					  if(is_dir($key.$moveproperty_name) == false){ @mkdir($key.$moveproperty_name, 0777); }
					  
					  $key1 = JPATH_BASE .DS.'PropertyDocuments'.DS.$moveproperty_name.DS;
					  //echo $key1.'<br />'; 
					  if(is_dir($key1.'ProposalReports') == false){ @mkdir($key1.'ProposalReports', 0777); }
					  
					  $key2 = JPATH_BASE .DS.'PropertyDocuments'.DS.$moveproperty_name.DS.'ProposalReports'.DS;
					  //echo $key2.'<br />'; 
					  if(is_dir($key2.$newrfp_id) == false){ @mkdir($key2.$newrfp_id, 0777); }
					  
						$dest = JPATH_BASE .DS.'PropertyDocuments'.DS.$moveproperty_name.DS.'ProposalReports'.DS.$newrfp_id.DS;
						$rfpfilename = explode('_',$filename);
						//echo '<pre>'; print_r($filename[0]); exit;
						if( $rfpfilename[0] == $rfp_id ) {
						$copied = @copy($filename,$dest.$filename);
							if($copied){ unlink($filename); }
							}
					}
					
				}
				
			} 
  }
// exit;
/* END Move Generated PDF to "PropertyDocuments/property Name/Proposal Reports/RFP#123456" *** anil_22-09-2011 */  
?>
