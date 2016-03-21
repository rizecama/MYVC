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

/*if($user->user_type == '11')

{

$sql = 'SELECT status FROM #__cam_vendor_billing WHERE user_id='.$user->id;

$db->setQuery($sql);

$db->query();

$is_userid = $db->loadResult();

}
*/
// print_r($user->user_type);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<jdoc:include type="head" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/menu.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/stylesheet.css" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/camassistant_left/images/favicon.ico"/>
 <link href="/cms/templates/camassistant_left/favicon.ico" rel="shortcut icon" type="image/x-icon" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/system/css/modal.css" type="text/css" />
  <script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/modal.js"></script>


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

		

			<a href="index.php">

		

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

	<div id="vender_left">

			<?php if($_REQUEST['controller']=='rfpcenter') { ?>

			<jdoc:include type="modules" name="rfpimage" />

			<?php } else if($_REQUEST['Itemid']=='112') { ?>

			<jdoc:include type="modules" name="image1" />

			<?php } else if($_REQUEST['controller']=='vendorsignup' ){ ?>

			<jdoc:include type="modules" name="billing_image" />
			
			<?php } else if($user->id) { ?>

			<jdoc:include type="modules" name="image" />

			<?php } else {?>
<jdoc:include type="modules" name="fimage" />
<?php } ?>
			<?php if($user->user_type == '11') : ?>

					<jdoc:include type="modules" name="left" style="left_menu" /> 

					<jdoc:include type="modules" name="left1" style="left_menu_yellow"" /> 

			<?php endif; ?> 

			<?php if ($user->user_type == '12') : ?> 

					<jdoc:include type="modules" name="leftmenu" style="left_menu" />  

					<jdoc:include type="modules" name="leftmenu1" style="left_menu_yellow" />  

			<?php endif; ?>

			<?php if ($user->user_type == '13') : ?>    

					<jdoc:include type="modules" name="leftfrim" style="left_frim_green" /> 

					<jdoc:include type="modules" name="leftfrim1" style="left_frim_yellow" /> 

					<jdoc:include type="modules" name="leftfrim2" style="left_frim_ash" /> 

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