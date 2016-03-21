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

/* Create a database object */
$db =& JFactory::getDBO();
$total_rfps="SELECT * FROM #__cam_rfpinfo "; /* where rfp_type = 'closed' */
$db->Setquery($total_rfps);
$row = $db->loadObjectList();
//echo "<pre>"; print_r($row); exit;

 /* START ** Function to COPY the Source non empty Directory to Destination Directory */
	/*function foldercopy($src, $dst)
	 {
		  if (is_dir($src))
		   {
			$files = scandir($src);
			mkdir($dst); // folder creation with source folder name
			foreach ($files as $file)
			if ($file != "." && $file != "..") foldercopy("$src/$file", "$dst/$file"); //recursive calling function
		   }
  			else if (file_exists($src)) copy($src, $dst); // copies file with source file name
     } */
 /* END ** Function to COPY the Source non empty Directory to Destination Directory */  
		
for($i=0;$i<count($row);$i++)
  {
  $rfp_id = $row[$i]->id;
  $property_id = $row[$i]->property_id; // main folder name
  $newrfp_id = 'RFP'.$rfp_id; //inner rfp folder
  //echo $rfp_id.' n '.$property_id.'<br />';
  
  
  /* START --- Code for GETTING BIDDED VEDNOR INFORMATION  */ 
	$sql_biiddedvendors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, U.extension, U.phone, U.cellphone,V.company_name,V.company_address,V.city,V.state,V.zipcode,V.image, V.in_house_vendor,V.company_phone,V.phone_ext,V.alt_phone,V.alt_phone_ext,V.established_year FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND (VP.proposaltype = 'Submit' OR VP.proposaltype = 'resubmit') AND VP.Alt_bid != 'Yes' ORDER BY VP.id ";
		$db->setQuery($sql_biiddedvendors);
		$Bid_vendors = $db->loadObjectList();
		//echo $Bid_vendors[0]->proposedvendorid; exit;
		//echo '<pre>'; print_r($Bid_vendors); exit;
	/* END --- GETTING BIDDED VEDNOR INFORMATION */
	
  
  /* Start --- Code for Getting Property name */
  
  $property_name ="SELECT property_name FROM #__cam_property where id=".$property_id;
  $db->Setquery($property_name);
  $property_name = $db->loadResult();
  
  $property_tax ="SELECT tax_id FROM #__cam_property where id=".$property_id;
  $db->Setquery($property_tax);
  $property_tax = $db->loadResult();
  
  //$property_name = $property_name.' '.$property_tax;
  $property_name = str_replace(" ", "_", $property_name);
  //echo '<pre>'; print_r($property_name); exit;
  /* End --- Code for Property name */  
  
  for($k=0;$k<count($Bid_vendors);$k++)
 {
  
  
  /* Code for Folder Creation */
  $key = JPATH_BASE .DS.'PropertyDocuments'.DS;
  //echo $key.'<br />';
  if(is_dir($key.$property_name) == false){ @mkdir($key.$property_name, 0777); }
  
  $key1 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS;
  //echo $key1.'<br />'; 
  if(is_dir($key1.'ProposalReports') == false){ @mkdir($key1.'ProposalReports', 0777); }
  
  $key2 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS;
  //echo $key2.'<br />'; 
  if(is_dir($key2.$newrfp_id) == false){ @mkdir($key2.$newrfp_id, 0777); }
  
  $key3 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS;
  //echo $key3.'<br />'; 
  $vendor_name = $Bid_vendors[$k]->name.' '.$Bid_vendors[$k]->lastname; 
  $vendor_name = str_replace(" ", "_", $vendor_name);
  if(is_dir($key3.$vendor_name) == false){ @mkdir($key3.$vendor_name, 0777); }
  
  $key4 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.$vendor_name.DS;
  //echo $key4.'<br />'; 
  if(is_dir($key4.'ProposalAttachments') == false){ @mkdir($key4.'ProposalAttachments', 0777); }
  
  
  /* Start --- Code for Coping the Compliance Documents */
  
  $key5 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.$vendor_name.DS;
  if(is_dir($key5.'VendorCompliance') == false){ @mkdir($key5.'VendorCompliance', 0777); }
	
	
		
    /* END --- Code for Coping the Compliance Documents */	
  
  //chdir($key);  
  //exit;
  }
  }
?>  