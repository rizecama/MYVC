<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if($_REQUEST['return']){ ?>
<!-- /* anil 23-07-2011*/ commented due to survey login this message is displayed even though we are login for the first time -->
<!--<p style="color:red;">Your session has expired. Please log in again.</p> -->
<?php } else { }?>


<?php if ($this->params->get( 'show_page_title', 1)) : ?>
<div id="dotshead_blue" style="text-align:center; color:#808080; padding-top:23px; font-size:20px;">
	<?php echo "Log In"; //$this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate($this->type); ?>

