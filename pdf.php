#!/usr/bin/php
<?php
set_time_limit(0);
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cron','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
	require_once('libraries/tcpdf/config/lang/eng.php');
	require_once('libraries/tcpdf/tcpdf.php');
	ini_set('zlib.output_compression','Off');

class MYPDF extends TCPDF {
	// Page footer
	public function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Page number
		$this->SetFontSize(8);
		$this->Cell(207, 0, 'Proposal Report Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, 2, 'C');
		$this->SetFontSize(7);
		$this->Cell(0, 5, 'Copyright 2011 CAMassistant.com', 0, 0, 'C');
	}
	
	public function Header() {
		// Position at 1.5 cm from top
		$this->SetY(-15);
	}
}

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');

/* Create a database object */
$db =& JFactory::getDBO();
$total_rfps="SELECT * FROM #__cam_rfpinfo where rfp_pdf=0";
//$total_rfps="SELECT * FROM #__cam_rfpinfo where rfp_type = 'closed'";
//$total_rfps="SELECT * FROM #__cam_rfpinfo";
$db->Setquery($total_rfps);
$row = $db->loadObjectList();
//echo "<pre>"; print_r($row); exit;
if($row){
for($i=0;$i<=count($row);$i++)
  {
/*  $result[0]->user_id;
  $closetime =  $row[$i]->proposalDueDate . " " . $row[$i]->proposalDueTime;
  // print_r( $closetime); echo "<br><br>";
  $date= str_replace('PM','',$closetime); 
  $date1= str_replace('AM','',$date); 
  $date2= explode('-',$date1);
  $date= $date2[1];
  $month= $date2[0];
  $year1= $date2[2];
  $year2= explode(' ',$year1);
  $year = $year2[0];
  $time = $year2[1];
  $date3= $year.'-'.$month.'-'.$date.' '.$time;
  $closeddate= strtotime($date3);
  $today = date('Y-m-d h:i');
  $todatdate= strtotime($today);
//echo $row[$i]->id; exit;
	if($todatdate >= $closeddate){
 	$update_rfp = "UPDATE jos_cam_rfpinfo SET rfp_type = 'closed',rfp_pdf=1 WHERE id= ".$row[$i]->id."";
	$db->setQuery($update_rfp);
	$res=$db->query();
	if($res){
*/	//////GENERATING PD FILE
	/////1. GETTING RFP DETAILS////
	$rfp_id = $row[$i]->id;
	$sql = 'SELECT U.name, U.lastname, U.email, U.extension, U.phone, C.comp_name, C.comp_city, C.comp_state, comp_zip,  C.comp_phno, C.comp_extnno, C.comp_alt_phno, C.comp_alt_extnno, C.comp_website, C.mailaddress, C.comp_logopath, C.comp_id, C.cust_id, P.street, P.property_name, P.state, P.city, P.zip, R.id, R.industry_id, R.startDate, R.endDate, R.projectName,R.work_perform, R.frequency, R.proposalDueDate, R.proposalDueTime FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON R.cust_id = C.cust_id  
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id  
		LEFT JOIN  #__users as U ON R.cust_id = U.id WHERE R.id = '.$rfp_id;
		$db->Setquery($sql);
		$RFP_details = $db->loadObjectList();
	//	echo "<pre>"; print_r($RFP_details); exit;
	//////GENERATING PD FILE COMPLETED
	
	/////2. GETTING BID AMOUNT DETAILS////
	/* AND (proposaltype = 'Submit' or proposaltype = 'resubmit') added to the end of this query by anil_27-09-2011 */
		$db = & JFactory::getDBO();
		$Bid_sql = "SELECT  (select count(*)  from #__cam_vendor_proposals where rfpno=".$rfp_id." AND proposaltype = 'Submit') as Submitted, (select count(*)  from #__cam_vendor_proposals where rfpno=".$rfp_id." AND proposaltype = 'Reject') as Rejected, (SELECT SUM(proposal_total_price)/count(id) FROM #__cam_vendor_proposals where rfpno=".$rfp_id." AND (proposaltype = 'Submit' or proposaltype = 'resubmit')) as Average_Bid, MAX(proposal_total_price) as Max_Bid, MIN(proposal_total_price) as Min_Bid FROM #__cam_vendor_proposals  WHERE rfpno = ".$rfp_id." AND (proposaltype = 'Submit' or proposaltype = 'resubmit')";
		$db->setQuery($Bid_sql);
		$Bid_info = $db->loadObjectList();
	/////2. GETTING BID AMOUNT DETAILS////
	
	/////3. GETTING BIDDED VEDNOR INFORMATION////
	$sql_biiddedvendors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, U.extension, U.phone, U.cellphone,V.company_name,V.company_address,V.city,V.state,V.zipcode,V.image, V.in_house_vendor,V.company_phone,V.phone_ext,V.alt_phone,V.alt_phone_ext,V.established_year FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND VP.proposaltype='Submit' AND VP.Alt_bid != 'Yes' ORDER BY VP.id ";
		$db->setQuery($sql_biiddedvendors);
		$Bid_vendors = $db->loadObjectList();
		
	/////3. GETTING BIDDED VEDNOR INFORMATION COMPLETED////
	
	/////4. GETTING ALT BIDDED VEDNOR INFORMATION////
			$sql_altvendors = "SELECT  VP.id,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, U.extension, U.phone, U.cellphone,V.company_name,V.company_address,V.city,V.state,V.zipcode,V.image, V.in_house_vendor,V.company_phone,V.phone_ext,V.alt_phone,V.alt_phone_ext,V.established_year FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND VP.proposaltype='Submit' AND VP.Alt_bid = 'yes' ORDER BY VP.id ";
		$db->setQuery($sql_altvendors);
		$res_altvendors = $db->loadObjectList();
		
	/////4. GETTING ALT BIDDED VEDNOR INFORMATION////
	
	/////5. FOR SECOND PAGE IN PDF////
			$sql_page = 'SELECT task_id,rfp_id,linetaskname,is_req_taskvendors FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql_page);
		$TASK_detailsn = $db->loadObjectList();
		// "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($TASK_detailsn); $p++) //to get task price
		  {
		   $nprice_sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="task" AND LP.item_id = '.$TASK_detailsn[$p]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"'; 
		  $db->Setquery($nprice_sql);
		  $price = $db->loadObjectList();
		  $TASK_detailsn[$p]->task_price = $price;
		  } 
		   for($p=0; $p<count($TASK_detailsn); $p++) //to get task price
		  {
		   $pricen2_sql = 'SELECT LP.id,LP.task_id,LP.upload_doc,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_uploadfiles as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.spl_req ="No" AND LP.task_id = '.$TASK_detailsn[$p]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"'; 
		  $db->Setquery($pricen2_sql);
		  $vendor_uploadsn = $db->loadObjectList();
			 for($i=0; $i<count($vendor_uploadsn); $i++)
			{
				 $arr = explode('/',$vendor_uploadsn[$i]->upload_doc);
				 $cnt = count($arr);
				 $vendor_uploadsn[$i]->title = $arr[$cnt-1];
				 $link = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_VENDOR&filename='.$vendor_uploadsn[$i]->title.'">'.$vendor_uploadsn[$i]->title.'</a>';
				 $vendor_uploadsn[$i]->title = $link;
			} 
		  $TASK_detailsn[$p]->vendor_uploadsn = $vendor_uploadsn;
		  
		  } 
			/////5. FOR SECOND PAGE IN PDF COMPLETED////
			
	//////6. FOR ALT TASK SUMMARY////
		$sql = 'SELECT task_id,rfp_id,linetaskname,is_req_taskvendors FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$TASK_details = $db->loadObjectList();
		
		// "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($TASK_details); $p++) //to get task price
		  {
		   $price_sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="task" AND LP.item_id = '.$TASK_details[$p]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid = "yes" AND VP.Alt_bid = "yes"'; 
		  $db->Setquery($price_sql);
		  $price = $db->loadObjectList();
		  $TASK_details[$p]->task_price = $price;
		  } 
		 
		   for($p=0; $p<count($TASK_details); $p++) //to get task price
		  {
		    $price_sql = 'SELECT LP.id,LP.task_id,LP.upload_doc,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_uploadfiles as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.spl_req ="No" AND LP.task_id = '.$TASK_details[$p]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"'; 
		
		  $db->Setquery($price_sql);
		  $vendor_uploads = $db->loadObjectList();
		  
			 for($i=0; $i<count($vendor_uploads); $i++)
			{
				 $arr = explode('/',$vendor_uploads[$i]->upload_doc);
				 $cnt = count($arr);
				 $vendor_uploads[$i]->title = $arr[$cnt-1];
				 $link = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_VENDOR&filename='.$vendor_uploads[$i]->title.'">'.$vendor_uploads[$i]->title.'</a>';
				 $vendor_uploads[$i]->title = $link;
			} 
		  $TASK_details[$p]->vendor_uploads = $vendor_uploads;
		  } 
 
		  ////6.FOR ALT TASK SUMMARY COMPLETED/////	
		  
	///7.GET ALT NOTES SUMMARY////
			$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$NOTES_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($NOTES_details); $p++) //to get task price
		  {
		   $price_sql = 'SELECT VN.add_notes,VN.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addnotes as VN ON VP.proposedvendorid = VN.vendor_id  WHERE VN.spl_req="No" AND VN.task_id = '.$NOTES_details[$p]->task_id.' AND VN.rfp_id=VP.rfpno AND VN.Alt_bid = "yes" AND VP.Alt_bid = "yes"'  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $NOTES_details[$p]->task_notes = $notes;
		  } 
	///7.GET ALT NOTES SUMMARY COMPLETED////
	  
	////8.GET DOCS SUMMARY//////
			$sql = 'SELECT * FROM #__cam_rfpsow_docs WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$DOCS_details = $db->loadObjectList();
		 
			for($i=0; $i<count($DOCS_details); $i++)
			{
			 $arr = explode('/',$DOCS_details[$i]->doc_path);
			 $cnt = count($arr);
			 $DOCS_details[$i]->title = $arr[$cnt-1];
			 $sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="doc" AND LP.item_id = '.$DOCS_details[$i]->doc_id .' AND LP.rfp_id=VP.rfpno  AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"'; 
			 //$sql = 'SELECT item_price FROM #__cam_rfpsow_docs_lineitems_prices WHERE rfp_id = '.$rfp_id.' AND item_type="doc" AND item_id='.$DOCS_details[$i]->doc_id;
			$db->Setquery($sql);
			$price = $db->loadObjectList();
			$DOCS_details[$i]->doc_price = $price;
			}
    	////8.GET DOCS SUMMARY COMPLETED//////
		
		////9.GET NOTES SUMMARY //////
		$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$NOTES_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($NOTES_details); $p++) //to get task price
		  {
		   $price_sql = 'SELECT VN.add_notes,VN.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addnotes as VN ON VP.proposedvendorid = VN.vendor_id  WHERE VN.spl_req="No" AND VN.task_id = '.$NOTES_details[$p]->task_id.' AND VN.rfp_id=VP.rfpno AND VN.Alt_bid != "yes" AND VP.Alt_bid != "yes"'  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $NOTES_details[$p]->task_notes = $notes;
		  } 
		////9.GET NOTES SUMMARY COMPLETED//////

		////10.GET EXCEPTION SUMMARY //////
		$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$EXCEPTION_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($EXCEPTION_details); $p++) //to get task price
		  {
		  $price_sql = 'SELECT VE.add_exception,VE.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addexception as VE ON VP.proposedvendorid = VE.vendor_id  WHERE VE.spl_req="No" AND VE.task_id = '.$EXCEPTION_details[$p]->task_id.' AND VE.rfp_id=VP.rfpno AND VE.Alt_bid != "yes" '  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $EXCEPTION_details[$p]->task_exception = $notes;
		  } 
	////10.GET EXCEPTION SUMMARY COMPLETED//////
	
		////11.GET ALT EXCEPTION SUMMARY COMPLETED//////	
		$sql_alte = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql_alte);
		$ALTEXCEPTION_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($p=0; $p<count($ALTEXCEPTION_details); $p++) //to get task price
		  {
		  $price_sql = 'SELECT VE.add_exception,VE.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addexception as VE ON VP.proposedvendorid = VE.vendor_id  WHERE VE.spl_req="No" AND VE.task_id = '.$ALTEXCEPTION_details[$p]->task_id.' AND VE.rfp_id=VP.rfpno AND VE.Alt_bid = "yes" '  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $ALTEXCEPTION_details[$p]->task_exception = $notes;
		  } 
			////11.GET ALT EXCEPTION SUMMARY COMPLETED//////	
			
		///12. FOR FOURTH PAGE IN PDF COMPLETED////
	 	$sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND  proposaltype='Submit' AND Alt_bid != 'yes'";
		$db->Setquery($sql);
		$vendor_ids = $db->loadObjectList();
		///12. FOR FOURTH PAGE IN PDF COMPLETED////
	
	///13. RFPCREATOR TASKS////
			$sql = 'SELECT task_id,rfp_id,task_desc,taskuploads  FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$tasks_list = $db->loadObjectList();
		for($i=0; $i<count($tasks_list); $i++)
		{
			 $arr = explode('/',$tasks_list[$i]->taskuploads);
			 $cnt = count($arr);
			 $tasks_list[$i]->title = $arr[$cnt-1];
			 $link = '<a style="color:#21314d; text-decoration:none" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_CAM&filename='.$tasks_list[$i]->title.'">'.$tasks_list[$i]->title.'</a>';
			 $tasks_list[$i]->title = $link;
		} 
	///13. RFPCREATOR TASKS COMPLETED////
	
	///14. FOR SPECIAL REQUIREMNTS CATEGORY///
	  $sql = " SELECT * FROM jos_cam_rfpreq_categories where req_parentid=0";
	  $db->Setquery($sql);
	  $categories = $db->loadObjectList();
	///14. FOR SPECIAL REQUIREMNTS CATEGORY COMPLETED ///

	///15. FOR SPECIAL REQUIREMNTS ///
			  $sql_specialreqs = " SELECT b.req_parentid as main_id, a.req_title as main_title FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_parentid 	 and b.rfp_id = ".$rfp_id."   group by b.req_parentid order by b.req_parentid "; 
		  $db->Setquery($sql_specialreqs);
		  $main_cat = $db->loadObjectList($main_cat);
		  $SPLRequirements_details['main'] = $main_cat;
		 $sql_subcat = " SELECT b.req_parentid as main_id, b.req_subparentid as sub_id, a.req_title as sub_title FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_subparentid and b.rfp_id = ".$rfp_id." AND  req_subparentid != 0  group by b.req_subparentid order by b.req_parentid ";
		  $db->Setquery($sql_subcat);
		  $sub_cat = $db->loadObjectList();
		  $SPLRequirements_details['sub'] = $sub_cat;
		  $sql_child = " SELECT b.req_parentid as main_id, b.req_subparentid as sub_id, b.req_id as child_id, a.req_title as child_title, b.price FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_id and b.rfp_id = ".$rfp_id." AND b.req_parentid != 0 AND req_subparentid != 0  order by b.req_parentid ";
		  $db->Setquery($sql_child);
		  $child = $db->loadObjectList();
		   $SPLRequirements_details['child'] = $child;
		   
	///15. FOR SPECIAL REQUIREMNTS COMPLETED ///
	
	///16. FOR SPECIAL REQUIREMNTS REVIEW ///
			$sql_rev = " SELECT b.req_parentid as main_id, a.req_title as main_title FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_parentid 	 and b.rfp_id = ".$rfp_id."   group by b.req_parentid order by b.req_parentid ";
		$db->Setquery($sql_rev);
		$main_catrev = $db->loadObjectList();
		$SPLRequirements_revdetails['main'] = $main_catrev;
		$sql = " SELECT DISTINCT b.req_parentid as main_id,b.price, b.req_subparentid as sub_id, a.req_title as sub_title FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_subparentid and b.rfp_id = ".$rfp_id." AND  b.req_subparentid != 0  order by b.req_parentid ";
		$db->Setquery($sql);
		$sub_cat = $db->loadObjectList();
		$SPLRequirements_revdetails['sub'] = $sub_cat;
		$sql_rev1 = " SELECT b.req_parentid as main_id,b.price, b.req_subparentid as sub_id, b.req_id as child_id, a.req_title as child_title FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_id and b.rfp_id = ".$rfp_id." AND b.req_parentid != 0 AND req_subparentid != 0  order by b.req_parentid ";
		$db->Setquery($sql_rev1);
		$SPLRequirements_revdetails['child'] = $db->loadObjectList();
		
	///16. FOR SPECIAL REQUIREMNTS REVIEW COMPLETED ///
	
	///17. FO COM DOCS///
		$sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND  proposaltype='Submit' AND Alt_bid != 'yes'";
		$db->Setquery($sql);
		$vendors_list = $db->loadObjectList();
		$COM = array();
		for($v=0; $v<count($vendors_list); $v++)
		{
			    //code to get OLN docs
				$sql = "SELECT OLN_upld_cert FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$OLN = $db->loadResultArray();
				for($i=0; $i<count($OLN); $i++)
				{
				$ext = substr($OLN[$i], -3); 
				$OLN[$i] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&filename='.$OLN[$i].'">'.$OLN[$i].'</a>';
				}
				$OLN = implode(',',$OLN);
				$COM[$v]['OLN'] = $OLN;
				
				//code to get PLN docs
				$sql = "SELECT PLN_upld_cert FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$PLN = $db->loadResultArray();
				for($i=0; $i<count($PLN); $i++)
				{
				$ext = substr($PLN[$i], -3); 
				$PLN[$i] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&filename='.$PLN[$i].'">'.$PLN[$i].'</a>';
				}
				$PLN = implode(',',$PLN);
				$COM[$v]['PLN'] = $PLN;
				
				//code to get GLI docs
				$sql = "SELECT GLI_upld_cert FROM #__cam_vendor_liability_insurence  where GLI_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$GLI = $db->loadResultArray();
				for($i=0; $i<count($GLI); $i++)
				{
				$ext = substr($GLI[$i], -3); 
				$GLI[$i] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&filename='.$GLI[$i].'">'.$GLI[$i].'</a>';
				}
				$GLI = implode(',',$GLI);
				$COM[$v]['GLI'] = $GLI;
				
				$sql = "SELECT vendor_id  FROM #__cam_vendor_compliance_w9docs WHERE w9_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$vendor_id = $db->loadResultArray();
				
				//code to display WCI docs
				$sql = "SELECT WCI_upld_cert FROM #__cam_vendor_workers_companies_insurance  where WCI_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$WCI = $db->loadResultArray();
				for($i=0; $i<count($WCI); $i++)
				{
				$ext = substr($WCI[$i], -3); 
				$WCI[$i] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&filename='.$WCI[$i].'">'.$WCI[$i].'</a>';
				}
				$WCI = implode(',',$WCI);
				$COM[$v]['WCI'] = $WCI;
					
				//W9 files
				$sql = "SELECT w9_upld_cert FROM #__cam_vendor_compliance_w9docs   where w9_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$W9 = $db->loadResult();
				if($W9 != '')
				{
				$ext2 = substr($W9, -3); 
				$W9 = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&filename='.$W9.'">'.$W9.'</a>';
				$COM[$v]['W9'] = $W9;
				}
		 }		
		 sort($COM);
		
		/////CODE FOR GENERATING PDF FILE	////
		
		
ob_end_clean();		
	
	
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	//$pdf->SetDrawColor(204, 204, 204);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	//set some language-dependent strings
	$pdf->setLanguageArray($l); 
	
	$pdf->SetFont('dejavusans', '', 10);// set font
	$pdf->AddPage(); // add a page
	// Your custom code here
	JHTML::_('behavior.modal');
	$from = JRequest::getVar('from','');
	$document =& JFactory::getDocument();
	$document->addStyleSheet('templates/camassistant_left/css/style.css');
	$RFP_info = $RFP_details[0];
	//echo "<pre>"; print_r($RFP_info); echo $RFP_info->id; 
	$RFP_info->id = sprintf('%06d', $RFP_info->id);
	//echo '<pre>'; print_r($RFP_info); exit;	
	$BID_info = $Bid_info[0];
	//echo '<pre>'; print_r($BID_info); exit;
	$BID_Vendors_info = $Bid_vendors;


	//calculation to no of pages iteration in pdf
	$remainder = count($BID_Vendors_info)%4;
	$quotient = intval(count($BID_Vendors_info)/4);
	$total = count($BID_Vendors_info);
	
	if($remainder == 0)
	$loop_iterator = $quotient;
	else
	$loop_iterator = $quotient+1;
	
	//code to max, min bid values of propsal
	$Max_bid = number_format($BID_info->Max_Bid, 2, '.', ',');
	$Min_bid = number_format($BID_info->Min_Bid, 2, '.', ',');
	$Avg_bid = number_format($BID_info->Average_Bid, 2, '.', ',');
	$com_phone = explode('-',$RFP_info->comp_phno) ;
	
	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set font
	$pdf->SetFont('dejavusans', '', 12);
	//Image Quality
	$pdf->setJPEGQuality(200);
	// add a page
	$pdf->AddPage();
	$pat = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS;
	//$pat = 'http://192.168.1.46/camassistant_new'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS;
	$x = 15;
	$y = 35;
	$w = 30;
	$h = 30;
	//$tem = JPATH_SITE.DS.'templates'.DS.'camassistant_left'.DS.'images'.DS;
	//$pdf->Image($tem."mc_headicons.jpg", 186, 10, 20, 4, '', '', '', true, 150);
	//$pdf->Image(imagepath, x, y, width, height, 'type', 'link', 'align', resize=true, dpi=150);
	//echo '<pre>'; print_r($RFP_info); exit;
	
	
	$db = JFactory::getDBO();
	$state="SELECT state_name FROM #__state where id='".$RFP_info->comp_state."'";
	$db->Setquery($state);
	$state_name = $db->loadResult();
	
	$ind_solicited ="SELECT industry_name FROM #__cam_industries where id='".$RFP_info->industry_id."'";
	$db->Setquery($ind_solicited);
	$ind_solicited = $db->loadResult();

	$altproposals_submitted="SELECT count(*) FROM #__cam_vendor_proposals where rfpno='".$RFP_info->id."' AND proposaltype='submit' AND Alt_bid='yes'";
	$db->Setquery($altproposals_submitted);
	$altproposals_submitted = $db->loadResult();
	
	$RFP_info->work_perform = explode(',',$RFP_info->work_perform,2) ;
	$RFP_info->work_perform = $RFP_info->work_perform[0].'<br />'.$RFP_info->work_perform[1];

	if(count($BID_Vendors_info)>0)
	{
		for($loop_start=0, $loop_stop=1; $loop_start<$loop_iterator; $loop_start++,$loop_stop++)
    {
		if($RFP_info->comp_logopath == ''){
		
				//Start -- if manager logo is empty then disply mgntfirm logo by anil_17-08-2011
				if($RFP_info->comp_id != '0'){
 				$db = JFactory::getDBO();
				$compid_sql = "SELECT comp_id FROM #__cam_customer_companyinfo where cust_id=".$RFP_info->cust_id;
				$db->Setquery($compid_sql);
				$compid = $db->loadResult(); 
				$custid_sql = "SELECT cust_id FROM #__cam_camfirminfo where id=".$compid;
				$db->Setquery($custid_sql);
				$custid = $db->loadResult(); 
				$logopath_sql = "SELECT comp_logopath FROM #__cam_customer_companyinfo where cust_id=".$custid;
				$db->Setquery($logopath_sql);
				$RFP_info->comp_logopath = $db->loadResult();
				}
				if($RFP_info->comp_logopath == ''){
				$RFP_info->comp_logopath = 'noimage2.gif';
				}
				//End -- if manager logo is empty then disply mgntfirm logo by anil_17-08-2011
				
		}
		
		// Start checking whether the file exists in the path or not anil_16-08-2011
		$filename = $pat.'properymanager/'.$RFP_info->comp_logopath;
		/* anil_27-08-2011 */
		$apath=getimagesize($filename);
		$height_orig=$apath[1];
		$width_orig=$apath[0];
		$aspect_ratio = (float) $height_orig / $width_orig;
		
		if($width_orig <= $height_orig ){
		if($width_orig <= '31'){
		$aspect_ratio = (float) $height_orig / $width_orig;
		$width = $width_orig;
		$height = $height = round($width * $aspect_ratio);
		$height_user = $height;
		} 
		else {
				$aspect_ratio = (float) $width_orig / $height_orig;
				$height = 18;
				$width = round($height * $aspect_ratio);
				$height_user = $height;
				}
		}
		else if($height_orig <= $width_orig ){
		if( height_orig <= '18'){
		$aspect_ratio = (float) $width_orig / $height_orig;
		$width = round($height * $aspect_ratio);
		$height = $height_orig;
		$height_user = $height_orig;
		} 
		else {
				//echo "anil"; exit;
				$aspect_ratio = (float) $height_orig / $width_orig;
				$width = 31;
				$height = round($width * $aspect_ratio);
				$height_user = $height;
				} 
		}
		//$width2 = $width*3;
		/* anil_27-08-2011 */		
if (!file_exists($filename)) {
   $RFP_info->comp_logopath = 'noimage2.gif';
   } // End checking whether the file exists in the path or not anil_16-08-2011
		$htmlcontent = '<table width="550px" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top:40px">';
						//$pdf->Image('http://192.168.1.46/camassistant_new/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
						$pdf->Image('https://camassistant.com/live/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
						
		$htmlcontent .= '<tr><td width="235px" height="50" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:21px;"><img width="50" height="14" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td></tr>
		
						<tr style="font-size:21px;">
							<td colspan="2" width="275px" align="left"><strong><br /><br /><br />PROPOSAL REPORT FOR:</strong><br />
							'.$RFP_info->property_name.'<br />'
							.$RFP_info->street.'<br />'
							.$RFP_info->city.',  '.$RFP_info->state.'  '.$RFP_info->zip.'</td>
						 </tr>
						<tr><td>&nbsp;</td></tr>
						<tr style="font-size:21px;">';
						
						$htmlcontent .='<td width="340px" align="left" style="width:500px; float:left;"><hr width="340px" /><strong><br />Summary Details For RFP No.'.$RFP_info->id.':</strong><br />Reference Name: '.$RFP_info->projectName.'<br />Industry Solicited: '.$ind_solicited.'<br/>RFP Close Date & Time: '.$RFP_info->proposalDueDate.'   '.$RFP_info->proposalDueTime.'<br />Location where work is to be performed: '.$RFP_info->work_perform.'<br />Projected Contract Term: '.$RFP_info->frequency.'</td>
							<td style="width:300px; font-size:21px; text-align:left;"><hr width="210px" /><strong><br />Proposal Overview Details:</strong><br />Proposals Submitted:  <strong>'.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted:  <strong>'.$altproposals_submitted.'</strong><br />High Bid: <strong>$'.$Max_bid.'</strong><br />Low Bid: <strong>$'.$Min_bid.'</strong><br />Average Bid: <strong>$'.$Avg_bid.'</strong><br />
							</td>
						</tr>
						<tr style="height:5px;"><td align="left" colspan="2" style="font-size:5px;"><hr width="550px" /><br /></td></tr>
						';
		/***eof table pan****/
		
		/**** sof table pan****/
			$htmlcontent .= '<tr valign="middle"><td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>';
							  $cnt=count($BID_Vendors_info);
							  
							  if($cnt>0)
							  {
							  for($v=(4*$loop_start); $v<(4*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$htmlcontent .=  '<td width="22%" align="left" valign="middle">';
								} else if($remainder == 1){
			$htmlcontent .=  '<td width="22%" align="left" valign="middle">';								
								}
								else if($remainder == 2){
			$htmlcontent .=  '<td width="22%" align="left" valign="middle">';								
								}
								else if($remainder == 3){
			$htmlcontent .=  '<td width="22%" align="left" valign="middle">';								
								}
								else if($remainder == 0){
			$htmlcontent .=  '<td width="100%" align="left" valign="middle">';								
								}
			$htmlcontent .=   '<table width="100%" border="1" cellspacing="0" cellpadding="3">';
							  if($v%2 == 0)
							  $class = "#21314d";  
							  else 
							  $class = "#7ab800";
							  $vid = $v+1;
	
							  if($BID_Vendors_info[$v]->company_name == '')
							  $BID_Vendors_info[$v]->company_name = '---';
			$htmlcontent .= '<tr align="center"><td bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px; height:15px;">VENDOR '.$vid.'</td></tr>';
			//if($BID_Vendors_info[$v]->image != '') $image = $BID_Vendors_info[$v]->image; else $image = 'noimage1.gif'; 
			
					// Start checking whether the file exists in the path or not anil_16-08-2011
							if($BID_Vendors_info[$v]->image != ''){ 
								$vendor_image = $pat.'vendors/pdf_resized/'.$BID_Vendors_info[$v]->image;
								if (!file_exists($vendor_image)) { 
									$image = 'noimage1.gif'; 
									} else 
									$image = $BID_Vendors_info[$v]->image; 
							 } else { $image = 'noimage1.gif'; }
					// End checking whether the file exists in the path or not anil_16-08-2011
	$BID_Vendors_info[$v]->company_phone = explode('-',$BID_Vendors_info[$v]->company_phone) ;
	$BID_Vendors_info[$v]->company_phone = '('.$BID_Vendors_info[$v]->company_phone[0].') '.$BID_Vendors_info[$v]->company_phone[1].'-'.$BID_Vendors_info[$v]->company_phone[2];
	$altphone = "Alt.Phone: ";
	$altphoneext = "Alt.Extension: ";
	$BID_Vendors_info[$v]->alt_phone = explode('-',$BID_Vendors_info[$v]->alt_phone) ;
	$BID_Vendors_info[$v]->alt_phone = '('.$BID_Vendors_info[$v]->alt_phone[0].') '.$BID_Vendors_info[$v]->alt_phone[1].'-'.$BID_Vendors_info[$v]->alt_phone[2];
	$cellphone = "Mobile Phone: ";
	$BID_Vendors_info[$v]->cellphone = explode('-',$BID_Vendors_info[$v]->cellphone) ;
	$BID_Vendors_info[$v]->cellphone = $cellphone.'('.$BID_Vendors_info[$v]->cellphone[0].') '.$BID_Vendors_info[$v]->cellphone[1].'-'.$BID_Vendors_info[$v]->cellphone[2];
	/*$phone ='Phone: ';
	$BID_Vendors_info[$v]->phone = explode('-',$BID_Vendors_info[$v]->phone) ;
	$BID_Vendors_info[$v]->phone = $phone.'('.$BID_Vendors_info[$v]->phone[0].') '.$BID_Vendors_info[$v]->phone[1].'-'.$BID_Vendors_info[$v]->phone[2];*/
	//print_r($BID_Vendors_info[$v]->proposal_total_price); exit;
	$BID_Vendors_info[$v]->proposal_total_price = number_format( $BID_Vendors_info[$v]->proposal_total_price , 2 , '.' ,',' );
	$db = JFactory::getDBO();
	$vstate="SELECT state_name FROM #__state where id='".$BID_Vendors_info[$v]->state."'";
	$db->Setquery($vstate);
	$vstate = $db->loadResult();
	//echo '<pre>'; print_r($vstate); exit; 
	//echo '<pre>'; print_r($BID_Vendors_info[$v]); exit;
	//echo "<pre>"; print_r($BID_Vendors_info[$v]->company_phone); exit;
	//echo $image; exit;
			$htmlcontent .= '<tr><td align="center"><img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$image.'"  />  </td></tr>';
			$htmlcontent .= '<tr valign="baseline"><td height="30" align="center" style="font-size:19px ; text-align: center; vertical-align:middle">'.$BID_Vendors_info[$v]->company_name.'</td></tr>'; 
//$rateimage= 'http://192.168.1.46/camassistant_new'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rating'.DS;
$rateimage= 'https://camassistant.com/live'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rating'.DS;
			$db = JFactory::getDBO();
			$rating = "SELECT rating_sum FROM #__content_rating where content_id =".$BID_Vendors_info[$v]->proposedvendorid;
			$db->Setquery($rating);
			$rating = $db->loadResult();
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; }
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; }
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; }
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; }
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; } 
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; }
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; }
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; }
			else 
			{ $rate_image = $rateimage.'40.png'; }
			//print_r($rate_image); exit;
			/*  '.$rating=plgVotitaly($BID_Vendors_info[$v]->proposedvendorid,$limitstart).' */
			/* <img src="templates/camassistant_left/images/rating.gif" width="75" height="15" /> */
			$htmlcontent .= '<tr><td border="0" style="font-size:19px ;text-align: center;"><img src="'.$rate_image.'" /></td></tr>
							<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$BID_Vendors_info[$v]->company_address.',<br />'.$BID_Vendors_info[$v]->city.',<br />'.$vstate.' '.$BID_Vendors_info[$v]->zipcode.'</td>  </tr>
							<tr><td height="15" style="font-size:19px ; text-align: center; ">In-House Vendor? <strong>'. $BID_Vendors_info[$v]->in_house_vendor.'</strong></td></tr>
							
							<tr><td height="15" style="font-size:19px ; text-align: center; ">Company Phone: '. $BID_Vendors_info[$v]->company_phone.'</td>  </tr>';
							 if($BID_Vendors_info[$v]->phone_ext != '') $phone_ext = 'Extension: '.$BID_Vendors_info[$v]->phone_ext; else $phone_ext = 'Extension: N/A'; 
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$phone_ext.'</td></tr>';
							if($BID_Vendors_info[$v]->alt_phone != '') $alt_ext = $altphone.$BID_Vendors_info[$v]->alt_phone; else $alt_ext = 'Alt.Phone: N/A';
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$alt_ext.'</td></tr>';
							 if($BID_Vendors_info[$v]->alt_phone_ext != '') $alt_phone_ext = $altphoneext.$BID_Vendors_info[$v]->alt_phone_ext; else $alt_phone_ext = 'Alt.Extension: N/A';
			 $htmlcontent .= '<tr><td  height="15" style="font-size:19px ; text-align: center; ">'.$alt_phone_ext.'</td></tr>
							 <tr><td height="15" style="font-size:19px ; text-align: center;">Year Business Established: '.$BID_Vendors_info[$v]->established_year.'</td>
		  </tr>
							<tr><td height="30" style="font-size:19px ;text-align: center; ">Contact: '.$BID_Vendors_info[$v]->name.' '.$BID_Vendors_info[$v]->lastname.'</td></tr>
							<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$BID_Vendors_info[$v]->email.'</td></tr>';		
							/*if($BID_Vendors_info[$v]->extension != '') $extension = 'Extension: '.$BID_Vendors_info[$v]->extension; else $extension = 'Extension: N/A';
			  $htmlcontent .= '<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$extension.'</td></tr>';*/
							if($BID_Vendors_info[$v]->cellphone != '') $cellphone = $BID_Vendors_info[$v]->cellphone; else $cellphone = 'Mobile Phone: N/A';
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$cellphone.'</td></tr>';
							if($v%2 == 0) $class = "#7ab800";  else $class = "#21314d";
		   $htmlcontent .= '<tr><td height="15" bgcolor="'.$class.'" style="color:#FFF; font-size:21px; font-weight:bold; font-family:ArialBlack; text-align: center; ">TOTAL AMOUNT PROPOSED</td></tr>';
							/*if($v%2 == 0)*/
							$class = "color:#21314d; font-size:21px; font-weight:bold; font-family:ArialBlack; text-align: center; ";
							/*else $class = "color:#7ab800; font-size:21px; font-weight:bold;  font-family:ArialBlack;text-align:center";*/
							$addexp="SELECT count(*) FROM #__cam_rfpsow_addexception where rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' ";
							$db->Setquery($addexp);
							$addexp = $db->loadResult();
							//echo '<pre>'; print_r($addexp); exit;
							if ($addexp >'0'){
							$BID_Vendors_info[$v]->proposal_total_price = $BID_Vendors_info[$v]->proposal_total_price.'<font style="color:#FF0000;"> *</font>';
							}
		  $htmlcontent .= '<tr><td height="15" style="'.$class.'">$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr>
						<tr><td height="15" style="font-size:19px ;text-align: center;">Alternate Proposal Provided?</td></tr>';
							$db = JFactory::getDBO();
							$sql = "SELECT proposal_total_price FROM #__cam_vendor_proposals where Alt_bid = 'yes' AND rfpno = ".sprintf('%d', $RFP_info->id)." AND proposedvendorid 	=".$BID_Vendors_info[$v]->proposedvendorid;
							$db->Setquery($sql);
							$Alt_Price = $db->loadResult();  
							if($Alt_Price != '') 
							{$res = 'Yes'; } else $res = 'No';
			$htmlcontent .=  '<tr><td height="15" style="font-size:19px ;text-align: center; color:#464646; font-weight:bold;  font-family:ArialBlack;">'.$res.'</td></tr>';
			if($Alt_Price != '')
			$Alt_Price = number_format( $Alt_Price ,2,'.',',' );
			//echo '<pre>'; print_r($Alt_Price); 
			if($Alt_Price != '') $Alt_Price = 'Alt.Price: $'.$Alt_Price; else $Alt_Price = 'Alt.Price: N/A';
			$htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; color:#464646; font-weight:bold; font-family:ArialBlack;">'.$Alt_Price.'</td>
		  </tr>';				 
			$htmlcontent .= '</table></td>';
								}//inner if loop
							  }//end for loop 
							 }//if loop 
			$htmlcontent .= '</tr></table></td></tr></table>';
			$htmlcontent .= '<table><tr><td></td></tr><tr><td style="font-size:17px; align:left;"><font color="red">* </font>Designates exception for 1 or more line items. 	Please see vendor notes for details.</td></tr></table>';  
		
			$style = array('color' => array(220, 220, 220));
			$style7 = array('width' => 0.1, 'color' => array(220, 220, 220));
			$pdf->SetLineStyle($style7);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0); 
		
		// add a page
		//$pdf->AddPage();
	// echo $htmlcontent; 
		if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
		/************************************************************End of 4th Page TASKS SUMMARY*************************************************************/
     }//end - for($loop_start=0, $loop_stop=1; $loop_start<count($BID_Vendors_info); $loop_start++,$loop_stop++)

$pdf->AddPage();
		$TASKS_summary = $TASK_details;
		//echo "<pre>"; print_r($TASKS_summary); exit;
		$DOCS_summary = $DOCS_details;
		$NOTES_summary = $NOTES_details;
		$EXCEPTION_summary = $ALTEXCEPTION_details;
		$RFP_NOTES_summary = $tasks_list;
		$vendors_cnt = $vendor_ids;
		
		
		
		
		//echo "<pre>"; print_r($TASKS_summary); exit;
			$htmlcontent3 = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">'.
			$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false); 
			$htmlcontent3 ='<tr><td width="235px" height="50" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.', '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td>
			</tr>';
		
			$htmlcontent3 .='<tr><td width="100%" colspan="2" height="15" bgcolor="#7ab800" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">RFP TASKS REQUESTED</td></tr>';
			
			$htmlcontent3 .= '<tr><td width="100%" colspan="2">';
							 $line_cnt=count($RFP_NOTES_summary);
							 if($line_cnt>0)
							 { 
							 for($li=0; $li<$line_cnt; $li++)
							 {
							 $lid = $li+1;
							 if($RFP_NOTES_summary[$li]->title == '')
							 $RFP_NOTES_summary[$li]->title = 'NONE';
			$htmlcontent3 .='<tr><td colspan="2" style="font-size:20px; text-align: left;"><span style="color:#21314d; font-weight:bold;"><br /><br />LINE ITEM #'.$lid.':</span> '.$RFP_NOTES_summary[$li]->task_desc.'<p style="color:#7ab800; font-weight:bold;">Attachment #'.$lid.': '.$RFP_NOTES_summary[$li]->title.'</p></td></tr>';
			
							// for($v=(6*$loop_start); $v<(6*$loop_stop); $v++)
							for($v=0; $v<count($BID_Vendors_info); $v++)
							{
							 $x = 0;
							 if($v%2 == 0)
							 $class = "#7ab800";  
							  else 
							  $class = "#21314d";
							 $vid = $v+1;
			$htmlcontent3 .='<table width="100%" border="0" cellpadding="3" cellspacing="3">';
			$htmlcontent3 .='<tr><td height="15" width="22%"  bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">VENDOR '.$vid.' NOTES:</td></tr>';
			/******************************************code to display NOTES*******************************************/
							$cnt_tasks=count($NOTES_summary); 
							if($cnt_tasks>0)
							{
							$flag = 0;
							$htmlcontent3 .= '<tr><td border="1" width="100%" height="15" style="font-size:19px ;text-align: left; ">';
								 for($T=0; $T<$cnt_tasks; $T++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $NOTES_summary[$T]->task_id)
								   {
									 $cnt_notes = count($NOTES_summary[$T]->task_notes); 
									 //echo "<pre>"; print_r($NOTES_summary[$T]->task_notes); 
									 for($N=0; $N<$cnt_notes; $N++)
									 {
										if($NOTES_summary[$T]->task_notes[$N]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($NOTES_summary[$T]->task_notes[$N]->add_notes != '')
									      {
										  $htmlcontent3 .= '<b>NOTES :</b><p>'.$NOTES_summary[$T]->task_notes[$N]->add_notes.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<b>NOTES : </b><p>NONE</p>';		
										  }
									    }
									 } 
								 } 
								} 
							}
				/******************************************code to display EXCEPTION *******************************************/
				$cnt_excep=count($EXCEPTION_summary); 
					if($cnt_excep>0)
							{
							$flag = 0;
								 for($E=0; $E<$cnt_excep; $E++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $EXCEPTION_summary[$E]->task_id)
								   {
									 $cnt_Excep = count($EXCEPTION_summary[$E]->task_exception); 
									 for($F=0; $F<$cnt_Excep; $F++)
									 {
									    if($EXCEPTION_summary[$E]->task_exception[$F]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($EXCEPTION_summary[$E]->task_exception[$F]->add_exception != '')
									      {
										  $htmlcontent3 .= '<p style="color:#FF0000"><b>EXCEPTION(S) :</b>&nbsp;<br />'.$EXCEPTION_summary[$E]->task_exception[$F]->add_exception.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p style="color:#FF0000"><b>EXCEPTION(S) :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}
				/******************************************code to display vendor uploaded files *******************************************/	
				$cnt_uploades=count($TASKS_summary); 
					if($cnt_uploades>0)
							{
							$flag = 0;
								 for($A=0; $A<$cnt_uploades; $A++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$A]->task_id)
								   {
									 $cnt_Attachments = count($TASKS_summary[$A]->vendor_uploads); 
									 for($B=0; $B<$cnt_Attachments; $B++)
									 {
									    if($TASKS_summary[$A]->vendor_uploads[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$A]->vendor_uploads[$B]->upload_doc != '')
									      {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S) :</b>&nbsp;<br />'.$TASKS_summary[$A]->vendor_uploads[$B]->title.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S) :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}	
				/******************************************code to display vendor line item prices *******************************************/	
				$cnt_prices=count($TASKS_summary); 
					if($cnt_prices>0)
							{
							$flag = 0;
								 for($TP=0; $TP<$cnt_prices; $TP++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$TP]->task_id)
								   {
									 $cnt_Task_Prices = count($TASKS_summary[$TP]->task_price); 
									 for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
									    if($TASKS_summary[$TP]->task_price[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$TP]->task_price[$B]->item_price != '')
									      {
										  $htmlcontent3 .= '<p><b>LINE ITEM PRICE :</b>&nbsp;<br />$ '.$TASKS_summary[$TP]->task_price[$B]->item_price.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p><b>LINE ITEM PRICE :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}	
											
									
							$htmlcontent3 .='</td></tr>';
							$htmlcontent3 .= '</table>';
							}//end inner for loop 
							}//end main for loop 
							}//if($line_cnt>0)
		    $htmlcontent3 .= '</td></tr>';
			$htmlcontent3 .= '</table>'; 
			

		// echo "SECOND".$htmlcontent3; 
		$pdf->writeHTML($htmlcontent3, true, 0, true, 0);	
		// add a page
		//$pdf->AddPage();				 
		/**************************************************END RFP LINE ITEMS AND VENDOR RESPONSES*************************************************************/
		
		/*********************************************SPECIAL REQUIREMENTS COMPLIANCE DOCS************************/
		/*$SPL_REQ_DETAILS = $this->SPLRequirements_details;
		$cat = $this->SPLReq_Category;
		$main = $SPL_REQ_DETAILS['main'];
		$sub = $SPL_REQ_DETAILS['sub'];
		$child = $SPL_REQ_DETAILS['child'];
		$price = $SPL_REQ_DETAILS['price'];*/
		$COM =$COM;
		
		$Review_reqCatList =  $SPLRequirements_details;
		
		$cat = $Review_reqCatList['main'];
		$main = $Review_reqCatList['main'];
		$sub = $Review_reqCatList['sub'];
		$child = $Review_reqCatList['child'];
		$child_price=array();
		//echo "<pre>"; print_r($cat); print_r($main); print_r($sub); print_r($child); 
	    error_reporting('E_WARNING)');
		// add a page
		$pdf->AddPage();
			$htmlcontent4 = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';
						//$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, "70", "24", "", "", "", true, 100);
			//$htmlcontent4 .= '<tr><td width="205px" height="50" align="left" ></td><td width="345px" style="text-align: left; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.','.$RFP_info->comp_state.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td></tr>';
						
		//$htmlcontent4 .='<tr style="height:5px;"><td align="left" colspan="2" style="font-size:5px;"><hr /><br /></td></tr>';
								
			$htmlcontent4 .='<tr><td colspan="2" height="15" bgcolor="#21314d" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">SPECIAL REQUIREMENTS -- Vendors meet the following requirements:</td></tr>';
			$htmlcontent4 .='<tr><td colspan="2"><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:19px; text-align: left; ">';	
			for($c=0; $c<count($cat); $c++)
							{
								 for($m=0; $m<count($main); $m++)
								 {
									if($cat[$c]->main_id == $main[$m]->main_id)
									{
										$htmlcontent4 .= '<span style="padding-left:0px;font-weight:bold;height:15px;">'.ucwords($main[$m]->main_title).'</span><br/>'; 
										for($s=0; $s<count($sub); $s++)
										{
											if($main[$m]->main_id==$sub[$s]->main_id)
											{
											$htmlcontent4 .= '<span style="padding-left:25px;font-weight:normal;height:15px;">&nbsp;&nbsp;'.ucwords($sub[$s]->sub_title).'</span><br/>';
											if($sub[$s]->sub_id==12)
											$htmlcontent4 .= '<span style="padding-left:25px;font-weight:normal;height:15px;"> &nbsp;&nbsp; Minimum Liability Insurance Amount Required:<b>$'.$sub[$s]->price.'</b></span> <br/>';
												for($ch=0; $ch<count($child); $ch++)
												{
													if($sub[$s]->sub_id==$child[$ch]->sub_id)
													{
													$htmlcontent4 .= '<span style="padding-left:45px;font-weight:normal;height:15px;">&nbsp;&nbsp;'.ucwords($child[$ch]->child_title).'</span>';
													if($child[$ch]->child_id==14)
													{
													$child_price=explode('/',$child[$ch]->price);
													$htmlcontent4 .= '<span style="padding-left:30px;font-weight:normal;height:15px;font-weight:bold"> $'.$child_price[0].'/$'.$child_price[1].'/$'.$child_price[2].'</span><br/>';
													} else {
													$htmlcontent4 .= '<br/>';
													}
													}
												}
											}
											
										}
									}
								  }
 						} //for($c=0; $c<count($cat); $c++)	
							$htmlcontent4 .= '<br/><br/>';
							$count=count($vendors_cnt);
							if($count>0){ for($v=0; $v<$count; $v++) { 
							$cnt = $v+1;
							 if($v%2 == 0)
							 $class = "#7ab800";  
							  else 
							  $class = "#21314d";
							  if($v != 0)
							$htmlcontent4 .= '<p></p>';
							$htmlcontent4 .=  '<table width="11%" cellpadding="3"><tr align="center"><td colspan="2" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px; height:15px;">VENDOR '.$cnt.':</td></tr></table>';
							
							  					 if($COM[$v]['OLN'] != '')
												 $htmlcontent4 .= '<br/>OLN License: '.$COM[$v]['OLN'].'<br/>'; 
												 if($COM[$v]['PLN'] != '')
												 $htmlcontent4 .= 'PLN License: '.$COM[$v]['PLN'].'<br/>'; 
												 if($COM[$v]['GLI'] != '')
												 $htmlcontent4 .= 'GLI Insurance: '.$COM[$v]['GLI'].'<br/>'; 
												 if($COM[$v]['WCI'] != '')
												 $htmlcontent4 .= 'WCI Insurance: '.$COM[$v]['WCI'].'<br/>'; 
												 if($COM[$v]['W9'] != '')
												 $htmlcontent4 .= 'W9: '.$COM[$v]['W9']; 
							 }
							 }
			$htmlcontent4 .='</td></tr></table>'; 
		    $htmlcontent4 .= '</td></tr></table>';	
				
		$pdf->writeHTML($htmlcontent4, true, 0, true, 0);
		//echo "THIRD".$htmlcontent4; 
	/********************************************END OF CODE SPECIAL REQUIREMENTS COMPLIANCE DOCS************************/
	} //end - if(count($BID_Vendors_info)>0)
	
	
	/******************************************************** CODE TO ALTERNATE PROPOSALS *****************************************************************/
	$BID_Vendors_info = $res_altvendors; 
	$remainder = count($BID_Vendors_info)%4;
	$quotient = intval(count($BID_Vendors_info)/4);
	$total = count($BID_Vendors_info);
	if($remainder == 0)
	$loop_iterator = $quotient;
	else
	$loop_iterator = $quotient+1;
	
	if(count($BID_Vendors_info)>0)
	{
	  // add a page
		$pdf->AddPage();
	/********************************************************** code to display vendor info htmlcontent ***************************************************/
	
	for($loop_start=0, $loop_stop=1; $loop_start<$loop_iterator; $loop_start++,$loop_stop++)
    {
		if($RFP_info->comp_logopath == '')
		$RFP_info->comp_logopath = 'noimage2.gif';
		$htmlcontent = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';
						$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
		$htmlcontent .= '<tr><td width="235px" height="70px" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td></tr>
		
						<tr style="font-size:21px; ">
							<td colspan="2" width="275px"  align="left"><strong><br />PROPOSAL REPORT FOR:</strong><br />
							'.$RFP_info->comp_name.'<br />'
							.$RFP_info->street.'<br />'
							.$RFP_info->city.',  '.$RFP_info->state.'  '.$RFP_info->zip.'</td>
						 </tr>
						
						<tr style="font-size:21px;">';
						
						$htmlcontent .='<td width="340px" align="left" style="width:500px; float:left;"><hr width="340px" /><strong><br />Summary Details For RFP No.'.$RFP_info->id.':</strong><br />Reference Name: '.$RFP_info->projectName.'<br />Industry Solicited: '.$ind_solicited.'<br/>RFP Close Date & Time: '.$RFP_info->proposalDueDate.'   '.$RFP_info->proposalDueTime.'<br />Location where work is to be performed: '.$RFP_info->work_perform.'<br />Projected Contract Term: '.$RFP_info->frequency.'							</td>
							<td style="width:300px; font-size:21px; text-align:left;"><hr width="210px" /><strong><br />Proposal Overview Details:</strong><br />Proposals Submitted:  <strong>'.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted:  <strong>'.$altproposals_submitted.'</strong><br />High Bid: <strong>$'.$Max_bid.'</strong><br />Low Bid: <strong>$'.$Min_bid.'</strong><br />Average Bid: <strong>$'.$Avg_bid.'</strong><br />
							</td>
						</tr>
						<tr style="height:5px;"><td align="left" colspan="2" style="font-size:5px;"><hr width="550px" /><br /></td></tr>
						';
		$htmlcontent .='<tr align="center"><td width="550px" bgcolor="#7ab800" colspan="2" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:22px;  vertical-align:middle; height:19px;">Alternate Proposals - See below for alternate proposals provided by vendors:</td></tr>';				
		/***eof table pan****/
		
		/**** sof table pan****/
			$htmlcontent .= '<tr><td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>';
							  $cnt=count($BID_Vendors_info);
							  if($cnt>0)
							  {
							  for($v=(4*$loop_start); $v<(4*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$htmlcontent .=  '<td width="25%" align="left" valign="middle">';
								} else if($remainder == 1){
			$htmlcontent .=  '<td width="25%" align="left" valign="middle">';								
								}
								else if($remainder == 2){
			$htmlcontent .=  '<td width="25%" align="left" valign="middle">';								
								}
								else if($remainder == 3){
			$htmlcontent .=  '<td width="25%" align="left" valign="middle">';								
								}
								else if($remainder == 0){
			$htmlcontent .=  '<td width="100%" align="left" valign="middle">';								
								}
			$htmlcontent .=   '<table width="100%" border="1" cellspacing="0" cellpadding="3">';
							  if($v%2 == 0)
							  $class = "#21314d";  
							  else 
							  $class = "#7ab800";
							  $vid = $v+1;
	
							  if($BID_Vendors_info[$v]->company_name == '')
							  $BID_Vendors_info[$v]->company_name = '---';
			$htmlcontent .= '<tr align="center"><td bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px; height:15px;">VENDOR '.$vid.'</td></tr>';
			//if($BID_Vendors_info[$v]->image != '') $image = $BID_Vendors_info[$v]->image; else $image = 'noimage1.gif'; 
			
					// Start checking whether the file exists in the path or not anil_16-08-2011
							if($BID_Vendors_info[$v]->image != ''){ 
								$vendor_image = $pat.'vendors/pdf_resized/'.$BID_Vendors_info[$v]->image;
								if (!file_exists($vendor_image)) { 
									$image = 'noimage1.gif'; 
									} else 
									$image = $BID_Vendors_info[$v]->image; 
							 } else { $image = 'noimage1.gif'; }
					// End checking whether the file exists in the path or not anil_16-08-2011
	$BID_Vendors_info[$v]->company_phone = explode('-',$BID_Vendors_info[$v]->company_phone) ;
	$BID_Vendors_info[$v]->company_phone = '('.$BID_Vendors_info[$v]->company_phone[0].') '.$BID_Vendors_info[$v]->company_phone[1].'-'.$BID_Vendors_info[$v]->company_phone[2];
	$altphone = "Alt.Phone: ";
	$altphoneext = "Alt.Extension: ";
	$BID_Vendors_info[$v]->alt_phone = explode('-',$BID_Vendors_info[$v]->alt_phone) ;
	$BID_Vendors_info[$v]->alt_phone = '('.$BID_Vendors_info[$v]->alt_phone[0].') '.$BID_Vendors_info[$v]->alt_phone[1].'-'.$BID_Vendors_info[$v]->alt_phone[2];
	$cellphone = "Mobile Phone: ";
	$BID_Vendors_info[$v]->cellphone = explode('-',$BID_Vendors_info[$v]->cellphone) ;
	$BID_Vendors_info[$v]->cellphone = $cellphone.'('.$BID_Vendors_info[$v]->cellphone[0].') '.$BID_Vendors_info[$v]->cellphone[1].'-'.$BID_Vendors_info[$v]->cellphone[2];
	/*$phone ='Phone: ';
	$BID_Vendors_info[$v]->phone = explode('-',$BID_Vendors_info[$v]->phone) ;
	$BID_Vendors_info[$v]->phone = $phone.'('.$BID_Vendors_info[$v]->phone[0].') '.$BID_Vendors_info[$v]->phone[1].'-'.$BID_Vendors_info[$v]->phone[2];*/
	$BID_Vendors_info[$v]->proposal_total_price = number_format( $BID_Vendors_info[$v]->proposal_total_price , 2 , '.' ,',' );
	$Alt_Price = number_format( $Alt_Price , 2 , '.' ,',' );
	$db = JFactory::getDBO();
	$vstate="SELECT state_name FROM #__state where id='".$BID_Vendors_info[$v]->state."'";
	$db->Setquery($vstate);
	$vstate = $db->loadResult();
	//echo '<pre>'; print_r($vstate); exit; 
	//echo '<pre>'; print_r($BID_Vendors_info[$v]); exit;
	//echo "<pre>"; print_r($BID_Vendors_info[$v]->company_phone); exit;
	//echo $image; exit;
	$rateimage= 'https://camassistant.com/live'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rating'.DS;
			$db = JFactory::getDBO();
			$rating = "SELECT rating_sum FROM #__content_rating where content_id =".$BID_Vendors_info[$v]->proposedvendorid;
			$db->Setquery($rating);
			$rating = $db->loadResult();
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; }
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; }
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; }
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; }
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; } 
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; }
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; }
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; }
			else 
			{ $rate_image = $rateimage.'40.png'; }
			//print_r($rate_image); exit;
			$htmlcontent .= '<tr><td align="center"> <img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$image.'"  />  </td></tr>';
			$htmlcontent .= '<tr><td height="30" align="center" style="font-size:19px ; text-align: center; ">'.$BID_Vendors_info[$v]->company_name.'</td></tr>'; 
			/*  '.$rating=plgVotitaly($BID_Vendors_info[$v]->proposedvendorid,$limitstart).' */
			/* <img src="templates/camassistant_left/images/rating.gif" width="75" height="15" /> */
			$htmlcontent .= '<tr><td border="0" style="font-size:19px ;text-align: center;"><img src="'.$rate_image.'" /></td></tr>
							<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$BID_Vendors_info[$v]->company_address.',<br />'.$BID_Vendors_info[$v]->city.',<br />'.$vstate.' '.$BID_Vendors_info[$v]->zipcode.'</td>  </tr>
							<tr><td height="15" style="font-size:19px ; text-align: center; ">In-House Vendor? <strong>'. $BID_Vendors_info[$v]->in_house_vendor.'</strong></td></tr>
							
							<tr><td height="15" style="font-size:19px ; text-align: center; ">Company Phone: '. $BID_Vendors_info[$v]->company_phone.'</td>  </tr>';
							 if($BID_Vendors_info[$v]->phone_ext != '') $phone_ext = 'Extension: '.$BID_Vendors_info[$v]->phone_ext; else $phone_ext = 'Extension: N/A'; 
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$phone_ext.'</td></tr>';
							if($BID_Vendors_info[$v]->alt_phone != '') $alt_ext = $altphone.$BID_Vendors_info[$v]->alt_phone; else $alt_ext = 'Alt.Phone: N/A';
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; ">'.$alt_ext.'</td></tr>';
							 if($BID_Vendors_info[$v]->alt_phone_ext != '') $alt_phone_ext = $altphoneext.$BID_Vendors_info[$v]->alt_phone_ext; else $alt_phone_ext = 'Alt.Extension: N/A';
			 $htmlcontent .= '<tr><td  height="15" style="font-size:19px ; text-align: center; ">'.$alt_phone_ext.'</td></tr>
							 <tr><td height="15" style="font-size:19px ; text-align: center;">Year Business Established: '.$BID_Vendors_info[$v]->established_year.'</td>
		  </tr>
							<tr><td height="30" style="font-size:19px ;text-align: center; ">Contact: '.$BID_Vendors_info[$v]->name.' '.$BID_Vendors_info[$v]->lastname.'</td></tr>
							<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$BID_Vendors_info[$v]->email.'</td></tr>';		
							/*if($BID_Vendors_info[$v]->extension != '') $extension = 'Extension: '.$BID_Vendors_info[$v]->extension; else $extension = 'Extension: N/A';
			  $htmlcontent .= '<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$extension.'</td></tr>';*/
							if($BID_Vendors_info[$v]->cellphone != '') $cellphone = $BID_Vendors_info[$v]->cellphone; else $cellphone = 'Mobile Phone: N/A';
			 $htmlcontent .= '<tr><td height="15" style="font-size:19px ;text-align: center; ">'.$cellphone.'</td></tr>';
							if($v%2 == 0) $class = "#7ab800";  else $class = "#21314d";
		   $htmlcontent .= '<tr><td height="15" bgcolor="'.$class.'" style="color:#FFF; font-size:21px; font-weight:bold; font-family:ArialBlack; text-align: center; ">TOTAL AMOUNT PROPOSED</td></tr>';
							/*if($v%2 == 0)*/ 
							$class = "color:#21314d; font-size:21px; font-weight:bold; font-family:ArialBlack; text-align: center; ";
							/*else $class = "color:#7ab800; font-size:21px; font-weight:bold;  font-family:ArialBlack;text-align:center";*/
							$addexp="SELECT count(*) FROM #__cam_rfpsow_addexception where rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' ";
							$db->Setquery($addexp);
							$addexp = $db->loadResult();
							//echo '<pre>'; print_r($addexp); exit;
							if ($addexp >'0'){
							$BID_Vendors_info[$v]->proposal_total_price = $BID_Vendors_info[$v]->proposal_total_price.'<font style="color:#FF0000;"> *</font>';
							}
		  $htmlcontent .= '<tr><td height="15" style="'.$class.'">$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr>
						<tr><td height="15" style="font-size:19px ;text-align: center;">Alternate Proposal Provided?</td></tr>';
							$db = JFactory::getDBO();
							$sql = "SELECT proposal_total_price FROM #__cam_vendor_proposals where Alt_bid = 'yes' AND rfpno = ".sprintf('%d', $RFP_info->id)." AND proposedvendorid 	=".$BID_Vendors_info[$v]->proposedvendorid;
							$db->Setquery($sql);
							$Alt_Price = $db->loadResult();  if($Alt_Price != '') 
							{$res = 'Yes'; } else $res = 'No';
			$htmlcontent .=  '<tr><td height="15" style="font-size:19px ;text-align: center; color:#464646; font-weight:bold;  font-family:ArialBlack;">'.$res.'</td></tr>';
			if($Alt_Price != '')
			$Alt_Price = number_format( $Alt_Price ,2,'.',',' );
			if($Alt_Price != '') $Alt_Price = 'Alt.Price: $'.$Alt_Price; else $Alt_Price = 'Alt.Price: N/A';
			$htmlcontent .= '<tr><td height="15" style="font-size:19px ; text-align: center; color:#464646; font-weight:bold; font-family:ArialBlack;">'.$Alt_Price.'</td>
		  </tr>';				 
			$htmlcontent .= '</table></td>';
								}//inner if loop
							  }//end for loop 
							 }//if loop 
			$htmlcontent .= '</tr></table></td></tr><tr><td align="left" style="font-size:17px; "><br /><font color="red">* </font>Designates exception for 1 or more line items. 	Please see vendor notes for details.</td></tr></table>';
			// echo $htmlcontent; exit;
			$style = array('color' => array(220, 220, 220));
			$style7 = array('width' => 0.1, 'color' => array(220, 220, 220));
			$pdf->SetLineStyle($style7);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0);
		//echo "FOURTH".$htmlcontent; 
			
		if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
		/************************************************************End of 4th Page TASKS SUMMARY*************************************************************/
     }//end - for($loop_start=0, $loop_stop=1; $loop_start<count($BID_Vendors_info); $loop_start++,$loop_stop++)
	 
	/********************************************************** code to display vendor info htmlcontent ***************************************************/ 
	
	 /***********************************************RFP LINE ITEMS ADN VENDOR RESPONSES*************************************************************/
		
		$TASKS_summary = $TASK_details;
		$NOTES_summary = $NOTES_details;
		
		$EXCEPTION_summary = $ALTEXCEPTION_details;
		$RFP_NOTES_summary = $tasks_list;
		$vendors_cnt = $vendor_ids;

		//echo "<pre>"; print_r($TASKS_summary); exit;
			// add a page
		    $pdf->AddPage();
			$htmlcontent3 = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">'.
			$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false); 
			$htmlcontent3 ='<tr><td width="235px" height="50" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.','.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td>
			</tr>';
		
			$htmlcontent3 .='<tr><td colspan="2" height="15" bgcolor="#7ab800" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">RFP TASKS REQUESTED</td></tr>';
			
			$htmlcontent3 .= '<tr><td colspan="2">';
							 $line_cnt=count($RFP_NOTES_summary);
							 if($line_cnt>0)
							 { 
							 for($li=0; $li<$line_cnt; $li++)
							 {
							 $lid = $li+1;
							 if($RFP_NOTES_summary[$li]->title == '')
							 $RFP_NOTES_summary[$li]->title = 'NONE';
			$htmlcontent3 .='<tr><td colspan="2" style="font-size:20px; text-align: left;"><span style="color:#21314d; font-weight:bold;"><br /><br />LINE ITEM #'.$lid.':</span> '.$RFP_NOTES_summary[$li]->task_desc.'<p style="color:#7ab800; font-weight:bold;">Attachment #'.$lid.': '.$RFP_NOTES_summary[$li]->title.'</p></td></tr>';
			
			
							// for($v=(6*$loop_start); $v<(6*$loop_stop); $v++)
							for($v=0; $v<count($BID_Vendors_info); $v++)
							{
							 $x = 0;
							 if($v%2 == 0)
							 $class = "#7ab800";  
							  else 
							  $class = "#21314d";
							 $vid = $v+1;
			$htmlcontent3 .='<table width="100%" border="0" cellpadding="3" cellspacing="3">';
			$htmlcontent3 .='<tr><td height="15" width="22%"  bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">VENDOR '.$vid.' NOTES:</td></tr>';	
			/******************************************code to display NOTES*******************************************/
							$cnt_tasks=count($NOTES_summary); 
							if($cnt_tasks>0)
							{
							$flag = 0;
							$htmlcontent3 .= '<tr><td border="1" width="100%" height="15" style="font-size:19px ;text-align: left; ">';
								 for($T=0; $T<$cnt_tasks; $T++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $NOTES_summary[$T]->task_id)
								   {
									 $cnt_notes = count($NOTES_summary[$T]->task_notes); 
									 //echo "<pre>"; print_r($NOTES_summary[$T]->task_notes); 
									 for($N=0; $N<$cnt_notes; $N++)
									 {
										if($NOTES_summary[$T]->task_notes[$N]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($NOTES_summary[$T]->task_notes[$N]->add_notes != '')
									      {
										  $htmlcontent3 .= '<b>NOTES :</b><p>'.$NOTES_summary[$T]->task_notes[$N]->add_notes.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<b>NOTES : </b><p>NONE</p>';		
										  }
									    }
									 } 
								 } 
								} 
							}
				/******************************************code to display EXCEPTION *******************************************/
				$cnt_excep=count($EXCEPTION_summary); 
					if($cnt_excep>0)
							{
							$flag = 0;
								 for($E=0; $E<$cnt_excep; $E++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $EXCEPTION_summary[$E]->task_id)
								   {
									 $cnt_Excep = count($EXCEPTION_summary[$E]->task_exception); 
									 for($F=0; $F<$cnt_Excep; $F++)
									 {
									    if($EXCEPTION_summary[$E]->task_exception[$F]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($EXCEPTION_summary[$E]->task_exception[$F]->add_exception != '')
									      {
										  $htmlcontent3 .= '<p style="color:#FF0000"><b>EXCEPTION(S) :</b>&nbsp;<br />'.$EXCEPTION_summary[$E]->task_exception[$F]->add_exception.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p style="color:#FF0000"><b>EXCEPTION(S) :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}
				/******************************************code to display vendor uploaded files *******************************************/	
				$cnt_uploades=count($TASKS_summary); 
					if($cnt_uploades>0)
							{
							$flag = 0;
								 for($A=0; $A<$cnt_uploades; $A++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$A]->task_id)
								   {
									 $cnt_Attachments = count($TASKS_summary[$A]->vendor_uploads); 
									 for($B=0; $B<$cnt_Attachments; $B++)
									 {
									    if($TASKS_summary[$A]->vendor_uploads[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$A]->vendor_uploads[$B]->upload_doc != '')
									      {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S) :</b>&nbsp;<br />'.$TASKS_summary[$A]->vendor_uploads[$B]->title.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S) :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}	
				/******************************************code to display vendor line item prices *******************************************/	
				$cnt_prices=count($TASKS_summary); 
					if($cnt_prices>0)
							{
							$flag = 0;
								 for($TP=0; $TP<$cnt_prices; $TP++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$TP]->task_id)
								   {
									 $cnt_Task_Prices = count($TASKS_summary[$TP]->task_price); 
									 for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
									    if($TASKS_summary[$TP]->task_price[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$TP]->task_price[$B]->item_price != '')
									      {
										  $htmlcontent3 .= '<p><b>LINE ITEM PRICE :</b>&nbsp;<br />$ '.$TASKS_summary[$TP]->task_price[$B]->item_price.'</p>';		
										  }
										  else
										  {
										  $htmlcontent3 .= '<p><b>LINE ITEM PRICE :</b>&nbsp;NONE</p>';		
										  }
									  }
									 } 
								 } 
								} 
							}	
											
									
							$htmlcontent3 .='</td></tr>';
							$htmlcontent3 .= '</table>';
							}//end inner for loop 
							}//end main for loop 
							}//if($line_cnt>0)
		    $htmlcontent3 .= '</td></tr>';
			$htmlcontent3 .= '</table>'; 
			
			
		
		print_r($pdf->writeHTML($htmlcontent3, true, 0, true, 0));	
//echo "FIFTH".$htmlcontent3; 
		// add a page
		//$pdf->AddPage();				 
		/**************************************************END RFP LINE ITEMS AND VENDOR RESPONSES*************************************************************/
		
	} //end - if(count($BID_Vendors_info)>0)
	
	if(count($BID_Vendors_info)== 0 && count($res_altvendors) == 0 )
	{
	$htmlcontent = "<font>No Proposals are Available for this RFP.  If you have questions or need assistance, please contact the CAMassistant Customer Support Team at 561-246-3830.  Thank you.</font>";
	$pdf->writeHTML($htmlcontent, true, 0, true, 0);
	}
	//echo $htmlcontent; exit;
	/******* eof table pan********/
	
	
	$pdf->lastPage();
	$title= $rfp_id.'_'.$RFP_info->comp_name.'.pdf'; //set title
	//echo $title; exit;
	$pdf->SetTitle($title);//set title
	ob_end_clean();
	//$upl_file_name=$pdf->Output($title, 'I');
	//$upl_file_name=$pdf->Output($title, 'F');
	$upl_file_name=$pdf->Output($title, 'F');
	$pdf_rfp = "UPDATE jos_cam_rfpinfo SET rfp_pdf  = 1 WHERE id= ".$row[$i]->id." ";
	$db->setQuery($pdf_rfp);
	$res=$db->query();
	
	//}
	// }
	

   }
   } else {
   echo 'There Is no pdfs to Generate';
   }

?>
