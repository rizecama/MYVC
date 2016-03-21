<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require_once(JPATH_BASE .DS.'includes'.DS.'pclzip.lib.php');
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'pdfclassforzip.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');

/*$pdfgen = new PDFgen();
$pdfgen->generatepdf($_REQUEST[rfpid]);

sleep(10);*/
ob_start();

/****************************************  START ZIP DOWNLOAD **********************************/

$zip = new ZipArchive();
//$_REQUEST['rfpid'] = '470916';
$filename_1 = "RFP".$_REQUEST['rfpid'].".zip";

if ($zip->open($filename_1, ZIPARCHIVE::CREATE)!==TRUE) {

exit("cannot open <$filename>\n");

}else{

$db =& JFactory::getDBO();

$totalzip_rfps="SELECT * FROM #__cam_rfpinfo where id=".$_REQUEST['rfpid'];

$db->Setquery($totalzip_rfps);

$ziprow = $db->loadObjectList();

//$ziprow = $db->loadResult();

//echo "<pre>"; print_r($ziprow); exit;
for($w=0;$w<count($ziprow);$w++)

  {

  $rfp_id = $ziprow[$w]->id;

  $property_id = $ziprow[$w]->property_id; // main folder name

  $newrfp_id = 'RFP'.$rfp_id; //inner rfp folder

  //echo $rfp_id.' n '.$property_id.'<br />';

$custid_sql = "SELECT cust_id FROM #__cam_rfpinfo where id=".$rfp_id;
		$db->Setquery($custid_sql);
		$firm_or_Mgr_id = $db->loadResult();
		$compid_sql = "SELECT comp_id FROM #__cam_customer_companyinfo where cust_id=".$firm_or_Mgr_id;
		$db->Setquery($compid_sql);
		$compid = $db->loadResult();
		if($compid == 0)
		$customer_id	=	$firm_or_Mgr_id;
		else
		{
			$Camfirm_sql = "SELECT cust_id FROM #__cam_camfirminfo where id=".$compid;
			$db->Setquery($Camfirm_sql);
			$Camfirm_id		=	$db->loadResult();
			$customer_id	=	$Camfirm_id;
		}
  /* START -- Adding pdf to zip in RFP#XXXXXX */

        $sql = 'SELECT  C.comp_name FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON ( R.cust_id = C.cust_id  OR  R.cust_id != C.cust_id )
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id
		LEFT JOIN  #__users as U ON (R.cust_id = U.id  OR R.cust_id != U.id)  WHERE R.id = '.$rfp_id.' AND C.cust_id='.$customer_id.' AND U.id	='.$customer_id;
		$db->Setquery($sql);
		$comp_name = $db->loadResult();
	$comp_name1=str_replace('|','_',$comp_name);
	$comp_name2=str_replace(' ','_',$comp_name1);
//echo '<pre>'; print_r($comp_name2); exit;
  $ziptitle= $rfp_id.'_'.$comp_name2.'.pdf';
  //$ziptitle= $rfp_id.'_'.$comp_name.'.pdf';


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
//exit;
  //if(file_exists($srcpath))
  //$zip->addFile($srcpath, $ziptitle);
  /* END -- Adding pdf to zip in RFP#XXXXXX */



  /* START --- Code for GETTING BIDDED VEDNOR INFORMATION  */

$sql_zipbiiddedvendorsors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, V.company_name FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND VP.Alt_bid != 'Yes' AND VP.proposaltype!='Draft' AND VP.proposaltype!='ITB'  ORDER BY VP.id ";

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
   //$vendorname = $Bid_zipvendors[$k]->name.' '.$Bid_zipvendors[$k]->lastname;
  //Updated by sateesh on 13/7/2012
    $sql_com = "SELECT company_name FROM #__cam_vendor_company WHERE user_id=".$Bid_zipvendors[$k]->proposedvendorid;
	$db->setQuery($sql_com);
	$vendorname = $db->loadResult();
	//Completed
	//$vendorname = str_replace(" ", "_", $vendorname);
	$vendorname = str_replace('\\',' ',$vendorname);
  	$vendorname = str_replace(" ", "_", $vendorname);


 // Upload ProjectAttachments by sateesh on  30th Sep 2014
  $property_details="SELECT u.property_name,u.tax_id,u.property_manager_id,v.jobtype FROM #__cam_property as u, #__cam_rfpinfo as v where u.id='".$property_id."' and u.id=v.property_id and v.id=".$rfp_id." ";
  $db->Setquery($property_details);
  $propertydata = $db->loadObject();
  
  $dest_rfp = JPATH_SITE.DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.'ProjectAttachments'.DS;
  
  if($propertydata->jobtype != 'yes') {
  $upload_doc_rfp ="SELECT taskuploads FROM #__cam_rfpsow_linetask where rfp_id =".$rfp_id;
  $db->Setquery($upload_doc_rfp);
  $allattachedrfpdocs = $db->loadObjectList();
  
  foreach($allattachedrfpdocs as $linetaks){ 
			if($linetaks->taskuploads){
				$path=JURI::base();
				$link= $path.$linetaks->taskuploads;
				$default = 'components/com_camassistant/doc/';
				$uploaded_file= str_replace(' ','',$linetaks->taskuploads);
				$p_name= str_replace(' ','_',$propertydata->property_name);
				$linetaks->taskuploads = str_replace(' ,','',$linetaks->taskuploads);
				$linetaks->taskuploads = str_replace(',,',',',$linetaks->taskuploads);
				$linetaks->taskuploads = str_replace(' ','',$linetaks->taskuploads);
				$uploads= explode(',',$linetaks->taskuploads );   
					if(count($uploads)>0 && count($linetaks->taskuploads)>0 ){ 
					 
						for ($l=0;$l<count($uploads);$l++){  ?> 
						<?php  $uploads1=explode('/',$uploads[$l]); 
					
						if($uploads[$l] && $uploads[$l]!=' '){  
						
						$uploads23=explode('/',$uploads[$l]);
						if($uploads23[0]=='components' && $uploads23[1]=='com_camassistant' && $uploads23[2]=='doc' ){
						$file_link = str_replace(' ','',$uploads[$l]);
						} else if($uploads23[0]=='components' && $uploads23[1]=='com_camassistant' && $uploads23[2]=='assets'){
						$file_link = str_replace(' ','',$uploads[$l]);
						} else {
						$file_link = $default.$p_name.'_'.$propertydata->tax_id.'//'.str_replace(' ','',$uploads[$l]);
						}
						$file_link= str_replace('// ','/',$file_link);
						$upcount=count($uploads1); 
						$total_path = 'components/com_camassistant/doc/'.$propertydata->property_name.'_'.$propertydata->tax_id.'/'.$uploads1[$upcount-1] ;
						$dest_rfp =$newrfp_id.DS.'ProjectAttachments'.DS;
						$zip->addFile($total_path, $dest_rfp.$uploads1[$upcount-1]);
						}
						
						}
						
					}
			}
  	}
  }
  else{
 	  $basicfiles ="SELECT filename FROM #__cam_basicrequest_files where filename!='' and rfpid =".$rfp_id;
	  $db->Setquery($basicfiles);
	  $basefiles = $db->loadObjectList();
  		for( $b=0; $b<count($basefiles); $b++ ){
			$total_path = 'components/com_camassistant/doc/'.$propertydata->property_name.'_'.$propertydata->tax_id.'/'.$basefiles[$b]->filename ;
			$dest_rfp =$newrfp_id.DS.'ProjectAttachments'.DS;
			$zip->addFile($total_path, $dest_rfp.$basefiles[$b]->filename);	
		}
  }

  
  //Completed
  
  $upload_doc ="SELECT upload_doc FROM #__cam_rfpsow_uploadfiles where rfp_id =".$rfp_id." AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

  $db->Setquery($upload_doc);

  $attfilename = $db->loadObjectList();

//echo '<pre>'; print_r($attfilename);


  /************* Start --- Code for Coping the attachments ****************/

    $attcount = count($attfilename);

	//$docname = explode('/',$attfilename[$k]->upload_doc);
	//$cnt = count($docname);

 //echo '<pre>';   print_r($attfilename[$k]->upload_doc); exit;

 	$path = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rfp'.DS.'Tasks'.DS;
	$source[] = "http://myvendorcenter.com/live/".$attfilename[$k]->upload_doc;
	//$source[] = "http://camassistant.com/live/components/com_camassistant/assets/images/rfp/Tasks/".$attfilename;

	$dest = JPATH_SITE.DS.'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS.$newrfp_id.DS.$vendorname.DS.'ProposalAttachments'.DS;

	$dir= @dir($path);

     $dest_new =$newrfp_id.DS.$vendorname.DS.'ProposalAttachments'.DS;

	for($j=0;$j<=$attcount;$j++)

  {
//echo '<pre>'; print_r($attfilename[$j]);
     $docname = explode('/',$attfilename[$j]->upload_doc);
	 $cnt = count($docname);
	$attfilename[$j]->upload_doc1 = str_replace('http://myvendorcenter.com/live/','',$attfilename[$j]->upload_doc);
	$attfilename[$j]->upload_doc2 = str_replace('http://myvendorcenter.com/live/','',$attfilename[$j]->upload_doc1);
	$docname = $docname[$cnt-1];
	//print_r($docname);
	$attfilename[$j]->upload_doc.'<br>';
	$dest_new.$docname;
	//echo '<pre>'; print_r($attfilename[$j]->upload_doc);
 	 $zip->addFile($attfilename[$j]->upload_doc2, $dest_new.$docname);


  }  // for loop
//exit;

  /**************** END --- Code for Copying the attachments **************/




  /**************** Start --- Code for Coping the Compliance Documents ***************/







	  /// START -- Code for Compliance Documents  //


  $sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND Alt_bid != 'yes'";

		$db->Setquery($sql);

		$zipvendors_list = $db->loadObjectList();



		$ZIPCOM = array();


		  $path_compliance = 'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'vendorcompliances'.DS.$vendor_name.DS;

		  $dest_compilance = $newrfp_id.DS.$vendorname.DS.'VendorCompliance'.DS;



			    //code to get OLN docs

				  $sql = "SELECT OLN_upld_cert FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$OLN = $db->loadResultArray();




				for($af=0; $af<count($OLN); $af++)
				{

				$ext = substr($OLN[$af], -3);
				$v1=$af+1;
              $path_compliance.'OLN_'.$v1.'/'.$OLN[$af].'<br>';
			 // echo  $dest_compilance.'OLN_'.$OLN[$af].'<br />';
				if(file_exists($path_compliance.'OLN_'.$v1.'/'.$OLN[$af]))

				$zip->addFile($path_compliance.'OLN_'.$v1.'/'.$OLN[$af], $dest_compilance.'OLN_'.$OLN[$af]);

				}


				//code to get PLN docs

				$sql = "SELECT PLN_upld_cert FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$PLN = $db->loadResultArray();


				for($ag=0; $ag<count($PLN); $ag++)
				{

				$ext = substr($PLN[$ag], -3);
				$v2=$ag+1;

				//echo $path_compliance.'PLN_'.$v2.'/'.$PLN[$ag];
				//echo '<br />'.$dest_compilance.'PLN_'.$PLN[$ag].'<br />';

				if(file_exists($path_compliance.'PLN_'.$v2.'/'.$PLN[$ag]))

				$zip->addFile($path_compliance.'PLN_'.$v2.'/'.$PLN[$ag], $dest_compilance.'PLN_'.$PLN[$ag]);

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
				//echo $path_compliance.'GLI_'.$v3.'/'.$GLI[$ah];
				//echo '<br />'.$dest_compilance.'GLI_'.$GLI[$ah].'<br />';
				if(file_exists($path_compliance.'GLI_'.$v3.'/'.$GLI[$ah]))

				$zip->addFile($path_compliance.'GLI_'.$v3.'/'.$GLI[$ah], $dest_compilance.'GLI_'.$GLI[$ah]);

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
				//echo '<br />'.$dest_compilance.'WCI_'.$WCI[$d].'<br />';

				if(file_exists($path_compliance.'WCI_'.$v4.'/'.$WCI[$d]))

				$zip->addFile($path_compliance.'WCI_'.$v4.'/'.$WCI[$d], $dest_compilance.'WCI_'.$WCI[$d]);

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
				//echo '<br />'.$dest_compilance.'W9_'.$W9.'<br />';

				if(file_exists($path_compliance.'W9/'.$W9))

				$zip->addFile($path_compliance.'W9/'.$W9, $dest_compilance.'W9_'.$W9);

				}



				//Warranty files

			$sql = "SELECT warranty_filepath FROM #__cam_vendor_proposals where rfpno =".$_GET[rfpid]." AND proposedvendorid=".$Bid_zipvendors[$k]->proposedvendorid;

				$db->Setquery($sql);

				$warranty = $db->loadResult();



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
				//echo '<br />'.$dest_compilance.'WARRANTY_'.$warfile.'<br />';

				if(file_exists($warranty))

				//$zip->addFile($warranty, $dest_compilance.'WARRANTY_'.$warfile);
				$zip->addFile($warranty, $dest_compilance1.'WARRANTY_'.$warfile);
				}

		 }


/// END -- Code for Compliance Documents  //


  }

//echo 'just before zip close'; exit;
$pdfgen = new PDFgen();
$pdfgen->generatepdf($_REQUEST['rfpid']);

$path_compliance = 'PropertyDocuments'.DS.$property_name.DS.'ProposalReports'.DS;
$dest_compilance = $newrfp_id.DS;
$srcpath = str_replace(" ", "_",$path_compliance.$dest_compilance);
 $srcpath = $srcpath.$ziptitle;
 //echo '<pre>'; print_r($srcpath); exit;
 //echo "</br>"; echo $dest_compilance.$ziptitle; exit;
//echo $srcpath.'<br>'; echo $dest_compilance.'<br>'; echo $ziptitle; exit;
//$rootpath = JPATH_SITE.DS.$ziptitle;
  if(file_exists($srcpath))
  {
  $zip->addFile($srcpath, $dest_compilance.$ziptitle);
  }
sleep(15);
//echo "<pre>"; print_r($zip); exit;
  $zip->close();

//exit;
/*header("Cache-Control: public");
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
//header("Content-Description: File Transfer");
//header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=\"$filename_1\"");
//header("Content-Transfer-Encoding: binary");
header("Content-length: " . filesize($filename_1)); */

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename_1");
header("Pragma: no-cache");
header("Expires: 0");

readfile("$filename_1");

unlink("$filename_1");
ob_end_flush();
}

 echo ' i am at the end of the file';



/****************************************  END ZIP DOWNLOAD **********************************/

?>