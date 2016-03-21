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

$itemid   = &JRequest::getVar('Itemid');
$form	  = JRoute::_('index.php?option=com_jefaqpro&view=faq&layout=form&Itemid='.$itemid);
?>


<!-- Includes script and css styles -->

<script type="text/javascript" src="<?php echo JURI::root().'components/com_jefaqpro/assets/js/utilities.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JURI::root().'components/com_jefaqpro/assets/css/accordionview.css' ?>">

<!-- Includes script and css styles Ended -->

<div class="componentheading">
	<?php
		if($this->params->get('show_page_title', 1)) {
			echo $this->params->get('page_title');
		} else {
			echo JText::_( 'JE_FAQ_DETAILS' );
		}
	?>
</div>

<?php require_once( dirname(__FILE__) . DS . 'default_faq.php' ); ?>


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
<br style="clear : both"/>

		<!-- Pagination code start -->
			<div id="je-pagination">
				 <?php echo $this->pageNav->getListFooter(); ?>
			</div>
		<!-- Pagination code End -->

<?php if ( $this->settings->footer_text == '1') : ?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php endif; ?>