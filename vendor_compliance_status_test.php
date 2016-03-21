<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
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

//For the PDF file
	require_once ( JPATH_BASE .DS.'libraries'.DS.'tcpdf'.DS.'config'.DS.'lang'.DS.'eng.php' );
	require_once ( JPATH_BASE .DS.'libraries'.DS.'tcpdf'.DS.'tcpdf.php' );
	
	ini_set('zlib.output_compression','Off');
	
		class MYPDF extends TCPDF {

		public function Footer() {
			$this->SetY(-15);
			//$this->SetFontSize(8);
			if($this->pageno){
			}$this->pageno=$this->pageno+1;
			//$this->SetFontSize(7);
			$this->Cell(0, 5, 'Copyright 2014-2015 HOA Assistant, LLC', 0, 0, 'C');
		}

		public function Header() {
			$this->SetY(-15);
		}
	}

//Completed
	
$db =& JFactory::getDBO();
 $sql_masters = "SELECT U.id,U.name,U.lastname,V.date,V.weeks FROM `jos_users` as U, `jos_cam_master_email_compliance_status` as V where U.user_type=13 and U.accounttype='master' and U.block=0 and U.id=V.masterid and U.id=1991";
$db->setQuery($sql_masters);
$masters = $db->loadObjectList();

for( $ms=0; $ms<count($masters); $ms++ ){
$today = date('Y-m-d');
	//calculate days in between present and db date
	$dbdate = explode(' ',$masters[$ms]->date);
	
	$date_difference = strtotime($today) - strtotime($dbdate[0]) ;
//	echo $date_difference.'<br/>';
	$days = $date_difference / 86400 ;
	$everydays = $masters[$ms]->weeks * 7 ;
//	echo $days.'<br />'; 
	$reminder = ($days % $everydays);
	if( $masters[$ms]->weeks == '24' ){
		$reminder = '0';
		$masters[$ms]->weeks = '24';
	}
	else{
		$reminder = $reminder;
		$masters[$ms]->weeks = $masters[$ms]->weeks;
	}
//	$leftover = $leftover - floor($leftover);
/*if( $masters[$ms]->id == '1913' ) {
echo "Master ID: ".$masters[$ms]->id.'<br />';
echo "Weeks: ".$masters[$ms]->weeks.'<br />';
echo "Reminder: ".$reminder.'<br />'; 
}*/

	if( $reminder == '6' && $masters[$ms]->weeks > '0'){
	
		$total_mangrs = '';
		$firmsarr = '';
		$comp_id = '';
		$companyid = '';
		$firmid1 = '';
		$subfirms = '';
		$Managers_list = '';
		
	//if( $masters[$ms]->id == '1885' ){
	//Get all managers under the master
		$sql1 = "SELECT firmid from #__cam_masteraccounts where masterid=".$masters[$ms]->id." ";
		$db->Setquery($sql1);
		$subfirms = $db->loadObjectlist();

	if($subfirms)
		{
			for( $a=0; $a<count($subfirms); $a++ )
				{
					$firmid1[] = $subfirms[$a]->firmid;
					$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$subfirms[$a]->firmid." ";
					$db->Setquery($sql);
					$companyid[] = $db->loadResult();
											
				}
				//echo "<pre>"; print_r($firmid1); echo "</pre>";	
        }
	
	if($companyid){
         	for( $c=0; $c<count($companyid); $c++ )
				{
					$sql_cid = "SELECT cust_id from #__cam_customer_companyinfo where comp_id=".$companyid[$c]." ";
					$db->Setquery($sql_cid);
					$managerids = $db->loadObjectList();
						if($managerids) {
							foreach( $managerids as $last_mans){
								$total_mangrs[] = $last_mans->cust_id ;
							}
						}
               }
        }
	
	if( $firmid1 && $total_mangrs )
		{
            $total_mangrs = array_merge($total_mangrs,$firmid1); 
        }
		
		
	if($firmid1){
		for( $d=0; $d<count($firmid1); $d++ ){
		$query = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$firmid1[$d];
			$db->setQuery($query);
			$comp_id = $db->loadResult();
			$userid=array($user->id);
			$query_mans = "SELECT cust_id from #__cam_customer_companyinfo where comp_id = ".$comp_id." ";
			$db->setQuery($query_mans);
			$Managers_list1 = $db->loadObjectList();
			if($Managers_list1) {
				foreach( $Managers_list1 as $Managers_list2){
					$Managers_list[] = $Managers_list2->cust_id ;
				}
			}
		}
			if($Managers_list){
			$total_mangrs = array_merge($Managers_list,$firmid1);
			} else {
			$total_mangrs = $firmid1;        
			}
	}	
		
		
        $userid=array($masters[$ms]->id);
        if($total_mangrs){
        $total_mangrs = array_merge($userid,$total_mangrs); 
		}
		else{
		$total_mangrs[] = $masters[$ms]->id; 
		}
		
		$firmsarr = implode($total_mangrs,',');
		
		//Get company id
		$sql = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$masters[$ms]->id;
		$db->setQuery( $sql);
		$comp_id = $db->loadResult();
		
		if($comp_id==''){
		$sql_comp = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$masters[$ms]->id;
		$db->setQuery( $sql_comp);
		$comp_id = $db->loadResult();
		}
		else{
		$comp_id = $comp_id;
		}
		//Completed	
			
	 $sql_managers = "SELECT c.cust_id, u.name, u.lastname,u.email, (SELECT count(p.id) FROM #__cam_property p WHERE  p.property_manager_id = u.id AND (p.company_id=".$comp_id." OR p.property_manager_id IN(".$firmsarr."))) AS cnt FROM #__cam_customer_companyinfo c LEFT JOIN  #__users u ON c.cust_id=u.id WHERE c.cust_id IN(".$firmsarr.")";
	 
	 $db->setQuery($sql_managers);
	$total_managers = $db->loadObjectList();
	
	// To remove the managers as per master settings
	for( $ty=0; $ty<count($total_managers); $ty++ ){
			 $sql_type = "SELECT dmanager, user_type, accounttype from #__users where id=".$total_managers[$ty]->cust_id." " ;
			$db->Setquery($sql_type);
			$mgr_status = $db->loadObject();
			
			//echo '<pre>';print_r($mgr_status);exit;
			if($mgr_status->user_type == '12')
			$status = 'm' ;
			if($mgr_status->dmanager == 'yes')
			$status = 'dm' ;
			if($mgr_status->user_type == '13')
			$status = 'admin' ;
			if($mgr_status->accounttype == 'master')
			$status = 'master' ;
			$total_managers[$ty]->usertype = $status ;	
		}	
	
	$firms = '';
	$firmid1 = '';

	 for( $po=0; $po<count($total_managers); $po++ ){

		$query_preferred = "SELECT DISTINCT(U.v_id), V.company_name,V.company_phone, W.id, W.subscribe_type, W.subscribe from #__vendor_inviteinfo as U, #__cam_vendor_company as V, #__users as W where LOWER(U.inhousevendors) = (W.email) and W.block=0 and V.user_id=W.id and U.userid=".$total_managers[$po]->cust_id." and W.block=0 and W.search='' order by V.company_name ASC "; 
	$db->setQuery($query_preferred);
	$preferred = $db->loadObjectList();
	
		// check global standards with vendors compliance docments
		for( $v=0; $v<count($preferred); $v++ ){
			$v_inds = "SELECT U.industry_id, V.industry_name FROM `jos_cam_vendor_industries` as U, jos_cam_industries as V where U.industry_id=V.id and U.user_id=".$preferred[$v]->id." order by V.industry_name ASC " ;
			$db->Setquery($v_inds);
			$vendor_industries = $db->loadObjectList();
	//Completed
		for( $in=0; $in<count($vendor_industries); $in++ ){
	//Check the master have global standards or not
			$log = new checkstatus();
			$master	=	$log->getmasterfirmaccount($total_managers[$po]->cust_id);
			$checkglobal	=	$log->checkglobalstandards($vendor_industries[$in]->industry_id,$master);
			
			if( $checkglobal == 'success' )	{
				$totalprefers_new_gli	=	$log->checknewspecialrequirements_gli($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_aip	=	$log->checknewspecialrequirements_aip($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_wci	=	$log->checknewspecialrequirements_wci($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_umb	=	$log->checknewspecialrequirements_umb($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_pln	=	$log->checknewspecialrequirements_pln($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_occ	=	$log->checknewspecialrequirements_occ($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				$totalprefers_new_omi	=	$log->checknewspecialrequirements_omi($preferred[$v]->id,$vendor_industries[$in]->industry_id,$master);
				/*echo "FIRM: ".$total_managers[$t]->cust_id."<br />".$preferred[$v]->id.'<br /><br />';
				echo $totalprefers_new_gli."<br />" ;
				echo $totalprefers_new_aip."<br />" ;
				echo $totalprefers_new_wci."<br />" ;
				echo $totalprefers_new_umb."<br />" ;
				echo $totalprefers_new_pln."<br />" ;*/
				
				if($totalprefers_new_gli == 'success' && $totalprefers_new_aip == 'success' && $totalprefers_new_wci == 'success' && $totalprefers_new_umb == 'success' && $totalprefers_new_pln == 'success' && $totalprefers_new_occ == 'success' && $totalprefers_new_omi == 'success' )
				{
					$c_status = '<font color="green">Compliant</font>';
					$sql_terms = "SELECT termsconditions FROM #__cam_vendor_aboutus WHERE vendorid=".$master." "; 
					$db->setQuery($sql_terms);
					$terms_exist = $db->loadResult();
						if($terms_exist == '1'){				
					$db =& JFactory::getDBO();
					$sql = "SELECT accepted FROM #__cam_vendor_terms WHERE masterid=".$master." and vendorid=".$preferred[$v]->id." ";
					$db->setQuery($sql);
					$terms = $db->loadResult();
						if($terms == '1'){
						$c_status = '<font color="green">Compliant</font>';
						}
						else{
						$c_status = '<font color="red">Non-Compliant</font>';
						}
					}
				}
				else
				{
					$c_status = '<font color="red">Non-Compliant</font>';
				}		
				//Send the mail to master account
				$vendor_documents = $log->getexpired_documents($preferred[$v]->id);
				$docs_permission = $log->getpermission_cdocs($master);
				
				if( $preferred[$v]->subscribe == 'yes' && $preferred[$v]->subscribe_type == 'free' )
				$account_type = '<span style="color:red;">Unverified</span>';
				else if( $preferred[$v]->subscribe == 'yes' && $preferred[$v]->subscribe_type != 'free' )
				$account_type = "<span style='color:green;'>Verified</span>";
				
				$vendor_data[$vendor_industries[$in]->industry_name][] = $c_status.'MYVC'.$account_type .'MYVC' . $preferred[$v]->company_name .'MYVC'.$vendor_documents.'MYVC' . $preferred[$v]->company_phone ;		
			}
			
		}
			
		
	}	
				
				$final_per_m = '';
	$final_per_a = '';
	$final_per_dm = '';
	$final_per_mn = '';

				if($total_managers[$po]->usertype == 'master'){
				$permission_m = "SELECT master FROM #__cam_master_compliancereport WHERE masterid=".$masters[$ms]->id." ";
				$db->setQuery($permission_m);
				$per_grant_m = $db->loadResult();
					if($per_grant_m == '1') {
					$final_per_m = 'yes';
					}
					else{
					$final_per_m = 'no';
					}
				}
				
				if($total_managers[$po]->usertype == 'admin'){
				$permission_a = "SELECT admin FROM #__cam_master_compliancereport WHERE masterid=".$masters[$ms]->id." ";
				$db->setQuery($permission_a);
				$per_grant_a = $db->loadResult();
				
					if($per_grant_a == '1') {
					$final_per_a = 'yes';
					}
					else{
					$final_per_a = 'no';
					}
				}
				
				if($total_managers[$po]->usertype == 'dm'){
				$permission_d = "SELECT dm FROM #__cam_master_compliancereport WHERE masterid=".$masters[$ms]->id." ";
				$db->setQuery($permission_d);
				$per_grant_d = $db->loadResult();
					if($per_grant_d == '1') {
					$final_per_d = 'yes';
					}
					else{
					$final_per_d = 'no';
					}
				}
				
				if($total_managers[$po]->usertype == 'm'){
				$permission_mn = "SELECT m FROM #__cam_master_compliancereport WHERE masterid=".$masters[$ms]->id." ";
				$db->setQuery($permission_mn);
				$per_grant_mn = $db->loadResult();
					if($per_grant_mn == '1') {
					$final_per_mn = 'yes';
					}
					else{
					$final_per_mn = 'no';
					}
				}
	//echo 	$total_managers[$t]->cust_id.'<br />';		
	//echo "Master:".$final_per_m.'<br />Admin: '.$final_per_a.'<br />District: '.$final_per_d.'<br />Normal: '.$final_per_mn.'<br /><br />' ;			
	
				
	//echo "<pre>"; print_r($vendor_data); echo "</pre>";
	if( ( $preferred && $checkglobal == 'success' ) && ( $final_per_m == 'yes' || $final_per_a == 'yes' || $final_per_d == 'yes' || $final_per_mn == 'yes' )  )	{
	
	$final_per_m = '';
	$final_per_a = '';
	$final_per_dm = '';
	$final_per_mn = '';
	
	
	$table_start = '<table width="100%" cellpadding="0" cellspacing="0">';
	$table_end = '</table>';
	$cdata = '<tr height="20"><td></td></tr>';
	//To save the PDF file into the folder
	$count_enable = $log->countenableddocs($masters[$ms]->id);
	//$pdf->SetFont();
	$today = date('Y-m-d H:i:s');
	$today_explode = explode(' ',$today);
	
	
	$vendordata_pdf = $vendor_data ;
	$nodata_count = '0';
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$only_pdfcontent = '<table style="width:1000px;" border="0" cellspacing="0" cellpadding="0">
  <tr><td><img src="/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/myvc_status.jpg" />';
 
  $only_pdfcontent .= '</td></tr>
    </table><br /><span style="font-size:28px;">Please find the list of your Vendors below and their compliance status as of <strong>'.date("h:i A", strtotime($today_explode[1])).'</strong> on <strong>'.$today_explode[0].'</strong>. Note: this list is determined by the Vendors that you have manually added to be included on your "My Vendors" list ("Corporate Preferred Vendors" list for Master Account holder). You can view this list by logging into your MyVendorCenter account and clicking on "Vendor Lists" ("Preferred Vendors" for Master Account holder)</span><br /><br />';
	
		foreach($vendordata_pdf as $key=>$value){
			$only_pdfcontent .= '<table style="width:100%;" width="100%" border="0" cellspacing="0" cellpadding="0">';
			$only_pdfcontent .= '<tr></tr><br /><tr height="20"><td colspan="12" style="text-align:center;"><strong style="font-size:35px; font-family:sans-serif; text-align:center;">'.$key.'</strong></td></tr><tr><td colspan="12" height="5"></td></tr>';
			$only_pdfcontent .= '<tr><td width="170" align="left"><strong style="font-size:25px; font-family:sans-serif; text-align:left;">Company</strong></td>';
			
			if( $docs_permission->phone_number == '1' )
			$only_pdfcontent .= '<td width="75"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Phone</strong></td>';
			if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">GL</strong></td>';
			if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Auto</strong></td>';
			if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">WC</strong></td>';
			if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Umbrella</strong></td>';
			if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">E & O</strong></td>';
			if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Prof. Lic</strong></td>';
			if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all')
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Occ Lic</strong></td>';

			$only_pdfcontent .= '<td width="75"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Comp Status</strong></td>';
			$only_pdfcontent .= '<td width="55"><strong style="font-size:25px; font-family:sans-serif; text-align:center;">Acc Type</strong></td>';
			$only_pdfcontent .= '</tr>';
			$count = count($value) ;
			
			for($last=0; $last<count($value); $last++){
				$exp = explode('MYVC',$value[$last]);
				//print_r($exp);exit;
				if($value[$last]){
				$only_pdfcontent .= '<tr style="border-top:2px solid green;"><td width="170"><span style="font-size:23px; text-align:left;">'.$exp[2].'</span></td>';
				if( $docs_permission->phone_number == '1' )
				$only_pdfcontent .= '<td width="75"><span style="font-size:23px; text-align:center;">'.$exp[11].'</span></td>';
				if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[3].'</span></td>';
				if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[4].'</span></td>';
				if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[5].'</span></td>';
				if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[6].'</span></td>';
				if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[7].'</span></td>';
				if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[8].'</span></td>';
				if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all')
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[9].'</span></td>';
				$only_pdfcontent .= '<td width="75"><span style="font-size:23px; text-align:center;">'.$exp[0].'</span></td>';
				$only_pdfcontent .= '<td width="55"><span style="font-size:23px; text-align:center;">'.$exp[1].'</span></td>';
				$only_pdfcontent .= '</tr>';
				if( $last+1 == $count ){
				$only_pdfcontent .= '<tr><td colspan="12"><img src="/var/www/vhosts/myvendorcenter.com/httpdocs/templates/camassistant_left/images/top_border.jpg" /></td></tr>';
				}
				$nodata_count = $nodata_count - 1 ;
				}
				else{
					$nodata_count = $nodata_count + 1 ;
				}
				
			}
		}
		$only_pdfcontent .= '</table>';
		
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setLanguageArray($l);
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setJPEGQuality(200);
		if( $count_enable <= '4' )
		$pdf->AddPage();
		else
		$pdf->AddPage('L');
		$pdf->writeHTML($only_pdfcontent, true, 0, true, 0);
		$pdf->lastPage();
		$title = $total_managers[$po]->cust_id.'_compliancereports.pdf'; //set title
		$pdf->SetTitle($title);//set title
		ob_end_clean();
		$pdf->Output('/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/compliance_reports/' . $title, 'F');
		
	//Completed 
		foreach($vendor_data as $key=>$value){
			$only_content .= '<tr height="20"></tr><tr height="20"><td colspan="10" width="100%" align="center"><strong style="font-size:20px; font-family:sans-serif; text-align:center;">'.$key.'</strong></td></tr><tr><td colspan="10" height="5"></td></tr>';
			$only_content .= '<tr><td width="20%" align="left"><strong style="font-size:15px; font-family:sans-serif; text-align:left;">Company</strong></td>';
			
			if( $docs_permission->phone_number == '1' )
			$only_content .= '<td width="18%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Phone</strong></td>';
			if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">GL</strong></td>';
			if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Auto</strong></td>';
			if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">WC</strong></td>';
			if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Umbrella</strong></td>';
			if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">E & O</strong></td>';
			if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Prof. Lic</strong></td>';
			if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all')
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Occ Lic</strong></td>';

			$only_content .= '<td width="12%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Comp Status</strong></td>';
			$only_content .= '<td width="8%" align="center"><strong style="font-size:15px; font-family:sans-serif; text-align:center;">Acc Type</strong></td>';
			$only_content .= '</tr>';
			$count = count($value) ;
			for($last=0; $last<count($value); $last++){
				$exp = explode('MYVC',$value[$last]);
				if( $last+1 == $count )
					$backgroud = "style='border-bottom:1px solid gray;'";
				else
					$backgroud = '';
				//echo 		$backgroud;
				//print_r($exp);exit;
				if($value[$last]){
				$only_content .= '<tr style="border-top:2px solid green;"><td width="20%" '.$backgroud.'><span style="font-size:13px; text-align:left; font-family:sans-serif; display:block;">'.$exp[2].'</span></td>';
				if( $docs_permission->phone_number == '1' )
				$only_content .= '<td width="18%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[11].'</span></td>';
				if( $docs_permission->gli == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[3].'</span></td>';
				if( $docs_permission->api == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[4].'</span></td>';
				if( $docs_permission->wc == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[5].'</span></td>';
				if( $docs_permission->umb == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[6].'</span></td>';
				if( $docs_permission->omi == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[7].'</span></td>';
				if( $docs_permission->pln == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[8].'</span></td>';
				if( $docs_permission->oln == '1' || $docs_permission->how_docs == 'all')
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[9].'</span></td>';
				$only_content .= '<td width="12%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[0].'</span></td>';
				$only_content .= '<td width="8%" '.$backgroud.' align="center"><span style="font-size:13px; text-align:center; font-family:sans-serif;">'.$exp[1].'</span></td>';
				$only_content .= '</tr>';
				/*if( $last+1 == $count ){
				$only_content .= '<tr><td style="border-bottom:2px solid gray;"></td></tr>';
				}*/
				$nodata_count = $nodata_count - 1 ;
				}
				else{
					$nodata_count = $nodata_count + 1 ;
				}
				
			}
		}
		$comp_stand = $table_start.$only_content.$table_end ;
		echo $comp_stand; exit;
	
				$message = "SELECT introtext FROM #__content WHERE  id=276";
				$db->setQuery($message);
				$body = $db->loadResult();
				$body = str_replace('{Manager}',$total_managers[$po]->name.' '.$total_managers[$po]->lastname,$body);
				$body = str_replace('{Industry List}',$comp_stand,$body);
				$today = date('Y-m-d H:i:s');
				$today_explode = explode(' ',$today);
				
				$body = str_replace('[date]',$today_explode[0],$body);
				$body = str_replace('[time]',date("h:i A", strtotime($today_explode[1])),$body);
				$body = str_replace('{CSS LINK}','<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />',$body);
				$sub = "Your Preferred Vendor Compliance Status";
				$from = "support@myvendorcenter.com";
				$from_name = 'MyVendorCenter';
				//$to = 'eric@myvendorcenter.com';
				
	$body = str_replace('{Industry List}',$cdata,$body);
	$attachment = "/var/www/vhosts/myvendorcenter.com/httpdocs/components/com_camassistant/assets/compliance_reports/".$title;
	$to_manager = $total_managers[$po]->email ;
	echo $total_managers[$po]->cust_id.'<br />'; 
	$user = JFactory::getUser($total_managers[$po]->cust_id);
	$managertype = $user->user_type ;
	$managertype1 = $user->accounttype ;
	$managertype2 = $user->dmanager ;
	$master_user	=	$log->getmasterfirmaccount($total_managers[$po]->cust_id);
	
	if( $managertype == '13' && $managertype1 == 'master' )
	$manager_type = 'master';
	else if( $managertype == '13' && $managertype1 != 'master' )
	$manager_type = 'camfirm';
	else if( $managertype == '12' && $managertype2 == 'yes')
	$manager_type = 'dm';
	else if( $managertype == '12' && $managertype2 != 'yes')
	$manager_type = 'm';
	
	$permission_mn = "SELECT master, admin, dm, m FROM #__cam_master_compliancereport WHERE masterid=".$master_user." ";
	$db->setQuery($permission_mn);
	$total_permisssion = $db->loadObject();

	$can_sendmail = '';	
	
	if(  $manager_type == 'master' && $total_permisssion->master == '1' ) 
		$can_sendmail = 'yes';	
	else if( $manager_type == 'camfirm' && $total_permisssion->admin == '1' ) 
		$can_sendmail = 'yes';	
	else if( $manager_type == 'dm' && $total_permisssion->dm == '1' ) 
		$can_sendmail = 'yes';	
	else if( $manager_type == 'm' && $total_permisssion->m == '1' ) 
		$can_sendmail = 'yes';
	else
		$can_sendmail = 'no';

	if( $can_sendmail == 'yes' ) {
		//$successMail =JUtility::sendMail($from, $from_name, $to_manager, $sub, $body,$mode = 1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		$to = 'manageremails@myvendorcenter.com';
		//$successMail =JUtility::sendMail($from, $from_name, $to, $sub, $body,$mode = 1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		$to_rize_gmail = 'rize.cama@gmail.com';
		$successMail =JUtility::sendMail($from, $from_name, $to_rize_gmail, $sub, $body,$mode = 1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
		
	}
	/*$msg = "First line of text\nSecond line of text";
	mail("eric@myvendorcenter.com","Test subject",$msg);
	
	$msg = "First line of text\nSecond line of text";
	mail("rize.cama@gmail.com","Test subject",$msg);*/
	//echo $body; exit;
	}
	else{

	}

	$checkglobal == '' ;
	$vendor_data = '';
	$body = '';
	$only_content = '';
	}
	exit;
	} //If condition check dates
		} //Completed managers for loop



		
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
	
			public function checkglobalstandards($industryid,$master)	{
			$db =& JFactory::getDBO();
			$query_gli = "SELECT id,industry_id FROM `jos_cam_master_generalinsurance_standards` where masterid=".$master." and industry_id= ".$industryid." " ;
			$db->Setquery($query_gli);
			$data_gli = $db->loadObjectList();
			$query_aip = "SELECT id,industryid FROM `jos_cam_master_autoinsurance_standards` where masterid=".$master." and industryid= ".$industryid." " ;
			$db->Setquery($query_aip);
			$data_aip = $db->loadObjectList();
			$query_umb = "SELECT id,industryid FROM `jos_cam_master_umbrellainsurance_standards` where masterid=".$master." and industryid= ".$industryid." " ;
			$db->Setquery($query_umb);
			$data_umb = $db->loadObjectList();
			$query_wci = "SELECT id,industryid FROM `jos_cam_master_workers_standards` where masterid=".$master." and industryid= ".$industryid." " ;
			$db->Setquery($query_wci);
			$data_wci = $db->loadObjectList();
			$query_lic = "SELECT id,industryid FROM `jos_cam_master_licinsurance_standards` where masterid=".$master." and industryid= ".$industryid." " ;
			$db->Setquery($query_lic);
			$data_lic = $db->loadObjectList();
				if( $data_gli || $data_aip || $data_umb || $data_wci || $data_lic )	{
					$existance =  "success";
				}
				else{
				$existance =  "fail";
				}
			return $existance ;	
			}
			
		 public function checknewspecialrequirements_gli($vendorid,$industryid,$managerid) 
				 {
					 $totalprefers_new_gli = '';
		$db = & JFactory::getDBO();
		$gli_data ="SELECT * from #__cam_vendor_liability_insurence  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($gli_data);
		$vendor_gli_data = $db->loadObjectList();
		//Get RFP data
		$rfp_gli_data ="SELECT * from #__cam_master_generalinsurance_standards WHERE masterid=".$managerid." and industry_id=".$industryid; //validation to status of docs
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
		
		public function checknewspecialrequirements_aip($vendorid,$industryid,$managerid) {
			
			$db = & JFactory::getDBO();
		$aip_data ="SELECT * from #__cam_vendor_auto_insurance  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($aip_data);
		$vendor_aip_data = $db->loadObjectList();
		//Get RFP data
		$rfp_aip_data ="SELECT * from #__cam_master_autoinsurance_standards WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
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
		
		public function checknewspecialrequirements_wci($vendorid,$industryid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$wci_data ="SELECT * from #__cam_vendor_workers_companies_insurance  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($wci_data);
		$vendor_wci_data = $db->loadObjectList();
		//Get RFP data
		$rfp_wci_data ="SELECT * from #__cam_master_workers_standards WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
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
		
		public function checknewspecialrequirements_umb($vendorid,$industryid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$umb_data ="SELECT * from #__cam_vendor_umbrella_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($umb_data);
		$vendor_umb_data = $db->loadObjectList();
		//Get RFP data
		$rfp_umb_data ="SELECT * from #__cam_master_umbrellainsurance_standards WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
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
		
		public function checknewspecialrequirements_pln($vendorid,$industryid,$managerid) 
			{
			$db = & JFactory::getDBO();
		$pln_data ="SELECT * from #__cam_vendor_professional_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($pln_data);
		$vendor_pln_data = $db->loadObjectList();
		//Get RFP data
		$rfp_pln_data ="SELECT * from #__cam_master_licinsurance_standards WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
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
		
	public function checknewspecialrequirements_occ($vendorid,$industryid,$managerid) {

		$db = & JFactory::getDBO();
		$occ_data ="SELECT * from #__cam_vendor_occupational_license  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($occ_data);
		$vendor_occ_data = $db->loadObjectList();
		//Get RFP data
		$rfp_occ_data ="SELECT * from #__cam_master_licinsurance_standards WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
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
		public function checknewspecialrequirements_omi($vendorid,$industryid,$managerid){

		$db = & JFactory::getDBO();
		$omi_data ="SELECT * from #__cam_vendor_errors_omissions_insurance  WHERE vendor_id=".$vendorid; //validation to status of docs
		$db->Setquery($omi_data);
		$vendor_omi_data = $db->loadObjectList();
		//Get RFP data
		$rfp_omi_data ="SELECT * from #__cam_master_errors_omissions WHERE masterid=".$managerid." and industryid=".$industryid; //validation to status of docs
		$db->Setquery($rfp_omi_data);
		$rfp_omi_data = $db->loadObject();
		
		
		
			for( $omi=0; $omi<count($vendor_omi_data); $omi++ ){
				
				if($rfp_omi_data->each_claim > '0'){	
					if($rfp_omi_data->each_claim <= $vendor_omi_data[$omi]->OMI_each_claim){
						$occur_omi[] = 'yes' ;
					}
					else{
						$occur_omi[] = 'no' ;
					}
				}	
				if($rfp_omi_data->aggregate_omi > '0'){	
					if($rfp_omi_data->aggregate_omi <= $vendor_omi_data[$omi]->OMI_aggregate){
						$occur_omi[] = 'yes' ;
					}
					else{
						$occur_omi[] = 'no' ;
					}
				}	
				if($rfp_omi_data->certholder_omi == 'yes'){
					if($vendor_omi_data[$omi]->OMI_cert == 'yes'){
						$occur_omi[] = 'yes' ;
					}
					else{
						$occur_omi[] = 'no' ;
					}
				}
				if($rfp_omi_data){
				if($vendor_omi_data[$omi]->OMI_end_date < date('Y-m-d') || !$vendor_omi_data[$omi]->OMI_upld_cert || $vendor_omi_data[$omi]->OMI_status == '-1' ) {
						$occur_omi[] = 'no' ;
				}
				else{
						$occur_omi[] = 'yes' ;
				}
				}
				
				/*if( $vendorid == '1767' ){
				echo "<pre>";	print_r($occur_omi); echo "</pre>";
				//echo "<pre>";	print_r($rfp_omi_data); echo "</pre>";
				}*/
		
				if($occur_omi){
					if( in_array("no", $occur_omi) ){
						$cabins_omi[] = "no";
					}
					else{
						$cabins_omi[] = "yes";
					}
				}
				$occur_omi = '';
			}	
			
				if($cabins_omi){
					if( in_array("yes", $cabins_omi) ){
						$special_omi = "success";
					}
					else{
						$special_omi = "fail";
					}
				}
				else{
					if($rfp_omi_data)
					$special_omi = "fail";
					else
					$special_omi = "success";
				}
		
				$cabins_omi = '';
				return $special_omi ;
				
			
	}
	
	public function getexpired_documents($vendorid){
		$gli_expdate = $this->gliexpdate($vendorid);
		$aip_expdate = $this->aipexpdate($vendorid);
		$wci_expdate = $this->wciexpdate($vendorid);
		$umb_expdate = $this->umbexpdate($vendorid);
		$omi_expdate = $this->omiexpdate($vendorid);
		$oln_expdate = $this->olnexpdate($vendorid);
		$pln_expdate = $this->plnexpdate($vendorid);
		$wc_expdate = $this->wcexpdate($vendorid);
		$expired_dates = $gli_expdate.'MYVC'.$aip_expdate.'MYVC'.$wci_expdate.'MYVC'.$umb_expdate.'MYVC'.$omi_expdate.'MYVC'.$oln_expdate.'MYVC'.$pln_expdate.'MYVC'.$wc_expdate ;
		//echo $expired_dates; exit;
		return $expired_dates;
		
	}
	public function gliexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT GLI_end_date FROM #__cam_vendor_liability_insurence  where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$GLI_date = $db->loadResult();
		
		$GLI_change = explode('-',$GLI_date);
		$final_GLI = $GLI_change[1].'/'.$GLI_change[2].'/'.$GLI_change[0];
		
		if( !$GLI_date || $GLI_date == '0000-00-00' )
			$GLI_final = 'None';
		else if( $GLI_date < $today )	
			$GLI_final = '<span style="color:red;">'.$final_GLI.'</span>';
		else
			$GLI_final = $final_GLI ;
		return $GLI_final;
	}
	public function aipexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT aip_end_date FROM #__cam_vendor_auto_insurance where  and vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$AIP_date = $db->loadResult();
		
		$AIP_change = explode('-',$AIP_date);
		$final_AIP = $AIP_change[1].'/'.$AIP_change[2].'/'.$AIP_change[0];
		
		if( !$AIP_date || $AIP_date == '0000-00-00' )
			$AIP_final = 'None';
		else if( $AIP_date < $today )	
			$AIP_final = '<span style="color:red;">'.$final_AIP.'</span>';
		else
			$AIP_final = $final_AIP ;
		return $AIP_final;
	}
	public function wciexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT WCI_end_date FROM #__cam_vendor_workers_companies_insurance where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$WCI_date = $db->loadResult();
		
		$WCI_change = explode('-',$WCI_date);
		$final_WCI = $WCI_change[1].'/'.$WCI_change[2].'/'.$WCI_change[0];
		
		if( !$WCI_date || $WCI_date == '0000-00-00' )
			$WCI_final = 'None';
		else if( $WCI_date < $today )	
			$WCI_final = '<span style="color:red;">'.$final_WCI.'</span>';
		else
			$WCI_final = $final_WCI ;
		return $WCI_final;
	}
	public function umbexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT UMB_expdate FROM #__cam_vendor_umbrella_license where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$UMB_date = $db->loadResult();
		
		$UMB_change = explode('-',$UMB_date);
		$final_UMB = $UMB_change[1].'/'.$UMB_change[2].'/'.$UMB_change[0];
		
		if( !$UMB_date || $UMB_date == '0000-00-00' )
			$UMB_final = 'None';
		else if( $UMB_date < $today )	
			$UMB_final = '<span style="color:red;">'.$final_UMB.'</span>';
		else
			$UMB_final = $final_UMB ;
		return $UMB_final;
	}
	public function omiexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT OMI_end_date FROM #__cam_vendor_errors_omissions_insurance where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$OMI_date = $db->loadResult();
		
		$OMI_change = explode('-',$OMI_date);
		$final_OMI = $OMI_change[1].'/'.$OMI_change[2].'/'.$OMI_change[0];
		
		if( !$OMI_date || $OMI_date == '0000-00-00' )
			$OMI_final = 'None';
		else if( $OMI_date < $today )	
			$OMI_final = '<span style="color:red;">'.$final_OMI.'</span>';
		else
			$OMI_final = $final_OMI ;
		return $OMI_final;
	}
	public function olnexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT OLN_expdate FROM #__cam_vendor_occupational_license where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$OLN_date = $db->loadResult();
		
		$OLN_change = explode('-',$OLN_date);
		$final_OLN = $OLN_change[1].'/'.$OLN_change[2].'/'.$OLN_change[0];
		
		if( !$OLN_date || $OLN_date == '0000-00-00' )
			$OLN_final = 'None';
		else if( $OLN_date < $today )	
			$OLN_final = '<span style="color:red;">'.$final_OLN.'</span>';
		else
			$OLN_final = $final_OLN ;
		return $OLN_final;
	}
	public function plnexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT PLN_expdate FROM #__cam_vendor_professional_license where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$PLN_date = $db->loadResult();
		
		$PLN_change = explode('-',$PLN_date);
		$final_PLN = $PLN_change[1].'/'.$PLN_change[2].'/'.$PLN_change[0];
		
		if( !$PLN_date || $PLN_date == '0000-00-00' )
			$PLN_final = 'None';
		else if( $PLN_date < $today )	
			$PLN_final = '<span style="color:red;">'.$final_PLN.'</span>';
		else
			$PLN_final = $final_PLN ;
		return $PLN_final;
	}
	public function wcexpdate($vendorid){
		$db =& JFactory::getDBO();
		$today = date('Y-m-d');
		$user = JFactory::getUser();
		$sql = "SELECT wc_end_date FROM #__cam_vendor_workers_compansation where vendor_id=".$vendorid." order by id ASC";
		$db->Setquery($sql);
		$WC_date = $db->loadResult();
		
		$WC_change = explode('-',$WC_date);
		$final_WC = $WC_change[1].'/'.$WC_change[2].'/'.$WC_change[0];
		
		if( !$WC_date || $WC_date == '0000-00-00' )
			$WC_final = 'None';
		else if( $WC_date < $today )	
			$WC_final = '<span style="color:red;">'.$final_WC.'</span>';
		else
			$WC_final = $final_WC ;
		return $WC_final;
	}
	public function countenableddocs($masterid){
		$docs_permission = $this->getpermission_cdocs($masterid);
		$total = '0';
		if( $docs_permission->how_docs == 'all' )
			$total = '8';
		else {
			if( $docs_permission->gli == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->api == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->wc == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->umb == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->omi == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->pln == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->oln == '1' )	
			$total = $total + 1 ;
			if( $docs_permission->phone_number == '1' )	
			$total = $total + 1 ;
		}
		return $total;
	}
		public function getpermission_cdocs($masteraccount){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__cam_master_compliancereport where masterid=".$masteraccount." ";
		$db->Setquery($sql);
		$docpermission = $db->loadObject();
		return $docpermission;
	}

		}
	
?>