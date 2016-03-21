<?php
class MYPDF extends TCPDF {
	// Page footer
	
	public function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15); 
		// Page number
		$this->SetFontSize(8);
			if($this->pageno){
		//$page=(int)$this->getAliasNumPage();
		$this->Cell(208, 0, 'Proposal Report Page '.$this->getPageNumGroupAlias().' of '.$this->getPageGroupAlias(), 0, 2, 'C'); 
}$this->pageno=$this->pageno+1;
		$this->SetFontSize(7);
		$this->Cell(0, 5, 'Copyright 2012-2013 HOA Assistant, LLC', 0, 0, 'C');
	}

	public function Header() {
		// Position at 1.5 cm from top
		$this->SetY(-15);
	}
}

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

	//$pdf->SetFont('dejavusans', '', 10);// set font
	$pdf->AddPage(); // add a page
	// Your custom code here
	JHTML::_('behavior.modal');
	$from = JRequest::getVar('from','');
	$document =& JFactory::getDocument();
	$document->addStyleSheet('templates/camassistant_left/css/style.css');
	$RFP_info = $RFP_details[0];
	//echo "<pre>"; print_r($RFP_info); echo $RFP_info->id; exit;
	$RFP_info->id = sprintf('%06d', $RFP_info->id);
	//echo '<pre>'; print_r($RFP_info); exit;
	$BID_info = $Bid_info[0];
	//echo '<pre>'; print_r($BID_info); exit;
	$BID_Vendors_info = $Bid_vendors;
 	$RFP_details_inhouse1 = $RFP_details_inhouse1;

	//calculation to no of pages iteration in pdf
	$remainder = count($BID_Vendors_info)%3;
	$quotient = intval(count($BID_Vendors_info)/3);
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
	//$pdf->SetFont('dejavusans', '', 12);
	//Image Quality
	$pdf->setJPEGQuality(200);
	// add a page
	$pdf->AddPage();
	$pat = JPATH_SITE.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS;


	$db = JFactory::getDBO();
	$state="SELECT state_name FROM #__state where id='".$RFP_info->comp_state."'";
	$db->Setquery($state);
	$state_name = $db->loadResult();

	$ind_solicited ="SELECT industry_name FROM #__cam_industries where id='".$RFP_info->industry_id."'";
	$db->Setquery($ind_solicited);
	$ind_solicited = $db->loadResult();

	$altproposals_submitted="SELECT count(*) FROM #__cam_vendor_proposals where rfpno='".$RFP_info->id."' AND (proposaltype='Submit' or proposaltype='resubmit') AND Alt_bid='yes'";
	$db->Setquery($altproposals_submitted);
	$altproposals_submitted = $db->loadResult();

	//$RFP_info->work_perform = explode(',',$RFP_info->work_perform,2) ;
	//$RFP_info->work_perform = $RFP_info->work_perform[0].'<br />'.$RFP_info->work_perform[1];


$db = JFactory::getDBO();
		$namef = "SELECT name,lastname FROM #__users where id=".$RFP_info->cust_id;
		$db->Setquery($namef);
		$namelast = $db->loadObjectlist();
		$fullname=$namelast[0]->name.' '.$namelast[0]->lastname;

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
		$imagefilename = $pat.'properymanager/'.$RFP_info->comp_logopath;
		/* anil_27-08-2011 */
		$apath=getimagesize($imagefilename);
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
		/* anil_27-08-2011 */
				$getpid = "SELECT U.property_manager_id,U.property_name FROM #__cam_rfpinfo as V, #__cam_property as U where V.id=".$RFP_info->id." AND U.id=V.property_id";
				$db->Setquery($getpid);
				$userid_p = $db->loadObject();

		$namef = "SELECT name,lastname FROM #__users where id=".$RFP_info->cust_id;
		$db->Setquery($namef);
		$manager_name = $db->loadObject();


		if (!file_exists($imagefilename)) {
   $RFP_info->comp_logopath = 'noimage2.gif';
   } // End checking whether the file exists in the path or not anil_16-08-2011
if($RFP_info->bidding == 'open' || $RFP_info->bidding == ''){
		$htmlcontent9 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>';
  $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/top_border.jpg', 0, 7, 1000, 2, "", "", "", true, 550,'', false, false, 0, false, false, false);
  $htmlcontent9 .= '</td></tr>
    </table>
  <tr>
    <td><table width="100%" height="106" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%" align="left" valign="top">';
		$pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 18, 20, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);

		$htmlcontent9 .= '</td><td width="10%" align="center" valign="top"><img src="templates/camassistant_left/images/line.png" height="110" /></td>
        <td width="70%" align="left" valign="top">
		<span style="font-size:35px; color:#707070; line-height:4px;"><strong>PROPOSAL REPORT</strong></span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$RFP_info->comp_name.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$manager_name->name.' '.$manager_name->lastname.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.str_replace('_',' ',$userid_p->property_name).'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">RFP#: '.$RFP_info->id.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$RFP_info->projectName.'</span><br />
		
        </td>
      </tr>
    </table></td>
  </tr>
  <tr><td>';
  $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/line_hori.jpg', 0, 57, 1000, 10, "", "", "", true, 550,'', false, false, 0, false, false, false);
  $htmlcontent9 .= '</td></tr>
  <tr style="border-top:2px solid green;">
    <td><p style="font-size:31px; color:#85c440; font-weight:bold; padding:95px 0px 15px 0px; margin:0px;"><br /><br />ABOUT THIS REPORT</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">This comprehensive report includes all of the participating vendors and their responses, based on the identical scope of work provided to each company.  The first page of the report includes an easy-to-read comparison of the more essential items related to each vendor, including contact information, compliance status, and proposal pricing.  The second page includes a breakdown of each vendor`s price, line-item by line-item. Following the second page are complete responses to the scope of work provided, including the vendor`s recommended solution, warranties, and attached documents (if applicable)..</p>
</td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">PROTECTING THE COMMUNITY</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Each and every vendor who submitted a quote for this request has met, or exceeded, the predetermined minimum requirements for insurance and licensing (if applicable). Supporting documents (insurance policies, licenses, etc.) are provided in the digital version of the entire proposal report. In addition, every vendor within this report has an "apple rating" that is based on the quality of their work and customer service with other communities. This should help increase the likelihood of hiring the best contractor at the best possible price.</p></td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">UNDERSTANDING A VENDOR`S PRICE</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Vendor pricing can vary greatly, even when compared "apples-to-apples". Some of the many reasons for varying quotes include acquisition fees, insurances, employee benefits, sales commissions, warranties, capital equipment, quality of workforce and materials, experience of estimators, and profit margin. Multiple bids through a competitive bidding process is an important part of the solution to finding the right vendor for the job.</p></td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">STAYING ORGANIZED</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Any information related to this report has been digitally recorded for future reference or use.  All related materials will be available for review in case a re-bid, punch-out list, warranty request, or dispute regarding the final product or service with a hired vendor is required.</p></td>
  </tr>
   <tr>
  <td><p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#1b4164;"><br><br><br><br><br>THIS IS NOT A SEALED BID. ALL PRICES WERE VISIBLE UPON BID SUBMISSION FROM VENDORS.</p></td></tr>
  
 </table>
';
}
else{
		$htmlcontent9 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>';
  $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/top_border.jpg', 0, 7, 1000, 2, "", "", "", true, 550,'', false, false, 0, false, false, false);
  $htmlcontent9 .= '</td></tr>
    </table>
  <tr>
    <td><table width="100%" height="106" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%" align="left" valign="top">';
		$pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 18, 20, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);

		$htmlcontent9 .= '</td><td width="10%" align="center" valign="top"><img src="templates/camassistant_left/images/line.png" height="110" /></td>
        <td width="70%" align="left" valign="top">
		<span style="font-size:35px; color:#707070; line-height:4px;"><strong>PROPOSAL REPORT</strong></span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$RFP_info->comp_name.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$manager_name->name.' '.$manager_name->lastname.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.str_replace('_',' ',$userid_p->property_name).'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">RFP#: '.$RFP_info->id.'</span><br />
		<span style="font-size:28px; color:#707070; line-height:4px;">'.$RFP_info->projectName.'</span><br />
		
        </td>
      </tr>
    </table></td>
  </tr>
  <tr><td>';
  $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/line_hori.jpg', 0, 57, 1000, 10, "", "", "", true, 550,'', false, false, 0, false, false, false);
  $htmlcontent9 .= '</td></tr>
  <tr style="border-top:2px solid green;">
    <td><p style="font-size:31px; color:#85c440; font-weight:bold; padding:95px 0px 15px 0px; margin:0px;"><br /><br />ABOUT THIS REPORT</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">This comprehensive report includes all of the participating vendors and their responses, based on the identical scope of work provided to each company.  The first page of the report includes an easy-to-read comparison of the more essential items related to each vendor, including contact information, compliance status, and proposal pricing.  The second page includes a breakdown of each vendor`s price, line-item by line-item. Following the second page are complete responses to the scope of work provided, including the vendor`s recommended solution, warranties, and attached documents (if applicable)..</p>
</td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">PROTECTING THE COMMUNITY</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Each and every vendor who submitted a quote for this request has met, or exceeded, the predetermined minimum requirements for insurance and licensing (if applicable). Supporting documents (insurance policies, licenses, etc.) are provided in the digital version of the entire proposal report. In addition, every vendor within this report has an "apple rating" that is based on the quality of their work and customer service with other communities. This should help increase the likelihood of hiring the best contractor at the best possible price.</p></td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">UNDERSTANDING A VENDOR`S PRICE</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Vendor pricing can vary greatly, even when compared "apples-to-apples". Some of the many reasons for varying quotes include acquisition fees, insurances, employee benefits, sales commissions, warranties, capital equipment, quality of workforce and materials, experience of estimators, and profit margin. Multiple bids through a competitive bidding process is an important part of the solution to finding the right vendor for the job.</p></td>
  </tr>
  <tr>
    <td>
    <p style="font-size:31px; font-weight:bold; padding:33px 0px 10px 0px; margin:0px; color:#85c440;">STAYING ORGANIZED</p></td>
  </tr>
  <tr>
    <td><p style="font-size:25px; line-height:5px; padding:0px; margin:0px; color:#707070">Any information related to this report has been digitally recorded for future reference or use.  All related materials will be available for review in case a re-bid, punch-out list, warranty request, or dispute regarding the final product or service with a hired vendor is required.</p></td>
  </tr>
   
  
 </table>
';
}
			$pdf->writeHTML($htmlcontent9, true, 0, true, 0);
		$pdf->startPageGroup();
	$pdf->AddPage();

	 $cnt=count($BID_Vendors_info);
   if($cnt>0)
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

if (!file_exists($imagefilename)) {
   $RFP_info->comp_logopath = 'noimage2.gif';
   } // End checking whether the file exists in the path or not anil_16-08-2011

		$htmlcontent = '<table width="635" border="0" cellspacing="0" cellpadding="1" align="center" style="padding-top:0px; font-family:arial; ">';
//$width = 75;
//$height = 15;
              //  echo '<pre>'; print_r($RFP_info);
						$pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
		$htmlcontent .= '<tr><td width="245px" height="50" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:23px;"><img width="50" height="14" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')&nbsp;'.$com_phone[1].'-'.$com_phone[2].'</td></tr>

						<br/><tr style="font-size:30px;">
							<td colspan="4" align="center"><strong>'.$RFP_info->projectName.'</strong><br />
							<strong>'.str_replace('_',' ',$RFP_info->property_name).' &nbsp;&nbsp;|&nbsp;&nbsp; RFP #'.$RFP_info->id.'</strong></td>
						 </tr>
						<br/>
						<tr style="font-size:23px;">';
//$workperform=explode(' ',$RFP_info->work_perform);
//echo '<pre>'; print_r($RFP_info->work_perform);
						if( $RFP_info->jobtype == 'yes' ){
						$htmlcontent .='<td align="left" width="290px;" ><br />Closed On<strong>: '.$RFP_info->proposalDueDate.'</strong><br />Proposals Submitted<strong>: '.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted<strong>: '.$altproposals_submitted.'</strong></td>';
						}
						else{
						$htmlcontent .='<td align="left" width="290px;" ><br />Industry Solicited<strong>: '.$ind_solicited.'</strong><br />Service Location<strong>: '.$RFP_info->work_perform.'</strong></td>';
						}
						if( $RFP_info->jobtype != 'yes' ){
                        $htmlcontent .='<td  style="text-align:left;" width="150px;"><br />Closed On<strong>: '.$RFP_info->proposalDueDate.'</strong><br />Proposals Submitted<strong>: '.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted<strong>: '.$altproposals_submitted.'</strong></td>';
						}
						else{
						$htmlcontent .='<td  style="text-align:left;" width="150px;"></td>';
						}
						
                        $htmlcontent .='<td align="right" style="text-align:left;" width="120px;"><br />High Bid<strong>: $'.$Max_bid.'</strong><br />Low Bid  <strong>: $'.$Min_bid.'</strong><br />Average Bid <strong>: $'.$Avg_bid.'</strong>	</td>


						</tr>
		<tr style="height:4px;"><td align="left" colspan="2" style="font-size:5px;"></td></tr>';
		/***eof table pan****/

		/**** sof table pan****/
			$htmlcontent .= '<tr><td width="140" align="left"><table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td align="center" bgcolor="gray" style="border:0.5px solid #b7b7b7;" height="14"><p style="font-size:26px;  color:#FFF; font-weight:bold;">DESCRIPTION</p></td></tr> <tr><td align="center" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:60px;"><p style="font-size:26px;color:#000; font-weight:bold;"><br/><br/></p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:36px;"><p style="font-size:26px;  color:#000; font-weight:bold;"><br>Company Name:</p></td></tr><tr><td align="center" valign="middle" height="48"><p><font style="font-size:26px;font-family:ArialBlack; color:#000; font-weight:bold;">Vendor Apple Rating:</font><br/><font style="font-size:24px;color:#000;">(Based on customer surveys & vendor follow through)</font></p></td></tr><tr valign="middle" cellpadding-top="20">
			<td align="center" valign="middle" bgcolor="#f3f9e8" height="45px" style="border:0.5px solid #b7b7b7; font-family:ArialBlack;"><div style="font-size:26px;  color:#000; font-weight:bold;"><br>Vendor Address:</div></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:15px;"><p style="font-size:26px;  color:#000; font-weight:bold;">Contact Name:</p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:26px;  color:#000; font-weight:bold;">Office Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:16px; "><p style="font-size:26px;  color:#000; font-weight:bold;">Alt.Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px; " bgcolor="#f3f9e8"><p style="font-size:26px;  color:#000; font-weight:bold;"
>Mobile Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:36px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/>Email Address:</p></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:26px; color:#000; font-weight:bold;">Business Established:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:15px; "><p style="font-size:26px; font-weight:bold; color:#000;">General Liability:</p></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:25px;"><table cellpadding="3" cellspacing="1"><tr><td style="font-size:26px; font-family:Arial Black; color:#000; font-weight:bold;">Workers Comp. Policy?</td></tr></table></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:24px; color:#000; font-weight:bold;">Meets Compliance Standards?</p></td></tr><tr>
<td align="center" valign="middle" style="border:0.5px solid #b7b7b7; height:45px;"><p><font style="font-size:26px; font-family:ArialBlack; color:#000;font-weight:bold;">In-House Vendor?</font><br/><font style="font-size:25px;color:#000;">(Vendor affiliated with management company)</font></p></td></tr><tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:23px;"><table cellpadding="3" cellspacing="2"><tr><td style="font-size:21px; font-family:Arial Black; color:#fff; font-weight:bold;">TOTAL AMOUNT PROPOSED:</td></tr></table></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:17px;"><p style="font-size:26px; color:#000; font-weight:bold;">Alternate Proposal?</p></td></tr></table></td>';
							 // $cnt=count($BID_Vendors_info);
							  if($cnt>0)
							  {
							  for($v=(3*$loop_start); $v<(3*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$htmlcontent .=  '<td width="140" align="left">';
								} else if($remainder == 1){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 2){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 3){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 0){
			$htmlcontent .=  '<td width="100%" align="left">';
								}
			$htmlcontent .=   '<table width="100%" border="0" cellspacing="2" cellpadding="2">';
							  if($v%2 == 0)
							  //$class = "#21314d";
                                                           $class = "#7ab800";
							  else
							  $class = "#7ab800";
							  $vid = $v+1;
							if($BID_Vendors_info[$v]->contact_name){
							  $BID_Vendors_info[$v]->company_name=$BID_Vendors_info[$v]->company_name;
							  } else {
							  $BID_Vendors_info[$v]->company_name=$BID_Vendors_info[$v]->company_name;
							  }
							  if($BID_Vendors_info[$v]->company_name == '')
							  $BID_Vendors_info[$v]->company_name = '---';
			$htmlcontent .= '<tr valign="middle"><td bgcolor="'.$class.'" align="center" height="14px" style="border:0.5px solid #b7b7b7;"><p style="color:#FFF; font-size:26px; font-weight:bold;">VENDOR '.$vid.'</p></td></tr>';
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
                                                         //echo '<pre>'; print_r( $BID_Vendors_info[$v]);
       if($BID_Vendors_info[$v]->company_phone!='' && $BID_Vendors_info[$v]->company_phone!='--' ){
	$BID_Vendors_info[$v]->company_phone = explode('-',$BID_Vendors_info[$v]->company_phone) ;
	$BID_Vendors_info[$v]->company_phone = '('.$BID_Vendors_info[$v]->company_phone[0].') '.$BID_Vendors_info[$v]->company_phone[1].'-'.$BID_Vendors_info[$v]->company_phone[2];
         } else {
            $BID_Vendors_info[$v]->company_phone='N/A';
        }
	$altphone = "Alt.Phone: ";
	$altphoneext = "Alt.Extension: ";
        if($BID_Vendors_info[$v]->alt_phone!='' && $BID_Vendors_info[$v]->alt_phone!='--' ){
	$BID_Vendors_info[$v]->alt_phone = explode('-',$BID_Vendors_info[$v]->alt_phone) ;
	$BID_Vendors_info[$v]->alt_phone = '('.$BID_Vendors_info[$v]->alt_phone[0].') '.$BID_Vendors_info[$v]->alt_phone[1].'-'.$BID_Vendors_info[$v]->alt_phone[2];
        } else {
            $BID_Vendors_info[$v]->alt_phone='N/A';
        }
	//$cellphone = "Mobile Phone: ";

          if($BID_Vendors_info[$v]->cellphone!='' && $BID_Vendors_info[$v]->cellphone!='--'){
	$BID_Vendors_info[$v]->cellphone = explode('-',$BID_Vendors_info[$v]->cellphone) ;
         //echo '<pre>'; print_r($BID_Vendors_info[$v]->cellphone);
         if(count($BID_Vendors_info[$v]->cellphone)>1){
	$BID_Vendors_info[$v]->cellphone = '('.$BID_Vendors_info[$v]->cellphone[0].') '.$BID_Vendors_info[$v]->cellphone[1].'-'.$BID_Vendors_info[$v]->cellphone[2];
        } else {
            $BID_Vendors_info[$v]->cellphone = $BID_Vendors_info[$v]->cellphone;
         }
           } else {
            $BID_Vendors_info[$v]->cellphone='N/A';
        }
        //echo '<pre>'; print_r($BID_Vendors_info[$v]->cellphone);
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
	//echo '<pre>'; print_r($BID_Vendors_info[$v]);
	//echo "<pre>"; print_r($BID_Vendors_info[$v]->company_phone); exit;
	//echo $image; exit;
		$rateimage= '/var/www/vhosts/myvendorcenter.com/httpdocs/'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rating'.DS;
			$db = JFactory::getDBO();
			$rating = "SELECT rating_sum FROM #__content_rating where content_id =".$BID_Vendors_info[$v]->proposedvendorid;
			$db->Setquery($rating);
			$rating = $db->loadResult();
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}

			$len = strlen($BID_Vendors_info[$v]->email);
							if($len>25) {
							$mail = explode('@',$BID_Vendors_info[$v]->email);
							$clearemail = $mail[0].'@<br>'.$mail[1];
							 }
							 else{
							$clearemail = $BID_Vendors_info[$v]->email;
							 }

			//print_r($rate_image); exit;
			$htmlcontent .= '<tr><td align="center" valign="middle" style="height:60px; border:0.5px solid #b7b7b7;" ><table cellpadding="0" cellspacing="1"><tr><td><img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$image.'"  /> </td></tr></table> </td></tr>';
			$htmlcontent .= '<tr valign="baseline"><td height="36" valign="middle" align="center" bgcolor="#f3f9e8" style="font-size:24px ; text-align: center; border:0.5px solid #b7b7b7;  vertical-align:middle"><br/><br/>'.$BID_Vendors_info[$v]->company_name.'</td></tr>';
			/*  '.$rating=plgVotitaly($BID_Vendors_info[$v]->proposedvendorid,$limitstart).' */
			/* <img src="templates/camassistant_left/images/rating.gif" width="75" height="15" /> */
                        if($rating!=''){
                            $rating=$rating;
                        } else {
                            $rating='4';
                        }
						if($BID_Vendors_info[$v]->contact_name){
							  $full_contactname = $BID_Vendors_info[$v]->contact_name;
							  } else {
							  $full_contactname = $BID_Vendors_info[$v]->name.' '.$BID_Vendors_info[$v]->lastname;
							  }
			$htmlcontent .= '<tr valign="middle"><td border="0" valign="middle" style="font-size:24px; text-align: center; height:48px;"><br/><br/>

			<img src="'.$rate_image.'" /><br/>'.$rating .' Out of 5</td></tr>
							<tr><td height="45" valign="middle" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->company_address.',<br />'.$BID_Vendors_info[$v]->city.',<br />'.$vstate.' '.$BID_Vendors_info[$v]->zipcode.'</td>  </tr><tr><td height="15" style="font-size:24px ;text-align: center; border:0.5px solid #b7b7b7; ">'.$full_contactname.'</td></tr>';


						$htmlcontent .= '<tr><td valign="middle" height="16" bgcolor="#f3f9e8" style="font-size:24px; text-align: center; border:0.5px solid #b7b7b7; ">'. $BID_Vendors_info[$v]->company_phone.'</td></tr>';


							$htmlcontent .= '<tr><td valign="middle" height="16" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->alt_phone.'</td>  </tr>';

			 $htmlcontent .= '<tr><td height="16" valign="middle" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->cellphone.'</td></tr><tr><td height="36" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; "><br/><br/>'.$clearemail.'</td></tr><tr><td height="16" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center;">'.$BID_Vendors_info[$v]->established_year.'</td></tr>';

                          $sql = "SELECT sum(GLI_policy_aggregate) FROM #__cam_vendor_liability_insurence WHERE GLI_end_date>='".$today."'and GLI_status = 1 AND vendor_id=".$BID_Vendors_info[$v]->proposedvendorid;
			  $db->Setquery($sql);
			$amount = $db->loadResult();
                         $amount = number_format($amount);
                        if($amount!=''){
                            $amount=$amount;
                        } else {
                            $amount='N/A';
                        }

                         $htmlcontent .= '<tr><td height="15" valign="middle" style="font-size:26px;text-align: center; border:0.5px solid #b7b7b7;  font-weight:bold; ">$'.$amount.'</td></tr>';

                          $sql2 = "SELECT excemption FROM #__cam_vendor_workers_companies_insurance WHERE WCI_status = 1 AND WCI_upld_cert!='' AND vendor_id=".$BID_Vendors_info[$v]->proposedvendorid;
                        $db->Setquery($sql2);
                        $WCI = $db->loadResultArray();

                        if($WCI)
                        {
                            if(in_array('1',$WCI)){

                            $onfile = '<font style="color:red; font-size:26px;">Exemption Only<font style="color:#ff6264; font-size:35px;" valign="middile">**</font></font>';
                            $wcresult[]='yes';
                            }  else { $onfile = '<font style="color:green; font-size:26px;" cellpadding="5">Yes<font style="font-size:35px;" valign="middile"> </font></font>';
							$wcresult[]='';
                            }
                	}
                        else if($WCI=''){
                            $onfile = '<font style="color:green; font-size:26px;">Yes<font style="font-size:35px;" valign="middile"> </font></font>';
							$wcresult[]='';
                        } else {
                        $onfile = '<font style="color:red; font-size:26px;">No<font style="font-size:35px;" valign="middile"> </font></font>';
						$wcresult[]='';
                        }
                       // echo '<pre>'; print_r($onfile);     exit;
					   
$log = new checkstatus();
$master	=	$log->getmasterfirmaccount($RFP_info->cust_id);

$checkglobal	=	$log->checkglobalstandards($RFP_info->id,$master);
	if( $checkglobal == 'success' )	{
		$totalprefers_new_gli	=	$log->checknewspecialrequirements_gli($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_aip	=	$log->checknewspecialrequirements_aip($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_wci	=	$log->checknewspecialrequirements_wci($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_umb	=	$log->checknewspecialrequirements_umb($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_pln	=	$log->checknewspecialrequirements_pln($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_occ	=	$log->checknewspecialrequirements_occ($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		/*if($BID_Vendors_info[$v]->proposedvendorid == '1806'){
		echo "FIRM: ".$total_managers[$t]->cust_id."<br />".$preferred[$v]->id.'<br /><br />';
				echo $totalprefers_new_gli."<br />" ;
				echo $totalprefers_new_aip."<br />" ;
				echo $totalprefers_new_wci."<br />" ;
				echo $totalprefers_new_umb."<br />" ;
				echo $totalprefers_new_pln."<br />" ;
			}	*/
			if($totalprefers_new_gli == 'success' && $totalprefers_new_aip == 'success' && $totalprefers_new_wci == 'success' && $totalprefers_new_umb == 'success' && $totalprefers_new_pln == 'success' && $totalprefers_new_occ == 'success' )
				{
					$db =& JFactory::getDBO();
					$sql_terms = "SELECT termsconditions FROM #__cam_vendor_aboutus WHERE vendorid=".$master." "; 
					$db->setQuery($sql_terms);
					$terms_exist = $db->loadResult();
				if($terms_exist == '1'){
					$sql = "SELECT accepted FROM #__cam_vendor_terms WHERE masterid=".$master." and vendorid=".$BID_Vendors_info[$v]->proposedvendorid." ";
					$db->setQuery($sql);
					$terms = $db->loadResult();
					
						if($terms == '1'){
						$color_stand = 'green' ;
						$standards = "<span style='color:green; font-weight:bold;'>Yes</span>";
						}
						else {
						$color_stand = 'red' ;
						$standards = "<span style='color:#ff6264; font-weight:bold;'>No</span>";
						}
					}
					else{
						$color_stand = 'green' ;
						$standards = "<span style='color:green; font-weight:bold;'>Yes</span>";
					}	
					
				}
				else
				{
					$color_stand = 'red' ;
					$standards = "<span style='color:#ff6264; font-weight:bold;'>No</span>";
				}	
	}			
					  else{
					    $color_stand = '' ;
						$standards = "<span>N/A</span>";
					  } 
if( $RFP_info->jobtype == 'yes' ){							
	$standards = $BID_Vendors_info[$v]->c_status;
	$color_stand = '';
}
else{
	$standards = $standards ;
	$color_stand = $color_stand ;
}
					   
                         $htmlcontent .= '<tr><td height="10" bgcolor="#f3f9e8" valign="middile" style="border:0.5px solid #b7b7b7;  font-weight:bold; text-align:center; "><table cellpadding="2" cellspacing="1"><tr><td>'.$onfile.'</td></tr></table></td></tr><tr><td height="16" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7; text-align: center; font-weight:bold; color:'.$color_stand.'">'.$standards.'</td></tr><tr><td height="45" style="font-size:26px; border:0.5px solid #b7b7b7;  text-align: center; "><br/><br/>'.$RFP_details_inhouse1.'</td></tr>';

							$class = "color:#21314d; font-size:24px;  font-family:ArialBlack; text-align: center; ";

			/* $addexp_star="SELECT add_exception FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and Alt_bid!='yes' ";
                        $db->Setquery($addexp_star);
			$star = $db->loadResult();


							if($star == '' || $star == 'None' || $star_final=='(list all exceptions here)'){
							$as = '';
							 $footer_note[] = '';
							}
							else{
							 $as = '<font color="#ff6264">* </font>';
							  $footer_note[] = 'yes';
							}*/

//Changed by sateesh
$addexpr="SELECT count(add_exception) FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and add_exception!='(list all exceptions here)' and check_exception='on' and Alt_bid!='yes' ";
							$db->Setquery($addexpr);
							$star_final = $db->loadResult();
                                                    if($star_final) {
							$as = '<font color="#ff6264">* </font>';
                             $footer_note[] = 'yes';
							}
							else{
							$as = '';
							$footer_note[] = '';
							}
//Completed

							if ($star_final >'0'){
							$BID_Vendors_info[$v]->proposal_total_price = $BID_Vendors_info[$v]->proposal_total_price.'<font style="color:#FF0000; font-family:ArialBlack; font-size:53px">'.$as.'</font>';
							}
		  $htmlcontent .= '<tr><td height="23" valign="middle" bgcolor="#21314d" style="'.$class.'; border:0.5px solid #b7b7b7; font-size:42px; font-weight:bold; font-family:ArialBlack; color:#fff;">$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr>';
							$db = JFactory::getDBO();
							$sql = "SELECT proposal_total_price FROM #__cam_vendor_proposals where Alt_bid = 'yes' AND rfpno = ".sprintf('%d', $RFP_info->id)." AND proposaltype = 'Submit' AND proposedvendorid =".$BID_Vendors_info[$v]->proposedvendorid;
							$db->Setquery($sql);
							$Alt_Price = $db->loadResult();
							//if($Alt_Price != '')
							//{$res = 'Yes'; } else $res = 'No';
			/*$htmlcontent .=  '<tr><td height="15" style="font-size:19px ;text-align: center; color:#464646;   font-family:ArialBlack;">'.$res.'</td></tr>';*/
			if($Alt_Price != '')
			$Alt_Price = number_format( $Alt_Price ,2,'.',',' );
			//echo '<pre>'; print_r($Alt_Price);
			if($Alt_Price != '') $Alt_Price = '$'.$Alt_Price; else $Alt_Price = 'No';
			$htmlcontent .= '<tr><td height="17" valign="middle" style="font-size:30px; border:0.5px solid #b7b7b7; font-weight:bold; text-align: center; color:#000; font-family:ArialBlack;">'.$Alt_Price.'</td>
		  </tr>';
			$htmlcontent .= '</table></td>';
								}//inner if loop
							  }//end for loop
							 }//if loop
							 //exit;
			//$htmlcontent .= '</tr></table></td></tr></table>';
                        $htmlcontent .= '</tr>';
if(in_array('yes',$footer_note)){
			$htmlcontent .= '<tr><td align="left" vaign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star.png" /> Designates exception for 1 or more line items. Please see vendor notes for details.</td></tr>';
}
   //echo '<pre>'; print_r($wcresult);


         if(in_array('yes',$wcresult)){

                           $htmlcontent .= '<tr><td align="left" valign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star-two.png" /> A certificate of exemption from the state is on file,however there is no actual policy in place to protect the community from liability in the event that a subcontractor is injured on the job(including claims for lost wages)</td></tr>';
}
                    //  $htmlcontent .= '<tr><td align="right" colspan="4"><a href="'.JURI::root().'index.php?option=com_camassistant&controller=rfpcenter&task=closedrfp&Itemid=89" target="_blank"><img src="'.JURI::root().'components/com_camassistant/assets/images/award-bg.jpg" target="_blank"/></a> </td></tr>';
                           $htmlcontent .= '</table>';
			//}

			$style = array('color' => array(220, 220, 220));
			$style7 = array('width' => 0.1, 'color' => array(220, 220, 220));
			$pdf->SetLineStyle($style7);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0);
		
		// add a page
		//$pdf->AddPage();
	    //echo $htmlcontent;
		if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
		/******************************  End of 4th Page TASKS SUMMARY ***************************************************/
     } //exit; //end - for($loop_start=0, $loop_stop=1; $loop_start<count($BID_Vendors_info); $loop_start++,$loop_stop++)

		//$pdf->AddPage();
		$TASKS_summary = $TASK_detailsn;
		//echo "<pre>"; print_r($TASKS_summary); exit;
		$DOCS_summary = $DOCS_details;
		$NOTES_summary = $NOTES_details;

		$ALTNOTES_summary = $ALTNOTES_details;

		$EXCEPTION_summary = $EXCEPTION_details;
		$RFP_NOTES_summary = $tasks_list;
		$vendors_cnt = $vendor_ids;

               // echo '<pre>'; print_r($this->RFP_NOTES_summary); exit;
             if(count($RFP_NOTES_summary)>1){
$pdf->AddPage();
$total = count($BID_Vendors_info);
$remainder = $total%3;
	 $quotient = intval($total/3);

$filename = $pat.'properymanager/'.$RFP_info->comp_logopath;
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
	if($remainder == 0)
	$loop_iterator = $quotient;
	else
	$loop_iterator = $quotient+1;

 for($loop_start=0, $loop_stop=1; $loop_start<$loop_iterator; $loop_start++,$loop_stop++)
    {
$lineitemprice='
<table width="630" border="0" cellspacing="0" cellpadding="0">


      <tr>
        <td width="36%">'; $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
      $lineitemprice.='  </td>

	<td width="315px" style="text-align: right; font-size:24px;"><img width="50" height="14" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')&nbsp;'.$com_phone[1].'-'.$com_phone[2].'</td></tr>

 <tr><td></td></tr><br/>
  <tr>
   <td height="20" width="88.5%" align="center" style="font-size:30px;  font-family:Arial; font-weight:bold;"><table border="0" align="center" cellspacing="2" cellpadding="2"><tr><td align="center" style="text-align:center;">
<div>ITEMIZED PRICING BREAKDOWN</div>
   </td></tr> </table></td>
  </tr><tr><td width="140" align="left" valign="middle"><table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; height:15px;"><p style="font-size:25px; font-weight:bold; color:#FFF;">DESCRIPTION</p></td></tr> <tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:60px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/><br/></p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:40px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/>Company Name:</p></td></tr>';
  $line_cnt=count($RFP_NOTES_summary);
							 if($line_cnt>0)
							 {
							 for($li=0; $li<$line_cnt; $li++)
							 {
                                                                       //echo '<pre>'; print_r($RFP_NOTES_summary[$li]);
									 $cnt_Task_Prices = count($RFP_NOTES_summary[$li]->task_id);
									 for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
									  	//echo '<pre>'; print_r($RFP_NOTES_summary[$li]);
										  $lineitemprice .= ' <tr> <td align="center" height="59" valign="middle" style="border:0.5px solid #b7b7b7;"><br/><font style="font-size:26px;  font-family:Arial; font-weight:bold; color:#000;">Line Item #'.($li+1).' Pricing:</font> <font style="font-size:26px; font-family:Arial;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr>';


									 }
                                                                   }
                                                                 }

$lineitemprice.='<tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:30px;"><table cellpadding="5" cellspacing="3"><tr><td style="font-size:22px; font-family:Arial Black; color:#fff; font-weight:bold;"> TOTAL AMOUNT PROPOSED:</td></tr></table></td></tr></table></td>';
//echo '<pre>'; print_r($BID_Vendors_info); exit;
      // for($v=0,  $count1 = count($BID_Vendors_info); $v< $count1; $v++)
						 if($cnt>0)
							  {	//{


         //  echo '<pre>'; print_r($BID_Vendors_info);
          // $cnt=count($BID_Vendors_info);
							  for($v=(3*$loop_start); $v<(3*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								} else if($remainder == 1){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 2){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 3){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 0){
			$lineitemprice .=  '<td width="100%" align="left" valign="middle">';
								}
			$lineitemprice .=   '<table width="100%" border="0" cellspacing="2" cellpadding="2">';

 if($BID_Vendors_info[$v]->image != ''){
								$vendor_image = $pat.'vendors/pdf_resized/'.$BID_Vendors_info[$v]->image;
								if (!file_exists($vendor_image)) {
									$BID_Vendors_info[$v]->image = 'noimage1.gif';
									} else
									$BID_Vendors_info[$v]->image = $BID_Vendors_info[$v]->image;
							 } else { $BID_Vendors_info[$v]->image = 'noimage1.gif'; }

          // echo '<pre>'; print_r($BID_Vendors_info);
    $lineitemprice.='
 <tr> <td align="center" valign="middle" bgcolor="#7ab800" style="border:0.5px solid #b7b7b7; height:15px;"><p style="font-size:24px; color:#FFF; font-weight:bold;">VENDOR'.($v+1).'</p></td></tr>

    <tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; height:60px;"><p style="font-size:21px; color:#000;"><img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$BID_Vendors_info[$v]->image.'"  /></p></td></tr>


    <tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7; height:40px; font-size:24px;color:#000;"><br/><br/>'.$BID_Vendors_info[$v]->company_name.'</td></tr>';
     $line_cnt=count($RFP_NOTES_summary);

							 //for($li=0; $li<$line_cnt; $li++)
							 //{
  $cnt_prices=count($TASKS_summary);

								 for($TP=0; $TP<$cnt_prices; $TP++)
								 {
                                                                   // echo '<pre>'; print_r($TASKS_summary[$TP]);echo $BID_Vendors_info[$v]->proposedvendorid;
								  // if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$TP]->task_id)
								  // {
                                                                        $cnt_Task_Prices = count($TASKS_summary[$TP]->task_price);
                                                                       // if($cnt_Task_Prices != '0'){
                                                                         // $prev_price_cnt = $cnt_Task_Prices;
                                                                      //  }//else if($cnt_Task_Prices == '0')
                                                                            // $cnt_Task_Prices = $prev_price_cnt;
                                                                        //echo $cnt_Task_Prices;
  $addexpr="SELECT add_exception,check_exception FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' AND task_id='".$TASKS_summary[$TP]->task_id."' AND Alt_bid!='yes' ";
							$db->Setquery($addexpr);
							$star_final = $db->loadObjectList();
//echo '<pre>'; print_r($star_final);
							if($star_final[0]->add_exception && $star_final[0]->add_exception!='(list all exceptions here)' && $star_final[0]->check_exception=='on') {
							$as = '<span style="color:#ff6264; font-size:45px">*</span>';
                                                         $footer_note[] = 'yes';
														 
							} else {
                                                            $as = '';
															$footer_note[] = '';
                                                        }
		$lineitems_prices="SELECT item_price FROM #__cam_rfpsow_docs_lineitems_prices where vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and item_id=".$TASKS_summary[$TP]->task_id;
							$db->Setquery($lineitems_prices);
							$lineitemsprices = $db->loadResult();
							//echo '<pre>'; print_r($lineitemsprices);
									// if($cnt_Task_Prices == 0 || !$lineitemsprices)
									if($cnt_Task_Prices == 0 || !$lineitemsprices)
									{
											$lineitemprice .= '<tr><td align="center" valign="middle" height="59" style="border:0.5px solid #b7b7b7; font-size:30px; font-family:Arial Black; color:#000; font-weight:bold;"><br/><br/>Included In Total Price</td></tr>';
											//exit;
									} else {

$lineitems_prices1="SELECT item_price FROM #__cam_rfpsow_docs_lineitems_prices where vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and item_id=".$TASKS_summary[$TP]->task_id;
							$db->Setquery($lineitems_prices1);
							$lineitemsprices1 = $db->loadResult();
$lineitemsprices1 = str_replace('(Line-Item Pricing)','0.00',$lineitemsprices1);
$lineitemprice .= '<tr><td align="center" valign="middle" height="59" style="border:0.5px solid #b7b7b7; font-size:35px; font-family:Arial Black; color:#000; font-weight:bold;"><br/><br/>$'.$lineitemsprices1.''.$as.'</td></tr>';
									 /*for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
                                                                         // echo $TASKS_summary[$TP]->task_price[$B]->item_price; echo '---'; echo $B; echo '<br>';
									    if($TASKS_summary[$TP]->task_price[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{

                                                               // echo $as;
                                      $TASKS_summary[$TP]->task_price[$B]->item_price=str_replace('(Line-Item Pricing)','0.00',$TASKS_summary[$TP]->task_price[$B]->item_price);
                                      if($TASKS_summary[$TP]->task_price[$B]->item_price){
                                      $TASKS_summary[$TP]->task_price[$B]->item_price=$TASKS_summary[$TP]->task_price[$B]->item_price;
                                      } else {
                                      $TASKS_summary[$TP]->task_price[$B]->item_price='0.00';
                                      }
				  $lineitemprice .= '<tr><td align="center" valign="middle" height="59" style="border:0.5px solid #b7b7b7; font-size:35px; font-family:Arial Black; color:#000; font-weight:bold;"><br/><br/>$'.$TASKS_summary[$TP]->task_price[$B]->item_price.''.$as.'</td></tr>';
}

                                                        }*/
                                                         }
                                                    }


		$lineitemprice .='<tr><td height="30" valign="middle" bgcolor="#21314d" style="'.$class.'; border:0.5px solid #b7b7b7; font-size:35px; font-weight:bold; font-family:ArialBlack; color:#fff;"><table cellpadding="3" cellspacing="2"><tr><td>$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr></table></td></tr></table></td>';

        }
    }
                                                          }

 $lineitemprice .='</tr>';

  if(in_array('yes',$footer_note)){
  $lineitemprice.='<tr>
    <td  align="left" vaign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star.png" /> Designates exception for 1 or more line items.  Please see vendor notes on the following pages for details.</td>
  </tr>';
  }
$lineitemprice .='</table>';
//$lineitemprice ='<table width="100%" border="0" cellpadding="3" cellspacing="0">';
			//$lineitemprice .='<tr><td height="15" bgcolor="'.$class.'" style="color:#FFF;  font-family:ArialBlack; font-size:21px ; text-align: center; ">'.$BID_Vendors_info[$v]->company_name.':</td>';


							 //$lineitemprice .='</tr></table>';
         //echo '<pre>'; print_r($lineitemprice);
$pdf->writeHTML($lineitemprice, true, 0, true, 0);
  if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
 } //exit;
 
/***************************************** RFP LINE ITEMS AND VENDOR RESPONSES ****************************************/
             } //exit;
			 
			 //Special basic request
		if( $RFP_info->jobtype == 'yes' ){
		$htmlcontent3 =  '<table width="100%" cellpadding="3"><tr align="center"><td colspan="2" bgcolor="#7ab800" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px;">SCOPE OF WORK(SOW)</td></tr></table><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:24px; text-align: left; ">';
		$htmlcontent3 .= "<br /><br />".nl2br($RFP_info->jobnotes);
		$htmlcontent3 .= '</td></tr></table>';
		$htmlcontent3 .=  '<BR /><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:24px; text-align: left; ">';
		$htmlcontent3 .= "<strong>UPLOADED FILES:<br /></strong><br />";
		$bascifiles = $basefiles ;
		for( $f=0; $f<count($bascifiles); $f++ ){
			$htmlcontent3 .= '<a style="color:#7ab800; text-decoration:none;" href="'.JURI::root().'index2.php?option=com_camassistant&controller=documents&task=viewbasicfile&filename='.$bascifiles[$f]->filename.'&filepath='.$bascifiles[$f]->filepath.'&rfpid='.$RFP_info->id.'">'.$bascifiles[$f]->filename.'</a><br />';
		}
		$htmlcontent3 .= '</td></tr></table>';
		}
		
			 $line_cnt=count($RFP_NOTES_summary);
			
							 if($line_cnt>0)
							 {
							 for($li=0; $li<$line_cnt; $li++)
							 {

                                                          // $htmlcontent3 = '<table width="500px" border="0" cellspacing="0" cellpadding="2" align="center" style="padding-top:40px">';
                                                            //$htmlcontent3 .= '<tr><td colspan="2">';
							 $lid = $li+1;
							 if($RFP_NOTES_summary[$li]->title == '')
							 $RFP_NOTES_summary[$li]->title = 'NONE';
							 $RFP_NOTES_summary[$li]->task_desc = html_entity_decode($RFP_NOTES_summary[$li]->task_desc);
							 if($li == 0){
							 $RFP_NOTES_summary[$li]->task_desc = nl2br($RFP_NOTES_summary[$li]->task_desc);
							 }
							 else {
                                                         $RFP_NOTES_summary[$li]->task_desc = nl2br($RFP_NOTES_summary[$li]->task_desc);
							// $RFP_NOTES_summary[$li]->task_desc = nl2br(wordwrap($RFP_NOTES_summary[$li]->task_desc, 140, "\n"));
							 }

                                                      $pdf->AddPage();
													  if( $RFP_info->jobtype == 'yes' ){
 $htmlcontent3 .='<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px"><tr><td colspan="2">';
 }
 else{
 $htmlcontent3 ='<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px"><tr><td colspan="2">';
 }
                                                     // echo $li;
                                                        // echo '<pre>'; print_r($RFP_NOTES_summary[$li]->task_desc);
							if( $RFP_info->jobtype == 'yes' ){							
							 $htmlcontent3.='<tr><td width="100%" height="15" style="font-size:32px; text-align: left; vertical-align:middile; color:#000; font-weight:bold;" valign="middile"><font style="font-size:26px;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr><tr><td colspan="3" style="font-size:30px; text-align: left;" width="500px"><font style="font-size:23px;" width="500px">'.$RFP_NOTES_summary[$li]->task_desc.'</font><p style="color:#7ab800; font-weight:bold; font-size:24px;">';
							 }
							 else{
$html = $RFP_NOTES_summary[$li]->task_desc ;
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html);
$html_notes = str_replace('?','.', $html_notes);

			$htmlcontent3.='<tr><td width="100%" height="15" style="font-size:32px; text-align: left; vertical-align:middile; color:#000; font-weight:bold;" valign="middile">LINE ITEM #'.$lid.': <font style="font-size:26px;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr><tr><td colspan="3" style="font-size:30px; text-align: left;" width="500px"><font style="font-size:23px;" width="500px">'.$html_notes.'</font><p style="color:#7ab800; font-weight:bold; font-size:24px;">File(s) Provided to Vendors: ';				 
							 }


			//echo "anand"; print_r($RFP_NOTES_summary[$li]);
			 if($RFP_NOTES_summary[$li]->taskuploads!==''){
			 $uploads=explode('/',$RFP_NOTES_summary[$li]->taskuploads);
//echo '<pre>'; print_r($RFP_NOTES_summary[$li]->taskuploads); exit;
			 $upcount=count($uploads);
			 $attach= $uploads[$upcount-1];

			 $db =& JFactory::getDBO();
			/* $property_details="SELECT tax_id FROM #__cam_property where property_name ='".$RFP_info->property_name."'";
			$db->Setquery($property_details);
			$tax_id = $db->loadResult(); */

         	$pid1 = 'SELECT property_id FROM #__cam_rfpinfo WHERE id = '.$RFP_info->id ;
		$db->Setquery($pid1);
		$pid = $db->loadResult();
		//echo '<pre>'; print_r($pid);
		$details = 'SELECT property_name,tax_id FROM #__cam_property WHERE id = '.$pid ;
		$db->Setquery($details);
		$details1 = $db->loadObjectList();
		//echo '<pre>'; print_r($details1);
		 $default ='components/com_camassistant/doc/';
		$file_link1 = $default.str_replace(' ','_',$details1[0]->property_name).'_'.$details1[0]->tax_id.'/';
                for($i=0; $i<count($RFP_NOTES_summary[$li]->taskuploads); $i++)
		{

                $RFP_NOTES_summary[$li]->taskuploads = str_replace(' ,','',$RFP_NOTES_summary[$li]->taskuploads);
                $RFP_NOTES_summary[$li]->taskuploads = str_replace(',,',',',$RFP_NOTES_summary[$li]->taskuploads);
                $uploads= explode(',',$RFP_NOTES_summary[$li]->taskuploads );

                if(count($uploads)>0 && count($RFP_NOTES_summary[$li]->taskuploads)>0 ){

                    for ($l=0;$l<count($uploads);$l++){ 
					  $uploads1=explode('/',$uploads[$l]);
             // echo '<pre>'; print_r($linetaks->taskuploads);
             if($uploads[$l]){
                 $uploads23=explode('/',$uploads[$l]);

              if($uploads23[0]=='components' && $uploads23[1]=='com_camassistant' && $uploads23[2]=='assets' ){
             $file_link = str_replace(' ','',$uploads[$l]);
             } else {
             $file_link = $default.str_replace(' ','_',$details1[0]->property_name).'_'.$details1[0]->tax_id.'/'.str_replace(' ','',$uploads[$l]);
             }
            // echo '<pre>'; print_r($file_link); // $file_link=$file_link1
   $upcount=count($uploads1); $file= $uploads1[$upcount-1];
 //echo '<br/>'; echo $file;
   $htmlcontent3 .='&nbsp;<span style="font-size:20px; font-color:#000;" color="#000"><a style="text-decoration:none; color:#000; font-color:#000;" href="'.JURI::root().'index.php?option=com_camassistant&controller=popupdocs&task=open&title='.$file.'&path='.$file_link.'">'.$file.'</a></span>&nbsp;&nbsp;&nbsp;';
  //echo '<pre>'; print_r($tasks_list[$i]->file_path);
 } } }
// $tasks_list[$i]->file_path = $tasks_listfile_path;
 //echo '<pre>'; print_r($tasks_list[$l]->file_path);

 }
//exit;
			// $default = 'http://camassistant.com/live/components/com_camassistant/doc/';
			//$file_link = $default.$RFP_info->property_name.'_'.$tax_id.'/';
			//$htmlcontent3 .= '<font style="font-size:22px;">&nbsp;'.$RFP_NOTES_summary[$li]->file_path.'</font>';
			// $htmlcontent3 .= '<a href="http://camassistant.com/live/index.php?option=com_camassistant&controller=popupdocs&task=open&title='.$RFP_NOTES_summary[$li]->taskuploads.'&path='.$file_link.'"> '.$RFP_NOTES_summary[$li]->taskuploads.'</a>';
			 } else {
			 $htmlcontent3 .= '';
			 }
			 $htmlcontent3 .= '</p></td></tr><br />';
			 // for($v=(6*$loop_start); $v<(6*$loop_stop); $v++)

							for($v=0; $v<count($BID_Vendors_info); $v++)
							{
							 $x = 0;
							 if($v%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							 $vid = $v+1;
			$htmlcontent3 .='<table width="100%" border="0" cellpadding="3" cellspacing="0">';
			$htmlcontent3 .='<tr><td height="15"  bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px ; text-align: left; "> '.$BID_Vendors_info[$v]->company_name.':</td>';
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
										  $htmlcontent3 .= '<td style="font-size:24px; font-color:#fff;" bgcolor="gray" color="#fff"><b>LINE ITEM PRICE:</b>&nbsp;<strong>$ '.$TASKS_summary[$TP]->task_price[$B]->item_price.'</strong></td>';
										  }
										  else
										  {
										  $htmlcontent3 .= '<td style="font-size:24px; font-color:#fff;" bgcolor="gray" color="#fff"><b>LINE ITEM PRICE:</b>&nbsp;NONE</td>';
										  }
									  }
									 }
								 }
								}
							}
			 $htmlcontent3 .= '</tr>';
			/******************************************code to display NOTES*******************************************/
							$cnt_tasks=count($NOTES_summary);
        if($cnt_tasks>0)
        {
        $flag = 0;
        $htmlcontent3 .= '<tr><td border="1" width="100%" height="15" style="font-size:24px ;text-align: left; ">';
                 for($T=0; $T<$cnt_tasks; $T++)
                 {
                   if($RFP_NOTES_summary[$li]->task_id == $NOTES_summary[$T]->task_id)
                   {
                         $cnt_notes = count($NOTES_summary[$T]->task_notes);
                         //echo "<pre>"; print_r($NOTES_summary[$T]->task_notes);
                         for($N=0; $N<$cnt_notes; $N++)
                         {
                         //echo '<pre>'; print_r($BID_Vendors_info[$v]->proposedvendorid) echo'<br/>';
                            //  echo $NOTES_summary[$T]->task_notes[$N]->vendor_id; echo '-----';
                            //  echo $BID_Vendors_info[$v]->proposedvendorid; echo '<br/>';

                            if($NOTES_summary[$T]->task_notes[$N]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid)
                                {


         if($NOTES_summary[$T]->task_notes[$N]->add_notes != '')
                              {
$NOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('font-size','font-size:22px ',$NOTES_summary[$T]->task_notes[$N]->add_notes);
$NOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('line-height','',$NOTES_summary[$T]->task_notes[$N]->add_notes);
$NOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('text-indent','',$NOTES_summary[$T]->task_notes[$N]->add_notes);
$NOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('img','',$NOTES_summary[$T]->task_notes[$N]->add_notes);
$NOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('width','',$NOTES_summary[$T]->task_notes[$N]->add_notes);
$html = html_entity_decode($NOTES_summary[$T]->task_notes[$N]->add_notes) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);
$notes = '<span style="font-size:24px;"><b>NOTES: </b>'.$html_notes.'</span>';
                                  }
                                  else
                                  {
                                  $notes = '<span style="font-size:24px;"><b>NOTES: </b>NONE</span>';
                                  }

                 }

                         }

                 }
                }
        }
        if($notes=='' || !$notes){
           $htmlcontent3 .=  '<span style="font-size:24px;"><b>NOTES: </b>NONE</span>';
        } else {
           $htmlcontent3 .=  $notes;
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
                                                                                $note_exe= $EXCEPTION_summary[$E]->task_exception[$F]->check_exception;
								if($EXCEPTION_summary[$E]->task_exception[$F]->add_exception!= '' && $EXCEPTION_summary[$E]->task_exception[$F]->add_exception!='(list all exceptions here)')
									      {
										  $EXCEPTION = '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S): </b>&nbsp;'.nl2br($EXCEPTION_summary[$E]->task_exception[$F]->add_exception).'</span>';
										  }
										  else
										  {
										  $EXCEPTION = '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S): </b>&nbsp;NONE</span>';
										  }

										  }
									 }
								 }
								}
							}
            if($EXCEPTION=='' || !$EXCEPTION || $note_exe==''){
           $htmlcontent3 .=  '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S): </b>&nbsp;NONE</span>';
        } else {
           $htmlcontent3 .=  $EXCEPTION;
        }
				/******************************************code to display vendor uploaded files *******************************************/
				$cnt_uploades=count($TASKS_summary);
				//echo "<pre>"; print_r($TASKS_summary); exit;
					if($cnt_uploades>0)
							{
							$flag = 0;
								 for($A=0; $A<$cnt_uploades; $A++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$A]->task_id)
								   {
									 $cnt_Attachments = count($TASKS_summary[$A]->vendor_uploadsn);
									 for($B=0; $B<$cnt_Attachments; $B++)
									 {
									    if($TASKS_summary[$A]->vendor_uploadsn[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$A]->vendor_uploadsn[$B]->upload_doc != '')
									      {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S):</b>&nbsp;'.$TASKS_summary[$A]->vendor_uploadsn[$B]->title.'</p>';
										  }
										  else
										  {
										  $htmlcontent3 .= '<p><b>ATTACHMENT(S):</b>&nbsp;NONE</p>';
										  }
                                                                                }
									 }
								 }
								}
							}
				/******************************************code to display vendor line item prices *******************************************/
				/*$cnt_prices=count($TASKS_summary);
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
							}	*/


							$htmlcontent3 .='</td></tr>';
							$htmlcontent3 .= '</table>';
							}  //echo $htmlcontent3; //end inner for loop
							 $htmlcontent3 .= '</td></tr>';
                                                   $htmlcontent3 .= '</table>'; 
												   
												   $pdf->writeHTML($htmlcontent3, true, 0, true, 0);  }  //$htmlcontent3 .= '</table>';//end main for loop
							}//if($line_cnt>0)
		/***************** END RFP LINE ITEMS AND VENDOR RESPONSES  ****************************/

		/***************** CODE TO GET VENDOR RESPONSE PRICES FOR RFP OTHER ITEM PRICE  ****************************/
			/*for($s=0; $s<count($vendors_cnt); $s++) {
$other_price_sql_s = "SELECT `price_other_items` FROM #__cam_vendor_proposals  where rfpno='".$RFP_info->id."' AND proposedvendorid  ='".$vendors_cnt[$s]->proposedvendorid. "' AND Alt_bid != 'yes' ";
							$db->setQuery($other_price_sql_s);
							$other_price_s[] = $db->loadResult();
}

$arr=array_unique($other_price_s);

if(count($arr)==1 && $arr[0]==0.00){

//echo '<pre>';print_r(array_unique($other_price_s));
}else{

		 $pdf->AddPage();
		 $vendors_cnt = $vendor_ids;

			$htmlcontentotherprice = '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';

			$htmlcontentotherprice .='<tr><td colspan="2" height="15" bgcolor="#21314d" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">All other items, charges & fees not itemized above</td></tr>';
			//$htmlcontentotherprice .='<tr><td colspan="2"><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:19px; text-align: left; ">';

							$htmlcontentotherprice .= '<br/><br/>';
							$count=count($vendors_cnt);
							if($vendors_cnt>0){

							for($z=0; $z<count($vendors_cnt); $z++) {

							$db =& JFactory::getDBO();
							 $other_price_sql = "SELECT `price_other_items` FROM #__cam_vendor_proposals  where rfpno='".$RFP_info->id."' AND (proposaltype='Submit' OR proposaltype='resubmit')  AND proposedvendorid  ='".$vendors_cnt[$z]->proposedvendorid. "' AND Alt_bid != 'yes' ";
							$db->setQuery($other_price_sql);
							 $other_price_d = $db->loadResult();

							if(!$other_price_d)
							$other_price_d = '0.00';
							else
							//$other_price_d = $other_price_d;
							$other_price_d = number_format( $other_price_d , 2 , '.' ,',' );

					//echo "PRICE".$other_price_d;
							//exit;
							$cnt = $z+1;
							 if($z%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							  if($z != 0)
							$htmlcontentotherprice .= '<br/>';
							// To get the vendor company name
		 $v_compname = "SELECT `company_name` FROM #__cam_vendor_company  where user_id  ='".$vendors_cnt[$z]->proposedvendorid. "'  ";
		 $db->setQuery($v_compname);
		$vendor_comp_name = $db->loadResult();
							$htmlcontentotherprice .=  '<tr><td bgcolor="'.$class.'" style="color:#ffffff; font-color:#ffffff; font-weight:bold; font-family:ArialBlack; font-size:30px; height:15px; border:1px solid gray; text-align: left;" width="40%">'.$vendor_comp_name.':</td><td width="20%" style="text-align: left;"  style="border:1px solid gray; color:gray; font-size:30px; font-weight:bold;">$ '.$other_price_d.' </td></tr>';

							 }

							}
		//	$htmlcontentotherprice .='</td></tr></table>';
		    $htmlcontentotherprice .= '</table>';

//echo 'anand__';
	//echo $htmlcontentotherprice; exit;
		$pdf->writeHTML($htmlcontentotherprice, true, 0, true, 0);
	} */
		/***************** CODE TO GET VENDOR RESPONSE PRICES FOR RFP OTHER ITEM PRICE  ****************************/


		/*********************************************SPECIAL REQUIREMENTS COMPLIANCE DOCS************************/
		$COM =$COM;

		$Review_reqCatList =  $SPLRequirements_details;

		//$Review_reqCatList = $this->Review_reqCatList;
		$cat = $Review_reqCatList['main'];
		$main = $Review_reqCatList['main'];
		$sub = $Review_reqCatList['sub'];
		$child = $Review_reqCatList['child'];
		$child_price=array();

	    error_reporting('E_WARNING)');
		// add a page

		$pdf->AddPage();
			$htmlcontent4 = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';
						//$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, "70", "24", "", "", "", true, 100);
			//$htmlcontent4 .= '<tr><td width="205px" height="50" align="left" ></td><td width="345px" style="text-align: left; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.','.$RFP_info->comp_state.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td></tr>';

		//$htmlcontent4 .='<tr style="height:5px;"><td align="left" colspan="2" style="font-size:5px;"><hr /><br /></td></tr>';

			
			if( $RFP_info->jobtype == 'yes' ){
			$htmlcontent4 .='<tr><td colspan="2" height="15" style="color:#000; font-weight:bold; font-family:Arial; font-size:30px ; text-align: center; ">WARRANTY:</td></tr>';
			}
			else{
			$htmlcontent4 .='<tr><td colspan="2" height="15" style="color:#000; font-weight:bold; font-family:Arial; font-size:30px ; text-align: center; ">GENERAL NOTES & WARRANTY:</td></tr>';
			}
			//This is for general notes and general exceptions
			
		$htmlcontent4 .='<tr><td colspan="2">';
		//$count=count($vendors_cnt);
		$count=count($BID_Vendors_info);
		if($count>0){ for($v=0; $v<$count; $v++) {
							$cnt = $v+1;
							 if($v%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							  if($v != 0)
							$htmlcontent4 .= '<br/>';
							$htmlcontent4 .=  '<table width="100%" cellpadding="3"><tr align="center"><td colspan="2" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px;">'.$BID_Vendors_info[$v]->company_name.':</td></tr></table><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:24px; text-align: left; ">';
	if( $RFP_info->jobtype != 'yes' ){		
		 $add_notes = 'SELECT add_notes FROM #__cam_rfpsow_addnotes WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid.' AND Alt_bid!="yes"';
		  $db->Setquery($add_notes);
		  $add_notes1 = $db->loadResult();
		  $add_notes1 = str_replace('font-size','font-size:22px ',$add_notes1);
		  $add_notes1 = str_replace('line-height','',$add_notes1);
		  $add_notes1 = str_replace('text-indent','',$add_notes1);
		  $add_notes1 = str_replace('img','',$add_notes1);
		  $add_notes1 = str_replace('width','',$add_notes1);
		  
		  
		  //echo '<pre>'; print_r( $add_notes1);
		 if($add_notes1 != ''){
$html = html_entity_decode($add_notes1) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);
		 $htmlcontent4 .= '<font style="font-size:24px; font-weight:bold;">GENERAL NOTES:</font><br/>'.$html_notes.'';
		 }
		 else{
		 $htmlcontent4 .= '<font style="font-size:24px; font-weight:bold;">GENERAL NOTES:</font><br/>NONE';
		 }
	}
	else{
		 $add_notes = 'SELECT add_notes FROM #__cam_rfpsow_addnotes WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid.' AND Alt_bid!="yes"';
		  $db->Setquery($add_notes);
		  $add_notes1 = $db->loadResult();
		  $add_notes1 = str_replace('font-size','font-size:22px ',$add_notes1);
		  $add_notes1 = str_replace('line-height','',$add_notes1);
		  $add_notes1 = str_replace('text-indent','',$add_notes1);
		  $add_notes1 = str_replace('img','',$add_notes1);
		  $add_notes1 = str_replace('width','',$add_notes1);
		  //echo '<pre>'; print_r( $add_notes1);
		 if($add_notes1 != ''){
$html = html_entity_decode($add_notes1) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);		 
		 $htmlcontent4 .= '<font style="font-size:24px; font-weight:bold;">PROPOSAL NOTES:</font><br/>'.$html_notes.'';
		 }
		 else{
		 $htmlcontent4 .= '<font style="font-size:24px; font-weight:bold;">PROPOSAL NOTES:</font><br/>NONE';
		 }
	}
		 //To get the documents in the general notes
		 $general_doc = 'SELECT upload_doc FROM #__cam_rfpsow_uploadfiles WHERE rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid. ' ';
		  $db->Setquery($general_doc);
		  $generalattach = $db->loadResult();
		  $generalattach_ex = explode('/',$generalattach);
		 if( $RFP_info->jobtype != 'yes' ){
		   $htmlcontent4 .= 'ATTACHMENT(S): <a style="text-decoration:none; color:#7AB800; font-color:#7AB800;" href="'.JURI::root().'index.php?option=com_camassistant&controller=proposals&task=downloadfile&title='.$generalattach_ex[4].'&path='.$generalattach.'">'.$generalattach_ex[4].'</a>';
		   }
		 //Completed
		 
		 
		  $add_exception = 'SELECT add_exception FROM #__cam_rfpsow_addexception WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid. ' AND Alt_bid!="yes"';
		  $db->Setquery($add_exception);
		  $add_exception1 = $db->loadResult();
		   // echo '<pre>'; print_r( $add_exception1);
		 /*  if($add_exception1 != '')
		 $htmlcontent4 .= '<br /><br /><font style="color:#FF0000; font-size:24px; font-weight:bold;">GENERAL EXCEPTION(S):</font><br/>'.nl2br($add_exception1).'';
		 else
		$htmlcontent4 .= '<br /><br /><font style="color:#FF0000; font-size:24px; font-weight:bold;">GENERAL EXCEPTION(S):</font><br/>None<br />';
                  *
                  */
                 $db =& JFactory::getDBO();
			 $sql = "SELECT warranty_filepath,warranty_file_text,warranty_file_area FROM #__cam_vendor_proposals where rfpno = ".$BID_Vendors_info[$v]->rfpno." AND Alt_bid!='yes' AND proposedvendorid=".$BID_Vendors_info[$v]->proposedvendorid;
				$db->Setquery($sql);
				$warranty = $db->loadObjectList();
				//echo '<pre>'; print_r($warranty);
				$x = 0;
							 if($w%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							 $wid = $w+1;
							 //	$warranrtyinformation .='<tr><td height="15" width="35%" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: left; ">VENDOR '.$wid.' warranrtyinformation:</td></tr>';
							$warrantylink='<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index2.php?option=com_camassistant&controller=proposals&task=downloadfile&title='.$warranty[0]->warranty_file_text.'&path='.$warranty[0]->warranty_filepath.'">'.$warranty[0]->warranty_file_text.'</a>';
				 if($warranty[0]->warranty_file_text != '' && $warranty[0]->warranty_filepath != '')
				{
				$warrantylink1 = $warrantylink;
				}
				else {
				$warrantylink1 = 'No Files';
				}
				if($warranty[0]->warranty_file_area != '')
				{
				$warranty_file_area = $warranty[0]->warranty_file_area;
				}
				else{
				$warranty_file_area = 'No text entered. If no attachment is provided, please contact vendor.';
				}



					if($warranty_file_area != ''){
					$warranty_file_area = str_replace('font-size','font-size:22px ',$warranty_file_area);
		  			$warranty_file_area = str_replace('line-height','',$warranty_file_area);
					$warranty_file_area = str_replace('text-indent','',$warranty_file_area);
					$warranty_file_area = str_replace('img','',$warranty_file_area);
					$warranty_file_area = str_replace('width','',$warranty_file_area);
					
$html = html_entity_decode($warranty_file_area) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);	

					$htmlcontent4 .= '<br /><br /><strong>WARRANTY: </strong><br />'.$html_notes;
					} else {
				$htmlcontent4 .= '<br /><br />WARRANTY: No text entered. If no attachment is provided, please contact vendor.';
	                }
				if($warrantylink1 != ''){
					 $htmlcontent4 .= '<br /><br /><strong>ATTATCHMENT(S):</strong> '.$warrantylink1;
					} else {
					  $htmlcontent4 .= '<br /><br /><strong>ATTATCHMENT(S):</strong> No Files ';
					}
                $htmlcontent4 .= '</td></tr></table>';
} }
		$htmlcontent4 .= '</td></tr></table>';
	//Completed
                $pdf->writeHTML($htmlcontent4, true, 0, true, 0);
                $pdf->AddPage();
				
				if( $RFP_info->jobtype != 'yes' ){
                $special_r = '<table width="550px" border="0" cellspacing="2" cellpadding="4" align="center" style="font-size:24px;">';
                $special_r .='<tr><td colspan="2" height="10" bgcolor="#21314d" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:28px ; text-align: center; ">COMPLIANCE DOCUMENTS</td></tr></table>';
		//$special_r .='<tr><td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:24px;"><tr><td style="font-size:21px; text-align: left; ">';

			$special_r .= $g_data;
			if($g_data)
			$special_r .= '<br />' ;
			$special_r .= $a_data;
			if($a_data)
			$special_r .= '<br />' ;
			$special_r .= $w_data;
			if($w_data)
			$special_r .= '<br />' ;
			$special_r .= $u_data;
			if($u_data)
			$special_r .= '<br />' ;
			$special_r .= $l_data;
			if($l_data)
			$special_r .= '<br />' ;
			}
							$special_r .= '<br/><br/>';
							
							//$count=count($vendors_cnt);
							$count=count($BID_Vendors_info);
							if($count>0){ for($v=0; $v<$count; $v++) {
							$cnt = $v+1;
							 if($v%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							  if($v != 0)
							$special_r .= '<br/>';
                                                        $special_r .=  '<table width="100%" cellpadding="0" cellspacing="0" border="1" style="font-size:24px;"><tr><td>';
							$special_r .=  '<table width="100%" cellpadding="3" cellspacing="0"><tr align="center"><td colspan="2" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px;">'.$BID_Vendors_info[$v]->company_name.':</td></tr></table><table width="100%" cellpadding="3" cellspacing="0"><tr><td>';
							//if($v !=0)
							//$special_r .= '<p style="height:20px;"></p>';
							  					/* if($COM[$v]['OLN'] != '')
												 $htmlcontent4 .= '<br/>OLN License: '.$COM[$v]['OLN'].'<br/>';
												 if($COM[$v]['PLN'] != '')
												 $htmlcontent4 .= 'PLN License: '.$COM[$v]['PLN'].'<br/>';
												 if($COM[$v]['GLI'] != '')
												 $htmlcontent4 .= 'GLI Insurance: '.$COM[$v]['GLI'].'<br/>';
												 if($COM[$v]['WCI'] != '')
												 $htmlcontent4 .= 'WCI Insurance: '.$COM[$v]['WCI'].'<br/>';
												 if($COM[$v]['W9'] != '')
												 $htmlcontent4 .= 'W9: '.$COM[$v]['W9'].'<br/>';
												 if($COM[$v]['WARRANTY'] != 'nofiles')
												 $htmlcontent4 .= 'WARRANTY-INFO: '.$COM[$v]['WARRANTY'];*/
                                    if($COM[$v]['OLN'] != '')
                                    $special_r .= 'Occupational License: '.$COM[$v]['OLN'].'<br/>';
                                    if($COM[$v]['PLN'] != '')
                                    $special_r .= 'Professional License: '.$COM[$v]['PLN'].'<br/>';
                                    if($COM[$v]['GLI'] != '')
                                    $special_r .= 'General Liability Insurance: '.$COM[$v]['GLI'].'<br/>';
                                    if($COM[$v]['WCI'] != '')
                                    $special_r .= 'Workers Comp Insurance: '.$COM[$v]['WCI'].'<br/>';
                                    if($COM[$v]['W9'] != '')
                                    $special_r .= 'W-9: '.$COM[$v]['W9'].'';

		/*$add_notes = 'SELECT add_notes FROM #__cam_rfpsow_addnotes WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid.' AND Alt_bid!="yes"';
		  $db->Setquery($add_notes);
		  $add_notes1 = $db->loadResult();
		  //echo '<pre>'; print_r( $add_notes1);
		   if($add_notes1 != '')
		 $htmlcontent4 .= '<br /><font style="font-size:23px; font-weight:bold;">NOTES:</font>'.nl2br($add_notes1).'';
		 else
		 $htmlcontent4 .= '<br /><font style="font-size:23px; font-weight:bold;">NOTES:</font>NONE';

		  $add_exception = 'SELECT add_exception FROM #__cam_rfpsow_addexception WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$v]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$v]->proposedvendorid. ' AND Alt_bid!="yes"';
		  $db->Setquery($add_exception);
		  $add_exception1 = $db->loadResult();
		   // echo '<pre>'; print_r( $add_exception1);
		   if($add_exception1 != '')
		 $htmlcontent4 .= '<br /><font style="color:#FF0000; font-size:23px; font-weight:bold;">EXCEPTION(S):</font>'.nl2br($add_exception1).'';
			 else
		$htmlcontent4 .= '<br /><font style="color:#FF0000; font-size:23px; font-weight:bold;">EXCEPTION(S):</font>NONE'; */
                                    $special_r .='</td></tr></table></td></tr></table>';
						 }
							 }
			$special_r .='</td></tr></table>';
		    $special_r .= '</td></tr></table>';
		//echo $htmlcontent4; exit;
		$pdf->writeHTML($special_r, true, 0, true, 0);
		
	/********************************************END OF CODE SPECIAL REQUIREMENTS COMPLIANCE DOCS************************/
	} //exit; //end - if(count($BID_Vendors_info)>0)


	/*****************  CODE TO ALTERNATE PROPOSALS  *********************/
	$BID_AltVendors_info = $res_altvendors;
	$BID_Vendors_info = $BID_AltVendors_info;//echo "<pre>"; print_r($BID_AltVendors_info);
	$remainder = count($BID_Vendors_info)%3;
	$quotient = intval(count($BID_Vendors_info)/3);
	$total = count($BID_Vendors_info);
	if($remainder == 0)
	$loop_iterator = $quotient;
	else
	$loop_iterator = $quotient+1;
        $cnt1=count($BID_Vendors_info);
	if($cnt1>0)
	{
	  // add a page
		$pdf->AddPage();
	/*****************  code to display vendor info htmlcontent  *****************/

	for($loop_start=0, $loop_stop=1; $loop_start<$loop_iterator; $loop_start++,$loop_stop++)
    {
		if($RFP_info->comp_logopath == '')
		$RFP_info->comp_logopath = 'noimage2.gif';
		$htmlcontent = '<table width="635" border="0" cellspacing="0" cellpadding="1" align="center" style="padding-top:0px; font-family:arial; ">';
//$width = 75;
//$height = 15;
              //  echo '<pre>'; print_r($RFP_info);
						$pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
		$htmlcontent .= '<tr><td width="245px" height="50" align="left" ></td>
							<td width="315px" align="right" style="text-align: right; font-size:23px;"><img width="50" height="14" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')&nbsp;'.$com_phone[1].'-'.$com_phone[2].'</td></tr>

						<br/><tr style="font-size:30px;">
							<td colspan="4" align="center"><strong>'.$RFP_info->projectName.'</strong><br />
							<strong>'.str_replace('_',' ',$RFP_info->property_name).' &nbsp;&nbsp;|&nbsp;&nbsp; RFP #'.$RFP_info->id.'</strong></td>
						 </tr>
						<br/>
						<tr style="font-size:23px;">';
//$workperform=explode(' ',$RFP_info->work_perform);
//echo '<pre>'; print_r($RFP_info->work_perform);
						if( $RFP_info->jobtype == 'yes' ){
						$htmlcontent .='<td align="left" width="290px;" ><br />Closed On<strong>: '.$RFP_info->proposalDueDate.'</strong><br />Proposals Submitted<strong>: '.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted<strong>: '.$altproposals_submitted.'</strong></td>';
						}
						else{
						$htmlcontent .='<td align="left" width="290px;" ><br />Industry Solicited<strong>: '.$ind_solicited.'</strong><br />Service Location<strong>: '.$RFP_info->work_perform.'</strong></td>';
						}
						if( $RFP_info->jobtype != 'yes' ){
                         $htmlcontent .='<td  style="text-align:left;" width="150px;"><br />Closed On<strong>: '.$RFP_info->proposalDueDate.'</strong><br />Proposals Submitted<strong>: '.$BID_info->Submitted.'</strong><br />Alt.Proposals Submitted<strong>: '.$altproposals_submitted.'</strong></td>';
						 }
						 else{
						 $htmlcontent .='<td  style="text-align:left;" width="150px;"></td>';
						 }
                          
						 $htmlcontent .='<td align="right" style="text-align:left;" width="120px;"><br />High Bid<strong>: $'.$Max_bid.'</strong><br />Low Bid  <strong>: $'.$Min_bid.'</strong><br />Average Bid <strong>: $'.$Avg_bid.'</strong>	</td>


						</tr>
		<tr style="height:4px;"><td align="left" colspan="2" style="font-size:5px;"></td></tr>';
		/***eof table pan****/

		/**** sof table pan****/
			$htmlcontent .= '<tr><td width="140" align="left"><table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td align="center" bgcolor="gray" style="border:0.5px solid #b7b7b7;" height="14"><p style="font-size:26px;  color:#FFF; font-weight:bold;">DESCRIPTION</p></td></tr> <tr><td align="center" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:60px;"><p style="font-size:26px;color:#000; font-weight:bold;"><br/><br/></p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:36px;"><p style="font-size:26px;  color:#000; font-weight:bold;"><br>Company Name:</p></td></tr><tr><td align="center" valign="middle" height="48"><p><font style="font-size:26px;font-family:ArialBlack; color:#000; font-weight:bold;">Vendor Apple Rating:</font><br/><font style="font-size:24px;color:#000;">(Based on customer surveys & vendor follow through)</font></p></td></tr><tr valign="middle" cellpadding-top="20"><td 
align="center" valign="middle" bgcolor="#f3f9e8" height="45px" style="border:0.5px solid #b7b7b7; font-family:ArialBlack;"><div style="font-size:26px;  color:#000; font-weight:bold;"><br>Vendor Address:</div></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:15px;"><p style="font-size:26px;  color:#000; font-weight:bold;">Contact Name:</p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:26px;  color:#000; font-weight:bold;">Office Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:16px; "><p style="font-size:26px;  color:#000; font-weight:bold;">Alt.Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;" bgcolor="#f3f9e8"><p style="font-size:26px; color:#000; font-weight:bold;">Mobile 
Number:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:36px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/>Email Address:</p></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:26px; color:#000; font-weight:bold;">Business Established:</p></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:15px; "><p style="font-size:26px; font-weight:bold; color:#000;">General Liability:</p></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:25px;"><table cellpadding="3" cellspacing="1"><tr><td style="font-size:26px; font-family:Arial Black; color:#000; font-weight:bold;">Workers Comp. Policy?</td></tr></table></td></tr><tr><td align="center" bgcolor="#f3f9e8" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:16px;"><p style="font-size:24px; color:#000; font-weight:bold;">Meets Compliance Standards?</p></td></tr><tr>
			<td align="center" valign="middle" style="border:0.5px solid #b7b7b7; height:45px;"><p><font style="font-size:26px; font-family:ArialBlack; color:#000;font-weight:bold;">In-House Vendor?</font><br/><font style="font-size:25px;color:#000;">(Vendor affiliated with management company)</font></p></td></tr><tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:23px;"><table cellpadding="3" cellspacing="2"><tr><td style="font-size:21px; font-family:Arial Black; color:#fff; font-weight:bold;">TOTAL AMOUNT PROPOSED:</td></tr></table></td></tr><tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:17px;"><p style="font-size:26px; color:#000; font-weight:bold;">Alternate Proposal?</p></td></tr></table></td>';
							 // $cnt=count($BID_Vendors_info);
							  if($cnt>0)
							  {
							  for($v=(3*$loop_start); $v<(3*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$htmlcontent .=  '<td width="140" align="left">';
								} else if($remainder == 1){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 2){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 3){
			$htmlcontent .=  '<td width="140" align="left">';
								}
								else if($remainder == 0){
			$htmlcontent .=  '<td width="100%" align="left">';
								}
			$htmlcontent .=   '<table width="100%" border="0" cellspacing="2" cellpadding="2">';
							  if($v%2 == 0)
							  //$class = "#21314d";
                                                           $class = "#7ab800";
							  else
							  $class = "#7ab800";
							  $vid = $v+1;
							if($BID_Vendors_info[$v]->contact_name){
							  $BID_Vendors_info[$v]->company_name=$BID_Vendors_info[$v]->company_name;
							  } else {
							  $BID_Vendors_info[$v]->company_name=$BID_Vendors_info[$v]->company_name;
							  }
							  if($BID_Vendors_info[$v]->company_name == '')
							  $BID_Vendors_info[$v]->company_name = '---';
			$htmlcontent .= '<tr valign="middle"><td bgcolor="'.$class.'" align="center" height="14px" style="border:0.5px solid #b7b7b7;"><p style="color:#FFF; font-size:26px; font-weight:bold;">VENDOR '.$vid.'</p></td></tr>';
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
                                                         //echo '<pre>'; print_r( $BID_Vendors_info[$v]);
       if($BID_Vendors_info[$v]->company_phone!='' && $BID_Vendors_info[$v]->company_phone!='--' ){
	$BID_Vendors_info[$v]->company_phone = explode('-',$BID_Vendors_info[$v]->company_phone) ;
	$BID_Vendors_info[$v]->company_phone = '('.$BID_Vendors_info[$v]->company_phone[0].') '.$BID_Vendors_info[$v]->company_phone[1].'-'.$BID_Vendors_info[$v]->company_phone[2];
         } else {
            $BID_Vendors_info[$v]->company_phone='N/A';
        }
	$altphone = "Alt.Phone: ";
	$altphoneext = "Alt.Extension: ";
        if($BID_Vendors_info[$v]->alt_phone!='' && $BID_Vendors_info[$v]->alt_phone!='--' ){
	$BID_Vendors_info[$v]->alt_phone = explode('-',$BID_Vendors_info[$v]->alt_phone) ;
	$BID_Vendors_info[$v]->alt_phone = '('.$BID_Vendors_info[$v]->alt_phone[0].') '.$BID_Vendors_info[$v]->alt_phone[1].'-'.$BID_Vendors_info[$v]->alt_phone[2];
        } else {
            $BID_Vendors_info[$v]->alt_phone='N/A';
        }
	//$cellphone = "Mobile Phone: ";

          if($BID_Vendors_info[$v]->cellphone!='' && $BID_Vendors_info[$v]->cellphone!='--'){
	$BID_Vendors_info[$v]->cellphone = explode('-',$BID_Vendors_info[$v]->cellphone) ;
         //echo '<pre>'; print_r($BID_Vendors_info[$v]->cellphone);
         if(count($BID_Vendors_info[$v]->cellphone)>1){
	$BID_Vendors_info[$v]->cellphone = '('.$BID_Vendors_info[$v]->cellphone[0].') '.$BID_Vendors_info[$v]->cellphone[1].'-'.$BID_Vendors_info[$v]->cellphone[2];
        } else {
            $BID_Vendors_info[$v]->cellphone = $BID_Vendors_info[$v]->cellphone;
         }
           } else {
            $BID_Vendors_info[$v]->cellphone='N/A';
        }
        //echo '<pre>'; print_r($BID_Vendors_info[$v]->cellphone);
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
	//echo '<pre>'; print_r($BID_Vendors_info[$v]);
	//echo "<pre>"; print_r($BID_Vendors_info[$v]->company_phone); exit;
	//echo $image; exit;
		$rateimage= '/var/www/vhosts/myvendorcenter.com/httpdocs/'.DS.'components'.DS.'com_camassistant'.DS.'assets'.DS.'images'.DS.'rating'.DS;
			$db = JFactory::getDBO();
			$rating = "SELECT rating_sum FROM #__content_rating where content_id =".$BID_Vendors_info[$v]->proposedvendorid;
			$db->Setquery($rating);
			$rating = $db->loadResult();
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}

			$len = strlen($BID_Vendors_info[$v]->email);
							if($len>25) {
							$mail = explode('@',$BID_Vendors_info[$v]->email);
							$clearemail = $mail[0].'@<br>'.$mail[1];
							 }
							 else{
							$clearemail = $BID_Vendors_info[$v]->email;
							 }
			$get_primarycontact = "SELECT contact_name FROM #__cam_vendor_proposals where rfpno =".$RFP_info->id." and proposedvendorid=".$BID_Vendors_info[$v]->proposedvendorid." and Alt_bid='' ";
			$db->Setquery($get_primarycontact);
			$primarycontact = $db->loadResult();
			if($primarycontact){
			$primarycontactperson = $primarycontact ;
			}
			else{
			$primarycontactperson = $BID_Vendors_info[$v]->name.' '.$BID_Vendors_info[$v]->lastname ;
			}
			
			//print_r($rate_image); exit;
			$htmlcontent .= '<tr><td align="center" valign="middle" style="height:60px; border:0.5px solid #b7b7b7;" ><table cellpadding="0" cellspacing="1"><tr><td><img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$image.'"  /> </td></tr></table> </td></tr>';
			$htmlcontent .= '<tr valign="baseline"><td height="36" valign="middle" align="center" bgcolor="#f3f9e8" style="font-size:24px ; text-align: center; border:0.5px solid #b7b7b7;  vertical-align:middle"><br/><br/>'.$BID_Vendors_info[$v]->company_name.'</td></tr>';
			/*  '.$rating=plgVotitaly($BID_Vendors_info[$v]->proposedvendorid,$limitstart).' */
			/* <img src="templates/camassistant_left/images/rating.gif" width="75" height="15" /> */
                        if($rating!=''){
                            $rating=$rating;
                        } else {
                            $rating='4';
                        }
			$htmlcontent .= '<tr valign="middle"><td border="0" valign="middle" style="font-size:24px; text-align: center; height:48px;"><br/><br/>

			<img src="'.$rate_image.'" /><br/>'.$rating .' Out of 5</td></tr>
							<tr><td height="45" valign="middle" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->company_address.',<br />'.$BID_Vendors_info[$v]->city.',<br />'.$vstate.' '.$BID_Vendors_info[$v]->zipcode.'</td>  </tr><tr><td height="15" style="font-size:24px ;text-align: center; border:0.5px solid #b7b7b7; ">'.$primarycontactperson.'</td></tr>';


						$htmlcontent .= '<tr><td valign="middle" height="16" bgcolor="#f3f9e8" style="font-size:24px; text-align: center; border:0.5px solid #b7b7b7; ">'. $BID_Vendors_info[$v]->company_phone.'</td></tr>';


							$htmlcontent .= '<tr><td valign="middle" height="16" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->alt_phone.'</td>  </tr>';

			 $htmlcontent .= '<tr><td height="16" valign="middle" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; ">'.$BID_Vendors_info[$v]->cellphone.'</td></tr><tr><td height="36" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center; "><br/><br/>'.$clearemail.'</td></tr><tr><td height="16" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7;  text-align: center;">'.$BID_Vendors_info[$v]->established_year.'</td></tr>';

                          $sql = "SELECT sum(GLI_policy_aggregate) FROM #__cam_vendor_liability_insurence WHERE GLI_end_date>='".$today."'and GLI_status = 1 AND vendor_id=".$BID_Vendors_info[$v]->proposedvendorid;
			  $db->Setquery($sql);
			$amount = $db->loadResult();
                         $amount = number_format($amount);
                        if($amount!=''){
                            $amount=$amount;
                        } else {
                            $amount='N/A';
                        }

                         $htmlcontent .= '<tr><td height="15" valign="middle" style="font-size:26px;text-align: center; border:0.5px solid #b7b7b7;  font-weight:bold; ">$'.$amount.'</td></tr>';

                          $sql2 = "SELECT excemption FROM #__cam_vendor_workers_companies_insurance WHERE WCI_status = 1 AND WCI_upld_cert!='' AND vendor_id=".$BID_Vendors_info[$v]->proposedvendorid;
                        $db->Setquery($sql2);
                        $WCI = $db->loadResultArray();

                        if($WCI)
                        {
                            if(in_array('1',$WCI)){

                            $onfile = '<font style="color:red; font-size:26px;">Exemption Only<font style="color:#ff6264; font-size:35px;" valign="middile">**</font></font>';
                            $wcresult[]='yes';
                            }  else { $onfile = '<font style="color:green; font-size:26px;" cellpadding="5">Yes<font style="font-size:35px;" valign="middile"> </font></font>';
							$wcresult[]='';
                            }
                	}
                        else if($WCI=''){
                            $onfile = '<font style="color:green; font-size:26px;">Yes<font style="font-size:35px;" valign="middile"> </font></font>';
							$wcresult[]='';
                        } else {
                        $onfile = '<font style="color:red; font-size:26px;">No<font style="font-size:35px;" valign="middile"> </font></font>';
						$wcresult[]='';
                        }
                       // echo '<pre>'; print_r($onfile);     exit;
					   
$log = new checkstatus();
$master	=	$log->getmasterfirmaccount($RFP_info->cust_id);

$checkglobal	=	$log->checkglobalstandards($RFP_info->id,$master);
	if( $checkglobal == 'success' )	{
		$totalprefers_new_gli	=	$log->checknewspecialrequirements_gli($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_aip	=	$log->checknewspecialrequirements_aip($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_wci	=	$log->checknewspecialrequirements_wci($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_umb	=	$log->checknewspecialrequirements_umb($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_pln	=	$log->checknewspecialrequirements_pln($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		$totalprefers_new_occ	=	$log->checknewspecialrequirements_occ($BID_Vendors_info[$v]->proposedvendorid,$RFP_info->id,$master);
		/*if($BID_Vendors_info[$v]->proposedvendorid == '1806'){
		echo "FIRM: ".$total_managers[$t]->cust_id."<br />".$preferred[$v]->id.'<br /><br />';
				echo $totalprefers_new_gli."<br />" ;
				echo $totalprefers_new_aip."<br />" ;
				echo $totalprefers_new_wci."<br />" ;
				echo $totalprefers_new_umb."<br />" ;
				echo $totalprefers_new_pln."<br />" ;
			}	*/
			if($totalprefers_new_gli == 'success' && $totalprefers_new_aip == 'success' && $totalprefers_new_wci == 'success' && $totalprefers_new_umb == 'success' && $totalprefers_new_pln == 'success' && $totalprefers_new_occ == 'success' )
				{
					$db =& JFactory::getDBO();
					$sql_terms = "SELECT termsconditions FROM #__cam_vendor_aboutus WHERE vendorid=".$master." "; 
					$db->setQuery($sql_terms);
					$terms_exist = $db->loadResult();
				if($terms_exist == '1'){
					$sql = "SELECT accepted FROM #__cam_vendor_terms WHERE masterid=".$master." and vendorid=".$BID_Vendors_info[$v]->proposedvendorid." ";
					$db->setQuery($sql);
					$terms = $db->loadResult();
					
						if($terms == '1'){
						$color_stand = 'green' ;
						$standards = "<span style='color:green; font-weight:bold;'>Yes</span>";
						}
						else {
						$color_stand = 'red' ;
						$standards = "<span style='color:#ff6264; font-weight:bold;'>No</span>";
						}
					}
					else{
						$color_stand = 'green' ;
						$standards = "<span style='color:green; font-weight:bold;'>Yes</span>";
					}	
					
				}
				else
				{
					$color_stand = 'red' ;
					$standards = "<span style='color:#ff6264; font-weight:bold;'>No</span>";
				}	
	}			

					  else{
					    $color_stand = '' ;
						$standards = "<span>N/A</span>";
					  } 
		
if( $RFP_info->jobtype == 'yes' ){
	$standards = $BID_Vendors_info[$v]->c_status;
	$color_stand = '';
}
else{
	$standards = $standards ;
	$color_stand = $color_stand ;
}

			   
                         $htmlcontent .= '<tr><td height="10" bgcolor="#f3f9e8" valign="middile" style="border:0.5px solid #b7b7b7;  font-weight:bold; text-align:center; "><table cellpadding="2" cellspacing="1"><tr><td>'.$onfile.'</td></tr></table></td></tr><tr><td height="16" bgcolor="#f3f9e8" style="font-size:24px; border:0.5px solid #b7b7b7; text-align: center; font-weight:bold; color:'.$color_stand.'">'.$standards.'</td></tr><tr><td height="45" style="font-size:26px; border:0.5px solid #b7b7b7;  text-align: center; "><br/><br/>'.$RFP_details_inhouse1.'</td></tr>';

							$class = "color:#21314d; font-size:24px;  font-family:ArialBlack; text-align: center; ";

			/*$addexp_star="SELECT add_exception FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and Alt_bid!='yes' ";
                        $db->Setquery($addexp_star);
			$star = $db->loadResult();
							if($star == '' || $star == 'None' || $star_final=='(list all exceptions here)'){
							$as = '';
							 $footer_note[] = '';
							}
							else{
							 $as = '<font color="#ff6264">* </font>';
							  $footer_note[] = 'yes';
							}
                         *
                         */
//Changed by sateesh

$addexpr="SELECT count(add_exception) FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and Alt_bid='yes' and add_exception!='(list all exceptions here)' and check_exception='on' ";
							$db->Setquery($addexpr);
							$star_final = $db->loadResult();
                                                      //  echo '<pre>'; print_r($star_final);
							if($star_final) {
							//echo 'anand';
                            $as = '<font color="#ff6264">* </font>';
                            $footer_note[] = 'yes';
							}
							else{
							$as = '';
							$footer_note[] = '';
							}
//Completed
//echo $as;
							if ($star_final >'0'){
							$BID_Vendors_info[$v]->proposal_total_price = $BID_Vendors_info[$v]->proposal_total_price.'<font style="color:#FF0000; font-family:ArialBlack; font-size:53px">'.$as.'</font>';
							}
		  $htmlcontent .= '<tr><td height="23" valign="middle" bgcolor="#21314d" style="'.$class.'; border:0.5px solid #b7b7b7; font-size:42px; font-weight:bold; font-family:ArialBlack; color:#fff;">$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr>';
							$db = JFactory::getDBO();
							$sql = "SELECT proposal_total_price FROM #__cam_vendor_proposals where Alt_bid = 'yes' AND rfpno = ".sprintf('%d', $RFP_info->id)." AND proposaltype = 'Submit' AND proposedvendorid =".$BID_Vendors_info[$v]->proposedvendorid;
							$db->Setquery($sql);
							$Alt_Price = $db->loadResult();
							//if($Alt_Price != '')
							//{$res = 'Yes'; } else $res = 'No';
			/*$htmlcontent .=  '<tr><td height="15" style="font-size:19px ;text-align: center; color:#464646;   font-family:ArialBlack;">'.$res.'</td></tr>';*/
			if($Alt_Price != '')
			$Alt_Price = number_format( $Alt_Price ,2,'.',',' );
			//echo '<pre>'; print_r($Alt_Price);
			if($Alt_Price != '') $Alt_Price = '$'.$Alt_Price; else $Alt_Price = 'No';
			$htmlcontent .= '<tr><td height="17" valign="middle" style="font-size:30px; border:0.5px solid #b7b7b7; font-weight:bold; text-align: center; color:#000; font-family:ArialBlack;">'.$Alt_Price.'</td>
		  </tr>';
			$htmlcontent .= '</table></td>';
								}//inner if loop
							  }//end for loop
							 }//if loop
							 //exit;
			//$htmlcontent .= '</tr></table></td></tr></table>';
                        $htmlcontent .= '</tr>';
if(in_array('yes',$footer_note)){
			$htmlcontent .= '<tr><td align="left" vaign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star.png" /> Designates exception for 1 or more line items. Please see vendor notes for details.</td></tr>';
}
   //echo '<pre>'; print_r($wcresult);


         if(in_array('yes',$wcresult)){

                           $htmlcontent .= '<tr><td align="left" valign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star-two.png" /> A certificate of exemption from the state is on file,however there is no actual policy in place to protect the community from liability in the event that a subcontractor is injured on the job(including claims for lost wages)</td></tr>';
}
                     // $htmlcontent .= '<tr><td align="right" colspan="4"><a href="'.JURI::root().'index.php?option=com_camassistant&controller=rfpcenter&task=closedrfp&Itemid=89" target="_blank"><img src="'.JURI::root().'components/com_camassistant/assets/images/award-bg.jpg" target="_blank"/></a> </td></tr>';
                           $htmlcontent .= '</table>';

			$style = array('color' => array(220, 220, 220));
			$style7 = array('width' => 0.1, 'color' => array(220, 220, 220));
			$pdf->SetLineStyle($style7);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0);
		
		//echo "FOURTH".$htmlcontent;

		if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
		/********************  End of 4th Page TASKS SUMMARY  ********************/
     } //exit;//end - for($loop_start=0, $loop_stop=1; $loop_start<count($BID_AltVendors_info); $loop_start++,$loop_stop++)

	/*********************** code to display vendor info htmlcontent *******************/

	 /********************  RFP LINE ITEMS ADN VENDOR RESPONSES  *******************/

		$TASKS_summary = $TASK_details;
		$NOTES_summary = $NOTES_details;
		$ALTNOTES_summary = $ALTNOTES_details ;
		$ALTEXCEPTION_details = $ALTEXCEPTION_details;
		$RFP_NOTES_summary = $tasks_list;
		$vendors_cnt = $vendor_ids;
 if(count($RFP_NOTES_summary)>1){
$pdf->AddPage();

$remainder = count($BID_Vendors_info)%3;
	 $quotient = intval(count($BID_Vendors_info)/3);
	 $total = count($BID_Vendors_info);
$filename = $pat.'properymanager/'.$RFP_info->comp_logopath;
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
	if($remainder == 0)
	$loop_iterator = $quotient;
	else
	$loop_iterator = $quotient+1;

 for($loop_start=0, $loop_stop=1; $loop_start<$loop_iterator; $loop_start++,$loop_stop++)
    {
$lineitemprice='
<table width="630" border="0" cellspacing="0" cellpadding="0">


      <tr>
        <td width="36%">'; $pdf->Image('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/images/properymanager/'.$RFP_info->comp_logopath, 10, 10, $width, $height, "", "", "", true, 550,'', false, false, 0, false, false, false);
      $lineitemprice.='  </td>

	<td width="315px" style="text-align: right; font-size:24px;"><img width="50" height="14" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong>'.$RFP_info->comp_name.'</strong><br />
		'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.',  '.$state_name.' '.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')&nbsp;'.$com_phone[1].'-'.$com_phone[2].'</td></tr>

 <tr><td></td></tr><br/>
  <tr>
   <td height="20" width="88.5%" align="center" style="font-size:30px;  font-family:Arial; font-weight:bold;"><table border="0" align="center" cellspacing="2" cellpadding="2"><tr><td align="center" style="text-align:center;">
<div>ITEMIZED PRICING BREAKDOWN</div>
   </td></tr> </table></td>
  </tr><tr><td width="140" align="left" valign="middle"><table width="100%" border="0" cellspacing="2" cellpadding="2"><tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; height:15px;"><p style="font-size:25px; font-weight:bold; color:#FFF;">DESCRIPTION</p></td></tr> <tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:60px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/><br/></p></td></tr><tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7;  font-family:ArialBlack; height:40px;"><p style="font-size:26px; color:#000; font-weight:bold;"><br/>Company Name:</p></td></tr>';
  $line_cnt=count($RFP_NOTES_summary);
							 if($line_cnt>0)
							 {
							 for($li=0; $li<$line_cnt; $li++)
							 {
                                                                       //echo '<pre>'; print_r($RFP_NOTES_summary[$li]);
									 $cnt_Task_Prices = count($RFP_NOTES_summary[$li]->task_id);
									 for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
									  	//echo '<pre>'; print_r($RFP_NOTES_summary[$li]);
							$lineitemprice .= ' <tr> <td align="center" height="59" valign="middle" style="border:0.5px solid #b7b7b7;"><br/><font style="font-size:26px;  font-family:Arial; font-weight:bold; color:#000;">Line Item #'.($li+1).' Pricing:</font> <font style="font-size:26px; font-family:Arial;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr>';


									 }
                                                                   }
                                                                 }

$lineitemprice.='<tr><td align="center" valign="middle" bgcolor="gray" style="border:0.5px solid #b7b7b7; font-family:ArialBlack; height:30px;"><table cellpadding="5" cellspacing="3"><tr><td style="font-size:22px; font-family:Arial Black; color:#fff; font-weight:bold;"> TOTAL AMOUNT PROPOSED:</td></tr></table></td></tr></table></td>';
//echo '<pre>'; print_r($BID_Vendors_info); exit;
      // for($v=0,  $count1 = count($BID_Vendors_info); $v< $count1; $v++)
						 if($cnt>0)
							  {	//{


         //  echo '<pre>'; print_r($BID_Vendors_info);
          // $cnt=count($BID_Vendors_info);
							  for($v=(3*$loop_start); $v<(3*$loop_stop); $v++) {
							  if($v<$total){
							  $full = $total-$remainder;
							  if( $v < $full){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								} else if($remainder == 1){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 2){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 3){
			$lineitemprice .=  '<td width="140" align="left" valign="middle">';
								}
								else if($remainder == 0){
			$lineitemprice .=  '<td width="100%" align="left" valign="middle">';
								}
			$lineitemprice .=   '<table width="100%" border="0" cellspacing="2" cellpadding="2">';

 if($BID_Vendors_info[$v]->image != ''){
								$vendor_image = $pat.'vendors/pdf_resized/'.$BID_Vendors_info[$v]->image;
								if (!file_exists($vendor_image)) {
									$BID_Vendors_info[$v]->image = 'noimage1.gif';
									} else
									$BID_Vendors_info[$v]->image = $BID_Vendors_info[$v]->image;
							 } else { $BID_Vendors_info[$v]->image = 'noimage1.gif'; }

          // echo '<pre>'; print_r($BID_Vendors_info);
    $lineitemprice.='
 <tr> <td align="center" valign="middle" bgcolor="#7ab800" style="border:0.5px solid #b7b7b7; height:15px;"><p style="font-size:24px; color:#FFF; font-weight:bold;">VENDOR'.($v+1).'</p></td></tr>

    <tr><td align="center" valign="middle" style="border:0.5px solid #b7b7b7; height:60px;"><p style="font-size:21px; color:#000;"><img src="components/com_camassistant/assets/images/vendors/pdf_resized/'.$BID_Vendors_info[$v]->image.'"  /></p></td></tr>


    <tr><td align="center" valign="middle" bgcolor="#f3f9e8" style="border:0.5px solid #b7b7b7; height:40px; font-size:24px;color:#000;"><br/><br/>'.$BID_Vendors_info[$v]->company_name.'</td></tr>';
     $line_cnt=count($RFP_NOTES_summary);

							 //for($li=0; $li<$line_cnt; $li++)
							 //{
  $cnt_prices=count($TASKS_summary);

								 for($TP=0; $TP<$cnt_prices; $TP++)
								 {
                                                                    //echo '<pre>'; print_r($TASKS_summary[$TP]);
								  // if($RFP_NOTES_summary[$li]->task_id == $TASKS_summary[$TP]->task_id)
								  // {
                  $addexpr="SELECT add_exception,check_exception FROM #__cam_rfpsow_addexception where add_exception!='' and rfp_id='".$RFP_info->id."' AND vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' AND task_id='".$TASKS_summary[$TP]->task_id."' AND Alt_bid='yes' ";
							$db->Setquery($addexpr);
							$star_final = $db->loadObjectList();
//echo '<pre>'; print_r($star_final);
							if($star_final[0]->add_exception && $star_final[0]->add_exception!='(list all exceptions here)' && $star_final[0]->check_exception=='on') {
							$as = '<span style="color:#ff6264; font-size:45px">*</span>';
                                                         $footer_note[] = 'yes';
							} else {
                                                            $as = '';
                                                        }
                                                        $cnt_Task_Prices = count($TASKS_summary[$TP]->task_price);
                                                                       // if($cnt_Task_Prices != '0'){
                                                                         // $prev_price_cnt = $cnt_Task_Prices;
                                                                      //  }//else if($cnt_Task_Prices == '0')
                                                                            // $cnt_Task_Prices = $prev_price_cnt;
                                                                        //echo $cnt_Task_Prices;
$lineitems_prices="SELECT item_price FROM #__cam_rfpsow_docs_lineitems_prices where vendor_id='".$BID_Vendors_info[$v]->proposedvendorid."' and item_id=".$TASKS_summary[$TP]->task_id;
							$db->Setquery($lineitems_prices);
							$lineitemsprices = $db->loadResult();
							//echo '<pre>'; print_r($lineitemsprices);
									// if($cnt_Task_Prices == 0 || !$lineitemsprices)
									if($cnt_Task_Prices == 0 || !$lineitemsprices)
									{
											$lineitemprice .= '<tr><td align="center" valign="middle" height="59" style="border:0.5px solid #b7b7b7; font-size:30px; font-family:Arial Black; color:#000; font-weight:bold;"><br/><br/>Included In Total Price</td></tr>';
											//exit;
									} else {

									 for($B=0; $B<$cnt_Task_Prices; $B++)
									 {
                                                                         // echo $TASKS_summary[$TP]->task_price[$B]->item_price; echo '---'; echo $B; echo '<br>';
									    if($TASKS_summary[$TP]->task_price[$B]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{

                                                               // echo $as;
                                      $TASKS_summary[$TP]->task_price[$B]->item_price=str_replace('(Line-Item Pricing)','0.00',$TASKS_summary[$TP]->task_price[$B]->item_price);
                                      if($TASKS_summary[$TP]->task_price[$B]->item_price){
                                      $TASKS_summary[$TP]->task_price[$B]->item_price=$TASKS_summary[$TP]->task_price[$B]->item_price;
                                      } else {
                                      $TASKS_summary[$TP]->task_price[$B]->item_price='0.00';
                                      }
				  $lineitemprice .= '<tr><td align="center" valign="middle" height="59" style="border:0.5px solid #b7b7b7; font-size:35px; font-family:Arial Black; color:#000; font-weight:bold;"><br/><br/>$'.$TASKS_summary[$TP]->task_price[$B]->item_price.''.$as.'</td></tr>';
										 // }


									//  }
									 //}

}

                                                        }
                                                         }
                                                    }


	$lineitemprice .='<tr><td height="30" valign="middle" bgcolor="#21314d" style="'.$class.'; border:0.5px solid #b7b7b7; font-size:35px; font-weight:bold; font-family:ArialBlack; color:#fff;"><table cellpadding="3" cellspacing="2"><tr><td>$'.$BID_Vendors_info[$v]->proposal_total_price.'</td></tr></table></td></tr></table></td>';

        }
    }
                                                          }

 $lineitemprice .='</tr>';

  if(in_array('yes',$footer_note)){
  $lineitemprice.='<tr>
    <td  align="left" vaign="top" style="font-size:23px; align:left;" colspan="4"><img  src="components/com_camassistant/assets/images/star.png" /> Designates exception for 1 or more line items.  Please see vendor notes on the following pages for details.</td>
  </tr>';
  }
$lineitemprice .='</table>';


							 //$lineitemprice .='</tr></table>';
     //    echo '<pre>'; print_r($lineitemprice);
$pdf->writeHTML($lineitemprice, true, 0, true, 0);

  if($loop_start < $loop_iterator-1){
		$pdf->AddPage();
		}
 } //exit;
/***************************************** RFP LINE ITEMS AND VENDOR RESPONSES ****************************************/
             }


		//echo "<pre>"; print_r($TASKS_summary); exit;
			// add a page
		   $line_cnt=count($RFP_NOTES_summary);
							 if($line_cnt>0)
							 {
							 for($li=0; $li<$line_cnt; $li++)
							 {
							 $lid = $li+1;
							 if($RFP_NOTES_summary[$li]->title == '')
							 $RFP_NOTES_summary[$li]->title = 'NONE';
			//$htmlcontent5 .='<tr><td colspan="2" style="font-size:20px; text-align: left;"><span style="color:#21314d; font-weight:bold;"><br /><br />LINE ITEM #'.$lid.':</span> '.$RFP_NOTES_summary[$li]->task_desc.'<p style="color:#7ab800; font-weight:bold;">Attachment #'.$lid.': '.$RFP_NOTES_summary[$li]->title.'</p></td></tr>';
			$RFP_NOTES_summary[$li]->task_desc = trim($RFP_NOTES_summary[$li]->task_desc);
							if($li == 0){
							 $RFP_NOTES_summary[$li]->task_desc = nl2br($RFP_NOTES_summary[$li]->task_desc);
							 }
							 else {
							 $RFP_NOTES_summary[$li]->task_desc = nl2br(wordwrap($RFP_NOTES_summary[$li]->task_desc, 140, "\n"));
							 }
 $pdf->AddPage();
 if( $RFP_info->jobtype == 'yes' ){	
 $htmlcontent5 ='<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px"><tr><td colspan="2">';
		 $htmlcontent5.='<tr><td width="100%" height="15" style="font-size:32px; text-align: left; vertical-align:middile; color:#000; font-weight:bold;" valign="middile"><font style="font-size:26px;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr><tr><td colspan="3" style="font-size:30px; text-align: left;" width="500px"><font style="font-size:23px;" width="500px">'.$RFP_NOTES_summary[$li]->task_desc.'</font><p style="color:#7ab800; font-weight:bold; font-size:24px;">';
}
else{
		$htmlcontent5 ='<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px"><tr><td colspan="2">';	
		 $htmlcontent5.='<tr><td width="100%" height="15" style="font-size:32px; text-align: left; vertical-align:middile; color:#000; font-weight:bold;" valign="middile">LINE ITEM #'.$lid.': <font style="font-size:26px;">'.$RFP_NOTES_summary[$li]->linetaskname.'</font></td></tr><tr><td colspan="3" style="font-size:30px; text-align: left;" width="500px"><font style="font-size:23px;" width="500px">'.$RFP_NOTES_summary[$li]->task_desc.'</font><p style="color:#7ab800; font-weight:bold; font-size:24px;">File(s) Provided to Vendors: ';
}


			//echo "anand"; print_r($link); exit;
			  if($RFP_NOTES_summary[$li]->taskuploads!==''){
			 $uploads=explode('/',$RFP_NOTES_summary[$li]->taskuploads);
//echo '<pre>'; print_r($RFP_NOTES_summary[$li]->taskuploads); exit;
			 $upcount=count($uploads);
			 $attach= $uploads[$upcount-1];

			 $db =& JFactory::getDBO();
			/* $property_details="SELECT tax_id FROM #__cam_property where property_name ='".$RFP_info->property_name."'";
			$db->Setquery($property_details);
			$tax_id = $db->loadResult(); */

         	$pid1 = 'SELECT property_id FROM #__cam_rfpinfo WHERE id = '.$RFP_info->id ;
		$db->Setquery($pid1);
		$pid = $db->loadResult();
		//echo '<pre>'; print_r($pid);
		$details = 'SELECT property_name,tax_id FROM #__cam_property WHERE id = '.$pid ;
		$db->Setquery($details);
		$details1 = $db->loadObjectList();
		//echo '<pre>'; print_r($details1);
		 $default ='components/com_camassistant/doc/';
		$file_link1 = $default.str_replace(' ','_',$details1[0]->property_name).'_'.$details1[0]->tax_id.'/';
                for($i=0; $i<count($RFP_NOTES_summary[$li]->taskuploads); $i++)
		{

                $RFP_NOTES_summary[$li]->taskuploads = str_replace(' ,','',$RFP_NOTES_summary[$li]->taskuploads);
                $RFP_NOTES_summary[$li]->taskuploads = str_replace(',,',',',$RFP_NOTES_summary[$li]->taskuploads);
                $uploads= explode(',',$RFP_NOTES_summary[$li]->taskuploads );

                if(count($uploads)>0 && count($RFP_NOTES_summary[$li]->taskuploads)>0 ){

                    for ($l=0;$l<count($uploads);$l++){  
               $uploads1=explode('/',$uploads[$l]);
             // echo '<pre>'; print_r($uploads[$l]);
             if($uploads[$l]){
                 $uploads23=explode('/',$uploads[$l]);

              if($uploads23[0]=='components' && $uploads23[1]=='com_camassistant' && $uploads23[2]=='assets' ){
             $file_link = str_replace(' ','',$uploads[$l]);
             } else {
             $file_link = $default.str_replace(' ','_',$details1[0]->property_name).'_'.$details1[0]->tax_id.'/'.str_replace(' ','',$uploads[$l]);
             }
             //echo '<pre>'; print_r($file_link); // $file_link=$file_link1
   $upcount=count($uploads1); $file= $uploads1[$upcount-1];

  $htmlcontent5 .='&nbsp;<span style="font-size:20px; font-color:#000;" color="#000"><a style="text-decoration:none; color:#000; font-color:#000;" href="'.JURI::root().'index.php?option=com_camassistant&controller=popupdocs&task=open&title='.$file.'&path='.$file_link.'">'.$file.'</a></span>&nbsp;&nbsp;&nbsp;';
  //echo '<pre>'; print_r($tasks_list[$i]->file_path);
 } } }
// $tasks_list[$i]->file_path = $tasks_listfile_path;
 //echo '<pre>'; print_r($tasks_list[$l]->file_path);

 }
			//$default = 'http://camassistant.com/live/components/com_camassistant/doc/';
			//$file_link = $default.$RFP_info->property_name.'_'.$tax_id.'/';
			//$htmlcontent5 .= '<font style="font-size:22px;">'.$RFP_NOTES_summary[$li]->file_path.'</font>';
			// $htmlcontent5 .= '<a href="http://camassistant.com/live/index.php?option=com_camassistant&controller=popupdocs&task=open&title='.$RFP_NOTES_summary[$li]->taskuploads.'&path='.$file_link.'"> '.$RFP_NOTES_summary[$li]->taskuploads.'</a>';
			 } else {
			 $htmlcontent5 .= '';
			 }
			 $htmlcontent5 .= '</p></td></tr><br />';
							// for($v=(6*$loop_start); $v<(6*$loop_stop); $v++)
							for($v=0; $v<count($BID_Vendors_info); $v++)
							{
							 $x = 0;
							 if($v%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							 $vid = $v+1;
			$htmlcontent5 .='<table width="100%" border="0" cellpadding="3" cellspacing="0">';
			$htmlcontent5 .='<tr><td height="15" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px ; text-align: center; ">'.$BID_Vendors_info[$v]->company_name.':</td>';

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
										 $htmlcontent5 .= '<td style="font-size:24px; font-color:#fff;" bgcolor="gray" color="#fff"><b>LINE ITEM PRICE:</b>&nbsp;<strong>$ '.$TASKS_summary[$TP]->task_price[$B]->item_price.'</strong></td>';
										  }
										  else
										  {
										  $htmlcontent5 .= '<td style="font-size:24px; font-color:#fff;" bgcolor="gray" color="#fff"><b>LINE ITEM PRICE:</b>&nbsp;NONE</td>';
										  }
									  }
									 }
								 }
								}
							}
							 $htmlcontent5 .='</tr>';
			/******************************************code to display NOTES*******************************************/
							$cnt_tasks=count($ALTNOTES_summary);
							$htmlcontent5 .= '<tr><td border="1" width="100%" height="15" style="font-size:24px ;text-align: left; ">';
							if($cnt_tasks>0)
							{
							$flag = 0;
							
								 for($T=0; $T<$cnt_tasks; $T++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $ALTNOTES_summary[$T]->task_id)
								   {
									 $cnt_notes = count($ALTNOTES_summary[$T]->task_notes);
									 //echo "<pre>"; print_r($NOTES_summary[$T]->task_notes);
									 for($N=0; $N<$cnt_notes; $N++)
									 {
										if($ALTNOTES_summary[$T]->task_notes[$N]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
										  if($ALTNOTES_summary[$T]->task_notes[$N]->add_notes != '')
									      {
									       $ALTNOTES_summary[$T]->task_notes[$N]->add_notes= str_replace('&acirc;','NONE',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);
$ALTNOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('font-size','font-size:22px ',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);
$ALTNOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('line-height','',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);
$ALTNOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('text-indent','',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);
$ALTNOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('img','',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);										$ALTNOTES_summary[$T]->task_notes[$N]->add_notes = str_replace('width','',$ALTNOTES_summary[$T]->task_notes[$N]->add_notes);   


$html = html_entity_decode($ALTNOTES_summary[$T]->task_notes[$N]->add_notes) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);	

										  $notes = '<span style="font-size:24px;"><b>NOTES: </b>'.$html_notes.'</span>';
										  }
										  else
										  {
										  $notes = '<span style="font-size:24px;"><b>NOTES: </b>NONE</span>';
										  }
									    }
									 }
								 }
								}
							}
           if($notes=='' || !$notes){
           $htmlcontent5 .=  '<span style="font-size:24px;"><b>NOTES: </b>NONE</span>';
        } else {
           $htmlcontent5 .=  $notes;
        }
				/******************************************code to display EXCEPTION *******************************************/
				$cnt_excep=count($ALTEXCEPTION_details);
					if($cnt_excep>0)
							{
							$flag = 0;
								 for($E=0; $E<$cnt_excep; $E++)
								 {
								   if($RFP_NOTES_summary[$li]->task_id == $ALTEXCEPTION_details[$E]->task_id)
								   {
									 $cnt_Excep = count($ALTEXCEPTION_details[$E]->task_exception);
									 for($F=0; $F<$cnt_Excep; $F++)
									 {
									    if($ALTEXCEPTION_details[$E]->task_exception[$F]->vendor_id == $BID_Vendors_info[$v]->proposedvendorid  )
										{
                                                                                 $note_exe= $ALTEXCEPTION_details[$E]->task_exception[$F]->check_exception;
										  if($ALTEXCEPTION_details[$E]->task_exception[$F]->add_exception != '' && $ALTEXCEPTION_details[$E]->task_exception[$F]->add_exception!='(list all exceptions here)')
									      {
										  $EXCEPTION = '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S):</b>&nbsp;'.nl2br($ALTEXCEPTION_details[$E]->task_exception[$F]->add_exception).'</span>';
										  }
										  else
										  {
										  $EXCEPTION = '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S):</b>&nbsp;NONE</span>';
										  }
									  }
									 }
								 }
								}
							}
          if($EXCEPTION=='' || !$EXCEPTION || $note_exe==''){
           $htmlcontent5 .=  '<br /><br /><span style="color:#FF0000; font-size:24px;"><b>EXCEPTION(S):</b>&nbsp;NONE</span>';
        } else {
           $htmlcontent5 .=  $EXCEPTION;
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
                                                                                      //echo '<pre>'; print_r($TASKS_summary[$A]->vendor_uploads[$B]);
										  $htmlcontent5 .= '<p><b>ATTACHMENT(S):</b>&nbsp;'.$TASKS_summary[$A]->vendor_uploads[$B]->title.'</p>';
										  }
										  else
										  {
										  $htmlcontent5 .= '<p><b>ATTACHMENT(S):</b>&nbsp;NONE</p>';
										  }
									  }
									 }
								 }
								}
							}
				/******************************************code to display vendor line item prices *******************************************/
			/*	$cnt_prices=count($TASKS_summary);
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
									    if($TASKS_summary[$TP]->task_price[$B]->vendor_id == $BID_AltVendors_info[$v]->proposedvendorid  )
										{
										  if($TASKS_summary[$TP]->task_price[$B]->item_price != '')
									      {
										  $htmlcontent5 .= '<p><b>LINE ITEM PRICE:</b>&nbsp;<br />$ '.$TASKS_summary[$TP]->task_price[$B]->item_price.'</p>';
										  }
										  else
										  {
										  $htmlcontent5 .= '<p><b>LINE ITEM PRICE:</b>&nbsp;NONE</p>';
										  }
									  }
									 }
								 }
								}
							}	*/


							$htmlcontent5 .='</td></tr><tr style="font-size:11px;"><td></td></tr>';
							$htmlcontent5 .= '</table>';
							}//end inner for loop
							 $htmlcontent5 .= '</td></tr>';
                                                   $htmlcontent5 .= '</table>'; 
												   $pdf->writeHTML($htmlcontent5, true, 0, true, 0);  }//end main for loop
							}//if($line_cnt>0)
		    //$htmlcontent5 .= '</td></tr>';
			//$htmlcontent5 .= '</table>';
		/**************** END RFP LINE ITEMS AND VENDOR RESPONSES *********************/
		$pdf->AddPage();
		 $vendors_cnt = $vendor_ids;
		 //echo "<pre>"; print_r($BID_AltVendors_info);
$warranrtyinformation = '<table width="550px" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';
						//$pdf->Image($pat.'properymanager/'.$RFP_info->comp_logopath, 10, 10, "70", "24", "", "", "", true, 100);
			//$htmlcontent4 .= '<tr><td width="205px" height="50" align="left" ></td><td width="345px" style="text-align: left; font-size:21px;"><img width="50" height="12" src="templates/camassistant_left/images/mc_headicons.jpg" /><br/><strong><br/>'.$RFP_info->comp_name.'</strong><br />'.$RFP_info->mailaddress.'<br />'.$RFP_info->comp_city.','.$RFP_info->comp_state.$RFP_info->comp_zip.'<br /><strong>P</strong>: ('.$com_phone[0].')'.$com_phone[1].'-'.$com_phone[2].'</td></tr>';

		//$htmlcontent4 .='<tr style="height:5px;"><td align="left" colspan="2" style="font-size:5px;"><hr /><br /></td></tr>';

			//$warranrtyinformation .='<tr><td colspan="2" height="15" bgcolor="#21314d" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:28px ; text-align: center; ">GENERAL NOTES  & EXCEPTIONS & WARRANTY:</td></tr>';
			if( $RFP_info->jobtype == 'yes' ){
				$warranrtyinformation .='<tr><td colspan="2" height="15" style="color:#000; font-weight:bold; font-family:Arial; font-size:30px ; text-align: center; ">WARRANTY:</td></tr>';
			}
			else {
			$warranrtyinformation .='<tr><td colspan="2" height="15" style="color:#000; font-weight:bold; font-family:Arial; font-size:30px ; text-align: center; ">GENERAL NOTES & WARRANTY:</td></tr>';
			}
			//This is for general notes and general exceptions
		$warranrtyinformation .='<tr><td colspan="2"><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:23px; text-align: left; ">';
		$count=count($BID_Vendors_info);
							if($BID_Vendors_info>0){

							for($w=0; $w<count($BID_Vendors_info); $w++) {

							$db =& JFactory::getDBO();
							$cnt = $v+1;
							 if($w%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							  if($w != 0)
							$warranrtyinformation .= '<p></p>';
							$warranrtyinformation .=  '<table width="100%" cellpadding="3"><tr align="center"><td colspan="2" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:24px;">'.$BID_Vendors_info[$w]->company_name.':</td></tr></table>';

		if( $RFP_info->jobtype != 'yes' ){	
		 $add_notes = 'SELECT add_notes FROM #__cam_rfpsow_addnotes WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$w]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$w]->proposedvendorid.' AND Alt_bid="yes"';
		  $db->Setquery($add_notes);
		  $add_notes1 = $db->loadResult();
		  $add_notes1 = str_replace('font-size','font-size:22px ',$add_notes1);
		  $add_notes1 = str_replace('line-height','',$add_notes1);
		  $add_notes1 = str_replace('text-indent','',$add_notes1);
		  $add_notes1 = str_replace('img','',$add_notes1);
		  $add_notes1 = str_replace('width','',$add_notes1);
		  
		  //echo '<pre>'; print_r( $add_notes1);
		   if($add_notes1 != ''){
$html = html_entity_decode($add_notes1) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);			   
		 $warranrtyinformation .= '<br /><font style="font-size:24px; font-weight:bold;">GENERAL NOTES:</font><br/>'.$html_notes.'';
		 }
		 else{
		 $warranrtyinformation .= '<br /><font style="font-size:24px; font-weight:bold;">GENERAL NOTES:</font><br/>NONE';
		 }
		 }
		 else{	
		 $add_notes = 'SELECT add_notes FROM #__cam_rfpsow_addnotes WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$w]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$w]->proposedvendorid.' AND Alt_bid="yes"';
		  $db->Setquery($add_notes);
		  $add_notes1 = $db->loadResult();
		  $add_notes1 = str_replace('font-size','font-size:22px ',$add_notes1);
		  $add_notes1 = str_replace('line-height','',$add_notes1);
		  $add_notes1 = str_replace('text-indent','',$add_notes1);
		  $add_notes1 = str_replace('img','',$add_notes1);
		  $add_notes1 = str_replace('width','',$add_notes1);
		  //echo '<pre>'; print_r( $add_notes1);
		   if($add_notes1 != '')
		   {
$html = html_entity_decode($add_notes1) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);		   
		 $warranrtyinformation .= '<br /><font style="font-size:24px; font-weight:bold;">PROPOSAL NOTES:</font><br/>'.$html_notes.'';
		 }
		 else{
		 $warranrtyinformation .= '<br /><font style="font-size:24px; font-weight:bold;">PROPOSAL NOTES:</font><br/>NONE';
		 }
		 }
		 
		  $add_exception = 'SELECT add_exception FROM #__cam_rfpsow_addexception WHERE spl_req="Yes" AND rfp_id = '.$BID_Vendors_info[$w]->rfpno.' AND vendor_id= '.$BID_Vendors_info[$w]->proposedvendorid. ' AND Alt_bid="yes"';
		  $db->Setquery($add_exception);
		  $add_exception1 = $db->loadResult();
		   // echo '<pre>'; print_r( $add_exception1);
		  /* if($add_exception1 != '')
		 $warranrtyinformation .= '<br /><br /><font style="color:#FF0000; font-size:24px; font-weight:bold;">GENERAL EXCEPTION(S):</font><br/>'.nl2br($add_exception1).'';
		 else
		$warranrtyinformation .= '<br /><br /><font style="color:#FF0000; font-size:24px; font-weight:bold;">GENERAL EXCEPTION(S):</font><br/>None<br />';
                   *
                   */
                 $db =& JFactory::getDBO();
			 $sql = "SELECT warranty_filepath,warranty_file_text,warranty_file_area FROM #__cam_vendor_proposals where rfpno = ".$BID_Vendors_info[$w]->rfpno." AND Alt_bid='yes' AND proposedvendorid=".$BID_Vendors_info[$w]->proposedvendorid;
				$db->Setquery($sql);
				$warranty = $db->loadObjectList();
				//echo '<pre>'; print_r($warranty);
				$x = 0;
							 if($w%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							 $wid = $w+1;
							 	//$warranrtyinformation .='<tr><td height="15" width="35%" bgcolor="'.$class.'" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: left; ">VENDOR '.$wid.' warranrtyinformation:</td></tr>';
							$warrantylink='<a style="color:#7AB800; text-decoration:none;" href="'.JURI::root().'index2.php?option=com_camassistant&controller=proposals&task=downloadfile&title='.$warranty[0]->warranty_file_text.'&path='.$warranty[0]->warranty_filepath.'">'.$warranty[0]->warranty_file_text.'</a>';
				 if($warranty[0]->warranty_file_text != '' && $warranty[0]->warranty_filepath != '')
				{
				$warrantylink1 = $warrantylink;
				}
				else {
				$warrantylink1 = 'No Files';
				}
				if($warranty[0]->warranty_file_area != '')
				{
				$warranty_file_area = $warranty[0]->warranty_file_area;
				}
				else{
				$warranty_file_area = 'No text entered. If no attachment is provided, please contact vendor.';
				}



					if($warranty_file_area != ''){
					$warranty_file_area = str_replace('font-size','font-size:22px ',$warranty_file_area);
		  			$warranty_file_area = str_replace('line-height','',$warranty_file_area);
					$warranty_file_area = str_replace('text-indent','',$warranty_file_area);
					$warranty_file_area = str_replace('img','',$warranty_file_area);
					$warranty_file_area = str_replace('width','',$warranty_file_area);
$html = html_entity_decode($warranty_file_area) ;
$html = preg_replace('/(<p.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<span.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<ul.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<div.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html = preg_replace('/(<li.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<a.+?)style=".+?"(>.+?)/i', "$1$2", $html);
$html_notes = preg_replace('/(<td.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h1.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h2.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h3.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h4.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h5.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h6.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<h7.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/(<font.+?)style=".+?"(>.+?)/i', "$1$2", $html_notes);
$html_notes = preg_replace('/[^(\x20-\x7F)]*/','', $html_notes);
$html_notes = str_replace('?','.', $html_notes);
$html_notes = str_replace('h4','h3', $html_notes);
$html_notes = str_replace('h6','h3', $html_notes);	
					
					$warranrtyinformation .= '<br /><br /><strong>WARRANTY: </strong><br />'.$html_notes;
					} else {
				$warranrtyinformation .= '<br /><br />WARRANTY: No text entered. If no attachment is provided, please contact vendor.';
				 }
				 if($warrantylink1 != ''){
					 $warranrtyinformation .= '<br /><br /><strong>ATTATCHMENT(S):</strong> '.$warrantylink1;
					} else {
					  $warranrtyinformation .= '<br /><br /><strong>ATTATCHMENT(S):</strong> No Files ';
					}
} }
		$warranrtyinformation .= '</td></tr></table></td></tr></table>';



//echo 'anand__';
	 //$warranrtyinformation;
	// exit;
		$pdf->writeHTML($warranrtyinformation, true, 0, true, 0);
//$BID_AltVendors_info
		/* $vendors_cnt_alt = $this->vendors_cnt;
//echo '<pre>'; print_r($BID_AltVendors_info);
		for($s=0; $s<count($BID_AltVendors_info); $s++) {
 $other_price_sql_s1 = "SELECT `price_other_items` FROM #__cam_vendor_proposals  where rfpno='".$RFP_info->id."' AND (proposaltype='Submit'Or proposaltype='resubmit') AND proposedvendorid  ='".$BID_AltVendors_info[$s]->proposedvendorid. "' AND Alt_bid = 'yes' ";
							$db->setQuery($other_price_sql_s1);
							$other_price_s1 = $db->loadResult();
                            print_r($other_price_s1);
							if($other_price_s1) {
							$other_price_s2[] = $other_price_s1;
							}
}

$arr1=array_unique($other_price_s2);
//echo 'anand1'; echo '<pre>'; print_r($arr1);
if(count($arr1)==1 && $arr1[0]==0.00){

//echo '<pre>';print_r(array_unique($other_price_s));
}

else{
//echo 'anand';
		 $pdf->AddPage();
		 $vendors_cnt = $vendor_ids;
		 //echo "<pre>"; print_r($BID_AltVendors_info);

			$htmlaltotherprice = '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" style="padding-top:40px">';

			$htmlaltotherprice .='<tr><td colspan="2" height="15" bgcolor="#21314d" style="color:#FFF; font-weight:bold; font-family:ArialBlack; font-size:21px ; text-align: center; ">All other items, charges & fees not itemized above</td></tr>';
			//$htmlcontentotherprice .='<tr><td colspan="2"><table border="1" width="100%" cellspacing="0" cellpadding="3"><tr><td style="font-size:19px; text-align: left; ">';

							$htmlaltotherprice .= '<br/><br/>';
							$count=count($BID_AltVendors_info);
							if($BID_AltVendors_info>0){

							for($z=0; $z<count($BID_AltVendors_info); $z++) {

							$db =& JFactory::getDBO();
							 $other_price_sql = "SELECT `price_other_items` FROM #__cam_vendor_proposals  where rfpno='".$RFP_info->id."' AND (proposaltype='Submit'Or proposaltype='resubmit') AND proposedvendorid  ='".$BID_AltVendors_info[$z]->proposedvendorid. "' AND Alt_bid = 'yes' ";
							$db->setQuery($other_price_sql);
							$other_price = $db->loadResult();
                           echo $other_price;
							if($other_price){
                              // echo "NO";
							$other_price1 = $other_price;
                            } else {
							$other_price1 = '0.00';
							$other_price1 = number_format( $other_price , 2 , '.' ,',' );

                            } //exit;
//echo "PRICE".$other_price1;
							$cnt = $z+1;
							 if($z%2 == 0)
							 $class = "#7ab800";
							  else
							  $class = "#21314d";
							  if($z != 0)
							$htmlaltotherprice .= '<br/>';
							// To get the vendor company name
		 $v_alt_compname = "SELECT `company_name` FROM #__cam_vendor_company  where user_id  ='".$BID_Vendors_info[$z]->proposedvendorid. "'  ";
		 $db->setQuery($v_alt_compname);
		$vendor_comp_name_alt = $db->loadResult();
							$htmlaltotherprice .=  '<tr><td bgcolor="'.$class.'" style="color:#ffffff; font-color:#ffffff; font-weight:bold; font-family:ArialBlack; font-size:30px; height:15px; border:1px solid gray; text-align: left;" width="40%">'.$vendor_comp_name_alt.':</td><td width="20%" style="text-align: left;"  style="border:1px solid gray; color:gray; font-size:30px; font-weight:bold;">$ '.$other_price1.' </td></tr>';

							 }

							}
		//	$htmlcontentotherprice .='</td></tr></table>';
		    $htmlaltotherprice .= '</table>';

//echo 'anand__';
	//echo $htmlaltotherprice;  exit;
		$pdf->writeHTML($htmlaltotherprice, true, 0, true, 0);
	} */
	} //exit;
	//echo '<pre>'; print_r($cnt); exit;
	//end - if(count($BID_AltVendors_info)>0)
	if($cnt== 0 && $cnt1 == 0 )
	{
	$htmlcontent15 = "<font>No Proposals are Available for this RFP.  If you have questions or need assistance, please contact the CAMassistant Customer Support Team at 561-246-3830.  Thank you.</font>";
	$pdf->writeHTML($htmlcontent15, true, 0, true, 0);
	
	}
	/******* eof table pan********/
	$RFP_comp_name=str_replace('|','_',$RFP_info->comp_name);
	$RFP_comp_name1=str_replace(' ','_',$RFP_comp_name);
	//echo '<br><br>'; echo '<pre>'; print_r($RFP_info); echo '<br><br>'; exit;
	$pdf->lastPage();
	$title= $rfp_id.'_'.$RFP_comp_name1.'.pdf';
	//print_r($title);  //exit;//set title
	$pdf->SetTitle($title);//set title

	ob_end_clean();
	$upl_file_name=$pdf->Output($title, 'F');
class checkstatus
		{
			public function getmasterfirmaccount($managerid){
				$db=&JFactory::getDBO();
				$sql_man_data = "SELECT id, user_type, accounttype FROM #__users WHERE id=".$managerid." ";
				$db->setQuery($sql_man_data);
				$man_data = $db->loadObject();	
				
			if($man_data->user_type == '12'){
				$query_c = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$man_data->id." ";
				$db->setQuery($query_c);
				$cid = $db->loadResult();	
				$camfirmid = "SELECT cust_id FROM #__cam_camfirminfo WHERE id=".$cid." ";
				$db->setQuery($camfirmid);
				$camfirm = $db->loadResult();
				$masterid = "SELECT masterid FROM #__cam_masteraccounts WHERE firmid=".$camfirm." ";
				$db->setQuery($masterid);
				$master = $db->loadResult();
				}
			elseif($man_data->user_type == '13' && $man_data->accounttype!='master'){
				$masterid = "SELECT masterid FROM #__cam_masteraccounts WHERE firmid=".$man_data->id." "; 
				$db->setQuery($masterid);
				$master = $db->loadResult();
			}
			else{
			$master = $man_data->id;
			}	
			return $master ;
			}
	
			public function checkglobalstandards($rfpid,$master)	{
			$db =& JFactory::getDBO();
			$query_gli = "SELECT id FROM `jos_cam_master_generalinsurance_standards_rfps` where rfpid=".$rfpid."  " ;
			$db->Setquery($query_gli);
			$data_gli = $db->loadObjectList();
			$query_aip = "SELECT id FROM `jos_cam_master_autoinsurance_standards_rfps` where rfpid=".$rfpid."  " ;
			$db->Setquery($query_aip);
			$data_aip = $db->loadObjectList();
			$query_umb = "SELECT id FROM `jos_cam_master_umbrellainsurance_standards_rfps` where rfpid=".$rfpid."  " ;
			$db->Setquery($query_umb);
			$data_umb = $db->loadObjectList();
			$query_wci = "SELECT id FROM `jos_cam_master_workers_standards_rfps` where rfpid=".$rfpid."  " ;
			$db->Setquery($query_wci);
			$data_wci = $db->loadObjectList();
			$query_lic = "SELECT id FROM `jos_cam_master_licinsurance_standards_rfps` where rfpid=".$rfpid."  " ;
			$db->Setquery($query_lic);
			$data_lic = $db->loadObjectList();
			
			if( !$data_gli && !$data_aip && !$data_umb && !$data_wci && $data_lic ) {
					$existance =  "notset";
				}
				
			else if( $data_gli || $data_aip || $data_umb || $data_wci || $data_lic )	{
					$existance =  "success";
				}
				else{
				$existance =  "fail";
				}
			return $existance ;	
			}
			
		 public function checknewspecialrequirements_gli($vendorid,$rfpid,$managerid) 
				 {
					 $totalprefers_new_gli = '';
		$db = & JFactory::getDBO();
		$gli_data ="SELECT * from #__cam_vendor_liability_insurence  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($gli_data);
		$vendor_gli_data = $db->loadObjectList();
		//Get RFP data
		$rfp_gli_data ="SELECT * from #__cam_master_generalinsurance_standards_rfps WHERE rfpid=".$rfpid." "; //validation to status of docs
		$db->Setquery($rfp_gli_data);
		$rfp_gli_data = $db->loadObject();
		//echo "<br />";
		//echo "<pre>"; print_r($vendor_gli_data); echo "</pre>";
		//echo "<pre>"; print_r($rfp_gli_data); echo "</pre>";
		
		$occur = '';
		for( $gl=0; $gl<count($vendor_gli_data); $gl++ ){
			if($rfp_gli_data->each_occurrence >  '0'){
				if($rfp_gli_data->each_occurrence <= $vendor_gli_data[$gl]->GLI_policy_occurence){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->damage_retend > '0'){
				if($rfp_gli_data->damage_retend <= $vendor_gli_data[$gl]->GLI_damage){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->med_expenses > '0'){
				if($rfp_gli_data->med_expenses <= $vendor_gli_data[$gl]->GLI_med){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}	
			if($rfp_gli_data->personal_inj > '0'){
				if($rfp_gli_data->personal_inj <= $vendor_gli_data[$gl]->GLI_injury){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->general_aggr > '0'){	
				if($rfp_gli_data->general_aggr <= $vendor_gli_data[$gl]->GLI_policy_aggregate){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}


			if($rfp_gli_data->applies_to == 'pol'){
				if($vendor_gli_data[$gl]->GLI_applies == 'pol'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->applies_to == 'proj'){
				if($vendor_gli_data[$gl]->GLI_applies == 'proj'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->applies_to == 'loc'){
				if($vendor_gli_data[$gl]->GLI_applies == 'loc'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->products_aggr >  '0'){
				if($rfp_gli_data->products_aggr <= $vendor_gli_data[$gl]->GLI_products){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}	
			if($rfp_gli_data->waiver_sub == 'yes') {
				if($vendor_gli_data[$gl]->GLI_waiver == 'waiver'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->primary_noncontr == 'yes') {
				if($vendor_gli_data[$gl]->GLI_primary == 'primary'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->additional_insured == 'yes') {
				if($vendor_gli_data[$gl]->GLI_additional){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
			if($rfp_gli_data->cert_holder == 'yes') {
				if($vendor_gli_data[$gl]->GLI_certholder == 'yes'){
					$occur[] = 'yes' ;
				}
				else{
					$occur[] = 'no' ;
				}
			}
				if($rfp_gli_data){
					if($vendor_gli_data[$gl]->GLI_end_date < date('Y-m-d') || !$vendor_gli_data[$gl]->GLI_upld_cert || !$vendor_gli_data[$gl]->GLI_policy_occurence || !$vendor_gli_data[$gl]->GLI_policy_aggregate || $vendor_gli_data[$gl]->GLI_status == '-1') {
						$occur[] = 'no' ;
					}
					else{
						$occur[] = 'yes' ;
					}
				}
		
			if($occur){
				if( in_array("no", $occur) ){
				$cabins_gli[] = "no";
				}
				else{
				$cabins_gli[] = "yes";
				}
			}
			$occur = '';
		}
		
		if($cabins_gli){
			if( in_array("yes", $cabins_gli) ){
			$special = "success";
			}
			else{
			$special = "fail";
			}
		}
		else{
				if($rfp_gli_data)
				$special = "fail";
				else
				$special = "success";
		}
			
		$cabins_gli[] = '';
		return $special ;
					 
				 }
		
		public function checknewspecialrequirements_aip($vendorid,$rfpid,$managerid) {
			
			$db = & JFactory::getDBO();
		$aip_data ="SELECT * from #__cam_vendor_auto_insurance  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($aip_data);
		$vendor_aip_data = $db->loadObjectList();
		//Get RFP data
		$rfp_aip_data ="SELECT * from #__cam_master_autoinsurance_standards_rfps WHERE rfpid=".$rfpid." "; //validation to status of docs
		$db->Setquery($rfp_aip_data);
		$rfp_aip_data = $db->loadObject();
			for( $ai=0; $ai<count($vendor_aip_data); $ai++ ){
				if($rfp_aip_data->applies_to_any == 'any'){
					if($rfp_aip_data->applies_to_any == $vendor_aip_data[$ai]->aip_applies_any){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}

				if($rfp_aip_data->applies_to_owned == 'owned'){
					if($rfp_aip_data->applies_to_owned == $vendor_aip_data[$ai]->aip_applies_owned){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}

				if($rfp_aip_data->applies_to_nonowned == 'nonowned'){
					if($rfp_aip_data->applies_to_nonowned == $vendor_aip_data[$ai]->aip_applies_nonowned){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}

				if($rfp_aip_data->applies_to_hired == 'hired'){
					if($rfp_aip_data->applies_to_hired == $vendor_aip_data[$ai]->aip_applies_hired){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}

				if($rfp_aip_data->applies_to_scheduled == 'scheduled'){
					if($vendor_aip_data[$ai]->aip_applies_scheduled == 'sch'){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->combined_single > '0'){	
					if($rfp_aip_data->combined_single <= $vendor_aip_data[$ai]->aip_combined){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->bodily_injusy_person > '0'){	
					if($rfp_aip_data->bodily_injusy_person <= $vendor_aip_data[$ai]->aip_bodily){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->bodily_injusy_accident > '0'){	
					if($rfp_aip_data->bodily_injusy_accident <= $vendor_aip_data[$ai]->aip_body_injury){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->property_damage > '0'){	
					if($rfp_aip_data->property_damage <= $vendor_aip_data[$ai]->aip_property){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->waiver == 'yes'){
					if($vendor_aip_data[$ai]->aip_waiver == 'waiver'){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->primary == 'yes'){
					if($vendor_aip_data[$ai]->aip_primary == 'primary'){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->additional_ins == 'yes'){
					if($vendor_aip_data[$ai]->aip_addition != ''){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data->cert_holder == 'yes'){
					if($vendor_aip_data[$ai]->aip_cert == 'yes'){
						$occur_aip[] = 'yes' ;
					}
					else{
						$occur_aip[] = 'no' ;
					}
				}
				
				if($rfp_aip_data){
					if($vendor_aip_data[$ai]->aip_end_date < date('Y-m-d') || $vendor_aip_data[$ai]->aip_upld_cert=='' || $vendor_aip_data[$ai]->aip_status == '-1' || !$vendor_aip_data[$ai]->aip_combined ) 		{
						$occur_aip[] = 'no' ;
						}
					else
						{
						$occur_aip[] = 'yes' ;
						}
				}
				if($occur_aip){
					if( in_array("no", $occur_aip) ){
						$cabins_aip[] = "no";
					}
					else{
						$cabins_aip[] = "yes";
					}
				}
				$occur_aip = '';
			}	
			if($cabins_aip){
				if( in_array("yes", $cabins_aip) ){
					$special_aip = "success";
				}
				else{
					$special_aip = "fail";
				}
			}
			else{
				if($rfp_aip_data)
				$special_aip = "fail";
				else
				$special_aip = "success";
			}
			
				$cabins_aip[] = '';
		
		return $special_aip ;
		}
		
		public function checknewspecialrequirements_wci($vendorid,$rfpid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$wci_data ="SELECT * from #__cam_vendor_workers_companies_insurance  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($wci_data);
		$vendor_wci_data = $db->loadObjectList();
		//Get RFP data
		$rfp_wci_data ="SELECT * from #__cam_master_workers_standards_rfps WHERE rfpid=".$rfpid." " ; //validation to status of docs
		$db->Setquery($rfp_wci_data);
		$rfp_wci_data = $db->loadObject();

			for( $wci=0; $wci<count($vendor_wci_data); $wci++ ){
				
				if($rfp_wci_data->disease_policy > '0'){	
					if($rfp_wci_data->disease_policy <= $vendor_wci_data[$wci]->WCI_disease_policy){
						$occur_wci[] = 'yes' ;
					}
					else{
						$occur_wci[] = 'no' ;
					}
				}	
					
				if($rfp_wci_data->disease_eachemp > '0'){
					if($rfp_wci_data->disease_eachemp <= $vendor_wci_data[$wci]->WCI_disease){
						$occur_wci[] = 'yes' ;
					}
					else{
						$occur_wci[] = 'no' ;
					}
				}
				
				if($rfp_wci_data->waiver_work == 'yes'){
					if($vendor_wci_data[$wci]->WCI_waiver == 'waiver'){
						$occur_wci[] = 'yes' ;
					}
					else{
						$occur_wci[] = 'no' ;
					}
				}
				
				if($rfp_wci_data->each_accident > '0'){
					if($rfp_wci_data->each_accident <= $vendor_wci_data[$wci]->WCI_each_accident){
						$occur_wci[] = 'yes' ;
					}
					else{
						$occur_wci[] = 'no' ;
					}
				}
				
				if($rfp_wci_data->certholder_work == 'yes'){
					if($vendor_wci_data[$wci]->WCI_cert == 'yes'){
						$occur_wci[] = 'yes' ;
					}
					else{
						$occur_wci[] = 'no' ;
					}
				}
				if($rfp_wci_data){
					if($vendor_wci_data[$wci]->WCI_end_date < date('Y-m-d') || $vendor_wci_data[$wci]->WCI_upld_cert=='' || $vendor_wci_data[$wci]->WCI_status == '-1') {
							$occur_wci[] = 'no' ;
					}
					else{
							$occur_wci[] = 'yes' ;
					}
				}	
				if($occur_wci){
					if( in_array("no", $occur_wci) ){
						$cabins_wci[] = "no";
					}
					else{
						$cabins_wci[] = "yes";
					}
				}
				$occur_wci = '';
			}
			
			if($cabins_wci){
				if( in_array("yes", $cabins_wci) ){
					$special_wci = "success";
				}
				else{
					$special_wci = "fail";
				}
			}
			else{
				if($rfp_wci_data)
				$special_wci = "fail";
				else
				$special_wci = "success";
			}
			
				$cabins_wci[] = '';
		
		return $special_wci ;
		}
		
		public function checknewspecialrequirements_umb($vendorid,$rfpid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$umb_data ="SELECT * from #__cam_vendor_umbrella_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($umb_data);
		$vendor_umb_data = $db->loadObjectList();
		//Get RFP data
		$rfp_umb_data ="SELECT * from #__cam_master_umbrellainsurance_standards WHERE rfpid=".$rfpid." "; //validation to status of docs
		$db->Setquery($rfp_umb_data);
		$rfp_umb_data = $db->loadObject();
		
			for( $umb=0; $umb<count($vendor_umb_data); $umb++ ){
				
				if($rfp_umb_data->each_occur > '0'){	
					if($rfp_umb_data->each_occur <= $vendor_umb_data[$umb]->UMB_occur){
						$occur_umb[] = 'yes' ;
					}
					else{
						$occur_umb[] = 'no' ;
					}
				}	
				if($rfp_umb_data->aggregate > '0'){	
					if($rfp_umb_data->aggregate <= $vendor_umb_data[$umb]->UMB_aggregate){
						$occur_umb[] = 'yes' ;
					}
					else{
						$occur_umb[] = 'no' ;
					}
				}	
				if($rfp_umb_data->certholder_umbrella == 'yes'){
					if($vendor_umb_data[$umb]->UMB_certholder == 'yes'){
						$occur_umb[] = 'yes' ;
					}
					else{
						$occur_umb[] = 'no' ;
					}
				}
				if($rfp_umb_data){
				if($vendor_umb_data[$umb]->UMB_expdate < date('Y-m-d') || !$vendor_umb_data[$umb]->UMB_upld_cert || $vendor_umb_data[$umb]->UMB_status == '-1' || !$vendor_umb_data[$umb]->UMB_aggregate || !$vendor_umb_data[$umb]->UMB_occur) {
						$occur_umb[] = 'no' ;
				}
				else{
						$occur_umb[] = 'yes' ;
				}
				}
				
				if($occur_umb){
					if( in_array("no", $occur_umb) ){
						$cabins_umb[] = "no";
					}
					else{
						$cabins_umb[] = "yes";
					}
				}
				$occur_umb = '';
			}	 
				
				if($cabins_umb){
					if( in_array("yes", $cabins_umb) ){
						$special_umb = "success";
					}
					else{
						$special_umb = "fail";
					}
				}
				else{
					if($rfp_umb_data)
					$special_umb = "fail";
					else
					$special_umb = "success";
				}
		
				$cabins_umb[] = '';
				return $special_umb ;
		}
		
		public function checknewspecialrequirements_pln($vendorid,$rfpid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$pln_data ="SELECT * from #__cam_vendor_professional_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($pln_data);
		$vendor_pln_data = $db->loadObjectList();
		//Get RFP data
		$rfp_pln_data ="SELECT * from #__cam_master_licinsurance_standards_rfps WHERE rfpid=".$rfpid." " ; //validation to status of docs
		$db->Setquery($rfp_pln_data);
		$rfp_pln_data = $db->loadObject();
		
			for( $pln=0; $pln<count($vendor_pln_data); $pln++ ){
			
				if($rfp_pln_data->professional == 'yes'){
					if($vendor_pln_data[$pln]->PLN_expdate < date('Y-m-d') || !$vendor_pln_data[$pln]->PLN_upld_cert || $vendor_pln_data[$pln]->PLN_status == '-1') {
						$occur_pln[] = 'no' ;
					}
					else{
						$occur_pln[] = 'yes' ;
					}
				}
				if( $occur_pln ){
					if( in_array("no", $occur_pln) ){
						$cabins_pln[] = "no";
					}
					else{
						$cabins_pln[] = "yes";
					}
				}	
			}	
			
			if($cabins_pln){
				if( in_array("yes", $cabins_pln) ){
					$special_pln = "success";
				}
				else{
					$special_pln = "fail";
				}
			}
			else{
					if($rfp_pln_data->professional)
					$special_pln = "fail";
					else
					$special_pln = "success";
			}
			
				$cabins_pln[] = '';
				return $special_pln ;
		}		 
		
	public function checknewspecialrequirements_occ($vendorid,$rfpid,$managerid){

		$db = & JFactory::getDBO();
		$occ_data ="SELECT * from #__cam_vendor_occupational_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($occ_data);
		$vendor_occ_data = $db->loadObjectList();
		//Get RFP data
		$rfp_occ_data ="SELECT * from #__cam_master_licinsurance_standards_rfps WHERE rfpid=".$rfpid." "; //validation to status of docs
		$db->Setquery($rfp_occ_data);
		$rfp_occ_data = $db->loadObject();
		
			for( $occ=0; $occ<count($vendor_occ_data); $occ++ ){
			
				if($rfp_occ_data->occupational == 'yes'){
					if($vendor_occ_data[$occ]->OLN_expdate < date('Y-m-d') || !$vendor_occ_data[$occ]->OLN_upld_cert || $vendor_occ_data[$pln]->OLN_status == '-1') {
						$occur_occ[] = 'no' ;
					}
					else{
						$occur_occ[] = 'yes' ;
					}
				}
				if( $occur_occ ){
					if( in_array("no", $occur_occ) ){
						$cabins_occ[] = "no";
					}
					else{
						$cabins_occ[] = "yes";
					}
				}	
			}	
			
			if($cabins_occ){
				if( in_array("yes", $cabins_occ) ){
					$special_occ = "success";
				}
				else{
					$special_occ = "fail";
				}
				$cabins_occ = '';
			}
			
			else{
					if($rfp_occ_data->occupational)
					$special_occ = "fail";
					else
					$special_occ = "success";
			}
			
				$cabins_occ = '';
				return $special_occ ;
	}
	//Completed	
		}
?>