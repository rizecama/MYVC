
<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require (JPATH_BASE .DS.'includes'.DS.'zipfile.inc.php');
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'pdfclass.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');


/*$pdfgen = new PDFgen();
$pdfgen->generatepdf($_REQUEST[rfpid]);

sleep(10);*/


/****************************************  START ZIP DOWNLOAD **********************************/

$zip = new zipfile();

$filename_1 = "RFP".$_REQUEST['rfpid'].".zip";

if ($zip->open($filename_1, ZIPARCHIVE::CREATE)!==TRUE) {

exit("cannot open <$filename>\n");

}else{

$db =& JFactory::getDBO();

$totalzip_rfps="SELECT * FROM #__cam_rfpinfo where id=".$_REQUEST['rfpid']; 

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
 // $ziptitle= $rfp_id.'_'.$property_name.'.pdf';
  /*$property_tax ="SELECT tax_id FROM #__cam_property where id=".$property_id;
  $db->Setquery($property_tax);
  $property_tax = $db->loadResult();
			
  $property_name = $property_name.' '.$property_tax;*/
  $property_name = str_replace(" ", "_", $property_name);

 
  $path_compliance = 'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS;
  $dest_compilance = $newrfp_id.DS;
  $srcpath = str_replace(" ", "_",$path_compliance.$dest_compilance); 
  $srcpath = $srcpath.$ziptitle; 
  $rootpath = JPATH_SITE.DS.$ziptitle;
   
  //if(file_exists($srcpath))
  //$zip->addFile($srcpath, $ziptitle);
  /* END -- Adding pdf to zip in RFP#XXXXXX */

  

  /* START --- Code for GETTING BIDDED VEDNOR INFORMATION  */ 

$sql_zipbiiddedvendorsors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, V.company_name FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND (VP.proposaltype='Submit' OR VP.proposaltype='resubmit') AND VP.Alt_bid != 'Yes' ORDER BY VP.id ";

		$db->setQuery($sql_zipbiiddedvendorsors);

		$Bid_zipvendors = $db->loadObjectList();
       // echo '<pre>';  print_r($Bid_zipvendors); exit;


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



	  


  /* Code for Folder Creation */

  $key3 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS;
  //echo $key3.'<br />'; 
  $vendorname = $Bid_zipvendors[$k]->name.' '.$Bid_zipvendors[$k]->lastname; 
  $vendorname = str_replace(" ", "_", $vendorname);
 
  
 
  
 $upload_doc ="SELECT upload_doc FROM #__cam_rfpsow_uploadfiles where rfp_id =".$rfp_id." AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

  $db->Setquery($upload_doc);

  $attfilename = $db->loadObjectList();


 

  /************* Start --- Code for Coping the attachments ****************/

    $attcount = count($attfilename); 

	$docname = explode('/',$attfilename[$k]->upload_doc,7); 

 //echo '<pre>';   print_r($docname[6]); exit;

 	$path = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rfp'.DS.'Tasks'.DS;

	$source[] = "http://camassistant.com/live/components/com_camassistant/assets/images/rfp/Tasks/".$attfilename;

	$dest = JPATH_SITE.DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.$vendorname.DS.'ProposalAttachments'.DS;

	$dir= @dir($path);

    $dest_new =$newrfp_id.DS.$vendorname.DS.'ProposalAttachments'.DS;

	for($j=0;$j<=$attcount;$j++)

  {

	$docname = str_replace('components/com_camassistant/assets/images/rfp/Tasks/','',$attfilename[$j]->upload_doc);
 	$zip->add_file($attfilename[$j]->upload_doc, $dest_new.$docname);


  }  // for loop


  /**************** END --- Code for Copying the attachments **************/


  

  /**************** Start --- Code for Coping the Compliance Documents ***************/

  
  

	
	

	  /// START -- Code for Compliance Documents  //


  $sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND  (proposaltype='Submit' OR proposaltype='resubmit') AND Alt_bid != 'yes'";

		$db->Setquery($sql);

		$zipvendors_list = $db->loadObjectList();

		
		

		$ZIPCOM = array();


		$path_compliance = 'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendor_name.DS;
		$dest_compilance = $newrfp_id.DS.$vendorname.DS.'VendorCompliance'.DS;

		

			    //code to get OLN docs

				 $sql = "SELECT OLN_upld_cert FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);
				
				$OLN = $db->loadResultArray();
				
				//print_r($OLN);;

				for($af=0; $af<count($OLN); $af++)
				{
				
				$ext = substr($OLN[$af], -3); 
				$v1=$af+1; 
              // echo $path_compliance.'OLN_'.$v1.'/'.$PLN[$af]; 
				if(file_exists($path_compliance.'OLN_'.$v1.'/'.$OLN[$af]))

				$zip->add_file($path_compliance.'OLN_'.$v1.'/'.$OLN[$af], $dest_compilance.'OLN_'.$OLN[$af]);

				}


				//code to get PLN docs

				$sql = "SELECT PLN_upld_cert FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;
                    
				$db->Setquery($sql);

				$PLN = $db->loadResultArray();
				
				echo '<br/><br/>';

				for($ag=0; $ag<count($PLN); $ag++)
				{
				
				$ext = substr($PLN[$ag], -3); 
				$v2=$ag+1;
				
				//echo $path_compliance.'PLN_'.$v2.'/'.$PLN[$ag]; 
				//echo '<br />'.$dest_compilance.$PLN[$ag].'<br />'; 

				if(file_exists($path_compliance.'PLN_'.$v2.'/'.$PLN[$ag]))

				$zip->add_file($path_compliance.'PLN_'.$v2.'/'.$PLN[$ag], $dest_compilance.'PLN_'.$PLN[$ag]);

				}
					
				
				//code to get GLI docs

				$sql = "SELECT GLI_upld_cert FROM #__cam_vendor_liability_insurence  where GLI_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;
				
				

				$db->Setquery($sql);

				$GLI = $db->loadResultArray();

				for($ah=0; $ah<count($GLI); $ah++)
				{
				
				$ext = substr($GLI[$ah], -3); 
				$v3=$ah+1;
				
				//echo ' hi i am GL'.$path_compliance.'GLI_'.$v3.'/'.$GLI[$ah].'<br/>'; 
				//echo '<br />'.$dest_compilance.$GLI[$ah]; 

				if(file_exists($path_compliance.'GLI_'.$v3.'/'.$GLI[$ah]))

				$zip->add_file($path_compliance.'GLI_'.$v3.'/'.$GLI[$ah], $dest_compilance.'GLI_'.$GLI[$ah]);

				}

				
				//code to display WCI docs

				$sql = "SELECT WCI_upld_cert FROM #__cam_vendor_workers_companies_insurance  where WCI_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$WCI = $db->loadResultArray(); 

				for($d=0; $d<count($WCI); $d++)
				{

				$ext = substr($WCI[$d], -3); 
				$v4=$d+1;
				
				//echo $path_compliance.'WCI_'.$v4.'/'.$WCI[$d]; 
				//echo '<br />'.$dest_compilance.$WCI[$d]; 

				if(file_exists($path_compliance.'WCI_'.$v4.'/'.$WCI[$d]))

				$zip->add_file($path_compliance.'WCI_'.$v4.'/'.$WCI[$d], $dest_compilance.'WCI_'.$WCI[$d]);

				}

				$WCI = implode(',',$WCI);

				$ZIPCOM[$v]['WCI'] = $WCI;

					

				//W9 files

				$sql = "SELECT w9_upld_cert FROM #__cam_vendor_compliance_w9docs   where w9_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$W9 = $db->loadResult();
			

				if($W9 != '')
				{

				$ext2 = substr($W9, -3); 

				//echo $path_compliance.'W9/'.$W9; 
				//echo '<br />'.$dest_compilance.$W9;  		
				
				if(file_exists($path_compliance.'W9/'.$W9))

				$zip->add_file($path_compliance.'W9/'.$W9, $dest_compilance.'W9_'.$W9);

				}
				
				
				
				//Warranty files

			$sql = "SELECT warranty_filepath FROM #__cam_vendor_proposals where rfpno =".$_GET[rfpid]." AND proposedvendorid=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$warranty = $db->loadResult();
				
				//echo '<pre>'; print_r($warranty); 
				
				$warfile = explode('/', $warranty);
				//echo '<pre>'; print_r($warfile); exit;
				
				$ai = count($warfile);
				$warfile = $warfile[$ai-1];
				//echo $e.'<br />'.$warfile; exit;
				
				/***************** START  --  Separate Folder for WARRANTY FILES in RFP#XXXXXX  *********************/
				
				/*$key6 = JPATH_BASE .DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS;
				 if(is_dir($key6.'WarrantyFiles') == false){ @mkdir($key6.'WarrantyFiles', 0777); }*/
				
				$dest_compilance1 = $newrfp_id.DS.'WarrantyFiles'.DS;
				
				/***************** END  --  Separate Folder for WARRANTY FILES in RFP#XXXXXX  *********************/
				
				if($warfile!='')
				{
				
				//echo $warranty; 
				//echo '<br />'.$dest_compilance.'WARRANTY_'.$warfile.'<br />'; exit;

				if(file_exists($warranty))

				//$zip->addFile($warranty, $dest_compilance.'WARRANTY_'.$warfile);
				$zip->add_file($warranty, $dest_compilance1.'WARRANTY_'.$warfile);
				}
				
		 }		

		 
/// END -- Code for Compliance Documents  //


  }
//echo 'just before zip close'; exit;
$pdfgen = new PDFgen();
$pdfgen->generatepdf($_REQUEST[rfpid]);
$path_compliance = 'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS;
$dest_compilance = $newrfp_id.DS;
$srcpath = str_replace(" ", "_",$path_compliance.$dest_compilance); 
$srcpath = $srcpath.$ziptitle; 
$rootpath = JPATH_SITE.DS.$ziptitle;
  if(file_exists($srcpath))
  {
  $zip->add_file($srcpath, $dest_compilance.$ziptitle);
  }
sleep(10);
//echo "<pre>"; print_r($zip); exit;
  $zip->close();

//exit;
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename_1");
header("Pragma: no-cache");
header("Expires: 0");
readfile("$filename_1");

unlink("$filename_1");

}

 echo ' i am at the end of the file';



/****************************************  END ZIP DOWNLOAD **********************************/

?>
