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
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE vendor_id=".$user->id; //validation to exists of docs
		$db->Setquery($alert_sql);
		$res = $db->loadResult();
		$alert['GLI_exist']= $res;

		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE vendor_id=".$user->id; //validation to exists of docs
		$db->Setquery($alert_sql);
		$res2 = $db->loadResult();
		$alert['W9_exist']= $res2;

		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence  WHERE GLI_status = 1 AND vendor_id=".$user->id;
		//$alert_sql = "SELECT count(*) from #__cam_vendor_liability_insurence WHERE GLI_status = 1 AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_liability_insurence where vendor_id=".$user->id.")";
		$db->Setquery($alert_sql);
		$res3 = $db->loadResult();
		if($res3 != 0) $res3=0; else $res3=1;
		$alert['GLI_status']= $res3;

		$alert_sql ="SELECT count(*) from #__cam_vendor_compliance_w9docs  WHERE w9_status != 1 AND vendor_id=".$user->id; //validation to status of docs
		$db->Setquery($alert_sql);
		$res4 = $db->loadResult();
		$alert['W9_status']= $res4;
		$today = date('Y-m-d');

		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_status = 1 AND vendor_id=".$user->id;
		//$alert_sql = "SELECT count(*) from #__cam_vendor_professional_license WHERE PLN_status = 1 AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_professional_license where vendor_id=".$user->id.")";
		$db->Setquery($alert_sql);
		$res5 = $db->loadResult();
		if($res5 != 0) $res5=0; else $res5=1;
		$alert['PLN_status']= $res5;

		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE PLN_expdate  >= '".$today."' AND vendor_id=".$user->id; //validation to expdate of docs
		//$alert_sql = "SELECT count(*) from #__cam_vendor_professional_license WHERE PLN_expdate  >= '".$today."' AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_professional_license where vendor_id=".$user->id.")";
		$db->Setquery($alert_sql);
		$res6 = $db->loadResult();
		if($res6 != 0) $res6=0; else $res6=1;
		$alert['PLN_exp']= $res6;

		$alert_sql ="SELECT count(*) from #__cam_vendor_professional_license  WHERE vendor_id=".$user->id;
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
		$alert_sql ="SELECT count(*) from #__cam_vendor_liability_insurence   WHERE GLI_end_date  >= '".$today."' AND vendor_id=".$user->id; //validation to expdate of docs
		//$alert_sql = "SELECT count(*) from #__cam_vendor_liability_insurence WHERE GLI_end_date  >= '".$today."' AND vendor_id=".$user->id."  AND id=(SELECT MIN(id) from #__cam_vendor_liability_insurence where vendor_id=".$user->id.")";
		$db->Setquery($alert_sql);
		$res8 = $db->loadResult();
		if($res8 != 0) $res8=0; else $res8=1;
		$alert['GLI_exp']= $res8;

		//echo "<pre>"; print_r($vendor_GLI_compliance_alert);
		$vendor_GLI_compliance_alert = $alert;
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
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/assets/css/style.css" type="text/css" />
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/camassistant_left/images/favicon.ico"/>
<link href="/cms/templates/camassistant_left/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/system/css/modal.css" type="text/css" />
<script src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery.js" type="text/javascript" /></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/modal.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/assets/js/main.js"></script>
</head>
<body class="Body_rfp">
<p>
  <!--sof index Banner BG -->
</p>
<!--eof index Banner BG -->
<!-- sof wrapper -->
<div id="wrapper">
<!-- sof header -->
<div id="header">
		<div id="logo">
		  		<?php

		$user =& JFactory::getUser();
		if($user->user_type == 13 && $_REQUEST['view'] == 'frontpage') {
		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';
		$redirection = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';
		}

		else if($user->user_type == 11 && $_REQUEST['view'] == 'frontpage') {
		$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';
		$redirection = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';
		}

		else if($user->user_type == 12 && $_REQUEST['view'] == 'frontpage') {
		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';
		$redirection = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';
		}
		else {
		$link = 'index.php';
		}
		?>
        <?php if($redirection)
		header( "Location: $redirection" ) ;

?>			<a href="<?php echo $link;?>">
				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/camassistant.gif" alt="CAMassistant.com - we do your bidding" />
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
			<jdoc:include type="modules" name="menu" />
		</div>
		<div id="fontsize_white">
				<jdoc:include type="modules" name="size_left" />
		</div>
	<div class="clear"></div>
</div>
<!-- eof Navigation -->
<!-- sof container -->
<div id="container_inner">
<!-- sof left -->
<!-- sof right -->
	<div id="vender_right1">
<jdoc:include type="modules" name="feedback" />
<!-- sof bedcrumb -->
		<!--<div id="bedcrumb">
				&nbsp;
		</div>-->
		<!--<div id="bedcrumb">
		<jdoc:include type="modules" name="breadcrumb" />
  <div class="clear"></div>
			</div>-->
		  <jdoc:include type="message" />
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
		<jdoc:include type="modules" name="footer_menu" />
	</div>
	<jdoc:include type="modules" name="footer" />
</div>
<!-- eof footer -->
<div class="clear"></div>
</div>
<!-- eof wrapper -->
</body>

</html>