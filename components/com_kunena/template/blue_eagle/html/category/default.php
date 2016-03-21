<script type="text/javascript">
function geterrorpopup(){
alert("Please choose your membership to SUBSCRIBE today to join the discussion.");
//document.location.href = 'index.php?option=com_camassistant&controller=vendors&task=subscriptions&Itemid=213';
}
</script>
<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Category
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>

<?php $this->displayCategories () ?>
<?php if ($this->category->headerdesc) : ?>
<?php /*?><div class="kblock">
	<div class="kheader">
		<span class="ktoggler"><a class="ktoggler close" title="<?php echo JText::_('COM_KUNENA_TOGGLER_COLLAPSE') ?>" rel="frontstats_tbody"></a></span>
		<h2><span><?php echo JText::_('COM_KUNENA_FORUM_HEADER'); ?></span></h2>
	</div>
	<div class="kcontainer" id="frontstats_tbody">
		<div class="kbody">
			<div class="kfheadercontentsateesh">
				<?php echo KunenaHtmlParser::parseBBCode ( $this->category->headerdesc ); ?>
			</div>
		</div>
	</div>
</div><?php */?>
<?php endif; ?>

<?php if (!$this->category->isSection()) : ?>
<?php
$user = JFactory::getUser();
$type = JRequest::getVar('type','');
if($type)
$external = "&type=".$type."";
else
$external = '';
//echo "<pre>"; print_r($user);
if($user->user_type == '11'){
$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';
}
else{
$link = "index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125"; 
}
?>
<table>
	<tr>
<?php //$this->displayCategoryActions() ?>
<td class="klist-actions-forum" align="right">
<?php
if($user->subscribe == 'yes' || $user->user_type == '13' || $user->user_type == '12' || $user->user_type == '16') { ?>
<a class="newtopic" href="index.php?option=com_kunena&view=topic&layout=create&catid=2<?php echo $external; ?>&Itemid=223">+ NEW TOPIC</a>
<?php } else { ?>
<a class="newtopic" href="#" onclick="geterrorpopup();">+ NEW TOPIC</a> 
<?php } ?>
<span style="margin: 5px; background: url("templates/camassistant_left/images/list-bg-news.gif") no-repeat scroll 0% center transparent;">&nbsp;</span> 
<a class="kunenadashboard" href="<?php echo $link; ?>">MY DASHBOARD</a>
<?php /*?><span style="margin: 5px; background: url("templates/camassistant_left/images/list-bg-news.gif") no-repeat scroll 0% center transparent;">&nbsp;</span> 
<a class="kunenamainforum" href="index.php?option=com_kunena&view=category&catid=2&type=<?php echo $type; ?>&Itemid=232">MAIN FORUM</a><?php */?>
</td>
</tr>
</table>

<p style="border-top:1px solid #E2E2E2; height:10px;"></p>


<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena') ?>" method="post" name="ktopicsform">
	<input type="hidden" name="view" value="topics" />
	<?php echo JHTML::_( 'form.token' ); ?>

<div class="kblock kflat">
	<div class="kheader">
		<?php if (!empty($this->topicActions)) : ?>
		<span class="kcheckbox select-toggle"><input class="kcheckall" type="checkbox" name="toggle" value="" /></span>
		<?php endif; ?>
		<h2><span><?php 
		$ex = explode(':',$this->escape($this->headerText));
		echo $ex[1];
		//echo $this->escape($this->headerText); ?></span></h2>
	</div>
	<div class="kcontainer">
		<div class="kbody" style="border:none;">
				<table class="kblocktable<?php echo $this->escape($this->category->class_sfx); ?>" id="kflattable">

					<?php if (empty ( $this->topics ) && empty ( $this->subcategories )) : ?>
					<tr class="krow2"><td class="kcol-first"><?php echo JText::_('COM_KUNENA_VIEW_NO_POSTS') ?></td></tr>

					<?php else : ?>
						<?php $this->displayRows (); ?>

					<?php  if ( !empty($this->topicActions) || !empty($this->embedded) ) : ?>
					<!-- Bulk Actions -->
					<tr class="krow1">
						<td colspan="<?php echo empty($this->topicActions) ? 5 : 6 ?>" class="kcol krowmoderation">
							<?php if (!empty($this->moreUri)) echo JHtml::_('kunenaforum.link', $this->moreUri, JText::_('COM_KUNENA_MORE'), null, null, 'follow'); ?>
							<?php if (!empty($this->topicActions)) : ?>
							<?php echo JHTML::_('select.genericlist', $this->topicActions, 'task', 'class="inputbox kchecktask" size="1"', 'value', 'text', 0, 'kchecktask'); ?>
							<?php if ($this->actionMove) :
								$options = array (JHTML::_ ( 'select.option', '0', JText::_('COM_KUNENA_BULK_CHOOSE_DESTINATION') ));
								echo JHTML::_('kunenaforum.categorylist', 'target', 0, $options, array(), 'class="inputbox fbs" size="1" disabled="disabled"', 'value', 'text', 0, 'kchecktarget');
								endif;?>
							<input type="submit" name="kcheckgo" class="kbutton" value="<?php echo JText::_('COM_KUNENA_GO') ?>" />
							<?php endif; ?>
						</td>
					</tr>
					<!-- /Bulk Actions -->
					<?php endif; ?>
					<?php endif; ?>
				</table>
		</div>
	</div>
</div>
</form>
<table class="klist-actions">
	<tr>
		<?php /*?><td class="klist-actions-goto">
			<a id="forumtop"> </a>
			<a class="kbuttongoto" href="#forumbottom" rel="nofollow"><?php echo $this->getIcon ( 'kforumbottom', JText::_('COM_KUNENA_GEN_GOTOBOTTOM') ) ?></a>
		</td><?php */?>
		
		<td class="klist-pages-all"><?php echo $this->getPagination (7); // odd number here (# - 2) ?></td>
	</tr>
</table>
<br /><br />


<?php endif; ?>
