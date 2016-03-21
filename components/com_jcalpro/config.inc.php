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

 $Id: config.inc.php 720 2011-05-12 08:36:01Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe, $Itemid, $session, $CONFIG_EXT, $THEME_DIR, $REFERER, $ME;
global $template_header, $template_footer, $meta_content, $lang_general, $show_main_menu;
global $lang_event_admin_data, $event_mode, $lang_info, $lang_system, $upgrade_detected, $lang_generalm;
global $lang_monthly_event_view, $lang_date_format, $event_icons, $template_monthly_view, $todayclr, $cat_id, $cal_id, $cat_list, $cal_list, $private_events_mode;
global $template_monthly_view_nav_row_sub_template, $template_monthly_view_print_nav_row_sub_template;
global $lang_event_search_data, $sundayclr, $weekdayclr, $todayclrHl, $weekdayclrHl, $sundayclrHl;
global $template_main_menu, $lang_main_menu, $template_add_event_form, $template_add_event_form_alt_rec_info, $template_add_event_form_show_calendar, $template_add_event_form_do_not_show_calendar, $template_add_event_form_show_private, $template_add_event_form_do_not_show_private, $template_calendar_select_sub_template, $template_add_event_form_show_auto_approve, $template_add_event_form_do_not_show_auto_approve, $errors, $today, $lang_daily_event_view;
global $lang_weekly_event_view, $lang_flat_event_view, $template_search_results, $lang_event_search_data, $lang_latest_events;
global $template_search_form, $template_cat_form, $template_caption_dialog, $template_event_view, $lang_event_view, $lang_add_event_view, $extmode;
global $zone_stamp, $template_mini_cal_view, $lang_mini_cal, $info_data, $picture, $cats_limit, $extcal_code_insert;
global $lang_cats_view, $template_cats_list, $lang_cat_events_view, $next_recurrence_stamp, $Itemid_Querystring, $template_cat_events_list, $template_cat_legend;
global $template_error_string, $template_admin_events;

jimport( 'joomla.utilities.date');
jimport('joomla.html.html');

$db = &JFactory::getDBO();
$my = &JFactory::getUser();
$registry = &JFactory::getConfig();
$option = JRequest::getCmd('option', 'com_jcalpro');

if ( !defined('USER_IS_ADMIN') ) define('USER_IS_ADMIN',($my->usertype == 'Administrator' || $my->usertype == 'Super Administrator') ? true : false);
if ( !defined('USER_IS_LOGGED_IN') ) define('USER_IS_LOGGED_IN',!($my->usertype == ''));

// Set initial debug level
$DB_DEBUG = true;

// define application constants
define('CONFIG_FILE_INCLUDED', true);

define('EXTCALENDAR_CONFIG_SET', true);

define('CALENDAR_NAME', 'JCal pro');
define('CALENDAR_VERSION', '2');

define('TEMPLATE_FILE', 'template.html');
define('TEMPLATE_JS_FILE', 'template.js');

// number of years ot show in year select list
define('JCL_NUMBER_YEARS_TO_SHOW_BEFORE', 5);
define('JCL_NUMBER_YEARS_TO_SHOW_AFTER', 20);

// a few options
// set to 0 so that week view show only days where at least one event exists.
// set to 1 to have all days of a week show, regardless of whether they have events or not
define( 'JC_SHOW_EMPTY_DAYS_ON_WEEK_VIEWS', 1);

// default values, JCal Pro 2
define('JCL_DEFAULT_OWNER_ID', 62);
define('JCL_RECUR_NO_LIMIT', 0);
define('JCL_RECUR_SO_MANY_OCCURENCES', 1);
define('JCL_RECUR_UNTIL_A_DATE', 2 );
define('JCL_SHOW_ALL_CALENDARS', 1);
define('JCL_SHOW_ONLY_THIS_CALENDAR', 2);
define('JCL_SHOW_ALL_EVENTS', 1);
define('JCL_DO_NOT_SHOW_PRIVATE_EVENTS', 2);
define('JCL_SHOW_ONLY_PRIVATE_EVENTS', 3);
define('JCL_SHOW_ONLY_OWN_EVENTS', 4);
define('JCL_EVENT_PUBLIC', 0);
define('JCL_EVENT_PRIVATE', 1);
define('JCL_EVENT_PRIVATE_READ_ONLY', 2);

// JcalPro 2.1 : new recurrence options
define('JCL_REC_TYPE_NONE', 0);
define('JCL_REC_TYPE_DAILY', 1);
define('JCL_REC_TYPE_WEEKLY', 2);
define('JCL_REC_TYPE_MONTHLY', 3);
define('JCL_REC_TYPE_YEARLY', 4);

define('JCL_REC_ON_DAY_NUMBER', 0);
define('JCL_REC_ON_SPECIFIC_DAY', 1);

define('JCL_REC_FIRST', 1);
define('JCL_REC_SECOND', 2);
define('JCL_REC_THIRD', 3);
define('JCL_REC_FOURTH', 4);
define('JCL_REC_LAST', 5);

define('JCL_REC_DAY_TYPE_DAY', 0);
define('JCL_REC_DAY_TYPE_SUNDAY', 1);
define('JCL_REC_DAY_TYPE_MONDAY', 2);
define('JCL_REC_DAY_TYPE_TUESDAY', 3);
define('JCL_REC_DAY_TYPE_WEDNESDAY', 4);
define('JCL_REC_DAY_TYPE_THURSDAY', 5);
define('JCL_REC_DAY_TYPE_FRIDAY', 6);
define('JCL_REC_DAY_TYPE_SATURDAY', 7);
define('JCL_REC_DAY_TYPE_WEEK_DAY', 8);
define('JCL_REC_DAY_TYPE_WEEKEND_DAY', 9);

define('JCL_REC_JANUARY', 0);
define('JCL_REC_FEBRUARY', 1);
define('JCL_REC_MARCH', 2);
define('JCL_REC_APRIL', 3);
define('JCL_REC_MAY', 4);
define('JCL_REC_JUNE', 5);
define('JCL_REC_JULY', 6);
define('JCL_REC_AUGUST', 7);
define('JCL_REC_SEPTEMBER', 8);
define('JCL_REC_OCTOBER', 9);
define('JCL_REC_NOVEMBER', 10);
define('JCL_REC_DECEMBER', 11);

define('JCL_FEEDS_STRIP_DESCRIPTION_HTML', 1);
define('JCL_FEEDS_DAYS_TO_INCLUDE_IN_FEED', 30);

define('JCL_SHOW_RECURRING_EVENTS_NONE', 0);
define('JCL_SHOW_RECURRING_EVENTS_ALL', 1);
define('JCL_SHOW_RECURRING_EVENTS_FIRST_ONLY', 2);
define('JCL_SHOW_RECURRING_EVENTS_NEXT_ONLY', 2);
define('JCL_SHOW_RECURRING_EVENTS_DEFER_TO_JCAL', 3);

define('JCL_EVENT_NO_END_DATE', '0000-00-00 00:00:00');

define('JCL_ALL_DAY_EVENT_END_DATE_LEGACY', '0000-00-00 00:00:01');
define('JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2', '9999-12-01 00:00:00');
define('JCL_ALL_DAY_EVENT_END_DATE', '2038-01-18 00:00:00');

define('JCL_LIST_ALL_EVENTS', 0);
define('JCL_LIST_PAST_EVENTS', 1);
define('JCL_LIST_UPCOMING_EVENTS', 2);
define('JCL_LIST_TODAY_EVENTS', 3);
define('JCL_LIST_YESTERDAY_EVENTS', 4);
define('JCL_LIST_TOMORROW_EVENTS', 5);
define('JCL_LIST_THIS_WEEK_EVENTS', 6);
define('JCL_LIST_LAST_WEEK_EVENTS', 7);
define('JCL_LIST_NEXT_WEEK_EVENTS', 8);
define('JCL_LIST_THIS_MONTH_EVENTS', 9);
define('JCL_LIST_LAST_MONTH_EVENTS', 10);
define('JCL_LIST_NEXT_MONTH_EVENTS', 11);
define('JCL_LIST_MONDAY_EVENTS', 12);
define('JCL_LIST_TUESDAY_EVENTS', 13);
define('JCL_LIST_WEDNESDAY_EVENTS', 14);
define('JCL_LIST_THURSDAY_EVENTS', 15);
define('JCL_LIST_FRIDAY_EVENTS', 16);
define('JCL_LIST_SATURDAY_EVENTS', 17);
define('JCL_LIST_SUNDAY_EVENTS', 18);
define('JCL_LIST_ACTIVE_EVENTS', 19);

define('JCL_DATE_MIN', '1971-01-01 00:00:00');
define('JCL_DATE_MAX', '2038-01-17 00:00:00');

define('JCL_FLEX_MAX_PANES', 9);
define('JCL_FLEX_DISPLAY_CONTENT_EVENTS_LIST', 0);
define('JCL_FLEX_DISPLAY_CONTENT_MINICAL', 1);

// microformating
define('JCL_MICROFORMAT_NONE', 'JclOutputFilter');
define('JCL_MICROFORMAT_HCALENDAR', 'JclOutputFilter_hCal');
define('JCL_MICROFORMAT_RDFA', 'JclOutputFilter_RDFa');

// Start buffering
ob_start();

$temp_path = realpath(isset($_SERVER['PATH_TRANSLATED'])?$_SERVER['PATH_TRANSLATED']:$_SERVER['SCRIPT_FILENAME']) . DS;

// Initialise the $CONFIG_EXT array and some other variables
$CONFIG_EXT = array();

// DB TABLE NAMES PREFIX
$CONFIG_EXT['TABLE_PREFIX'] =  "#__jcalpro2_";

// FS configuration
$CONFIG_EXT['FS_PATH'] = JPATH_ROOT . '/components/com_jcalpro/';        // Your file system path
$CONFIG_EXT['calendar_url'] = JURI::base() . 'components/com_jcalpro/';        // Your calendar web url

$CONFIG_EXT['Itemid'] = JRequest::getVar( 'Itemid', false);
if (!$CONFIG_EXT['Itemid']) {  // @TODO : remove that query, use Joomla
	$db->setQuery("SELECT MAX(id) FROM #__menu WHERE link LIKE '%index.php?option=com_jcalpro%' AND published <> '-2'");
	$CONFIG_EXT['Itemid'] = $db->loadResult();
}

$Itemid_Querystring = $CONFIG_EXT['Itemid'] ? '&amp;Itemid='.$CONFIG_EXT['Itemid'] : '';

$CONFIG_EXT['calendar_calling_page'] = "index.php?option=" . $option . $Itemid_Querystring;

require_once $CONFIG_EXT['FS_PATH'].'include/functions.inc.php';
require_once $CONFIG_EXT['FS_PATH'].'jcalpro.class.php';

$REFERER = get_referer();

// File system paths
$CONFIG_EXT['UPLOAD_DIR'] = $CONFIG_EXT['FS_PATH'].'upload/';
$CONFIG_EXT['UPLOAD_DIR_URL'] = $CONFIG_EXT['calendar_url'].'upload/';
$CONFIG_EXT['MINI_PICS_DIR'] = $CONFIG_EXT['FS_PATH'].'images/minipics/';
$CONFIG_EXT['MINI_PICS_URL'] = $CONFIG_EXT['calendar_url'].'images/minipics/';
$CONFIG_EXT['LIB_DIR'] = $CONFIG_EXT['FS_PATH'].'lib/';
$CONFIG_EXT['PLUGINS_DIR'] = $CONFIG_EXT['FS_PATH'].'plugins/';
$CONFIG_EXT['LANGUAGES_DIR'] = $CONFIG_EXT['FS_PATH'].'languages/';
$CONFIG_EXT['THEMES_DIR'] = $CONFIG_EXT['FS_PATH'].'themes/';

// Database definitions
$CONFIG_EXT['TABLE_CATEGORIES'] = $CONFIG_EXT['TABLE_PREFIX'] . 'categories';
$CONFIG_EXT['TABLE_CALENDARS'] = $CONFIG_EXT['TABLE_PREFIX'] . 'calendars';
$CONFIG_EXT['TABLE_GROUPS'] = $CONFIG_EXT['TABLE_PREFIX'] . 'groups';
$CONFIG_EXT['TABLE_USERS'] = $CONFIG_EXT['TABLE_PREFIX'] . 'users';
$CONFIG_EXT['TABLE_EVENTS'] = $CONFIG_EXT['TABLE_PREFIX'] . 'events';
$CONFIG_EXT['TABLE_CONFIG'] = $CONFIG_EXT['TABLE_PREFIX'] . 'config';
$CONFIG_EXT['TABLE_TEMPLATES'] = $CONFIG_EXT['TABLE_PREFIX'] . 'templates';
$CONFIG_EXT['TABLE_PLUGINS'] = $CONFIG_EXT['TABLE_PREFIX'] . 'plugins';
$CONFIG_EXT['TABLE_REMOTES'] = $CONFIG_EXT['TABLE_PREFIX'] . 'remotes';

// Retrieve DB stored configuration
$query = "SELECT * FROM {$CONFIG_EXT['TABLE_CONFIG']}";
$db->setQuery( $query);
$rows = $db->loadAssocList();
if (!empty( $rows)) {
	foreach ($rows as $row) {
		$CONFIG_EXT[$row['name']] = $row['value'];
	} // while
}

// calculate local server time offset
$serverOffset = date( 'O');  // + 0200 becomes 200, - 0330 becomes -330
$isDst = date( 'I');
$serverHoursOffset = intval($serverOffset/100);
$serverMinutesOffset = $serverOffset - $serverHoursOffset *100;
$serverOffset = ($serverHoursOffset * 3600 + $serverMinutesOffset * 60) / 3600;
$CONFIG_EXT['timezone'] = $serverOffset;
$CONFIG_EXT['isDst'] = $isDst;

// calculate mysql server timezone
$currentTs = gmmktime();
$currentUTCDate = gmdate( 'Y-m-d H:i:s', $currentTs);
$query = 'select unix_timestamp( \'' . $currentUTCDate . '\');';  // timestamp of 1975-01-01 00:00:00 UTC is 157766400
$db->setQuery( $query);
$row = $db->loadResult();
$CONFIG_EXT['sqlServerOffset'] = 0;
if (!empty( $row)) {
	$CONFIG_EXT['sqlServerOffset'] = $currentTs - (int) $row;
}

// website timezone value, can be overwritten by value stored in db
// set using backend
if (empty($CONFIG_EXT['site_timezone'])) {
	// no value stored in db, try to get one from Joomla config
	$CONFIG_EXT['site_timezone'] = jclGetPhpTimezoneByOffset( $mainframe->getCfg( 'offset'));
}

// Other $CONFIG_EXT vars
$CONFIG_EXT['app_name'] = $CONFIG_EXT['calendar_name']; // The Mambo sitename where your calendar lives
// get current version info

if(!isset($CONFIG_EXT['release_version'])) {
	//$CONFIG_EXT['release_name'] = '1.0';
	//$CONFIG_EXT['release_version'] = '1.0';
	//$CONFIG_EXT['release_type'] = '';
}

if(!isset($CONFIG_EXT['calendar_status'])) $CONFIG_EXT['calendar_status'] = 1;

// Set error logging level
if ($CONFIG_EXT['debug_mode']) {
	error_reporting (E_ALL);
	$DB_DEBUG = true;
}

$db->setQuery( "SELECT name FROM #__jcalpro2_themes WHERE published= '1'" );
$themeName = $db->loadResult();

// check session for jcal_change_theme stored
$shSession = & JFactory::getSession();
$sessionChangedTheme = $shSession->get( 'jcal_change_theme', '');

// Check for template name passed as URL param
$jcal_change_theme = JRequest::getString( 'jcal_change_theme', $sessionChangedTheme);
if( !empty($jcal_change_theme) ) {
	$themeName = $jcal_change_theme;
	// store new value in session, so that it stays there for this user
	$shSession->set( 'jcal_change_theme', $jcal_change_theme);
}

$CONFIG_EXT['theme'] = $themeName;

if (!file_exists($CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php")) $CONFIG_EXT['theme'] = 'default';

$isPrint = JRequest::getInt( 'print', 0) == 1;
$styleName = $isPrint ? 'print' : 'style';
$jcalcssurl = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}/{$styleName}.css";
$jcalcssie7url = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}/styleie7.css";
$jcalcssie6url = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}/styleie6.css";
$jcalcssfile = $CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/{$styleName}.css";
$jcalcssie6file = $CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/styleie6.css";
$jcalcssie7file = $CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/styleie7.css";

if (file_exists($jcalcssfile)) {
	$mainframe->addCustomHeadTag("<link href='{$jcalcssurl}' rel='stylesheet' type='text/css' />");
}
if (file_exists($jcalcssie6file)) {
	$mainframe->addCustomHeadTag("<!--[if IE 6]><link href='{$jcalcssie6url}' rel='stylesheet' type='text/css' /><![endif]-->");
}
if (file_exists($jcalcssie7file)) {
	$mainframe->addCustomHeadTag("<!--[if IE 7]><link href='{$jcalcssie7url}' rel='stylesheet' type='text/css' /><![endif]-->");
}

// let's get started with the A. word
if ($CONFIG_EXT['enable_ajax_features']) {
	// load supporting class
	include_once( $CONFIG_EXT['FS_PATH'] . 'lib/shajax.php');
	$shajaxHelper = & shajaxSupport::getInstance( $CONFIG_EXT['calendar_url'] . 'lib/', $CONFIG_EXT['calendar_url'] . 'images/ajax-loader.gif');
	$shajaxHelper->addBaseJavascript();
}

// set theme path
require_once $CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php";
$THEME_DIR = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}";

// get language info
$legacy_lang = &JFactory::getLanguage();
$CONFIG_EXT['lang'] = $legacy_lang->getBackwardLang();
if (!file_exists($CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php")) $CONFIG_EXT['lang'] = 'english';
require_once $CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php";

// load main template
jcload_template();

// get default vars set by admin either globally or on a menu item basis
$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');
$pageCal = $pageParams->get( 'select_a_cal') == JCL_SHOW_ONLY_THIS_CALENDAR ? $pageParams->get( 'cal_id') : null;
$pageCatList = $pageParams->get( 'cat_list');
$pageCalList = $pageParams->get( 'cal_list');
$pagePrivateEventMode = $pageParams->get( 'show_private_events');

// Process these default values
$extmode = JRequest::getCmd( 'extmode', $pageParams->get( 'extmode'));
$event_mode = JRequest::getCmd( 'event_mode', null);
$extid = JRequest::getInt( 'extid', null);
$event_id = JRequest::getInt( 'event_id', $extid);
$cat_id = JRequest::getInt( 'cat_id', null);
$cal_id = JRequest::getInt( 'cal_id', $pageCal);
$extcal_search = $db->getEscaped(JRequest::getVar( 'extcal_search', '','POST'));

// validate and set the calendars and categories list
$cat_list = jclValidateList( $pageCatList);
$cal_list = jclValidateList( $pageCalList);

// get the private event display mode : decide whether to show private and public, only public, only private events
$private_events_mode = JRequest::getInt( 'private_events_mode', $pagePrivateEventMode);

// Localizing time : we get timestamp
$zone_stamp = extcal_get_local_time();  // time stamp of 'now'

// Initialize time variables with today's date (in user time)
$m = (int) jcServerDateToFormat( $zone_stamp, '%m');
$y = (int) jcServerDateToFormat( $zone_stamp, '%Y');
$d = (int) jcServerDateToFormat( $zone_stamp, '%d');
$hr = (int) jcServerDateToFormat( $zone_stamp, '%H');
$mn = (int) jcServerDateToFormat( $zone_stamp, '%M');

$today = array(
	'day' => $d,
	'month' => $m,
	'year' => $y,
	'hour' => $hr,
	'minute' => $mn
);

// initialise the date variable
$reqDate = JRequest::getVar( 'date', null);
if(!empty( $reqDate)) {
	$dateDetails = jclExtractDetailsFromDate( $reqDate, '%Y-%m-%d');
	if ($dateDetails) {
		$date = array(
			'day' => (int)$dateDetails->day,
			'month' => (int)$dateDetails->month,
			'year' => (int)$dateDetails->year
		);
	}
}

if (empty( $date)) {
	$date = array(
		'day' => (int)$today['day'],
		'month' => (int)$today['month'],
		'year' => (int)$today['year']
	);
}

// prepare popup view :
if ($CONFIG_EXT['popup_event_mode']) {
	jimport( 'joomla.html.html');
	$paramsPopup = array( 'size' => array( 'x' => $CONFIG_EXT['popup_event_width'], 'y' => $CONFIG_EXT['popup_event_height']));
	//add javascript
	JHTML::_( 'behavior.modal', 'a.jcal_modal', $paramsPopup);
}

function setRights ( $action, $section, $usergroup )
{
	$my = & JFactory::getUser();
	$acl = & JFactory::getACL();

	if ( JString::trim ( $usergroup ) == "" )
	{
		$usergroup = 'public frontend';
	}

	$acl->_mos_add_acl( 'content', $action, 'users', $usergroup, $section, 'all' );

	$childs = ( $acl->get_group_children_tree( '', $usergroup, false ) );

	$usergroup = JString::strtolower($usergroup);

	if ( $usergroup == 'public frontend' OR $usergroup == 'registered' OR $usergroup == 'author' OR $usergroup == 'editor' OR $usergroup == 'publisher' )
	{
		$childs = array_merge ( $childs, $acl->get_group_children_tree ( '', 'public backend', false ) );
	}

	// $acl->get_group_children_tree translates (using JText::_ the usergroup
	// this break everything in other than English languages
	// based on the id, we must reset the usergroup to its original value
	// we do our own query, instead of using $acl->getGroup, as JAuthorization does not cache results
	if (!empty( $childs)) {
		$db = & JFactory::getDBO();
		$query = 'select id, name from #__core_acl_aro_groups;';
		$db->setQuery( $query);
		$groupList = $db->loadAssocList( 'id');
	}

	foreach ( $childs AS $childsKey => $childsValue )
	{
		if (!empty( $groupList) && array_key_exists( $childs[$childsKey]->value, $groupList)) {
			$childs[$childsKey]->text = $groupList[$childs[$childsKey]->value]['name'];
		}
		$childs[$childsKey]->text = str_replace ( "&nbsp;", "", $childs[$childsKey]->text );
		$childs[$childsKey]->text = str_replace ( "-", "", $childs[$childsKey]->text );
		$childs[$childsKey]->text = str_replace ( ".", "", $childs[$childsKey]->text );

		$childs[$childsKey]->text = JString::strtolower ( $childs[$childsKey]->text );
		$acl->_mos_add_acl( 'content', $action, 'users', $childs[$childsKey]->text, $section, 'all' );
	}
}

setRights ( 'add', 'calendar', $CONFIG_EXT['who_can_add_events'] );
setRights ( 'edit', 'calendar', $CONFIG_EXT['who_can_edit_events'] );
setRights ( 'delete', 'calendar', $CONFIG_EXT['who_can_delete_events'] );
setRights ( 'approve', 'calendar', $CONFIG_EXT['who_can_approve_events'] );
setRights ( 'bypass_captcha', 'calendar', $CONFIG_EXT['who_can_bypass_captcha'] );

// setup categories rights
$query = "
	SELECT
		cat_id, level
	FROM
		#__jcalpro2_categories
";  

$db->setQuery( $query );
$allCategories = $db->loadObjectList();

foreach ( $allCategories AS $allCategory )
{
	setRights ( 'category' . $allCategory->cat_id, 'calendar', $allCategory->level );
}

// setup calendars rights
$query = "
	SELECT
		cal_id, level
	FROM
		#__jcalpro2_calendars
";  

$db->setQuery( $query );
$allCalendars = $db->loadObjectList();

foreach ( $allCalendars AS $calendar )
{
	setRights ( 'calendar' . $calendar->cal_id, 'calendar', $calendar->level );
}

define('EXTCAL_TEXT_ALL_DAY',$lang_add_event_view['all_day_label']);