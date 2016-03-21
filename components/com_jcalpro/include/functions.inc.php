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

 $Id: functions.inc.php 718 2011-05-11 19:30:35Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.utilities.date');

function mf_process_category_date(&$row, $date = null) {
	// Added this function to handle custom display of event dates in the view-by-category events list,
	// so that it displays recurrent events properly.

	global $lang_add_event_view, $lang_event_view, $lang_general, $lang_date_format, $CONFIG_EXT, $next_recurrence_stamp;

	$showrecurrence = $CONFIG_EXT['show_recurrence_info_category_view'];
	$timeString = $CONFIG_EXT['show_event_times_in_cat_view'] ? ' ('.mf_get_timerange($row, $date).')' : '';

	if (!empty($date)) {
		$currentDay = is_numeric( $date) ? $date : jcUTCDateToFormat( $date, '%d');
		$eventStartDay = jcUTCDateToFormat( $row->start_date, '%d');
		$eventEndDay = jcUTCDateToFormat( $row->end_date, '%d');
		if ( $currentDay == $eventStartDay) {
			// we are on the day the event start
			$eventDate = $row->start_date;
		} else if ( $currentDay == $eventEndDay) {
			// we are on the day the event ends
			$eventDate = $row->end_date;
		} else {
			// we are on another day
			// get current month/year
			$curMonth = jcUTCDateToFormat( $row->start_date, '%m');
			$curYear = jcUTCDateToFormat( $row->start_date, '%Y');
			$eventCurDateTS = jcUserTimeToUTC( 0,0,0,$curMonth,$currentDay, $curYear);
			$eventDate =  jcUTCDateToFormat( $eventCurDateTS, '%Y-%m-%d %H:%M:%S') . ' (...)';
		}
	} else {
		$eventDate = $row->start_date;
	}

	$return_date_string = jcUTCDateToFormat( $eventDate, $lang_date_format['full_date']). $timeString;

	if ($showrecurrence) $return_date_string .= '<br />' . mf_get_recurrence_info_string($row);

	return $return_date_string;

}

function mf_get_recurrence_info_string(&$row) {

	global $lang_add_event_view, $lang_event_view, $lang_general, $lang_date_format, $next_recurrence_stamp, $CONFIG_EXT;

	$return_recur_info = '';

	// special case : detached events
	if (@$row->rec_type_select != JCL_REC_TYPE_NONE && @$row->detached_from_rec) {
		return $lang_add_event_view['repeat_event_detached_short'];
	}

	switch (@$row->rec_type_select) {
		case JCL_REC_TYPE_DAILY: // daily
			if ( $row->rec_daily_period == 1 ) {
				$return_recur_info .= $lang_general['everyday'];
			} else {
				$return_recur_info .= $lang_add_event_view['repeat_every'].' '.$row->rec_daily_period.' '.$lang_general['days'];
			}
			if( $row->recur_end_type == 1 ) {
				// make it a user date, as this is what mf_until_enddate_string expects
				$end_date_stamp = jcUTCDateToTs( $row->recur_until);
				$row->recur_until = jcUTCDateToFormat( $end_date_stamp, '%Y-%m-%d %H:%M:%S');
			}
			$return_recur_info .= mf_until_enddate_string($row,'%B %d, %Y');
			break;
		case JCL_REC_TYPE_WEEKLY: // weekly
			if ( $row->rec_weekly_period == 1 ) {
				//$daynumber = date('w', mf_convert_to_timestamp( $row->start_date,'dateonly'));
				if ($CONFIG_EXT['day_start']) {
					$daynumber = jcUTCDateToFormat( $row->start_date, '%u');
				} else {
					$daynumber = jcUTCDateToFormat( $row->start_date, '%w');
				}
				$return_recur_info .= $lang_add_event_view['repeat_every'].' '.$lang_date_format['day_of_week'][$daynumber];
			} else {
				$return_recur_info .= $lang_add_event_view['repeat_every'].' '.$row->rec_weekly_period.' '.$lang_add_event_view['repeat_weeks'];
			}
			if( $row->recur_end_type == 1 ) {
				// make it a user date, as this is what mf_until_enddate_string expects
				$end_date_stamp = jcUTCDateToTs( $row->recur_until);
				$row->recur_until = jcUTCDateToFormat( $end_date_stamp, '%Y-%m-%d %H:%M:%S');
			}
			$return_recur_info .= mf_until_enddate_string($row,'%B %d, %Y');
			break;
		case JCL_REC_TYPE_MONTHLY: // monthly
			if ( $row->rec_monthly_period == 1 ) {
				$return_recur_info .= $lang_general['everymonth'];
			} else {
				$return_recur_info .= $lang_add_event_view['repeat_every'].' '.$row->rec_monthly_period.' '.$lang_general['months'];
			}
			if( $row->recur_end_type == 1 ) {
				// make it a user date, as this is what mf_until_enddate_string expects
				$end_date_stamp = jcUTCDateToTs( $row->recur_until);
				$row->recur_until = jcUTCDateToFormat( $end_date_stamp, '%Y-%m-%d %H:%M:%S');
			}
			$return_recur_info .= mf_until_enddate_string($row,'%B %d, %Y');
			break;
		case JCL_REC_TYPE_YEARLY: // yearly
			if ( $row->rec_yearly_period == 1 ) {
				$return_recur_info .= $lang_general['everyyear'];
			} else {
				$return_recur_info .= $lang_add_event_view['repeat_every'].' '.$row->rec_yearly_period.' '.$lang_general['years'];
			}
			if( $row->recur_end_type == 1 ) {
				// make it a user date, as this is what mf_until_enddate_string expects
				$end_date_stamp = jcUTCDateToTs( $row->recur_until);
				$row->recur_until = jcUTCDateToFormat( $end_date_stamp, '%Y-%m-%d %H:%M:%S');
			}
			$return_recur_info .= mf_until_enddate_string($row,'%B %d, %Y');
			break;
		case '':
		default:
			$return_recur_info .= $lang_add_event_view['event_no_repeat_msg'];
			break;
	}

	return $return_recur_info;

}

function mf_until_enddate_string(&$event, $date_format=false) {
	// Used by mf_process_category_date() to calculate the end date of recurring events.

	global $lang_date_format, $lang_event_view;

	$return_string = '';
	$date_format = $date_format ? $date_format : $lang_date_format['full_date'];

	if ($event->recur_end_type) {
		$return_string .= ' '.JString::strtolower($lang_event_view['event_end_date']) . ' ' . jcUTCDateToFormat( $event->recur_until, $date_format);
	}

	return $return_string;

}

function jcHourToDisplayString( $hour, $minute = null, $force24Hours = null) {
	global $CONFIG_EXT, $lang_general;

	$use24Hours = is_null( $force24Hours) ? $CONFIG_EXT['time_format_24hours'] : $force24Hours;
	$minuteDisplay = is_null($minute) ? '' : ':' . sprintf("%02d",$minute);
	if($use24Hours) {
		// 24 hours
		$displayItem = sprintf("%02d",$hour) . $minuteDisplay;
	} else {
		// bug #152 - if minute isn't there or is 0, make it fuzzy
		$fuzzy = (bool)(is_null($minute) || 0 == (int) sprintf("%02d",$minute));
		// am/pm
		if ($hour == 0) {
			$displayItem = '00'. $minuteDisplay .' - '. $lang_general[$fuzzy?'midnight':'am'];
		} else if ($hour == 12) {
			$displayItem = '12' . $minuteDisplay . ' - '. $lang_general[$fuzzy?'noon':'pm'];
		} else if ($hour > 0 && $hour < 12) {
			$displayItem = sprintf("%02d",$hour) . $minuteDisplay . ' ' . $lang_general['am'];
		} else {
			$displayItem = sprintf("%02d",$hour - 12) . $minuteDisplay . ' ' . $lang_general['pm'];
		}
		// Don't include the leading zero in 12-hour time:
		$displayItem = (JString::substr($displayItem,0,1) == '0') ? JString::substr($displayItem,1) : $displayItem;
	}

	return $displayItem;
}

function mf_get_time_from_datetime($timedatestring, $convertToLocal = false) {
	// $timedatestring is considered a UTC timedate
	global $CONFIG_EXT;

	$timestring = JString::substr($timedatestring,-8,8);
	$timestringArray = explode(':',$timestring);

	$hour = jcUTCDateToFormat( $timedatestring, '%H');
	$minute = jcUTCDateToFormat( $timedatestring, '%M');
	return jcHourToDisplayString( $hour, $minute);
}

function mf_get_timerange(&$event, $date = null) {
	// Takes an event that has been loaded as an JCalEvent class instance
	// times are stored as UTC, so we must convert to local before displaying
	global $CONFIG_EXT;

	if ( !jclIsAllDay($event->end_date) && (jclIsNoEndDate($event->end_date) || $CONFIG_EXT['show_only_start_times'] )) {
		return str_replace(' ','&nbsp;',mf_get_time_from_datetime($event->start_date));
	}
	// If the event is an "all day" event, return that:
	else if ( jclIsAllDay($event->end_date)) return EXTCAL_TEXT_ALL_DAY;
	// If the event spans more than one day, don't use the end time:
	// let's make it a bit better now :
	else {
		$eventStartDay = jcUTCDateToFormat( $event->start_date, '%d');
		$eventEndDay = jcUTCDateToFormat( $event->end_date, '%d');
		if ( $eventStartDay < $eventEndDay ) {
			if (!empty($date)) {
				$currentDay = is_numeric( $date) ? $date : jcUTCDateToFormat( $date, '%d');
				if ( $currentDay == $eventStartDay) {
					// we are on the day the event start
					return str_replace(' ','&nbsp;',mf_get_time_from_datetime($event->start_date)) . '...';
				} else if ( $currentDay == $eventEndDay) {
					// we are on the day the event ends
					return '...' . str_replace(' ','&nbsp;',mf_get_time_from_datetime($event->end_date));
				} else {
					// we are on another day
					return '...';
				}
			} else {
				return str_replace(' ','&nbsp;',mf_get_time_from_datetime($event->start_date));
			}
		} else {
			return (mf_get_time_from_datetime($event->start_date) . ' - ' . mf_get_time_from_datetime($event->end_date));
		}
	}
}

function require_login() {
	/* this function checks to see if the user is logged in.  if not, it will show
	* the login screen before allowing the user to continue */
	global $CONFIG_EXT, $lang_system, $lang_general;

	if (!USER_IS_LOGGED_IN) {
		//$_SESSION["wantsurl"] = qualified_me();
		jcPageHeader($lang_system['system_caption']);
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog($lang_system['system_caption'], $lang_system['page_requires_login'], $lang_general['continue'], $sef_href);
		return false;
	}
}

function require_priv($action, $redirectToUrl = null) {
	global $CONFIG_EXT, $lang_system, $lang_general;

	$my = &JFactory::getUser();
	$acl = &JFactory::getACL();

	/* this function checks to see if the user has the privilege $priv.  if not,
	* it will display an Insufficient Privileges page and stop */
	// Revised to use new USER_IS_ADMIN global constant, which was set in config.inc.php
	// using Mambo's usertype value. Does NOT have fancy code to allow "XXX type and up"
	// to access page--just checks to see if you ARE that type or an Admin, and then lets
	// you through. With one exception: if the privilege is set to "Registered" then anybody
	// who's logged in gets through. NOTE that this differs from has_priv() in that if the user
	// does NOT have the privilege, it gives them a warning screen before returning false.

	if ( trim ( $my->usertype ) == "" )
	{
		$my->usertype = 'Public Frontend';
	}

	if ( $acl->acl_check( 'content', $action, 'users', $my->usertype, 'calendar', 'all' ) )
	{
		return true;
	}
	else
	{
		jcPageHeader($lang_system['system_caption']);
		$mylevel = (($my->usertype == '') || !isset($my->usertype)) ? 'Anonymous Guest' : $my->usertype;
		$sef_href = JRoute::_( empty( $redirectToUrl) ? $CONFIG_EXT['calendar_calling_page'] : $redirectToUrl);
		theme_redirect_dialog($lang_system['system_caption'], $lang_system['page_access_denied']
		. sprintf($lang_system['system_caption'], $mylevel, $CONFIG_EXT['who_can_'.$action.'_events'])
		.'.', $lang_general['back'], $sef_href);
		return false;
	}
}

function has_priv($action) {
	global $CONFIG_EXT, $lang_system, $lang_generalm;

	$my = &JFactory::getUser();
	$acl = &JFactory::getACL();
	/* returns true if the user has the privilege $priv */
	// Revised to use new USER_IS_ADMIN global constant, which was set in config.inc.php
	// using Mambo's usertype value. Does NOT have fancy code to allow "XXX type and up"
	// to access page--just checks to see if you ARE that type or an Admin, and then lets
	// you through. With one exception: if the privilege is set to "Registered" then anybody
	// who's logged in gets through.

	if ( trim ( $my->usertype ) == "" )
	{
		$my->usertype = 'Public Frontend';
	}

	if ( $acl->acl_check( 'content', $action, 'users', $my->usertype, 'calendar', 'all' ) )
	{
		return true;
	}
	else
	{
		return false;
	}

}

/**
 * Finds out whether current user can perform an action on an event
 * @param $event
 * @return boolean
 */
function jclCanModifyEvent( $event, $action) {

	$status = false;
	$actions = array ('edit', 'delete');
	if (empty( $event) || empty( $action) || !in_array($action, $actions)) {
		return false;
	}

	// can user edit ?
	$userCanDo = has_priv( $action);
	if (!$userCanDo) {
		return $status;
	}

	// public event : we're fine
	if ($event->private == JCL_EVENT_PUBLIC) {
		return true;
	}

	// remaining option : this is a private event : user can perform action only
	// if she is the owner
	$user = &JFactory::getUser();
	return $user->id == $event->owner_id;
}

function jclCanViewEvent( $event) {

	global $private_events_mode;

	$status = false;

	// check calendar access && category access
	$userCanView = has_priv ( 'calendar' . $event->cal_id ) && has_priv ( 'category' . $event->catId ) && $event->published;
	if (!$userCanView) {
		return false;
	}

	// check various settings
	switch ($private_events_mode) {
		case JCL_DO_NOT_SHOW_PRIVATE_EVENTS :
			if ($event->private != JCL_EVENT_PUBLIC) {
				return false;
			}
			break;
		case  JCL_SHOW_ONLY_PRIVATE_EVENTS :
			if ($event->private == JCL_EVENT_PUBLIC) {
				return false;
			}
			break;
		case  JCL_SHOW_ONLY_OWN_EVENTS :
			if ($user->id != $event->owner_id) {
				return false;
			}
			break;
	}
	// event is public or read only
	if ($event->private != JCL_EVENT_PRIVATE) {
		return true;
	}

	// if private, only display if user is owner
	$user = &JFactory::getUser();
	return $user->id == $event->owner_id;
}

// Search function
function extcal_search()
{
	global $lang_event_search_data;
	// don't show search on print pages
	$print = JRequest::getCmd( 'print', 0);
	if (!empty( $print)) {
		return;
	}
	$keyword = JRequest::getString( 'extcal_search', $lang_event_search_data['search_caption'], 'POST');
	$button = (isset($_POST["extcal_search"]) && !empty($_POST["extcal_search"])) ?$lang_event_search_data['search_again']:$lang_event_search_data['search_button'];
	theme_search_form($keyword, $button);
}

// Error strings template
function theme_error_string($string) {
	global $template_error_string;

	$params = array('{MESSAGE}' => $string);
	return template_eval($template_error_string, $params);
}

/**
 * Build the html for a category select list
 *
 * @param integer $current the currently selected category id
 * @return html for a select list of accessible categories
 */
function jclBuildCategoriesList( $current = null) {

	global $CONFIG_EXT;

	$db = &JFactory::getDBO();

	// building category list
	$cat_id = isset ( $current) ? $current : '';

	$cat_filter = " WHERE published = '1' OR cat_id = " .$db->Quote($cat_id).' ORDER BY cat_name';
	$query = "SELECT * FROM ".$CONFIG_EXT['TABLE_CATEGORIES'] . $cat_filter;
	$db->setQuery( $query);
	$raw_cat_list = $db->loadObjectList();

	$cat_list = '';

	// remove cats if user is not authorized
	if (!empty( $raw_cat_list)) {
		foreach( $raw_cat_list as $cat) {
			if ( has_priv ( 'category' . $cat->cat_id ) ) {
				$selected = "";
				if(!empty( $cat_id)) {
					$selected = ($cat->cat_id == $cat_id)?'selected="selected"':'';
				}
				$cat_list .= "\t<option value='".$cat->cat_id."' style='color: " . $cat->color . "' $selected>".$cat->cat_name."</option>\n";
			}
		}
	}

	return $cat_list;
}

function display_event_form($target, $extmode, $form, $event_mode = '', $backLink = '') {
	/* Display event form */

	global $CONFIG_EXT, $THEME_DIR, $template_add_event_form, $template_add_event_form_alt_rec_info, $template_add_event_form_show_calendar,
	$template_add_event_form_do_not_show_calendar, $template_add_event_form_show_private, $template_add_event_form_do_not_show_private,
	$template_add_event_form_show_auto_approve, $template_add_event_form_do_not_show_auto_approve, $errors, $today;
	global $lang_add_event_view, $lang_general, $lang_date_format, $lang_settings_data;

	$db = &JFactory::getDBO();
	jimport( 'joomla.html.html');

	// if popup, only show component
	if ($event_mode != 'add' && $event_mode !='edit' && $CONFIG_EXT['popup_event_mode']) {
		$connector = strpos( $target, '?') === false ? '?' : '&amp;';
		$target .= $connector . 'tmpl=component';
	}

	// building category list
	$cat_list = jclBuildCategoriesList( $form['cat']);

	// building calendars list
	$cal_list = jclBuildSimpleCalendarList( $form['cal_id']);

	// building day list
	$day_list = '';
	for ($i = 1;$i<=31;$i++)
	{
		$selected = ($form['day']==$i)?'selected="selected"':'';
		$day_list .= "\t<option value='$i' $selected>$i</option>\n";
	}

	// building month list
	$month_list = '';
	for($i=1;$i<=12;$i++)
	{
		$selected = ($form['month'] == $i)?"selected":"";
		$month_list .= "\t<option value='".$i."' $selected>".$lang_date_format['months'][$i-1]."</option>\n";
	}

	// building year list
	$year_list = '';
	$y = date("Y", TSserverToUTC( extcal_get_local_time())) - JCL_NUMBER_YEARS_TO_SHOW_BEFORE;
	for ($i=0;$i<=JCL_NUMBER_YEARS_TO_SHOW_AFTER;$i++)
	{
		$selected = ($form['year']==$y)?"selected":"";
		$year_list .= "\t<option $selected>$y</option>\n";
		$y += 1;
	}

	// building time list options
	// we now always use the 24 hours template, in order to remove ambiguity between noon and midnight on am/pm mode
	$hour_init = 0;
	$hour_limit = 23;
	$start_hour_list = '';
	for ($i = $hour_init;$i<=$hour_limit;$i++)
	{
		$selected = ($form['start_time_hour'] == $i)?'selected="selected"':'';
		// find display value depending on setting :
		if($CONFIG_EXT['time_format_24hours']) {
			// 24 hours
			$displayItem = sprintf("%02d",$i);
		} else {
			// am/pm
			if ($i == 0) {
				$displayItem = '00 '. $lang_general['midnight'];
			} else if ($i == 12) {
				$displayItem = '12 '. $lang_general['noon'];
			} else if ($i > 0 && $i < 12) {
				$displayItem = sprintf("%02d",$i) . ' ' . $lang_general['am'];
			} else {
				$displayItem = sprintf("%02d",$i - 12) . ' ' . $lang_general['pm'];
			}

		}
		$start_hour_list .= "\t<option value='$i' $selected>".$displayItem."</option>\n";
	}
	$start_minute_list = '';
	for ($i = 0;$i<=59;$i+=1)
	{
		$selected = ($form['start_time_minute'] == $i)?'selected="selected"':'';
		$start_minute_list .= "\t<option value='$i' $selected>".sprintf("%02d",$i)."</option>\n";
	}

	//@TODO : remove, not needed anymore
	$start_ampm_list = '';

	// building recurrence info
	$recur_type_1_options = '';

	// building day list
	$recur_until_day_list = '';

	// building month list
	$recur_until_month_list = '';

	// building year list
	$recur_until_year_list = '';

	$auto_approve = !empty( $form['autoapprove']) ? 'checked="checked"' : '';
	$del_picture = !empty( $form['delpicture']) ? 'checked="checked"' : '';

	// calculate private event select list
	$privateLabels = array( JCL_EVENT_PUBLIC => $lang_add_event_view['public_event'], JCL_EVENT_PRIVATE => $lang_add_event_view['private_event'],
	JCL_EVENT_PRIVATE_READ_ONLY => $lang_add_event_view['private_event_read_only']);
	$private = '';
	foreach ($privateLabels as $key => $label) {
		$selected = isset($form['private']) && $form['private'] == $key ? 'selected="selected"':'';
		$private .= "\t<option value='" . $key . "' $selected>". $label ."</option>\n";
	}

	$orig_picture = isset($form['origpicture'])?$form['origpicture']:"";

	// jcal 2 : if this is an instance of a recurring event, detached or not from original, don't allow recurrence change
	if (!empty( $form['rec_id'])) {
		template_extract_block($template_add_event_form, 'recurrence_row', $template_add_event_form_alt_rec_info);
	}

	if(!$errors) template_extract_block($template_add_event_form, 'errors_row');
	if(!$CONFIG_EXT['addevent_allow_contact']) template_extract_block($template_add_event_form, 'contact_row');
	if(!$CONFIG_EXT['addevent_allow_email']) template_extract_block($template_add_event_form, 'email_row');
	if(!$CONFIG_EXT['addevent_allow_url']) template_extract_block($template_add_event_form, 'url_row');

	switch($event_mode) {
		case "edit":
			$title = format_text($form['title'],false,$CONFIG_EXT['capitalize_event_titles']);
			starttable("100%", sprintf($lang_add_event_view['edit_event'],$form['extid'],$title),2);
			$submit = $lang_add_event_view['update_event_button'];
			break;
		case "add":
		default:
			starttable("100%",$lang_add_event_view['section_title'],2);
			$submit = $lang_add_event_view['section_title'];
			break;
	}

	// we now always use the 24hours template
	template_extract_block($template_add_event_form, '12hour_mode_row');

	if ( $CONFIG_EXT['addevent_allow_html'] )
	{

		//ob_start();
		// parameters : areaname, content, hidden field, width, height, rows, cols

		if ( !isset ( $form['description'] ) )
		{
			$form['description'] = '';
		}

		$editorInstance = JFactory::getEditor();
		$editorDescription = $editorInstance->display( 'description',$form['description'],'100%','200','45','10');
	}
	else
	{
		$editorDescription = '<textarea name="description" rows="8" cols="50">' . @$form['description'] . '</textarea>';
	}

	if (!empty($form['rec_id']) && !empty($form['detached_from_rec'])) {
		$recurrence_message = $lang_add_event_view['repeat_event_detached'];
	} elseif (!empty($form['rec_id'])) {
		// this is an event part of a recurrence, but not the parent event
		$recurrence_message = $lang_add_event_view['repeat_event_not_detached'];
		// let's add a link to edit the parent event
		$link = JRoute::_('index.php?option=com_jcalpro&amp;extmode=event&amp;event_mode=edit&amp;extid=' . $form['rec_id']);
		$recurrence_message .= '&nbsp&nbsp<a class="button" href="' . $link . '" >&nbsp;&nbsp;' .  $lang_add_event_view['repeat_edit_parent_event'] . '&nbsp;&nbsp;</a>';
	} elseif ($form['rec_type_select'] != JCL_REC_TYPE_NONE) {
		$recurrence_message = $lang_add_event_view['event_repeat_msg'];
	} else {
		$recurrence_message = $lang_add_event_view['event_no_repeat_msg'];
	}

	// V 2.1.x : new recurrence options

	if (empty($form['rec_id'])) {
		// this is a regular event, not a child of another recurring event
		// recurrence type selection : none, daily, weekly, monthly, yearly
		$options = array(
		array( 'value' => JCL_REC_TYPE_NONE, 'text' => $lang_add_event_view['repeat_none'], 'attrib' => 'onclick = "jclShowRecOptions(\'none\');jclSetText(\'recur_message\', noRecurEventMsg)"', 'id' => '')
		,array( 'value' => JCL_REC_TYPE_DAILY, 'text' => $lang_add_event_view['repeat_daily'], 'attrib' => 'onclick = "jclShowRecOptions(\'daily\');jclSetText(\'recur_message\', recurEventMsg)"', 'id' => '')
		,array( 'value' => JCL_REC_TYPE_WEEKLY, 'text' => $lang_add_event_view['repeat_weekly'], 'attrib' => 'onclick = "jclShowRecOptions(\'weekly\');jclSetText(\'recur_message\', recurEventMsg)"', 'id' => '')
		,array( 'value' => JCL_REC_TYPE_MONTHLY, 'text' => $lang_add_event_view['repeat_monthly'], 'attrib' => 'onclick = "jclShowRecOptions(\'monthly\');jclSetText(\'recur_message\', recurEventMsg)"', 'id' => '')
		,array( 'value' => JCL_REC_TYPE_YEARLY, 'text' => $lang_add_event_view['repeat_yearly'], 'attrib' => 'onclick = "jclShowRecOptions(\'yearly\');jclSetText(\'recur_message\', recurEventMsg)"', 'id' => '')
		);
		$recTypeSelectHtml = jclBuildRadioList( $options, 'rec_type_select', $form['rec_type_select'], null, false, true);
		//$recTypeSelectHtml = str_replace('<input type="radio"', '<input type="radio"' . ' disabled ', $recTypeSelectHtml);  // disable recurrence options if site admin wants to - uncomment to activate

		// weekly recurrence options
		$options = array(
		array( 'value' => '1', 'name' => 'rec_weekly_on_monday', 'text' => $lang_date_format['day_of_week'][1], 'checked' => $form['rec_weekly_on_monday'] ? $form['rec_weekly_on_monday'] : '', 'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_tuesday', 'text' => $lang_date_format['day_of_week'][2], 'checked' => $form['rec_weekly_on_tuesday'] ? $form['rec_weekly_on_tuesday'] : '', 'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_wednesday', 'text' => $lang_date_format['day_of_week'][3], 'checked' => $form['rec_weekly_on_wednesday'] ? $form['rec_weekly_on_wednesday'] : '',  'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_thursday', 'text' => $lang_date_format['day_of_week'][4], 'checked' => $form['rec_weekly_on_thursday'] ? $form['rec_weekly_on_thursday'] : '', 'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_friday', 'text' => $lang_date_format['day_of_week'][5], 'checked' => $form['rec_weekly_on_friday'] ? $form['rec_weekly_on_friday'] : '', 'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_saturday', 'text' => $lang_date_format['day_of_week'][6], 'checked' => $form['rec_weekly_on_saturday'] ? $form['rec_weekly_on_saturday'] : '',  'attrib' => '', 'id' => '')
		, array( 'value' => '1', 'name' => 'rec_weekly_on_sunday', 'text' => $lang_date_format['day_of_week'][0], 'checked' => $form['rec_weekly_on_sunday'] ? $form['rec_weekly_on_sunday'] : '',  'attrib' => '', 'id' => '')
		);

		if (!$CONFIG_EXT['day_start']) {
			// week starts on sunday
			$tmp = $options[6];
			array_unshift( $options, $tmp);
			unset( $options[7]);
		}

		$recTypeWeeklyOnDays = jclBuildCheckBoxesList( $options, false, false);

		// monthly recurrence options
		$recMonthlyTypeOnDayNumber = jclBuildRadioListItem( 'rec_monthly_type', 'rec_monthly_type0', '0', $form['rec_monthly_type'] == JCL_REC_ON_DAY_NUMBER,
		$lang_add_event_view['rec_monthly_on'], '', false);
		$recMonthlyTypeOnSpecificDay = jclBuildRadioListItem( 'rec_monthly_type', 'rec_monthly_type1', '1', $form['rec_monthly_type'] == JCL_REC_ON_SPECIFIC_DAY,
		$lang_add_event_view['rec_monthly_on'], '', false);
		$recMonthlyDayOrder = jclBuildDayOrderList( 'rec_monthly_day_order', $form['rec_monthly_day_order'], 'class="listbox" onChange="jclSetChecked(\'rec_monthly_type0\', false); jclSetChecked(\'rec_monthly_type1\', true);"');
		$recMonthlyDayType = jclBuildDayTypeList( 'rec_monthly_day_type', $form['rec_monthly_day_type'], 'class="listbox" onChange="jclSetChecked(\'rec_monthly_type0\', false); jclSetChecked(\'rec_monthly_type1\', true);"');

		// yearly recurrence options
		$recYearlyTypeOnDayNumber = jclBuildRadioListItem( 'rec_yearly_type', 'rec_yearly_type0', '0', $form['rec_yearly_type'] == JCL_REC_ON_DAY_NUMBER,
		$lang_add_event_view['rec_yearly_on'], '', false);
		$recYearlyTypeOnSpecificDay = jclBuildRadioListItem( 'rec_yearly_type', 'rec_yearly_type1', '1', $form['rec_yearly_type'] == JCL_REC_ON_SPECIFIC_DAY,
		$lang_add_event_view['rec_yearly_on'], '', false);
		$recYearlyDayOrder = jclBuildDayOrderList( 'rec_yearly_day_order', $form['rec_yearly_day_order'], 'class="listbox" onChange="jclSetChecked(\'rec_yearly_type0\', false); jclSetChecked(\'rec_yearly_type1\', true);"');
		$recYearlyDayType = jclBuildDayTypeList( 'rec_yearly_day_type', $form['rec_yearly_day_type'], 'class="listbox" onChange="jclSetChecked(\'rec_yearly_type0\', false); jclSetChecked(\'rec_yearly_type1\', true);"');
		$recYearlyOnMonth = jclBuildGenericList( 'rec_yearly_on_month', $form['rec_yearly_on_month'],  $lang_date_format['months'], 'class="listbox"');
		$recRecurUntil = JHTML::_( 'calendar', $form['rec_recur_until'], 'rec_recur_until', 'rec_recur_until', $lang_date_format['date_entry'], 'class="textinput"');
		$recCloseSectionStyle = get_display_style('recurrence','close');
		$recOpenSectionStyle = get_display_style('recurrence','open');
		if (!empty($form['common_event_id'])) {
			$commonEventId =  jclBuildHiddenFields( array( array('name' => 'common_event_id', 'value' => $form['common_event_id'])));
		} else {
			$commonEventId = '';
		}
	} else {
		// this is a child of a recurrent event, we don't display recurrence options, but we need to pass them on as hidden fields to preserve them
		$options = array(
		array( 'name'=>'rec_weekly_on_monday', 'value'=>$form['rec_weekly_on_monday']),
		array( 'name'=>'rec_weekly_on_tuesday', 'value'=>$form['rec_weekly_on_tuesday']),
		array( 'name'=>'rec_weekly_on_wednesday', 'value'=>$form['rec_weekly_on_wednesday']),
		array( 'name'=>'rec_weekly_on_thursday', 'value'=>$form['rec_weekly_on_thursday']),
		array( 'name'=>'rec_weekly_on_friday', 'value'=>$form['rec_weekly_on_friday']),
		array( 'name'=>'rec_weekly_on_saturday', 'value'=>$form['rec_weekly_on_saturday']),
		array( 'name'=>'rec_weekly_on_sunday', 'value'=>$form['rec_weekly_on_sunday'])
		);
		$recTypeWeeklyOnDays = jclBuildHiddenFields( $options);
		$options = array(
		array( 'name'=>'rec_monthly_day_order', 'value'=>$form['rec_monthly_day_order'])
		);
		$recMonthlyDayOrder = jclBuildHiddenFields( $options);
		$options = array(
		array( 'name'=>'rec_monthly_day_type', 'value'=>$form['rec_monthly_day_type'])
		);
		$recMonthlyDayType = jclBuildHiddenFields( $options);
		$options = array(
		array( 'name'=>'rec_yearly_on_month', 'value'=>$form['rec_yearly_on_month'])
		);
		$recYearlyOnMonth = jclBuildHiddenFields( $options);
		$options = array(
		array( 'name'=>'rec_yearly_day_order', 'value'=>$form['rec_yearly_day_order'])
		);
		$recYearlyDayOrder = jclBuildHiddenFields( $options);
		$options = array(
		array( 'name'=>'rec_yearly_day_type', 'value'=>$form['rec_yearly_day_type'])
		);
		$recYearlyDayType = jclBuildHiddenFields( $options);

		$recRecurUntil = jclBuildHiddenFields( array( array('name' => 'recur_until', 'value' => $form['rec_recur_until'])));

		if (!empty($form['common_event_id'])) {
			$commonEventId =  jclBuildHiddenFields( array( array('name' => 'common_event_id', 'value' => $form['common_event_id'])));
		} else {
			$commonEventId = '';
		}

		$recCloseSectionStyle = get_display_style('recurrence','close', 'forced');
		$recOpenSectionStyle = get_display_style('recurrence','open', 'forced');
	}
	// end of recurrence calendar input

	// prepare data for template
	$params = array(
	'{TARGET}' => $target,
	'{THEME_DIR}' => $THEME_DIR,
	'{MODE}' => $extmode,
	'{EVENT_ID}' => isset($form['extid'])?$form['extid']:"",
	'{ERRORS}' => $lang_general['errors'],
	'{ERROR_MSG}' => $errors,
	'{EVENT_DETAILS_CAPTION}' => $lang_add_event_view['event_details_label'],
	'{TITLE_LABEL}' => $lang_add_event_view['event_title'],
	'{TITLE_VAL}' => isset($form['title'])?$form['title']:"",
	'{DESC_LABEL}' => $lang_add_event_view['event_desc'],
	'{DESC_EDITOR}' => $editorDescription,
	'{SEL_CATS_LABEL}' => $lang_add_event_view['event_cat'],
	'{SEL_CATS_DEF}' => $lang_add_event_view['choose_cat'],
	'{SEL_CATS_VAL}' => $cat_list,
	'{DATE_LABEL}' => $lang_add_event_view['event_date'],
	'{DAY_LABEL}' => $lang_add_event_view['day_label'],
	'{MONTH_LABEL}' => $lang_add_event_view['month_label'],
	'{YEAR_LABEL}' => $lang_add_event_view['year_label'],
	'{START_DATE_LABEL}' => $lang_add_event_view['start_date_label'],
	'{START_TIME_LABEL}' => $lang_add_event_view['start_time_label'],
	'{END_DATE_LABEL}' => $lang_add_event_view['end_date_label'],
	'{DAYS_LABEL}' => $lang_general['days'],
	'{HOURS_LABEL}' => $lang_general['hours'],
	'{MINUTES_LABEL}' => $lang_general['minutes'],
	'{ALL_DAY_LABEL}' => $lang_add_event_view['all_day_label'],
	'{NO_DURATION_LABEL}' => $lang_add_event_view['repeat_end_date_none'].' ('.$lang_settings_data['multi_day_events_start'].')',
	'{DURATION_TYPE_NORMAL_CHECKED}' => ((int)$form['duration_type'] == 1)?'checked':'',
	'{DURATION_TYPE_NONE_CHECKED}' => ((int)$form['duration_type'] == 0)?'checked':'',
	'{DURATION_TYPE_ALLDAY_CHECKED}' => ((int)$form['duration_type'] == 2)?'checked':'',
	'{START_DAY_VAL}' => $day_list,
	'{START_MONTH_VAL}' => $month_list,
	'{START_YEAR_VAL}' => $year_list,
	'{START_HOUR_VAL}' => $start_hour_list,
	'{START_MINUTE_VAL}' => $start_minute_list,
	'{START_AMPM_VAL}' => $start_ampm_list,
	'{DAYS_VAL}' => $form['end_days'],
	'{HOURS_VAL}' => $form['end_hours'],
	'{MINUTES_VAL}' => $form['end_minutes'],
	'{CONTACT_CAPTION}' => $lang_add_event_view['contact_details_label'],
	'{CONTACT_LABEL}' => $lang_add_event_view['contact_info'],
	'{CONTACT_VAL}' => isset($form['contact'])?$form['contact']:"",
	'{EMAIL_LABEL}' => $lang_add_event_view['contact_email'],
	'{EMAIL_VAL}' => isset($form['email'])?$form['email']:"",
	'{URL_LABEL}' => $lang_add_event_view['contact_url'],
	'{URL_VAL}' => isset($form['url'])?$form['url']:"",
	'{ADMIN_CAPTION}' => $lang_add_event_view['admin_options_label'],
	'{SUBMIT}' => $submit,
	'{RECUR_CAPTION}' => $lang_add_event_view['repeat_event_label'],
	'{RECUR_METHOD_CAPTION}' => $lang_add_event_view['repeat_method_label'],
	'{EXPAND}' => $lang_general['expand'],
	'{COLLAPSE}' => $lang_general['collapse'],
	'{RECURRENCE_CLOSE_SECTION}' => $recCloseSectionStyle,
	'{RECURRENCE_OPEN_SECTION}' => $recOpenSectionStyle,
	'{RECURRENCE_MESSAGE}' => $recurrence_message,
	'{RECUR_TYPE_NONE}' => $lang_add_event_view['repeat_none'],
	'{RECUR_TYPE_NONE_CHECKED}' => empty($form['recur_type_select'])?"checked":"",
	'{RECUR_TYPE_1_CHECKED}' => (!empty($form['recur_type_select']) && $form['recur_type_select'] == 1 ? "checked":""),
	'{RECUR_EVERY}' => $lang_add_event_view['repeat_every'],
	'{RECUR_VAL_1}' => !empty($form['recur_val_1']) ? $form['recur_val_1'] : '',
	'{RECUR_TYPE_1_OPTIONS}' => $recur_type_1_options,
	'{RECUR_END_DATE_CAPTION}' => $lang_add_event_view['repeat_end_date_label'],
	'{RECUR_END_DATE_NONE_CHECKED}' => empty($form['recur_end_type'])?"checked":"",
	'{RECUR_END_DATE_NONE}' => $lang_add_event_view['repeat_end_date_none'],
	'{RECUR_END_DATE_COUNT_CHECKED}' => (!empty($form['recur_end_type']) && $form['recur_end_type'] == 1)?"checked":"",
	'{RECUR_END_DATE_COUNT}' => sprintf($lang_add_event_view['repeat_end_date_count'],'<input type="text" name="recur_end_count" id="recur_end_count" value="'.$form['recur_end_count'].'" size="2" class="textinput" />'),
	'{RECUR_END_DATE_UNTIL_CHECKED}' => (!empty($form['recur_end_type']) && $form['recur_end_type'] == 2)?"checked":"",
	'{RECUR_END_DATE_UNTIL}' => $lang_add_event_view['repeat_end_date_until'],
	'{RECUR_UNTIL_DAY_VAL}' => $recur_until_day_list,
	'{RECUR_UNTIL_MONTH_VAL}' => $recur_until_month_list,
	'{RECUR_UNTIL_YEAR_VAL}' => $recur_until_year_list,
	'{REC_ID}' => empty($form['rec_id']) ? '' : $form['rec_id'],
	'{DETACHED_FROM_REC}' => empty($form['detached_from_rec']) ? '' : $form['detached_from_rec'],
	'{OWNER_ID}' => empty($form['owner_id']) ? '' : $form['owner_id'],
	'{REGISTRATION_URL}' => empty($form['registration_url']) ? '' : $form['registration_url'],
	'{CANCEL_NAME}' => ($event_mode == 'add') ? 'cancel_add_event' : 'cancel_edit_event',
	'{CANCEL_MSG}' => $lang_general['back'],
	'{RECUR_EVERY}' => $lang_add_event_view['repeat_every'],
	'{RECUR_TYPE_1}' => empty($form['rec_type_select']) ? '' : $form['rec_type_select'],
	'{RECUR_END_TYPE}' => empty($form['recur_end_type']) ? '' : $form['recur_end_type'],
	'{RECUR_END_COUNT}' => empty($form['recur_end_count']) ? '' : $form['recur_end_count']
	,'{REC_TYPE_SELECT}' => empty($recTypeSelectHtml) ? '' : $recTypeSelectHtml // V 2.1.x : new recurrence options
	// daily recurrence options
	,'{REC_DAILY_PERIOD_LEADING_LABEL}' => $lang_add_event_view['repeat_every']
	,'{REC_DAILY_PERIOD_TRAILING_LABEL}' => $lang_add_event_view['repeat_days']
	,'{REC_DAILY_PERIOD}' => empty($form['rec_daily_period']) ? '' : $form['rec_daily_period']
	// weekly recurrence options
	,'{REC_WEEKLY_PERIOD_LEADING_LABEL}' => $lang_add_event_view['repeat_every']
	,'{REC_WEEKLY_PERIOD_TRAILING_LABEL}' => $lang_add_event_view['repeat_weeks']
	,'{REC_WEEKLY_PERIOD}' => empty($form['rec_weekly_period']) ? '' : $form['rec_weekly_period']
	,'{REC_WEEKLY_ON_DAY_CHECK_BOXES}' => $recTypeWeeklyOnDays
	,'{REC_WEEKLY_ON_DAY_CHECK_LABEL}' => $lang_add_event_view['rec_weekly_on']
	// monthly recurrence options
	,'{REC_MONTHLY_PERIOD_LEADING_LABEL}' => $lang_add_event_view['repeat_every']
	,'{REC_MONTHLY_PERIOD_TRAILING_LABEL}' => $lang_add_event_view['repeat_months']
	,'{REC_MONTHLY_PERIOD}' => empty($form['rec_monthly_period']) ? '' : $form['rec_monthly_period']
	,'{REC_MONTHLY_ON_DAY_NUMBER}' => empty($recMonthlyTypeOnDayNumber) ? '' : $recMonthlyTypeOnDayNumber
	,'{REC_MONTHLY_DAY_NUMBER}' => empty($form['rec_monthly_day_number']) ? '' : $form['rec_monthly_day_number']
	,'{REC_MONTHLY_ON_SPECIFIC_DAY}' => empty($recMonthlyTypeOnSpecificDay) ? '' : $recMonthlyTypeOnSpecificDay
	,'{REC_MONTHLY_DAY_ORDER}' => empty($recMonthlyDayOrder) ? '' : $recMonthlyDayOrder
	,'{REC_MONTHLY_DAY_TYPE}' => empty($recMonthlyDayType) ? '' : $recMonthlyDayType
	// yearly recurrence options
	,'{REC_YEARLY_PERIOD_LEADING_LABEL}' => $lang_add_event_view['repeat_every']
	,'{REC_YEARLY_PERIOD_TRAILING_LABEL}' => $lang_add_event_view['repeat_years']
	,'{REC_YEARLY_PERIOD}' => empty($form['rec_yearly_period']) ? '' : $form['rec_yearly_period']
	,'{REC_YEARLY_ON_DAY_NUMBER}' => empty($recYearlyTypeOnDayNumber) ? '' : $recYearlyTypeOnDayNumber
	,'{REC_YEARLY_DAY_NUMBER}' => empty($form['rec_yearly_day_number']) ? '' : $form['rec_yearly_day_number']
	,'{REC_YEARLY_ON_SPECIFIC_DAY}' => empty($recYearlyTypeOnSpecificDay) ? '' : $recYearlyTypeOnSpecificDay
	,'{REC_YEARLY_DAY_ORDER}' => empty($recYearlyDayOrder) ? '' : $recYearlyDayOrder
	,'{REC_YEARLY_DAY_TYPE}' => empty($recYearlyDayType) ? '' : $recYearlyDayType
	,'{REC_YEARLY_ON_MONTH_LABEL}' => $lang_add_event_view['rec_yearly_on_month_label']
	,'{REC_YEARLY_ON_MONTH}' => empty($recYearlyOnMonth) ? '' : $recYearlyOnMonth
	// end of recurrence
	,'{REC_RECUR_UNTIL}' => empty($recRecurUntil) ? '' : $recRecurUntil
	// common_event_id
	,'{COMMON_EVENT_ID}' => empty($commonEventId) ? '' : $commonEventId
	);

	// calculate show calendar sub-template
	if ($CONFIG_EXT['enable_multiple_calendars']) {
		// show the select list if showing the calendars
		$values = array( '{SEL_CALS_LABEL}' =>  $lang_add_event_view['event_cal'], '{SEL_CALS_VAL}' => $cal_list);
		$sub_template = template_eval( $template_add_event_form_show_calendar, $values);
		$params['{SHOW_CALENDAR_SUB_TEMPLATE}'] = $sub_template;
		$params['{DO_NOT_SHOW_CALENDAR_SUB_TEMPLATE}'] = '';
	} else {
		// insert a hidden field if not choice to the user
		$values = array( '{SEL_CALS_VAL}' => $cal_id);
		$sub_template = template_eval( $template_add_event_form_do_not_show_calendar, $values);
		$params['{SHOW_CALENDAR_SUB_TEMPLATE}'] = '';
		$params['{DO_NOT_SHOW_CALENDAR_SUB_TEMPLATE}'] = $sub_template;
	}

	// calculate show private event sub-template
	$user = & JFactory::getUser();
	if (!$user->guest) {
		// show the private field if user is logged in
		$values = array( '{PRIVATE_LABEL}' =>  $lang_add_event_view['privacy'], '{PRIVATE_VAL}' => $private);
		$sub_template = template_eval( $template_add_event_form_show_private, $values);
		$params['{SHOW_PRIVATE_EVENT_SUB_TEMPLATE}'] = $sub_template;
		$params['{DO_NOT_SHOW_PRIVATE_EVENT_SUB_TEMPLATE}'] = '';
	} else {
		// insert a hidden field if user not logged in
		$values = array( '{PRIVATE_LABEL}' =>  $lang_add_event_view['private_event'], '{PRIVATE_VAL}' => JCL_EVENT_PUBLIC);
		$sub_template = template_eval( $template_add_event_form_do_not_show_private, $values);
		$params['{SHOW_PRIVATE_EVENT_SUB_TEMPLATE}'] = '<td class="tableb">&nbsp;</td>';
		$params['{DO_NOT_SHOW_PRIVATE_EVENT_SUB_TEMPLATE}'] = $sub_template;
	}

	// calculate approval sub_template
	if (has_priv('approve')) {
		// user can approve events
		$values = array( '{AUTO_APPR_LABEL}' =>  $lang_add_event_view['auto_appr_event'], '{AUTO_APPR_STATUS}' => $auto_approve);
		$sub_template = template_eval( $template_add_event_form_show_auto_approve, $values);
		$params['{SHOW_APPROVE_EVENT_SUB_TEMPLATE}'] = $sub_template;
	} else {
		// user needs admin aproval for events
		$values = array( '{AUTO_APPR_LABEL}' =>  $lang_add_event_view['auto_appr_event'], '{AUTO_APPR_STATUS}' => $auto_approve);
		$sub_template = template_eval( $template_add_event_form_do_not_show_auto_approve, $values);
		$params['{SHOW_APPROVE_EVENT_SUB_TEMPLATE}'] = $sub_template;
	}

	// import captcha lib
	if ($CONFIG_EXT['enable_recaptcha']  && !has_priv('bypass_captcha')) {
		JPluginHelper::importplugin( 'jcalpro', 'jclrecaptcha');
		$params['{SHOW_CAPTCHA_SUB_TEMPLATE}'] = plgJcalproJclRecaptcha::getCaptcha();
	} else {
		$params['{SHOW_CAPTCHA_SUB_TEMPLATE}'] = '';
	}

	// setup cancel button
	//$return_to = JRequest::getString( 'return_to');
	$return_to = jclGetCookie( 'return_to');
	if (!empty( $return_to)) {
		$params['{RETURN_TO}'] = $return_to;
	} elseif ($event_mode == 'add') {
		$params['{RETURN_TO}'] =  $CONFIG_EXT['calendar_calling_page'];
		//jclSetCookie( 'return_to', $CONFIG_EXT['calendar_calling_page']);
	} else {
		$params['{RETURN_TO}'] = $CONFIG_EXT['calendar_calling_page'] . '&extmode=view&extid=' . (isset($form['extid'])?$form['extid']:"");
		//jclSetCookie( 'return_to',  $CONFIG_EXT['calendar_calling_page'] . '&extmode=view&extid=' . (isset($form['extid'])?$form['extid']:""));
	}

	echo template_eval($template_add_event_form, $params);
	endtable();

	// add javascript to initialize our form, but only if reccurence options are shown
	// ie : don't show if editing a detached or child event
	if (empty($form['rec_id'])) {
		$rec_types = array( 'none', 'daily', 'weekly', 'monthly', 'yearly');
		$js = 'window.addEvent( \'domready\', function() { jclShowRecOptions(\'' . $rec_types[$form['rec_type_select']] . '\');';
		// add radio box auto-selection when slecting a date in calendar
		$js .= '$(\'recur_end_count\').onchange=function () {jclSetChecked(\'recur_end_type_until\', false);jclSetChecked(\'recur_end_type_count\', true);};';
		$js .= '$(\'rec_recur_until\').onchange=function () {jclSetChecked(\'recur_end_type_until\', true);jclSetChecked(\'recur_end_type_count\', false);};';
		$js .= '});';
		$document = JFactory::getDocument();
		$document->addScriptDeclaration( $js);
	}
}

function display_cat_form($target, $extmode, $form) {
	/* Display category form */
	global $CONFIG_EXT, $template_cat_form, $THEME_DIR, $errors, $lang_cat_admin_data, $lang_general;

	$acl = &JFactory::getACL();
	// build category list

	$admin_auto_approve = (isset($form['adminapproved']) && $form['adminapproved'])?"checked":"";
	$user_auto_approve = (isset($form['userapproved']) && $form['userapproved'])?"checked":"";
	$cat_status = (isset($form['published']) && $form['published'])?"checked":"";

	if(!$errors) template_extract_block($template_cat_form, 'errors_row');


	switch($extmode) {
		case "add":
			$caption = $lang_cat_admin_data['add_cat'];
			break;
		case "edit":
			$caption = $lang_cat_admin_data['edit_cat']." [id{$form['cat_id']}] '{$form['cat_name']}'";
			break;
		default:
			$caption = $lang_cat_admin_data['add_cat'];
	}

	$groupA = $acl->get_group_children_tree( null, 'USERS', false );

	// $acl->get_group_children_tree translates (using JText::_) the usergroup
	// this breaks everything in other than English languages
	// based on the id, we must reset the usergroup to its original value
	// we do our own query, instead of using $acl->getGroup, as JAuthorization does not cache results
	if (!empty( $groupA)) {
		$db = & JFactory::getDBO();
		$query = 'select id, name from #__core_acl_aro_groups;';
		$db->setQuery( $query);
		$groupList = $db->loadAssocList( 'id');
	}

	foreach ( $groupA as $groupAKey => $groupAValue )
	{
		if (!empty( $groupList) && array_key_exists( $groupA[$groupAKey]->value, $groupList)) {
			$groupAValue->textEdit = $groupList[$groupA[$groupAKey]->value]['name'];
		} else {
			$groupAValue->textEdit = $groupA[$groupAKey]->text;
		}

		$groupAValue->textEdit = str_replace ( "&nbsp;", "", $groupAValue->textEdit );
		$groupAValue->textEdit = str_replace ( "-", "", $groupAValue->textEdit );
		$groupAValue->textEdit = str_replace ( ".", "", $groupAValue->textEdit );

		$groupAValue->textEdit =  strtolower ( $groupAValue->textEdit );

		$user_levels[$groupAValue->text] = $groupAValue->textEdit;
	}

	$value = $form['level'];

	$categories_select = '
		<select name="level" class="listbox">
	';

	foreach ($user_levels as $userlevel_name => $userlevel)
	{
		$categories_select .= "<option value=\"$userlevel\" " . ($value == $userlevel ? 'selected="selected"':'') . ">$userlevel_name</option>\n";
	}

	$categories_select .= '
</select>
';


	$params = array(
'{TARGET}' => $target,
'{MODE}' => $extmode,
'{CAT_ID}' => isset($form['cat_id'])?$form['cat_id']:"",
'{ERRORS}' => $lang_general['errors'],
'{ERROR_MSG}' => $errors,
'{CAT_DETAILS_CAPTION}' => $lang_cat_admin_data['general_info_label'],
'{CAT_NAME_LABEL}' => $lang_cat_admin_data['cat_name'],
'{CAT_MAIN_CAPTION}' => $caption,
'{CAT_NAME_VAL}' => isset($form['cat_name'])?$form['cat_name']:"",
'{DESC_LABEL}' => $lang_cat_admin_data['cat_desc'],
'{DESC_VAL}' => isset($form['description'])?$form['description']:"",
'{COLOR_LABEL}' => $lang_cat_admin_data['cat_color'],
'{COLOR}' => isset($form['color'])?$form['color']:"",
'{PICK_COLOR_ICON}' => str_replace('administrator', '', $CONFIG_EXT['calendar_url']).'images/icon-colorpicker.gif',
'{PICK_COLOR_LNK}' => str_replace('administrator', '', $CONFIG_EXT['calendar_url']).'include/colorpicker.php',
'{PICK_COLOR}' => $lang_cat_admin_data['pick_color'],
'{STATUS_LABEL}' => JTEXT::_( 'Published'),
'{CATEGORY_LABEL}' => $lang_cat_admin_data['category_label'],
'{CATEGORIES_SELECT}' => $categories_select,
'{STATUS_CHK}' => $cat_status,
'{STATUS_ACTIVE_LABEL}' => ''/*$lang_cat_admin_data['active_label']*/,
	//'{SUBMIT}' => $submit
	);

	echo template_eval($template_cat_form, $params);
	endtable();
}

/**
 * Edit or create a calendar
 *
 * @param unknown_type $target
 * @param unknown_type $extmode
 * @param unknown_type $form
 */
function display_cal_form($target, $extmode, $form) {
	/* Display calendar form */
	global $CONFIG_EXT, $template_cal_form, $THEME_DIR, $errors, $lang_cal_admin_data, $lang_general;

	$acl = &JFactory::getACL();
	// build category list

	$admin_auto_approve = (isset($form['adminapproved']) && $form['adminapproved'])?"checked":"";
	$user_auto_approve = (isset($form['userapproved']) && $form['userapproved'])?"checked":"";
	$cal_status = (isset($form['published']) && $form['published'])?"checked":"";

	if(!$errors) template_extract_block($template_cal_form, 'errors_row');


	switch($extmode) {
		case "add":
			$caption = $lang_cal_admin_data['add_cal'];
			break;
		case "edit":
			$caption = $lang_cal_admin_data['edit_cal']." [id{$form['cal_id']}] '{$form['cal_name']}'";
			break;
		default:
			$caption = $lang_cal_admin_data['add_cal'];
			break;
	}

	$groupA = $acl->get_group_children_tree( null, 'USERS', false );

	// $acl->get_group_children_tree translates (using JText::_) the usergroup
	// this breaks everything in other than English languages
	// based on the id, we must reset the usergroup to its original value
	// we do our own query, instead of using $acl->getGroup, as JAuthorization does not cache results
	if (!empty( $groupA)) {
		$db = & JFactory::getDBO();
		$query = 'select id, name from #__core_acl_aro_groups;';
		$db->setQuery( $query);
		$groupList = $db->loadAssocList( 'id');
	}

	foreach ( $groupA as $groupAKey => $groupAValue )
	{
		if (!empty( $groupList) && array_key_exists( $groupA[$groupAKey]->value, $groupList)) {
			$groupAValue->textEdit = $groupList[$groupA[$groupAKey]->value]['name'];
		} else {
			$groupAValue->textEdit = $groupA[$groupAKey]->text;
		}
		$groupAValue->textEdit = str_replace ( "&nbsp;", "", $groupAValue->textEdit );
		$groupAValue->textEdit = str_replace ( "-", "", $groupAValue->textEdit );
		$groupAValue->textEdit = str_replace ( ".", "", $groupAValue->textEdit );

		$groupAValue->textEdit =  JString::strtolower ( $groupAValue->textEdit );

		$user_levels[$groupAValue->text] = $groupAValue->textEdit;
	}

	$value = $form['level'];

	$calendars_select = '
		<select name="level" class="listbox">
	';

	foreach ($user_levels as $userlevel_name => $userlevel)
	{
		$calendars_select .= "<option value=\"$userlevel\" " . ($value == $userlevel ? 'selected="selected"':'') . ">$userlevel_name</option>\n";
	}

	$calendars_select .= '
		</select>
	';


	$params = array(
		'{TARGET}' => $target,
		'{MODE}' => $extmode,
		'{CAL_ID}' => isset($form['cal_id'])?$form['cal_id']:"",
		'{ERRORS}' => $lang_general['errors'],
		'{ERROR_MSG}' => $errors,
		'{CAL_DETAILS_CAPTION}' => $lang_cal_admin_data['general_info_label'],
		'{CAL_NAME_LABEL}' => $lang_cal_admin_data['cal_name'],
		'{CAL_MAIN_CAPTION}' => $caption,
		'{CAL_NAME_VAL}' => isset($form['cal_name'])?$form['cal_name']:"",
		'{DESC_LABEL}' => $lang_cal_admin_data['cal_desc'],
		'{DESC_VAL}' => isset($form['description'])?$form['description']:"",
		'{STATUS_LABEL}' => JTEXT::_( 'Published'),
		'{CALENDAR_LABEL}' => $lang_cal_admin_data['calendar_label'],
		'{CALENDARS_SELECT}' => $calendars_select,
		'{STATUS_CHK}' => $cal_status,
		'{STATUS_ACTIVE_LABEL}' => ''/*$lang_cat_admin_data['active_label']*/,
	//'{SUBMIT}' => $submit
	);

	echo template_eval($template_cal_form, $params);
	endtable();
}

// function to display a legend of categories
function display_cat_legend ($colspan = '', $today = false)
{
	global $CONFIG_EXT;

	$isPrint = JRequest::getInt( 'print', 0) == 1;
	if ($isPrint) {
		return;
	}

	$categories = get_active_categories( $applyMenuRestrictions = true);
	theme_cat_legend ($categories, $colspan, $today);
}

// HTML template for the list of categories and their corresponding colors
function theme_cat_legend ($categories, $colspan = '', $today = false)
{
	global $template_cat_legend, $CONFIG_EXT, $lang_general, $todayclr;
	if(!$colspan) $colspan = "1";

	$template_cat_legend1 = $template_cat_legend;
	$header_row = template_extract_block($template_cat_legend1, 'header_row');
	$start_col_row = template_extract_block($template_cat_legend1, 'start_col_row');
	$end_col_row = template_extract_block($template_cat_legend1, 'end_col_row');
	$today_row = template_extract_block($template_cat_legend1, 'today_row');
	$cats_row = template_extract_block($template_cat_legend1, 'cats_row');
	$empty_cell_row = template_extract_block($template_cat_legend1, 'empty_cell_row');
	$footer_row = template_extract_block($template_cat_legend1, 'footer_row');

	$columns = 4;

	$params = array(
		'{ROWS}' => $colspan
	);
	echo template_eval($header_row, $params);

	$cat_count = count($categories); //
	$rows = ceil(( $cat_count + 1) / $columns); // total number of rows
	$row = 0; // used to count rows in <tr> loop

	if ( $rows > 0 )
	{
		while($row < $rows) {
			echo $start_col_row;
			for($column=0;$column < $columns;$column++ ) {
				if($today && $column == 0 && $row == 0) {
					$params = array(
						'{TODAY}' => $lang_general['today'],
						'{COLOR}' => $todayclr
					);
					echo template_eval($today_row, $params);
				} elseif($cat_count) {
					if ( is_array ( $categories ) ) {
						list(,$category) = each($categories);
					}
					$sef_href = $CONFIG_EXT['calendar_calling_page'].'&extmode=cat&cat_id='.$category['cat_id'];
					if ( isset( $category['cat_ext'] ) && $category['cat_ext'] ) {
						$sef_href .= '&cat_ext='.$category['cat_ext'];
					}
					$sef_href = JRoute::_( $sef_href );
					$params = array(
						'{CAT_NAME}' => $category["cat_name"],
						'{CAT_LINK}' => 'href="'.$sef_href .'"',
						'{COLOR}' => $category['color']
					);
					echo template_eval($cats_row, $params);
					$cat_count--;
				} else  echo $empty_cell_row;
			}
			echo $end_col_row;
			$row++; // increase row number for next loop
		}
	}
	echo $footer_row;
}

// Eval a template (substitute vars with values)
function template_eval(&$template, &$vars)
{
	return strtr($template, $vars);
}


// Extract and return block '$block_name' from the template, the block is replaced by $subst
function template_extract_block(&$template, $block_name, $subst='')
{
	global $lang_system;

	if(!$template) return;
	$pattern = "#(<!-- BEGIN $block_name -->)(.*?)(<!-- END $block_name -->)#s";
	if ( !preg_match($pattern, $template, $matches)){
		die( sprintf( $lang_system['template_block_not_found'], $block_name, htmlspecialchars($template)));
	}
	$template = str_replace($matches[1].$matches[2].$matches[3], $subst, $template);
	return $matches[2];
}

// Highlight found keywords in a given string and return the processed string
function highlight($keyword,$string,$startTag,$endTag)
{
	$newString = "";
	$positions = array();
	$lastPos = 0;
	$stringLength = strlen($string);
	$length = strlen($keyword);
	$start = JString::strpos(JString::strtolower($string), JString::strtolower($keyword));

	if (is_integer($start)) {
		$positions[] = $start;
	}

	while(is_integer($start = JString::strpos(JString::substr(JString::strtolower($string),$start+$length), JString::strtolower($keyword))))
	{
		if (is_integer($start)) {
			$count=count($positions) - 1;
			$start = $positions[$count]+$start+$length;
			$positions[] = $start;
		}
	}

	if(count($positions))
	{
		foreach($positions as $pos) {
			$newString .= JString::substr($string,$lastPos,$pos - $lastPos).$startTag.JString::substr($string,$pos,$length).$endTag;
			$lastPos = $pos +$length;
		}
	}

	$newString .= JString::substr($string,$lastPos,$stringLength - $lastPos);
	return $newString;

}

function colorHighlight($hexColor) {
	// highlights a color by increasing it's luminosity
	//$temp = hexdec(substr($hexColor, 1)) - hexdec("140A04");
	//return "#".dechex($temp);
}

/**
 * NOTE : "local" time here does not mean anything, just current timestamp
 *
 * @return unknown
 */
function extcal_get_local_time () {

	static $now = null;

	if (is_null( $now)) {
		$now = time();
	}

	return $now;
}

/*
 * Turns user hours, minutes, seconds, etc  into a UTC date, formatted for db.
 * This is dst safe
 */
function jcUserTimeToUTC($h, $m, $s, $mo, $d, $y, $format = '%Y-%m-%d %H:%M:%S') {
	$ts = gmmktime($h, $m, $s, $mo, $d, $y);
	$dst = jclGetDst( $ts);
	return jcUTCDateToFormatNoOffset( TSUTCToUser( $ts, $dst), $format);
}


/*
 * Turns UTC hours, minutes, seconds, etc  into a UTC date, formatted for db.
 * This is dst safe
 */
function jcTimeToUTC($h, $m, $s, $mo, $d, $y, $format = '%Y-%m-%d %H:%M:%S') {
	$ts = gmmktime($h, $m, $s, $mo, $d, $y);
	$dst = jclGetDst( $ts);
	return jcUTCDateToFormatNoOffset( $ts - $dst * 3600, $format);
}

/*
 * Turns UTC hours, minutes, seconds, etc  into a UTC date, formatted for db.
 * dst not used
 */
function jcTimeToUTCNoDst($h, $m, $s, $mo, $d, $y, $format = '%Y-%m-%d %H:%M:%S') {
	$ts = gmmktime($h, $m, $s, $mo, $d, $y);
	return jcUTCDateToFormatNoOffset( $ts, $format);
}

/*
 * Turns a timestamp into a UTC date, formatted for db.
 * This is dst safe
 */
function jcTSToUTC( $ts, $format = '%Y-%m-%d %H:%M:%S') {
	// compensate for dst
	$dst = jclGetDst( $ts);
	$ts = $ts - 3600 * $dst;
	return jcUTCDateToFormatNoOffset( $ts, $format);
}

/**
 * Returns the timestamp of the same hour in UTC time
 * ie : if incoming ts is ts of 20:00 in server time zone
 * then function returns ts of 20:00 UTC
 *
 * @param unix timestamp $ts
 */
function TSServerToUTC( $ts) {

	global $CONFIG_EXT;

	$offset = jcGetServerOffset($ts) * 3600;
	if (!empty($offset)) {
		$ts += $offset;
	}

	return $ts;
}

/**
 * Returns the timestamp of the same hour in server time
 * ie : if incoming ts is ts of 20:00 in UTC time zone
 * then function returns ts of 20:00 in server time zone
 *
 * @param unix timestamp $ts
 */
function TSUTCToServer( $ts) {

	global $CONFIG_EXT;

	$offset = jcGetServerOffset($ts) * 3600;
	if (!empty($offset)) {
		$ts -= $offset;
	}
	return $ts;
}

/**
 * Returns the timestamp of the same hour in UTC time
 * ie : if incoming ts is ts of 20:00 in user time zone
 * then function returns ts of 20:00 UTC
 *
 * @param unix timestamp $ts
 */
function TSUserToUTC( $ts, $isDst) {

	global $mainframe, $CONFIG_EXT;

	$isDst = is_null($isDst) ? $CONFIG_EXT['isDst'] : $isDst;
	$offset = ($mainframe->getCfg( 'offset') + ($isDst ? 1 : 0) ) * 3600;
	if (!empty($offset)) {
		$ts += $offset;
	}
	return $ts;
}

/**
 * Returns the timestamp of the same hour in user time
 * ie : if incoming ts is ts of 20:00 in UTC time zone
 * then function returns ts of 20:00 in user time zone
 *
 * @param unix timestamp $ts
 */
function TSUTCToUser( $ts, $isDst) {

	global $mainframe, $CONFIG_EXT;

	$isDst = is_null($isDst) ? $CONFIG_EXT['isDst'] : $isDst;
	$offset = ($mainframe->getCfg( 'offset') + ( $isDst ? 1 : 0) ) * 3600;
	if (!empty($offset)) {
		$ts -= $offset;
	}
	return $ts;
}

function TSUserToServer ($ts) {

	$dst = jclGetDst( $ts);
	$ts = TSUTCToServer( TSUserToUTC( $ts, $dst));
	return $ts;

}

function TSServerToUser ($ts) {

	$dst = jclGetDst( $ts);
	$ts = TSUTCToUser( TSServerToUTC( $ts), $dst);
	return $ts;

}

/**
 * Compensate for possible dst on the time of
 * the incoming timestamp. If dst is on, then ts is
 * reduced by one hour. Hence, when displayed as a date time,
 * the time will be the same as if there was no dst
 *
 * @param integer $ts
 * @return integer
 */
function jclCompensateTSForDst( $ts) {
	$dst = jclGetDst($ts);
	$ts -= $dst ? 3600 : 0;
	return $ts;
}

/**
 * Compensate for dst in the opposite direction of
 * jclCompensateForDst(). Needed when calculating series
 * if starting event has been compensated
 *
 * @param <type> $ts timestamp of the event
 */
function jclInverseCompensateTSForDst( $ts) {

	$dst = jclGetDst($ts);
	$ts += $dst ? 0 : 3600;
	return $ts;
}

/**
 * Returns time stamp of 00:00 the same day
 * as the incoming timestamp considered a user time
 *
 * @param int $ts
 */
function startOfDayInUserTime( $ts) {

	global $CONFIG_EXT;

	// find about current day in user time based on incoming timestamp
	$d = jcUTCDateToFormat( $ts, '%d');
	$m = jcUTCDateToFormat( $ts, '%m');
	$y = jcUTCDateToFormat( $ts, '%Y');
	// find ts of 00:00:00 on that day

	$dateString = "$y-$m-$d 00:00:00 " . $CONFIG_EXT['site_timezone'];
	$date = new DateTime( $dateString);
	$ts = $date->format('U');
	return $ts;
}

/**
 * Returns time stamp of 00:00 the same day
 * as the incoming timestamp considered a UTC time
 *
 * @param int $ts
 */
function startOfDayInUTCTime( $ts) {

	global $CONFIG_EXT;

	// will be in user time as no offset is specified
	$currentDate = new JDate( $ts);
	$currentDate->setOffset( jcGetServerOffset($ts));

	// remove hours, minutes, seconds
	$date = $currentDate->toFormat( '%Y-%m-%d');

	// make a timestamp, and compensate for server vs user time
	$ts = TSServerToUTC( strtotime( $date));

	return $ts;
}

/**
 * Prepare a date supposed to be UTC to be displayed
 * Mostly used when displaying a date taken straight from database
 *
 * @param mixed $date
 * @param String $mask
 */
function jcUTCDateToFormat( $date, $mask='') {

	if (empty( $date)) {
		return '';
	}

	// format date
	$jcDate = new JDate( $date);
	global $mainframe;
	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat() method
	// as joomla uses strftime in that method (strftime uses server offset).
	// When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation so we don't need
	// to compensate for it
	$compensateServer = 0;
	if (is_numeric( $date)) {
		global $CONFIG_EXT;
		$compensateServer = -1 * jcGetServerOffset( $date);
	}
	// is dst on on that particular date ?
	if (is_numeric( $date)) {
		$ts = $date;
	} else {
		$ts = strtotime( $date . ' UTC');
	}
	$dst = jclGetDst( $ts);

	$jcDate->setOffset( $compensateServer + $mainframe->getCfg( 'offset') + $dst);
	return $jcDate->toFormat( $mask);
}

function jcGetServerOffset( $ts) {

	// calculate local server time offset
	$serverOffset = date( 'O', $ts);  // + 0200 becomes 200, - 0330 becomes -330
	$serverHoursOffset = intval($serverOffset/100);
	$serverMinutesOffset = $serverOffset - $serverHoursOffset *100;
	$serverOffset = ($serverHoursOffset * 3600 + $serverMinutesOffset * 60) / 3600;
	return $serverOffset;
}

/**
 * Prepare a date supposed to be UTC to be used in calculation
 * User offset is not applied
 *
 * @param mixed $date
 * @param String $mask
 */
function jcUTCDateToFormatNoOffset( $date, $mask='') {

	if (empty( $date)) {
		return '';
	}

	// format date
	$jcDate = new JDate( $date);
	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	if (is_numeric( $date)) {
		global $CONFIG_EXT;
		$jcDate->setOffset( -1 * jcGetServerOffset($date));
	}
	return $jcDate->toFormat( $mask);
}

/**
 * Prepare a date supposed to be UTC to be used in calculation
 * User offset is not applied
 *
 * @param mixed $date
 * @param String $mask
 */
function jcUTCDateToFormatNoOffsetDst( $date, $mask='') {

	if (empty( $date)) {
		return '';
	}

	// format date
	$jcDate = new JDate( $date);
	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	$compensateServer = 0;
	if (is_numeric( $date)) {
		global $CONFIG_EXT;
		$compensateServer = -1 * jcGetServerOffset($date);
	}
	// is dst on on that particular date ?
	if (is_numeric( $date)) {
		$ts = $date;
	} else {
		$ts = strtotime( $date . ' UTC');
	}
	$dst = jclGetDst( $ts);

	$jcDate->setOffset( $compensateServer + $dst);
	return $jcDate->toFormat( $mask);
}

/**
 * Prepare a date supposed to be in user time to be displayed
 *
 * @param mixed $date
 * @param String $mask
 */
function jcUserDateToFormat( $date, $mask='') {

	global $mainframe, $CONFIG_EXT;

	if (empty( $date)) {
		return '';
	}

	$jcDate = new JDate( $date, is_numeric( $date) ? 0 : $mainframe->getCfg( 'offset'));

	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	$compensateServer = 0;
	if (is_numeric( $date)) {
		$compensateServer = -1 * jcGetServerOffset($date);
	}

	// is dst on on that particular date ?
	if (is_numeric( $date)) {
		$ts = $date;
	} else {
		$ts = strtotime( $date . jcTimeZoneToText( $mainframe->getCfg( 'offset')));
	}
	$dst = jclGetDst( $ts);

	// now compensate for user time
	$jcDate->setOffset( $compensateServer + $mainframe->getCfg( 'offset') + $dst);

	return $jcDate->toFormat( $mask);
}

/**
 * Turn date supposed to be in user time into a unix timestamp
 *
 * @param mixed $date
 */
function jcUserDateToTS( $date) {

	global $mainframe, $CONFIG_EXT;

	if (empty( $date)) {
		return '';
	}

	$jcDate = new JDate( $date, is_numeric( $date) ? 0 : $mainframe->getCfg( 'offset'));

	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	$compensateServer = 0;
	if (is_numeric( $date)) {
		$compensateServer = -1 * jcGetServerOffset($date);
	}

	// is dst on on that particular date ?
	if (is_numeric( $date)) {
		$ts = $date;
	} else {
		$ts = strtotime( $date . jcTimeZoneToText( $mainframe->getCfg( 'offset')));
	}
	$dst = jclGetDst( $ts);

	// now compensate for user time
	$jcDate->setOffset( $compensateServer + $mainframe->getCfg( 'offset') + $dst);

	return $jcDate->toUnix();
}

/*
 * convert from 8.75 to 845 ie : 8 hours and 3/4 of an hour
 * also include a rough fix for php rounding error
 */
function jcOffsetToText( $offset, $addSign = false, $withColon = false, $zeroPad = false) {
	$hours = (int) $offset;
	$minutes = $offset - $hours;
	$minutes = $minutes * 60;
	$text = $hours . '.' . $minutes;
	$t = (string)intval( round(10000000 * $text + 0.5) / 100000);
	if ($zeroPad) {
		$t = strlen($t) == 2 ? ('0' . $t) : $t;
		$t = strlen($t) == 3 ? ('0' . $t) : $t;
	}
	if ($addSign) {
		$t = (intval($t) > 0 ? '+' : '-') . $t;
	}
	if ($withColon) {
		$t = substr( $t, 0, strlen($t)-2) . ':' . substr( $t, -2);
	}

	return $t;
}

function jcTimeZoneToText( $offset) {
	if (empty( $offset)) {
		$out = ' UTC';
	}  else {
		$out = sprintf( '%+05d', jcOffsetToText( $offset));
	}
	return $out;
}

/**
 * Prepare a date supposed to be in server time to be displayed
 * (ie we turn it into user time)
 * Mostly used when displaying a timestamp obtained through a mktime()
 *
 * @param mixed $date
 * @param String $mask
 * @param float $timezone in hours
 */
function jcServerDateToFormat( $date, $mask='') {

	global $mainframe;
	if (empty( $date)) {
		return '';
	}

	// format date
	$jcDate = new JDate( $date, is_numeric( $date) ? 0 : jcGetServerOffset(strtotime($date)));

	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	$compensateServer = 0;
	if (is_numeric( $date)) {
		$compensateServer = -1 * jcGetServerOffset($date);
	}

	// is dst on on that particular date ?
	if (is_numeric( $date)) {
		$ts = $date;
	} else {
		$ts = strtotime( $date . ' UTC');
	}
	$dst = jclGetDst( $ts);

	// now compensate for user time
	$jcDate->setOffset( $compensateServer + $mainframe->getCfg('offset') + $dst);

	return $jcDate->toFormat( $mask);
}

/**
 * Prepare a date supposed to be in server time to be used in calculation
 * User offset is not applied
 *
 * @param mixed $date
 * @param String $mask
 */
function jcServerDateToFormatNoOffset( $date, $mask='') {

	global $mainframe;
	if (empty( $date)) {
		return '';
	}

	// format date
	$jcDate = new JDate( $date, is_numeric( $date) ? 0 : jcGetServerOffset(strtotime($date)));

	// if we supply a timestamp, compensate for server offset,
	// otherwise we will be off when using the toFormat) method
	// as joomla uses strftime. When $date is a string,
	// the JDate object timestamp value is calculated using mktime
	// thus introducing the server offset in the equation
	$compensateServer = 0;
	if (is_numeric( $date)) {
		$compensateServer = -1 * jcGetServerOffset($date);
	}

	// now compensate for user time
	$jcDate->setOffset( $compensateServer);

	return $jcDate->toFormat( $mask);
}

/**
 * Simple wrapper
 *
 * @param unknown_type $ts
 * @param unknown_type $format
 * @return unknown
 */
function jcTSToFormat( $ts, $format) {

	$jcDate = new JDate( $ts);
	return $jcDate->toFormat($format);
}

/**
 * Turn a date supposed to be UTC into a unix timestamp
 *
 * @param mixed $date
 */
function jcUTCDateToTs( $date) {

	if (empty( $date)) {
		return false;
	}

	// format date
	$jcDate = new JDate( $date);
	$ts = $jcDate->toUnix();
	$ts = TSServerToUTC( $ts);

	return $ts;
}

function format_text($string,$no_slashes = false,$ucwords = false) {
	global $CONFIG_EXT;

	// processes a given text and returns it
	$string = ($ucwords)?ucwords($string):$string;
	if ( !$CONFIG_EXT['addevent_allow_html'] )
	{
		$string = nl2br($string);
	}
	if($no_slashes)
	$string = stripslashes($string);
	return $string;
}

function sub_string($input,$length,$suffix) {

	$string = html_entity_decode($input, ENT_COMPAT, 'UTF-8');  // J 1.5.x+ needs utf-8

	if( !empty( $string ) && $length>0 )
	{
		$isText = true;
		$ret = "";
		$i = 0;

		$currentChar = "";
		$lastSpacePosition = -1;
		$lastChar = "";

		$tagsArray = array();
		$currentTag = "";
		$tagLevel = 0;

		$noTagLength = JString::strlen( strip_tags( $string ) );

		// Parser loop
		for( $j=0; $j<JString::strlen( $string ); $j++ )
		{

			$currentChar = JString::substr( $string, $j, 1 );
			$ret .= $currentChar;

			// Lesser than event
			if( $currentChar == "<") $isText = false;

			// Character handler
			if( $isText )
			{

				// Memorize last space position
				if( $currentChar == " " ) { $lastSpacePosition = $j; }
				else { $lastChar = $currentChar; }

				$i++;
			}
			else
			{
				$currentTag .= $currentChar;
			}

			// Greater than event
			if( $currentChar == ">" )
			{
				$isText = true;

				// Opening tag handler
				if( ( strpos( $currentTag, "<" ) !== FALSE ) &&
				( strpos( $currentTag, "/>" ) === FALSE ) &&
				( strpos( $currentTag, "</") === FALSE ) )
				{

					// Tag has attribute(s)
					if( strpos( $currentTag, " " ) !== FALSE )
					{
					$currentTag = JString::substr( $currentTag, 1, strpos( $currentTag, " " ) - 1 );
					}
					else
					{
					// Tag doesn't have attribute(s)
					$currentTag = JString::substr( $currentTag, 1, -1 );
					}

					array_push( $tagsArray, $currentTag );

				}
				else if( strpos( $currentTag, "</" ) !== FALSE )
				{

					array_pop( $tagsArray );
				}

				$currentTag = "";
			}

			if( $i >= $length)
			{
				break;
			}
		}

		// Cut HTML string at last space position
		if( $length < $noTagLength )
		{
			if( $lastSpacePosition != -1 )
			{
				$ret = JString::substr( $string, 0, $lastSpacePosition );
				$ret .= $suffix;
			}
			else
			{
				$ret = JString::substr( $string, 0, $j+1 );
			}
		}

		// Close broken XHTML elements
		while( sizeof( $tagsArray ) != 0 )
		{
			$aTag = array_pop( $tagsArray );
			$ret .= "</" . $aTag . ">\n";
		}

	}
	else
	{
		$ret = "";
	}

	return( $ret );
}

function html_entities($string) {
	// replaces all html entities except 'double' encoding of the ampersands that are already existant
	$translation_table = get_html_translation_table (HTML_ENTITIES,ENT_QUOTES);
	$translation_table[chr(38)] = '&';
	return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,4};)/","&amp;" , strtr($string, $translation_table));
}

function html_decode($string)
{
	$trans_tbl = get_html_translation_table(HTML_ENTITIES);
	$trans_tbl = array_flip($trans_tbl);
	return strtr($string, $trans_tbl);
}


function strip_querystring($url) {
	// takes a URL and returns it without the querystring portion
	if ($commapos = strpos($url, '?')) {
		return JString::substr($url, 0, $commapos);
	} else {
		return $url;
	}
}

function get_referer() {
	// returns the URL of the HTTP_REFERER without the querystring portion
	$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
	return $referer;
	//  return strip_querystring($referer);
}

function extcal_dir_list($dirname)
{
	$handle=opendir($dirname);
	while ($file = readdir($handle))
	{
		if($file=='.'||$file=='..'||is_dir($dirname.$file)) continue;
		$result_array[]=$file;
	}
	closedir($handle);
	return $result_array;
}

function extcal_get_picture_file($file) {
	global $CONFIG_EXT;

	if($file) {
		if(file_exists($CONFIG_EXT['MINI_PICS_DIR'].$file.".jpg")) $file = $file.".jpg";
		elseif(file_exists($CONFIG_EXT['MINI_PICS_DIR'].$file.".gif")) $file = $file.".jpg";
		else $file = $CONFIG_EXT['mini_cal_def_picture'];
	} else $file = $CONFIG_EXT['mini_cal_def_picture'];
	return $file;
}

function process_content($data)
{
	/* Process message data with various conversions */

	global $CONFIG_EXT, $CFG, $mainframe;

	if ($CONFIG_EXT['addevent_allow_html'])
	{
		$data = sh_html_entity_decode ( $data);  // J 1.5.x+ needs utf-8
		if ( $CONFIG_EXT['allow_javascript_in_event_urls'] ) $data = preg_replace("/http:\/\/javascript:(.*?) target=\"".$CONFIG_EXT['url_target_for_events']."\"/si", "javascript:$1", $data);
		/* adding a space to beginning */
		$data = ' '.$data;
		$data = preg_replace("#([\n ])([a-z]+?)://([^,<> \n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"".$CONFIG_EXT['url_target_for_events']."\">\\2://\\3</a>", $data);
		$data = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,<> \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"".$CONFIG_EXT['url_target_for_events']."\">www.\\2.\\3\\4</a>", $data);
		$data = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([^,<> \n\r]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $data);
		/* Remove space */
		$data = JString::substr($data, 1);

		// trigger content plugins event on description
		$params      =& $mainframe->getParams('com_jcalpro');
		$data = JHTML::_('content.prepare', $data, $params);

	}
	
	$data = preg_replace( '#<[\s]*meta#isU', '', $data);
	return $data;

}

function get_week_number($day, $month, $year) {
	global $CONFIG_EXT;

	if($CONFIG_EXT['day_start']) $week = strftime( '%W', mktime(0, 0, 0, $month, $day, $year));
	else $week = strftime( '%U', mktime(0, 0, 0, $month, $day, $year));
	$yearBeginWeekDay = strftime( '%w', mktime(0, 0, 0, 1, 1, $year));
	$yearEndWeekDay  = strftime( '%w', mktime(0, 0, 0, 12, 31, $year));
	// make the checks for the year beginning
	if($yearBeginWeekDay > 1 && $yearBeginWeekDay < 5) {
		// First week of the year begins during Monday-Thursday.
		// Currently first week is 0, so all weeks should be incremented by one
		$week++;
	} else if($week == 0) {
		// First week of the year begins during Friday-Sunday.
		// First week should be 53, and other weeks should remain as they are
		$week = 53;
	}
	// make the checks for the year end, these only apply to the weak 53
	if($week == 53 && $yearEndWeekDay > 0 && $yearEndWeekDay < 5) {
		// Currently the last week of the year is week 53.
		// Last week of the year begins during Friday-Sunday
		// Last week should be week 1
		$week = 1;
	}
	// return the correct ISO 8601:1988 week
	return $week;
}

// Get the week's first and last days
function get_week_bounds($day, $month, $year) {
	global $CONFIG_EXT;
	if($CONFIG_EXT['day_start']) { // if monday is the first day
		$dayOfWeek = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day,$year), '%w') - 1; // weekday as a decimal number [0,6], with 0 representing Monday
		$dayOfWeek = ($dayOfWeek == -1)?6:$dayOfWeek;
	}
	else  // if sunday is the first day

	$dayOfWeek = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day,$year), '%w'); // weekday as a decimal number [0,6], with 0 representing Sunday
	// first day of week
	$offset = $dayOfWeek;
	$week = Array();
	$week['first_day']['year'] = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day - $offset,$year), '%Y' );
	$week['first_day']['month'] = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day - $offset,$year), '%m');
	$week['first_day']['day'] = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day - $offset,$year), '%d');
	$week['first_day']['dayOfWeek'] = $dayOfWeek;
	// last day of week
	$offset=(6 - $dayOfWeek);
	$week['last_day']['year']  = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day + $offset,$year), '%Y' );
	$week['last_day']['month']  = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day + $offset,$year), '%m');
	$week['last_day']['day']  = jcUTCDateToFormatNoOffset( gmmktime(12,0,0,$month,$day + $offset,$year), '%d');
	$week['last_day']['dayOfWeek'] = $offset;
	return $week;
}

function timetoduration ($seconds, $periods = null) {
	// Force the seconds to be numeric
	$seconds = (int)$seconds;
	// Define our periods
	if (!is_array($periods)) {
		$periods = array (
		//'years'     => 31556926,
		//'months'    => 2629743,
		//'weeks'     => 604800,
		'days'      => 86400,
		'hours'     => 3600,
		'minutes'   => 60,
		//'seconds'   => 1
		);
	}
	// Loop through
	foreach ($periods as $period => $value) {
		$count = floor($seconds / $value);
		$values[$period] = $count;
		if ($count == 0) {
			continue;
		}
		$seconds = $seconds % $value;
	}
	// Return array
	if (empty($values)) {
		$values = null;
	}

	return $values;
}

function datestoduration ($start_date, $end_date, $periods = null) {

	$seconds = strtotime($end_date) - strtotime($start_date);
	// Force the seconds to be numeric
	$seconds = (int)$seconds;
	// Define our periods
	if (!is_array($periods)) {
		$periods = array (
		//'years'     => 31556926,
		//'months'    => 2629743,
		//'weeks'     => 604800,
		'days'      => 86400,
		'hours'     => 3600,
		'minutes'   => 60,
		//'seconds'   => 1
		);
	}
	// Loop through
	foreach ($periods as $period => $value) {
		$count = floor($seconds / $value);
		$values[$period] = $count;
		if ($count == 0) {
			continue;
		}
		$seconds = $seconds % $value;
	}
	// Return array
	if (empty($values)) {
		$values = null;
	}

	// fix the all day value
	if(date("G:i",strtotime($end_date)) == "23:59") {
		$values['days']++;
		$values['hours'] = 0;
		$values['minutes'] = 0;
	}

	return $values;
}

// Load and parse the template.html file
function jcload_template()
{
	global $mainframe, $THEME_DIR, $CONFIG_EXT, $template_header, $template_footer, $lang_general, $lang_add_event_view, $lang_system;

	if ( !file_exists($CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php" ) ) {
		$CONFIG_EXT['theme'] = 'default';
	}

	if (file_exists($CONFIG_EXT['FS_PATH']."themes/".$CONFIG_EXT['theme']."/" . TEMPLATE_FILE)) {
		$template_file = $CONFIG_EXT['FS_PATH']."themes/".$CONFIG_EXT['theme']."/" . TEMPLATE_FILE;

		if ($mainframe->isAdmin()) {
			// insert script to open a new window for the colorpicker
			$jsFile = JURI::root() . 'components/com_jcalpro/include/colorpicker.js';
			$document = & JFactory::getDocument();

			$document->addScript( $jsFile);
			$js_template_file = '';
		} else {
			$js_template_file = JRoute::_('components/com_jcalpro/themes/'.$CONFIG_EXT['theme']."/" . TEMPLATE_JS_FILE);
		}
	} else die(sprintf( $lang_system['template_file_not_found'], TEMPLATE_FILE));

	// add header javascript link
	$format = JRequest::getCmd( 'format');

	// read js template
	if (!empty( $js_template_file) && $format != 'raw') {
		$templateJsPath = JURI::base() . 'components/com_jcalpro/themes/'.$CONFIG_EXT['theme'];
		$document = &JFactory::getDocument();
		$document->addScript( $js_template_file);

		// a bit more javascript init
		// repeat event messages
		$more_js = '
			var recurEventMsg = "' . $lang_add_event_view['event_repeat_msg'] . '";
			var noRecurEventMsg = "' . $lang_add_event_view['event_no_repeat_msg'] . '";

			// cookie variables
			var extcal_cookie_id = "' . $CONFIG_EXT['cookie_name'] . '";
			var extcal_cookie_path = "' . $CONFIG_EXT['cookie_path'] . '";
			var extcal_cookie_domain = "";
			var jcl_base_themes_dir = "' . $templateJsPath . '";
			document.imageArray = new Array(10);
			preloadImage(0, jcl_base_themes_dir + "/images/addsign.gif",
				jcl_base_themes_dir + "/images/addsign_a.gif");

			';
		$document->addScriptDeclaration( "<!--\n" . $more_js . "\n//-->");
	}

	// read html template
	$template = fread(fopen($template_file, 'r'), filesize($template_file));

	// Header processing
	$cal_pos = strpos($template, "{CONTENT}");
	$template_header = JString::substr($template, 0, $cal_pos);

	$signature = '<a title="JCal Pro, the Joomla calendar" href="http://dev.anything-digital.com/" target="_blank">JCal Pro Calendar ' . CALENDAR_VERSION . '</a>';

	if(strpos(" ".$lang_general['signature'],"%s")) {
		$signature = sprintf($lang_general['signature'], $signature);
	} else {
		$signature = $lang_general['signature'] . " " . $signature;
	}
	$add_signature = '<div class="atomic atomic_colored">'.$signature.'</div><br />';
	
	if (@$CONFIG_EXT['disable_footer']) {
		$add_signature = '';
	}

	// Footer processing
	$cal_pos = strpos($template, "{CONTENT}");
	$template = str_replace("{CONTENT}", $add_signature ,$template);
	$template_footer = JString::substr($template, $cal_pos);

}

function get_version_readable($version = "200.00") {
	// returns a readable version (Major.Minor.CVS) out of a string version
	$matches = explode(".",$version);
	$major_version = intval((int)$matches[0]/100);
	$minor_version = $major_version * 100 - intval($matches[0]);
	$cvs_version = intval($matches[1]);
	return $major_version.".".$minor_version.".".$cvs_version;
}

/**
 returns a datetime string, filled with current time in UTC zone
 */
function getLastUpdatedDateTime() {

	global $CONFIG_EXT;

	// current date time in UTC
	return jcServerDateToFormatNoOffset( extcal_get_local_time(), '%Y-%m-%d %H:%M:%S');
}

/**
 * Store a new object in database
 *
 * @param object $event an object which properties are the event fields
 * @return 0 if an error happened, insert id if success
 */
function storeNewEvent( $event) {

	global $CONFIG_EXT, $mainframe, $lang_add_event_view;

	$db = &JFactory::getDBO();
	// create public id : in special cases, the common_event_id may already exists, even for a new event
	// for instance when importing from an iCal calendar, or from another source
	$event->common_event_id = empty( $event->common_event_id) ? jclCreateEventCommonId( $event) : $event->common_event_id;

	// add a timestamp
	$event->last_updated = getLastUpdatedDateTime();

	// $event has been created so that all properties match a db column
	$properties = get_object_vars( $event);

	$eventId = false;

	// prepare query with object properties
	if (!empty( $properties)) {

		// need to create an intermediate event of class JCalEvent
		// so that Joomfish can work with it
		// JF does not handle UPDATE queries, so we have to use updateObject(),
		// which only accepts JTable descendant objects
		// for historical reasons, our $event is a StdClass, and it would
		// be too large and bug-prone work to change that now.
		// will have to wait for jcp3 to do it properly
		$dbEvent = new JCalEvent();
		foreach( $properties as $key => $value) {
			if (substr( $key, 0, 1) != '_') {
				$dbEvent->$key = $value;
			}
		}

		$db->insertObject($CONFIG_EXT['TABLE_EVENTS'], $dbEvent, 'extid');

		// if no error, return last insert id
		$eventId = $db->getErrorNum() ? 0 : $dbEvent->extid;

		// if Joomfish is active, and we are updating an existing recurring event
		// we must restore all the other versions of the same event
		// in other languages. We have stored them before deleting
		// the events, so hopefully we have kept all data we need
		// the base event has already been created above, so we can now
		// fix the "other languges" translations

		// if this is a recurring event child, update other languages with stored values
		if ($eventId && !empty($event->rec_id)) {
			// if not multilingual, nothing to do
			$conf =& JFactory::getConfig();
			$IsMultiLingual = !is_null( $conf->getValue( 'multilingual_support', null));
			if ($IsMultiLingual) {
				// site is multlingual, fetch list of active languages
				$languages = JoomFishManager::getLanguages($active = true);

				// if more than one language, we need to store language variants
				if (!empty( $languages) && count( $languages) > 1) {
					$modified = JFactory::getDate();
					$user = JFactory::getUser();
					$curLanguage = JFactory::getLanguage();
					$defaultLanguageCode = $conf->getValue( 'config.defaultlang');
					foreach( $languages as $language) {
					if ($curLanguage->getTag() != $language->code) {
						// retrieve stored data (we want to retrieve stored translation for the
						// parent event, not the child, hence we use rec_id, not extid
						$variants = setGetData( md5( $event->rec_id . $language->code));
						if (!is_null( $variants)) {
							foreach( $variants as $key => $value) {
								if (!empty( $value)) {
									if ($language->code == $defaultLanguageCode) {
						// we must update the main jcal event table
						$sql = "update " . $db->NameQuote($CONFIG_EXT['TABLE_EVENTS']) . 'set ' . $db->NameQuote($key) . '=' . $db->Quote($value) . ' '
						. 'where extid=' . $db->quote($eventId);
									} else {
						// we must the joomfish translation table with the original content
						$sql= "INSERT INTO #__jf_content (language_id, reference_id, reference_table, reference_field, value, original_value, original_text, modified, modified_by, published) "
						. " values (". $db->quote($language->id) . ", " . $db->quote($eventId) . ", " . $db->quote('jcalpro2_events') . ', ' . $db->Quote($key)
						. ", " . $db->quote($value) . ", " . $db->quote(md5($value)) . ", '', " . $db->quote($modified->toMysql()) . ", " . $user->id . ', 1)';
									}
									$db->setQuery($sql);
									$db->query();
								}
							}
						}
					}
					}
				}
			}
		}

	}

	return $eventId;
}

function setGetData( $id, $data = null) {

	static $_storedData = array();

	// are we reading or storing ?
	if (!is_null( $data)) {
		// storing data
		$_storedData[$id] = $data;
	}

	// return stored data
	return empty($_storedData[$id]) ? null : $_storedData[$id];
}


function getLanguageVariantsColumns() {

	static $_variants = array('title', 'description', 'contact', 'url', 'registration_url', 'email');

	return $_variants;

}
/**
 * Store language-dependent elements of an event, in order
 * to be able to recreate them later
 *
 * @param $event
 * @return unknown_type
 */
function storeLanguagesVariants( $event) {

	// if not multilingual, nothing to do
	$conf =& JFactory::getConfig();
	$IsMultiLingual = !is_null( $conf->getValue( 'multilingual_support', null));
	if (!$IsMultiLingual) {
		return;
	}

	// site is multlingual, fetch list of active languages
	$languages = JoomFishManager::getLanguages($active = true);

	// calculate reference id
	$eventId = empty( $event->rec_id) || !empty( $event->detached_from_rec) ? $event->extid : $event->rec_id;

	// if more than one language, we need to store language variants
	if (!empty( $languages) && count( $languages) > 1) {
		$db = &JFactory::getDBO();
		$defaultLanguageCode = $conf->getValue( 'config.defaultlang');
		foreach( $languages as $language) {
			$columns = implode( ',', getLanguageVariantsColumns());
			// for default language, we get the translations directly from the Jcal events table
			if ($language->code == $defaultLanguageCode) {
				$query = 'select ' . $columns . ' from #__jcalpro2_events where extid = ' . $db->quote( $eventId);
			} else {
				// while for non-default language elements, we get translation directly from Joomfish table
				$query = 'select value, reference_field from #__jf_content as jf join #__languages as lang where '
				. '     jf.reference_id = ' . $db->quote( $eventId)
				. ' and jf.reference_table = "jcalpro2_events"'
				. ' and jf.language_id = lang.id'
				. ' and lang.code = ' . $db->quote( $language->code);
			}
			$db->setQuery( $query);
			// read columns from db, forcing language retrieved
			$variantElements = $db->loadObjectList( $translate = true, $language);
			// store these elements, indexed on event id and language
			if (!empty( $variantElements)) {
				$variant = new stdClass();
				// store read translation into an object
				// adjusting format based on whether this is default language or not
				// see above, query is not the same so output format is not either
				foreach ($variantElements as $element) {
					if ($language->code == $defaultLanguageCode) {
					$variant = $element;
					} else {
					$tmp = $element->reference_field;
					$variant->$tmp = $element->value;
					}
				}
				setGetData( md5( $event->extid . $language->code), $variant);
			}
		}
	}
}

/**
 * Delete all child events of a given event
 *
 * @param integer $eventId the db id of the parent event
 * @return boolean, true if success, false if an error occured
 */
function deleteChildEvents( $event) {

	if (empty( $event->extid)) {
		return false;
	}

	// store each version of the events, per language so that
	// we can recreate each of them afterwards
	storeLanguagesVariants( $event);

	global $CONFIG_EXT, $mainframe, $lang_add_event_view;

	$db = &JFactory::getDBO();

	// build query
	$query = "delete from ".$CONFIG_EXT['TABLE_EVENTS']. ' where rec_id=' . $db->Quote( $event->extid);
	// based on global config, also delete detached child event
	$query .= $CONFIG_EXT['update_detached_with_series'] ? '' : ' and detached_from_rec=\'0\'';
	$db->setQuery($query);
	$db->query();

	// result
	$result = $db->getErrorNum();

	if ($result == 0) {
		// success
		$num = $db->getAffectedRows();
		$mainframe->enqueueMessage( stripslashes( sprintf( $lang_add_event_view['deleted_child_events'], $num)));
	} else {
		$mainframe->enqueueMessage( stripslashes( sprintf( $lang_add_event_view['failed_child_event_deletion'], $event->title, $result)), null, 'error');
	}
	// return success info
	return $result == 0;
}
/**
 * Update an event alredy existing in the DB
 *
 * @param object $event an object which properties are the event fields
 * @return boolean, true if success, false if an error happened
 */
function updateExistingEvent ( $event) {

	global $CONFIG_EXT, $mainframe, $lang_add_event_view;

	$db = &JFactory::getDBO();

	// update timestamp
	$event->last_updated = getLastUpdatedDateTime();

	// implement Mollom spam check through Moovur plugin
	//$useMoovur = !empty($CONFIG_EXT['enable_moovur']);
	$useMoovur = false;
	if ( $useMoovur && class_exists('Moovur')) {
		// use a copy of $event, as Moovur plugin unfortunately attach fields to the incoming object
		// thus breaking Jcal pro code further down the line
		Moovur::checkContent( clone($event), 'com_jcalpro', '');
	}

	// need to create an intermediate event of class JCalEvent
	// so that Joomfish can work with it
	// JF does not handle UPDATE queries, so we have to use updateObject(),
	// which only accepts JTable descendant objects
	// for historical reasons, our $event is a StdClass, and it would
	// be too large and bug-prone work to change that now.
	// will have to wait for jcp3 to do it properly
	$dbEvent = new JCalEvent();

	// and now we pass data from $event into $dbEvent. How stupid can stupid be ?
	$properties = get_object_vars( $event);
	if (!empty( $properties)) {
		foreach( $properties as $key => $value) {
			if (substr( $key, 0, 1) != '_') {
				$dbEvent->$key = $value;
			}
		}

		$db->updateObject($CONFIG_EXT['TABLE_EVENTS'], $dbEvent, 'extid');

		// display result
		$result = $db->getErrorNum();
		$e = $db->getErrorMsg();
		if ($result != 0) {
			$mainframe->enqueueMessage( stripslashes( sprintf( $lang_add_event_view['failed_existing_event_update'], $dbEvent->title, $result)), null, 'error');
		}

		// return success info
		return  $result == 0;
	}

	return false;
}
/**
 * Update an event alredy existing in the DB
 *
 * @param object $event an object which properties are the event fields
 * @return boolean, true if success, false if an error happened
 */
function updateExistingRecurringEvent ( $event) {

	// special case, if event was recurrent before, but has been edited and is no more recurrent
	$noMoreRec = $event->rec_type_select == JCL_REC_TYPE_NONE;

	// 0 - Check if event is valid
	$result = $noMoreRec ? true : createRecurringEventChildren( $event, $event->extid, $checkOnly = true);
	// 1 - delete child events
	if ($result) {
		$result = deleteChildEvents( $event);
	}

	// 2 - update event
	if ($result) {
		$result = updateExistingEvent( $event);
	}

	// 3 - create child events (only if event is still recurrent)
	if (!$noMoreRec && $result) {
		$result =  createRecurringEventChildren( $event, $event->extid);
	}

	return $result;
}

/**
 * Update a static event already in db into a recurring event
 *
 * @param object $event an object which properties are the event fields
 * @return boolean, true if success, false if an error happened
 */
function updateExistingStaticEventToRecurring ( $event) {

	// 1 - Check if event is valid
	$result = createRecurringEventChildren( $event, $event->extid, $checkOnly = true);

	// 2 - update event
	if ($result) {
		$result = updateExistingEvent( $event);
	}

	// 3 - create child events
	if ($result) {
		$result =  createRecurringEventChildren( $event, $event->extid);
	}

	return $result;
}

/**
 * Create a new event in database
 *
 * Includes creating sub-events when event is recurring
 *
 * @param unknown_type $cal_id
 * @param unknown_type $owner_id
 * @param unknown_type $title
 * @param unknown_type $description
 * @param unknown_type $contact
 * @param unknown_type $url
 * @param unknown_type $email
 * @param unknown_type $picture
 * @param unknown_type $cat
 * @param unknown_type $day
 * @param unknown_type $month
 * @param unknown_type $year
 * @param unknown_type $start_date
 * @param unknown_type $end_date
 * @param unknown_type $approve
 * @param unknown_type $recur_type
 * @param unknown_type $recur_val
 * @param unknown_type $recur_end_type
 * @param unknown_type $recur_count
 * @param unknown_type $recur_until
 * @param array $rawData user input as raw arrat, mostly to get recurrence info
 * @param int $rec_id, optional recurrence id, if part of a recurrence
 * @param int $detached_from_rec optional, set to 1 if event is no more tied to the recurrence definition
 */
function createEvent( $cal_id, $owner_id, $title, $description, $contact, $url, $registration_url, $email, $picture,
$cat, $day, $month, $year, $approved, $private, $start_date, $end_date, $published, $recur_end_type,
$recur_count, $recur_until, $rawData, $rec_id = 0, $detached_from_rec = 0, $checkOnly = false) {

	global $mainframe, $CONFIG_EXT, $lang_add_event_view;

	if ($checkOnly && $rawData['rec_type_select'] == JCL_REC_TYPE_NONE) {
		// if only checking and event is not recurrent, nothing to do
		return true;
	}

	// create a structure for easier handling
	$event = new stdClass();

	$event->rec_id = $rec_id;
	$event->cal_id = $cal_id;
	$event->detached_from_rec = $detached_from_rec;
	$event->owner_id = $owner_id;
	$event->title = $title;
	$event->description = $description;
	$event->contact = $contact;
	$event->url = $url;
	$event->registration_url = $registration_url;
	$event->email = $email;
	$event->picture = $picture;
	$event->cat = $cat;
	$event->day = $day;
	$event->month = (int) $month;
	$event->year = (int) $year;
	$event->approved = $approved;
	$event->private = $private;
	$event->start_date = $start_date;
	$event->end_date = $end_date;
	$event->published = $published;
	$event->checked_out = '0';
	$event->checked_out_time = '0000-00-00 00:00:00';
	$event->recur_type = $recur_type;
	$event->recur_val = $recur_val;
	$event->recur_end_type = $recur_end_type;
	$event->recur_count = (int) $recur_count;
	$event->recur_until = $recur_until;

	// V 2.1.x
	$event->rec_type_select = $rawData['rec_type_select'];

	// daily
	$event->rec_daily_period = (int) $rawData['rec_daily_period'];

	// weekly
	$event->rec_weekly_period = (int) $rawData['rec_weekly_period'];
	$event->rec_weekly_on_monday = (int) $rawData['rec_weekly_on_monday'];
	$event->rec_weekly_on_tuesday = (int) $rawData['rec_weekly_on_tuesday'];
	$event->rec_weekly_on_wednesday = (int) $rawData['rec_weekly_on_wednesday'];
	$event->rec_weekly_on_thursday = (int) $rawData['rec_weekly_on_thursday'];
	$event->rec_weekly_on_friday = (int) $rawData['rec_weekly_on_friday'];
	$event->rec_weekly_on_saturday = (int) $rawData['rec_weekly_on_saturday'];
	$event->rec_weekly_on_sunday = (int) $rawData['rec_weekly_on_sunday'];

	// monthly
	$event->rec_monthly_period = (int) $rawData['rec_monthly_period'];
	$event->rec_monthly_type = (int) $rawData['rec_monthly_type'];
	$event->rec_monthly_day_number = (int) $rawData['rec_monthly_day_number'];
	$event->rec_monthly_day_list = $rawData['rec_monthly_day_list'];
	$event->rec_monthly_day_order = (int) $rawData['rec_monthly_day_order'];
	$event->rec_monthly_day_type = (int) $rawData['rec_monthly_day_type'];

	// yearly
	$event->rec_yearly_period = (int) $rawData['rec_yearly_period'];
	$event->rec_yearly_on_month = (int) $rawData['rec_yearly_on_month'];
	$event->rec_yearly_on_month_list = $rawData['rec_yearly_on_month_list'];
	$event->rec_yearly_type = (int) $rawData['rec_yearly_type'];
	$event->rec_yearly_day_number = (int) $rawData['rec_yearly_day_number'];
	$event->rec_yearly_day_order = (int) $rawData['rec_yearly_day_order'];
	$event->rec_yearly_day_type = (int) $rawData['rec_yearly_day_type'];

	// we may have forced the common_event_id
	if (!empty($rawData[common_event_id])) {
		$event->common_event_id = $rawData[common_event_id];
	}

	// implement Mollom spam check through Moovur plugin
	//$useMoovur = !empty($CONFIG_EXT['enable_moovur']);
	$useMoovur = false;
	if ( $useMoovur && !$checkOnly && class_exists('Moovur')) {
		// use a copy of $event, as Moovur plugin unfortunately attach fields to the incoming object
		// thus breaking Jcal pro code further down the line
		Moovur::checkContent( clone($event), 'com_jcalpro', '');
	}

	// first, check if start date is on the first recurrence
	// otherwise refuse creating
	if ($checkOnly && $event->rec_type_select != JCL_REC_TYPE_NONE && empty( $event->rec_id) && empty( $event->detached_from_rec) ) {
		$recId = 1;  // dummy recId, only for checking recurrence
		$isValid = createRecurringEventChildren( $event, $recId, $checkOnly);
		return $isValid;
	}

	// store into db. We get last insert id as a result or 0 if error occured
	$recId = storeNewEvent( $event);
	// reset dst compensation
	$event->start_date = $start_date;
	$event->end_date = $end_date;

	// should we create children events ?
	if ($recId && $event->rec_type_select != JCL_REC_TYPE_NONE && empty( $event->rec_id) && empty( $event->detached_from_rec)) {
		// now calculate recurrences of this event
		createRecurringEventChildren( $event, $recId);
	} else {
		// mention what we've done
		if (!empty( $recId)) {
			// distinguish edit event link if in backend or frontend
			if ($mainframe->isAdmin()) {
				$link = $CONFIG_EXT['calendar_calling_page'] . '&section=events&task=editA&hidemainmenu=1&id=' . $recId;
				$mainframe->enqueueMessage( stripslashes( sprintf( $lang_add_event_view['submit_event_approved'],$link)));
			}

		}
	}

	return $recId;
}

/**
 * Create and store in db all children of a recurring event
 * restoring other language variants if we are updating an
 * existing event instead of just creating a new one
 *
 * @param object $parent the parent event defining the recurrence
 * @param int $rec_id the db id of the parent event
 * @return int the number of occurences created, 0 if error or no occurences
 */
function createRecurringEventChildren( $parent, $rec_id, $checkOnly = false) {

	$created = doCreateRecurringEventChildren( $parent, $rec_id, $checkOnly);

	// report success
	return $created;

}

/**
 * Create and store in db all children of a recurring event
 *
 * @param object $parent the parent event defining the recurrence
 * @param int $rec_id the db id of the parent event
 * @return int the number of occurences created, 0 if error or no occurences
 */
function doCreateRecurringEventChildren( $parent, $rec_id, $checkOnly = false) {

	global $CONFIG_EXT, $mainframe, $lang_add_event_view;

	// prepare a copy of the parent event, breaking the reference
	$child = unserialize(serialize( $parent));
	$child->rec_id = $rec_id;
	// remove current extid, to avoid duplicate key db errors when storing
	unset( $child->extid);

	// attach some useful fields, we'll remove them later so as to be able to save the object to db
	$parent->startDateTS = jcUTCDateToTs( $parent->start_date);
	if($parent->start_date > $parent->end_date) {
		$parent->endDateTS = $parent->startDateTS;
	} else {
		$parent->endDateTS = jcUTCDateToTs( $parent->end_date);
	}

	$parent->startDay = (int)jcUTCDateToFormatNoOffset( $parent->startDateTS, '%d');
	$parent->startMonth = (int)jcUTCDateToFormatNoOffset( $parent->startDateTS, '%m');
	$parent->startYear = (int)jcUTCDateToFormatNoOffset( $parent->startDateTS, '%Y');
	$parent->startHour = (int)jcUTCDateToFormatNoOffset( $parent->startDateTS, '%H');
	$parent->startMinute = (int)jcUTCDateToFormatNoOffset( $parent->startDateTS, '%M');
	$parent->startDayUserTime = (int)jcUTCDateToFormat( $parent->startDateTS, '%d');
	$parent->startMonthUserTime = (int)jcUTCDateToFormat( $parent->startDateTS, '%m');
	$parent->startYearUserTime = (int)jcUTCDateToFormat( $parent->startDateTS, '%Y');
	$parent->startHourUserTime = (int)jcUTCDateToFormat( $parent->startDateTS, '%H');
	$parent->startMinuteUserTime = (int)jcUTCDateToFormat( $parent->startDateTS, '%M');

	// call the functions doing the hardwork
	// createSimpleRecChildren covers recurrences option where the recurrence period is fixed (ie one day, one week, etc)
	// rec like every second tuesday have to be processed differently
	$created = 1;  // the parent event has already been created
	$status = false;
	switch($parent->rec_type_select) {
		case JCL_REC_TYPE_DAILY:
			$status = createSimpleRecChildren( $parent, $child, $created, $checkOnly);
			break;
		case JCL_REC_TYPE_WEEKLY:
			$status = createSimpleRecChildren( $parent, $child, $created, $checkOnly);
			break;
		case JCL_REC_TYPE_MONTHLY:
			if ($parent->rec_monthly_type == JCL_REC_ON_DAY_NUMBER) {
				$status = createSimpleRecChildren( $parent, $child, $created, $checkOnly);
			} else if ($parent->rec_monthly_type == JCL_REC_ON_SPECIFIC_DAY){
				$status = createCustomRecChildren( $parent, $child, $created, $checkOnly);
			}
			break;
		case JCL_REC_TYPE_YEARLY:
			if ($parent->rec_yearly_type == JCL_REC_ON_DAY_NUMBER) {
				$status = createSimpleRecChildren( $parent, $child, $created, $checkOnly);
			} else if ($parent->rec_yearly_type == JCL_REC_ON_SPECIFIC_DAY){
				$status = createCustomRecChildren( $parent, $child, $created, $checkOnly);
			}
			break;
		default:
			// should never happen
			jclRestoreEvent( $parent);
			return false;
			break;
	}

	// return result check before displaying anything
	if ($checkOnly) {
		jclRestoreEvent( $parent);
		return $status;
	}

	// mention what we've done
	if (!empty( $created) && !$checkOnly) {
		// distinguish edit event link if in backend or frontend
		if ($mainframe->isSite()) {
			$link = JRoute::_($CONFIG_EXT['calendar_calling_page'] . '&extmode=view&extid=' . $child->rec_id);
		} else {
			$link = JRoute::_($CONFIG_EXT['calendar_calling_page'] . '&section=events&task=editA&hidemainmenu=1&id=' . $child->rec_id);
		}
		$mainframe->enqueueMessage( stripslashes( sprintf( $lang_add_event_view['created_child_events'], $created, $child->title, $link)));
	}

	// remove fields we added
	jclRestoreEvent( $parent);

	return $created;
}

/**
 * Remove some fields that were added for convenience
 * Otherwise would be saved to db and cause an error
 */
function jclRestoreEvent( $parent) {
	unset( $parent->startDateTS);
	unset( $parent->endDateTS);
	unset( $parent->startDate);
	unset( $parent->endDate);
	unset( $parent->startDay);
	unset( $parent->startMonth);
	unset( $parent->startYear);
	unset( $parent->startHour);
	unset( $parent->startMinute);
	unset( $parent->endDay);
	unset( $parent->endMonth);
	unset( $parent->endYear);
	unset( $parent->startDayUserTime);
	unset( $parent->startMonthUserTime);
	unset( $parent->startYearUserTime);
	unset( $parent->startHourUserTime);
	unset( $parent->startMinuteUserTime);

	unset( $parent->catId);
	unset( $parent->recType);
	unset( $parent->recInterval);
	unset( $parent->recEndDate);
	unset( $parent->recEndType);
	unset( $parent->recEndCount);

}


/*
 * Create children events for a parent, recurring event
 * when recurrence is a simple one ie: with a fixed recurrence period
 * @param object $parent the parent event
 * @param object $child, the children event, already prepared for storage, only missing start and end date
 * @param integer $created updated with the number of events actually created
 * @return boolean, true is success, false if errors
 */
function createSimpleRecChildren( $parent, $child, & $created, $checkOnly = false) {

	// a few counters
	$recur_count = 1;  // start with one, as the original event has been already created
	$result = true;

	// set the end of recurrence information
	if ($parent->recur_end_type == JCL_RECUR_UNTIL_A_DATE) {
		$endDateTS = jcUTCDateToTs( $parent->recur_until);
	} else {
		$endDateTS = 0;
	}

	// compute duration
	$duration =  $parent->endDateTS - $parent->startDateTS;

	// find possible start dates for each serie and create recurrences on each of them
	// this will return an array of possible start_date in 2008-12-01 12:45:12 format (UTC, suited for direct db usage)
	// for daily rec, there is only one possibel start_date, that of the initial day
	// other types of recurrences have more possibilities
	$recTypes = array( 'None', 'Daily', 'Weekly', 'Monthly', 'Yearly');
	$fn = 'jclFind' . $recTypes[$parent->rec_type_select] . 'RecStarts';
	if (!function_exists( $fn)) {
		return false;
	}
	$startOfRecs = $fn( $parent);

	// return false if only checking recurrence and we could not find any
	if ($checkOnly && empty( $startOfRecs)) {
		return false;
	}

	// iterate over possible start dates, and create children for each series
	if (!empty( $startOfRecs)) {
		foreach( $startOfRecs as $startOfRec) {
			$createdChildren = 0;
			$child->start_date = $startOfRec;
			// if current startOfRec is on the same day as the parent event, we must skip that first recurrence
			$skipFirst = $parent->start_date == $child->start_date;
			if ($checkOnly) {
				// changed : now start date of event MUST be first recurrence
				// so return false otherwise while checking recurrence validity
				return $skipFirst;
			}

			$result = createPeriodicChildren( $parent, $child, $duration, jcUTCDateToTs( $startOfRec), $createdChildren,  $skipFirst, $endDateTS, $parent->recur_count+1);
			if ($result) {
				$created += $createdChildren;
			}
		}
	}

	// return results
	return $result;

}

/*
 * Create children events for a parent, recurring event
 * Will process more complex recurrence rules such as
 * every second monday of the month
 * Only used so far for monthly and yearly recurrences
 */
function createCustomRecChildren( $parent, $child, & $created, $checkOnly = false) {

	// a few counters
	$recur_count = 1;
	$result = true;

	// set the end of recurrence information
	if ($parent->recur_end_type == JCL_RECUR_UNTIL_A_DATE) {
		$endDateTS = jcUTCDateToTs( $parent->recur_until);
	} else {
		$endDateTS = 0;
	}

	// get next valid recurrence for the current rules and
	// repeat until we get to end of rec
	$recTypes = array( 'None', 'Daily', 'Weekly', 'Monthly', 'Yearly');
	$fn = 'jclCreateCustom' . $recTypes[$parent->rec_type_select] . 'Rec';
	if (!function_exists( $fn)) {
		return;
	}

	// call the function to perform the creation
	$result = $fn( $parent, $child, $created, $endDateTS, $checkOnly);

	// return results
	return $result;
}

/**
 * Search for possible start dates of series within a daily recurring event definition
 *
 */
function jclFindDailyRecStarts( $parent) {

	$recStarts = array();

	// daily recurrence : the most simple : we start on the parent start_date
	$recStarts[] = $parent->start_date;

	// return set of recs
	return $recStarts;
}

/**
 * Search for possible start dates of series within a weekly recurring event definition
 * If no specific weekday has been selected, then we start on the event start day
 * If some week days have been selected, then we find the nex of each
 *
 */
function jclFindWeeklyRecStarts( $parent) {

	global $CONFIG_EXT;

	// build a list of days
	$days = array();
	$daysText = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
	$start = !$CONFIG_EXT['day_start'] ? JCL_REC_DAY_TYPE_SUNDAY : JCL_REC_DAY_TYPE_MONDAY; // start on day as per user settings
	$index = 0;
	for ($i=$start; $i<8; $i++ ) {
		$days[$index]->key = $i;
		$days[$index]->value = $daysText[$i-1];
		$index++;
	}
	if ($CONFIG_EXT['day_start']) {
		// let's not forget Sunday
		$days[$index]->key = JCL_REC_DAY_TYPE_SUNDAY;
		$days[$index]->value = 'sunday';
	}

	// no possible rec start date at first
	$recStarts = array();

	// start with parent start_date
	$recStarts[] = $parent->start_date;

	// iterate over possible starts
	$firstThrough = true;
	foreach ($days as $day) {
		$property = 'rec_weekly_on_' . $day->value;
		if ($parent->$property) {
			// we MUST start on the parent start_date. So the first active recur on value
			// must match the day_of_week of the parent start_date
			if ($firstThrough) {
				$firstThrough = false;
				if (!dayIsOfTypeUserTime( $parent->start_date, $day->key)) {
					// if start_date is not the same day of week as that of first requested day,
					// return and empty array : no good, we can't do that recurrence
					$recStarts = array();
					return $recStarts;
				}
			} else {
				// otherwise need to recur on this one
				$recStarts[] = findNextWeekDay( $parent->start_date, $day->key);
			}
		}
	}

	// if no specific day was requested, we start a week after the event start date
	if (empty( $recStarts)) {
		$nextweekTS = jcUTCDateToTs( $parent->start_date) + 86400*7;
		$recStarts[] = jcUTCDateToFormatNoOffset( $nextweekTS, '%Y-%m-%d %H:%M:%S');
	}

	// return set of recs
	return $recStarts;
}


/*
 * Find the next occurence of a specific weekday (ie monday, tuesday),
 * counting from a provided date,
 *
 * @param string $from, the initial UTC date, in textual format 2008-12-01 05:05:05
 * @day integer $day, the neede day, Sunday = 1, Monday = 2, etc
 */
function findNextWeekDay( $from, $day) {

	$startTS = jcUTCDateToTs( $from);
	for ($i = 1; $i < 7; $i++) {
		// add one day until we are on a week day as requested
		$currentTS = $startTS + ($i * 86400);
		// warning : the check must be done in user time
		if ((int)jcUTCDateToFormat( $currentTS, '%w') == $day-1) {
			// we're there, format the date and return it
			return jcUTCDateToFormatNoOffset( $currentTS, '%Y-%m-%d %H:%M:%S');
		}
	}
	return false;
}

/**
 * Search for possible start dates of series within a monthly recurring event definition
 * This function only processes cases where recurrence start on a given numbered day
 *
 */
function jclFindMonthlyRecStarts( $parent) {

	$recStarts = array();

	if ($parent->rec_monthly_type == JCL_REC_ON_DAY_NUMBER) {

		// check if start_date exists. ie: as one can enter the day of the month
		// value freely, it is possible to enter, for instance, 31st of february !
		$ts = jcUTCDateToTS( $parent->start_date);
		$newDate = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');

		// if reconstructed date is the same as original, we are good to go for next check
		if ($parent->start_date == $newDate) {
			$recStarts[] = $parent->start_date;
		}

		// also check that starting day is the correct one, ie the one user
		// requested to recur on
		$startDay = jcUTCDateToFormatNoOffset( $ts, '%d');
		if ($parent->startDayUserTime != $parent->rec_monthly_day_number) {
			// not the day we are supposed to start recurring on
			$recStarts = array();
		}

	}

	return $recStarts;
}

function jclFindNextYear( $parent) {

	$startYear = $parent->startYearUserTime;
	if ($parent->rec_yearly_day_number == 29 && $parent->rec_yearly_on_month == JCL_REC_FEBRUARY) {
		// special case, if asked to recur on the 29 of feb, we must wait till such a day exists
		do {
			$startYear++;
			$ts = gmmktime(12,0,0,2,2,$startYear);
			$isBissext = date( 'L', $ts);
		} while (!$isBissext);
	} else {
		$startYear++;
	}

	return $startYear;
}

/**
 * Check the start date of a yearly recurring event definition
 * This function only processes cases where recurrence start on a given numbered day
 * WARNING : month records in the DB are numbered from 0. We must add 1 to
 * use them in mktime or gmktime functions
 *
 */
function jclFindYearlyRecStarts( $parent) {

	$recStarts = array();

	if ($parent->rec_yearly_type == JCL_REC_ON_DAY_NUMBER) {

		// check if start_date exists. ie: as one can enter the day of the month
		// value freely, it is possible to enter, for instance, 31st of february !
		$ts = jcUTCDateToTS( $parent->start_date);
		$newDate = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');

		// if reconstructed date is the same as original, we are good to go
		if ($parent->start_date == $newDate) {
			$recStarts[] = $parent->start_date;
		} else {
			// bad day entered as start_date
			return false;
		}

		// start date exists, now checks it matches the day set for the recurrence
		// reminder : This function only processes cases where recurrence start on a given numbered day
		// find out what month we're on
		if ($parent->startDayUserTime != $parent->rec_yearly_day_number || $parent->startMonthUserTime != $parent->rec_yearly_on_month+1) {
			return false;
		}
	}

	// return set of recs
	return $recStarts;
}

/*
 * Check if a given day is of a given type as defined by
 * the JCL_REC_DAY_TYPE_XXXX constants
 */
function dayIsOfType( $day, $month, $year, $dayType) {

	// first the most simple
	if ($dayType == JCL_REC_DAY_TYPE_DAY) {
		// every day is a 'day'
		return true;
	}

	// unsupported types for now
	if ($dayType > JCL_REC_DAY_TYPE_SATURDAY) {
		return false;
	}

	// calculate timestamp and find the current day
	$ts = gmmktime( 12, 0, 0, $month, $day, $year);
	$thisDayType = intval( jcTSToUTC( $ts, '%w')) + 1;  // UTC time

	// return comparison result
	return $thisDayType == $dayType;
}

/*
 * Check if a given day is of a given type as defined by
 * the JCL_REC_DAY_TYPE_XXXX constants
 * NB: operates in user time, assuming param is UTC
 */
function dayIsOfTypeUserTime( $date, $dayType) {

	// first the most simple
	if ($dayType == JCL_REC_DAY_TYPE_DAY) {
		// every day is a 'day'
		return true;
	}

	// unsupported types for now
	if ($dayType > JCL_REC_DAY_TYPE_SATURDAY) {
		return false;
	}

	// calculate timestamp and find the current day
	$ts = jcUTCDateToTs( $date);
	$thisDayType = intval( jcUTCDateToFormat( $ts, '%w')) + 1;  // user time

	// return comparison result
	return $thisDayType == $dayType;
}

/*
 * Find a specific day in a given month. Target day is defined by
 * - ordering : first, second, thrid, fourth or last
 * - type : day, monday, tuesday, ..., sunday
 *
 * @return false if none found, integer in [1,31] if found
 */
function getDayOfMonthByOrder( $month, $year, $ordering, $dayType, $eventDay = 1) {

	// init counters
	$occurences = array();
	$occCount = 0;
	$currentDay = 1;

	// get number of days in this month
	$ts = gmmktime( 1,0,0, $month, 10, $year);
	$dayInMonth = date( 't', $ts);

	// iterate over days in the month
	while ($currentDay <= $dayInMonth) {
		// if this day is of the requested type
		if (dayIsOfType( $currentDay, $month, $year, $dayType)) {
			// this is an occurence, increase count and store it (needed if seeking 'last' occurence
			$occCount++;
			$occurences[] = $currentDay;
			// if seeking first, second, third or fourth occurence, are we there ?
			if ($currentDay >= $eventDay && $occCount == $ordering && $ordering != JCL_REC_LAST) {
				// if yes, we can return current day
				return $currentDay;
			}
		}
		// else move to next day
		$currentDay++;
	}
	// if seeking the last occurence of a daytype
	if ($currentDay >= $eventDay && $ordering == JCL_REC_LAST & !empty($occurences)) {
		// return the last occurence found
		return $occurences[count($occurences)-1];
	}

	// nothing found, error
	return false;
}

/*
 * Check if start date is on the first occurence of the series
 * before creating the event
 */
function jclCreateFirstCustomMonthlyRec( $month, $year, $parent, $child, $endDateTS, & $currentRecCount, & $childrenCount, & $created, $checkOnly = false) {

	// get next recurrence
	$firstRecDay = getDayOfMonthByOrder( $month, $year, $parent->rec_monthly_day_order, $parent->rec_monthly_day_type, $parent->startDayUserTime);
	if ($firstRecDay == false) {
		// start_date must be the first occurence of the series
		return false;
	}
	// we have found a first rec possible day, check if not already out of bound
	$ts = jcUTCDateToTs( jcUserTimeToUTC( $parent->startHourUserTime, $parent->startMinuteUserTime, 0, $month, $firstRecDay, $year));

	// return false if already passed end date
	if ($parent->recur_end_type == JCL_RECUR_UNTIL_A_DATE && $ts > $endDateTS) {
		return false;
	}

	// are we on start date of initial event ?
	// need to compensate for dst as this is normally only done a little bit downstream
	$isFirstEvent = $ts == $parent->startDateTS;

	// if only checking return result
	// the first event does not coincide with the first recurrence
	// means user did not select start date as the initial recurrence : wrong
	if ($checkOnly) {
		return $isFirstEvent;
	}

	// actually create event, but only if it does not coincide in time with initial event
	$result = true;
	if (!$isFirstEvent) {
		// actually create the event
		$duration = $parent->endDateTS - $parent->startDateTS;
		$child->start_date = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');
		if (!jclIsAllDay($parent->end_date) && !jclIsNoEndDate($parent->end_date)) {
			$child->end_date = jcUTCDateToFormatNoOffset( $ts + $duration, '%Y-%m-%d %H:%M:%S');
		} else {
			$child->end_date = $parent->end_date;
		}
		$child->day = (int)jcUTCDateToFormatNoOffset( $ts, '%d');
		$child->month = (int)jcUTCDateToFormatNoOffset( $ts, '%m');
		$child->year = (int)jcUTCDateToFormatNoOffset( $ts, '%Y');
		// we set the common_event_id ourselves, so that children have an id that repeats itself
		// if the same id is use for the parent. This is required when importing several times
		// the same parent event, so that children are updated just like the parent event
		$child->common_event_id = $parent->common_event_id . '-' . ($created + 1);
		$result = storeNewEvent( $child);
		if ($result) {
			$created++;
		}
	}

	// update recurrence counts
	if ($result) {
		$currentRecCount++;
	}
	// return day found
	return $result;
}

/*
 * Create next recurrence, if any, for the target month. Do not need to check against
 * parent event start date, as this is the second or more recurrence
 */
function jclCreateNextCustomMonthlyRec( $month, $year, $parent, $child, $endDateTS, & $currentRecCount, & $created) {

	// get next recurrence. At this stage, any day in the month is acceptable, so we don't pass last argument
	$nextRecDay = getDayOfMonthByOrder( $month, $year, $parent->rec_monthly_day_order, $parent->rec_monthly_day_type);

	if ($nextRecDay == false) {
		// could not find a suitable day on this month
		return false;
	}
	// we have found a possible day, check if not already out of bound
	$ts = jcUTCDateToTs( jcUserTimeToUTC( $parent->startHourUserTime, $parent->startMinuteUserTime, 0, $month, $nextRecDay, $year));

	// return false if already passed end date
	if ($parent->recur_end_type == JCL_RECUR_SO_MANY_OCCURENCES) {
		$result = $currentRecCount <= $parent->recur_count;
	} else {
		// recur_end_type is JCL_RECUR_UNTIL_A_DATE
		$result = $ts <= $endDateTS;
	}
	if (!$result) {
		return false;
	}

	// actually create the event
	$duration = $parent->endDateTS - $parent->startDateTS;
	$child->start_date = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');
	if (!jclIsAllDay($parent->end_date) && !jclIsNoEndDate($parent->end_date)) {
		$child->end_date = jcUTCDateToFormatNoOffset( $ts + $duration, '%Y-%m-%d %H:%M:%S');
	} else {
		$child->end_date = $parent->end_date;
	}
	$child->day = (int)jcUTCDateToFormatNoOffset( $ts, '%d');
	$child->month = (int)jcUTCDateToFormatNoOffset( $ts, '%m');
	$child->year = (int)jcUTCDateToFormatNoOffset( $ts, '%Y');
	// we set the common_event_id ourselves, so that children have an id that repeats itself
	// if the same id is use for the parent. This is required when importing several times
	// the same parent event, so that children are updated just like the parent event
	$child->common_event_id = $parent->common_event_id . '-' . ($created + 1);
	$result = storeNewEvent( $child);

	// update recurrence counts
	if ($result) {
		$currentRecCount++;
		$created++;
	}

	// return result of storage
	return $result;
}

/**
 * Create monthly recurrences of event, when the recurrence rule is not a simple one
 * ie: next occurence is not obtained by adding a fixed amount of time, like a day or a week
 *
 * @param <type> $parent
 * @param <type> $child
 * @param <type> $created
 * @param <type> $endDateTS
 * @param <type> $checkOnly
 * @return <type>
 */
function jclCreateCustomMonthlyRec( $parent, $child, & $created, $endDateTS, $checkOnly = false) {

	// counters
	$currentRecCount = 1;
	$childrenCount = 0;

	// starting month
	$month = $parent->startMonthUserTime;
	$year = $parent->startYearUserTime;

	// create first recurrence. $month and $year will be adjusted if needs be to actually jump to next month
	$result =  jclCreateFirstCustomMonthlyRec( $month, $year, $parent, $child, $endDateTS, $currentRecCount, $childrenCount, $created, $checkOnly);

	// if only checking return with result
	if ($checkOnly) {
		return $result;
	}

	// if successfull, repeat until we reach the end
	if ($result) {
		do {
			$created += $childrenCount;
			$childrenCount = 0;

			// increase running month/year by period
			$result = jclFindSimplyNextMonth( $month, $year, $parent->rec_monthly_period);

			// get next recurrence, if any, for the new target month
			$result = $result && jclCreateNextCustomMonthlyRec( $month, $year,$parent, $child, $endDateTS, $currentRecCount, $childrenCount);

		} while ( $result && $childrenCount > 0);
	}

	return $result;
}

/*
 * Check if we have to start on next year or not,
 * before creating the event
 */
function jclCreateFirstCustomYearlyRec( & $month, & $year, $parent, $child, $endDateTS, & $currentRecCount, & $created, $checkOnly = false) {

	// get next recurrence
	$firstRecDay = getDayOfMonthByOrder( $month, $year, $parent->rec_yearly_day_order, $parent->rec_yearly_day_type, $parent->startDayUserTime);

	if ($firstRecDay == false) {
		// event start_date is not first occurence of series, reject
		return false;
	}
	// we have found a first rec possible day, check if not already out of bound
	$ts = jcUTCDateToTs( jcUserTimeToUTC( $parent->startHourUserTime, $parent->startMinuteUserTime, 0, $month, $firstRecDay, $year));

	// return false if already passed end date
	if ($parent->recur_end_type == JCL_RECUR_UNTIL_A_DATE && $ts > $endDateTS) {
		return false;
	}

	// are we on start date of initial event ?
	$isFirstEvent = $ts == $parent->startDateTS;

	// if only checking return false
	// the first event does not coincide with the first recurrence
	// means user did not select start date as the initial recurrence : wrong
	if ($checkOnly) {
		return $isFirstEvent;
	}

	// actually create event, but only if it does not coincide in time with initial event
	$result = true;
	if (!$isFirstEvent) {
		// actually create the event
		$duration = $parent->endDateTS - $parent->startDateTS;
		$child->start_date = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');
		if (!jclIsAllDay($parent->end_date) && !jclIsNoEndDate($parent->end_date)) {
			$child->end_date = jcUTCDateToFormatNoOffset( $ts + $duration, '%Y-%m-%d %H:%M:%S');
		} else {
			$child->end_date = $parent->end_date;
		}
		$child->day = (int)jcUTCDateToFormatNoOffset( $ts, '%d');
		$child->month = (int)jcUTCDateToFormatNoOffset( $ts, '%m');
		$child->year = (int)jcUTCDateToFormatNoOffset( $ts, '%Y');

		// we set the common_event_id ourselves, so that children have an id that repeats itself
		// if the same id is use for the parent. This is required when importing several times
		// the same parent event, so that children are updated just like the parent event
		$child->common_event_id = $parent->common_event_id . '-' . ($created + 1);

		// now store the event in db
		$result = storeNewEvent( $child);
		if ($result) {
			$created++;
		}
	}

	// update recurrence counts
	if ($result) {
		$currentRecCount++;
	}

	// return day found
	return $result;
}

/*
 * Create next recurrence, if any, for the target year. Do not need to check against
 * parent event start date, as this is the second or more recurrence
 */
function jclCreateNextCustomYearlyRec( $month, $year, $parent, $child, $endDateTS, & $currentRecCount, & $created) {

	// get next recurrence. At this stage, any day in the month is acceptable, so we don't pass last argument
	$nextRecDay = getDayOfMonthByOrder( $month, $year, $parent->rec_yearly_day_order, $parent->rec_yearly_day_type);
	if ($nextRecDay == false) {
		// could not find a suitable day on this month
		return false;
	}
	// we have found a possible day, check if not already out of bound
	$ts = jcUTCDateToTs( jcUserTimeToUTC( $parent->startHourUserTime, $parent->startMinuteUserTime, 0, $month, $nextRecDay, $year));

	// return false if already passed end date
	if ($parent->recur_end_type == JCL_RECUR_SO_MANY_OCCURENCES) {
		$result = $currentRecCount <= $parent->recur_count;
	} else {
		// recur_end_type is JCL_RECUR_UNTIL_A_DATE
		$result = $ts <= $endDateTS;
	}
	if (!$result) {
		return false;
	}

	// actually create the event
	$duration = $parent->endDateTS - $parent->startDateTS;
	$child->start_date = jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');
	if (!jclIsAllDay($parent->end_date) && !jclIsNoEndDate($parent->end_date)) {
		$child->end_date = jcUTCDateToFormatNoOffset( $ts + $duration, '%Y-%m-%d %H:%M:%S');
	} else {
		$child->end_date = $parent->end_date;
	}
	$child->day = (int)jcUTCDateToFormatNoOffset( $ts, '%d');
	$child->month = (int)jcUTCDateToFormatNoOffset( $ts, '%m');
	$child->year = (int)jcUTCDateToFormatNoOffset( $ts, '%Y');

	// we set the common_event_id ourselves, so that children have an id that repeats itself
	// if the same id is use for the parent. This is required when importing several times
	// the same parent event, so that children are updated just like the parent event
	$child->common_event_id = $parent->common_event_id . '-' . ($created + 1);

	// now store the event in db
	$result = storeNewEvent( $child);

	// update recurrence counts
	if ($result) {
		$currentRecCount++;
		$created++;
	}

	// return result of storage
	return $result;
}

/**
 * Create yearly recurrences of event, when the recurrence rule is not a simple one
 * ie: next occurence is not obtained by adding a fixed amount of time, like a day or a week
 *
 * @param <type> $parent
 * @param <type> $child
 * @param <type> $created
 * @param <type> $endDateTS
 * @param <type> $checkOnly
 * @return <type>
 */
function jclCreateCustomYearlyRec( $parent, $child, & $created, $endDateTS, $checkOnly = false) {

	// counters
	$currentRecCount = 1;
	$childrenCount = 0;

	// starting month
	$month = $parent->startMonthUserTime;
	$year = $parent->startYearUserTime;

	// create first recurrence. $month and $year will be adjusted if needs be to actually jump to next month
	$result =  jclCreateFirstCustomYearlyRec( $month, $year, $parent, $child, $endDateTS, $currentRecCount, $childrenCount, $checkOnly);

	// if only checking return with result
	if ($checkOnly) {
		return $result;
	}

	// if successfull, repeat until we reach the end
	if ($result) {
		do {
			$created += $childrenCount;
			$childrenCount = 0;

			// increase running month/year by period
			$result = jclFindSimplyNextMonth( $month, $year, $parent->rec_yearly_period * 12);

			// get next recurrence, if any, for the new target month
			$result = $result && jclCreateNextCustomYearlyRec( $month, $year, $parent, $child, $endDateTS, $currentRecCount, $childrenCount);

		} while ( $result && $childrenCount > 0);
	}

	return $result;
}

/*
 * Finds the next month, possibly with a specified period (ie: 2 mont, 3 month)
 * Adjusts  $month & $year to match that of next month
 * Don't bother about a particular day
 */
function jclFindSimplyNextMonth( & $month, & $year, $period = 1) {

	// basic params check
	if ($month > 12 or $month < 0) {
		return false;
	}
	if ($year < 1) {
		return false;
	}
	if ($period < 1 ) {
		return false;
	}

	// start real work
	$plusYear = intval($period / 12);  // more than 12 month to add ? add one or more years
	$plusMonth = $period % 12; // how many months, in addition to years ?

	// add period
	$month += $plusMonth;
	$year += $plusYear;

	// double-check : we still may cross a year boundary
	if ($month > 12) {
		$year += 1;
		$month = $month % 12;
	}

	// return false if not same date
	return true;

}

/*
 * Finds the next month, possibly with a specified period (ie: 2 mont, 3 month)
 * Adjusts  $month & $year to match that of next month
 * If day does not exist in next month (like if starting from
 * jan 30, we cannot find feb 30, so we move straight up to march 30
 */
function jclFindNextMonth( $startDay, & $hour, & $minute, & $month, & $year, $period = 1) {

	// basic params check
	if ($month > 12 or $month < 0) {
		return false;
	}
	if ($year < 1) {
		return false;
	}
	if ($period < 1 ) {
		return false;
	}

	// start real work
	$plusYear = intval($period / 12);  // more than 12 month to add ? add one or more years
	$plusMonth = $period % 12; // how many months, in addition to years ?

	// add period
	$month += $plusMonth;
	$year += $plusYear;

	// double-check : we still may cross a year boundary
	if ($month > 12) {
		$year += 1;
		$month = $month % 12;
	}

	// final check : does the day exists on that year ?
	// days on the 29, 30 or 31 may not exists on some month/year combination
	// turn the result in a ts, then break it down and check it match what we expect
	$ts = jcUTCDateToTS( $year . '-' . $month . '-' . $startDay . ' ' . $hour . ':' . $minute . ':00 UTC');
	$newDay = (int)jcUTCDateToFormatNoOffset( $ts, '%d');
	$newYear = (int)jcUTCDateToFormatNoOffset( $ts, '%Y');
	$newMonth = (int)jcUTCDateToFormatNoOffset( $ts, '%m');

	$found = ($newDay == $startDay && $newMonth == $month && $newYear == $year);

	// return false if not same date
	return $found;

}

/*
 * find next month : a little bit special :
 * start day may be a 29, 30 or 31. Based on the start month
 * there may not be a 29, 30 or 31 in next day. So we must skip it, but keep searching
 * for security, there is a control loop that stops at 14, so we can go over a full year and be sure to exit
 */
function jclFindRealNextMonth( $startDay, & $hour, & $minute, & $month, & $year, $period = 1) {

	$i = 1;
	do {
		$found = jclFindNextMonth( $startDay, $hour, $minute, $month, $year, $period);
		$i++;
	} while (!$found && $i < 14);

	return $found;
}

/*
 * Create children events for a parent, recurring event
 * when recurrence period is fixed, ie: a day or a week
 *
 * @param object $parent, the initial parent event, with added fields for easier calculation
 * @param object $child, the children event, already prepared for storage, only missing start and end date
 * @param integer $duration duration of event in seconds, needed to update end_date field
 * @param $startTS the unix timestamp to start from
 * @param integer $created updated with the number of events actually created
 * @param boolean $skipFirst if true, we must skip the first event in the series, as this coincide with the parent event
 * @param integer $stopTS the unix timestamp after which recurrence must stop
 * @param integer $recCount max number of recurrences
 * @return boolean, true is success, false if errors
 */
function createPeriodicChildren( $parent, $child, $duration, $startTS, & $created,  $skipFirst, $stopTS = 0, $recCount = 0) {

	// check we have a valid stop condition
	if (($child->recur_end_type == JCL_RECUR_UNTIL_A_DATE && $stopTS < ($starTS+$duration)) || ($child->recur_end_type == JCL_RECUR_SO_MANY_OCCURENCES && $recCount < 1)) {
		return false;
	}

	// we start from the specified event start time
	$exact_current_stamp = $startTS;
	$recur_count = 1;
	$result = true;
	// if event series started on a time when dst is on, dst was compensated for the
	// first occurence, and so is the startTS
	// if event series started at a time when dst was off, we need to compensate
	// for additional events
	$dstAlreadyCompensated = jclGetDst( $startTS);

	// now iterate through each occurence, creating a new event each iteration
	do {
		// create the event at the current timestamp
		if ( ($child->recur_end_type == JCL_RECUR_UNTIL_A_DATE && $exact_current_stamp <= $stopTS) || ($child->recur_end_type == JCL_RECUR_SO_MANY_OCCURENCES && $recur_count < $recCount) ) {
			// compensate for dst as we are calculating in UTC
			$saveTs = $dstAlreadyCompensated ? jclInverseCompensateTSForDst( $exact_current_stamp) : jclCompensateTSForDst( $exact_current_stamp);

			// now prepare the child event for storage in the db
			$child->start_date = jcUTCDateToFormatNoOffset( $saveTs, '%Y-%m-%d %H:%M:%S');
			if (!jclIsAllDay($parent->end_date) && !jclIsNoEndDate($parent->end_date)) {
				$child->end_date = jcUTCDateToFormatNoOffset( $saveTs + $duration, '%Y-%m-%d %H:%M:%S');
			} else {
				$child->end_date = $parent->end_date;
			}
			$child->day = (int)jcUTCDateToFormatNoOffset( $saveTs, '%d');
			$child->month = (int)jcUTCDateToFormatNoOffset( $saveTs, '%m');
			$child->year = (int)jcUTCDateToFormatNoOffset( $saveTs, '%Y');

			// store child events in database, skipping first event if asked to
			if (!$skipFirst) {

				// we set the common_event_id ourselves, so that children have an id that repeats itself
				// if the same id is use for the parent. This is required when importing several times
				// the same parent event, so that children are updated just like the parent event
				$child->common_event_id = $parent->common_event_id . '-' . ($created + 1);
				// now store the event in db
				$result = storeNewEvent( $child);
				if ($result) {
					$created++;
				}
			} else {
				$skipFirst = false;
			}

			// store data for next iteration
			$day = (int)jcUTCDateToFormatNoOffset( $exact_current_stamp, '%d');
			$month = (int)jcUTCDateToFormatNoOffset( $exact_current_stamp, '%m');
			$year = (int)jcUTCDateToFormatNoOffset( $exact_current_stamp, '%Y');;
			$hour = (int)jcUTCDateToFormatNoOffset( $exact_current_stamp, '%H');
			$minute = (int)jcUTCDateToFormatNoOffset( $exact_current_stamp, '%M');

			$recur_count++;
		}

		// Then the current stamp is updated as the date is incremented by the recur interval until it comes up to the target date.
		switch($child->rec_type_select) {
			case JCL_REC_TYPE_DAILY:
				$exact_current_stamp += $child->rec_daily_period * 86400;
				break;
			case JCL_REC_TYPE_WEEKLY:
				$exact_current_stamp += $child->rec_weekly_period *  604800; // = 7 *86400
				break;
			case JCL_REC_TYPE_MONTHLY:
				$found = jclFindRealNextMonth( $day, $hour, $minute, $month, $year, $child->rec_monthly_period);
				if (!$found) {
					return false;
				}
				$exact_current_stamp =  gmmktime( $hour, $minute,0,$month,$day,$year);
				break;
			case JCL_REC_TYPE_YEARLY:
				$found = jclFindRealNextMonth( $day, $hour, $minute, $month, $year, $child->rec_yearly_period  * 12);
				if (!$found) {
					return false;
				}
				$exact_current_stamp = gmmktime( $hour, $minute,0,$month,$day,$year);
				break;
			default:
				// should never happen
				return false;
				break;
		}
	} while( $result && ( ($child->recur_end_type == JCL_RECUR_UNTIL_A_DATE && $exact_current_stamp <= $stopTS) || ($child->recur_end_type == JCL_RECUR_SO_MANY_OCCURENCES && $recur_count < $recCount) ) );

	// return results
	return $result;

}

/**
 * Check if PHP version is high enough to handle timezones
 * If yes, returns current server tz and store it
 * if no, returns false
 *
 * @staticvar <type> $managed
 * @staticvar <type> $serverTZ
 * @return <type>
 */
function jclPhpManageTZ() {

	static $managed = null;
	static $serverTZ = null;

	if (is_null( $serverTZ)) {
		// not yet found if this server PHP can handle timezones, let's do it now
		if (is_callable('date_default_timezone_get')) {
			$serverTZ = date_default_timezone_get();
		} else {
			$serverTZ = false;
		}
	}

	return $serverTZ;
}

/**
 * Find if a given moment in time has dst on or off in a
 * given timezone
 *
 * Currently, this only works if server timezone matches the
 * requested timezone
 *
 * @param <type> $ts Unix timestamp of the moment to check
 * @param <type> $zone an array can be 'offset' => a number of hours || 'textOffset' => '+0200' for instance
 * @return <int> 0 if dst is off, 1 if dst is on
 */
function jclGetDst( $ts, $zone = null) {

	global $CONFIG_EXT;

	// calculate whichever timezone we want to use
	$targetTZ = empty( $zone) ? $CONFIG_EXT['site_timezone'] : $zone;

	// get server TZ. Will return false if php version is not high enough to handle timezones
	$serverTZ = jclPhpManageTZ();

	// if PHP version is high enough, and we have a target zone
	if (!empty($serverTZ) && !empty( $targetTZ)) {
		// server php handles timezones, we can use them
		$set = date_default_timezone_set( $targetTZ);
	}

	// TZ is either left untouched or set to the configured or requested timezone
	// so we can query whether dst is on, and then reset system timezone
	$dst = date( 'I', $ts);
	if (!empty( $serverTZ)) {
		date_default_timezone_set( $serverTZ);
	}

	return $dst;
}

/**
 * get all events for a given day range
 *
 * @param integer $first_date_stamp date time of 00:00:00 of the first day in range in UTC time
 * @param integer $last_date_stamp date time of 00:00:00 of the last day in range in UTC time
 * @param boolean $include_recurrent
 * @param boolean $show_overlapping_recurrences
 * @param boolean $last_updated if true, selection is done based on the last_updated field instead of event date
 * @return array : one element per day in range, each element is an array of event element, each event element being
 * an array : eventId, event start_date, event_end_date, event_details
 */

function get_events( $first_date, $last_date, $include_recurrent = JCL_SHOW_RECURRING_EVENTS_ALL, $show_overlapping_recurrences = false, $last_updated = false, $profiledUserId = 0) {

	// cache as many requests as we can
	static $resultCache = null;

	// return events that occur at a specific date WARNING: this timestamp must be based on a UTC time.
	// events are stored as UTC times, so a local date may actually span over 2 days
	// get_events does the conversion
	global $CONFIG_EXT, $cal_id, $cat_id, $cat_list, $cat_list_illbethere, $cat_list_community, $cal_list, $private_events_mode, $today, $mainframe;
	$db = &JFactory::getDBO();

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );

	// preliminary checks
	if(empty($first_date) || empty( $last_date)) {
		return false;
	}

	// validate categories and calendars
	if (!empty( $cat_id) && !has_priv ( 'category' . $cat_id)) {
		// user not allowed to see this cat
		return false;
	}
	if (empty( $cat_list)) {
		// if list of cats is empty, we read all cats
		$cat_list = jclGetCategories();
	}
	$cat_list = jclValidateAndCheckAuthList( $cat_list, 'category');
	if (empty( $cat_list)) {
		// not allowed to see any cat in the current category list
		return false;
	}

	if (!empty( $cal_id) && !has_priv ( 'calendar' . $cal_id)) {
		// use not allowed to see this calendar
		return false;
	}
	if (empty( $cal_list)) {
		$cal_list = jclGetCalendars();
	}
	$cal_list = jclValidateAndCheckAuthList( $cal_list, 'calendar');
	if (empty( $cal_list)) {
		// not allowed to see any calendar in the current calendar list
		return false;
	}

	// now all cat or cal selectors are validated against user authorizations

	// unix timestamps of start and end dates
	$startTS = jcUTCDateToTs($first_date);
	$endTS = jcUTCDateToTs($last_date);

	// do not display past events
	$todayUserTime = jcUserTimeToUTC( 0, 0, 0, $today['month'], $today['day'], $today['year']);
	$todayTS = jcUTCDateToTs($todayUserTime);
	if( !$CONFIG_EXT['archive'] && $startTS < $todayTS) {
		$first_date = $todayUserTime;
		// update timestamp
		$startTS = $todayTS;
	}

	// convert to mysql date time, for query
	$startOfFirstDaySql = $db->Quote( $first_date);
	$endOfLastDaySql = $db->Quote( $last_date);

	// generate the sql query for a specific date
	$event_condition = '';

	// are we trying to fetch events based on last update date ?
	if ($last_updated) {
		$event_condition .= (empty( $event_condition) ? '' : ' AND ') . " e.last_updated >= $startOfFirstDaySql AND e.last_updated <= $endOfLastDaySql";
	} else {
		// conditions on date of the event
		$event_condition  = "(    ( e.start_date <= $startOfFirstDaySql AND e.end_date >= $endOfLastDaySql"
		." AND e.end_date != " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE)
		." AND e.end_date != " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE_LEGACY)
		." AND e.end_date != " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2)
		. ") ";
		$event_condition .= " OR ((e.start_date >= $startOfFirstDaySql AND e.start_date < $endOfLastDaySql) "
		." AND (e.end_date = " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE)
		." OR e.end_date = " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE_LEGACY)
		." OR e.end_date = " . $db->Quote( JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2)
		. ")) ";
		$event_condition .= "  OR ( e.start_date > $startOfFirstDaySql AND e.start_date <= $endOfLastDaySql)";
		$event_condition .= "  OR ( e.end_date > $startOfFirstDaySql AND e.end_date <= $endOfLastDaySql ) )";

	}


	// apply settings on showing reccuring events
	if ($CONFIG_EXT['show_recurrent_events'] == JCL_SHOW_RECURRING_EVENTS_FIRST_ONLY) {
		// if only show the first occurence in a series :
		$event_condition .= (empty( $event_condition) ? '' : ' AND ') . ' e.rec_id = ' . $db->Quote('0');
	}


	// read from db
	$query = "SELECT e.*, DATE_FORMAT( e.start_date, '%Y%m%d' ) as date, c.cat_id, c.cat_name, c.color, c.description as cat_desc from " . $CONFIG_EXT['TABLE_EVENTS'] . ' AS e'
	. " LEFT JOIN " . $CONFIG_EXT['TABLE_CATEGORIES'] . " AS c ON e.cat=c.cat_id "
	. " LEFT JOIN " . $CONFIG_EXT['TABLE_CALENDARS'] . " AS cal ON e.cal_id=cal.cal_id ";
	$query .= "WHERE ".$event_condition." AND c.published = '1' AND e.published = '1' AND cal.published='1' AND approved = '1' ";

	// apply category restrictions
	if(!empty($cat_id) && is_numeric($cat_id)) {
		$query .= "AND e.cat = ".$db->Quote( $cat_id) . ' ';
	} else if (!empty( $cat_list)) {
		// if not a specific cat requested, apply categories list restrictions
		$query .= "AND e.cat IN (" . $cat_list . ") ";
	}

	// apply calendar restrictions
	if (!empty( $cal_id)) {
		$query .= "AND e.cal_id = ".$db->Quote( $cal_id) . ' ';
	} else if (!empty( $cal_list)) {
		// if not a specific cal requested, apply calendars list restrictions
		$query .= "AND e.cal_id IN (" . $cal_list . ") ";
	}

	// apply private event restrictions
	$user = &JFactory::getUser();
	switch ($private_events_mode) {
		case JCL_DO_NOT_SHOW_PRIVATE_EVENTS :
			$query .= "AND e.private = '" . JCL_EVENT_PUBLIC . "' ";
			break;
		case  JCL_SHOW_ONLY_PRIVATE_EVENTS :
			$query .= "AND e.owner_id = " . $db->Quote( $user->id) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\')  ';
			break;
		case  JCL_SHOW_ONLY_OWN_EVENTS :
			// if we are looking at the profile of another user than the one logged in
			if (!empty( $profiledUserId) && $profiledUserId != $user->id) {
				// make sure we display on the tab only those events that belong to that particular user
				$query .= ' AND ( (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\'))  '
				. 'OR (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND '. $db->Quote( $profiledUserId) .'!='. $db->Quote( $user->id) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\', \'' . JCL_EVENT_PUBLIC . '\') ' . ')'
				. '  )';
			} else {
				// possibly any user looking, so need to show private events only to their owner
				$query .= "AND e.owner_id = " . $db->Quote( $user->id);
			}
			break;
		default:
			$query .= "AND (e.private in ('".JCL_EVENT_PUBLIC ."', '".JCL_EVENT_PRIVATE_READ_ONLY."') "
			. "OR (e.owner_id = " . $db->Quote( $user->id) . " AND e.private = '". JCL_EVENT_PRIVATE ."')) ";
			break;
	}

	// apply recurrency restrictions
	if ($include_recurrent == JCL_SHOW_RECURRING_EVENTS_NONE) {
		$query .= "AND e.rec_type_select = '". JCL_REC_TYPE_NONE ."' ";
	}

	// finalize query
	$query .= "ORDER BY start_date,title ASC";

	// query the db if no cache hit
	$queryId = md5( $query);
	if (empty( $resultCache) || !isset( $resultCache[$queryId])) {
		$db->setQuery( $query);
		$events = $db->loadObjectList();
	
	$rows = array();
	$catnames = array();
	foreach ( $events as $i => $row ) {
		$rows[$row->date.'_'.$i] = $row;
		$catnames[$row->cat_name] = $row->color;
	}

	if ( ( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && @$CONFIG_EXT['show_illbethere'] ) ) && !$cal_id) {
		$cat_list_illbethere = $cat_list_illbethere ? $cat_list_illbethere : jclValidateList( $pageParams->get( 'cat_list_illbethere' ) );
		if ( empty( $cat_list_illbethere ) ) {
			$cat_list_illbethere = @$CONFIG_EXT['cat_list_illbethere'];
		}
		if ( $cat_list_illbethere == -1 ) {
			$cat_list_illbethere = '';
		}
		$exclude_illbethere = $pageParams->get( 'cat_list_exclude_illbethere' );
		// read RSVP categories list
		$query = "SELECT e.*, DATE_FORMAT( e.session_up, '%Y%m%d' ) as date, c.name as cat_name
			FROM #__illbethere_sessions as e
			LEFT JOIN #__illbethere_categories as c
			ON c.cat_id = e.cat_id
			WHERE e.published = '1'";
		// apply category restrictions
		if ( !empty( $cat_list_illbethere ) ) {
			$query .= " AND e.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
		}
		// apply sort order
		$query .= " ORDER BY e.session_up, e.title ASC";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		if (!empty($extra_rows)) {
			foreach ( $extra_rows as $i => $row ) {
				$row->cat_ext = 'illbethere';
				$row->extid = $row->session_id;
				$row->start_date = $row->session_up;
				$row->end_date = $row->session_down;
				if ( in_array( $row->cat_name, array_keys( $catnames ) ) ) {
					$row->color = $catnames[$row->cat_name];
				} else {
					$row->color = $CONFIG_EXT['color_illbethere'];
				}
				$rows[$row->date.'_r_'.$i] = $row;
			}
		}
	}

	if ( ( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && @$CONFIG_EXT['show_community'] ) ) && !$cal_id ) {
		$cat_list_community = $cat_list_community ? $cat_list_community : jclValidateList( $pageParams->get( 'cat_list_community' ) );
		if ( empty( $cat_list_community ) ) {
			$cat_list_community = @$CONFIG_EXT['cat_list_community'];
		}
		if ( $cat_list_community == -1 ) {
			$cat_list_community = '';
		}
		$exclude_community = $pageParams->get( 'cat_list_community_exclude' );
		// read RSVP categories list
		$config = new JConfig();
		$query = "SELECT e.*, DATE_FORMAT( e.startdate, '%Y%m%d' ) as date, c.name as cat_name
			, DATE_ADD(e.startdate, INTERVAL (-1 * {$config->offset}) HOUR) AS utcdatetimestart
			, DATE_ADD(e.enddate, INTERVAL (-1 * {$config->offset}) HOUR) AS utcdatetimeend
			FROM #__community_events as e
			LEFT JOIN #__community_events_category as c
			ON c.id = e.catid
			WHERE e.published = '1'";
		// apply category restrictions
		if ( !empty( $cat_list_community ) ) {
			$query .= " AND e.catid ".( $exclude_community ? 'NOT' : '' )." IN ( " . (is_array($cat_list_community) ? implode(',', $cat_list_community) : $cat_list_community) . " )";
		}
		// apply sort order
		$query .= " ORDER BY e.startdate, e.title ASC";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		if (!empty($extra_rows)) {
			foreach ( $extra_rows as $i => $row ) {
				$row->cat_ext = 'community';
				$row->extid = $row->id;
				$row->start_date = $row->utcdatetimestart;//startdate;
				$row->end_date = $row->utcdatetimeend;//enddate;
				if ( in_array( $row->cat_name, array_keys( $catnames ) ) ) {
					$row->color = $catnames[$row->cat_name];
				} else {
					$row->color = $CONFIG_EXT['color_community'];
				}
				$rows[$row->date.'_c_'.$i] = $row;
			}
		}
	}

	if ( !empty( $rows ) ) {
		ksort( $rows );
		$events = array_values( $rows );
	}

	jclKeepOnlyRecurNext( $events, $endOfLastDaySql);
		$resultCache[$queryId] = $events;

	}

	$eventsRead = $resultCache[$queryId];

	// build record for returning results
	$events = array();
	if (!empty( $eventsRead)) {
		$recIdsList = array();
		foreach( $eventsRead as $event) {
			$events[] = array( $event->extid, jcUTCDateToTs( $event->start_date), jcUTCDateToTs($event->end_date), $event);
		}
	}

	// we have an array with all events in the range. Need to split them by day
	// iterate over events and find which day they are on
	// when that is done, we can apply show multidays events settings by discarding some
	$returnEvents = false;
	foreach( $events as $event) {
		if (jclIsAllDay( $event[3]->end_date) || jclIsNoEndDate( $event[3]->end_date)) {
			// all-day and no-end date events : special case
			$endOfDayTS = startOfDayInUserTime( $event[1])  + 86399;  // end of day where start of event falls
			if ($endOfDayTS >= $startTS) {
				$day = intval(jcUTCDateToFormat( $event[1], '%d'));
				$returnEvents[$day][] = $event;
			}
		} else {
			// apply multi_days settings
			switch ($CONFIG_EXT['multi_day_events']) {
				case 'start':
					// show only start day
					$endOfDayTS = startOfDayInUserTime( $event[1])  + 86399;  // end of day where start of event falls
					if ($endOfDayTS >= $startTS) {
					$day = intval(jcUTCDateToFormat( $event[1], '%d'));
					$returnEvents[$day][] = $event;
					}
					break;
				case 'bounds':
					// show start and end day of events
					$endOfDayTS = startOfDayInUserTime( $event[1])  + 86399;  // end of day where start of event falls
					if ($endOfDayTS >= $startTS && $endOfDayTS <= $endTS) {
					$dayEnd = intval(jcUTCDateToFormat( $event[1], '%d'));
					$returnEvents[$dayEnd][] = $event;
					}
					// show end date
					$startOfDayTS = startOfDayInUserTime( $event[2]);  // start of day where end of event falls
					if ($startOfDayTS >= $startTS && $startOfDayTS <= $endTS) {
					$dayStart = intval(jcUTCDateToFormat( $event[2], '%d'));
					if ($dayStart != $dayEnd) {
						$returnEvents[$dayStart][] = $event;
					}
					}
					break;
				default:
					// show all days of events, no restriction
					$startOfDayTS = startOfDayInUserTime( $event[1]);  // start of day where start of events falls
					while ( $startOfDayTS <= $event[2]) {  // until we're past end of event
					$endOfDayTS = $startOfDayTS + 86399; // end of day where start of event falls
					if (($endOfDayTS >= $startTS && $endOfDayTS <= $endTS) || ($startOfDayTS >= $startTS && $startOfDayTS <= $endTS)) {  // either of those fall within the time range we are displaying
						$day = intval(jcUTCDateToFormat( $startOfDayTS, '%d'));    // store the event for that day
						$returnEvents[$day][] = $event;
					}
					// move 24 hrs forward
					$startOfDayTS += 86400;
					}

					break;
			}
		}
	}

	return $returnEvents;
}


/*
 * Check a set of events for recurring events.
 * Remove all events except next occurence (from today)
 * if parameters ask for that
 * of a repetition
 */
function jclKeepOnlyRecurNext( & $events, $upperLimit) {

	global $CONFIG_EXT, $today;

	if ($CONFIG_EXT['show_recurrent_events'] != JCL_SHOW_RECURRING_EVENTS_NEXT_ONLY || empty( $events)) {
		return;
	}

	// extract recurring events, and sort them by recurrence id
	$recEvents = array();
	$size = count( $events);
	for( $i = 0; $i < $size; $i++) {
		// if a recurrent event, put it to working copy
		if ($events[$i]->rec_type_select != JCL_REC_TYPE_NONE) {
			$id = empty( $events[$i]->rec_id) ? $events[$i]->extid : $events[$i]->rec_id;
			$recEvents[$id][] = $i;
		}
	}
	// read from db any event from the same rec series, between today (in user time) and the end of the requested period
	$startOfToday = jcUserTimeToUTC( 0, 0, 0, $today['month'], $today['day'], $today['year']);
	$db = & JFactory::getDBO();
	$startOfTodaySql = $db->Quote( $startOfToday);

	if (!empty( $recEvents)) {
		$nextRecEvents = array();
		foreach( $recEvents as $recId => $eventList) {
			// find next event for this recurrence
			$query = 'select ' . $db->nameQuote( 'extid') . ' from ' . $CONFIG_EXT['TABLE_EVENTS'];
			$query .= ' where ' . $db->nameQuote( 'extid') . ' = ' . $db->Quote( $recId);
			$query .= ' or ' . $db->nameQuote( 'rec_id') . ' = ' . $db->Quote( $recId);
			$query .= " and (    ( start_date <= $startOfTodaySql AND end_date >= $upperLimit ) ";
			$query .= "  OR ( start_date >= $startOfTodaySql AND start_date <= $upperLimit ) ";
			$query .= "  OR ( end_date > $startOfTodaySql AND end_date <= $upperLimit ) )";
			$query .= ' order by start_date asc ';
			$db->setQuery( $query);
			$nextRecEvents[$recId] = $db->loadResult();
		}
	}

	// we have all events, and we also have an array holding the extid of the next recurrence (next from today)
	// for each recurrence series
	// now we drop all events which are not that next recurrence
	foreach( $recEvents as $recId => $eventList) {
		foreach($eventList as $eventId)
		// if current event in the rec event list is not the last, as read in db, discard it
		if ($events[$eventId]->extid != $nextRecEvents[$recId] ) {
			unset($events[$eventId]);
		}
	}
}


/*
 * Check a set of events for recurring events.
 * Remove all events that are not astarting or trailing instance
 * of a repetition
 */
function jclKeepOnlyRecurBounds( & $events) {

	global $CONFIG_EXT;

	if ($CONFIG_EXT['multi_day_events'] != 'bounds' || empty( $events)) {
		return;
	}

	// extract recurring events, and sort them by recurrence id, only keeping child events
	$recEvents = array();
	$size = count( $events);
	for( $i = 0; $i < $size; $i++) {
		// if this is a child event
		if ($events[$i]->rec_type_select != JCL_REC_TYPE_NONE && $events[$i]->rec_id != 0) {
			$recEvents[$events[$i]->rec_id][] = $i;
		}
	}
	// read from db the last event in all recurrences
	if (!empty( $recEvents)) {
		$lastEvents = array();
		foreach( $recEvents as $recId => $eventList) {
			$db = & JFactory::getDBO();
			// find last event for this recurrence
			$query = 'select ' . $db->nameQuote( 'extid') . ' from ' . $CONFIG_EXT['TABLE_EVENTS'];
			$query .= ' where ' . $db->nameQuote( 'extid') . ' = ' . $db->Quote( $recId);
			$query .= ' or ' . $db->nameQuote( 'rec_id') . ' = ' . $db->Quote( $recId);
			$query .= ' order by start_date desc ';
			$db->setQuery( $query);
			$lastEvents[$recId] = $db->loadResult();
		}
	}

	// we have all events, and we also have an array holding the extid of the last event in each recurrence
	// now we drop all events which are not either the first or the last in a series
	foreach( $recEvents as $recId => $eventList) {
		foreach($eventList as $eventId)
		// if current event in the rec event list is not the last, as read in db, discard it
		if ($events[$eventId]->extid != $lastEvents[$recId] ) {
			unset($events[$eventId]);
		}
	}

}

function get_cat_info ($cat_id) {
	// function that returns a category name if it exists, given a cat_id
	global $CONFIG_EXT;

	$db = &JFactory::getDBO();

	if (!$cat_id) {
		return false;
	}
	//query db
	$query = "SELECT cat_id, cat_name, description FROM " . $CONFIG_EXT['TABLE_CATEGORIES'] . " WHERE published = 1 and cat_id = '$cat_id'";
	$db->setQuery($query);
	$cat_info = $db->loadAssoc();
	// return if no cats with this id
	if (empty( $cat_info)) {
		return false;
	}

	return $cat_info;
}

function get_active_categories( $applyMenuRestrictions = false) {

	// function that returns a list of categories that a user is allowed to see
	global $CONFIG_EXT, $cat_list;

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );
	$db = &JFactory::getDBO();

	// if told so, apply cat list restrictions set in menu item
	$where = ' where c.published = 1 AND e.cat IS NOT NULL';
	if (!empty( $cat_list)) {
		$where .= ' AND c.cat_id in (' . $cat_list . ')';
	}

	$query = "SELECT c.cat_id, c.cat_name, c.description AS cat_desc, c.color FROM ".$CONFIG_EXT['TABLE_CATEGORIES']." as c
		LEFT JOIN ".$CONFIG_EXT['TABLE_EVENTS'] . " AS e
		ON e.cat = c.cat_id";
	$query .= $where." GROUP BY c.cat_id ORDER BY c.cat_name";
	$db->setQuery($query);
	$raw_cat_list = $db->loadAssocList();

	$catnames = array();
	foreach ( $raw_cat_list as $row ) {
		$catnames[] = $row['cat_name'];
	}

	if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && @$CONFIG_EXT['show_illbethere'] ) ) {
		$cat_list_illbethere = jclValidateList( $pageParams->get( 'cat_list_illbethere' ) );
		if ( empty( $cat_list_illbethere ) ) {
			$cat_list_illbethere = @$CONFIG_EXT['cat_list_illbethere'];
		}
		if ( $cat_list_illbethere == -1 ) {
			$cat_list_illbethere = '';
		}
		$exclude_illbethere = $pageParams->get( 'cat_list_exclude_illbethere' );
		// read RSVP categories list
		$query = "SELECT c.*, IF(ISNULL(j.color),'',j.color) AS color FROM #__illbethere_categories as c
			LEFT JOIN #__illbethere_sessions AS e
			ON e.cat_id = c.cat_id
			LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS j
			ON c.name = j.cat_name
			WHERE c.published = '1'
			AND e.cat_id IS NOT NULL";
		// apply category restrictions
		if ( !empty( $cat_list_illbethere ) ) {
			$query .= " AND c.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
		}
		// apply sort order
		$query .= " GROUP BY c.cat_id ORDER BY c.name";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadAssocList();

		foreach ( $extra_rows as $row ) {
			if ( !in_array( $row['name'], $catnames ) ) {
				$row['cat_ext'] = 'illbethere';
				$row['cat_name'] = $row['name'];
				$row['cat_desc'] = $row['description'];
				if (empty($row['color'])) {
					$row['color'] = $CONFIG_EXT['color_illbethere'];
				}
				$raw_cat_list[] = $row;
			}
		}
	}

	if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && @$CONFIG_EXT['show_community'] ) ) {
		$cat_list_community = jclValidateList( $pageParams->get( 'cat_list_community' ) );
		if ( empty( $cat_list_community ) ) {
			$cat_list_community = @$CONFIG_EXT['cat_list_community'];
		}
		if ( $cat_list_community == -1 ) {
			$cat_list_community = '';
		}
		$exclude_community = $pageParams->get( 'cat_list_community_exclude' );
		// read JomSocial categories list
		$query = "SELECT c.*, IF(ISNULL(j.color),'',j.color) AS color FROM #__community_events_category as c
			LEFT JOIN #__community_events AS e
			ON e.catid = c.id
			LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS j
			ON c.name = j.cat_name
			WHERE e.catid IS NOT NULL";
		// apply category restrictions
		if ( !empty( $cat_list_community ) ) {
			$query .= " AND c.id ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
		}
		// apply sort order
		$query .= " GROUP BY c.id ORDER BY c.name";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadAssocList();

		foreach ( $extra_rows as $row ) {
			if ( !in_array( $row['name'], $catnames ) ) {
				$row['cat_ext'] = 'community';
				$row['cat_id'] = $row['id'];
				$row['cat_name'] = $row['name'];
				$row['cat_desc'] = $row['description'];
				if (empty($row['color'])) {
					$row['color'] = $CONFIG_EXT['color_community'];
				}
				$raw_cat_list[] = $row;
			}
		}
	}

	// remove events if user is not authorized
	$cat_list = array();
	if (!empty( $raw_cat_list)) {
		foreach( $raw_cat_list as $cat) {
			if ( @$row['cat_ext'] || has_priv ( 'category' . @$cat['cat_id'] ) ) {
				$cat_list[] = $cat;
			}
		}
	}

	return $cat_list;
}

function sort_events($events, &$event_stack, $date_stamp) {

	while (list(,$event_info) = each($events))
	{
		$event_style = jclGetStyle($date_stamp,$event_info[1],$event_info[2]);

		if($event_style=="eventstart" && !in_array($event_info[0], $event_stack)) $event_stack[] = $event_info[0];
	}

	reset($events);
	while (list(,$event_info) = each($events))
	{
		$event_style = jclGetStyle($date_stamp,$event_info[1],$event_info[2]);

		if($event_style=="eventend" && in_array($event_info[0], $event_stack)) {
			for($key=0;$key<count($event_stack);$key++)
			if($event_stack[$key]==$event_info[0]) break;
			array_splice($event_stack, $key);
		}
	}
	reset($events);
	return $events;
}

function get_display_style ($name,$type, $forced = '') {
	global $CONFIG_EXT;

	$status = 0;
	$return_value = array("display: none","display: show");
	if ($forced != 'forced') {
		$cookie_name = $CONFIG_EXT['cookie_name']."_hidden_display";
		if (!empty($_COOKIE[$cookie_name])) {
			$items = explode(',',$_COOKIE[$cookie_name]);
			$status = true;//in_array($name,$items);
		} else {
			$status = true;
		}
	} else {
		$status = false;
	}
	if($type == "close")
	return $status?$return_value[1]:$return_value[0];
	elseif($type == "open")
	return $status?$return_value[0]:$return_value[1];
}

function invoke_code($component,$params) {
	// function that invokes a component with and returns output for display
	global $CONFIG_EXT, $lang_system;

	switch($component) {
		case "minicalendar":
			$output_buffer = print_mini_cal_view($params);
			return array('status' => true, 'html' => $output_buffer);
			break;
		default:
			return array('status' => false, 'html' => $lang_system['unknown_component']);
			break;
	}
}

function get_language_name($language_dir) {
	// returns the name and native name of a given language
	$language_names = array(
		'arabic' => array('Arabic','&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;'),
		'bosnian' => array('Bosnian','Bosanski'),
		'brazilian_portuguese' => array('Portuguese [Brazilian]'),
		'bulgarian' => array('Bulgarian','&#1041;&#1098;&#1083;&#1075;&#1072;&#1088;&#1089;&#1082;&#1080;'),
		'chinese_big5' => array('Chinese-Big5','&#21488;&#28771;'),
		'chinese_gb' => array('Chinese-GB2312','&#20013;&#22269;'),
		'croatian' => array('Croatian(Hrvatski'),
		'czech' => array('Czech(&#x010C;esky'),
		'danish' => array('Danish','Dansk'),
		'dutch' => array('Dutch','Nederlands'),
		'english' => array('English','English'),
		'estonian' => array('Estonian','Eesti'),
		'finnish' => array('Finnish','Suomea'),
		'french' => array('French','Fran&ccedil;ais'),
		'german' => array('German','Deutsch','de'),
		'greek' => array('Greek','&#917;&#955;&#955;&#951;&#957;&#953;&#954;&#940;'),
		'hebrew' => array('Hebrew','&#1506;&#1489;&#1512;&#1497;&#1514;'),
		'hungarian' => array('Hungarian','Magyarul'),
		'indonesian' => array('Indonesian','Bahasa Indonesia'),
		'italian' => array('Italian','Italiano'),
		'japanese' => array('Japanese','&#26085;&#26412;&#35486;'),
		'korean' => array('Korean','&#54620;&#44397;&#50612;'),
		'latvian' => array('Latvian','Latvian'),
		'norwegian' => array('Norwegian','Norsk'),
		'polish' => array('Polish','Polski'),
		'portuguese' => array('Portuguese [Portugal]','Portugu&ecirc;s'),
		'russian' => array('Russian','&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;'),
		'slovak' => array('Slovak','Slovensky'),
		'slovenian' => array('Slovenian','Slovensko'),
		'spanish' => array('Spanish','Espa&ntilde;ol'),
		'swedish' => array('Swedish','Svenska'),
		'thai' => array('Thai','&#3652;&#3607;&#3618;'),
		'turkish' => array('Turkish','T&uuml;rk&ccedil;e'),
		'vietnamese' => array('Vietnamese')
	);
	$name = count($language_names[$language_dir])==2?$language_names[$language_dir][0]." (".$language_names[$language_dir][1].")":$language_names[$language_dir][0];
	return isset($language_names[$language_dir])?$name:$language_dir;
}
/**
 * Returns string with html entities decode
 * UTF-8 and PHP 4 compatible
 *
 * @param unknown_type $string
 */
function sh_html_entity_decode ($string) {

	if (version_compare(PHP_VERSION, '5.0.0') === -1) {
		jimport( 'tcpdf.html_entity_decode_php4');
		$tmp = html_entity_decode_php4( $string);
		$tmp = str_replace( '&quot;', '"', $tmp); // tcpdf does not decode &quot; - this is equivalent to ENT_COMPAT
		return $tmp;
	} else {
		return html_entity_decode( $string);
	}
}

/**
 * Redirect to another location
 * (c) Yannick Gaultier - 2008
 *
 * @param unknown_type $url
 * @param unknown_type $msg
 * @param unknown_type $redirKind
 * @param unknown_type $msgType
 */
function jc_shRedirect( $url, $msg='', $redirKind = '301', $msgType='message' ) {

	global $mainframe, $sefConfig;

	// specific filters
	if (class_exists('InputFilter')) {
		$iFilter = new InputFilter();
		$url = $iFilter->process( $url );
		if (!empty($msg)) {
			$msg = $iFilter->process( $msg );
		}

		if ($iFilter->badAttributeValue( array( 'href', $url ))) {
			$url = $GLOBALS['shConfigLiveSite'];
		}
	}

	// If the message exists, enqueue it
	if (JString::trim( $msg )) {
		$mainframe->enqueueMessage($msg, $msgType);
	}

	// Persist messages if they exist
	if (count($mainframe->_messageQueue))
	{
		$session =& JFactory::getSession();
		$session->set('application.queue', $mainframe->_messageQueue);
	}

	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		@ob_end_clean(); // clear output buffer
		switch ($redirKind) {
			case '302':
				$redirHeader ='HTTP/1.1 302 Moved Temporarily';
				break;
			case '303':
				$redirHeader ='HTTP/1.1 303 See Other';
				break;
			default:
				$redirHeader = 'HTTP/1.1 301 Moved Permanently';
				break;
		}
		header( $redirHeader );
		header( "Location: ". str_replace( '&amp;', '&', $url) );
	}
	$mainframe->close();
}

/**
 * Build an html select list of existing calendars, with redirect on onchange events
 *
 * Manages permissions when building the list
 * @param integer $cal_id pre-selected calendar id
 */
function jclBuildCalendarList( $cal_id = null, $baseUrl = '') {

	global $CONFIG_EXT, $lang_general, $mainframe;

	// init return string
	$cal_list = '';

	// if multiple calendars allowed
	if ($CONFIG_EXT['enable_multiple_calendars']) {

		// this particular menu item may be restricted to showing a list of calendars
		// get default vars set by admin either globally or on a menu item basis
		if ($mainframe->isSite()) {
			$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');
			$list =  $pageParams->get( 'cal_list');
		} else {
			$list = null;
		}
		$cal_list = jclValidateList( $list);

		// get database instance
		$db = & JFactory::getDBO();

		// build calendars list
		$cal_filter = ' WHERE ' . ( !empty( $cal_list) ? '(cal_id in (' . $cal_list . ') AND ' : '') . "(published = '1' OR cal_id = '$cal_id')" . ( !empty( $cal_list) ? ')' : '') . " ORDER BY cal_name";
		$query = "SELECT * FROM ".$CONFIG_EXT['TABLE_CALENDARS'] . $cal_filter;
		$db->setQuery( $query);
		$raw_cal_list = $db->loadObjectList();

		// if only one calendar, don't show list anyway
		if (count( $raw_cal_list) > 1) {
			// target url
			if (empty( $baseUrl)) {
				$baseUrl = $CONFIG_EXT['calendar_calling_page'];
			}

			// insert first a
			$cal_list = "\t<option value='".(JRoute::_( $baseUrl))."' >" . $lang_general['any_calendar'] . "</option>\n";

			// complete base url for adding cal ids
			$baseUrl .= '&amp;cal_id=';

			// remove calendars if user is not authorized
			if (!empty( $raw_cal_list)) {
				foreach( $raw_cal_list as $cal) {
					if ( has_priv ( 'calendar' . $cal->cal_id ) ) {
					$selected = ($cal->cal_id == $cal_id)?'selected="selected"':'';
					$cal_list .= "\t<option value='".(JRoute::_( $baseUrl . $cal->cal_id))."'  $selected>".$cal->cal_name."</option>\n";
					}
				}
			}
		} else {
			// only one cal, clear the list
			$cal_list = '';
		}
	}

	// return list
	return $cal_list;

}

/**
 * Build an html select list of existing calendars, with id as options
 *
 * Manages permissions when building the list
 * @param integer $cal_id pre-selected calendar id
 */
function jclBuildSimpleCalendarList( $cal_id = null) {

	global $CONFIG_EXT, $lang_general, $mainframe;

	// init return string
	$cal_list = '';

	// if multiple calendars allowed
	if ($CONFIG_EXT['enable_multiple_calendars']) {

		// this particular menu item may be restricted to showing a list of calendars
		// get default vars set by admin either globally or on a menu item basis
		if ($mainframe->isSite()) {
			$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');
			$list = $pageParams->get( 'cal_list');
		} else {
			$list = null;
		}
		$cal_list = jclValidateList( $list);

		// get database instance
		$db = & JFactory::getDBO();

		// build calendars list
		$cal_filter = ' WHERE ' . ( !empty( $cal_list) ? '(cal_id in (' . $cal_list . ') AND ' : '') . "(published = '1' OR cal_id = '$cal_id')" . ( !empty( $cal_list) ? ')' : '') . " ORDER BY cal_name";
		$query = "SELECT * FROM ".$CONFIG_EXT['TABLE_CALENDARS'] . $cal_filter;
		$db->setQuery( $query);
		$raw_cal_list = $db->loadObjectList();

		// remove calendars if user is not authorized
		if (!empty( $raw_cal_list)) {
			foreach( $raw_cal_list as $cal) {
				if ( has_priv ( 'calendar' . $cal->cal_id ) ) {
					$selected = ($cal->cal_id == $cal_id)?'selected="selected"':'';
					$cal_list .= "\t<option value='". $cal->cal_id."'  $selected>".$cal->cal_name."</option>\n";
				}
			}
		}
	}

	// return list
	return $cal_list;

}

function jclGetPhpTimezonesList() {

	static $zones = array();

	$serverTZ = jclPhpManageTZ();
	if (empty( $serverTZ)) {
		// PHP cannot manage timezones (probably less than 5.1.0
		return $zones;
	}
	//php can manage, let's get and store zones
	// adapted from david at mytton dot net, from php.net/timezone_identifiers_list
	if (empty( $zones)) {
		$all = timezone_abbreviations_list();
		foreach ($all as $zoneAbbr) {
			if (!empty($zoneAbbr)) {
				foreach($zoneAbbr as $zone) {
					$zone['timezone_id'] = jclWorkaroundPHPBug51819( $zone['timezone_id']);
					$zoneName = explode('/', $zone['timezone_id']); // 0 => Continent, 1 => City

					// Only use "friendly" continent names
					if ($zoneName[0] == 'Africa' || $zoneName[0] == 'America' || $zoneName[0] == 'Antarctica' || $zoneName[0] == 'Arctic' || $zoneName[0] == 'Asia' || $zoneName[0] == 'Atlantic' || $zoneName[0] == 'Australia' || $zoneName[0] == 'Europe' || $zoneName[0] == 'Indian' || $zoneName[0] == 'Pacific') {
					if (!empty($zoneName[1])) {
						$continent = $zoneName[0];
						$city = $zoneName[1];
						$subcity = isset($zoneName[2]) ? $zoneName[2] : '';
						$display = $zoneName[0] . '/' . str_replace('_', ' ', $zoneName[1]);
						if (empty($zones[$display])) {
							$zones[$display]['continent'] = $continent;
							$zones[$display]['city'] = $city;
							$zones[$display]['subcity'] = $subcity;
							// remove display of current offset, too confusing for users
							$zones[$display]['display'] = $display; // . ' (' . jcTimeZoneToText(floatval($zone['offset']) / 3600) . ')';
							$zones[$display]['offset'] = floatval( $zone['offset']);
							$zones[$display]['timezone_id'] = $zone['timezone_id'];
						}
					}
					}
				}
			}
		}
	}

	// sort array
	asort( $zones);

	return $zones;
}

/*
 * http://bugs.php.net/bug.php?id=51819
 * 
 */
function jclWorkaroundPHPBug51819( $zoneId) {
	
	$bad= array( 'Australia/ACT', 'Australia/LHI', 'Australia/NSW', 'Europe/Isle_of_Man');
	$good = array( 'Australia/Act', 'Australia/Lhi', 'Australia/Nsw', 'Europe/Isle_Of_Man');
	$id = str_replace( $bad, $good, $zoneId);

	return $id;
}

/**
 * Find a timezone php id by its offset from UTC
 *
 * @param <type> $offset
 * @return <type>
 */
function jclGetPhpTimezoneByOffset( $offset) {

	$serverTZ = jclPhpManageTZ();
	if (empty( $serverTZ)) {
		// PHP cannot manage timezones (probably less than 5.1.0
		return '';
	}

	$zones = jclGetPhpTimezonesList();
	$offset = floatval($offset) * 3600;
	foreach( $zones as $zone) {
		if($zone['offset'] == $offset) {
			return $zone['timezone_id'];
		}
	}

	return '';
}

/**
 * Builds html select from PHP supplied timezones list
 * @param <type> $current if non empty, will be pre-selected in the select list
 */
function jclBuildPhpTimezonesList( $current = '') {

	$serverTZ = jclPhpManageTZ();
	if (empty( $serverTZ)) {
		// PHP cannot manage timezones (probably less than 5.1.0
		return '';
	}
	// php handles timezones, let's build the list
	// adapted from vats_tco at comcast dot net, from php.net/timezone_identifiers_list
	$zones = jclGetPhpTimezonesList();
	$structure = '';
	foreach($zones AS $zone) {
		extract($zone);
		if(!isset($selectcontinent)) {
			$structure .= '<optgroup label="'.$continent.'">'; // continent
		} elseif($selectcontinent != $continent) {
			$structure .= '</optgroup><optgroup label="'.$continent.'">'; // continent
		}

		if(isset($city) != ''){
			if (!empty($subcity) != ''){
				$city = $city . '/'. $subcity;
			}
			$structure .= "<option ".((($continent.'/'.$city)==$current)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".$display."</option>"; //Timezone
		} else {
			if (!empty($subcity) != ''){
				$city = $city . '/'. $subcity;
			}
			$structure .= "<option ".(($continent==$current)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>"; //Timezone
		}

		$selectcontinent = $continent;
	}
	$structure .= '</optgroup>';

	return $structure;
}

/**
 * Fetch user name from db, caches results
 *
 * @param integer $id the requested user id
 * @param integer $trimTo maximum lenght of the return name
 * @returd string : the trimmed user name
 */
function jclGetEventOwner( $id, $trimTo = 0) {

	static $names = array();

	// no id, no name
	$id = intval( $id);
	if (empty( $id)) {
		return '';
	}

	// valid id
	if (empty( $names[$id])) {
		// not in cache, read from DB
		$db =& JFactory::getDBO();
		$query = 'select username from #__users where ' . $db->nameQuote( 'id') . '=' . $db->Quote( $id);
		$db->setQuery( $query);
		$names[$id] = $db->loadResult();
	}

	// return cached value
	return $trimTo == 0 ? $names[$id] : JString::substr( $names[$id], $trimTo);

}

/**
 * Fetch calendar name from db, caches results
 *
 * @param integer $id the requested calendar id
 * @param integer $trimTo maximum lenght of the return name
 * @returd string : the trimmed user name
 */
function jclGetCalendarName( $id, $trimTo = 0) {

	static $names = array();

	// no id, no name
	$id = intval( $id);
	if (empty( $id)) {
		return '';
	}
	// valid id
	if (empty( $names[$id])) {
		// not in cache, read from DB
		$db =& JFactory::getDBO();
		$query = 'select cal_id, cal_name from #__jcalpro2_calendars';
		$db->setQuery( $query);
		$result = $db->loadObjectList( 'cal_id');
		if (!empty( $result)) {
			foreach($result as $cal) {
				$names[$cal->cal_id] = $cal->cal_name;
			}
		}
	}

	// return cached value
	return $trimTo == 0 ? $names[$id] : JString::substr( $names[$id], $trimTo);

}

/**
 * Fetch category name from db, caches results
 *
 * @param integer $id the requested category id
 * @param integer $trimTo maximum lenght of the return name
 * @returd string : the trimmed user name
 */
function jclGetCategoryName( $id, $trimTo = 0) {

	static $names = array();

	// no id, no name
	$id = intval( $id);
	if (empty( $id)) {
		return '';
	}
	// valid id
	if (empty( $names[$id])) {
		// not in cache, read from DB
		$db =& JFactory::getDBO();
		$query = 'select cat_id, cat_name from #__jcalpro2_categories';
		$db->setQuery( $query);
		$result = $db->loadObjectList( 'cat_id');
		if (!empty( $result)) {
			foreach($result as $cat) {
				$names[$cat->cat_id] = $cat->cat_name;
			}
		}
	}

	// return cached value
	return $trimTo == 0 ? $names[$id] : JString::substr( $names[$id], $trimTo);

}

/**
 * Returns a string with a list of all categories published
 */
function jclGetCategories() {

	static $cats = null;

	if (is_null( $cats)) {

		// not in cache, read from DB
		$db =& JFactory::getDBO();
		$query = 'select cat_id from #__jcalpro2_categories where ' . $db->nameQuote('published') . '='.$db->Quote( '1');
		$db->setQuery( $query);
		$result = $db->loadResultArray();
		if (!empty( $result)) {
			$cats = implode( ',', $result);
		}
	}
	return $cats;
}

/**
 * Returns a string with a list of all calendars published
 */
function jclGetCalendars() {

	static $cals = null;

	if (is_null( $cals)) {

		// not in cache, read from DB
		$db =& JFactory::getDBO();
		$query = 'select cal_id from #__jcalpro2_calendars where ' . $db->nameQuote('published') . '='.$db->Quote( '1');
		$db->setQuery( $query);
		$result = $db->loadResultArray();
		if (!empty( $result)) {
			$cals = implode( ',', $result);
		}
	}
	return $cals;
}

/**
 * Return a list of id, prepared for use in a in .. sql clause
 *
 * @param string $list  the list as entered by user, supposed to be 3,45 ,67
 */
function jclValidateList( $list) {
	if (!is_array($list)) {
		$list = explode( ',', $list);
	}
	$output = '';
	if (!empty( $list)) {
	$output = array();
		foreach($list as $listItem) {
			$item = intval( $listItem);
			if (!empty( $item)) {
				$output[] = $item;
			}
		}
		$output = implode( ',', $output );
	}
	return $output;
}

/**
 * Return a list of id, prepared for use in a in .. sql clause
 * only inlcuding those items the current user can see
 *
 * @param string $list  the list as entered by user, supposed to be 3,45 ,67
 * @param string $kind  in ['category', 'calendar']
 */
function jclValidateAndCheckAuthList( $list, $kind) {
	// now check authorization
	if (!is_array($list)) {
		$list = explode( ',', $list);
	}
	$output = '';
	if (!empty( $list)) {
		foreach($list as $listItem) {
			$item = intval( $listItem);
			if (!empty( $item)) {
				// only add to output if allowed to see
				if (has_priv ( $kind . $item )) {
					$output .= ', ' . $item;
				}
			}
		}
		$output = JString::trim( $output, ' ,');
	}
	return $output;
}

/*
 * Builds a radio list where each item can have its own
 * event handler (joomla library does not allow this)
 *
 */
function jclBuildRadioList( $options, $name, $selected = null, $idtag = null, $translate = false, $vertical = false) {

	$html = '';
	if (empty( $options)) {
		return $html;
	}

	// build list
	$count = 0;
	foreach ($options as $option) {
		if ($vertical && $count != 0) {
			// vertical list, add a br
			$html .= '<br />';
		}
		$currentId = (empty($option['id']) ? (empty($idtag) ? $name.$count: $idtag): $option['id']);
		$checked =  !is_null( $selected) && $option['value'] == $selected;
		$html .= jclBuildRadioListItem( $name, $currentId, $option['value'], $checked, $option['text'], $option['attrib'], $translate);
		$count++;
	}

	return $html;
}

/*
 * Builds a list of hidden fields
 *
 */
function jclBuildHiddenFields( $options) {

	jimport( 'joomla.utilities.array');

	$html = '';
	if (empty( $options)) {
		return $html;
	}

	// build list
	foreach ($options as $option) {
		$attributes = JArrayHelper::toString( $option);
		$html .= '<input type="hidden" ' . $attributes . " />\n";
	}

	return $html;
}

/**
 Builds a radio list item
 */
function jclBuildRadioListItem( $name, $id, $value, $checked, $text, $attrib, $translate = false) {

	$html = '';
	// input tag
	$html .= '<input type="radio" name="' . $name .'"';
	$html .= ' id="' . $id . '"';
	$html .= ' value="' . $value . '"';
	$html .= empty( $checked) ? '' : ' checked="checked"';
	$html .= empty( $attrib) ? '' :  ' ' . $attrib;
	$html .= ' />';
	// label
	$text = $translate ? JText::_( $text) : $text;
	$html .= '<label for="' . $id . '">' . $text . '</label>';

	return $html;
}

function jclBuildDayOrderList( $name, $selected, $attrib) {

	global $lang_add_event_view;

	$options = array( JCL_REC_FIRST => $lang_add_event_view['rec_day_first']
	, JCL_REC_SECOND => $lang_add_event_view['rec_day_second']
	, JCL_REC_THIRD => $lang_add_event_view['rec_day_third']
	, JCL_REC_FOURTH => $lang_add_event_view['rec_day_fourth']
	, JCL_REC_LAST => $lang_add_event_view['rec_day_last']
	);

	return jclBuildGenericList( $name, $selected, $options, $attrib);
}

function jclBuildDayTypeList( $name, $selected, $attrib) {

	global $lang_date_format, $lang_add_event_view, $CONFIG_EXT;

	$options = array();
	$options[JCL_REC_DAY_TYPE_DAY] =  $lang_add_event_view['rec_day_day'];

	// loop through days of the week
	$start = !$CONFIG_EXT['day_start'] ? JCL_REC_DAY_TYPE_SUNDAY : JCL_REC_DAY_TYPE_MONDAY; // start on day as per user settings
	for ($i=$start; $i<8; $i++ ) {
		$options[$i] = JString::strtolower( $lang_date_format['day_of_week'][$i-1]);
	}
	if ($CONFIG_EXT['day_start']) {
		// let's not forget Sunday
		$options[JCL_REC_DAY_TYPE_SUNDAY] = JString::strtolower( $lang_date_format['day_of_week'][0]);
	}
	/*  Not yet!
	* $options[JCL_REC_DAY_TYPE_WEEK_DAY] =  $lang_add_event_view['rec_day_week_day'];
	* $options[JCL_REC_DAY_TYPE_WEEKEND_DAY] =  $lang_add_event_view['rec_day_weekend_day'];
	*/

	return jclBuildGenericList( $name, $selected, $options, $attrib);
}

function jclBuildGenericList( $name, $selected, $options, $attrib) {

	// build the list of options
	$list = array();
	foreach( $options as $value => $text) {
		$list[] = JHTML::_( 'select.option', $value, $text);
	}

	// build the select list itself
	$html = JHTML::_( 'select.genericlist', $list, $name, $attrib, 'value', 'text', $selected);

	return $html;
}

function jclBuildMonthsOptionsList( $selected) {

	global $lang_date_format;

	$html = '';
	for($i=1;$i<=12;$i++) {
		$selected = ( $selected == $i) ? 'selected="selected"':'';
		$html .= "\t<option value='".$i."' $selected>".$lang_date_format['months'][$i-1]."</option>\n";
	}

	return $html;
}

/**
 * Builds a checkboxes lists
 */
function jclBuildCheckBoxesList( $options, $translate = false, $vertical = false) {

	$html = '';
	if (empty( $options)) {
		return $html;
	}

	// build list
	$count = 0;
	foreach ($options as $option) {
		if ($vertical && $count != 0) {
			// vertical list, add a br
			$html .= '<br />';
		}
		$html .= "\n\t" . '<input type="checkbox" ';
		if (!empty( $option['name'])) {
			$html .= ' name="' . $option['name']. '"';
		}
		if (!empty( $option['id'])) {
			$html .= ' id="' . $option['id']. '"';
		}
		$html .= ' value="' . $option['value'] . '"';
		if (!empty( $option['checked'])) {
			$html .= ' checked="' . $option['checked'] . '"';
		}
		$html .= ' />';
		$html .= $option['text'];

		$count++;
	}

	return $html;
}

/**
 * Calculate the css style suited for a particular event
 *
 * @param integer $day_stamp
 * @param integer $start_stamp
 * @param integer $end_stamp
 * @param integer $recur_type
 * @param integer $rec_id
 * @param integer $detached_from_rec
 * @return string the css class
 */
function jclGetStyle($day_stamp,$start_stamp,$end_stamp, $recur_type = '', $rec_id = 0, $detached_from_rec = 0) {

	$startbound = jcUTCDateToFormat($day_stamp, '%Y%m%d') - jcUTCDateToFormat($start_stamp, '%Y%m%d'); // 0 means event starts same day
	$endbound = jcUTCDateToFormat($end_stamp, '%Y%m%d') - jcUTCDateToFormat($day_stamp, '%Y%m%d'); // 0 means event ends same day

	$class = "eventfull"; // default event class
	if(!$startbound && !$endbound) $class = "eventfull";
	elseif(!$startbound && $endbound>0) $class = "eventstart";
	elseif($startbound>0 && !$endbound) $class = "eventend";
	elseif($startbound>0 && $endbound>0) $class = "eventmiddle";

	// Jcal pro 2
	if ($rec_id && $detached_from_rec) {
		$class .= 'repeatdetached';
	} elseif ($rec_id) {
		$class .= 'repeatchild';
	} elseif ($recur_type != JCL_REC_TYPE_NONE) {
		$class .= 'repeat';
	}

	return $class;

}

/**
 * Returns a specific module instance data
 * Copied from JModuleHelper::getModule, but search by
 * id instead of title
 *
 * @param integer $id the module id
 */
function jclGetModuleById( $id) {

	$result = null;
	if (!empty( $id)) {
		$modules =& JModuleHelper::_load();
		$total = count($modules);
		for ($i = 0; $i < $total; $i++) {
			// Match the name of the module
			if ($modules[$i]->id == $id)
			{
				$result =& $modules[$i];
				break;  // Found it
			}
		}
	}
	return $result;
}

/**
 * Creates a unique id for a new event,
 * independant of current database id
 * for inter-systems communication
 *
 * @param object $event the to-be-created event
 * @return string a unique id
 */
function jclCreateEventCommonId( $event) {

	if (empty( $event)) {
		return '';
	}

	$commonId = md5( $event->cal_id . $event->cat . $event->rec_id . $event->owner_id . $event->title . $event->start_date . $event->end_date . time())
	. trim( JURI::base(), '/');

	return $commonId;
}

/**
 * Insert links to rss feeds in head of document
 *
 * @param string the already JRouted link to the feed
 */
function jclInsertFeedsLinks( $feedsLink) {

	if (!empty( $feedsLink )) {
		$document = & JFactory::getDocument();
		$type = $document->getType();
		if ($type == 'html') {
			$document->addHeadLink($feedsLink, 'alternate', 'rel', array( 'type' => 'application/rss+xml', 'title' => 'RSS 2.0'));
			$document->addHeadLink($feedsLink, 'alternate', 'rel', array( 'type' => 'application/atom+xml', 'title' => 'Atom 1.0'));
		}
	}
}

/*
 * Explode a date as entered by a user into its components
 * (day, month, year), using the date format that
 * was used for entry
 * Can only operate if separator is - / : _ +
 * @param string $date the user input
 * @format string the date format (strftime kind) used for input
 * @return object the extracted day, month and year
 */
function jclExtractDetailsFromDate( $date, $format) {

	$separators = '[-\/\:_+]';
	$pattern = '#[0-9]{1,4}' .$separators. '[0-9]{1,4}' .$separators. '[0-9]{1,4}$#iU';
	// check entry
	if (!$result = preg_match( $pattern, $date)) {
		return false;
	};

	// normalize format string to a - separator
	$format = preg_replace( '#' . $separators . '+#iU', '-', $format);
	$date = preg_replace( '#' . $separators . '+#iU', '-', $date);

	// now we can split both
	$formatBits = explode( '-', $format);
	$dateBits = explode( '-', $date);

	// check data size
	if (empty( $formatBits) || empty( $dateBits) || (count ($formatBits) != count($dateBits))) {
		return false;
	}

	// prepare result
	$details = new StdClass();

	// iterate over bits and basic validation
	for( $i = 0; $i < count( $formatBits); $i++) {
		switch ($formatBits[$i]) {
			case '%m' :
				$details->month = (int)$dateBits[$i];
				if ($details->month < 1 || $details->month > 12) {
					return false;
				}
				break;
			case '%d' :
				$details->day = (int)$dateBits[$i];
				if ($details->day < 1 || $details->day > 31) {
					return false;
				}
				break;
			case '%Y' :
				$details->year = (int)$dateBits[$i];
				if ($details->year < 1971 || $details->year > 2037) {
					return false;
				}
				break;
			default :
				return false;
				break;
		}
	}

	return $details;
}

/*
 * Get the correct target date for each view in the main menu
 * based on the current requested date
 */
function jclGetCurrentDatesByView( $currentDate) {

	$queries = array();
	if (!empty( $currentDate)) {
		// cal view : need to find 1st of month
		$queries['cal'] = '&amp;date=' . substr( $currentDate, 0, 8) . '01';
		// flat view, goes by the month as well
		$queries['flat'] = $queries['cal'];
		// week view : need to fin sunday or monday of the week
		$details = jclExtractDetailsFromDate( $currentDate, '%Y-%m-%d');
		$boundaries = get_week_bounds( $details->day, $details->month, $details->year);
		$queries['week'] = '&amp;date=' . $boundaries['first_day']['year'] . '-' . $boundaries['first_day']['month'] . '-' . $boundaries['first_day']['day'];
		//day and event view, just use the date
		$queries['day'] = '&amp;date=' . $currentDate;
		$queries['view'] = '&amp;date=' . $currentDate;
	} else {
		$queries['cal'] = '';
		$queries['flat'] = '';
		$queries['week'] = '';
		$queries['day'] = '';
		$queries['view'] = '';
	}
	return $queries;
}

function jclGetIgnoredKeywords() {
	global $CONFIG_EXT;
	$forced = explode(',', 'and,am,is,are,was,were,be,being,been,to,as,a,it,is');
	$configured = @$CONFIG_EXT['metadata_ignore_keywords'];
	$configured = strip_tags($configured);
	$cofigured = explode(',', $configured);
	if (!empty($configured) && is_array($configured)) {
		foreach ($configured as $key => $value) {
			$configured[$key] = trim($value);
		}
	}
	return array_merge((array) $configured, $forced);
}

function jclExtractKeywords($text) {
	global $CONFIG_EXT;
	$ignore = jclGetIgnoredKeywords();
	foreach ($ignore as $key => $val) {
		$ignore[$key] = trim($val);
	}
	$keywords = array();
	// hmm
	if (false === strpos($text, ' ')) {
		return $keywords;
	}
	// a little cleaning first
	$text = trim($text);
	$text = strip_tags($text);
	$words = explode(' ', $text);
	foreach ($words as $word) {
		$word = trim($word);
		if (in_array($word, $ignore)) {
			continue;
		}
		if (empty($word)) {
			continue;
		}
		if (!isset($keywords[$word])) {
			$keywords[$word] = 0;
		}
		$keywords[$word]++;
	}
	
	$finalWords = array();
	foreach ($keywords as $key => $value) {
		if (1 < $value) {
			$finalWords[] = $key;
		}
	}
	return $finalWords;
}

/**
 * adds metadata to the page header
 * 
 * @param $keywords
 * @param $description
 */
function jclSetPageMetadata($keywords='', $description='') {
	// get the global meta from configuration
	global $CONFIG_EXT;
	$metakeys = explode(',', @$CONFIG_EXT['metadata_global_keywords'].'');
	$metadesc = trim(@$CONFIG_EXT['metadata_global_description'].'');
	if (!empty($keywords)) {
		if (!is_array($keywords)) {
			$keywords = explode(',', (string) $keywords);
		}
		$metakeys = array_merge($keywords, (array) $metakeys);
	}
	if (!empty($description)) {
		$metadesc = $description;
	}
	// sanitise
	if (!empty($metakeys)) {
		foreach ($metakeys as $key => $val) {
			$metakeys[$key] = htmlspecialchars(strip_tags(trim($val)));
		}
	}
	$metadesc = htmlspecialchars(strip_tags(trim($metadesc)));
	// get the document & set meta
	$document = & JFactory::getDocument();
	$document->setMetaData('keywords', implode(',', (array) $metakeys));
	$document->setMetaData('description', $metadesc);
}

function jclSetPageTitle($title, $elementId = '') {
	if (empty($title)) {
		return;
	}
	// if printing, add that
	if (JRequest::getInt('print', 0)) {
		$title = JText::_('Print').' - '.$title;
	}

	// remove entities
	$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');

	// set html document page title
	$document = & JFactory::getDocument();
	$document->setTitle($title);

	// if document is served using ajax, add some javascript so that
	// the page title is updated
	$isShajax = JRequest::getCmd('shajax', false);
	if ($isShajax) {
		echo shajaxSupport::setPostDisplayAction($elementId, $title);
	}
}

/**
 * Remove non-breakable spaces from an UTF8 string
 */
function jclRemoveNbSpaceUTF8( $string) {
	str_replace(chr(0xc2).chr(0xa0), '', $string);
}

function jclProcessReadMore( $desc, $showReadmore = false, $link = '') {

	if (!empty( $desc)) {
		$readMoreString = '<hr id="system-readmore" />';
		if (strpos( $desc, $readMoreString) !== false) {
			if ($showReadmore && !empty($link)) {
				// we want to show read more link. First drop whatever is after the read more link
				$desc = explode( $readMoreString, $desc);
				$desc = $desc[0];
				// now output read more
				$desc .= '<a href="'.$link.'" class="readon">' . JText::sprintf('Read more...') . '</a>';
			}  else {
				// else display all description : ie strip possible read more codes
				$desc = str_replace( $readMoreString, '<br />', $desc);
			}
		}
	}
	return $desc;
}

/**
 * Check if date is end date of an all day event
 * @param string $endDate a mysql format date
 */
function jclIsAllDay( $endDate) {

	$status = !empty( $endDate) && (JCL_ALL_DAY_EVENT_END_DATE == $endDate || JCL_ALL_DAY_EVENT_END_DATE_LEGACY == $endDate || JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2 == $endDate);
	return $status;
}

/**
 * Check if date is end date of a "no-end-date" event
 * @param string $endDate a mysql format date
 */
function jclIsNoEndDate( $endDate) {

	$status = !empty( $endDate) && JCL_EVENT_NO_END_DATE == $endDate ? true : false;
	return $status;
}

/**
 * Builds an sql where clause to query for a specific
 * date range such as "today, tomorrow, this month, etc
 *
 *  @return string the sql clause, without any leading WHERE
 */
function jclBuildRangeWhereCondition( $dateRange) {

	// look for start and end date of range
	$range = jclFindDateRangeBoundaries( $dateRange);

	// convert to mysql date time, for query
	$db = & JFactory::getDBO();
	$startOfFirstDaySql = $db->Quote( $range->start);
	$endOfLastDaySql = $db->Quote( $range->end);

	// conditions on date of the event
	$rangeCondition  = "( ( (#__jcalpro2_events.end_date != '" . JCL_ALL_DAY_EVENT_END_DATE . "' AND #__jcalpro2_events.end_date != '"
	. JCL_ALL_DAY_EVENT_END_DATE_LEGACY . "' AND #__jcalpro2_events.end_date != '" . JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2
	. "')  AND (( #__jcalpro2_events.start_date <= $startOfFirstDaySql AND #__jcalpro2_events.end_date >= $endOfLastDaySql) ";
	$rangeCondition .= "  OR ( #__jcalpro2_events.end_date > $startOfFirstDaySql AND #__jcalpro2_events.end_date <= $endOfLastDaySql )) )";
	$rangeCondition .= "  OR ( #__jcalpro2_events.start_date > $startOfFirstDaySql AND #__jcalpro2_events.start_date <= $endOfLastDaySql) )";

	return $rangeCondition;
}




/**
 * Gets menu items by attribute
 *
 * @access public
 * @param array attributes pair
 * @param boolean   If true, only returns the first item found
 * @return array
 */
function jclGetMenuItems($attributes, $firstonly = false) {

	// get menu items from Joomla
	$menu = &JSite::getMenu();
	$menuItems = $menu->getMenu();

	$items = null;

	foreach ($menuItems as  $item) {
		if ( ! is_object($item) )
		continue;

		$good = true;
		foreach($attributes as $attribute => $value) {
			$good = $good && $item->$attribute == $value;
		}
		if ($good) {
			if($firstonly) {
				return $item;
			}
			$items[] = $item;
		}
	}
	return $items;
}

/**
 * Get Itemid of a given component
 */
function jclGetItemid($compName, $published = true) {

	$itemid = null;

	// turn $published in correct format
	$published = $published ? 1 : 0;

	// find component id in the component table
	$component = & JComponentHelper::getComponent( $compName);
	if (!$component->enabled) {
		return $itemid;
	}

	// search for component in menu list
	$attributes = array( 'componentid' => $component->id, 'published' => $published);
	$item = jclGetMenuItems( $attributes, $firstOnly = true);
	$itemid = empty( $item) ? null : $item->id;

	return $itemid;
}

function jclGetEventItemid($event, $default = 0) {
/*
* id from menu where cat_id is only the event's cat
* id from menu where cat_id contains the event's cat
* id from menu where cal_id is only the event's cal and cat_id is all
* id from menu where cal_id contains the event's cal and cat_id is all
* id from menu where cal_id is all and cat_id is all
* whatever Itemid is on the page
*/
	$component = & JComponentHelper::getComponent('com_jcalpro');
	$attributes = array('componentid' => $component->id, 'published' => '1');
	$items = jclGetMenuItems($attributes, false);
	
	$itemid = $default;
	$cat_id_strict = 0;
	$cat_id = 0;
	$cal_id_strict = 0;
	$cal_id = 0;
	$all_id = 0;
	$req_id = JRequest::getInt('Itemid', 0);
	
	//echo '<!-- REQ_ID: '.$req_id.' -->';
	//echo '<!-- DEF_ID: '.$itemid.' -->';

	if (!empty($items)) {
		foreach ($items as $item) {
			//echo '<!-- ITEMID: ' . print_r($item->id,1) . ' -->';
			//echo '<!-- PARAMS: ' . print_r($item->params,1) . ' -->';
			//echo '<!-- EVENT: ' . print_r($event,1) . ' -->';
			// simple checks :P
			if (!isset($item->params)) {
				continue;
			}
			// turn params to registry
			$params = new JRegistry();
			// no registry? bail
			if (!$params->loadINI($item->params)) {
				continue;
			}
			// get the cals & cats from the menu item
			$cals = (array) $params->getValue('cal_list');
			$cats = (array) $params->getValue('cat_list');
			// set cat ids if found
			// do cats first and if a "strict" match is found, return it
			if (in_array($event->cat_id, $cats)) {
				if (1 == count($cats)) {
					//echo '<!-- FOUND EXPLICIT CAT_ID: '.$item->id.' -->';
					return (int) $item->id;
				} else {
					//echo '<!-- FOUND CAT_ID: '.$item->id.' -->';
					$cat_id = $item->id;
				}
			}
			// see if cats is "all" and cal is correct
			else if ('' == @$cats[0] && (in_array($event->cal_id, $cals))) {
				//echo '<!-- FOUND CAT_ID: '.$item->id.' (2) -->';
				$cat_id = $item->id;
			}
			// set cal ids if found
			if (in_array($event->cal_id, $cals)) {
				if (1 == count($cals)) {
					// save this for now, because we may find a cat later
					$cal_id_strict = $item->id;
					//echo '<!-- FOUND EXPLICIT CAL_ID: '.$item->id.' -->';
				} else {
					//echo '<!-- FOUND CAL_ID: '.$item->id.' -->';
					$cal_id = $item->id;
				}
			}
			// see if "cals" is all
			else if ('' == @$cals[0]) {
				//echo '<!-- FOUND CAL_ID: '.$item->id.' (2) -->';
				$all_id = $item->id;
			}
		}
	}
	// ok, done looping menu items - return by precedence
	// sorry about the ternary ;)
	return $cat_id_strict
		? $cat_id_strict
		: ($cat_id
			? $cat_id
			: ($cal_id_strict
				? $cal_id_strict
				: ($cal_id
					? $cal_id
					: ($all_id
						? $all_id
						: ($itemid
							? $itemid
							: ($req_id)
							)
						)
					)
				)
			)
		;
}

function jclGetItemidFromDb( $compName) {

	$db = &JFactory::getDBO();

	$db->setQuery("SELECT MAX(id) FROM #__menu WHERE link LIKE '%index.php?option=com_jcalpro%' AND published <> '-2'");
	return $db->loadResult();
}

/**
 * Finds the start and end date for a specific
 * date range such as "today, tomorrow, this month, etc
 *
 * @param $dateRange an integer constant
 * @return object with start and end of range as properties
 */
function jclFindDateRangeBoundaries( $dateRange) {

	// init with min and max allowed date values
	$boundaries = new stdClass();
	$boundaries->start = JCL_DATE_MIN;
	$boundaries->end = JCL_DATE_MAX;

	// if there is one condition on the date range
	if ($dateRange != JCL_LIST_ALL_EVENTS) {

		// current day
		global $today;
		$now = jcUTCDateToFormatNoOffset( extcal_get_local_time(), '%Y-%m-%d %H:%M:%S');
		$oneSecondAgo = jcUTCDateToFormatNoOffset( extcal_get_local_time() - 1, '%Y-%m-%d %H:%M:%S');

		// check various conditions
		switch ($dateRange) {
			case JCL_LIST_ACTIVE_EVENTS:
				$boundaries->start = jcUserTimeToUTC($today['hour'],$today['minute'],0,$today['month'],$today['day'],$today['year']);
				$boundaries->end = jcUserTimeToUTC( $today['hour'],$today['minute'],59,$today['month'],$today['day'],$today['year']);
				break;
			case JCL_LIST_PAST_EVENTS:
				$boundaries->end = $oneSecondAgo;
				break;
			case JCL_LIST_UPCOMING_EVENTS:
				$boundaries->start = $now;
				break;
			case JCL_LIST_TODAY_EVENTS:
				$boundaries->start = jcUserTimeToUTC(0,0,0,$today['month'],$today['day'],$today['year']);
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$today['month'],$today['day'],$today['year']);
				break;
			case JCL_LIST_YESTERDAY_EVENTS:
				$boundaries->start = jcUserTimeToUTC(0,0,0,$today['month'],$today['day']-1,$today['year']);
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$today['month'],$today['day']-1,$today['year']);
				break;
			case JCL_LIST_TOMORROW_EVENTS:
				$boundaries->start = jcUserTimeToUTC(0,0,0,$today['month'],$today['day']+1,$today['year']);
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$today['month'],$today['day']+1,$today['year']);
				break;
			case JCL_LIST_THIS_WEEK_EVENTS:

				$week_bound = get_week_bounds($today['day'],$today['month'],$today['year']);

				$fdy = $week_bound['first_day']['year'];
				$fdm = $week_bound['first_day']['month'];
				$fdd = $week_bound['first_day']['day'];

				$ldy = $week_bound['last_day']['year'];
				$ldm = $week_bound['last_day']['month'];
				$ldd = $week_bound['last_day']['day'];
				$boundaries->start = jcUserTimeToUTC(0,0,0,$fdm,$fdd,$fdy);
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$ldm,$ldd,$ldy);
				break;
			case JCL_LIST_LAST_WEEK_EVENTS:
				$week_bound = get_week_bounds($today['day'],$today['month'],$today['year']);

				$fdy = $week_bound['first_day']['year'];
				$fdm = $week_bound['first_day']['month'];
				$fdd = $week_bound['first_day']['day'];

				$boundaries->start = jcUserTimeToUTC(0,0,0,$fdm,$fdd-7,$fdy);
				$boundaries->end = jcUserTimeToUTC(23,59,59,$fdm,$fdd-1,$fdy);
				break;
			case JCL_LIST_NEXT_WEEK_EVENTS:
				$week_bound = get_week_bounds($today['day'],$today['month'],$today['year']);

				$ldy = $week_bound['last_day']['year'];
				$ldm = $week_bound['last_day']['month'];
				$ldd = $week_bound['last_day']['day'];
				$boundaries->start = jcUserTimeToUTC(0,0,0,$ldm,$ldd+1,$ldy);
				$boundaries->end = jcUserTimeToUTC(23,59,59,$ldm,$ldd+7,$ldy);
				break;
			case JCL_LIST_THIS_MONTH_EVENTS:
				// number of days in current month
				$nr = date("t", TSServerToUser( mktime(1,0,1,$today['month'],5,$today['year'])));
				$boundaries->start = jcUserTimeToUTC( 0,0,0,$today['month'],1,$today['year']);  // we must use server time, not UTC
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$today['month'],$nr,$today['year']);
				break;
			case JCL_LIST_LAST_MONTH_EVENTS:
				// seek last month
				$month = $today['month']-1;
				$year = $today['year'];
				if ($month < 1) {
					$month = 12;
					$year -= 1;
				}
				// set range
				$nr = date("t", TSServerToUser( mktime(1,0,1,$month,5,$year)));
				$boundaries->start = jcUserTimeToUTC( 0,0,0,$month,1,$year);  // we must use server time, not UTC
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$month,$nr,$year);
				break;
			case JCL_LIST_NEXT_MONTH_EVENTS:
				// seek next month
				$month = $today['month']+1;
				$year = $today['year'];
				if ($month > 12) {
					$month = 1;
					$year += 1;
				}
				// set range
				$nr = date("t", TSServerToUser( mktime(1,0,1,$month,5,$year)));
				$boundaries->start = jcUserTimeToUTC( 0,0,0,$month,1,$year);  // we must use server time, not UTC
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$month,$nr,$year);
				break;

			case JCL_LIST_MONDAY_EVENTS:
			case JCL_LIST_TUESDAY_EVENTS:
			case JCL_LIST_WEDNESDAY_EVENTS:
			case JCL_LIST_THURSDAY_EVENTS:
			case JCL_LIST_FRIDAY_EVENTS:
			case JCL_LIST_SATURDAY_EVENTS:
			case JCL_LIST_SUNDAY_EVENTS:
				$currentDayOfWeek = jcUTCDateToFormat( $now, '%w');  // 1 is monday, 2 is tuesday
				// special case for sundays : depending on which day user has set week to start, we
				// may be looking for previous sunday or next sunday

				$week_bound = get_week_bounds($today['day'],$today['month'],$today['year']);

				$fdy = $week_bound['first_day']['year'];
				$fdm = $week_bound['first_day']['month'];
				$fdd = $week_bound['first_day']['day'];

				global $CONFIG_EXT;
				$targetDay = $today['day'] - ($currentDayOfWeek + JCL_LIST_MONDAY_EVENTS - $dateRange - 1);
				if(!$CONFIG_EXT['day_start'] && $dateRange == JCL_LIST_SUNDAY_EVENTS) { // if sunday is the first day of week
					// we want last sunday, not next
					$targetDay -= 7;
				}
				$boundaries->start = jcUserTimeToUTC(0,0,0,$fdm,$targetDay,$fdy);
				$boundaries->end = jcUserTimeToUTC( 23,59,59,$fdm,$targetDay,$fdy);

				break;

		}
	}

	// return calculated object
	return $boundaries;

}

function jclProcessICalRequest( $filename, $startDate, $endDate, $eventList = null) {

	global $CONFIG_EXT;

	// for now, ical format requests are handled separately
	$format = JRequest::getVar( 'format', 'html');
	if ($format == 'ical') {

		// handle the ical request, using adhoc functions
		// Require the display feeds library
		require_once(JPATH_COMPONENT.DS.'include'.DS. $format . '.inc.php');

		// produce the ics file and return it to the user
		// instantiate viewer object
		$className = 'Jcl' . ucfirst( $format);
		$iCalView = new $className( $startDate, $endDate, $eventList);

		// attach parameters
		$params = array(
		'calName' => $CONFIG_EXT['calendar_name']
		,'calDescription' => $CONFIG_EXT['calendar_description']
		,'timezone' => $CONFIG_EXT['site_timezone']
		,'filename' => $filename . '.ics'
		);
		$iCalView->injectProperties( $params);

		// call the display method
		$iCalView->display();

		// we should never reach this point as the display() method should return
		// the file to the user
		return;
	}

}

/**
 * Look up an event using its common_event_id column in the db
 * returning its extid if found, or null if not
 *
 * @param $eventId, the event common_event_id value
 * @param $noChild, boolean, if true, only parent event will be included
 * @return integer the primary id of the matched event, or null if not found
 */
function jclFindEventByCommonId( $eventId, $noChild = false) {

	global $CONFIG_EXT;

	// check input
	if (empty( $eventId)) {
		return null;
	}

	// there is something to look for, search db
	$db = &JFactory::getDBO();
	$query = 'select * from ' . $db->NameQuote( $CONFIG_EXT['TABLE_EVENTS'])
	. ' where '
	. $db->NameQuote( 'common_event_id') . ' = ' . $db->Quote($eventId)
	. ($noChild ? ' AND ' . $db->NameQuote( 'rec_id') . ' = ' . $db->Quote(0) : '');
	$db->setQuery( $query);
	$event = $db->loadObject();

	// finalize return value
	$event = empty( $event) ? null : $event;
	return $event;
}

function jclSetNotNull( $value, $default) {

	return $value === null ? $default : $value;
}


function jclSetReturnValue( $month = null, $day = null, $year = null) {

	global $CONFIG_EXT, $today;

	$isShajax = JRequest::getCmd( 'shajax', false);
	if (!$isShajax) {
		// extmode string
		$extmode = JRequest::getCmd( 'extmode', '');
		$extmode = empty( $extmode) ? '' : '&amp;extmode=' . $extmode;
		// cacul date
		$targetDate = JRequest::getString( 'date');
		if (empty( $targetDate)) {
			$urlTargetDate = '';
		} else {
			$month = empty($month) ? $today['month'] : $month;
			$day = empty($day) ? $today['day'] : $day;
			$year = empty($year) ? $today['year'] : $year;
			$urlTargetDate = '&amp;date=' . jcTSToFormat( mktime(0,0,0,$month,$day,$year), '%Y-%m-%d');
		}

		$returnTo = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . $extmode . $urlTargetDate );
		jclSetCookie( 'return_to', $returnTo);
	}
}

function jclGetCookieKey( $itemName) {

	static $keys = array();
	return 'jcl_'. $itemName;
	if (empty( $keys[$itemName])) {
		jimport('joomla.utilities.utility');
		$keys[$itemName] = JUtility::getHash('JCalPro_key_' . $itemName . JURI::base());
	}

	return $keys[$itemName];
}

function jclSetCookie( $itemName, $value, $lifetime = null, $path = '/', $base64Encode = true) {

	// set lifetime to one day, unless asked otherwise
	$lifetime = is_null($lifetime) ? time() + 24*60*60 : $lifetime;

	// encode value if requested
	$value = $base64Encode ? base64_encode( $value) : $value;

	// set cookie holding value passed
	setcookie( jclGetCookieKey( $itemName), $value, 1900087511, '/');
}

function jclGetCookie( $itemName, $defaultValue = null, $base64Decode = true) {

	// read cookie value from request
	$cookieValue = JRequest::getString( jclGetCookieKey( $itemName), null, 'COOKIE');

	// decode if asked to
	$value = $base64Decode ? base64_decode( $cookieValue) : $cookieValue;

	// check default
	if (is_null( $value) && !is_null( $defaultValue)) {
		$value = $defaultValue;
	}

	// return possisbly decode value
	return $value;

}

/**
 * Builds up some javascript to display
 * page title and a print button on the print window
 * @param $pageTitle
 */
function jclGetPrintHeader( $pageTitle) {

	global $CONFIG_EXT;

	$output =  '<div class="jcl_print_title"><h1>' . $pageTitle . '</h1>';
	$output .= '<a class="jcl_print_button" href="#" onclick="document.getElementById(\'jcl_print_image\').style.display=\'none\';window.print();window.close();return false;">'
	.'<img id="jcl_print_image" src="'.$CONFIG_EXT['calendar_url'].'themes/'.$CONFIG_EXT['theme'].'/images/icon-print.gif" border="0" alt="print" />'
	.'</a>';
	$output .=  '</div>';

	return $output;
}

/**
 * Checks if editorinsert plugin is installed and
 * fire an error if not installed and published
 */
function jclCheckEditorInsertInstalled() {

	$enabled = JPluginHelper::isEnabled( 'editors-xtd', 'jclinsert');

	if (!$enabled) {
		JError::RaiseError( 500, 'Jcal pro editor insert plugin not installed! Get it at <a target="_blank" href="http://dev.anything-digital.com" >Anything Digital</a>');
	}
}

/**
 * Clean up function for sending data to javascript
 * as json. If CR or LF are included,that
 * will confuse JS 
 * @param unknown_type $string
 */
function jclCleanEndOfLines( $string) {

	$output = str_replace( Chr(13), '', $string);
	$output = str_replace( Chr(10), '\n', $output);

	return $output;
}

/**
 * Fetches the Itemid from the database for the given extension
 * @param $ext
 */
function getIntegrationItemid($ext) {
	global $Itemid_Querystring, $CONFIG_EXT;
	$id = $Itemid_Querystring;
	if (isset($CONFIG_EXT["itemid_{$ext}"]) && 0 != (int) $CONFIG_EXT["itemid_{$ext}"]) {
		$id = '&amp;Itemid='.((int) $CONFIG_EXT["itemid_{$ext}"]);
	} else {
		$db = &JFactory::getDbo();
		// sanitize (not necessary?)
		$ext = $db->getEscaped($ext, true);
		$db->setQuery("SELECT id FROM #__menu WHERE link LIKE 'index.php?option=com_{$ext}%' AND published = 1 ORDER BY id LIMIT 1");
		if ($result = (int) $db->loadResult()) {
			$id = "&amp;Itemid={$result}";
		}
	}
	return $id;
}

/**
 * gets JomSocial's Itemid
 */
function getJomSocialItemid() {
	global $Itemid_Querystring, $CONFIG_EXT;
	static $itemid;
	if (empty($itemid)) {
		$itemid = getIntegrationItemid('community');
	}
	return $itemid;
}

/**
 * gets I'll Be There's Itemid
 */
function getIllBeThereItemid() {
	global $Itemid_Querystring, $CONFIG_EXT;
	static $itemid;
	if (empty($itemid)) {
		$itemid = getIntegrationItemid('illbethere');
	}
	return $itemid;
}