<?php
class PDFgen {

	function generatepdf($rfpid)
	{

/* Create a database object */
$db =& JFactory::getDBO();
//echo '<pre>'; print_r($_REQUEST);
//echo '<pre>'; print_r($_GET);
//echo '<pre>'; print_r($rfpid);
//$total_rfps="SELECT * FROM #__cam_rfpinfo where rfp_type = 'closed' and rfp_pdf=0";
$total_rfps="SELECT * FROM #__cam_rfpinfo where id=".$rfpid;
$db->Setquery($total_rfps);
$row = $db->loadObjectList();

$sql ="SELECT property_name FROM #__cam_property where id=".$row[0]->property_id;
$db->Setquery($sql);
$property_name = $db->loadResult();
$moveproperty_name = str_replace(" ", "_", $property_name);

for($i=0;$i<=count($row);$i++)
  {

	//////GENERATING PD FILE
	/////1. GETTING RFP DETAILS////
	$rfp_id = $row[$i]->id;
	$propertyid=$row[$i]->property_id;
	/*$sql = 'SELECT U.name, U.lastname, U.email, U.extension, U.phone, C.comp_name, C.comp_city, C.comp_state, comp_zip,  C.comp_phno, C.comp_extnno, C.comp_alt_phno, C.comp_alt_extnno, C.comp_website, C.mailaddress, C.comp_logopath, C.comp_id, C.cust_id, P.street, P.property_name, P.state, P.city, P.zip, R.id, R.industry_id, R.startDate, R.endDate, R.projectName,R.work_perform, R.frequency, R.proposalDueDate, R.proposalDueTime FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON R.cust_id = C.cust_id
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id
		LEFT JOIN  #__users as U ON R.cust_id = U.id WHERE R.id = '.$rfp_id;*/
		//code to get RFP Camfirm details
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
		//end of code
		// C.comp_id and  C.cust_id are added by anil_17-08-2011 for pdf generation manager logo purpose in the below query.
		$sql = 'SELECT U.name, U.lastname, U.email, U.extension, U.phone, C.comp_name, C.comp_city, C.comp_state, comp_zip,  C.comp_phno, C.comp_extnno, C.comp_alt_phno, C.comp_alt_extnno, C.comp_website, C.mailaddress, C.comp_logopath, C.comp_id, C.cust_id, P.street, P.property_name, P.state, P.city, P.zip, R.id, R.industry_id, R.startDate, R.endDate, R.projectName,R.work_perform, R.frequency, R.proposalDueDate, R.proposalDueTime, R.bidding, R.jobtype, R.jobnotes FROM #__cam_rfpinfo as R
		LEFT JOIN  #__cam_customer_companyinfo as C ON ( R.cust_id = C.cust_id  OR  R.cust_id != C.cust_id )
		LEFT JOIN  #__cam_property as P ON R.property_id = P.id
		LEFT JOIN  #__users as U ON (R.cust_id = U.id  OR R.cust_id != U.id)  WHERE R.id = '.$rfp_id.' AND C.cust_id	=	'.$customer_id.' AND U.id	=	'.$customer_id;
		$db->Setquery($sql);
		$RFP_details = $db->loadObjectList();

	for($in=0; $in<count($RFP_details); $in++) {

		$sqln = 'SELECT vid FROM #__vendor_inviteinfo WHERE userid = '.$firm_or_Mgr_id.' AND v_id='.$RFP_details[$in]->proposedvendorid.' AND vendortype=inhouse and status=1';
		$db->Setquery($sqln);
		$RFP_details_inhouse = $db->loadResult();
		if($RFP_details_inhouse){
		$RFP_details_inhouse1='Yes';
		} else {
		$RFP_details_inhouse1='No';
		}
		}
		// echo "<pre>"; print_r($RFP_details); exit;
	//////GENERATING PD FILE COMPLETED

	/////2. GETTING BID AMOUNT DETAILS////
	/* AND (proposaltype = 'Submit' or proposaltype = 'resubmit') added to the end of this query by anil_27-09-2011 */
		$db = & JFactory::getDBO();
		$Bid_sql = "SELECT  (select count(*)  from #__cam_vendor_proposals where rfpno=".$rfp_id." AND (proposaltype = 'Submit' or proposaltype = 'resubmit')) as Submitted, (select count(*)  from #__cam_vendor_proposals where rfpno=".$rfp_id." AND proposaltype = 'Reject') as Rejected, (SELECT SUM(proposal_total_price)/count(id) FROM #__cam_vendor_proposals where rfpno=".$rfp_id." AND (proposaltype = 'Submit' or proposaltype = 'resubmit') ) as Average_Bid, MAX(CAST( proposal_total_price AS UNSIGNED )) as Max_Bid, MIN(CAST( proposal_total_price AS UNSIGNED )) as Min_Bid 	FROM #__cam_vendor_proposals  WHERE proposal_total_price !='' and proposal_total_price!='0.00' and rfpno = ".$rfp_id." AND (proposaltype = 'Submit' or proposaltype = 'resubmit') ";
		$db->setQuery($Bid_sql);
		$Bid_info = $db->loadObjectList();
		$count = "select count(*) as count1, SUM(proposal_total_price) as total  from jos_cam_vendor_proposals where rfpno=".$rfp_id." and proposal_total_price !='0.00' and 	proposal_total_price!='' ";
		$db->setQuery($count);
		$wocount = $db->loadObject();
		$Bid_info[0]->Average_Bid = $wocount->total / $wocount->count1;

	/////2. GETTING BID AMOUNT DETAILS////

	/////3. GETTING BIDDED VEDNOR INFORMATION////
	$sql_biiddedvendors = "SELECT  VP.id,VP.proposedvendorid,VP.contact_name,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, U.extension, U.phone, U.cellphone,V.company_name,V.company_address,V.city,V.state,V.zipcode,V.image, V.in_house_vendor,V.company_phone,V.phone_ext,V.alt_phone,V.alt_phone_ext,V.established_year FROM #__cam_vendor_proposals AS VP LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id LEFT JOIN #__users as U ON U.id = V.user_id  WHERE  VP.rfpno = ".$rfp_id." AND VP.Alt_bid != 'Yes' AND VP.proposaltype!='Draft' AND VP.proposaltype!='ITB' ORDER BY VP.id ";
		$db->setQuery($sql_biiddedvendors);
		$Bid_vendors = $db->loadObjectList();
//echo 'anand'; exit;
	/////3. GETTING BIDDED VEDNOR INFORMATION COMPLETED////

	/////4. GETTING ALT BIDDED VEDNOR INFORMATION////
			$sql_altvendors = "SELECT  R.rating_sum, VP.id,VP.contact_name,VP.proposedvendorid,VP.rfpno,VP.Alt_bid,VP.proposal_total_price, U.name, U.lastname, U.email, U.extension, U.phone, U.cellphone,V.company_name,V.company_address,V.city,V.state,V.zipcode,V.image, V.in_house_vendor,V.company_phone,V.phone_ext,V.alt_phone,V.alt_phone_ext,V.established_year FROM #__cam_vendor_proposals AS VP
			LEFT JOIN #__content_rating as R ON R.content_id = VP.proposedvendorid
			LEFT JOIN #__cam_vendor_company as V ON VP.proposedvendorid = V.user_id
			LEFT JOIN #__users as U ON U.id = V.user_id  WHERE VP.rfpno = ".$rfp_id." AND VP.Alt_bid = 'yes' ORDER BY VP.id ";
		$db->setQuery($sql_altvendors);
		$res_altvendors = $db->loadObjectList();

	/////4. GETTING ALT BIDDED VEDNOR INFORMATION////

	/////5. FOR SECOND PAGE IN PDF////
			$sql_page = 'SELECT task_id,rfp_id,linetaskname,is_req_taskvendors FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql_page);
		$TASK_detailsn = $db->loadObjectList();

		  for($p=0; $p<count($TASK_detailsn); $p++) //to get task price
		  {
		   $nprice_sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="task" AND LP.item_id = '.$TASK_detailsn[$p]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"';
		  $db->Setquery($nprice_sql);
		  $price = $db->loadObjectList();
		  /*if($TASK_detailsn[$p]->task_id == '2245')
		  {echo $nprice_sql;
		  echo "<pre>"; print_r($price);}*/
		  $TASK_detailsn[$p]->task_price = $price;
		  }
		   for($q=0; $q<count($TASK_detailsn); $q++) //to get task price
		  {
		   $pricen2_sql = 'SELECT LP.id,LP.task_id,LP.upload_doc,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_uploadfiles as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.spl_req ="No" AND LP.task_id = '.$TASK_detailsn[$q]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"';
		  $db->Setquery($pricen2_sql);
		  $vendor_uploadsn = $db->loadObjectList();
			 for($r=0; $r<count($vendor_uploadsn); $r++)
			{
				 $arr = explode('/',$vendor_uploadsn[$r]->upload_doc);
				 $cnt = count($arr);
				 $vendor_uploadsn[$r]->title = $arr[$cnt-1];
				 $link = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_VENDOR&filename='.$vendor_uploadsn[$r]->upload_doc.'">'.$vendor_uploadsn[$r]->title.'</a>';
				 $vendor_uploadsn[$r]->title = $link;
			}
		  $TASK_detailsn[$q]->vendor_uploadsn = $vendor_uploadsn;

		  }
			/////5. FOR SECOND PAGE IN PDF COMPLETED////

	//////6. FOR ALT TASK SUMMARY////
		$sql = 'SELECT task_id,rfp_id,linetaskname,is_req_taskvendors FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$TASK_details = $db->loadObjectList();

		// "<pre>"; print_r($TASK_details);
		  for($ac=0; $ac<count($TASK_details); $ac++) //to get task price
		  {
		   $price_sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="task" AND LP.item_id = '.$TASK_details[$ac]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid = "yes" AND VP.Alt_bid = "yes"';
		  $db->Setquery($price_sql);
		  $price = $db->loadObjectList();
		  $TASK_details[$ac]->task_price = $price;
		  }

		   for($t=0; $t<count($TASK_details); $t++) //to get task price
		  {
		    $price_sql = 'SELECT LP.id,LP.task_id,LP.upload_doc,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_uploadfiles as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.spl_req ="No" AND LP.task_id = '.$TASK_details[$t]->task_id .' AND LP.rfp_id=VP.rfpno AND LP.Alt_bid = "yes" AND VP.Alt_bid = "yes"';

		  $db->Setquery($price_sql);
		  $vendor_uploads = $db->loadObjectList();

			 for($u=0; $u<count($vendor_uploads); $u++)
			{
				 $arr = explode('/',$vendor_uploads[$u]->upload_doc);
				 $cnt = count($arr);
				 $vendor_uploads[$u]->title = $arr[$cnt-1];
				 $link = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_VENDOR&filename='.$vendor_uploads[$u]->upload_doc.'">'.$vendor_uploads[$u]->title.'</a>';
				 $vendor_uploads[$u]->title = $link;
			}
		  $TASK_details[$t]->vendor_uploads = $vendor_uploads;
		  }
		  //echo "<pre>"; print_r($TASK_details);

		  ////6.FOR ALT TASK SUMMARY COMPLETED/////

	///7.GET ALT NOTES SUMMARY////
			$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$ALTNOTES_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($y=0; $y<count($ALTNOTES_details); $y++) //to get task price
		  {
		   $price_sql = 'SELECT VN.add_notes,VN.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addnotes as VN ON VP.proposedvendorid = VN.vendor_id  WHERE VN.spl_req="No" AND VN.task_id = '.$ALTNOTES_details[$y]->task_id.' AND VN.rfp_id=VP.rfpno AND VN.Alt_bid = "yes" AND VP.Alt_bid = "yes"'  ;
		  $db->Setquery($price_sql);
		  $altnotes = $db->loadObjectList();
		  $ALTNOTES_details[$y]->task_notes = $altnotes;
		  }
	///7.GET ALT NOTES SUMMARY COMPLETED////

	////8.GET DOCS SUMMARY//////
			$sql = 'SELECT * FROM #__cam_rfpsow_docs WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$DOCS_details = $db->loadObjectList();

			for($f=0; $f<count($DOCS_details); $f++)
			{
			 $arr = explode('/',$DOCS_details[$f]->doc_path);
			 $cnt = count($arr);
			 $DOCS_details[$f]->title = $arr[$cnt-1];
			 $sql = 'SELECT LP.id,LP.item_id,LP.item_price,LP.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_docs_lineitems_prices as LP ON VP.proposedvendorid = LP.vendor_id  WHERE LP.item_type="doc" AND LP.item_id = '.$DOCS_details[$f]->doc_id .' AND LP.rfp_id=VP.rfpno  AND LP.Alt_bid != "yes" AND VP.Alt_bid != "yes"';
			 /*$sql = 'SELECT item_price FROM #__cam_rfpsow_docs_lineitems_prices WHERE rfp_id = '.$rfp_id.' AND item_type="doc" AND item_id='.$DOCS_details[$i]->doc_id;*/
			$db->Setquery($sql);
			$price = $db->loadObjectList();
			$DOCS_details[$f]->doc_price = $price;
			}
    	////8.GET DOCS SUMMARY COMPLETED//////

		////9.GET NOTES SUMMARY //////
		$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$NOTES_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($g=0; $g<count($NOTES_details); $g++) //to get task price
		  {
		   $price_sql = 'SELECT VN.add_notes,VN.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addnotes as VN ON VP.proposedvendorid = VN.vendor_id  WHERE VN.spl_req="No" AND VN.task_id = '.$NOTES_details[$g]->task_id.' AND VN.rfp_id=VP.rfpno AND VN.Alt_bid != "yes" AND VP.Alt_bid != "yes"'  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $NOTES_details[$g]->task_notes = $notes;
		  }
		////9.GET NOTES SUMMARY COMPLETED//////

		////10.GET EXCEPTION SUMMARY //////
		$sql = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$EXCEPTION_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($h=0; $h<count($EXCEPTION_details); $h++) //to get task price
		  {
		  $price_sql = 'SELECT VE.add_exception,VE.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addexception as VE ON VP.proposedvendorid = VE.vendor_id  WHERE VE.spl_req="No" AND VE.task_id = '.$EXCEPTION_details[$h]->task_id.' AND VE.rfp_id=VP.rfpno AND VE.Alt_bid != "yes" AND  VP.Alt_bid != "yes" '  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $EXCEPTION_details[$h]->task_exception = $notes;
		  }
	////10.GET EXCEPTION SUMMARY COMPLETED//////

		////11.GET ALT EXCEPTION SUMMARY COMPLETED//////
		$sql_alte = 'SELECT task_id,rfp_id FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql_alte);
		$ALTEXCEPTION_details = $db->loadObjectList();
		//echo "<pre>"; print_r($TASK_details);
		  for($l=0; $l<count($ALTEXCEPTION_details); $l++) //to get task price
		  {
		  $price_sql = 'SELECT VE.add_exception,VE.vendor_id FROM #__cam_vendor_proposals as VP LEFT JOIN #__cam_rfpsow_addexception as VE ON VP.proposedvendorid = VE.vendor_id  WHERE VE.spl_req="No" AND VE.task_id = '.$ALTEXCEPTION_details[$l]->task_id.' AND VE.rfp_id=VP.rfpno AND VE.Alt_bid = "yes" AND  VP.Alt_bid = "yes" '  ;
		  $db->Setquery($price_sql);
		  $notes = $db->loadObjectList();
		  $ALTEXCEPTION_details[$l]->task_exception = $notes;
		  }
			////11.GET ALT EXCEPTION SUMMARY COMPLETED//////

		///12. FOR FOURTH PAGE IN PDF COMPLETED////
	 	$sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND Alt_bid != 'yes'";
		$db->Setquery($sql);
		$vendor_ids = $db->loadObjectList();
		///12. FOR FOURTH PAGE IN PDF COMPLETED////

	///13. RFPCREATOR TASKS////
		$sql = 'SELECT task_id,rfp_id,task_desc,taskuploads,linetaskname  FROM #__cam_rfpsow_linetask WHERE rfp_id = '.$rfp_id ;
		$db->Setquery($sql);
		$tasks_list = $db->loadObjectList();
		$pid1 = 'SELECT property_id FROM #__cam_rfpinfo WHERE id = '.$rfp_id ;
		$db->Setquery($pid1);
		$pid = $db->loadResult();
		//echo '<pre>'; print_r($pid);
		$details = 'SELECT property_name,tax_id FROM #__cam_property WHERE id = '.$pid ;
		$db->Setquery($details);
		$details1 = $db->loadObjectList();
		//echo '<pre>'; print_r($details1);
		 $default ='components/com_camassistant/doc/';
		$file_link = $default.str_replace(' ','_',$details1[0]->property_name).'_'.$details1[0]->tax_id.'/';
		for($ab=0; $ab<count($tasks_list); $ab++)
		{
			 $arr = explode('/',$tasks_list[$ab]->taskuploads);
			 $cnt = count($arr);
			 $tasks_list[$ab]->title = $arr[$cnt-1];
			   if($arr==''){
			 $file=$tasks_list[$ab]->taskuploads;
			 } else {
			 $file=$tasks_list[$ab]->title;
			  }
			  $link = '<a style="color:#21314d; text-decoration:none" href="'.JURI::root().'index.php?option=com_camassistant&controller=popupdocs&task=open&title='.$file.'&path='.$file_link.'/'.$tasks_list[$ab]->taskuploads.'">'.$file.'</a>';
			 //$link = '<a style="color:#21314d; text-decoration:none" href="http://myvendorcenter.com/live/index.php?option=com_camassistant&controller=vendors&task=view_upld_cert&folder_type=uploaded_by_CAM&filename='.$tasks_list[$ab]->title.'">'.$tasks_list[$ab]->title.'</a>';
			 $tasks_list[$ab]->file_path = $link;
		}
	///13. RFPCREATOR TASKS COMPLETED////
		// To get the special requirements/
		$rfp_gli_data ="SELECT * from #__cam_master_generalinsurance_standards_rfps  WHERE rfpid=".$rfp_id; //validation to status of docs
		$db->Setquery($rfp_gli_data);
		$generaldata = $db->loadObject();
		if( $generaldata ) {
	$g_data = '<table width="100%" border="0" style="font-size:24px;"><tr><td><strong>General Liability</strong></td></tr><tr><td><ul style="list-style-type:none;">';
		 if($generaldata->occur){ 
	$g_data .= '<li>Occur</li>';
		 } 
		 if($generaldata->each_occurrence && $generaldata->each_occurrence != '0.00'){ 
	$g_data .= '<li>Each Occurrence: <span id="greenbolddolor">$ '.number_format($generaldata->each_occurrence,2).'</span></li>';
		 } 
		 if($generaldata->damage_retend && $generaldata->damage_retend != '0.00'){ 
	$g_data .= '<li>Damage to Rented Premises: <span id="greenbolddolor">$ '.number_format($generaldata->damage_retend,2) .'</span></li>';
		 }
		 if($generaldata->med_expenses && $generaldata->med_expenses != '0.00'){ 
	$g_data .= 	'<li>Med Expenses: <span id="greenbolddolor">$ '.number_format($generaldata->med_expenses,2) .'</span></li>';
		 }
		 if($generaldata->personal_inj && $generaldata->personal_inj != '0.00'){ 
	$g_data .= '<li>Personal & Adv injury: <span id="greenbolddolor">$ '.number_format($generaldata->personal_inj,2) .'</span></li>';
		 }
		if( $generaldata->general_aggr  ){
	$g_data .= '<li>General Aggregate:&nbsp;<span id="greenbolddolor">$ '.number_format($aggregate_price,2) .'</span>';
		}
		if($generaldata->applies_to){ 
		$g_data .= '&nbsp;&nbsp;| &nbsp;&nbsp;Applies To:&nbsp;&nbsp;';
		if($generaldata->applies_to == 'pol') {
		$g_data .= 'Pol&nbsp;&nbsp; ';
		}
		else if($generaldata->applies_to == 'proj'){
		$g_data .= 'Proj&nbsp;&nbsp;';
		}
		else if($generaldata->applies_to == 'loc') {
		$g_data .= 'Loc';
		}
		$g_data .= '</li>';
		 } 
		 
		if($generaldata->products_aggr && $generaldata->products_aggr !='0.00' ){ 
		$g_data .= '<li>Products - COMP/OP Aggregate: <span id="greenbolddolor">$ '.number_format($generaldata->products_aggr,2) .'</span></li>';
		 } ?>
		<?php if($generaldata->waiver_sub == 'yes'){ $waiv = 'checked'; $class_waiver_sub = 'styled'; 
		$g_data .= '<li><label>Waiver of Subrogation</label></li>';
		 } 
		if($generaldata->primary_noncontr == 'yes'){ $prim = 'checked'; $class_primary_noncontr = 'styled';
		$g_data .= '<li><label> Primary Non-Contributory</label></li>';
		 } ?>
		<?php if($generaldata->additional_insured == 'yes'){ $add = 'checked'; $class_additional_insured = 'styled';
		$g_data .= '<li><label> List my Company as as "Additional Insured"</label></li>' ;
		 } 
		 if($generaldata->cert_holder == 'yes'){ $cert = 'checked'; $class_cert_holder = 'styled'; 
		$g_data .= '<li><label> MyVendorCenter listed as Cert. Holder</label></li>';
		 } 
		$g_data .= '</ul></td></td></tr></table> ';
	 }
	 	$rfp_aip_data ="SELECT * from #__cam_master_autoinsurance_standards_rfps  WHERE rfpid=".$rfp_id; //validation to status of docs
		$db->Setquery($rfp_aip_data);
		$autodata = $db->loadObject();
		
		if($autodata){  
		$a_data = '<table width="100%" border="0" style="font-size:24px;"><tr><td><strong>Auto Liability</strong></td></tr><tr><td><ul style="list-style-type:none;">';
		 } 
		
		if($autodata->applies_to_any || $autodata->applies_to_owned || $autodata->applies_to_nonowned || $autodata->applies_to_hired || $autodata->applies_to_scheduled){ 
			$a_data .= '<li>Applies To:';
		if($autodata->applies_to_any) 
		$a_data .= 'Any&nbsp;&nbsp; ';
		if($autodata->applies_to_owned)
		$a_data .= 'Owned&nbsp;&nbsp; ';
		if($autodata->applies_to_nonowned)
		$a_data .= 'Non-Owned&nbsp;&nbsp; ';	
		if($autodata->applies_to_hired)
		$a_data .= 'Hired&nbsp;&nbsp; ';	
		if($autodata->applies_to_scheduled)
		$a_data .= 'Scheduled&nbsp;&nbsp; ';	
		$a_data .= '</li>';	
		}
		if($autodata->combined_single && $autodata->combined_single != '0.00'){
			$a_data .= '<li>Combined Single Limit: <span id="greenbolddolor">$ '.number_format($autodata->combined_single,2) .'</span></li>';
		}
		if($autodata->bodily_injusy_person && $autodata->bodily_injusy_person != '0.00'){ 
			$a_data .= '<li>Bodily Injury - Per Person: <span id="greenbolddolor">$ '.number_format($autodata->bodily_injusy_person,2) .'</span></li>';
		}
		if($autodata->bodily_injusy_accident && $autodata->bodily_injusy_accident != '0.00'){ 
			$a_data .= '<li>Bodily Injury - Per Accident: <span id="greenbolddolor">$ '.number_format($autodata->bodily_injusy_accident,2) .'</span></li>';
		}
		if($autodata->property_damage && $autodata->property_damage != '0.00'){ 
			$a_data .= '<li>Property Damage - Per Accident: <span id="greenbolddolor">$ '.number_format($autodata->property_damage,2) .'</span></li>';
		}
		if($autodata->waiver == 'yes'){ 
			$a_data .= '<li><label>Waiver of Subrogation</label></li>';
		}
		if($autodata->primary == 'yes'){
			$a_data .= '<li><label>Primary Non-Contributory</label></li>';
		}
		if($autodata->additional_ins == 'yes'){
			$a_data .= '<li><label>List my Company as as "Additional Insured"</label></li>';
		}
		if($autodata->cert_holder == 'yes'){
			$a_data .= '<li><label>MyVendorCenter listed as Cert. Holder</label></li>';
		}
		if($autodata){ 
		$a_data .= '</ul></td></td></tr></table>';
		 } 
		 
		$rfp_wci_data ="SELECT * from #__cam_master_workers_standards_rfps WHERE rfpid=".$rfp_id; //validation to status of docs
		$db->Setquery($rfp_wci_data);
		$workdata = $db->loadObject();
		if($workdata)
		{
			$w_data = '<table width="100%" border="0" style="font-size:24px;"><tr><td><strong>Worker`s Comp Policy/Employer`s Liability</strong></td></tr><tr><td><ul style="list-style-type:none;">';
		}
		if($workdata->workers_not == 'not'){
			if($workdata->workers_not){
			$w_data .= '<li>Worker`s Comp Exemptions NOT accepted</li>';
			}
			if($workdata->each_accident && $workdata->each_accident != '0.00'){
			$w_data .= '<li>Each Accident: <span id="greenbolddolor">$ '.number_format($workdata->each_accident,2) .'</span></li>';
			}
			if($workdata->disease_policy && $workdata->disease_policy != '0.00'){
			$w_data .= '<li>Desease - Policy Limit: <span id="greenbolddolor">$ '.number_format($workdata->disease_policy,2) .'</span></li>';
			}
			if($workdata->disease_eachemp && $workdata->disease_eachemp != '0.00'){
			$w_data .= '<li>Desease - Each Employee: <span id="greenbolddolor">$ '.number_format($workdata->disease_eachemp,2) .'</span></li>';
			}
			if($workdata->waiver_work == 'yes'){
			$w_data .= '<li>Waiver of Subrogation</li>';
			}
			if($workdata->certholder_work == 'yes'){
			$w_data .= '<li>MyVendorCenter listed as Cert. Holder</li>';
			}
		}
		else if($workdata->workers_not == 'yes'){
			$w_data .= '<li>Worker`s Comp Exemptions accepted<br />WARNING: Worker`s Comp. Exemption Certificates are commonly mistaken for a Worker`s Comp policy. Please be aware that this "exemption" does NOT offer the property manager/association/building owner any form of protection against liability for an injured worker`s loss of wages and/or medical expenses if an on-the-job injury occurs. Consult your legal advisor for your unique situation, as laws vary by jurisdiction.
		</li>';
		}
		if($workdata){ 
		$w_data .= '</ul></td></td></tr></table>';
		 }
		 
		$rfp_umb_data ="SELECT * from #__cam_master_umbrellainsurance_standards_rfps WHERE rfpid=".$rfp_id; //validation to status of docs
		$db->Setquery($rfp_umb_data);
		$umbrelladata = $db->loadObject();
		
		if($umbrelladata)
		{
			$u_data = '<table width="100%" border="0" style="font-size:24px;"><tr><td><strong>Umbrella Liability</strong></td></tr><tr><td><ul style="list-style-type:none;">';
		}
		if($umbrelladata->each_occur && $umbrelladata->each_occur != '0.00'){
			$u_data .= '<li>Each Occurrence: <span id="greenbolddolor">$ '.number_format($umbrelladata->each_occur,2) .'</span></li>';
		}
		if($umbrelladata->aggregate && $umbrelladata->aggregate != '0.00'){
			$u_data .= '<li>Aggregate: <span id="greenbolddolor">$ '.number_format($umbrelladata->aggregate,2) .'</span></li>';
		}
		if($umbrelladata->certholder_umbrella == 'yes'){
			$u_data .= '<li>MyVendorCenter listed as Cert. Holder</li>';
		}
		
		if($umbrelladata){ 
		$u_data .= '</ul></td></td></tr></table>';
		} 
		
		$rfp_pln_data ="SELECT * from #__cam_master_licinsurance_standards_rfps WHERE rfpid=".$rfp_id; //validation to status of docs
		$db->Setquery($rfp_pln_data);
		$licdata = $db->loadObject();	
		
		if($licdata)
		{
			$l_data = '<table width="100%" border="0" style="font-size:24px;"><tr><td><strong>Umbrella Liability</strong></td></tr><tr><td><ul style="list-style-type:none;">';
		}
		if($licdata->professional == 'yes'){
			$l_data .= '<li><label>Professional License</label></li>';
		}
		if($licdata->occupational == 'yes'){
			$l_data .= '<li><label>Occupational License</label></li>';
		}
		if($licdata){ 
		$l_data .= '</ul></td></td></tr></table>';
		}
		//Completed
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
		 $sql_subcat = " SELECT b.req_parentid as main_id, b.req_subparentid as sub_id, a.req_title as sub_title, b.price FROM jos_cam_rfpreq_categories as a , jos_cam_rfpreq_info as b  WHERE a.req_id = b.req_subparentid and b.rfp_id = ".$rfp_id." AND  req_subparentid != 0  group by b.req_subparentid order by b.req_parentid ";
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
		$sql = "SELECT proposedvendorid FROM #__cam_vendor_proposals  WHERE rfpno=".$rfp_id." AND Alt_bid != 'yes'";
		$db->Setquery($sql);
		$vendors_list = $db->loadObjectList();
		
		// To get the basic uploaded files
		$query_basic = "SELECT * FROM #__cam_basicrequest_files WHERE rfpid=".$rfp_id."  ";
		$db->setQuery($query_basic);
		$basefiles = $db->loadObjectList();
		//COmpleted
		
				//$ven_name = str_replace(' ','_',$ven_name);;
		$COM = array();
		for($v=0; $v<count($vendors_list); $v++)
		{
				//code to create folder with vendor name,taxid details
				$user	= JFactory::getUser($vendors_list[$v]->proposedvendorid);
				$db = JFactory::getDBO();
				$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$vendors_list[$v]->proposedvendorid;
				$db->setQuery($sql);
				$tax_id = $db->loadResult();
				$user->name = str_replace(' ','_',$user->name);
				$user->lastname = str_replace(' ','_',$user->lastname);
				$ven_name = $user->name.'_'.$user->lastname.'_'.$tax_id;
				//end of code to create folder with vendor name,taxid details
			    //code to get OLN docs
				$sql = "SELECT OLN_upld_cert FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$OLN = $db->loadResultArray();
				for($a=0; $a<count($OLN); $a++)
				{
					$ext = substr($OLN[$a], -3);
					/* anil_29-09-2011 */
                      $sql = "SELECT OLN_folder_id FROM #__cam_vendor_occupational_license  where OLN_status = 1 AND vendor_id='".$vendors_list[$v]->proposedvendorid."' AND OLN_upld_cert='".$OLN[$a]."'";
		$db->Setquery($sql);
		$OLN_folder_id = $db->loadResult();
					/* anil_29-09-2011 */
					$no=$OLN_folder_id;

					$user	= JFactory::getUser($vendors_list[$v]->proposedvendorid);
					$filename = $OLN[$a];
					$folder_type = JRequest::getVar('folder_type','');
					$aj=$OLN_folder_id;
					$doc_type = 'OLN_'.$aj;
					if($folder_type == 'uploaded_by_CAM')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/doc';
					else if($folder_type == 'uploaded_by_VENDOR')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/assets/images/rfp/Tasks';
					else
					$path = 'vendorcompliances/'.$ven_name.'/'.$doc_type;
					$doc_name = $path."/";
					$OLN[$a] = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/components/com_camassistant/assets/images/download.php?f='.$OLN[$a].'&base='.$doc_name.'">'.$OLN[$a].'</a>';
					/* anil_29-09-2011 */

				}
				$OLN = implode(',',$OLN);
				$COM[$v]['OLN'] = $OLN;

				//code to get PLN docs
				$sql = "SELECT PLN_upld_cert FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$PLN = $db->loadResultArray();
				for($b=0; $b<count($PLN); $b++)
				{
					$ext = substr($PLN[$b], -3);
					/* anil_29-09-2011 */
					 $sql = "SELECT PLN_folder_id FROM #__cam_vendor_professional_license  where PLN_status = 1 AND vendor_id='".$vendors_list[$v]->proposedvendorid."' AND PLN_upld_cert='".$PLN[$b]."'";
		$db->Setquery($sql);
		$PLN_folder_id = $db->loadResult();
					$no=$PLN_folder_id;
					$filename = $PLN[$b];
					$folder_type = JRequest::getVar('folder_type','');
					$ak=$PLN_folder_id;
					$doc_type = 'PLN_'.$ak;
					if($folder_type == 'uploaded_by_CAM')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/doc';
					else if($folder_type == 'uploaded_by_VENDOR')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/assets/images/rfp/Tasks';
					else
					$path = 'vendorcompliances/'.$ven_name.'/'.$doc_type;
					$doc_name = $path."/";
					$PLN[$b] = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/components/com_camassistant/assets/images/download.php?f='.$PLN[$b].'&base='.$doc_name.'">'.$PLN[$b].'</a>';
					/* anil_29-09-2011 */

				}
				$PLN = implode(',',$PLN);
				$COM[$v]['PLN'] = $PLN;

				//code to get GLI docs
				$sql = "SELECT GLI_upld_cert FROM #__cam_vendor_liability_insurence  where GLI_status = 1 AND vendor_id=".$vendors_list[$v]->proposedvendorid;
				$db->Setquery($sql);
				$GLI = $db->loadResultArray();
				for($ad=0; $ad<count($GLI); $ad++)
				{
					$ext = substr($GLI[$ad], -3);
					/* anil_29-09-2011 */
					  $sql = "SELECT GLI_folder_id FROM #__cam_vendor_liability_insurence  where GLI_status = 1 AND vendor_id='".$vendors_list[$v]->proposedvendorid."' AND GLI_upld_cert='".$GLI[$ad]."'";
		$db->Setquery($sql);
		$GLI_folder_id = $db->loadResult();
					$no=$GLI_folder_id;
					$filename = $GLI[$ad];
					$folder_type = JRequest::getVar('folder_type','');
					$al=$GLI_folder_id;
					$doc_type = 'GLI_'.$al;
					if($folder_type == 'uploaded_by_CAM')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/doc';
					else if($folder_type == 'uploaded_by_VENDOR')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/assets/images/rfp/Tasks';
					else
					$path = 'vendorcompliances/'.$ven_name.'/'.$doc_type;
					$doc_name = $path."/";
					$GLI[$ad] = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/components/com_camassistant/assets/images/download.php?f='.$GLI[$ad].'&base='.$doc_name.'">'.$GLI[$ad].'</a>';
					/* anil_29-09-2011 */

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
				for($ae=0; $ae<count($WCI); $ae++)
				{
					$ext = substr($WCI[$ae], -3);
					/* anil_29-09-2011 */
					$sql = "SELECT WCI_folder_id FROM #__cam_vendor_workers_companies_insurance  where WCI_status = 1 AND vendor_id='".$vendors_list[$v]->proposedvendorid."' AND WCI_upld_cert='".$WCI[$ae]."'";
		$db->Setquery($sql);
		$WCI_folder_id = $db->loadResult();
					$no=$WCI_folder_id;
					$filename = $WCI[$ae];
					$folder_type = JRequest::getVar('folder_type','');
					$am=$WCI_folder_id;
					$doc_type = 'WCI_'.$am;
					if($folder_type == 'uploaded_by_CAM')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/doc';
					else if($folder_type == 'uploaded_by_VENDOR')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/assets/images/rfp/Tasks';
					else
					$path = 'vendorcompliances/'.$ven_name.'/'.$doc_type;
					$doc_name = $path."/";
					$WCI[$ae] = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/components/com_camassistant/assets/images/download.php?f='.$WCI[$ae].'&base='.$doc_name.'">'.$WCI[$ae].'</a>';

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
					/* anil_29-09-2011 */
					$filename = $W9;
					$folder_type = JRequest::getVar('folder_type','');
					$doc_type = 'W9';
					if($folder_type == 'uploaded_by_CAM')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/doc';
					else if($folder_type == 'uploaded_by_VENDOR')
					$path = 'http://myvendorcenter.com/live/components/com_camassistant/assets/images/rfp/Tasks';
					else
					$path = 'vendorcompliances/'.$ven_name.'/'.$doc_type;
					$doc_name = $path."/";
					$W9 = '<a style="color:#7AB800; text-decoration:none;" href="http://myvendorcenter.com/live/components/com_camassistant/assets/images/download.php?f='.$W9.'&base='.$doc_name.'">'.$W9.'</a>';
					$COM[$v]['W9'] = $W9;
				}

				//Warranty info files
			$sql = "SELECT warranty_filepath,warranty_file_text,warranty_file_area FROM #__cam_vendor_proposals   where rfpno = ".$rfp_id." AND proposedvendorid=".$vendors_list[$v]->proposedvendorid;

				$db->Setquery($sql);
				$warranty = $db->loadObjectList();
				//echo "<pre>"; print_r($warranty);
				$filename = $warranty[0]->warranty_file_text;
				$warranty_filepath = $warranty[0]->warranty_filepath;
				//print_r($warranty_filepath);
				$warranty_filepath1= explode('/',$warranty_filepath);
				//echo "<pre>"; print_r($warranty_filepath1);
				$cnt = count($warranty_filepath1);
				$dpath = $warranty_filepath1[$cnt-2];
				//print_r($dpath);
				$folder_type = JRequest::getVar('folder_type','');
				$doc_type = 'warranty';
				if($folder_type == 'uploaded_by_CAM')
				$path = JURI::root().'components/com_camassistant/doc';
				else if($folder_type == 'uploaded_by_VENDOR')
				$path = JURI::root().'components/com_camassistant/assets/images/rfp/Tasks';
				else
				$path = 'vendorcompliances/'.$ven_name.'/'.$dpath;
 	 			$doc_name = $path."/";
			    /*echo '<pre>';
				print_r($warranty[0]->warranty_filepath); */
				if($warranty[0]->warranty_filepath != '')
				{
				$COM[$v]['WARRANTY'] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index2.php?option=com_camassistant&controller=proposals&task=downloadfile&title='.$warranty[0]->warranty_file_text.'&path='.$warranty_filepath.'">'.$warranty[0]->warranty_file_text.'</a>';
				// $COM[$v]['WARRANTY'] = '<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'components/com_camassistant/assets/images/download.php?f='.$warranty[0]->warranty_file_text.'&base='.$doc_name.'">'.$warranty[0]->warranty_file_text.'</a>';

				}
				else if($warranty[0]->warranty_file_text != '' && $warranty[0]->warranty_filepath == '')
				{$COM[$v]['WARRANTY'] = $warranty[0]->warranty_file_text;}
				else
				$COM[$v]['WARRANTY'] = 'nofiles';

				if($warranty[0]->warranty_file_area != '')
				{
				$COM[$v]['WARRANTYtext'] = $warranty[0]->warranty_file_area;
				}
				else{
				$COM[$v]['WARRANTYtext'] = 'No text entered. If no attachment is provided, please contact vendor.';
				}
		 }

		/////CODE FOR GENERATING PDF FILE	////

	ob_end_clean();
	require_once('libraries/tcpdf/config/lang/eng.php');
	require_once('libraries/tcpdf/tcpdf.php');
	require_once ( JPATH_BASE .DS.'tcpdfclass.php' );

      /*********************** COPY PDF  ********************************/

		 $dest = JPATH_BASE .DS.'PropertyDocuments'.DS.$moveproperty_name.DS.'ProposalReports'.DS.'RFP'.$rfpid.DS;
		//move_uploaded_file($title,
		//JPATH_BASE .DS.$title; echo "<br/>";
		//$dest.$title;
             // echo $title;  
                 if (!is_dir($dest)) {
                @mkdir($dest,0777);
                }
		$copied = @copy(JPATH_BASE .DS.$title,$dest.$title);
							if($copied){
                                                           
							unlink($title);
							}



	} // generatepdf($rfpid) function end

	}


}
?>
