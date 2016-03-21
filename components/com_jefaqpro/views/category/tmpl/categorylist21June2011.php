<?php
/**
 * jeFAQ pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Get the variables from the url
$itemid   = &JRequest::getVar('Itemid');
$catid    = &JRequest::getVar('catid');
$task	  = &JRequest::getVar('task');

// For reference links.
$link	  = JRoute::_('index.php?option=com_jefaqpro&view=category&Itemid='.$itemid);
$form	  = JRoute::_('index.php?option=com_jefaqpro&view=faq&layout=form&catid='.$catid.'&Itemid='.$itemid);

?>

<!-- Includes script and css styles -->
<script type="text/javascript" src="<?php echo JURI::root().'components/com_jefaqpro/assets/js/utilities.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::root().'components/com_jefaqpro/assets/css/accordionview.css' ?>">
<!-- Includes script and css styles Ended -->

<!-- Area for component heading -->
<div class="componentheading">
	<?php
		if($this->params->get('show_page_title', 1)) {
			//echo $this->params->get('page_title');
		} else {
			//echo JText::_( 'JE_FAQ_DETAILS' );
		}
	?>
</div>
<!-- Component heading ended -->

<!-- Content Area -->
<div id="contentarea" style="text-align : justify;">

	<!-- Header Area -->
	<?php
	if ( count($this->items) > 0) {

		if ( $this->items['0']->catid == '0' ) {
			$this->category->category = JText::_( 'JE_UNCATEGORISED' );
		}
		// defalut_categories.php file included here.
		require_once( dirname(__FILE__) . DS . 'default_categorylist.php' );
	?>

	<?php } else {
		echo '<div id="je-nofaqs" style="text-align : center;">'.JText::_('JE_DATAS').'</div>';
	}?>

		<!-- Back Button -->
		<?php if ( $task == 'lists' ) { ?>
			<div id="je-backbutton">
				<a id="je-button" href="<?php echo $link; ?>" title="<?php echo JText::_('JE_BACK'); ?>" > <strong> <?php echo JText::_('JE_BACK'); ?> </strong> </a>
			</div>
		<?php } ?>
		<!-- Ended Back button -->

		<!-- New Button -->
		<?php
		if ( $this->settings->show_reguser == '1' ) {
			if ( $this->settings->show_form == '1' && $this->user->get('id') >0 ) {
		?>
				<div id="je-newbutton">
					<div style="text-align : right">
						<a id="je-addbutton" href="<?php echo $form; ?>" title="<?php echo JText::_('JE_ADDNEW'); ?>" > <strong> <?php echo JText::_('JE_ADDNEW'); ?> </strong> </a>
					</div>
				</div>
		<?php
			}
		} else {

			if ( $this->settings->show_form == '1' ) {
		?>
				<div id="je-newbutton">
					<div style="text-align : right">
						<a id="je-addbutton" href="<?php echo $form; ?>" title="<?php echo JText::_('JE_ADDNEW'); ?>" > <strong> <?php echo JText::_('JE_ADDNEW'); ?> </strong> </a>
					</div>
				</div>
		<?php
			}
		}
		?>
		<!-- Ended New button -->

</div>
<!-- Content area ended -->

<br style="clear : both"/>

<?php if ( $this->settings->footer_text == '1') : ?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php endif; ?>