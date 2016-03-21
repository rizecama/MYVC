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
$after1day=date('Y-m-d', strtotime('+1 days', strtotime($today)));
//$dateDiff = $today - $date2;
 $after60days=date('Y-m-d', strtotime('+60 days', strtotime($today)));



/******************************************************OLN DOCS***********************************************************/

 /*$OLN_EXP_DOCS = "SELECT distinct(u.id) FROM #__users as u 
LEFT JOIN #__cam_vendor_occupational_license as A ON A.vendor_id=u.id
LEFT JOIN  #__cam_vendor_professional_license as B ON B.vendor_id=u.id
LEFT JOIN  #__cam_vendor_liability_insurence as C ON C.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_companies_insurance as D ON D.vendor_id=u.id
 WHERE u.user_type = 11 AND ((A.OLN_expdate = '".$days_ago."' AND A.OLN_expdate != '00-00-0000') OR (B.PLN_expdate = '".$days_ago."' AND B.PLN_expdate != '00-00-0000') OR (C.GLI_end_date = '".$days_ago."' AND C.GLI_end_date != '00-00-0000') OR (D.WCI_end_date = '".$days_ago."' AND D.WCI_end_date != '00-00-0000'))  ORDER BY u.id ";
$db->Setquery($OLN_EXP_DOCS);
$vendor_ids = $db->loadResultArray();*/

$OLN_EXP_DOCS = "SELECT distinct(u.id) FROM #__users as u 
LEFT JOIN #__cam_vendor_occupational_license as A ON A.vendor_id=u.id
LEFT JOIN #__cam_vendor_auto_insurance as AI ON AI.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_compansation as WC ON WC.vendor_id=u.id
LEFT JOIN  #__cam_vendor_professional_license as B ON B.vendor_id=u.id
LEFT JOIN  #__cam_vendor_liability_insurence as C ON C.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_companies_insurance as D ON D.vendor_id=u.id
 WHERE u.user_type = 11 AND u.id=1767 AND ((A.OLN_expdate != '00-00-0000' AND A.OLN_expdate < '".$today."') OR (B.PLN_expdate != '00-00-0000' AND B.PLN_expdate < '".$today."') OR (C.GLI_end_date != '00-00-0000' AND C.GLI_end_date < '".$today."')  OR (D.WCI_end_date != '00-00-0000' AND  D.WCI_end_date < '".$today."') OR (AI.aip_end_date != '00-00-0000' AND AI.aip_end_date < '".$today."') OR (WC.wc_end_date != '00-00-0000' AND WC.wc_end_date < '".$today."'))  ORDER BY u.id ";
$db->Setquery($OLN_EXP_DOCS);
$vendor_ids = $db->loadResultArray();

//$vendor_id='1354';
//$vendor_ids=array($vendor_id);
//echo "<pre>"; print_r($vendor_ids); exit;

/********************************************code to send email notifications to vendros**********************************/
for($n=0; $n<count($vendor_ids); $n++)
{
	//To get the vendors information
	$user = JFactory::getUSer($vendor_ids[$n]);
//        echo "<br />" . $user->id . "<br>";
        $aipdate1="SELECT aip_end_date FROM #__cam_vendor_auto_insurance where vendor_id=".$user->id." ";
        $db->Setquery($aipdate1);
        $aipdate = $db->loadObjectList();
        
        for($a=0; $a<count($aipdate); $a++)
        {
           $datea=$aipdate[$a]->aip_end_date;
           $daylen = 60*60*24;
           $datediff= (strtotime($today)-strtotime($datea))/$daylen;
           $result=$datediff % 60;
         
           if($result=='0' && $datediff > 0){
               $senda=1;
           }
        }
        $datediff = 0 ;
		$result = 0 ;
        $oldate1="SELECT OLN_expdate FROM #__cam_vendor_occupational_license where vendor_id=".$user->id." ";
        $db->Setquery($oldate1);
        $oldate = $db->loadObjectList();
        
        for($o=0; $o<count($oldate); $o++)
        {
           $dateo=$oldate[$o]->OLN_expdate;
            $daylen = 60*60*24;
           $datediff= (strtotime($today)-strtotime($dateo))/$daylen;
           $result=$datediff % 60;
         
           if($result=='0' && $datediff > 0){
               $sendo=1;
           }
        }
        $datediff = 0 ; 
		$result = 0 ;       
        $wcdate1="SELECT wc_end_date FROM #__cam_vendor_workers_compansation where vendor_id=".$user->id." ";
        $db->Setquery($wcdate1);
        $wcdate = $db->loadObjectList();
        
        for($wc=0; $wc<count($wcdate); $wc++)
        {
           $datewc=$wcdate[$wc]->wc_end_date;
            $daylen = 60*60*24;
           $datediff= (strtotime($today)-strtotime($datewc))/$daylen;
		   
           $result=$datediff % 60;
        
           if($result=='0' && $datediff > 0){
               $sendwc=1;
           }
        }
        $datediff = 0 ;
		$result = 0 ;
				
         $pldate1="SELECT PLN_expdate FROM #__cam_vendor_professional_license where vendor_id=".$user->id." ";
        $db->Setquery($pldate1);
        $pldate = $db->loadObjectList();
        
        for($p=0; $p<count($pldate); $p++)
        {
           $datep=$pldate[$p]->PLN_expdate;
            $daylen = 60*60*24;
           $datediff= (strtotime($today)-strtotime($datep))/$daylen;
           $result=$datediff % 60;
         
           if($result=='0' && $datediff > 0){
               $sendp=1;
           }
        }
        $datediff = 0 ;  
		$result = 0 ;      
        $gdate1="SELECT GLI_end_date FROM #__cam_vendor_liability_insurence where vendor_id=".$user->id." ";
        $db->Setquery($gdate1);
        $gdate = $db->loadObjectList();
        
        for($g=0; $g<count($gdate); $g++)
        {
           $dateg=$gdate[$g]->GLI_end_date;
           $daylen = 60*60*24;
           $datediff= (strtotime($today)-strtotime($dateg))/$daylen;
		   //echo "<br>".$datediff."<br>";
           $result=$datediff % 60;
         
           if($result=='0' && $datediff > 0){
               $sendg=1;
           }
        }
        $datediff = 0 ;  
		$result = 0 ;      
        $wdate1="SELECT WCI_end_date FROM #__cam_vendor_workers_companies_insurance where vendor_id=".$user->id." ";
        $db->Setquery($wdate1);
        $wdate = $db->loadObjectList();
        //echo "<pre>"; print_r($wdate);
        for($w=0; $w<count($wdate); $w++)
        {
           $datew=$wdate[$w]->WCI_end_date;
           $daylen = 60*60*24;
           $datediff = (strtotime($today)-strtotime($datew))/$daylen;
           $result=$datediff % 60;
           if($result=='0' && $datediff > 0){
               $sendw=1;
           }
          
        }
        $datediff = 0 ;
		$result = 0 ;		
//	  echo "A:".$sendw . '<br />' . "B:".$sendg . '<br />' . "C:".$sendp . '<br />' . "D:".$sendwc . '<br />' . "E:".$sendo . '<br />' . "F:".$senda ;
	  $sendw='1';
	  $sendg='1';
	  $sendp='1';
	  $sendwc='1';
	  $sendo='1';
	  $senda='1';
        if($sendw=='1' || $sendg=='1'|| $sendp=='1'|| $sendwc=='1' || $sendo=='1' || $senda=='1'){
		
			if($sendw) {
			$brk_wci = '<br />';
			$wci_docs="SELECT WCI_end_date FROM #__cam_vendor_workers_companies_insurance where vendor_id=".$user->id." ";
			$db->Setquery($wci_docs);
			$totalwcidocs = $db->loadObjectList();
				for( $wc=0; $wc<count($totalwcidocs); $wc++ ){
					if($totalwcidocs[$g]->WCI_end_date < $today){
						$wcc = $wc + 1 ;
						$list_wci[] = "WORKERS COMPENSATION / EMPLOYER`S LIABILITY POLICY - ".$wcc; 
					}
				}
				$list_wci_tot = implode('<br />',$list_wci);	
			}
			
			if($sendg) {
			$brk_gli = '<br />';	
			$gli_docs = "SELECT GLI_end_date FROM #__cam_vendor_liability_insurence where vendor_id=".$user->id." ";
			$db->Setquery($gli_docs);
			$totalglidocs = $db->loadObjectList();
				for( $g=0; $g<count($totalglidocs); $g++ ){
					if($totalglidocs[$g]->GLI_end_date < $today){
						$gli = $g + 1 ;
						$list_gli[] = "GENERAL LIABILITY POLICY - ".$gli ; 
					}
				}
				$list_gli_tot = implode('<br />',$list_gli);				
			}
			
			if($sendp) {
			$brk_pln = '<br />';
			$pln_docs="SELECT PLN_expdate FROM #__cam_vendor_professional_license where vendor_id=".$user->id." ";
			$db->Setquery($pln_docs);
			$totalplndocs = $db->loadObjectList();
				for( $p=0; $p<count($totalplndocs); $p++ ){
					if($totalplndocs[$p]->PLN_expdate < $today){
						$plnc = $p + 1; 	
						$list_pln[] = "PROFESSIONAL LICENSE - ".$plnc; 
					}
				}
				$list_pln_tot = implode('<br />',$list_pln);				
			}
			
			if($sendwc) {
			$brk_wc = '<br />';	
			// Get document id 
			$wc_docs="SELECT wc_end_date FROM #__cam_vendor_workers_compansation where vendor_id=".$user->id." ";
			$db->Setquery($wc_docs);
			$totalwcdocs = $db->loadObjectList();
				for( $w=0; $w<count($totalwcdocs); $w++ ){
					if($totalwcdocs[$w]->wc_end_date < $today){
						$wcil = $w + 1 ;
						$list_wc[] = "WORKERS COMP EXEMPTION FORM - ".$wcil ; 
					}
				}
				$list_wc_tot = implode('<br />',$list_wc);			
			}
			
			if($sendo) {
			$brk_oln = '<br />';	
			// Get document id 
			$oln_docs = "SELECT OLN_expdate FROM #__cam_vendor_occupational_license where vendor_id=".$user->id." ";
			$db->Setquery($oln_docs);
			$totalolndocs = $db->loadObjectList();
				for( $o=0; $o<count($totalolndocs); $o++ ){
					if($totalolndocs[$o]->OLN_expdate < $today){
						$ols = $o + 1 ;
						$list_oln[] = "BUS. TAX RECEIPT / OCCUPATIONAL LICENSE - ".$ols ; 
					}
				}
				$list_oln_tot = implode('<br />',$list_oln);		
			}
			
			if($senda) {
			// Get document id 
			$aip_dos="SELECT id, aip_end_date FROM #__cam_vendor_auto_insurance where vendor_id=".$user->id." order by id ASC ";
			$db->Setquery($aip_dos);
			$totaldocs = $db->loadObjectList();
			//echo "<pre>"; print_r($totaldocs);
				for( $a=0; $a<count($totaldocs); $a++ ){
					if($totaldocs[$a]->aip_end_date < $today){
						$aips = $a + 1 ;
						$list_aip[] = "COMMERCIAL VEHICLE POLICY - ".$aips ; 
					}
				}
				$list_aip_tot = implode('<br />',$list_aip);
			}
			
			$totalexpireddocs = $list_wci_tot.$brk_wci.$list_gli_tot.$brk_gli.$list_pln_tot.$brk_pln.$list_wc_tot.$brk_wc.$list_oln_tot.$brk_oln.$list_aip_tot;
			
			$recipient = $user->email;
			
			
         $db = JFactory::getDBO();
	$mailfrom = 'support@myvendorcenter.com';
	$fromname = 'MyVendorCenter Team';
	$recipient = $user->email;
	$ccemails = $user->ccemail;
        //echo '<pre>'; print_r($recipient); echo '<br/>'; echo $n; exit;
	//$recipient = 'lalitha@projectsinfo.net';
	//$vendorname = $user->name.'&nbsp;'.$user->lastname;
    $vendor_company = "SELECT company_name  FROM #__cam_vendor_company where user_id=".$user->id." ";
	$db->setQuery($vendor_company);
	$vcompanyv = $db->loadResult();
	$mailsubject = 'Your Compliance Document has Expired';
	$sql = "SELECT introtext FROM #__content where id=273"; 
	$db->Setquery($sql);
	$introtext=$db->loadResult();
   // $recipient = 'rize.cama@gmail.com' ;
        
	$body = str_replace('[Vendor Company Name]',$vcompanyv,$introtext); 
	$body = str_replace('[Compliance Document]',$totalexpireddocs,$body); 
	
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
	//echo $body; exit;
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1);			
	$recipient = 'vendoremails@myvendorcenter.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1);			
       }
	 }  
        $sendw = 0 ;
		$sendg = 0 ;
		$sendp = 0 ;
		$sendwc = 0 ;
		$sendo = 0 ;
        $senda = 0 ;
            $expired_wci = '';
			$expired_gli = '';
			$expired_pln = '';
			$expired_wc = '';
			$expired_oln = '';
			$expired_aip = '';
			$brk_wci = '';
			$brk_gli = '';
			$brk_pln = '';
			$brk_wc = '';
			$brk_oln = '';
			$brk_aip = '';
			
      //  echo '<pre>'; print_r($body); 
	//JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
}	//exit;

exit;
