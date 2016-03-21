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
echo $daysbefore7 ;
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
	$mailfrom = 'support@myvendorcenter.com';
	$fromname = 'MyVendorCenter Team';
	$recipient = $user->email;
	$ccemails = $user->ccemail;
	
    $vendor_company = "SELECT company_name  FROM #__cam_vendor_company where user_id=".$user->id."";
	$db->setQuery($vendor_company);
	$vcompanyv = $db->loadResult();
        //echo '<pre>'; print_r($recipient); echo '<br/>'; echo $n; exit;
	//$recipient = 'lalitha@projectsinfo.net';
	$vendorname = $user->name.'&nbsp;'.$user->lastname;
        
	$mailsubject = 'Your Compliance Document is about to Expire';
	$sql = "SELECT introtext FROM #__content   where id=272"; 
	$db->Setquery($sql);
	$introtext=$db->loadResult();
        
	$body = str_replace('[Vendor Company Name]',$vcompanyv,$introtext); 
	
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
				
	$recipient = 'rize.cama@gmail.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	$recipient = 'vendoremails@myvendorcenter.com';			
	JUtility::sendMail($mailfrom, $fromname, $recipient, $mailsubject, $body,$mode = 1); 
	}
	$subscribe = '';
				
}	//exit;

exit;
