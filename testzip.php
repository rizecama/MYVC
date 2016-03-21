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


$zip = new ZipArchive();

$filename_1 = "RFP".$_GET[rfpid].".zip";

if ($zip->open($filename_1, ZIPARCHIVE::CREATE)!==TRUE) {

exit("cannot open <$filename>\n");

}else{



$db =& JFactory::getDBO();

$totalzip_rfps="SELECT * FROM #__cam_rfpinfo where id=".$_GET[rfpid]; 

$db->Setquery($totalzip_rfps);

$ziprow = $db->loadObjectList();

//$ziprow = $db->loadResult();
//echo "<pre>"; print_r($ziprow);


for($w=0;$w<count($ziprow);$w++)

  {

  $rfp_id = $ziprow[$w]->id;

  $property_id = $ziprow[$w]->property_id; // main folder name

  $newrfp_id = 'RFP'.$rfp_id; //inner rfp folder

  //echo $rfp_id.' n '.$property_id.'<br />';


  /* START -- Adding pdf to zip in RFP#XXXXXX */
  
  $sql = 'SELECT C.comp_name, U.name, U.lastname, U.email, P.property_name, R.id, R.industry_id FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON R.cust_id = C.cust_id  
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id  
		LEFT JOIN  #__users as U ON R.cust_id = U.id WHERE R.id ='.$rfp_id;
		$db->Setquery($sql);
		$comp_name = $db->loadResult();

  $ziptitle= $rfp_id.'_'.$comp_name.'.pdf';
  
  
  
  /* Start --- Code for Getting Property name */

  $property_name ="SELECT property_name FROM #__cam_property where id=".$property_id;
  $db->Setquery($property_name);
  $property_name = $db->loadResult();
  
  /*$property_tax ="SELECT tax_id FROM #__cam_property where id=".$property_id;
  $db->Setquery($property_tax);
  $property_tax = $db->loadResult();
			
  $property_name = $property_name.' '.$property_tax;*/
  $property_name = str_replace(" ", "_", $property_name);

 
  $path_compliance = 'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS;
  $dest_compilance = $newrfp_id.DS;
  $srcpath = str_replace(" ", "_",$path_compliance.$dest_compilance.$ziptitle); 

  /*if(file_exists($srcpath))
  $zip->addFile($srcpath, $ziptitle);*/
  
  /* END -- Adding pdf to zip in RFP#XXXXXX */

  

  /* START --- Code for GETTING BIDDED VEDNOR INFORMATION  */ 

	$sql_zipbiiddedvendorsors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, V.company_name FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND VP.proposaltype='Submit' AND VP.Alt_bid != 'Yes' ORDER BY VP.id ";

		$db->setQuery($sql_zipbiiddedvendorsors);

		$Bid_zipvendors = $db->loadObjectList();
         //echo '<pre>';  print_r($Bid_zipvendors); exit;


	/* END --- GETTING BIDDED VEDNOR INFORMATION */

	

  	for($k=0;$k<count($Bid_zipvendors);$k++)
	  {


    $sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$Bid_zipvendors[$k]->proposedvendorid; 

	$db->setQuery($sql);

	$tax_id = $db->loadResult();
	//echo $tax_id; exit;

	$vendorname = $Bid_zipvendors[$k]->name.'_'.$Bid_zipvendors[$k]->lastname; 
	
	$vendorname = str_replace(" ", "_", $vendorname);
	
	$vendor_name = $Bid_zipvendors[$k]->name.'_'.$Bid_zipvendors[$k]->lastname.'_'.$tax_id; 

    $vendor_name = str_replace(" ", "_", $vendor_name);

  	//echo $vendor_name; exit;

  /* End --- Code for Property name */  



	  /// START -- Code for Compliance Documents  //


  $sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND  proposaltype='Submit' AND Alt_bid != 'yes'";

		$db->Setquery($sql);

		$zipvendors_list = $db->loadObjectList();

		$ZIPCOM = array();


		$path_compliance = 'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendor_name.DS;
		$dest_compilance = $newrfp_id.DS.$vendorname.DS.'Vendor Compliance'.DS;

		for($v=0; $v<count($zipvendors_list); $v++)
		{

			    //code to get OLN docs

				$sql = "SELECT OLN_upld_cert FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id=".$zipvendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);
				
				$OLN = $db->loadResultArray();
				
				//print_r($OLN);;

				for($a=0; $a<count($OLN); $a++)
				{
				$ext = substr($OLN[$a], -3); 
				$v1=$a+1; 

				/*if(file_exists($path_compliance.'OLN_'.$v1.'/'.$OLN[$a]))

				$zip->addFile($path_compliance.'OLN_'.$v1.'/'.$OLN[$a], $dest_compilance.'OLN_'.$OLN[$a]);*/

				}


				//code to get PLN docs

				$sql = "SELECT PLN_upld_cert FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id=".$zipvendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);

				$PLN = $db->loadResultArray();

				for($b=0; $b<count($PLN); $b++)
				{
				
				$ext = substr($PLN[$b], -3); 
				$v2=$b+1;
				
				//echo $path_compliance.'PLN_'.$v2.'/'.$PLN[$b]; 
				//echo '<br />'.$dest_compilance.$PLN[$b].'<br />'; exit; 

				/*if(file_exists($path_compliance.'PLN_'.$v2.'/'.$PLN[$b]))

				$zip->addFile($path_compliance.'PLN_'.$v2.'/'.$PLN[$b], $dest_compilance.'PLN_'.$PLN[$b]);*/

				}
					
				
				//code to get GLI docs

				$sql = "SELECT GLI_upld_cert FROM #__cam_vendor_liability_insurence  where GLI_status = 1 AND vendor_id=".$zipvendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);

				$GLI = $db->loadResultArray();

				for($x=0; $x<count($GLI); $x++)
				{
				
				$ext = substr($GLI[$x], -3); 
				$v3=$x+1;
				
				//echo $path_compliance.'GLI_'.$v3.'/'.$GLI[$x]; 
				//echo '<br />'.$dest_compilance.$GLI[$x]; exit;

				/*if(file_exists($path_compliance.'GLI_'.$v3.'/'.$GLI[$x]))

				$zip->addFile($path_compliance.'GLI_'.$v3.'/'.$GLI[$x], $dest_compilance.'GLI_'.$GLI[$x]);*/

				}

				
				//code to display WCI docs

				$sql = "SELECT WCI_upld_cert FROM #__cam_vendor_workers_companies_insurance  where WCI_status = 1 AND vendor_id=".$zipvendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);

				$WCI = $db->loadResultArray(); 

				for($d=0; $d<count($WCI); $d++)
				{

				$ext = substr($WCI[$d], -3); 
				$v4=$d+1;
				
				//echo $path_compliance.'WCI_'.$v4.'/'.$WCI[$d]; 
				//echo '<br />'.$dest_compilance.$WCI[$d]; exit;

				/*if(file_exists($path_compliance.'WCI_'.$v4.'/'.$WCI[$d]))

				$zip->addFile($path_compliance.'WCI_'.$v4.'/'.$WCI[$d], $dest_compilance.'WCI_'.$WCI[$d]);*/

				}

				$WCI = implode(',',$WCI);

				$ZIPCOM[$v]['WCI'] = $WCI;

					

				//W9 files

				$sql = "SELECT w9_upld_cert FROM #__cam_vendor_compliance_w9docs   where w9_status = 1 AND vendor_id=".$zipvendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);

				$W9 = $db->loadResult();
			

				if($W9 != '')
				{

				$ext2 = substr($W9, -3); 

				//echo $path_compliance.'W9/'.$W9; 
				//echo '<br />'.$dest_compilance.$W9;  exit;				
				
				/*if(file_exists($path_compliance.'W9/'.$W9))

				$zip->addFile($path_compliance.'W9/'.$W9, $dest_compilance.'W9_'.$W9);*/

				}
				
				
				
				//Warranty files

			echo $sql = "SELECT warranty_filepath FROM #__cam_vendor_proposals where rfpno =".$_GET[rfpid]." AND proposedvendorid=".$zipvendors_list[$v]->proposedvendorid;  //exit; 

				$db->Setquery($sql);

				$warranty = $db->loadResult();
				
				//echo '<pre>'; print_r($warranty); 
				
				$warfile = explode('/', $warranty);
				//echo '<pre>'; print_r($warfile); exit;
				
				$e = count($warfile);
				$warfile = $warfile[$e-1];
				//echo $e.'<br />'.$warfile; exit;
				
				$key6 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'Proposal Reports'.DS.$newrfp_id.DS;
				 if(is_dir($key6.'WarrantyFiles') == false){ @mkdir($key6.'WarrantyFiles', 0777); }
				
				$dest_compilance1 = $newrfp_id.DS.'WarrantyFiles'.DS;
				
				if($warfile!='')
				{
				
				//echo $warranty; 
				//echo '<br />'.$dest_compilance.'WARRANTY_'.$warfile.'<br />'; exit;

				if(file_exists($warranty))
				
				$zip->addFile($warranty, $dest_compilance1.'WARRANTY_'.$warfile);
				}
				
		 }		

		 
/// END -- Code for Compliance Documents  //


  /* Code for Folder Creation */

  $key3 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS;
  //echo $key3.'<br />'; 
  $vendorname = $Bid_zipvendors[$k]->name.' '.$Bid_zipvendors[$k]->lastname; 
  $vendorname = str_replace(" ", "_", $vendorname);
  if(is_dir($key3.$vendorname) == false){ @mkdir($key3.$vendorname, 0777); }
  
  $key4 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.$vendorname.DS;
  //echo $key4.'<br />'; 
  if(is_dir($key4.'ProposalAttachments') == false){ @mkdir($key4.'ProposalAttachments', 0777); }
  
 $upload_doc ="SELECT upload_doc FROM #__cam_rfpsow_uploadfiles where rfp_id =".$rfp_id." AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

  $db->Setquery($upload_doc);

  $filename = $db->loadObjectList();


 

  /************* Start --- Code for Coping the attachments ****************/

    $attcount = count($filename); 

	$docname = explode('/',$filename[$k]->upload_doc,7); 

 //echo '<pre>';   print_r($docname[6]); exit;

 	$path = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rfp'.DS.'Tasks'.DS;

	$source[] = "http://camassistant.com/live/components/com_camassistant/assets/images/rfp/Tasks/".$filename;

	$dest = JPATH_SITE.DS.'PropertyDocuments'.DS.$property_name.DS.'Proposal Reports'.DS.$newrfp_id.DS.$vendorname.DS.'Proposal Attachments'.DS;

	$dir= @dir($path);

    $dest_new =$newrfp_id.DS.$vendorname.DS.'Proposal Attachments'.DS;

	for($j=0;$j<=$attcount;$j++)

  {

	$docname = str_replace('components/com_camassistant/assets/images/rfp/Tasks/','',$filename[$j]->upload_doc);

 //$zip->addFile($filename[$j]->upload_doc, $dest_new.$docname);

     if($docname[6]=$dir->read()) 

	 {

		if($filename[$j]!='.'&&$filename[$j]!='..')

		{

		$file_ext = substr($filename[$j]->upload_doc, strrpos($filename[$j]->upload_doc, '.') + 1);


		if($file_ext == 'pdf' || $file_ext == 'PDF' || $file_ext == 'doc' || $file_ext == 'DOC' || $file_ext == 'docx' || $file_ext == 'DOCX' || $file_ext == 'jpg' || $file_ext == 'JPG' || $file_ext == 'gif' || $file_ext == 'GIF' || $file_ext == 'png' || $file_ext == 'PNG' || $file_ext == 'jpeg' || $file_ext == 'JPEG' || $file_ext == 'rtf' || $file_ext == 'RTF' || $file_ext == 'xls' || $file_ext == 'XLS' || $file_ext == 'ppt' || $file_ext == 'PPT' || $file_ext == 'xlsx' || $file_ext == 'XLSX' || $file_ext == 'pptx' || $file_ext == 'PPTX' )

				{


				} // copy files

		}  // condition for copy files

	

     }  // if dir read()

  }  // for loop


  /**************** END --- Code for Copying the attachments **************/


  

  /**************** Start --- Code for Coping the Compliance Documents ***************/

  
  $key5 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'Proposal Reports'.DS.$newrfp_id.DS.$vendorname.DS;

  if(is_dir($key5.'Vendor Compliance') == false){ @mkdir($key5.'Vendor Compliance', 0777); 

  }

	
	$path = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS;

	$dest_comp = $newrfp_id.DS.$vendorname.DS.'Vendor Compliance'.DS;

    
	//$zip->addFile($filename[$j]->upload_doc, $dest_comp.$docname);


	$dir= @dir($path.$vendor_name);

	  }

  }

  $zip->close();


header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=$filename_1");
header("Pragma: no-cache");
header("Expires: 0");
readfile("$filename_1");

unlink("$filename_1");

}

 echo ' i am at the end of the file';


?>

