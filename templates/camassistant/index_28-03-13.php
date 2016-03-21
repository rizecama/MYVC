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







?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >







<head>







<jdoc:include type="head" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/menu.css" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/stylesheet.css" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/style.css" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/js/uispinner.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/js/jquery-latest.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/js/jquery.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/js/core.js" type="text/css" />







<link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/system/css/modal.css" type="text/css" />







  <script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/modal.js"></script>



  <script type="text/JavaScript">



<!--



function MM_preloadImages() { //v3.0



  if (document.images)



    {



      preload_image = new Image(25,25); 



      preload_image.src="http://camassistant.com/cms/templates/camassistant/images/banner_index.jpg"; 



    }



}



//-->



</script>

<!-- SSL Script Below -->


<script language="javascript" type="text/javascript">
//<![CDATA[
var tl_loc0=(window.location.protocol == "https:")? "https://secure.comodo.net/trustlogo/javascript/trustlogo.js" :
"http://www.trustlogo.com/trustlogo/javascript/trustlogo.js";
document.writeln('<scr' + 'ipt language="JavaScript" src="'+tl_loc0+'" type="text\/javascript">' + '<\/scr' + 'ipt>');
//]]>
</script>



</head>







<body onload="MM_preloadImages()">







<div id="cam_bg_index">
<!--sof index Banner BG -->
<div id="banner_bg_index">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td background="<?php echo $this->baseurl ?>/templates/camassistant_inner/images/camsignup2_bg_articles.gif" style="height:38px;">&nbsp;</td>
    <td background="<?php echo $this->baseurl ?>/templates/camassistant_inner/images/camsignup2_bg_articles.gif" style="height:38px;">&nbsp;</td>
  </tr>
</table>

<div class="clear"></div>
</div>
<!--eof index Banner BG -->






<jdoc:include type="modules" name="bg" />







<div class="clear"></div>







</div>







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

?>



 

			<a href="<?php echo $link;?>">

				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/camassistant.gif" alt="CAMassistant.com - we do your bidding" />

			</a>



		



		</div>















 <!-- sof signin -->







    <div id="signin_pannel">







     















        <jdoc:include type="modules" name="login" />







    </div>







    <!-- eof signin -->







    







  </div>







<!-- eof header -->







  







  







  <!-- sof Navigation -->







  <div id="navbar">







    <div id="navigation">







<jdoc:include type="modules" name="menu" />







</div>







<div id="fontsize"><jdoc:include type="modules" name="size_main" /></div>







<div class="clear"></div>







  </div>







<!-- eof Navigation -->















<!-- sof Banner -->







<jdoc:include type="modules" name="camhome" />







<div class="clear"></div>























<!-- sof container -->







<div id="container">















<div id="container_left">




<jdoc:include type="modules" name="feedback" /> 


<!--sof signup -->







<jdoc:include type="modules" name="homeleft" />







</div>







<div id="container_right">







<jdoc:include type="modules" name="homeright" />







</div>







<div class="clear"></div>







</div>







<div>







<jdoc:include type="message" />







<jdoc:include type="component" />







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