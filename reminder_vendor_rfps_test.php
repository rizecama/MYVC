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
$today = date('Y-m-d');
/* Create a database object */
//$days_ago = date('Y-m-d', strtotime('1 days', strtotime($today)));


$db =& JFactory::getDBO();
 $sql_openrfps = "SELECT id, update_date,createdDate, property_id, cust_id, industry_id, projectName from `#__cam_rfpinfo` where rfp_type='rfp' and publish='1'";
$db->setQuery($sql_openrfps);
$rfps = $db->loadObjectList();
for( $r=0; $r<count($rfps); $r++ ){
	$today = date('Y-m-d');
	//calculate days in between present and db date
	$dbdate = explode('-',$rfps[$r]->update_date);
	$rfpdate = $dbdate[2] . '-' . $dbdate[0] . '-' . $dbdate[1] ;
	$date_difference = strtotime($today) - strtotime($rfpdate) ;
	$days = $date_difference / 86400 ;
	$reminder = ($days % 5);
	
	if($reminder == '0'){
		$sql_invites = "SELECT user_id from `#__cam_vendor_availablejobs` where rfp_id=".$rfps[$r]->id." and status = '0' and not_interested = '0' ";
		$db->setQuery($sql_invites);
		$invitations = $db->loadObjectList();
		
			if($invitations) {
				for( $i=0; $i<count($invitations); $i++ ){
					
					 $sql = "SELECT  vendorid from `#__invitations_personal` where rfpid=".$rfps[$i]->id."";
					$db->setQuery($sql);
					$personal_vendors = $db->loadObjectList();
						if( $personal_vendorss )
						 {
						for( $e=0; $e<count($personal_vendors); $e++ ){
						$personal_vendorss[] = $personal_vendors[$e]->vendorid;
						 }
						}
						else
						$personal_vendorss[] =''; 
					if( !in_array($invitations[$i]->user_id,$personal_vendorss)  ) 
			           {	
					//Get vendor company name
					 $sql_vcompany = "SELECT company_name FROM #__cam_vendor_company WHERE  user_id =  ".$invitations[$i]->user_id." ";
					$db->setQuery($sql_vcompany);
					$vendor_companyname = $db->loadResult();
					// Get manager name
					$sql_managername = "SELECT name, lastname FROM #__users WHERE id = ".$rfps[$r]->cust_id." ";
					$db->setQuery($sql_managername);
					$manager_fullname = $db->loadObject();
					$manager_name = $manager_fullname->name.'&nbsp;'.$manager_fullname->lastname;
					//Get Prooperty name
					$sql_propertyname = "SELECT property_name FROM #__cam_property WHERE id = ".$rfps[$r]->property_id." ";
					$db->setQuery($sql_propertyname);
					$property_name = $db->loadResult();
					//Get vendor email
					$sql_managername = "SELECT email, ccemail, subscribe FROM #__users WHERE id = ".$invitations[$i]->user_id." ";
					$db->setQuery($sql_managername);
					$vendors = $db->loadObject();
					$vendormail = $vendors->email ;
					$vendorccmail = $vendors->ccemail ;
					$subscribe = $vendors->subscribe ;
					
					$message = "SELECT introtext FROM #__content WHERE  id=331";
					$db->setQuery($message);
					$body = $db->loadResult();
					
					$body = str_replace('[Vendor Company Name]',$vendor_companyname,$body);
					$body = str_replace('[Manager Full Name]',$manager_name,$body);
					
					
					$sub = "A Project is available for your company_devtest";
					$from = "support@myvendorcenter.com";
					$from_name = 'MyVendorCenter';
					//$to_rize = $vendor_email ;					
					$to_rize = 'rize.cama@gmail.com';
					$to_eric = 'vendoremails@myvendorcenter.com' ;
					//To get proposal id
					$proposal_sql = "SELECT id FROM #__cam_vendor_proposals WHERE rfpno = ".$rfps[$r]->id." and proposedvendorid=".$invitations[$i]->user_id." and bidfrom='admin' ";
					$db->setQuery($proposal_sql);
					$proposalid = $db->loadResult();
					//To check this vendor invited or not 
					$rfpin = "SELECT id FROM #__rfp_invitations WHERE rfpid = ".$rfps[$r]->id." and vendorid=".$invitations[$i]->user_id."  ";
					$db->setQuery($rfpin);
					$invited = $db->loadResult();
					$excting_vendor = "SELECT id FROM #__cam_rfp_reminders_open WHERE rfpid = ".$rfps[$r]->id." and vendorid=".$invitations[$i]->user_id."";
					$db->setQuery($excting_vendor);
					$excting_vendor = $db->loadResult();
					
				if($invited) {	
					if( $subscribe == 'yes' && !$excting_vendor ) {
					$successMail =JUtility::sendMail($from, $from_name, $to_rize, $sub, $body,$mode = 1);
					//$successMail =JUtility::sendMail($from, $from_name, $to_eric, $sub, $body,$mode = 1);
					//$successMail =JUtility::sendMail($from, $from_name, $vendormail, $sub, $body,$mode = 1);
					//To send the mail to CC
					$cclist = explode(';',$vendorccmail);
					for($c=0; $c<=count($cclist); $c++){
					$listcc = $cclist[$c];
					if($listcc){
					//$successMail =JUtility::sendMail($from, $from_name, $listcc, $sub, $body,$mode = 1);
					}
					} 
					}
					if( !$excting_vendor )
					 {
					$sql = "insert into #__cam_rfp_reminders_open values ('','".$rfps[$r]->id."','".$invitations[$i]->user_id."','".$proposalid."','".$rfps[$r]->cust_id."', '".date("m-d-Y H:i")."','a', '1')";
					$db->SetQuery($sql);
					$db->query();
					}	
			     }
			
				}	
				}
			}
	
	} //If condition check dates
		} //Completed managers for loop


		
?>