<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2008 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla! and Mambo.
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
 *
 * $Id: latest.inc.php 720 2011-05-12 08:36:01Z jeffchannell $
 *
 * Module for displaying upcoming events in connection with the JCal Pro
 * component. The component must be installed before this module will work.
 * There are some options for this module, which can be set in the
 * "Parameters" section of the module in Administration.
 *

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */


/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $CONFIG_EXT, $EXTCAL_CONFIG, $cal_id, $cat_id, $cat_list, $private_events_mode, $lang_latest_events, $Itemid;

// store parameters in a global variable for sort callback function
global $jclUserParams;

$jclUserParams = $params;

// get application database object
$db = &JFactory::getDBO();
$jclUser	=& JFactory::getUser();


if ( !defined('USER_IS_ADMIN') ) define('USER_IS_ADMIN',((($jclUser->usertype == 'Administrator') || ($jclUser->usertype == 'Super Administrator')) ? true : false));
if ( !defined('USER_IS_LOGGED_IN') ) define('USER_IS_LOGGED_IN',!($jclUser->usertype == ''));

$config = &JFactory::getConfig();
$offset = (int) @$CONFIG_EXT['timezone'];
$mosConfig_live_site = JURI::root();
$legacy_lang = &JFactory::getLanguage();
$mosConfig_lang = $legacy_lang->getBackwardLang();
$mosConfig_locale = $config->getValue('config.language');
$mosConfig_absolute_path = rtrim( JPATH_ROOT, DS);

$option = "com_jcalpro";
require_once( JPATH_ROOT."/components/com_jcalpro/config.inc.php" );

##-------------------We'll get the menu Itemid to pass on when clicking a link:

// use specific Itemid if requested
$defaultItemid = jclGetItemid('com_jcalpro', $published = true);
// but default to default menu item going to jcalpro
$jcal_itemid = intval($params->get('component_itemid', $defaultItemid));
// last solution : current page Itemid
$jcal_itemid = $jcal_itemid ? $jcal_itemid : $Itemid;


##-------------------Some little variables we'll use later:

$previouseventmonth = '';
$thiseventmonth = '';
$module_output = '';
$locale_was_set = false;
$rowsUpcoming = array();
$rowsUpcomingRecurrent = array();
$rowsRecent = array();
$rowsRecentRecurrent = array();


// JParameter sucks hairy nuts, use JRegistry instead
$paramFix = JRegistry::getInstance('jcal_param_fix');
$paramFix->loadINI($params->_raw);


//-------------------EXTCAL_CONFIG will contain any important config variables we need:
$EXTCAL_CONFIG = array();
//$EXTCAL_CONFIG['now'] = JHTML::date( extcal_get_local_time(), '%Y-%m-%d %H:%M:%S');  // local time
$EXTCAL_CONFIG['now_stamp'] = extcal_get_local_time();
$EXTCAL_CONFIG['today_stamp'] = startOfDayInUserTime( $EXTCAL_CONFIG['now_stamp']);
$EXTCAL_CONFIG['Itemid'] = $jcal_itemid;

// There are two important values we need to get from the main ExtCal Settings, which the other module
// and component load into something called $CONFIG_EXT. If these settings have already been loaded by
// another module or component, we can save a query. Otherwise we query the settings table here.
if ( isset($CONFIG_EXT['show_recurrent_events']) && isset($CONFIG_EXT['addevent_allow_html']) && isset($CONFIG_EXT['who_can_add_events']) && isset($CONFIG_EXT['show_times']) && $CONFIG_EXT['show_times'] == 3) {
	$EXTCAL_CONFIG['show_recurrent_events'] = $CONFIG_EXT['show_recurrent_events'];
	$EXTCAL_CONFIG['addevent_allow_html'] = $CONFIG_EXT['addevent_allow_html'];
	$EXTCAL_CONFIG['who_can_add_events'] = $CONFIG_EXT['who_can_add_events'];
} else {
	$query = "SELECT name, value FROM #__jcalpro2_config WHERE name = 'addevent_allow_html' OR name = 'show_recurrent_events' OR name = 'who_can_add_events'";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	foreach ($rows as $row) {
		$EXTCAL_CONFIG[$row->name] = $row->value;
	}
}

##-------------------Gather parameters from the module administration section:

$EXTCAL_CONFIG['display_if_no_events'] = intval($params->def('display_if_no_events',1));
$EXTCAL_CONFIG['number_of_events_to_list_upcoming'] = intval($params->def('number_of_events_to_list_upcoming',5));
$EXTCAL_CONFIG['number_of_events_to_list_recent'] = intval($params->def('number_of_events_to_list_recent',0));
$EXTCAL_CONFIG['categories_list'] = $paramFix->getValue('categories');
$EXTCAL_CONFIG['categories_illbethere'] = $paramFix->getValue('categories_illbethere');
$EXTCAL_CONFIG['categories_community'] = $paramFix->getValue('categories_community');
$EXTCAL_CONFIG['calendars_list'] = $paramFix->getValue('calendars_list');
// fix the above 4 vars
foreach (array('list', 'illbethere', 'community') as $x) {
	if (empty($EXTCAL_CONFIG['categories_'.$x])) {
		$EXTCAL_CONFIG['categories_'.$x] = '-2';
	}
	$EXTCAL_CONFIG['categories_'.$x] = str_replace(('list'==$x?'-2':'-1'), '', implode(',', (array) $EXTCAL_CONFIG['categories_'.$x]));
}
if (empty($EXTCAL_CONFIG['calendars_list'])) {
	$EXTCAL_CONFIG['calendars_list'] = '';
}
$EXTCAL_CONFIG['calendars_list'] = str_replace('-2', '', implode(',', (array) $EXTCAL_CONFIG['calendars_list']));
$EXTCAL_CONFIG['title_max_length'] = intval($params->def('title_max_length',256));
$EXTCAL_CONFIG['show_times'] = intval($params->def('show_times',1));
$EXTCAL_CONFIG['show_dates'] = intval($params->def('show_dates',1));
$EXTCAL_CONFIG['enable_multiple_calendars'] = intval($params->def('enable_multiple_calendars',1));
$EXTCAL_CONFIG['show_category'] = intval($params->def('show_category',1));
$EXTCAL_CONFIG['show_calendar'] = intval($params->def('show_calendar',1));
$EXTCAL_CONFIG['show_description'] = intval($params->def('show_description',1));
$EXTCAL_CONFIG['show_contact'] = intval($params->def('show_contact',1));
$EXTCAL_CONFIG['description_max_length'] = intval($params->def('description_max_length',256));
$outputSetting = $params->get('output', '');
$EXTCAL_CONFIG['days_view'] = $params->get('days_view', '');
$EXTCAL_CONFIG['date_format'] = $params->get('date_format', '%B %d, %Y');

$strip_bbcode_from_description = intval($params->def('strip_bbcode_from_description',3));
$EXTCAL_CONFIG['strip_bbcode_from_description'] = ( $strip_bbcode_from_description = 3 ) ? $EXTCAL_CONFIG['addevent_allow_html'] : $strip_bbcode_from_description;
$show_recurrent_events = intval($params->def('show_recurrent_events',3));
$EXTCAL_CONFIG['show_recurrent_events'] = ( $show_recurrent_events == 3 ) ? $CONFIG_EXT['show_recurrent_events'] : $show_recurrent_events;

$EXTCAL_CONFIG['private_events_mode'] = intval($params->def('private_events_mode',1));
$EXTCAL_CONFIG['event_separator'] = JString::trim($params->def('event_separator',''));
$EXTCAL_CONFIG['show_month_separators'] = intval($params->def('show_month_separators',0));
$rawMonthSeparatorStyle = htmlspecialchars(JString::trim($params->def('month_separator_style','background-color: transparent; border-top-color: #777777; border-bottom-color: #777777; border-top-width: 1px; border-bottom-width: 1px; border-top-style: solid; border-bottom-style: solid; font-style: italic; font-weight: bold; margin: 4px; text-align: center;')));
$EXTCAL_CONFIG['month_separator_style'] = ( $rawMonthSeparatorStyle == '' ) ? '' : ' style="'.str_replace(array("\r\n","\n"),'',$rawMonthSeparatorStyle).'"';
$EXTCAL_CONFIG['no_upcoming_events_text'] = $params->def('no_upcoming_events_text',$lang_latest_events['no_events_scheduled']);
$EXTCAL_CONFIG['recent_events_text'] = $params->def('recent_events_text',$lang_latest_events['recent_events']);
$rawRecentEventsStyle = htmlspecialchars(JString::trim($params->def('recent_events_style','font-size: 110%; font-weight: bold; background-color: transparent; border-top-color: #333333; border-bottom-color: #333333; border-top-width: 2px; border-bottom-width: 2px; border-top-style: solid; border-bottom-style: solid; margin: 10px; text-align: center;')));
$EXTCAL_CONFIG['recent_events_style'] = ( $rawRecentEventsStyle == '' ) ? '' : ' style="'.str_replace(array("\r\n","\n"),'',$rawRecentEventsStyle).'"';
$EXTCAL_CONFIG['show_full_calendar_link'] = intval($params->def('show_full_calendar_link',1));
$EXTCAL_CONFIG['full_calendar_link_text'] = htmlspecialchars($params->def('full_calendar_link_text',$lang_latest_events['view_full_cal']));
$EXTCAL_CONFIG['show_add_event_link'] = intval($params->def('show_add_event_link',0));
$EXTCAL_CONFIG['add_event_text'] = htmlspecialchars($params->def('add_event_text',$lang_latest_events['add_new_event']));
$EXTCAL_CONFIG['time_format_12_or_24'] = intval($params->def('time_format_12_or_24',1));

// JCal 2.1 : new parameters
$EXTCAL_CONFIG['show_readmore'] = $params->def( 'show_readmore', 'yes');
$EXTCAL_CONFIG['events_list'] = implode(',', (array)$paramFix->getValue('events_list'));


######################################################################
#####  CUSTOM FUNCTIONS:
######################################################################

if( !function_exists('mf_shorten_with_ellipsis') )
{
	function mf_shorten_with_ellipsis($inputstring,$characters) {
		return (strlen($inputstring) >= $characters) ? JString::substr($inputstring,0,($characters-3)) . '...' : $inputstring;
	}
}

if( !function_exists('mf_get_daterange_string') )
{

	function mf_get_daterange_string($thisEvent) {

		global $EXTCAL_CONFIG, $lang_latest_events;

		// do not show anything for end date if all day event or no end date event
		$no_end_specified = ( jclIsNoEndDate($thisEvent->end_date) || jclIsAllDay($thisEvent->end_date) || $EXTCAL_CONFIG['show_times'] == 3 ) ? true : false;

		// find about details of date, for easier comparisons later
		$start_month = jcUTCDateToFormat($thisEvent->start_date, '%m');
		$start_daynumber = jcUTCDateToFormat($thisEvent->start_date, '%d');
		$start_year = jcUTCDateToFormat($thisEvent->start_date, '%Y');
		$end_month = jcUTCDateToFormat($thisEvent->end_date, '%m');
		$end_daynumber = jcUTCDateToFormat($thisEvent->end_date, '%d');
		$end_year = jcUTCDateToFormat($thisEvent->end_date, '%Y');

		// is it an all-day event
		if ( jclIsAllDay( $thisEvent->end_date) ) { // This event is an "All Day" event
			$start_time = EXTCAL_TEXT_ALL_DAY;
		}
		else {
			// else prepare event start time data
			$hour = jcUTCDateToFormat( $thisEvent->start_date, '%H');
			$minute = jcUTCDateToFormat( $thisEvent->start_date, '%M');
			$start_time = jcHourToDisplayString( $hour, $minute,!$EXTCAL_CONFIG['time_format_12_or_24']);

			// and event end time data
			$hour = jcUTCDateToFormat( $thisEvent->end_date, '%H');
			$minute = jcUTCDateToFormat( $thisEvent->end_date, '%M');
			$end_time = jcHourToDisplayString( $hour, $minute,!$EXTCAL_CONFIG['time_format_12_or_24']);

		}


		// If months are the same, return January 6-7, 2005. If not, return January 6 - February 7, 2005, if same year.
		if ( (($start_daynumber == $end_daynumber) && ($start_month == $end_month) && ($start_year == $end_year)) || $no_end_specified ) {
			// January 30, 2007 (08:00 - 10:00)
			$returnstring = $EXTCAL_CONFIG['show_dates'] ? jcUTCDateToFormat( $thisEvent->start_date, $EXTCAL_CONFIG['date_format']) : '';
			$returnstring .=  $EXTCAL_CONFIG['show_times']  ? ' (' . $start_time . ( ($EXTCAL_CONFIG['show_times'] == 3 || $no_end_specified) ? '' : ' - ' . $end_time ) . ')' : '';
		} else {
			// events are not on the same day
			if ($EXTCAL_CONFIG['show_dates']) {
				$temp_start = jcUTCDateToFormat( $thisEvent->start_date, $EXTCAL_CONFIG['date_format']);
				$temp_end   = jcUTCDateToFormat(  $thisEvent->end_date, $EXTCAL_CONFIG['date_format']) ;
			} else {
				$temp_start = '';
				$temp_end = '';
			}
			if ( $EXTCAL_CONFIG['show_times'] ) {
				$returnstring = $temp_start . '(' . $start_time . ')' . ' - ' . $temp_end . ( ($EXTCAL_CONFIG['show_times'] == 3 || $no_end_specified) ? '' : ' (' . $end_time . ')' ) ;
			} else {
				$returnstring = $temp_start . ' - ' . $temp_end;
			}
		}

		if ( $EXTCAL_CONFIG['days_view'] )
		{
			$difference = jcUTCDateToTs( $thisEvent->start_date) - TSserverToUTC( extcal_get_local_time());
			$days = $difference / 24 / 60 / 60;
			if ( $days >= 0 ) {
				$returnstring = round ( $days ) . $lang_latest_events['more_days'];
			} else {
				$returnstring = round ( $days * -1 ) . $lang_latest_events['days_ago'];
			}
		}

		return $returnstring;
	}
}

if( !function_exists('process_extcal_description') )
{
	function process_extcal_description($data)
	{
		/* Process message data with various conversions to eliminate bbcode and such*/

		global $EXTCAL_CONFIG;

		// Is BBCcode allowed in the Extcal settings?

		if (!$EXTCAL_CONFIG['strip_bbcode_from_description'])
		{

			$data = preg_replace("/\[B\](.*?)\[\/B\]/si", "<strong>\\1</strong>", $data);
			$data = preg_replace("/\[I\](.*?)\[\/I\]/si", "<em>\\1</em>", $data);
			$data = preg_replace("/\[U\](.*?)\[\/U\]/si", "<u>\\1</u>", $data);

			$data = preg_replace("/\[LEFT\](.*?)\[\/LEFT\]/si", "<div align='left'>\\1</div>", $data);
			$data = preg_replace("/\[CENTER\](.*?)\[\/CENTER\]/si", "<div align='center'>\\1</div>", $data);
			$data = preg_replace("/\[RIGHT\](.*?)\[\/RIGHT\]/si", "<div align='right'>\\1</div>", $data);

			$data = preg_replace("/\[URL\](http:\/\/)?(.*?)\[\/URL\]/si", "<A HREF=\"http://\\2\" target=\"_blank\">\\2</A>", $data);
			$data = preg_replace("/\[URL=(http:\/\/)?(.*?)\](.*?)\[\/URL\]/si", "<A HREF=\"http://\\2\" target=\"_blank\">\\3</A>", $data);
			$data = preg_replace("/\[EMAIL\](.*?)\[\/EMAIL\]/si", "<A HREF=\"mailto:\\1\" style=\"color:#446699\">\\1</A>", $data);
			$data = preg_replace("/\[IMG\](.*?)\[\/IMG\]/si", "<IMG border=0 SRC=\"\\1\">", $data);

			/* adding a space to beginning */
			$data = " ".$data;

			$data = preg_replace("#([\n ])([a-z]+?)://([^,<> \n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $data);

			$data = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,<> \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $data);

			$data = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([^,<> \n\r]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $data);

			/* Remove space */
			$data = JString::substr($data, 1);

		} else {  // Remove code entirely when "Allow HTML" is disabled in Settings:
			$data = preg_replace("/\[B\](.*?)\[\/B\]/si", "$1", $data);
			$data = preg_replace("/\[I\](.*?)\[\/I\]/si", "$1", $data);
			$data = preg_replace("/\[U\](.*?)\[\/U\]/si", "$1", $data);

			$data = preg_replace("/\[LEFT\](.*?)\[\/LEFT\]/si", "$1", $data);
			$data = preg_replace("/\[CENTER\](.*?)\[\/CENTER\]/si", "$1", $data);
			$data = preg_replace("/\[RIGHT\](.*?)\[\/RIGHT\]/si", "$1", $data);

			$data = preg_replace("/\[URL\](http:\/\/)?(.*?)\[\/URL\]/si", "$2", $data);
			$data = preg_replace("/\[URL=(http:\/\/)?(.*?)\](.*?)\[\/URL\]/si", "$3", $data);
			$data = preg_replace("/\[EMAIL\](.*?)\[\/EMAIL\]/si", "$1", $data);
			$data = preg_replace("/\[IMG\](.*?)\[\/IMG\]/si", "$1", $data);
		}

		// protect agains bad MS Word code : causes lots of problems in IE if left intact
		$pattern = '#&lt;!--\[if\s!mso\]&gt;.*\[endif\]--&gt;#isU';
		$data = preg_replace( $pattern, '', $data);
		$pattern = '#&lt;!--\[if\spub\]&gt;.*\[endif\]--&gt;#isU';
		$data = preg_replace( $pattern, '', $data);
		$pattern = '#&lt;!--\[if\s[gtel]{2,3}\smso.*\[endif\]--&gt;#isU';
		$data = preg_replace( $pattern, '', $data);

		// security added
		$pattern = '#<[\s]*meta#isU';
		$data = preg_replace( $pattern, '', $data);
		return $data;
	}
}

if (!function_exists( 'jclModuleSortLatestItems')) {

	/**
	* Callback function to sort an array of events
	*
	* @param $first the first event to be compared, as an object
	* @param $second second event to be sorted, as an object
	* @return int 0, if items are equals, -1 if $first > $second, 1 if $first < $second
	*/
	function jclModuleSortLatestItems( $first, $second) {

		global $jclUserParams;

		// get user setttings
		$sort = JString::trim($jclUserParams->def('sort', 'date'));
		$dir = JString::trim( $jclUserParams->def( 'direction', 'asc'));

		// find about comparison criteria
		switch ($sort) {
			case 'category':
				$sort1 = 'cat_name';
				$sort2 = 'start_date';
				$sort3 = 'title';
				break;
			default:
				$sort1 = 'start_date';
				$sort2 = 'title';
				$sort3 = '';
				break;
		}

		// perform comparison
		// first level comparison
		if (!empty( $sort1)) {
			if ($first->$sort1 > $second->$sort1) {
				return $dir == 'asc' ? 1 : -1;
			} else if ($first->$sort1 < $second->$sort1) {
				return $dir == 'asc' ? -1 : 1;
			}
		}

		// first criterion is the same, look at second
		if (!empty($sort2)) {
			if ($first->$sort2 > $second->$sort2) {
				return $dir == 'asc' ? 1 : -1;
			} else if ($first->$sort2 < $second->$sort2) {
				return $dir == 'asc' ? -1 : 1;
			}
		}

		// second criterion is the same, look at third
		if (!empty($sort3)) {
			if ($first->$sort3 > $second->$sort3) {
				return $dir == 'asc' ? 1 : -1;
			} else if ($first->$sort3 < $second->$sort3) {
				return $dir == 'asc' ? -1 : 1;
			}
		}
		// all criteria are the same, items are equals
		return 0;
	}
}

// if eventid list is provided, we can display even if max number of events is null
$forcedEventId = !empty( $EXTCAL_CONFIG['events_list']);
/*
 @comment_do_not_remove@
 */
##-------------------Query all upcoming events:

if ($EXTCAL_CONFIG['number_of_events_to_list_upcoming'] || $forcedEventId) {
	// prepare time limits
	$startUpcoming = jcTSToUTC( $EXTCAL_CONFIG['now_stamp'], '%Y-%m-%d %H:%M:%S');
	$startUpcoming = $db->Quote( $startUpcoming);

	// ! remember, need to select a table primary key for Joomfish to work !
	$query = 'SELECT e.*, c.cat_name, c.cat_id, cal.cal_name, cal.cal_id from #__jcalpro2_events AS e '
	. ' LEFT JOIN ' . $CONFIG_EXT['TABLE_CATEGORIES'] . ' AS c ON e.cat=c.cat_id'
	. ' LEFT JOIN ' . $CONFIG_EXT['TABLE_CALENDARS'] . ' AS cal ON e.cal_id=cal.cal_id'
	. ' WHERE ( ( ( e.end_date >= ' .$startUpcoming
	. ' ) OR ( e.start_date >= ' . $startUpcoming .'))'
	. ' OR ( e.end_date = \''.JCL_ALL_DAY_EVENT_END_DATE.'\' ) OR ( e.end_date = \''.JCL_ALL_DAY_EVENT_END_DATE_LEGACY.'\' ) OR ( e.end_date = \''.JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2.'\' ))'
	. ' AND c.published = \'1\' AND cal.published = \'1\' AND e.published = \'1\' AND approved = \'1\'';

	// apply category restrictions
	if (!empty( $EXTCAL_CONFIG['categories_list'])) {
		$query .= ' AND e.cat IN (' . $EXTCAL_CONFIG['categories_list'] . ') ';
	}

	// apply calendar restrictions
	if (!empty( $EXTCAL_CONFIG['calendars_list'])) {
		$query .= ' AND e.cal_id IN (' . $EXTCAL_CONFIG['calendars_list'] . ') ';
	}

	// apply recurrency restrictions
	if (empty( $EXTCAL_CONFIG['show_recurrent_events'])) {
		// don't show recurring events
		$query .= ' AND e.rec_type_select=\''.JCL_REC_TYPE_NONE.'\'';
	}

	// apply private event restrictions
	switch ($EXTCAL_CONFIG['private_events_mode']) {
		case JCL_DO_NOT_SHOW_PRIVATE_EVENTS :
			$query .= "AND e.private = '" . JCL_EVENT_PUBLIC . "' ";
			break;
		case  JCL_SHOW_ONLY_PRIVATE_EVENTS :
			$query .= "AND e.owner_id = " . $db->Quote( $jclUser->id) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\')  ';
			break;
		case  JCL_SHOW_ONLY_OWN_EVENTS :
			// if we are looking at the profile of another user than the one logged in
			if (!empty( $profiledUserId) && $profiledUserId != $jclUser->id) {
				// make sure we display on the tab only those events that belong to that particular user
				$query .= ' AND ( (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\'))  '
				. 'OR (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND '. $db->Quote( $profiledUserId) .'!='. $db->Quote( $jclUser->id)
				. ' AND e.private in ( \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\', \'' . JCL_EVENT_PUBLIC . '\') ' . ')'
				. '  )';
			} else {
				// possibly any user looking, so need to show private events only to their owner
				$query .= "AND e.owner_id = " . $db->Quote( $jclUser->id);
			}
			break;
		default:
			$query .= "AND (e.private in ('".JCL_EVENT_PUBLIC ."', '".JCL_EVENT_PRIVATE_READ_ONLY."') "
			. "OR (e.owner_id = " . $db->Quote( $jclUser->id) . " AND e.private = '". JCL_EVENT_PRIVATE ."')) ";
			break;
	}

	// apply event id restrictions
	if ($forcedEventId) {
		$query .= ' AND e.extid IN (' . $EXTCAL_CONFIG['events_list'] . ') ';
	}

	// order by ascending start date
	$query .= ' ORDER BY ' . $db->nameQuote( 'e.start_date') . ' asc';

	// query the db
	$db->setQuery( $query );
	$rowsUpcomingGross = $db->loadObjectList();

	// process resulting events to remove unauthorized for current user and other restrictions
	$reccount = count($rowsUpcomingGross);
	$recIdsList = array();
	foreach( $rowsUpcomingGross as $row ) {
		if ( has_priv ( 'category' . $row->cat ) && has_priv ( 'calendar' . $row->cal_id )) {
			// If a regular event, or an all day event, and it starts today or later, include it here
			if ( !jclIsAllDay($row->end_date)
			|| (jclIsAllDay( $row->end_date) && jcUTCDateToTs(JString::substr($row->start_date,0,10) . ' 23:59:59') >= $EXTCAL_CONFIG['now_stamp'] ))  {
				// last check : remove every instance of a recurrence series, but the next one
				if ( $row->rec_type_select != JCL_REC_TYPE_NONE && $EXTCAL_CONFIG['show_recurrent_events'] == 2) {
					// if it is the parent event of the series or we have not already seen an event
					// from this series
					if (empty($row->rec_id) || !isset($recIdsList[$row->rec_id])) {
						// keep this one and store its event
						$rowsUpcoming[] = $row;
						$recId = empty($row->rec_id) ? $row->extid : $row->rec_id;
						$recIdsList[$recId] = true;
					}
				} else {
					// not recurring, or not asked to keep only next occurence, just keep it
					$rowsUpcoming[] = $row;
				}
			}
		}
	}

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );
	
	if ($EXTCAL_CONFIG['categories_illbethere'] !== '-2') {
		// read RSVP categories list
		$query = "SELECT e.*, c.name as cat_name
			FROM #__illbethere_sessions as e
			LEFT JOIN #__illbethere_categories as c
			ON c.cat_id = e.cat_id
			WHERE e.published = '1'
			AND (
					( ( e.session_down >= ".$startUpcoming." ) OR ( e.session_up >= ".$startUpcoming.") )
				OR	( e.session_down = '".JCL_ALL_DAY_EVENT_END_DATE."' )
				OR	( e.session_down = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' )
				OR	( e.session_down = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."' )
				)
		";
		// apply category restrictions
		if ( $EXTCAL_CONFIG['categories_illbethere'] ) {
			$query .= " AND e.cat_id IN ( ".$EXTCAL_CONFIG['categories_illbethere']." )";
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
				$row->description = $row->introtext;
				$rowsUpcoming[] = $row;
			}
		}
	}

	if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && $CONFIG_EXT['show_community'] ) ) {
		$cat_list_community = jclValidateList( $pageParams->get( 'cat_list_community' ) );
		if ( empty( $cat_list_community ) ) {
			$cat_list_community = @$CONFIG_EXT['cat_list_community'];
		}
		if ( $cat_list_community == -1 ) {
			$cat_list_community = '';
		}
		$exclude_community = $pageParams->get( 'cat_list_community_exclude' );
		// read community categories list
		$query = "SELECT e.*, c.name as cat_name
					, DATE_ADD(e.startdate, INTERVAL (-1 * {$offset}) HOUR) AS utcdatetimestart
					, DATE_ADD(e.enddate, INTERVAL (-1 * {$offset}) HOUR) AS utcdatetimeend
			FROM #__community_events as e
			LEFT JOIN #__community_events_category as c
			ON c.id = e.catid
			WHERE 
			(
					( ( e.enddate >= ".$startUpcoming." ) OR ( e.startdate >= ".$startUpcoming.") )
				OR	( e.enddate = '".JCL_ALL_DAY_EVENT_END_DATE."' )
				OR	( e.enddate = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' )
				OR	( e.enddate = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."' )
				)
			";
		// apply category restrictions
		if (!empty($EXTCAL_CONFIG['categories_community'])) {
			$query .= " AND e.catid IN ( ".$EXTCAL_CONFIG['categories_community']." )";
		}
		// apply sort order
		$query .= " ORDER BY e.startdate, e.title ASC";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		foreach ( $extra_rows as $i => $row ) {
			$row->cat_ext = 'community';
			$row->extid = $row->id;
			$row->start_date = $row->startdate;
			$row->end_date = $row->enddate;
			$rowsUpcoming[] = $row;
		}
	}

	// sort as per user settings
	if (!empty( $rowsUpcoming)) {
		usort( $rowsUpcoming, 'jclModuleSortLatestItems');
		$rowsUpcoming = array_slice( $rowsUpcoming, 0, $EXTCAL_CONFIG['number_of_events_to_list_upcoming'] );
	}

}
##-------------------Query all recent events:
if ($EXTCAL_CONFIG['number_of_events_to_list_recent'] || $forcedEventId) {

	$startRecent = jcTSToUTC( $EXTCAL_CONFIG['now_stamp'], '%Y-%m-%d %H:%M:%S');
	$startRecent = $db->Quote( $startRecent);
	$query = 'SELECT e.*, cal.cal_name, cal.cal_id, c.cat_name, c.cat_id from #__jcalpro2_events AS e '
	. ' LEFT JOIN ' . $CONFIG_EXT['TABLE_CATEGORIES'] . ' AS c ON e.cat=c.cat_id'
	. ' LEFT JOIN ' . $CONFIG_EXT['TABLE_CALENDARS'] . ' AS cal ON e.cal_id=cal.cal_id'
	. " WHERE (( e.end_date < ". $startRecent ." AND  e.end_date != '" . JCL_EVENT_NO_END_DATE."' AND e.end_date != '" .JCL_ALL_DAY_EVENT_END_DATE. "' AND e.end_date != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' AND e.end_date != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."') "
	. " OR ( e.start_date < ". $startRecent ." AND (e.end_date  = '" . JCL_EVENT_NO_END_DATE."' OR e.end_date  = '" .JCL_ALL_DAY_EVENT_END_DATE. "' OR e.end_date  = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' OR e.end_date  = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."' ))) "
	. ' AND c.published = \'1\' AND cal.published = \'1\' AND e.published = \'1\' AND approved = \'1\'';

	// apply category restrictions
	if (!empty( $EXTCAL_CONFIG['categories_list']) && 'Array' != $EXTCAL_CONFIG['categories_list']) {
		$query .= ' AND e.cat IN (' . $EXTCAL_CONFIG['categories_list'] . ') ';
	}

	// apply calendar restrictions
	if (!empty( $EXTCAL_CONFIG['calendars_list'])) {
		$query .= ' AND e.cal_id IN (' . $EXTCAL_CONFIG['calendars_list'] . ') ';
	}

	// apply recurrency restrictions
	if (empty( $EXTCAL_CONFIG['show_recurrent_events'])) {
		// show all occurences of events
		$query .= ' AND e.rec_type_select=\''.JCL_REC_TYPE_NONE.'\'';
	}

	// apply private event restrictions
	$jclUser = &JFactory::getUser();
	switch ($EXTCAL_CONFIG['private_events_mode']) {
		case JCL_DO_NOT_SHOW_PRIVATE_EVENTS :
			$query .= "AND e.private = '" . JCL_EVENT_PUBLIC . "' ";
			break;
		case  JCL_SHOW_ONLY_PRIVATE_EVENTS :
			$query .= "AND e.owner_id = " . $db->Quote( $jclUser->id) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\')  ';
			break;
		case  JCL_SHOW_ONLY_OWN_EVENTS :
			// if we are looking at the profile of another user than the one logged in
			if (!empty( $profiledUserId) && $profiledUserId != $jclUser->id) {
				// make sure we display on the tab only those events that belong to that particular user
				$query .= ' AND ( (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE . '\', \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\'))  '
				. 'OR (e.owner_id=' . $db->Quote( $profiledUserId) . ' AND '. $db->Quote( $profiledUserId) .'!='. $db->Quote( $jclUser->id) . ' AND e.private in ( \'' . JCL_EVENT_PRIVATE_READ_ONLY . '\', \'' . JCL_EVENT_PUBLIC . '\') ' . ')'
				. '  )';
			} else {
				// possibly any user looking, so need to show private events only to their owner
				$query .= "AND e.owner_id = " . $db->Quote( $jclUser->id);
			}
			break;
		default:
			$query .= "AND (e.private in ('".JCL_EVENT_PUBLIC ."', '".JCL_EVENT_PRIVATE_READ_ONLY."') "
			. "OR (e.owner_id = " . $db->Quote( $jclUser->id) . " AND e.private = '". JCL_EVENT_PRIVATE ."')) ";
			break;
	}

	// apply event id restrictions
	if ($forcedEventId) {
		$query .= ' AND e.extid IN (' . $EXTCAL_CONFIG['events_list'] . ') ';
	}

	// order by descending start date
	$query .= ' ORDER BY ' . $db->nameQuote( 'e.start_date') . ' desc';

	// query the db
	$db->setQuery( $query );
	$rowsRecentGross = $db->loadObjectList();

	// process resulting events to remove unauthorized for current user
	$reccount = count($rowsRecentGross);
	$recIdsList = array();
	foreach( $rowsRecentGross as $row ) {
		if ( has_priv ( 'category' . $row->cat ) && has_priv ( 'calendar' . $row->cal_id ))  {
			// If a regular event, or an all day event, and it starts today or later, include it here
			if ( !jclIsAllDay( $row->end_date)
			|| (jclIsAllDay( $row->end_date) && jcUTCDateToTs(JString::substr($row->start_date,0,10) . ' 23:59:59') <= $EXTCAL_CONFIG['now_stamp'] ))  {
				// last check : remove every instance of a recurrence series, but the next one
				if ( $row->rec_type_select != JCL_REC_TYPE_NONE && $EXTCAL_CONFIG['show_recurrent_events'] == 2) {
					// if it is the parent event of the series or we have not already seen an event
					// from this series
					if (empty($row->rec_id) || !isset($recIdsList[$row->rec_id])) {
						// keep this one and store its event
						$rowsRecent[] = $row;
						$recId = empty($row->rec_id) ? $row->extid : $row->rec_id;
						$recIdsList[$recId] = true;
					}
				} else {
					// not recurring, or not asked to keep only next occurence, just keep it
					$rowsRecent[] = $row;
				}
			}
		}
	}

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );
	if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && $CONFIG_EXT['show_illbethere'] ) ) {
		$cat_list_illbethere = jclValidateList( $pageParams->get( 'cat_list_illbethere' ) );
		if ( empty( $cat_list_illbethere ) ) {
			$cat_list_illbethere = @$CONFIG_EXT['cat_list_illbethere'].'';
		}
		if ( $cat_list_illbethere == -1 ) {
			$cat_list_illbethere = '';
		}

		$exclude_illbethere = $pageParams->get( 'cat_list_exclude_illbethere' );
		// read RSVP categories list
		$query = "SELECT e.*, c.name as cat_name
			FROM #__illbethere_sessions as e
			LEFT JOIN #__illbethere_categories as c
			ON c.cat_id = e.cat_id
			WHERE e.published = '1'
			AND (
					( e.session_down < ". $startRecent ." AND e.session_down != '" . JCL_EVENT_NO_END_DATE."' AND e.session_down != '" .JCL_ALL_DAY_EVENT_END_DATE. "' AND e.session_down != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' AND e.session_down != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."')
				OR
					( e.session_up < ". $startRecent ." AND (e.session_down  = '" . JCL_EVENT_NO_END_DATE."' OR e.session_down  = '" .JCL_ALL_DAY_EVENT_END_DATE. "' OR e.session_down  = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' OR e.session_down  = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."' ))
				)
			";
		// apply category restrictions
		if ( !empty( $cat_list_illbethere ) ) {
			$query .= " AND e.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
		}
		// apply sort order
		$query .= " ORDER BY e.session_up, e.title ASC";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		foreach ( $extra_rows as $i => $row ) {
			$row->cat_ext = 'illbethere';
			$row->extid = $row->session_id;
			$row->start_date = $row->session_up;
			$row->end_date = $row->session_down;
			$row->description = $row->introtext;
			$rowsRecent[] = $row;
		}
	}

	if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && $CONFIG_EXT['show_community'] ) ) {
		$cat_list_community = jclValidateList( $pageParams->get( 'cat_list_community' ) );
		if ( empty( $cat_list_community ) ) {
			$cat_list_community = @$CONFIG_EXT['cat_list_community'];
		}
		if ( $cat_list_community == -1 ) {
			$cat_list_community = '';
		}
		$exclude_community = $pageParams->get( 'cat_list_community_exclude' );
		// read RSVP categories list
		$query = "SELECT e.*, c.name as cat_name
			FROM #__community_events as e
			LEFT JOIN #__community_events_category as c
			ON c.id = e.catid
			WHERE 
			 (
					( e.enddate < ". $startRecent ." AND e.enddate != '" . JCL_EVENT_NO_END_DATE."' AND e.enddate != '" .JCL_ALL_DAY_EVENT_END_DATE. "' AND e.enddate != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' AND e.enddate != '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."')
				OR
					( e.startdate < ". $startRecent ." AND (e.enddate = '" . JCL_EVENT_NO_END_DATE."' OR e.enddate = '" .JCL_ALL_DAY_EVENT_END_DATE. "' OR e.enddate = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY."' OR e.enddate = '".JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2."' ))
				)
			";
		// apply category restrictions
		if ( !empty( $cat_list_community ) ) {
			$query .= " AND e.catid ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
		}
		// apply sort order
		$query .= " ORDER BY e.startdate, e.title ASC";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		foreach ( $extra_rows as $i => $row ) {
			$row->cat_ext = 'community';
			$row->extid = $row->id;
			$row->start_date = $row->startdate;
			$row->end_date = $row->enddate;
			$rowsRecent[] = $row;
		}
	}
	
	// sort as per user settings
	if (!empty( $rowsRecent)) {
		usort( $rowsRecent, 'jclModuleSortLatestItems');
		$rowsRecent = array_slice( $rowsRecent, 0, $EXTCAL_CONFIG['number_of_events_to_list_recent'] );
	}
}

if ( ((count($rowsUpcoming) + count($rowsRecent)) > 0) || $EXTCAL_CONFIG['display_if_no_events'] ) {  // IF: Don't display if there are no events and the parameter is set not to

	##-------------------Second, define an important constant if not defined already:

	if ( !defined('EXTCAL_TEXT_ALL_DAY') ) {

		if ( isset($lang_add_event_view) ) {
			define('EXTCAL_TEXT_ALL_DAY',$lang_add_event_view['all_day_label']);
		} else {
			$extcal_language_path = $mosConfig_absolute_path . "/components/com_jcalpro/languages/";
			if (!file_exists($extcal_language_path."{$mosConfig_lang}/index.php")) $mosConfig_lang = 'english';
			require_once $extcal_language_path."{$mosConfig_lang}/index.php";
			define('EXTCAL_TEXT_ALL_DAY',$lang_add_event_view['all_day_label']);
		}

	}

	##-------------------Upcoming Events Section:

	if ( count($rowsUpcoming) ) {

		$extcounter = 0;
		$module_output_array = array();
		$module_output_array[$extcounter] = "";
		$previouseventmonth = '';

		if( $outputSetting == 1 && !$EXTCAL_CONFIG['show_month_separators'] ) { $module_output_array[$extcounter] .= "<ul class=\"eventslist\">"; }

		foreach ( $rowsUpcoming as $thisEvent ) { // For each upcoming event we do:

			$thiseventmonth = jcUTCDateToFormat( $thisEvent->start_date, '%B');  // for display, so set offset
			if ( $EXTCAL_CONFIG['show_month_separators'] ) { // If "Show Month Separators" is enabled in Administration, draw the month name:
				if ($thiseventmonth != $previouseventmonth) {
					// If this is a new month and it's not the first incident, we decrement the counter so that
					// this event is simply added to the the previous array index. Now when we implode a few lines
					// down, it won't add the event separator between the event and the month separator.
					if( $outputSetting == 1 && $previouseventmonth != '' ) { $module_output_array[$extcounter] .= "</ul>"; }
					$module_output_array[$extcounter] .= '<div'.$EXTCAL_CONFIG['month_separator_style'].'>' . ucwords($thiseventmonth) . '</div>';
					if( $outputSetting == 1 ) { $module_output_array[$extcounter] .= "<ul class=\"eventslist\">"; }
					$previouseventmonth = $thiseventmonth;
				}
			}

			$ext_full_calendar_URL = JRoute::_( 'index.php?option=com_jcalpro&amp;Itemid=' . $EXTCAL_CONFIG['Itemid'] );
			$urlTargetDate = @$urlTargetDate.'';

			// popup or link ?
			if ($CONFIG_EXT['popup_event_mode']) {
				if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'illbethere' ) {
					$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$thisEvent->extid . '&amp;tmpl=component' . getIllBeThereItemid();
				} else if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'community' ) {
					$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$thisEvent->extid . '&amp;tmpl=component' . getJomSocialItemid();
				} else {
					$non_sef_href = "index.php?option=com_jcalpro&amp;Itemid="./*$EXTCAL_CONFIG['Itemid']*/ jclGetEventItemid($thisEvent, $EXTCAL_CONFIG['Itemid']) ."&amp;extmode=view&amp;extid=".$thisEvent->extid. '&amp;tmpl=component' . (strlen($urlTargetDate)?"&amp;date=$urlTargetDate":'');
				}
				$link = 'href="'.JRoute::_( $non_sef_href ).'" class="jcal_modal" rel="{handler: \'iframe\'}" ';
			} else {
				if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'illbethere' ) {
					$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$thisEvent->extid . getIllBeThereItemid() );
				} else if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'community' ) {
					$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$thisEvent->extid . getJomSocialItemid() );
				} else {
					$sef_href = JRoute::_( "index.php?option=com_jcalpro&amp;Itemid=".jclGetEventItemid($thisEvent, $EXTCAL_CONFIG['Itemid'])."&amp;extmode=view&amp;extid=".$thisEvent->extid  . (strlen($urlTargetDate)?"&amp;date=$urlTargetDate":'') );
					//$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$thisEvent->extid  . (strlen($urlTargetDate)?"&amp;date=$urlTargetDate":'') );
				}
				$link = "href=\"$sef_href\"";
			}

			// Actual output:
			if ( $outputSetting == 1)
			{
				$module_output_array[$extcounter] .= '<li>';
			}
			else
			{
				$module_output_array[$extcounter] .= '<div class="latest_event">';
			}

			$module_output_array[$extcounter] .= '<a '.$link.'>' . mf_shorten_with_ellipsis($thisEvent->title,$EXTCAL_CONFIG['title_max_length']);
			$module_output_array[$extcounter] .= "</a>\n";
			if( $EXTCAL_CONFIG['show_dates'] || $EXTCAL_CONFIG['show_times'] ) {
				$module_output_array[$extcounter] .= '<br /><span class="eventsdate">';
				$module_output_array[$extcounter] .=  mf_get_daterange_string( $thisEvent );
				$module_output_array[$extcounter] .= "</span>\n";
			}

			$calCatString = ( $EXTCAL_CONFIG['show_calendar'] && @$thisEvent->cal_name != '' ) ? '(<small>' . stripslashes( @$thisEvent->cal_name) . '</small>) ' : '';
			$calCatString .= ( $EXTCAL_CONFIG['show_category'] && $thisEvent->cat_name != '' )  ? '(<small>' . stripslashes( $thisEvent->cat_name) . '</small>) ' : '';
			$module_output_array[$extcounter] .= empty( $calCatString) ? '' : '<br />' . $calCatString;

			if( $EXTCAL_CONFIG['show_description'] ) {
				$desc = $EXTCAL_CONFIG['show_description'] ? sub_string(stripslashes( process_extcal_description($thisEvent->description)),
				$EXTCAL_CONFIG['description_max_length'],'...') : '';
				$desc = jclProcessReadmore( $desc, $EXTCAL_CONFIG['show_readmore'], @$ext_event_link_URL.'' );
				$module_output_array[$extcounter] .= $EXTCAL_CONFIG['show_description'] && !empty($desc) ? "<br /><div class=\"eventdescription\">" . $desc . "</div>" : '';
			}
			$module_output_array[$extcounter] .= $EXTCAL_CONFIG['show_contact'] && !empty($thisEvent->contact) ? '<br /><small>' . stripslashes( $thisEvent->contact) . '</small>' : '';

			if ( $outputSetting == 1)
			{
				$module_output_array[$extcounter] .= "</li>\n";
			}
			else
			{
				$module_output_array[$extcounter] .= "</div>\n";
			}
			$extcounter++;
			$module_output_array[$extcounter] = '';
		}

		if ( $outputSetting == 1)
		{
			$module_output_array[$extcounter] .= "</ul>\n";
		}

		// Get event separator only if output is not a table (<ul>)
		if( $outputSetting != 1 ) { $event_separator = $EXTCAL_CONFIG['event_separator']; }
		else { $event_separator = ""; }

		// We did this in an array so we can implode it and separate the entries with whatever we want.
		$module_output .= implode($event_separator,$module_output_array);

	} else {
		// display "No upcoming events" message, but only if user has set the module to display upcoming events
		if ($EXTCAL_CONFIG['number_of_events_to_list_upcoming']) {
			$module_output .= '<div class="latest_event">'.$EXTCAL_CONFIG['no_upcoming_events_text'].'</div>';
		}
	}

	##-------------------Recent Events Section (if enabled in the module parameters):

	if ( ($EXTCAL_CONFIG['number_of_events_to_list_recent'] || $forcedEventId) && !empty($rowsRecent) ) {

		$module_output .= '<div'.$EXTCAL_CONFIG['recent_events_style'].'>' . $EXTCAL_CONFIG['recent_events_text'] . '</div>';
		$extcounter = 0;
		$module_output_array = array();
		$module_output_array[$extcounter] = "";
		$previouseventmonth = '';

		if( $outputSetting == 1 && !$EXTCAL_CONFIG['show_month_separators'] ) { $module_output_array[$extcounter] .= "<ul>"; }

		foreach ( $rowsRecent as $thisEvent ) { // For each upcoming event we do:

			if ( $EXTCAL_CONFIG['show_month_separators'] ) { // If "Show Month Separators" is enabled in Administration, draw the month name:
				$thiseventmonth = jcUTCDateToFormat($thisEvent->start_date, '%B');
				if ($thiseventmonth != $previouseventmonth) {
					if( $outputSetting == 1 && $previouseventmonth != '' ) { $module_output_array[$extcounter] .= "</ul>"; }
					$module_output_array[$extcounter] .= '<div'.$EXTCAL_CONFIG['month_separator_style'].'>' . ucwords($thiseventmonth) . '</div>';
					if( $outputSetting == 1 ) { $module_output_array[$extcounter] .= "<ul>"; }
					$previouseventmonth = $thiseventmonth;
				}
			}
		
			$tmpl = $CONFIG_EXT['popup_event_mode'] ? '&amp;tmpl=component' : '';
			if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'illbethere' ) {
				$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$thisEvent->extid . $tmpl . getIllBeThereItemid();
			} else if ( isset( $thisEvent->cat_ext ) && $thisEvent->cat_ext == 'community' ) {
				$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$thisEvent->extid . $tmpl . getJomSocialItemid();
			} else {
				$non_sef_href = "index.php?option=com_jcalpro&amp;Itemid=".jclGetEventItemid($thisEvent, $EXTCAL_CONFIG['Itemid'])."&amp;extmode=view&amp;extid=".$thisEvent->extid. $tmpl;
			}
			
			$ext_event_link_URL = JRoute::_($non_sef_href);
			// Actual output:
			if ( $outputSetting == 1)
			{
				$module_output_array[$extcounter] .= '<li>';
			}
			else
			{
				$module_output_array[$extcounter] .= '<div class="latest_event">';
			}
			$module_output_array[$extcounter] .= '<a '.($CONFIG_EXT['popup_event_mode'] ? 'class="jcal_modal" rel="{handler: \'iframe\'}"': '').' href="' . $ext_event_link_URL . '" >' . mf_shorten_with_ellipsis($thisEvent->title,$EXTCAL_CONFIG['title_max_length']) . '</a>';
			if( $EXTCAL_CONFIG['show_dates'] || $EXTCAL_CONFIG['show_times'] ) {
				$module_output_array[$extcounter] .= '<span class="eventsdate">';
				$module_output_array[$extcounter] .=  '<br />' . mf_get_daterange_string($thisEvent);
				$module_output_array[$extcounter] .= "</span>\n";
			}

			$calCatString = ( $EXTCAL_CONFIG['show_calendar'] && @$thisEvent->cal_name != '' ) ? '(<small>' . stripslashes( @$thisEvent->cal_name) . '</small>) ' : '';
			$calCatString .= ( $EXTCAL_CONFIG['show_category'] && @$thisEvent->cat_name != ''  )? '(<small>' . stripslashes( @$thisEvent->cat_name) . '</small>) ' : '';
			$module_output_array[$extcounter] .= empty( $calCatString) ? '' : '<br />' . $calCatString;

			$desc = sub_string(process_extcal_description($thisEvent->description), $EXTCAL_CONFIG['description_max_length'],'...');
			$desc = jclProcessReadmore( $desc, $EXTCAL_CONFIG['show_readmore'], $ext_event_link_URL );
			$module_output_array[$extcounter] .= $EXTCAL_CONFIG['show_description'] && !empty($desc) ? "<br /><div class=\"eventdescription\">" . $desc . "</div>" : '';
			$module_output_array[$extcounter] .= $EXTCAL_CONFIG['show_contact'] && !empty( $thisEvent->contact) ? '<br /><small>' . stripslashes( $thisEvent->contact) . '</small>' : '';

			if ( $outputSetting == 1)
			{
				$module_output_array[$extcounter] .= '</li>';
			}
			else
			{
				$module_output_array[$extcounter] .= '</div>';
			}

			$extcounter++;
			$module_output_array[$extcounter] = '';
		}

		if ( $outputSetting == 1)
		{
			$module_output_array[$extcounter] .= '</ul>';
		}

		// Get event separator only if output is not a table (<ul>)
		if( $outputSetting != 1 ) { $event_separator = $EXTCAL_CONFIG['event_separator']; }
		else { $event_separator = ""; }

		// We did this in an array so we can implode it and separate the entries with whatever we want.
		$module_output .= implode($event_separator,$module_output_array);
	}

	##-------------------Extra Links to Full Calendar and Add New Event:

	if ( $EXTCAL_CONFIG['show_full_calendar_link'] ) {
		$ext_full_calendar_URL = JRoute::_( 'index.php?option=com_jcalpro&amp;view=calendar&amp;Itemid=' . $EXTCAL_CONFIG['Itemid'] );
		$module_output .= '<a href="'.$ext_full_calendar_URL.'">' . $EXTCAL_CONFIG['full_calendar_link_text'] . '</a><br />';
	}
	if ( $EXTCAL_CONFIG['show_add_event_link'] && has_priv( 'add') ) {
		$ext_add_event_URL = JRoute::_( 'index.php?option=com_jcalpro&amp;Itemid=' . $EXTCAL_CONFIG['Itemid'] . '&amp;extmode=event&amp;event_mode=add' );
		$module_output .= '<a href="'.$ext_add_event_URL.'">' . $EXTCAL_CONFIG['add_event_text'] . '</a><br />';
	}

	##-------------------Set the locale for date/time functions back to the one already set by Mambo:
	/*if ( $locale_was_set ) setlocale(LC_TIME,$mosConfig_locale);*/

	echo $module_output;

} // ENDIF: Don't display if there are no events and the parameter is set not to