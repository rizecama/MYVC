<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm">

	<!-- Global Settings Start-->
	<div id="je-mainglobal">

		<!-- Start General settings here - (general.php) -->
		<div id="je-generalsettings">
			<?php require_once( dirname(__FILE__) . DS . 'view.php' ); ?>
		</div>
		<!-- General settings end  -->

		<!-- Start Email settings here - (email.php) -->
		<div id="je-emailsettings">
			<?php
				require_once( dirname(__FILE__) . DS . 'themes.php' );
				require_once( dirname(__FILE__) . DS . 'formsettings.php' );
			?>
		</div>
		<!-- Email settings end  -->

		<div class="clr"></div>

		<!-- Start faq's settings here - (view.php) -->
		<div id="je-generalsettings">
			<?php require_once( dirname(__FILE__) . DS . 'general.php' ); ?>
		</div>
		<!-- faq's settings end  -->

		<!-- Start faq's settings here - (view.php) -->
		<div id="je-emailsettings">
			<?php
				require_once( dirname(__FILE__) . DS . 'email.php' );
			?>
		</div>
		<!-- faq's settings end  -->

	</div>
	<!-- Global Settings End -->

	<input type="hidden" name="option" value="com_jefaqpro" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="id" value="<?php echo $this->items->id; ?>" />
	<input type="hidden" name="controller" id="controller" value="globalsettings" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>

</form>

<script type="text/javascript">
	window.onload = callOnloadscript;

	function callOnloadscript()
	{
		imageResize();
		selectTheme('<?php echo $this->items->themes; ?>');
	}
</script>

<div class="clr"></div>

<?
	$com_name = urlencode("JE FAQ Pro") ;
	$dom =  urlencode($_SERVER['HTTP_HOST']) ;
	$querystr = "http://www.jextn.com/latestversion.php?name=$com_name&dom=$dom";

	if(function_exists('file_get_contents')) {
		$data = @file_get_contents($querystr);
	} else {
		$ch = @curl_init($querystr);
		@curl_setopt($ch, CURLOPT_HEADER, 0);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = @curl_exec($ch);
		@curl_close($ch);
	}
?>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>