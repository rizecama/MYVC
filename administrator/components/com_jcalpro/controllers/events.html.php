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

 $Id: events.html.php 694 2011-02-07 23:05:46Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.html.pane');
jimport('joomla.html.editor');
jimport( 'joomla.html.html');

class HTML_events
{
  function showEvents ( &$rows, &$pageNav, $search, $option, $section, &$lists )
  {
    global $CONFIG_EXT, $lang_date_format;
     
    $my= &JFactory::getUser();

    JHTML::_( 'behavior.tooltip' );
    ?>

<form action="index.php" method="post" name="adminForm">
<table class="adminheading" cellspacing="5">
	<tr>
		<td>Calendar:<br />
			<?php echo $lists['calendars'];?></td>
		<td>Category:<br />
			<?php echo $lists['categories'];?></td>
		<td>Range:<br />
			<?php echo $lists['date_range'];?></td>
		<td>Show:<br />
			<?php echo $lists['month_to_show'];?>&nbsp;<?php echo $lists['year_to_show'];?></td>
		<td>Recur. events:<br />
			<?php echo $lists['show_children'];?></td>
		<td>Published:<br />
			<?php echo $lists['published'];?></td>
		<td>Approved:<br />
			<?php echo $lists['approved'];?></td>
		<td>Filter:<br />
			<input type="text" name="search" value="<?php echo htmlspecialchars(stripslashes($search));?>"
			class="inputbox" onChange="document.adminForm.submit();" /></td>
	</tr>
</table>

<table class="adminlist">
	<tr>
		<th width="20">#</th>
		<th width="20" class="title"><input type="checkbox" name="toggle"
			value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
		<th align="center" class="title">Id</th>
		<th class="title"><?php echo JHTML::_('grid.sort',   'Title', 'order_by_title', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Calendar', 'order_by_calendar', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Category', 'order_by_category', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Start time', 'order_by_start_time', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'End time', 'order_by_end_time', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Kind', 'order_by_kind', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Owner', 'order_by_owner', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title"><?php echo JHTML::_('grid.sort',   'Privacy', 'order_by_privacy', @$lists['order_dir'], @$lists['order'] ); ?></th>
		<th align="center" class="title">Published</th>
		<th align="center" class="title">Approved</th>
	</tr>
	<?php
	$k = 0;
	for ( $i = 0, $n = count ( $rows ); $i < $n; $i++ )
	{
	  $row = $rows[$i];

	  $link 	= 'index.php?option=com_jcalpro&section=events&task=editA&hidemainmenu=1&id='. $row->extid;

	  $row->id = $row->extid;

	  $img 	= $row->published ? 'tick.png' : 'publish_x.png';
	  $task 	= $row->published ? 'unpublish' : 'publish';
	  $alt 	= $row->published ? 'Published' : 'Unpublished';
	  $app_img 	= $row->approved ? 'tick.png' : 'publish_x.png';
	  $app_task 	= $row->approved ? 'notapprove' : 'approve';
	  $app_alt 	= $row->approved ? 'Approved' : 'Not Approved';
	  $privateMsgs = array( JCL_EVENT_PUBLIC => 'Public', JCL_EVENT_PRIVATE => 'Private', JCL_EVENT_PRIVATE_READ_ONLY => 'Read only');
	  $privacy 	= $privateMsgs[$row->private];
	  //$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
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

	  ?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $pageNav->getRowOffset( $i ); ?></td>
		<td><?php echo $checked; ?></td>
		<td align="center"><?php echo $row->extid; ?></td>
		<td><?php
		if ( $row->checked_out && ( $row->checked_out != $my->id ) )
		{
		  echo $row->title;
		}
		else
		{
		  ?> <a href="<?php echo $link; ?>" title="Edit Event"> <?php echo $row->title; ?>
		</a> <?php
		}

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


		?></td>
		<td align="center"><?php echo $calendarName; ?></td>
		<td align="center"><?php echo $row->categoryName; ?></td>
		<td align="center"><?php echo $startDate; ?></td>
		<td align="center"><?php echo $endDate;?></td>
		<td align="center"><?php echo $kinds[$kind]; ?></td>
		<td align="center"><?php echo $owner; ?></td>
		<?php if ($kind != 'repeat_child' && $kind != 'repeat_parent') { ?>
		<td align="center"><?php echo $privacy;?></td>
		<td align="center"><a href="javascript: void(0);"
			onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
		<img src="images/<?php echo $img;?>" width="12" height="12" border="0"
			title="<?php echo $alt; ?>" /> </a></td>
		<td align="center"><a href="javascript: void(0);"
			onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $app_task;?>')">
		<img src="images/<?php echo $app_img;?>" width="12" height="12"
			border="0" title="<?php echo $alt . $cannotModifyChild; ?>" /> </a></td>
			<?php } else { // child_event : cannot (mass) modify, need to change parent, or fully edit the event?>
		<td align="center"><?php echo $privacy;?></td>
		<td align="center"><img src="images/<?php echo $img;?>" width="12"
			height="12" border="0" title="<?php echo $alt; ?>" /></td>
		<td align="center"><img src="images/<?php echo $app_img;?>" width="12"
			height="12" border="0"
			title="<?php echo $alt . $cannotModifyChild; ?>" /></td>
			<?php } ?>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
</table>

	<?php echo $pageNav->getListFooter(); ?> <input type="hidden"
	name="option" value="<?php echo $option; ?>" /> <input type="hidden"
	name="section" value="<?php echo $section; ?>" /> <input type="hidden"
	name="task" value="" /> <input type="hidden" name="boxchecked"
	value="0" /> <input type="hidden" name="hidemainmenu" value="0"> <input
	type="hidden" name="filter_order"
	value="<?php echo $lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir" value="<?php echo $lists['order_dir']; ?>" /></form>
	<?php
  }

  function editEvent( &$row, &$lists, $checked, $option, $section )
  {
    global $lang_add_event_view;

    // add javascript to initialize our form (don't though if editing a detached or child event,
    // as they don't have recurrence options
    if (empty($row->rec_id)) {
      $rec_types = array( 'none', 'daily', 'weekly', 'monthly', 'yearly');
      $js = 'window.addEvent( \'domready\', function() { jclShowRecOptions(\'' . $rec_types[$row->rec_type_select] . '\');';
      // add radio box auto-selection when slecting a date in calendar
      $js .= '$(\'recur_end_count\').onchange=function () {document.getElementById(\'recur_end_type_until\').checked=false;document.getElementById(\'recur_end_type_count\').checked=true;};';
      $js .= '$(\'rec_recur_until\').onchange=function () {document.getElementById(\'recur_end_type_until\').checked=true;document.getElementById(\'recur_end_type_count\').checked=false;};';
      $js .= '});';
      $document = JFactory::getDocument();
      $document->addScriptDeclaration( $js);
    }

    $tabs = & JPane::getInstance('tabs');

    JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'misc' );
    ?>
<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if ( form.title.value == "" ) {
				alert( "You must provide a title." );
			}
			else if ( form.cat.value == "0" )
			{
				alert( "You must provide a category." );
			} else {

				submitform( pressbutton );
			}
		}

		function jclGetElement(psID) {
			  if (document.all) {
			    return document.all[psID];
			  }

			  else if (document.getElementById) {
			    return document.getElementById(psID);
			  }

			  else {
			    for (iLayer = 1; iLayer < document.layers.length; iLayer++) {
			      if (document.layers[iLayer].id == psID)
			        return document.layers[iLayer];
			    }
			  }

			  return false;
			}

		// ==========================================
		// Set DIV ID to hide
		// ==========================================

		function jcl_hide_div(itm) {
		  if (!itm)
		    return;

		  itm.style.display = "none";
		}

		// ==========================================
		// Set DIV ID to show
		// ==========================================

		function jcl_show_div(itm) {
		  if (!itm)
		    return;

		  itm.style.display = "";
		}

		// shows recurrence options div, hiding all others
		function jclShowRecOptions(id) {
		  var divs = new Array('jcl_rec_none_options', 'jcl_rec_daily_options',
		      'jcl_rec_weekly_options', 'jcl_rec_monthly_options',
		      'jcl_rec_yearly_options');
		  var target = '';
		  if (id) {
		    target = 'jcl_rec_' + id + '_options';
		  }
		  for (i = 0; i < divs.length; i++) {
		    if (divs[i] == target) {
		      jcl_show_div(jclGetElement(divs[i]));
		    } else {
		      jcl_hide_div(jclGetElement(divs[i]));
		    }
		  }
		}
</script>
<form action="index.php" method="post" name="adminForm">

<table class="adminheading">
	<tr>
		<th>Event: <small> <?php echo $row->extid ? 'Edit' : 'New';?> </small>
		</th>
	</tr>
</table>

<table width="100%">
	<tr>
		<td width="60%" valign="top">
		<table width="100%" class="adminform">
			<tr>
				<th colspan="2">Event Details</th>


				<tr>
					<td width="20%" align="right">Title:</td>
					<td><input class="inputbox" type="text" name="title" size="50"
						maxlength="100" value="<?php echo $row->title; ?>" /></td>
				</tr>
				<tr>
					<td align="right">Calendar:</td>
					<td><?php echo $lists['calendars'];?></td>
				</tr>
				<tr>
					<td align="right">Category:</td>
					<td><?php echo $lists['categories'];?></td>
				</tr>
				<tr>
					<td align="right">Event Description:</td>
					<td><?php
					$editor = &JFactory::getEditor();
					echo $editor->display( 'description',  $row->description , 500, 250, '70', '10');
					?></td>
				</tr>
				<tr>
					<td rowspan='4' class='tableb' width='160'>Event Date</td>
					<td>Start Time:</td>
				</tr>
				<tr>
					<td><?php echo $lists['days'];?>&nbsp; <?php echo $lists['months'];?>&nbsp;
					<?php echo $lists['years'];?>&nbsp;&nbsp; At: <?php echo $lists['hours'];?>
					<?php echo $lists['minutes'];?></td>
				</tr>
				<tr>
					<td class='tablec'>Duration:</td>
				</tr>
				<tr>
					<td><input type='radio' name='duration_type' value='1'
					<?php echo $checked['normal'];?>>&nbsp;&nbsp;&nbsp; <input
						type='text' name='end_days' class='textinput'
						value='<?php echo $row->endDays;?>' size='3'>&nbsp;Days&nbsp;&nbsp;
					<input type='text' name='end_hours' class='textinput'
						value='<?php echo $row->endHours;?>' size='3'>&nbsp;Hours&nbsp;&nbsp;
					<input type='text' name='end_minutes' class='textinput'
						value='<?php echo $row->endMinutes;?>' size='3'>&nbsp;Minutes&nbsp;&nbsp;
					<br />
					<input type='radio' name='duration_type' value='2'
					<?php echo $checked['allday'];?>>&nbsp;&nbsp;&nbsp;All Day <br />
					<input type='radio' name='duration_type' value='0'
					<?php echo $checked['none'];?>>&nbsp;&nbsp;&nbsp;No end date (Show
					start date only)</td>
				</tr>

				<tr>
					<td width="20%" align="right">Contact info:</td>
					<td><textarea cols="50" rows="5" name="contact"><?php echo $row->contact; ?></textarea>
					</td>
				</tr>

				<tr>
					<td width="20%" align="right">Email:</td>
					<td><input class="inputbox" type="text" name="email" size="50"
						maxlength="100" value="<?php echo $row->email; ?>" /></td>
				</tr>

				<tr>
					<td width="20%" align="right">URL:</td>
					<td><input class="inputbox" type="text" name="url" size="50"
						maxlength="100" value="<?php echo $row->url; ?>" /></td>
				</tr>

				<tr>
					<td colspan="2"><?php if (/*empty($lists['previous_recur_type']) || */empty( $row->rec_id)) {
					  // parent recurring event : we can edit
					  ?>
					<table width='100%' cellpadding='4' cellspacing='0'>
						<!-- Recurrence method and options section -->
						<hr>
						<tr>
							<td class='tablec' colspan="2"><strong><?php echo $lang_add_event_view['repeat_method_label']; ?></strong></td>
						</tr>
						<tr>
							<td class='tableb' width="25%"><?php echo $lists['recTypeSelectHtml']; ?>
							<br />
							<br />
							</td>
							<td class='tableb' valign="top">
							<div id="jcl_rec_none_options"></div>
							<div id="jcl_rec_daily_options">
							<ul>
								<li><?php echo $lang_add_event_view['repeat_every']; ?>&nbsp; <input
									type="text" name="rec_daily_period"
									value="<?php echo $row->rec_daily_period; ?>" size='3'
									class='textinput' />&nbsp; <?php echo $lang_add_event_view['repeat_days']; ?>
								</li>
							</ul>
							</div>
							<div id="jcl_rec_weekly_options">
							<ul>
								<li><?php echo $lang_add_event_view['repeat_every']; ?>&nbsp; <input
									type="text" name="rec_weekly_period"
									value="<?php echo $row->rec_weekly_period; ?>" size='3'
									class='textinput' />&nbsp; <?php echo $lang_add_event_view['repeat_weeks']; ?>&nbsp;<?php echo $lang_add_event_view['rec_weekly_on']; ?><br />
								<br />
								<?php echo $lists['rec_weekly_on_day_checkboxes']; ?></li>
							</ul>
							</div>
							<div id="jcl_rec_monthly_options">
							<ul>
								<li><?php echo $lang_add_event_view['repeat_every']; ?>&nbsp; <input
									type="text" name="rec_monthly_period"
									value="<?php echo $row->rec_monthly_period; ?>" size='3'
									class='textinput' />&nbsp; <?php echo $lang_add_event_view['repeat_months']; ?><br />
								<br />
								<?php echo $lists['recMonthlyTypeOnDayNumber']; ?>&nbsp; <input
									type="text" name="rec_monthly_day_number"
									value="<?php echo $row->rec_monthly_day_number; ?>" size='3'
									class='textinput' /><br />
								<br />
								<?php echo $lists['recMonthlyTypeOnSpecificDay']; ?>&nbsp; <?php echo $lists['rec_monthly_day_order']; ?>&nbsp;
								<?php echo $lists['rec_monthly_day_type']; ?></li>
							</ul>
							</div>
							<div id="jcl_rec_yearly_options">
							<ul>
								<li><?php echo $lang_add_event_view['repeat_every']; ?>&nbsp; <input
									type="text" name="rec_yearly_period"
									value="<?php echo $row->rec_yearly_period; ?>" size='3'
									class='textinput' />&nbsp; <?php echo $lang_add_event_view['repeat_years']; ?>&nbsp;<?php echo $lang_add_event_view['rec_yearly_on_month_label']; ?>&nbsp;<?php echo $lists['rec_yearly_on_month']; ?><br />
								<br />
								<?php echo $lists['recYearlyTypeOnDayNumber']; ?>&nbsp; <input
									type="text" name="rec_yearly_day_number"
									value="<?php echo $row->rec_yearly_day_number; ?>" size='3'
									class='textinput' /><br />
								<br />
								<?php echo $lists['recYearlyTypeOnSpecificDay']; ?>&nbsp; <?php echo $lists['rec_yearly_day_order']; ?>&nbsp;
								<?php echo $lists['rec_yearly_day_type']; ?></li>
							</ul>
							</div>
							</td>
						</tr>
						<!-- Recurrence end date options -->
						<tr>
							<td class='tablec' colspan="2"><strong><?php echo $lang_add_event_view['repeat_end_date_label']; ?></strong></td>
						</tr>
						<tr>
							<td class='tableb' colspan="2"><input type="radio"
								name="recur_end_type" id="recur_end_type_count" value="1"
								<?php echo ((int)$row->recur_end_type == 1)?"checked":""; ?> />
								<?php echo sprintf($lang_add_event_view['repeat_end_date_count'],'<input type="text" name="recur_end_count" id="recur_end_count" value="'.$row->recur_end_count.'" size="2" class="textinput" />'); ?>
							</td>
						</tr>
						<tr>
							<td class='tableb' colspan="2"><input type="radio"
								name="recur_end_type" id="recur_end_type_until" value="2"
								<?php echo ((int)$row->recur_end_type == 2)?"checked":""; ?> /><?php echo $lang_add_event_view['repeat_end_date_until']; ?>:
							&nbsp; <?php echo $lists['rec_recur_until'];?></td>
						</tr>
					</table>
					<?php } else {
					  // child recurring event : wa cannot edit
					  if ($row->detached_from_rec) {
					    echo '<br /><strong>' . $lang_add_event_view['repeat_event_detached'] . '</strong>';
					  } else {
					    $link = JRoute::_('index.php?option=com_jcalpro&section=events&task=editA&hidemainmenu=1&id=' . $row->rec_id);
					    echo '<br /><strong>' . $lang_add_event_view['repeat_event_not_detached'] . '</strong>&nbsp&nbsp<a class="button" href="' . $link . '" >&nbsp;&nbsp;'
					    .  $lang_add_event_view['repeat_edit_parent_event'] . '&nbsp;&nbsp;</a>';
					  }


					  echo "\n" . '<input type="hidden" name="rec_type_select" value="1" />
     <input type="hidden" name="rec_daily_period" value="'.$row->rec_daily_period.'" />
     <input type="hidden" name="rec_weekly_period" value="'.$row->rec_weekly_period.'" />
     '. $lists['rec_weekly_on_day_checkboxes']. '
     <input type="hidden" name="rec_monthly_period" value="'.$row->rec_monthly_period.'" />
     <input type="hidden" name="rec_monthly_day_number" value="'.$row->rec_monthly_day_number.'" />
     '. $lists['rec_monthly_day_order']. '
     '. $lists['rec_monthly_day_type']. '
     <input type="hidden" name="rec_yearly_period" value="'.$row->rec_yearly_period.'" />
     '. $lists['rec_yearly_on_month']. '
     <input type="hidden" name="rec_yearly_day_number" value="'.$row->rec_yearly_day_number.'" />
     '. $lists['rec_yearly_day_order']. '
     '. $lists['rec_yearly_day_type']. '
     <input type="hidden" name="recur_end_type" value="'.$row->recur_end_type.'" />
     <input type="hidden" name="recur_end_count" id="recur_end_count" value="'.$row->recur_end_count.'" />
     '. $lists['rec_recur_until'];

					} ?></td>
				</tr>

		</table>
		</td>
		<td width="40%" valign="top"><?php
		$tabs->startPane("content-pane");
		$tabs->startPanel("Publishing","publish-page");
		?>
		<table width="100%" class="adminform">
			<tr>
				<th colspan="2">Publishing Info</th>


				<tr>


					<tr>
						<td valign="top" align="right"><?php echo _EXTCAL_PUBLISHED; ?>:</td>
						<td><?php echo $lists['published']; ?></td>
					</tr>

					<tr>
						<td valign="top" align="right"><?php echo $lang_add_event_view['auto_appr_event']; ?>:</td>
						<td><?php echo $lists['approved']; ?></td>
					</tr>

					<tr>
						<td valign="top" align="right"><?php echo $lang_add_event_view['privacy']; ?>:</td>
						<td><?php echo $lists['private']; ?></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>

		</table>
		<?php
		$tabs->endPanel();
		$tabs->endPane();
		?></td>
	</tr>
</table>

<script language="Javascript"
	src="<?php echo JURI::base();;?>/includes/js/overlib_mini.js"></script>
<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="section" value="<?php echo $section; ?>" /> <input
	type="hidden" name="extid" value="<?php echo $row->extid; ?>" /> <input
	type="hidden" name="rec_id" value="<?php echo $row->rec_id; ?>" /> <input
	type="hidden" name="detached_from_rec"
	value="<?php echo $row->detached_from_rec; ?>" /> <input type="hidden"
	name="previous_recur_type"
	value="<?php echo $lists['previous_recur_type']; ?>" /> <input
	type="hidden" name="owner_id" value="<?php echo $row->owner_id; ?>" />

<input type="hidden" name="task" value="" /></form>
		<?php
  }
}
?>