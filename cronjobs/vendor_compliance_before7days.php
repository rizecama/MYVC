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
$daysbefore7=date('Y-m-d', strtotime('+7 days', strtotime($today)));
$after1day=date('Y-m-d', strtotime('+1 days', strtotime($today)));
$after60days=date('Y-m-d', strtotime('+60 days', strtotime($today)));

//print_r($after60days); exit; 
/******************************************************OLN DOCS***********************************************************/

 $OLN_EXP_DOCS = "SELECT distinct(u.id) FROM #__users as u 
LEFT JOIN #__cam_vendor_occupational_license as A ON A.vendor_id=u.id
LEFT JOIN #__cam_vendor_auto_insurance as AI ON AI.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_compansation as WC ON WC.vendor_id=u.id
LEFT JOIN  #__cam_vendor_professional_license as B ON B.vendor_id=u.id
LEFT JOIN  #__cam_vendor_liability_insurence as C ON C.vendor_id=u.id
LEFT JOIN #__cam_vendor_workers_companies_insurance as D ON D.vendor_id=u.id
 WHERE u.user_type = 11 AND ((A.OLN_expdate = '".$daysbefore7."' AND A.OLN_expdate != '00-00-0000') OR (B.PLN_expdate = '".$daysbefore7."' AND B.PLN_expdate != '00-00-0000') OR (C.GLI_end_date = '".$daysbefore7."' AND C.GLI_end_date != '00-00-0000') OR (AI.aip_end_date = '".$daysbefore7."' AND AI.aip_end_date != '00-00-0000') OR (WC.wc_end_date = '".$daysbefore7."' AND WC.wc_end_date != '00-00-0000') OR (D.WCI_end_date = '".$daysbefore7."' AND D.WCI_end_date != '00-00-0000'))  ORDER BY u.id ";
$db->Setquery($OLN_EXP_DOCS); 
$vendor_ids = $db->loadResultArray();

//$vendor_id='1354';
//$vendor_ids=array($vendor_id);

//echo count($vendor_ids); echo '<br/>';
/********************************************code to send email notifications to vendros**********************************/
for($n=0; $n<count($vendor_ids); $n++)
{
	//To get the vendors information
	$user = JFactory::getUSer($vendor_ids[$n]);
	$db = JFactory::getDBO();
	// To get the particular document
	$log = new checkstatus();
	$gdate1="SELECT GLI_end_date FROM #__cam_vendor_liability_insurence where vendor_id=".$user->id." ";
    $db->Setquery($gdate1);
    $gdate = $db->loadObjectList();
	for($g=0; $g<count($gdate); $g++)
        {
				$dateg = $gdate[$g]->GLI_end_date;
				if($dateg == $daysbefore7)
				{
			    $gli = $g + 1 ;
			    $list_gli = "GENERAL LIABILITY POLICY - ".$gli ;
				$master	=	$log->sendmail_vendor($user->id,$list_gli);
				}
        }
	
	$aipdate1="SELECT aip_end_date FROM #__cam_vendor_auto_insurance where vendor_id=".$user->id." ";
        $db->Setquery($aipdate1);
        $aipdate = $db->loadObjectList();
        
        for($a=0; $a<count($aipdate); $a++)
        {
           $datea = $aipdate[$a]->aip_end_date;
			   if($datea == $daysbefore7){
			   $aip = $a + 1 ;
			   $list_aip = "COMMERCIAL VEHICLE POLICY - ".$aip ;
			   $master	=	$log->sendmail_vendor($user->id,$list_aip);
			   }
        }

	
	$oldate1="SELECT OLN_expdate FROM #__cam_vendor_occupational_license where vendor_id=".$user->id." ";
        $db->Setquery($oldate1);
        $oldate = $db->loadObjectList();
        
        for($o=0; $o<count($oldate); $o++)
        {
           $dateo = $oldate[$o]->OLN_expdate;
			   if($dateo == $daysbefore7){
			   $oln = $o + 1 ;
			   $list_oln = "BUS. TAX RECEIPT / OCCUPATIONAL LICENSE - ".$oln ;
			   $master	=	$log->sendmail_vendor($user->id,$list_oln);
			   }
        }
	
	$wcdate1="SELECT wc_end_date FROM #__cam_vendor_workers_compansation where vendor_id=".$user->id." ";
        $db->Setquery($wcdate1);
        $wcdate = $db->loadObjectList();
        
        for($wc=0; $wc<count($wcdate); $wc++)
        {
           $datewc = $wcdate[$wc]->wc_end_date;
			   if($datewc == $daysbefore7){
			   $wcd = $wc + 1 ;
			   $list_wc = "WORKERS COMP EXEMPTION FORM - ".$wcd ;
			   $master	=	$log->sendmail_vendor($user->id,$list_wc);
			   }
        }
		
	$pldate1="SELECT PLN_expdate FROM #__cam_vendor_professional_license where vendor_id=".$user->id." ";
        $db->Setquery($pldate1);
        $pldate = $db->loadObjectList();
        
        for($p=0; $p<count($pldate); $p++)
        {
           $datep = $pldate[$p]->PLN_expdate;
               if($datep == $daysbefore7){
			   $pln = $p + 1 ;
			   $list_pln = "PROFESSIONAL LICENSE - ".$pln ;
			   $master	=	$log->sendmail_vendor($user->id,$list_pln);
			   }
        }
	
	$wdate1="SELECT WCI_end_date FROM #__cam_vendor_workers_companies_insurance where vendor_id=".$user->id." ";
        $db->Setquery($wdate1);
        $wdate = $db->loadObjectList();
        //echo "<pre>"; print_r($wdate);
        for($w=0; $w<count($wdate); $w++)
        {
           $datew = $wdate[$w]->WCI_end_date;
           	   if($datew == $daysbefore7){
			   $wci = $w + 1 ;
			   $list_wci = "WORKERS COMPENSATION / EMPLOYER`S LIABILITY POLICY - ".$wci ;
			   $master	=	$log->sendmail_vendor($user->id,$list_wci);
			   }
        }

}	//exit;

	class checkstatus
		{
			public function sendmail_vendor($vendorid,$document)
			{
					$user = JFactory::getUSer($vendorid);
					$db = JFactory::getDBO();
					$mailfrom = 'support@myvendorcenter.com';
					$fromname = 'MyVendorCenter Team';
					$recipient = $user->email;
					$ccemails = $user->ccemail;
					$vendor_company = "SELECT company_name  FROM #__cam_vendor_company where user_id=".$user->id."";
					$db->setQuery($vendor_company);
					$vcompanyv = $db->loadResult();
					$vendorname = $user->name.'&nbsp;'.$user->lastname;
					$mailsubject = 'Your Compliance Document is about to Expire';
					$sql = "SELECT introtext FROM #__content   where id=272"; 
					$db->Setquery($sql);
					$introtext=$db->loadResult();
					$body = str_replace('[Vendor Company Name]',$vcompanyv,$introtext); 
					$body = str_replace('[compliance document name]',$document,$body);
					$vendor_subscribe = "SELECT subscribe  FROM #__users where id=".$user->id."";
					$db->setQuery($vendor_subscribe);
					$subscribe = $db->loadResult();
					if($subscribe == 'yes'){
					//$recipient = 'rize.cama@gmail.com' ;
					JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
					
								$cclist = explode(';',$ccemails);
								for($c=0; $c<=count($cclist); $c++)
								{
									$listcc = $cclist[$c];
									if($listcc){
										$res = JUtility::sendMail($mailfrom, $fromname, $listcc, $mailsubject, $body,$mode = 1); 
									}
								}
					//echo $body;			
					$recipient = 'rize.cama@gmail.com';			
					JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
					$recipient = 'vendoremails@myvendorcenter.com';			
					JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
					}
					$subscribe = '';
					$document = '';
			}
		}	
exit;
