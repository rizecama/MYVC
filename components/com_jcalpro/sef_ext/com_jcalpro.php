<?php
/*
 **********************************************
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
 http://dev.anything-digital.com//
 **********************************************
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $mainframe;
$sefConfig = & shRouter::shGetConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// include utility functions, shared with meta_ext plugin
include_once( JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'sef_ext'.DS.'com_jcalpro_lib.php');

// ------------------  Load plugin language file  ---------------------------------------------------

$shLangIso = jclLoadPluginLanguage( 'com_jcalpro_lang', $shLangIso, '_JCL_SH404SEF_CALENDAR');

// ------------------  End of loading plugin language file ------------------------------------------


// ------------------  End of loading plugin language file ------------------------------------------

// Update issue : as of 1.5.5 of sh404sef, we created sh404sef backend parameters for jcal
// those params are used in this new version of the jcal plugin for sh404sef
// howver, users upgrading their Jcal pro without upgrading their sh404sef will
// experience errors. So we are making sure this does not happen here

if (is_null( $sefConfig->jclInsertCalendarId)) {
	$sefConfig->jclInsertEventId = false;
	$sefConfig->jclInsertCategoryId = false;
	$sefConfig->jclInsertCalendarId = false;
	$sefConfig->jclInsertCalendarName = false;
	$sefConfig->jclInsertDate = false;
	$sefConfig->jclInsertDateInEventView = true;
}
// -----------------


// get url variable
$extmode = empty($extmode) ? null : $extmode;
$event_mode = empty($event_mode) ? null : $event_mode;
$cal_id = empty($cal_id) ? null : $cal_id;
$cat_id = empty($cat_id) ? null : $cat_id;
$cat_ext = empty($cat_ext) ? null : $cat_ext;
$extid = empty($extid) ? null : $extid;
$date = empty($date) ? null : $date;
$view = empty($view) ? null : $view;

// Build the root of the url
$shName = shGetComponentPrefix($option);
$shName = empty($shName) ? getMenuTitle($option, (isset($view) ? @$view : null), $Itemid ) : $shName;

if ($sefConfig->jclInsertCalendarId && !empty( $cal_id) && !empty($shName) && $shName != '/') {
	$shName = $cal_id . $shName;
}

if ($sefConfig->jclInsertCalendarName && !empty($shName) && $shName != '/') {
	$title[] = $shName;
	$title[] = '/';
}

// build url

// calendar can be set through url
if (!empty( $cal_id)) {
	$calTitle = jclGetCalendarName( $cal_id, $option, $shLangName);
	if (!empty( $calTitle)) {
		$title[] =  $calTitle;
		shRemoveFromGETVarsList('cal_id');
	}
}

// flag to avoid inserting date twice
$dateInserted = false;

// main display mode
switch ($extmode) {
	default:
		$dosef = false;
		break;
	case '' :
		// to avoid the 'default' case
		shRemoveFromGETVarsList('view');
		break;
	case 'cal' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_MONTHLY'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'flat' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_FLAT'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'week' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_WEEKLY'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'day' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_DAYLY'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'cats' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_CATEGORIES'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'cat' :
		$catTitle = jclGetCategoryTitle( $cat_id, $cat_ext, $option, $shLangName);
		if (!empty( $catTitle)) {
			// if we have a category title, use it
			$title[] = $catTitle;
			shRemoveFromGETVarsList('cat_id');
			shRemoveFromGETVarsList('cat_ext');
		}
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'view' :
		$eventData = null;
		$eventTitle = jclGetEventData( $extid, $eventData, $option, $shLangName);
		if (!empty( $eventTitle)) {
			// optionnally insert date
			if ($sefConfig->jclInsertDateInEventView) {
				if (!function_exists( 'jcUTCDateToFormat')) {
					// we may be doing an auto-redirect, and functions.inc.php may not be loaded
					require_once (JPATH_ROOT .DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'functions.inc.php');
				}
				$title[] = jcUTCDateToFormat($eventData->start_date, '%Y-%m-%d');
				shRemoveFromGETVarsList('date');
				$dateInserted = true;
			}
			// if we have an event title (we should), use it
			$title[] = $eventTitle;
			if (!empty($eventData->rec_id)) {
				// if a recurrence of an event, add id to segragate
				// from initial event
				$title[] = $extid;
			}

			shRemoveFromGETVarsList('extid');
		}
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'extcal_search' :
		$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_SEARCH'];
		$title[] = '/';
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('view');
		break;
	case 'event' :
		switch ($event_mode) {
			case 'add' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_ADD_EVENT'];
				$title[] = '/';
				break;
			case 'edit' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_EDIT_EVENT'];
				$title[] = '/';
				break;
			case 'del' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_DELETE_EVENT'];
				$title[] = '/';
				break;
			case 'apr' :
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_APPROVE_EVENT'];
				$title[] = '/';
				break;
			default:
				$title[] = $sh_LANG[$shLangIso]['_JCL_SH404SEF_VIEW_EVENT'];
				$title[] = '/';
				break;
		}
		shRemoveFromGETVarsList('extmode');
		shRemoveFromGETVarsList('event_mode');
		shRemoveFromGETVarsList('view');
		break;
}

// insert requested date
if ($sefConfig->jclInsertDate && !empty( $date) && !$dateInserted) {
	$title[] = $date;
	shRemoveFromGETVarsList('date');
}

// don't return an empty url
if (empty( $title) && !empty($shName) && $shName != '/') {
	$title[] = $shName;
	$title[] = '/';
}

// remove standard variables
shRemoveFromGETVarsList('option');
if (!empty($Itemid)) {
	shRemoveFromGETVarsList('Itemid');
}
shRemoveFromGETVarsList('lang');

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
	$string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
	(isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
	(isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------
