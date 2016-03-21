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

 $Id: com_jcalpro.php 667 2011-01-24 21:02:32Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com/
 **********************************************
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $shMosConfig_locale, $sh_LANG, $mainframe, $Itemid;

// include utility functions, shared with sef_ext plugin
include_once( JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'sef_ext'.DS.'com_jcalpro_lib.php');

// get a DB instance
$database =& JFactory::getDBO();

// get parameters
$extmode = JRequest::getString( 'extmode', '');
$event_mode = JRequest::getString( 'event_mode', 0);
$cal_id = JRequest::getInt( 'cal_id', 0);
$cat_id = JRequest::getInt( 'cat_id', 0);
$cat_ext = JRequest::getString( 'cat_ext', 0);
$extid = JRequest::getInt( 'extid', 0);
$date = JRequest::getString( 'date', 0);
$lang = JRequest::getString( 'lang', '');
$extcal_search= JRequest::getString( 'extcal_search', '');

// Build the root of the url
$shName = shGetComponentPrefix($option);
$shName = empty($shName) ? getMenuTitle($option, (isset($view) ? @$view : null), $Itemid ) : $shName;

// load language strings
$shLangName = empty($lang) ? $shMosConfig_locale : shGetNameFromIsoCode( $lang);
$shLangIso = isset($lang) ? $lang : shGetIsoCodeFromName( $shMosConfig_locale);
$shLangIso = jclLoadPluginLanguage( 'com_jcalpro_lang', $shLangIso, '_JCL_SH404SEF_CALENDAR');

//-------------------------------------------------------------

global 	$shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag,
$shCustomLangTag, $shCustomRobotsTag;

// JCalPro language strings and params
global $lang_date_format, $lang_weekly_event_view, $today;

$shCustomLangTag = $shLangIso;
$shCustomRobotsTag = ($tmpl = 'component' && !empty( $print) ) ? 'noindex, nofollow' : 'index, follow';
$title= array();

// build page title
// calendar can be set through url
if (!empty( $cal_id)) {
	$calTitle = jclGetCalendarName( $cal_id, $option, $shLangName);
	if (!empty( $calTitle)) {
		$title[] = $calTitle;
	}
} else {
	$title[] = $shName;
}

// main display mode
switch ($extmode) {
	case 'cal' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_MONTHLY'];
		if (!empty( $date)) {
			$title[] = jcUTCDateToFormat( $date, $lang_date_format['month_year']);
		} else {
			// this is current month
			$title[] = jcTSToFormat( mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['month_year']);
		}
		break;
	case 'flat' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_FLAT'];
		if (!empty( $date)) {
			$title[] = jcUTCDateToFormat( $date, $lang_date_format['month_year']);
		} else {
			// this is current month
			$title[] = jcTSToFormat( mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['month_year']);
		}
		break;
	case 'week' :
		if(!empty( $date)) {
			$dateDetails = jclExtractDetailsFromDate( $date, '%Y-%m-%d');
			if ($dateDetails) {
				$day = $dateDetails->day;
				$month = $dateDetails->month;
				$year = $dateDetails->year;
			}
		}

		if (empty($day)) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}

		// Calculationg the week number
		$weeknumber = get_week_number($day, $month, $year);
		$week_bound = array();
		$week_bound = get_week_bounds($day,$month,$year);

		$fdy = $week_bound['first_day']['year'];
		$fdm = $week_bound['first_day']['month'];
		$fdd = $week_bound['first_day']['day'];

		$ldy = $week_bound['last_day']['year'];
		$ldm = $week_bound['last_day']['month'];
		$ldd = $week_bound['last_day']['day'];

		$period = sprintf($lang_weekly_event_view['week_period'],jcUTCDateToFormatNoOffset( "$fdy-$fdm-$fdd", $lang_date_format['mini_date']),
		jcUTCDateToFormatNoOffset( "$ldy-$ldm-$ldd", $lang_date_format['mini_date']));

		$title[] = $period;
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_WEEKLY'] . ' ' . $weeknumber;
		break;
	case 'day' :
		if(!empty( $date)) {
			$dateDetails = jclExtractDetailsFromDate( $date, '%Y-%m-%d');
			if ($dateDetails) {
				$day = $dateDetails->day;
				$month = $dateDetails->month;
				$year = $dateDetails->year;
			}
		}

		if (empty($day)) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_DAYLY'];
		$title[] = jcTSToFormat( mktime(0,0,0,$month,$day,$year), $lang_date_format['full_date']);
		break;
	case 'cats' :
		If (!empty( $cal_id)) {
			$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_CATEGORIES'];
		}
		break;
	case 'cat' :
		$catTitle = jclGetCategoryTitle( $cat_id, $cat_ext, $option, $shLangName);
		if (!empty( $catTitle)) {
			// if we have a category title, use it
			$title[] = $catTitle;
		}
		break;
	case 'view' :
		$eventData = null;;
		$eventTitle = jclGetEventData( $extid, $eventData, $option, $shLangName);
		if (!empty( $eventData)) {
			// set calendar
			$eventCal = jclGetCalendarTitle( $eventData->cal_id, $option, $shLangName);
			if (!empty( $eventCal)) {
				$title[] = $eventCal;
			}
			// set category
			$eventCat = jclGetCategoryTitle( $eventData->cat, $cat_ext, $option, $shLangName);
			if (!empty( $eventCat)) {
				$title[] = $eventCat;
			}
			// start date
			$title[] = jcUTCDateToFormat( $eventData->start_date, $lang_date_format['full_date']);
			// main title
			$title[] = $eventData->title . (!empty($eventData->rec_id) ? ' ' . $sh_LANG[$shLangIso]['_JCL_SH404SEF_RECURRENCE'] : '');
		}
		break;
	case 'extcal_search' :
		$searchTitle = $sh_LANG[$shLangIso]['_JCL_SH404SEF_SEARCH'];
		if (!empty( $extcal_search)) {
			$searchTitle .= ' : ' . $extcal_search;
		}
		$title[] = $searchTitle;
		break;
	case 'event' :
		switch ($event_mode) {
			case 'add' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_ADD_EVENT'];
				break;
			case 'edit' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_EDIT_EVENT'];
				break;
			case 'del' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_DELETE_EVENT'];
				break;
			default:
				break;
		}
		break;
	default:
		break;
}

// finalize title
$title = array_reverse( $title);
$shCustomTitleTag = JString::ltrim(implode( ' | ', $title), '/ | ');