<?php

/**

 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.



 * @license		GNU/GPL, see LICENSE.php

 * Joomla! is free software. This version may have been modified pursuant

 * to the GNU General Public License, and as distributed it includes or

 * is derivative of works licensed under the GNU General Public License or

 * other free or open source software licenses.

 * See COPYRIGHT.php for copyright notices and details.

 */

// no direct access

JHTML::_('behavior.modal');

defined( '_JEXEC' ) or die( 'Restricted access' );

$user = JFactory::getUser();

$db = & JFactory::getDBO();

if($user->user_type == '11')



{



		$db = JFactory::getDBO();

		$today = date('Y-m-d');

		$query ="select industry_id from #__cam_vendor_industries Where user_id =".$user->id;

		$db->setQuery($query);

		$getindustryids = $db->loadResultArray();

		if($getindustryids)

		{

		if(in_array('56',$getindustryids))

		$PLN_needed = 'yes';

		else $PLN_needed = 'no';

		}

	else



		$PLN_needed = 'no';

		$user_type = $user->get('user_type');

		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE GLI_end_date  >= '".$today."' AND GLI_upld_cert!= '' AND GLI_policy_occurence!='' AND GLI_policy_aggregate!='' AND GLI_status!='-1' AND vendor_id=".$user->id; //validation to exists of docs



		$db->Setquery($alert_sql);

		$res = $db->loadResult();

		$alert['GLI_exist']= $res;

		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_upld_cert!='' AND w9_status!='-1'  AND vendor_id=".$user->id; //validation to exists of docs

		$db->Setquery($alert_sql);

		$res2 = $db->loadResult();

		$alert['W9_exist']= $res2;



		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE GLI_status = 1 AND vendor_id=".$user->id;



		//$alert_sql = "SELECT count(*) from #__cam_vendor_liability_insurence WHERE GLI_status = 1 AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_liability_insurence where vendor_id=".$user->id.")";



		$db->Setquery($alert_sql);

		$res3 = $db->loadResult();

		if($res3 != 0) $res3=0; else $res3=1;

		$alert['GLI_status']= $res3;

		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_upld_cert!=''  AND ein_number!='' AND vendor_id=".$user->id; //validation to status of docs



		$db->Setquery($alert_sql);

		$res4 = $db->loadResult();

		$alert['W9_status']= $res4;

		



		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_status = 1 AND vendor_id=".$user->id;



		//$alert_sql = "SELECT count(*) from #__cam_vendor_professional_license WHERE PLN_status = 1 AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_professional_license where vendor_id=".$user->id.")";



		$db->Setquery($alert_sql);

		$res5 = $db->loadResult();

		if($res5 != 0) $res5=0; else $res5=1;

		$alert['PLN_status']= $res5;



		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  >= '".$today."' AND PLN_status = 1 AND vendor_id=".$user->id; //validation to expdate of docs



		//$alert_sql = "SELECT count(*) from #__cam_vendor_professional_license WHERE PLN_expdate  >= '".$today."' AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_professional_license where vendor_id=".$user->id.")";



		$db->Setquery($alert_sql);

		$res6 = $db->loadResult();

		if($res6 != 0) $res6=0; else $res6=1;

		$alert['PLN_exp']= $res6;



		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  >= '".$today."' AND PLN_state!='' AND PLN_type!='' AND PLN_upld_cert!='' AND PLN_status!='-1' AND vendor_id=".$user->id;

		$db->Setquery($alert_sql);

		$res7 = $db->loadResult();

		$alert['PLN_exist']= $res7;

/*$alert_sql ="SELECT count(*) from #__cam_vendor_occupational_license   WHERE OLN_expdate <= '".$today."' AND vendor_id=".$user->id; //validation to expdate of docs



		$db->Setquery($alert_sql);



		$res5 = $db->loadResult();



		$alert['OLN_exp']= $res5;



		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  <= '".$today."' AND vendor_id=".$user->id; //validation to expdate of docs



		$db->Setquery($alert_sql);



		$res6 = $db->loadResult();



		$alert['PLN_exp']= $res6;



		$alert_sql ="SELECT count(*) from #__cam_vendor_workers_companies_insurance   WHERE WCI_end_date  <= '".$today."' AND vendor_id=".$user->id; //validation to expdate of docs



		$db->Setquery($alert_sql);



		$res7 = $db->loadResult();



		$alert['WCI_exp']= $res7;*/

		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence   WHERE GLI_end_date  >= '".$today."' AND GLI_upld_cert!= '' AND GLI_policy_occurence!='' AND GLI_policy_aggregate!='' AND vendor_id=".$user->id; //validation to expdate of docs

		//$alert_sql = "SELECT count(*) from #__cam_vendor_liability_insurence WHERE GLI_end_date  >= '".$today."' AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_liability_insurence where vendor_id=".$user->id.")";

		$db->Setquery($alert_sql);

		$res8 = $db->loadResult();

		if($res8 != 0) $res8=0; else $res8=1;

		$alert['GLI_exp']= $res8;

		//echo "<pre>"; print_r($vendor_GLI_compliance_alert);

		$vendor_GLI_compliance_alert = $alert;

		//To get the subscription level
		$subscribe = "SELECT subscribe from #__users   WHERE id=".$user->id;
		$db->Setquery($subscribe);
		$sub_type = $db->loadResult();
	//Completed

}



?>





<?php
//Company ID Check

$compid = 0;
$user = & JFactory::getUser(); 
$uid = $user->get('id');
$usertype = $user->get('user_type') ;
//Check if User ID is saved and up to date

if(!isset($_COOKIE['tpl_usr']) || $_COOKIE['tpl_usr'] != $uid){
$db = JFactory::getDBO();
//Look up Company ID
if($usertype == '12'){
$usr = "SELECT comp_id FROM `jos_cam_customer_companyinfo` WHERE cust_id=".$uid;
$db->Setquery($usr);
$compid = $db->loadResult();
}
if($usertype == '13'){
$usr = "SELECT id FROM `jos_cam_camfirminfo` WHERE cust_id=".$uid; 
$db->Setquery($usr);
$compid = $db->loadResult();
}
//Cache Company Info
setcookie("tpl_usr", $uid);
setcookie("comp_id", $compid);
}
else{
//Get Company ID from cookie
$compid = $_COOKIE['comp_id'];
}
if($compid > 0){
//Insert Company ID into page Head
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/company/company'.$compid.'.css" type="text/css" />';
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<jdoc:include type="head" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/menu.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/stylesheet.css" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/camassistant_left/images/favicon.ico"/>

 <link href="templates/camassistant_left/favicon.ico" rel="shortcut icon" type="image/x-icon" />


  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/system/css/modal.css" type="text/css" />
  
  <?php echo $company_css; ?>

<?php if( ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'closedrfp' && $_REQUEST['type'] == 'end') || 
		  ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'awardrfp')	||
		  ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'awardrfp' && $_REQUEST['rated'] == 'yes')
 ){ ?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<?php } ?>

<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/main.js"></script>

  <script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/modal.js"></script>

  <!--Start of Zopim Live Chat Script-->

<script type="text/javascript">

window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=

d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.

_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');

$.src='//v2.zopim.com/?1RqQOqVdj61nnN81694Osoej0wUVYcKZ';z.t=+new Date;$.

type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');

</script>
<script type="text/javascript">
function getrequestpopup(){
	el='index.php?option=com_camassistant&controller=rfp&task=getrfptype&tmpl=component';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:380}}"))
	SqueezeBox.fromElement(el,options);
}
</script>
<!--End of Zopim Live Chat Script-->

</head>

<body class="Body_rfp cid<?php echo $compid; ?>">

<p>

  <!--sof index Banner BG -->

</p>

<!--eof index Banner BG -->

<!-- sof wrapper -->

<div id="wrapper">

	<div id="header">

		<div id="logo">

		<?php

		$user =& JFactory::getUser();

		if($user->user_type == 13 && $_REQUEST['view'] == 'frontpage') {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';

		}


		else if($user->user_type == 11 && $_REQUEST['view'] == 'frontpage') {

		$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';

		}

                else if($user->user_type == 12 && $_REQUEST['view'] == 'frontpage') {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';

		}
		if($user->user_type == 16 ) {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';

		}

		else {
			if($user->user_type == 11 && ($sub_type == 'no' || $sub_type == '')){
			$link = 'index.php?option=com_camassistant&controller=vendors&task=subscriptions&Itemid=213';	
			}
			else {
			$link = 'index.php';
			}
		}

		?>

			<a href="<?php echo $link;?>">

				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/myvendorcenter.gif" alt="CAMassistant.com - we do your bidding" />



			</a>

		</div>

		<!-- sof signin -->

		<div id="signin_pannel">

					   <?php if(($_REQUEST['task'] == 'vendorsignup_p2') || ($_REQUEST['task'] == 'vendorsignup_p3') || ($_REQUEST['task'] == 'mail_redirect_form')  || ($_REQUEST['task'] == 'thanks_redirect')) {/*echo 'in if'; echo $_REQUEST['task']; exit; */?>

	   			<jdoc:include type="modules" name="nologin" />

	   <?php } else { /*echo 'in else if'; exit;*/ ?>

	   			<jdoc:include type="modules" name="login" />

	   <?php } ?>

		</div>

	<!-- eof signin -->

	</div>

<!-- eof header -->

<!-- sof Navigation -->

	<div id="navbar_in">

		<div id="navigation_in2">

			<?php if($user->id ) { ?>
			<jdoc:include type="modules" name="menu_logged" />
			<?php } else { ?>
			<jdoc:include type="modules" name="menu" />
			<?php } ?>
			

		</div>

		<div id="fontsize_white">

				<jdoc:include type="modules" name="size_left" />

		</div>

	<div class="clear"></div>

</div>

<!-- eof Navigation -->

<!-- sof container -->

<?php

$db = & JFactory::getDBO();

$query ="select suspend from #__users Where id =".$user->id;

$db->setQuery($query);

$suspend = $db->loadResult();

if($suspend == 'suspend'){

$display = 'none';

$message = "<div id='container_inner_suspend'>Your Account has been locked by a MyVendorCenter.com Administrator. Please call our office at 561-246-3830 so we can re-enable your account.</div>";

}

else{

$display = '';

}

echo $message ;

?>

<div id="container_inner" style="display:<?php echo $display; ?>">

<!-- sof left -->

<div id="vender_left">

<jdoc:include type="modules" name="feedback" />

			<?php if($_REQUEST['controller']=='rfpcenter' || $_REQUEST['controller']=='rfp' || $_REQUEST['task'] == 'invitemanager' || $_REQUEST['controller']=='boardmembers' || $_REQUEST['task']=='manage_properties' || $_REQUEST['task']=='customer_edit_form' || $_REQUEST['task'] == 'dm_rfps_by_managers' || $_REQUEST['task'] == 'vendorscenter' || $_REQUEST['controller']=='addproperty' || $_REQUEST['controller']=='vendorscenter' || $_REQUEST['controller']=='sorting' || $_REQUEST['controller']=='vinvitations' || $_REQUEST['task'] =='company_edit_form' || ($_REQUEST['controller']=='documents' && $user->user_type != '11' ) ) { ?>

			<jdoc:include type="modules" name="rfpimage" />

			<?php } else if($_REQUEST['Itemid']=='112') { ?>

			<jdoc:include type="modules" name="image1" style="subscriptiontype" />

			<?php } else if($_REQUEST['controller']=='vendorsignup' ){ ?>

			<jdoc:include type="modules" name="billing_image" />

			<?php } else if($user->id && $sub_type == 'yes') { ?>

			<jdoc:include type="modules" name="image1" style="subscriptiontype" />

			<?php } else {?>
			<jdoc:include type="modules" name="fimage" />
			<?php } ?>
			<?php if($user->user_type == '11' && ($sub_type == 'no' || $sub_type == '')){ ?>
			<jdoc:include type="modules" name="subscriptionfail" style="subscriptionfail" />
			<?php }
			?>
			
			<?php if($user->user_type == '11' && $sub_type == 'yes') : ?>

					<jdoc:include type="modules" name="left" style="left_menu" />
					<jdoc:include type="modules" name="left1" style="left_menu_yellow" />
					<?php /*?><?PHP if(($vendor_GLI_compliance_alert['GLI_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_status'] == 0 && $vendor_GLI_compliance_alert['W9_status'] == 0) && ($vendor_GLI_compliance_alert['GLI_exp'] == 0) ) { ?><?php */?>

					<?PHP  /*if($PLN_needed == 'no') { 

					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0) {  ?>

					<jdoc:include type="modules" name="left1" style="left_menu_yellow" />

					<?PHP } } else if($PLN_needed == 'yes'){ 

					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0 && $vendor_GLI_compliance_alert['PLN_exist'] != 0) {  ?>

					<jdoc:include type="modules" name="left1" style="left_menu_yellow" />

					<?PHP } }*/

					?>

			<?php endif; ?>

			<?php if($user->user_type == '11' && $sub_type == 'yes') : ?>

			<jdoc:include type="modules" name="vendorrating" style="left_frim_green" />

			<?php endif; ?>
			<?php if($user->user_type == '11' && $sub_type == 'yes') : ?>
			<jdoc:include type="modules" name="vendorseal" style="" />
			<?php endif; ?>
								
			<?php if ($user->user_type == '12' && $user->dmanager == '') : ?>

					<jdoc:include type="modules" name="leftmenu" style="left_menu" />

					<jdoc:include type="modules" name="leftmenu1" style="left_menu_yellow" />

			<?php endif; ?>

			<?php if ($user->user_type == '13') : ?>

					<jdoc:include type="modules" name="leftfrim" style="left_frim_green" />

					<jdoc:include type="modules" name="leftfrim1" style="left_frim_yellow" />
					<?php if ($user->accounttype == 'master' && $user->user_type == '13' ) { ?>
					<jdoc:include type="modules" name="leftfrim4" style="left_frim_ash" />
					<?php } else { ?>
					<jdoc:include type="modules" name="leftfrim2" style="left_frim_ash" />
					<?php } ?>
					
					
					
					
					
					
					
					
					
					
					
					
			<?php endif; ?>
			

<?php if ($user->user_type == '12' && $user->dmanager == 'yes') : ?>

					<jdoc:include type="modules" name="leftmenu" style="left_menu" />

					<jdoc:include type="modules" name="leftmenu1" style="left_menu_yellow" />

					<jdoc:include type="modules" name="leftfrim3" style="left_frim_ash" />

			<?php endif; ?>
		<?php if ($user->user_type == '16') : ?>
					
					<jdoc:include type="modules" name="leftfrim" style="left_frim_green" />
                     <jdoc:include type="modules" name="leftfrim1" style="left_frim_yellow" />
					<?php if ( $user->user_type == '16' ) { ?>
					
					<?php } else { ?>
					<jdoc:include type="modules" name="leftfrim2" style="left_frim_ash" />
					<?php } ?>
					
			<?php endif; ?>	

	</div>

<!-- eof left -->

<!-- sof right -->

	<div id="vender_right">

	<!-- sof bedcrumb -->

		<!--<div id="bedcrumb">

				&nbsp;

		</div>-->

		<!--<div id="bedcrumb">

				<jdoc:include type="modules" name="breadcrumb" />

				<div class="clear"></div>

			</div>-->

                 <?php if(($_REQUEST['controller']=='rfpcenter' && $_REQUEST['task']=='dashboard') ||($_REQUEST['controller']=='vendors' && $_REQUEST['task']=='vendor_dashboard')) { ?>

                <jdoc:include type="modules" name="announcement" />

                <?php } ?>

		  <div class="info_message_report"><jdoc:include type="message" /></div>

		<jdoc:include type="component" />

	<!-- eof bedcrumb -->

	</div>

<!-- eof right -->

	<div class="clear"></div>

</div>

<!-- eof container -->

<!-- sof footer -->

<div id="footer">

	<div id="footer_nav">
			<?php if ( !$user->id ) : ?>
			<jdoc:include type="modules" name="footer_menu" />
			<?php endif; ?>
			<?php if ( $user->id ) : ?>
			<jdoc:include type="modules" name="footer_menu_logged" />
			<?php endif; ?>	
	</div>

	<jdoc:include type="modules" name="footer" />

</div>

<!-- eof footer -->

<div class="clear"></div>

</div>

<!-- eof wrapper -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44486501-1', 'myvendorcenter.com');
  ga('send', 'pageview');

</script>
<script type='text/javascript' src="<?php echo $this->baseurl ?>/templates/camassistant_left/js/main.js"></script>
<script type="text/javascript">
	jQuery(document).ready( function(){
<?php 
if( $_REQUEST['task'] != 'vendor_dashboard' ){  ?>
		jQuery('.warning_compliance').addClass('hide');
<?php } 

if( $_REQUEST['task'] != 'vendor_dashboard' ){  ?>
		jQuery('.warning_nonc').addClass('hide');
<?php } 
?>
	});
</script>
<script type="text/javascript">
jQuery('.active_'+'<?php echo $_REQUEST['Itemid']; ?>').addClass('active');

jQuery(function() {
    setTimeout(function() {
        jQuery(".info_message_report").fadeOut("slow")
    }, 5000);
	setTimeout(function() {
        jQuery(".warning_compliance").fadeOut("slow")
    }, 10000);
	setTimeout(function() {
        jQuery(".warning_nonc").fadeOut("slow")
    }, 10000);
	setTimeout(function() {
        jQuery(".warning_recs").fadeOut("slow")
    }, 10000);
	<?php
		setcookie("test_cookie", "test");
		setcookie("nonc_cookie", "nonc");
		setcookie("nonc_cookie", "recs");
	?>
});

</script>


</body>

</html>