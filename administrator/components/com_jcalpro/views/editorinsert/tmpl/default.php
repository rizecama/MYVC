<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla!
 (com_extcal_0_9_2_RC4.zip from mamboguru.com).
 Extcal (http://sourceforge.net/projects/extcal) was renamed
 and adapted to become a Mambo/Joomla! component by
 Matthew Friedman, and further modified by David McKinnis
 (mamboguru.com) to repair some security holes.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************

 $Id: default.php 712 2011-03-08 17:45:00Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

global $lang_date_format;

$iconUrl = JURI::root() . 'components/com_jcalpro/images/icon_48x48.png';

?>

<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">
<div class="header icon-48-generic" style="display: inline"><?php echo JText::_( 'PLG_JCLINSERT_WINDOW_TITLE' ); ?>
</div>
<div style="display: inline; float: right">

  <div class="button2-left"><a href="#" class="blank"
  	onclick="JavaScript: jclEditorDoInsert('content');return false;"><?php echo JText::_('PLG_JCLINSERT_BUTTON_INSERT_CONTENT')?>
  </a></div>
  <div class="button2-left"><a href="#" class="blank"
  	onclick="JavaScript: jclEditorDoInsert('link');return false;"><?php echo JText::_('PLG_JCLINSERT_BUTTON_INSERT_LINK')?>
  </a></div>
  <div style="clear: both;display: inline; float: right; padding-top: 10px;">
    <fieldset class="adminform">
      <legend><?php echo JText::_('PLG_JCLINSERT_ITEMID_PARAM_INPUT'); ?></legend>
      <table class="admintable" cellspacing="1">
        <tbody>
          <tr>
            <td class="inputbox" >
              <input type="text" value="<?php echo $this->defaultItemid; ?>" id="jcl_insert_options_link_itemid" name="jcl_insert_options_link_itemid" size="10" maxlength="10" />
            </td>
          </tr>
        </tbody>
      </table>
    </fieldset>
  </div>
</div>
<div style="display: inline; float: right">
<fieldset class="adminform"><legend><?php echo JText::_('PLG_JCLINSERT_OPTIONS_TITLE')?></legend>

<table class="admintable" cellspacing="1">
	<tbody>
		<tr>
			<td width="185" class="key"><?php echo JText::_('PLG_JCLINSERT_OPTIONS_EVENT_TITLE')?>
			</td>
			<td><input type="radio" name="jcl_insert_options_event_title"
				id="jcl_insert_options_event_title0" value="0" <?php echo !$this->jcl_insert_options_event_title ? 'checked="checked"':'';?> class="inputbox" /> <label
				for="jcl_insert_options_event_title0"><?php echo JText::_('PLG_JCLINSERT_NO'); ?></label>
			<input type="radio" name="jcl_insert_options_event_title"
				id="jcl_insert_options_event_title1" value="1" <?php echo $this->jcl_insert_options_event_title ? 'checked="checked"':'';?>
				class="inputbox" /> <label for="jcl_insert_options_event_title1"><?php echo JText::_('PLG_JCLINSERT_YES'); ?></label>
			</td>
		</tr>
		<tr>
      <td width="185" class="key"><?php echo JText::_('PLG_JCLINSERT_BUTTON_INSERT_START_DATE')?>
      </td>
      <td><input type="radio" name="jcl_insert_options_event_start_date"
        id="jcl_insert_options_event_start_date0" value="0"
        checked="checked" class="inputbox" /> <label
        for="jcl_insert_options_event_start_date0"><?php echo JText::_('PLG_JCLINSERT_NO'); ?></label>
      <input type="radio" name="jcl_insert_options_event_start_date"
        id="jcl_insert_options_event_start_date1" value="1"
        class="inputbox" /> <label
        for="jcl_insert_options_event_start_date1"><?php echo JText::_('PLG_JCLINSERT_YES'); ?></label>
      </td>
    </tr>
    <tr>
      <td width="185" class="key"><?php echo JText::_('PLG_JCLINSERT_BUTTON_INSERT_END_DATE')?>
      </td>
      <td><input type="radio" name="jcl_insert_options_event_end_date"
        id="jcl_insert_options_event_end_date0" value="0"
        checked="checked" class="inputbox" /> <label
        for="jcl_insert_options_event_end_date0"><?php echo JText::_('PLG_JCLINSERT_NO'); ?></label>
      <input type="radio" name="jcl_insert_options_event_end_date"
        id="jcl_insert_options_event_end_date1" value="1"
        class="inputbox" /> <label
        for="jcl_insert_options_event_end_date1"><?php echo JText::_('PLG_JCLINSERT_YES'); ?></label>
      </td>
    </tr>
    <tr>
      <td width="185" class="key"><?php echo JText::_('PLG_JCLINSERT_OPTIONS_EVENT_DESCRIPTION')?>
      </td>
      <td><input type="radio" name="jcl_insert_options_event_description"
        id="jcl_insert_options_event_description0" value="0"
        checked="checked" class="inputbox" /> <label
        for="jcl_insert_options_event_description0"><?php echo JText::_('PLG_JCLINSERT_NO'); ?></label>
      <input type="radio" name="jcl_insert_options_event_description"
        id="jcl_insert_options_event_description1" value="1"
        class="inputbox" /> <label
        for="jcl_insert_options_event_description1"><?php echo JText::_('PLG_JCLINSERT_YES'); ?></label>
      </td>
    </tr>
	</tbody>
</table>
</fieldset>
</div>
<div class="clr"></div>
</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>
&nbsp;
<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">
<form action="index.php" method="post" name="adminForm">

<table class="adminheading">
	<tr>
		<td>Calendar:&nbsp;</td>
		<td><?php echo $this->lists['calendars'];?></td>
		<td>&nbsp;Category:&nbsp;</td>
		<td><?php echo $this->lists['categories'];?></td>
		<td>&nbsp;Range:&nbsp;</td>
		<td><?php echo $this->lists['date_range'];?></td>
		<td>&nbsp;Show:&nbsp;</td>
		<td><?php echo $this->lists['month_to_show'];?></td>
		<td><?php echo $this->lists['year_to_show'];?></td>
		<td>&nbsp;Recur. events:&nbsp;</td>
		<td><?php echo $this->lists['show_children'];?></td>
		<td>&nbsp;Filter:&nbsp;</td>
		<td><input type="text" name="search"
			value="<?php echo htmlspecialchars(stripslashes($this->search));?>" class="inputbox"
			onChange="document.adminForm.submit();" /></td>
	</tr>
</table>

<table class="adminlist">
	<tr>
		<th width="20">#</th>
		<th width="20" class="title"><input type="checkbox" name="toggle"
			value="" onclick="checkAll(<?php echo count($this->rows); ?>);" /></th>
		<th align="center" class="title">Id</th>
		<th class="title"><?php echo JHTML::_('grid.sort',   'Title', 'order_by_title', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Calendar', 'order_by_calendar', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Category', 'order_by_category', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Start time', 'order_by_start_time', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'End time', 'order_by_end_time', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Kind', 'order_by_kind', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Owner', 'order_by_owner', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Privacy', 'order_by_privacy', @$this->lists['order_dir'], @$this->lists['order'] ); ?></th>
		<th align="center" class="title">Published</th>
		<th align="center" class="title">Approved</th>
	</tr>
	<?php
	$k = 0;
	for ( $i = 0, $n = count ( $this->rows ); $i < $n; $i++ )
	{
	  $row = $this->rows[$i];

	  $link   = '#';

	  $row->id = $row->extid;

	  $img  = $row->published ? 'tick.png' : 'publish_x.png';
	  $task   = $row->published ? 'unpublish' : 'publish';
	  $alt  = $row->published ? 'Published' : 'Unpublished';
	  $app_img  = $row->approved ? 'tick.png' : 'publish_x.png';
	  $app_task   = $row->approved ? 'notapprove' : 'approve';
	  $app_alt  = $row->approved ? 'Approved' : 'Not Approved';
	  $privateMsgs = array( JCL_EVENT_PUBLIC => 'Public', JCL_EVENT_PRIVATE => 'Private', JCL_EVENT_PRIVATE_READ_ONLY => 'Read only');
	  $privacy  = $privateMsgs[$row->private];
	  //$checked  = mosCommonHTML::CheckedOutProcessing( $row, $i );
	  $checked     = JHTML::_('grid.checkedout',   $row, $i );

	  $kinds = array(
    'static' => 'Static',
    'repeat_parent' => 'Repeat (parent)',
    'repeat_child' => 'Repeat (child)',
    'repeat_detached' => 'Repeat (detached)');
	  $cannotModifyChild = " (repeat event : cannot mass modify non detached events. Please edit parent event directly)";
	  $kind = '';
	  switch ($row->rec_type_select) {
	    case JCL_REC_TYPE_NONE :
	      $kind = 'static';
	      break;
	    case JCL_REC_TYPE_DAILY:
	    case JCL_REC_TYPE_WEEKLY:
	    case JCL_REC_TYPE_MONTHLY:
	    case JCL_REC_TYPE_YEARLY:
	      if (empty( $row->rec_id)) {
	        $kind = 'repeat_parent';
	      } else if ($row->detached_from_rec) {
	        $kind = 'repeat_detached';
	      } else {
	        $kind = 'repeat_child';
	      }
	      break;
	  }

	  // calculate calendar name
	  $calendarName = jclGetCalendarName( $row->cal_id);
	  // calculate owner name
	  $owner = jclGetEventOwner( $row->owner_id);

	  $date_mask = $lang_date_format['mini_date'];
	  $startDateString = jcUTCDateToFormat( $row->start_date, $date_mask);
	  // add time, except for all day events
	  if (!jclIsAllDay( $row->end_date)) {
	    $hour = jcUTCDateToFormat( $row->start_date, '%H');
	    $minute = jcUTCDateToFormat( $row->start_date, '%M');
	    $startDateString .= ' - ' . jcHourToDisplayString( $hour, $minute);
	  }
	  switch ($row->end_date) {
	    case JCL_ALL_DAY_EVENT_END_DATE:
	    case JCL_ALL_DAY_EVENT_END_DATE_LEGACY:
	      $startDate = $startDateString;
	      $endDate = 'All day';
	      break;
	    case JCL_EVENT_NO_END_DATE:
	      $startDate = $startDateString;
	      $endDate = '-';
	      break;
	    default:
	      $startDate = $startDateString;
	      $endDate = jcUTCDateToFormat( $row->end_date, $date_mask);
	      // add time, except for all day events
	      $hour = jcUTCDateToFormat( $row->end_date, '%H');
	      $minute = jcUTCDateToFormat( $row->end_date, '%M');
	      $endDate .= ' - ' . jcHourToDisplayString( $hour, $minute);
	      break;
	  }

	  // calculate event data, for storage in the rel attribute
	  // so that it's available from javascript
	  // warning : need to remove #13 chars and replace #10 by \n
	  // so that javascript is not confused
	  $jsTitle = jclCleanEndOfLines( $this->escape( $row->title));
	  $jsDesc = jclCleanEndOfLines( $this->escape( $row->description));
	  $rel = '{title:\''.$jsTitle.'\',description:\''.$jsDesc.'\'';
	  $rel .= ',startDate:\'' . JText::_('PLG_JCLINSERT_BUTTON_INSERT_START_TEXT') .' '. $startDate . '\',endDate:\''  . JText::_('PLG_JCLINSERT_BUTTON_INSERT_END_TEXT') . ' '.$endDate . '\'';
	  $rel .= '}';

	  // calculate tooltip
	  $tooltip = $this->escape( $row->title) . '::' . $this->escape( $row->description);

	  ?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagenav->getRowOffset( $i ); ?></td>
		<td class="check"><?php echo $checked; ?></td>
		<td align="center"><?php echo $row->extid; ?></td>
		<td><a id="eventData_<?php echo $row->extid;?>"
			class="hasTip eventLinkInsertLink"
			title="<?php echo $tooltip; ?>" rel="<?php echo $rel; ?>"
			href="javascript:"> <?php echo $row->title; ?></a></td>
		<td align="center"><?php echo $calendarName; ?></td>
		<td align="center"><?php echo $row->categoryName; ?></td>
		<td align="center"><?php echo $startDate; ?></td>
		<td align="center"><?php echo $endDate;?></td>
		<td align="center"><?php echo $kinds[$kind]; ?></td>
		<td align="center"><?php echo $owner; ?></td>
		<td align="center"><?php echo $privacy;?></td>
		<td align="center"><img src="<?php echo JURI::root() . 'administrator/'; ?>images/<?php echo $img;?>" width="12"
			height="12" border="0" title="<?php echo $alt; ?>" /></td>
		<td align="center"><img src="<?php echo JURI::root() . 'administrator/'; ?>images/<?php echo $app_img;?>" width="12"
			height="12" border="0"
			title="<?php echo $alt . $cannotModifyChild; ?>" /></td>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
</table>

	<?php echo $this->pagenav->getListFooter(); ?> <input type="hidden"
	name="option" value="<?php echo $this->option; ?>" /> <input
	type="hidden" name="task" value="editorinsert" /> <input type="hidden"
	name="tmpl" value="component" /> <input type="hidden" name="boxchecked"
	value="0" /> <input type="hidden" name="hidemainmenu" value="0"> <input
	type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir"
	value="<?php echo $this->lists['order_dir']; ?>" /></form>
<div class="clr"></div>
</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>
