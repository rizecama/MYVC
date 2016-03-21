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

<?php
//Company ID Check

$compid = 0;
$user = & JFactory::getUser(); 
$uid = $user->get('id');

//Check if User ID is saved and up to date
if(!isset($_COOKIE['tpl_usr']) || $_COOKIE['tpl_usr'] != $uid){
$db = JFactory::getDBO();

//Look up Company ID
$usr = "SELECT comp_id FROM `jos_cam_customer_companyinfo` WHERE cust_id=".$uid;
$db->Setquery($usr);
$compid = $db->loadResult();

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
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_inner/css/company/company'.$compid.'.css" type="text/css" />';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

<head>

<jdoc:include type="head" />

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="media/system/css/modal.css" type="text/css">

<link rel="stylesheet" href="plugins/system/rokbox/themes/light/rokbox-style.css" type="text/css">

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/menu.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/stylesheet.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/css/style.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/uispinner.js" type="text/css" />

<?php echo $company_css; ?>

<script src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery-latest.js" type="text/javascript"></script>

<script src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/jquery.js" type="text/javascript" /></script>

<script type="text/javascript" src="media/system/js/mootools.js"></script>

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/core.js" type="text/css" />

<script type="text/javascript" src="plugins/system/rokbox/rokbox.js"></script>

<script type="text/javascript" src="plugins/system/rokbox/themes/light/rokbox-config.js"></script>

<script type="text/javascript" src="media/system/js/modal.js"></script>

<script type="text/javascript">

var rokboxPath = 'plugins/system/rokbox/';



		window.addEvent('domready', function() {



			SqueezeBox.initialize({});



			$$('a.modal').each(function(el) {

				el.addEvent('click', function(e) {

					new Event(e).stop();

					SqueezeBox.fromElement(el);

				});

			});

		});

  </script>







<!-- SLL Below -->

<script language="javascript" type="text/javascript">

//<![CDATA[

var tl_loc0=(window.location.protocol == "https:")? "https://secure.comodo.net/trustlogo/javascript/trustlogo.js" :

"http://www.trustlogo.com/trustlogo/javascript/trustlogo.js";

document.writeln('<scr' + 'ipt language="JavaScript" src="'+tl_loc0+'" type="text\/javascript">' + '<\/scr' + 'ipt>');

//]]>

</script>

<!--Start of Zopim Live Chat Script-->



<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1RqQOqVdj61nnN81694Osoej0wUVYcKZ';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>



<!--End of Zopim Live Chat Script-->
<script type='text/javascript' src="<?php echo $this->baseurl ?>/templates/camassistant_inner/js/main.js"></script>
</head>

<body class="Body_rfp cid<?php echo $compid; ?>">

<div id="cam_bg_index">

<!--sof index Banner BG -->

<div id="banner_bg_index">

<table width="100%" cellpadding="0" cellspacing="0">

  <tr>

    <td style="height:38px;">&nbsp;</td>

    <td style="height:38px;">&nbsp;</td>

  </tr>

</table>

<div class="clear"></div>

</div>

<!--eof index Banner BG -->
<?php if(($_REQUEST['task'] != 'propertyowner_last')){ ?>
<jdoc:include type="modules" name="bg" />
<?php } ?>
<div class="clear"></div>

</div>

<div id="wrapper">

<!-- sof header -->

<div id="header">

  <div id="logo">
<?php
		/*if($_REQUEST['option'] == 'com_kunena'){ ?>
		<script type="text/javascript">
		jQuery(function(){
		jQuery('#system-message').addClass('removekunenareply');
		});
		</script>
		<? }*/
		
		

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
		else if($user->user_type == 16) {

		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';

		}

		else {

		$link = 'index.php';

		}

		?>

		<a href="<?php echo $link;?>">

				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/myvendorcenter.gif" alt="CAMassistant.com - we do your bidding" />



			</a>

		</div>

    <div id="signin_pannel">

       <?php if(($_REQUEST['task'] == 'vendorsignup_p1') || ($_REQUEST['task'] == 'vendorsignup_p2') || ($_REQUEST['task'] == 'vendorsignup_p3') || ($_REQUEST['view'] == 'propertymanager')) {/*echo 'in if'; echo $_REQUEST['task']; exit; */?>

	   			<jdoc:include type="modules" name="nologin" />

	   <?php } 
	   else { /*echo 'in else if'; exit;*/ 
				if($user->id){
	   			?><jdoc:include type="modules" name="login" />
				<?php } ?>

	   <?php } ?>

     </div>

  </div>

  <div id="navbar">

    <div id="navigation">

			<?php if($user->id) { ?>
			<jdoc:include type="modules" name="menu_logged" />
			<?php } else { ?>
			<jdoc:include type="modules" name="menu" />
			<?php } ?>

</div>

<div id="fontsize"><jdoc:include type="modules" name="size_inner" /></div>

<div class="clear"></div>

 </div>

<!-- eof Navigation -->

<!-- sof Banner -->
<?php if(($_REQUEST['task'] == 'propertyowner_1' || $_REQUEST['task'] == 'activation' )){?>
<jdoc:include type="modules" name="propertyowner_banner" />
<?php } if(($_REQUEST['task'] != 'propertyowner_last' && $_REQUEST['task'] != 'propertyowner_1' && $_REQUEST['task'] != 'activation')) { ?>
<jdoc:include type="modules" name="banner" />
<?php }?>
<div class="clear"></div>

<div style="min-height:300px; padding-top:20px;">

<jdoc:include type="modules" name="feedback" />

<jdoc:include type="message" />

<?php 
$option = JRequest::getVar('option','');
$view = JRequest::getVar('view','');
$layout = JRequest::getVar('layout','');
$mode = JRequest::getVar('mode','');
$userid = JRequest::getVar('userid','');
	if($option == 'com_kunena' && $view == 'user' && $layout == 'list') {
	echo "<p align='center' style='padding-top:20px;'> You do not have permission to access this page.</p>";
	 } 
	else if($option == 'com_kunena' && $view == 'statistics' ){
	echo "<p align='center' style='padding-top:20px;'> You do not have permission to access this page.</p>";
	}
	else if($option == 'com_kunena' && $view == 'topics' && $mode == 'replies' ){
	echo "<p align='center' style='padding-top:20px;'> You do not have permission to access this page.</p>";
	}
	else if($option == 'com_kunena' && $view == 'user' && $userid != '' ){
	echo "<p align='center' style='padding-top:20px;'> You do not have permission to access this page.</p>";
	}
else { ?>
<jdoc:include type="component" />
<?php } ?>

</div>

<div class="clear"></div>

  
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

</div>

<!--

<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));



</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-44486501-1'");

pageTracker._trackPageview();

} catch(err) {}</script>-->

<script>

function GetHeight2(inDiv) {

var oDiv = inDiv;

    var sOriginalOverflow = oDiv.style.overflow;

    var sOriginalHeight = oDiv.style.height;

    oDiv.style.overflow = "visible";

    oDiv.style.height = "auto";

    var theight = oDiv.offsetHeight;

    oDiv.style.height = sOriginalHeight;

    oDiv.style.overflow = sOriginalOverflow;

    return theight;

}



jQuery(".info-accord a.readmore").click(function(e){

if(jQuery(this.parentNode).hasClass("anim"))

{

jQuery(this.parentNode).removeClass("anim");

jQuery(this.parentNode).animate({height: "222px"}, 500);

jQuery(this).text("READ MORE");

}

else

{

var theight = GetHeight2(this.parentNode) + 10;

jQuery(this.parentNode).addClass("anim");

jQuery(this).text("READ LESS");

jQuery(this.parentNode).animate({height: theight+"px"}, 500);

}

});



</script>

<!-- eof wrapper -->
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-44486501-1', 'myvendorcenter.com');

  ga('send', 'pageview');



</script>

</body>

</html>