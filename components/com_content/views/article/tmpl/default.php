<link rel="stylesheet" href="<? echo juri::base(); ?>components/com_jefaqpro/assets/css/style.css" type="text/css" />
<link rel="stylesheet" href="<? echo juri::base(); ?>templates/camassitant/css/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant/css/style_popup.css" type="text/css" />
   <?php // no direct access
defined('_JEXEC') or die('Restricted access');

$canEdit	= ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
?>
<?php if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title) : ?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
<?php endif; ?>
<?php if ($canEdit || $this->params->get('show_title') || $this->params->get('show_pdf_icon') || $this->params->get('show_print_icon') || $this->params->get('show_email_icon')) : ?>
<table class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" style="width:100%">
<tr>
	<?php if ($this->params->get('show_title')) : ?>
		
	<?php endif; ?>
	<?php if (!$this->print) : ?>
		<?php if ($this->params->get('show_pdf_icon')) : ?>
		<td align="right" width="450" class="buttonheading">
		<?php echo JHTML::_('icon.pdf',  $this->article, $this->params, $this->access); ?>
		</td>
		<?php endif; ?>
		
		

		<?php if ($this->params->get('show_email_icon')) : ?>
		<td align="right" width="40" class="buttonheading">
		<?php echo JHTML::_('icon.email',  $this->article, $this->params, $this->access); ?>
		</td>
		<?php endif; ?>
		<?php if ($canEdit) : ?>
		<td align="right" width="40" class="buttonheading">
			<?php echo JHTML::_('icon.edit', $this->article, $this->params, $this->access); ?>
		</td>
		<?php endif; ?>
	<?php else : ?>
		<td align="right" width="40" class="buttonheading">
		<?php echo JHTML::_('icon.print_screen',  $this->article, $this->params, $this->access); ?>
		</td>
	<?php endif; ?>
</tr>
</table>
<?php endif; ?>

<?php  if (!$this->params->get('show_intro')) :
	echo $this->article->event->afterDisplayTitle;
endif; ?>
<?php if ($this->params->get('show_title')) : ?>
<div id="i_bar_basicinfo">
<div id="i_bar_txt" style="text-align:center; font-size:14px;">
<span style="padding-left:0px; color:#fff;"><strong><?php echo strtoupper($this->escape($this->article->title)); ?></strong></span></div>
</div>
<?php endif; ?>
<?php echo $this->article->event->beforeDisplayContent; ?>
<table class="contentpaneopencontent<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" style="color: #636363; font-family: Arial; font-size: 13px;">
<?php if (($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid)) : ?>
<tr>
	<td>
		<?php if ($this->params->get('show_section') && $this->article->sectionid && isset($this->article->section)) : ?>
		<span>
			<?php if ($this->params->get('link_section')) : ?>
				<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->article->sectionid)).'">'; ?>
			<?php endif; ?>
			<?php echo $this->escape($this->article->section); ?>
			<?php if ($this->params->get('link_section')) : ?>
				<?php echo '</a>'; ?>
			<?php endif; ?>
				<?php if ($this->params->get('show_category')) : ?>
				<?php echo ' - '; ?>
			<?php endif; ?>
		</span>
		<?php endif; ?>
		<?php if ($this->params->get('show_category') && $this->article->catid) : ?>
		<span>
			<?php if ($this->params->get('link_category')) : ?>
				<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->article->catslug, $this->article->sectionid)).'">'; ?>
			<?php endif; ?>
			<?php echo $this->escape($this->article->category); ?>
			<?php if ($this->params->get('link_category')) : ?>
				<?php echo '</a>'; ?>
			<?php endif; ?>
		</span>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>
<?php if (($this->params->get('show_author')) && ($this->article->author != "")) : ?>
<tr>
	<td valign="top">
		<span class="small">
			<?php JText::printf( 'Written by', ($this->escape($this->article->created_by_alias) ? $this->escape($this->article->created_by_alias) : $this->escape($this->article->author)) ); ?>
		</span>
		&nbsp;&nbsp;
	</td>
</tr>
<?php endif; ?>

<?php if ($this->params->get('show_create_date')) : ?>
<tr>
	<td valign="top" class="createdate">
		<?php echo JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC2')) ?>
	</td>
</tr>
<?php endif; ?>

<?php if ($this->params->get('show_url') && $this->article->urls) : ?>
<tr>
	<td valign="top">
		<a href="http://<?php echo $this->article->urls ; ?>" target="_blank">
			<?php echo $this->escape($this->article->urls); ?></a>
	</td>
</tr>
<?php endif; ?>

<tr>
<td valign="top">
<?php if (isset ($this->article->toc)) : ?>
	<?php echo $this->article->toc; ?>
<?php endif; ?>
<?php echo $this->article->text; ?>
</td>
</tr>

<?php if ( intval($this->article->modified) !=0 && $this->params->get('show_modify_date')) : ?>
<tr>
	<td class="modifydate">
		<?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2'))); ?>
	</td>
</tr>
<?php endif; ?>
</table>
<span class="article_separator">&nbsp;</span>
<?php echo $this->article->event->afterDisplayContent; ?>


<div align="center" class="print_separate">
		<?php 
		if($_REQUEST['id']){ ?>
		<?php if ( $this->params->get( 'show_print_icon' )) : ?>
		<a rel="nofollow" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print" href="index.php?view=article&amp;id=<?php echo $_REQUEST['id']; ?>%3Aprivacy-policy&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=&amp;option=com_content&amp;Itemid=113" class="printicons"></a>
		<?php endif; ?>
		<?php } else { ?>
		<?php if ( $this->params->get( 'show_print_icon' )) : ?>
		<?php echo JHTML::_('icon.print_popup',  $this->article, $this->params, $this->access); ?>
		<?php endif; ?>
		<?php } ?>

</div>