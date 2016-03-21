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







defined( '_JEXEC' ) or die( 'Restricted access' );







?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >







<head>







<jdoc:include type="head" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/menu.css" type="text/css" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/stylesheet.css" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/style.css" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/uispinner.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery-latest.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/core.js" type="text/css" />







</head>







<body>







<div id="cam_bg_index">







<jdoc:include type="modules" name="bg" />







<div class="clear"></div>







</div>







<div id="wrapper">







<!-- sof header -->







  <div id="header">







  <div id="logo">



		<?php 

		$user =& JFactory::getUser();		

		if($user->user_type == 13) {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';

		}

		else if($user->user_type == 11) {

		$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';		

		}

		else if($user->user_type == 12) {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';			

		}

		else {

		$link = 'index.php';

		}

		?>



			<a href="<?php echo $link;?>">

				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/camassistant.gif" alt="CAMassistant.com - we do your bidding" />

			</a>



		



		</div>















 <!-- sof signin -->







    <div id="signin_pannel">







     







       <?php if(($_REQUEST['task'] == 'vendorsignup_p1') || ($_REQUEST['task'] == 'vendorsignup_p2') || ($_REQUEST['task'] == 'vendorsignup_p3')) {/*echo 'in if'; echo $_REQUEST['task']; exit; */?>   



	   			<jdoc:include type="modules" name="nologin" /> 



	   <?php } else { /*echo 'in else if'; exit;*/ ?> 



	   			<jdoc:include type="modules" name="login" /> 



	   <?php } ?>







    







    </div>







    <!-- eof signin -->







    







  </div>







<!-- eof header -->







  







  







  <!-- sof Navigation -->







  <div id="navbar">







    <div id="navigation">







<jdoc:include type="modules" name="menu" />







</div>







<div id="fontsize"><jdoc:include type="modules" name="size_inner" /></div>







<div class="clear"></div>







  </div>







<!-- eof Navigation -->















<!-- sof Banner -->







<jdoc:include type="modules" name="banner" />







<div class="clear"></div>























<!-- sof container -->







<div style="min-height:300px; padding-top:20px;">















<jdoc:include type="message" />







<jdoc:include type="component" />







</div>







<div class="clear"></div>







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















</div>







<script type="text/javascript">







var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");







document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));







</script>







<script type="text/javascript">







try {







var pageTracker = _gat._getTracker("UA-3689532-2");







pageTracker._trackPageview();







} catch(err) {}</script>







<!-- eof wrapper -->







</body>







</html>