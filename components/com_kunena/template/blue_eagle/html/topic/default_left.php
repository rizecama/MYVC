<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Topic
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>
<?php /*?><div class="kmsg-header kmsg-header-left">
	<h2 style="border-top:1px solid rgba(0, 0, 0, 0.2);">
		<span class="kmsgtitle<?php echo $this->escape($this->msgsuffix) ?> kmsg-title-left" style="background:none; padding-left:0px;">
			<?php echo $this->displayMessageField('subject') ?>
		</span>
		<span class="kmsgdate kmsgdate-left" title="<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat_hover') ?>">
			<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat') ?>
		</span>
		<span class="kmsg-id-left">
			<a id="<?php echo intval($this->message->id) ?>"></a>
			<?php echo $this->numLink ?>
		</span>
		<span class="kmsg-id-left">
			<a href="index.php?option=com_kunena&view=category&catid=2&Itemid=233" class="newtopic" style="color:#636363 !important;">MAIN FORUM</a>
		</span>
	</h2>
</div><?php */?>

<table class="<?php echo $this->class ?>_myvckunena">
	<tbody>
		<tr>
			<td rowspan="2" class="kprofile-left" style="border-right:1.5px solid rgba(0, 0, 0, 0.1); background-color:#fff; width:17%; min-width:158px;">
				<?php $this->displayMessageProfile('vertical') ?>
			</td>
			<td class="kmessage-left" style="background-color:#fff;">
			<?php if($_REQUEST['id']){
		$db = & JFactory::getDBO();
		$getcname = "SELECT subject FROM `#__kunena_topics`  where id=".$_REQUEST['id']." ";
		$db->setQuery($getcname);
		$idname = $db->loadResult();
				}
				?>
				<?php /*?><span style="background:none; padding-left:0px; color:#7AB800" class="kmsgtitle kmsg-title-left"><?php echo $idname ; ?>
		</span><br /><?php */?>
		
			<span class="kmsgdate kmsgdate-left" style="padding-left:20px; font-weight:bold;" title="<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat_hover') ?>">
			<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat') ?>
		</span>
				<span style="padding-left:20px;"><?php $this->displayMessageContents() ?></span>
			</td>
		</tr>
		<tr style="background:#fff;">
			<td class="kbuttonbar-left">
				<?php $this->displayMessageActions() ?>
			</td>
		</tr>
	</tbody>
	<p style="height:10px; border:none; background:#fff;"></p>
</table>

<!-- Begin: Message Module Position -->
<?php $this->displayModulePosition('kunena_msg_' . $this->mmm) ?>
<!-- Finish: Message Module Position -->
