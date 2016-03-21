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
</head>
<body>
<div id="banner_bg_index">
<jdoc:include type="modules" name="bg" />
<div class="clear"></div>
</div>
<div id="wrapper">
<!-- sof header -->
  <div id="header">
  <div id="logo"><jdoc:include type="modules" name="logo" /></div>

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
<jdoc:include type="modules" name="banner" />
<div class="clear"></div>


<!-- sof container -->
<div id="container">

<div id="container_left">
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