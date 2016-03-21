<?PHP
  
define( '_JEXEC', 1 );
define('JPATH_BASE', str_replace('/cronjobs','',dirname(__FILE__)) );
define( 'DS', DIRECTORY_SEPARATOR );
/* Required Files */
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* To use Joomla's Database Class */
require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');
$today = date('Y-m-d');


/* Create a database object */
$db =& JFactory::getDBO();
//$days_ago = date('Y-m-d', strtotime('1 days', strtotime($today)));
$daysbefore7=date('Y-m-d', strtotime('-7 days', strtotime($today)));
$after1day=date('Y-m-d', strtotime('-1 days', strtotime($today)));
$after60days=date('Y-m-d', strtotime('+60 days', strtotime($today)));
//echo $after1day; 
//print_r($after60days); 
/******************************************************OLN DOCS***********************************************************/

 $OLN_EXP_DOCS = "SELECT distinct(u.id) FROM #__users as u 
LEFT JOIN #__cam_vendor_occupational_license as A ON A.vendor_id=u.id
LEFT JOIN #__cam_vendor_auto_insurance as AI ON AI.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_compansation as WC ON WC.vendor_id=u.id
LEFT JOIN  #__cam_vendor_professional_license as B ON B.vendor_id=u.id
LEFT JOIN  #__cam_vendor_liability_insurence as C ON C.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_companies_insurance as D ON D.vendor_id=u.id
 WHERE u.user_type = 11 AND ((A.OLN_expdate = '".$today."' AND A.OLN_expdate != '00-00-0000') OR (B.PLN_expdate = '".$today."' AND B.PLN_expdate != '00-00-0000') OR (C.GLI_end_date = '".$today."' AND C.GLI_end_date != '00-00-0000') OR (AI.aip_end_date = '".$today."' AND AI.aip_end_date != '00-00-0000') OR (WC.wc_end_date = '".$today."' AND WC.wc_end_date != '00-00-0000') OR (D.WCI_end_date = '".$today."' AND D.WCI_end_date != '00-00-0000'))  ORDER BY u.id ";
$db->Setquery($OLN_EXP_DOCS);
$vendor_ids = $db->loadResultArray();
//$vendor_id='1354';
//$vendor_ids=array($vendor_id);

//echo "<pre>"; print_r($vendor_ids); echo '<pre/>';  
/********************************************code to send email notifications to vendros**********************************/
for($n=0; $n<count($vendor_ids); $n++)
{
	//To get the vendors information
	$user = JFactory::getUSer($vendor_ids[$n]);
	 	
		$gdate1="SELECT GLI_end_date FROM #__cam_vendor_liability_insurence where vendor_id=".$user->id." ";
        $db->Setquery($gdate1);
        $gdate = $db->loadObjectList();
        for($g=0; $g<count($gdate); $g++)
        {
           $dateg=$gdate[$g]->GLI_end_date;
           $datediff = strtotime($today)-strtotime($dateg);
		   
   
			   if($datediff >= '0' && $gdate[$g]->GLI_end_date != '0000-00-00' ){
			   $sendgli = 1;
			   $gli = $g + 1 ;
			   
			   $list_gli[] = "GENERAL LIABILITY POLICY - ".$gli ;
			   $brk_gli = '<br />';
			   $gli = '';
			   }
        }
		if($list_gli)
		$list_gli_tot = implode('<br />',$list_gli);
		$datediff = 0 ;
		
		$aipdate1="SELECT aip_end_date FROM #__cam_vendor_auto_insurance where vendor_id=".$user->id." ";
        $db->Setquery($aipdate1);
        $aipdate = $db->loadObjectList();
        
        for($a=0; $a<count($aipdate); $a++)
        {
           $datea=$aipdate[$a]->aip_end_date;
           $datediff = strtotime($today)-strtotime($datea);
			   if($datediff >= '0' && $aipdate[$a]->aip_end_date != '0000-00-00' ){
			   $sendaip = 1;
			   $aip = $a + 1 ;
			   $list_aip[] = "COMMERCIAL VEHICLE POLICY - ".$aip ;
			   $brk_aip = '<br />';
			   }
        }
		if($list_aip)
		$list_aip_tot = implode('<br />',$list_aip);
		$datediff = 0 ;
		
		$oldate1="SELECT OLN_expdate FROM #__cam_vendor_occupational_license where vendor_id=".$user->id." ";
        $db->Setquery($oldate1);
        $oldate = $db->loadObjectList();
        
        for($o=0; $o<count($oldate); $o++)
        {
           $dateo = $oldate[$o]->OLN_expdate;
           $datediff = strtotime($today)-strtotime($dateo);
			   if($datediff >= '0' && $oldate[$o]->OLN_expdate != '0000-00-00' ){
			   $sendoln = 1;
			   $oln = $o + 1 ;
			   $list_oln[] = "BUS. TAX RECEIPT / OCCUPATIONAL LICENSE - ".$oln ;
			   $brk_oln = '<br />';
			   }
        }
		if($list_oln)
		$list_oln_tot = implode('<br />',$list_oln);
        $datediff = 0 ; 
		
		$wcdate1="SELECT wc_end_date FROM #__cam_vendor_workers_compansation where vendor_id=".$user->id." ";
        $db->Setquery($wcdate1);
        $wcdate = $db->loadObjectList();
        
        for($wc=0; $wc<count($wcdate); $wc++)
        {
           $datewc = $wcdate[$wc]->wc_end_date;
           $datediff = strtotime($today)-strtotime($datewc);
			   if($datediff >= '0' && $wcdate[$wc]->wc_end_date != '0000-00-00' ){
			   $sendwc = 1;
			   $wcd = $wc + 1 ;
			   $list_wc[] = "WORKERS COMP EXEMPTION FORM - ".$wcd ;
			   $brk_wc = '<br />';
			   }
        }
		if($list_wc)
		$list_wc_tot = implode('<br />',$list_wc);
        $datediff = 0 ;
		
		$pldate1="SELECT PLN_expdate FROM #__cam_vendor_professional_license where vendor_id=".$user->id." ";
        $db->Setquery($pldate1);
        $pldate = $db->loadObjectList();
        
        for($p=0; $p<count($pldate); $p++)
        {
           $datep = $pldate[$p]->PLN_expdate;
           $datediff = strtotime($today)-strtotime($datep);
               if($datediff >= '0' && $pldate[$p]->PLN_expdate != '0000-00-00' ){
			   $sendpln = 1;
			   $pln = $p + 1 ;
			   $list_pln[] = "PROFESSIONAL LICENSE - ".$pln ;
			   $brk_pln = '<br />';
			   }
        }
		if($list_pln)
		$list_pln_tot = implode('<br />',$list_pln);
        $datediff = 0 ;  
		
		$wdate1="SELECT WCI_end_date FROM #__cam_vendor_workers_companies_insurance where vendor_id=".$user->id." ";
        $db->Setquery($wdate1);
        $wdate = $db->loadObjectList();
        //echo "<pre>"; print_r($wdate);
        for($w=0; $w<count($wdate); $w++)
        {
           $datew = $wdate[$w]->WCI_end_date;
           $datediff = strtotime($today)-strtotime($datew);
           	   if($datediff >= '0' && $wdate[$w]->WCI_end_date != '0000-00-00' ){
			   $sendwci = 1;
			   $wci = $w + 1 ;
			   $list_wci[] = "WORKERS COMPENSATION / EMPLOYER`S LIABILITY POLICY - ".$wci ;
			   $brk_wci = '<br />';
			   }
        }
		if($list_wci)
		$list_wci_tot = implode('<br />',$list_wci);	
        $datediff = 0 ;
		
		
		$udate1="SELECT UMB_expdate FROM #__cam_vendor_umbrella_license where vendor_id=".$user->id." ";
        $db->Setquery($udate1);
        $udate = $db->loadObjectList();
        //echo "<pre>"; print_r($wdate);
        for($u=0; $u<count($udate); $u++)
        {
           $dateu = $udate[$u]->UMB_expdate;
           $datediff = strtotime($today)-strtotime($dateu);
           	   if($datediff >= '0' && $udate[$u]->UMB_expdate != '0000-00-00' ){
			   $sendumb = 1;
			   $umb = $u + 1 ;
			   $list_umb[] = "UMBRELLA LIABILITY POLICY - ".$umb ;
			   $brk_umb = '<br />';
			   }
        }
		if($list_umb)
		$list_umb_tot = implode('<br />',$list_umb);	
        $datediff = 0 ;
		
		if($list_gli_tot)
		$brk_wci = '<br />';
		else
		$brk_wci = '';
		
		if($list_pln_tot)
		$brk_gli = '<br />';
		else
		$brk_gli = '';
		
		if($list_wc_tot)
		$brk_pln = '<br />';
		else
		$brk_pln = '';
		
		if($list_oln_tot)
		$brk_wc = '<br />';
		else
		$brk_wc = '';
		
		if($list_aip_tot)
		$brk_oln = '<br />';
		else
		$brk_oln = '';
		
		if($list_umb_tot)
		$brk_umb = '<br />';
		else
		$brk_umb = '';
		
		$totalexpireddocs = $list_wci_tot.$brk_wci.$list_gli_tot.$brk_gli.$list_pln_tot.$brk_pln.$list_wc_tot.$brk_wc.$list_oln_tot.$brk_oln.$list_aip_tot.$brk_umb.$list_umb_tot;
		
		
	$totalexpireddocs = preg_replace( '@^(<br\\b[^>]*/?>)+@i', '', $totalexpireddocs ); // Removes first break tag from string
	$db = JFactory::getDBO();
	$mailfrom = 'support@myvendorcenter.com';
	$fromname = 'MyVendorCenter Team';
	$recipient = $user->email;
	$ccemails = $user->ccemail;
    
	$vendor_company = "SELECT company_name  FROM #__cam_vendor_company where user_id=".$user->id."";
	$db->setQuery($vendor_company);
	$vcompanyv = $db->loadResult();
        //echo '<pre>'; print_r($recipient); echo '<br/>'; echo $n; 
	//$recipient = 'lalitha@projectsinfo.net';
	$vendorname = $user->name.'&nbsp;'.$user->lastname;
        
	$mailsubject = 'Your compliance document has expired';
	$sql = "SELECT introtext FROM #__content   where id=273"; 
	$db->Setquery($sql);
	$introtext=$db->loadResult();
    
	$body = str_replace('[Vendor Company Name]',$vcompanyv,$introtext); 
	$body = str_replace('[Compliance Document]',$totalexpireddocs,$body);
	//echo $body ;
	$vendor_subscribe = "SELECT subscribe  FROM #__users where id=".$user->id."";
	$db->setQuery($vendor_subscribe);
	$subscribe = $db->loadResult();
	if($subscribe == 'yes'){
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	
				$cclist = explode(';',$ccemails);
				for($c=0; $c<=count($cclist); $c++)
				{
					$listcc = $cclist[$c];
					if($listcc){
						$res = JUtility::sendMail($mailfrom, $fromname, $listcc, $mailsubject, $body,$mode = 1); 
					}
				}
	$recipient = 'rize.cama@gmail.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	$recipient = 'simon.soa@gmail.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	$recipient = 'vendoremails@myvendorcenter.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	}

            $list_wci = '';
			$list_pln = '';
			$list_wc = '';
			$list_oln = '';
			$list_aip = '';
			$list_gli = '';
			$list_umb = '';
			
			$list_wci_tot = '';
			$list_gli_tot = '';
			$list_pln_tot = '';
			$list_wc_tot = '';
			$list_oln_tot = '';
			$list_aip_tot = '';	
			$list_umb_tot = '';	
}	//

exit;
