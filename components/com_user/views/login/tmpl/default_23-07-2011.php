<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if($_REQUEST['return']){ ?>
<p style="color:red;">Your session has expired. Please log in again.</p> 
<?php } else { }?>
<?php if ($this->params->get( 'show_page_title', 1)) : ?>
<div id="dotshead_blue">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate($this->type); ?>

