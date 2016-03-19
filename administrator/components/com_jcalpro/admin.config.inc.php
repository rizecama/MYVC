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

 $Id: admin.config.inc.php 718 2011-05-11 19:30:35Z jeffchannell $

 Revision date: 03/07/2007

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */


//==========================================
// LIFTED FROM config.inc.php    START
//==========================================

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.utilities.date');
jimport('joomla.html.html');

global $mainframe, $Itemid, $session, $CONFIG_EXT, $THEME_DIR;
global $template_header, $template_footer, $meta_content, $lang_general, $lang_add_event_view, $show_main_menu;
global $lang_event_admin_data, $event_mode, $lang_info, $lang_system, $upgrade_detected, $lang_generalm;
global $lang_monthly_event_view, $lang_date_format, $event_icons, $template_monthly_view, $todayclr, $cat_id;
global $lang_event_search_data, $sundayclr, $weekdayclr, $todayclrHl, $weekdayclrHl, $sundayclrHl;
global $template_main_menu, $lang_main_menu, $template_add_event_form, $errors, $today, $lang_daily_event_view;
global $lang_weekly_event_view, $lang_flat_event_view, $template_search_results, $lang_event_search_data;
global $template_search_form, $lang_config_data, $comp_path, $template_cat_form, $template_cal_form, $lang_cat_admin_data, $lang_cal_admin_data,$lang_general;
global $lang_settings_data, $theme_info;

$registry =& JFactory::getConfig();
foreach (get_object_vars($registry->toObject()) as $k => $v)
{
  $varname = 'mosConfig_'.$k;
  $$varname = $v;
}



$my = & JFactory::getUser();
$db = & JFactory::getDBO();

define('USER_IS_ADMIN',((($my->usertype == 'Administrator') || $my->usertype == 'Super Administrator')) ? true : false);
define('SETTINGS_PHP', true);
define('ADMIN_CATS_PHP', true);
define('ADMIN_CALS_PHP', true);
define('IN_MAMBO_ADMIN_SECTION', true);
// number of years ot show in year select list
define('JCL_NUMBER_YEARS_TO_SHOW_BEFORE', 5);
define('JCL_NUMBER_YEARS_TO_SHOW_AFTER', 20);

// Set initial debug level
$DB_DEBUG = true;

// define application constants
define('CONFIG_FILE_INCLUDED', true);

define('CALENDAR_NAME', 'JCal Pro');
define('CALENDAR_VERSION', '2.2.17.1587');
define('TEMPLATE_FILE', 'template.html');
define('TEMPLATE_JS_FILE', 'template.js');

// default values, JCal Pro 2
define('JCL_DEFAULT_OWNER_ID', 62);
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

$temp_path = realpath(isset($_SERVER['PATH_TRANSLATED'])?$_SERVER['PATH_TRANSLATED']:$_SERVER['SCRIPT_FILENAME']) . DS;

// Initialise the $CONFIG_EXT array and some other variables
$CONFIG_EXT = array();

// DB TABLE NAMES PREFIX
$CONFIG_EXT['TABLE_PREFIX'] =  "#__jcalpro2_";

// FS configuration
$CONFIG_EXT['FS_PATH'] = JPATH_SITE . "/components/com_jcalpro/";        // Your file system path
$CONFIG_EXT['ADMIN_PATH'] = JPATH_COMPONENT_ADMINISTRATOR;        // Your admin file system path
$CONFIG_EXT['calendar_url'] = JURI::base() . 'components/com_jcalpro/';        // Your calendar web url
$CONFIG_EXT['calendar_calling_page'] = JURI::base() . "/index.php?option=" . JRequest::getVar( 'option', 'com_jcalpro');  // Your calendar web url

require_once $CONFIG_EXT['FS_PATH']."include/functions.inc.php";
require_once $CONFIG_EXT['FS_PATH'].'jcalpro.class.php';

$ME = $CONFIG_EXT['calendar_calling_page'];
$REFERER = get_referer();

// File system paths
$CONFIG_EXT['UPLOAD_DIR'] = $CONFIG_EXT['FS_PATH']."upload/";
$CONFIG_EXT['UPLOAD_DIR_URL'] = $CONFIG_EXT['calendar_url']."upload/";
$CONFIG_EXT['MINI_PICS_DIR'] = $CONFIG_EXT['FS_PATH']."images/minipics/";
$CONFIG_EXT['MINI_PICS_URL'] = $CONFIG_EXT['calendar_url']."images/minipics/";
$CONFIG_EXT['LIB_DIR'] = $CONFIG_EXT['FS_PATH']."lib/";
$CONFIG_EXT['PLUGINS_DIR'] = $CONFIG_EXT['FS_PATH']."plugins/";
$CONFIG_EXT['LANGUAGES_DIR'] = $CONFIG_EXT['FS_PATH']."languages/";
$CONFIG_EXT['THEMES_DIR'] = $CONFIG_EXT['FS_PATH']."themes/";

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
  foreach ( $rows as $row) {
    $CONFIG_EXT[$row['name']] = $row['value'];
  }
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
$CONFIG_EXT['app_name'] = $CONFIG_EXT['calendar_name'];
// get current version info
if(!isset($CONFIG_EXT['release_version'])) {
  $CONFIG_EXT['release_name'] = '1.0 dev';
  $CONFIG_EXT['release_version'] = "1.0";
  $CONFIG_EXT['release_type'] = 'dev';
}

// Set error logging level
if ($CONFIG_EXT['debug_mode']) {
  error_reporting (E_ALL);
  $DB_DEBUG = true;
} else {
  error_reporting (E_ALL ^ E_NOTICE);
  $DB_DEBUG = false;
}

$db->setQuery( "SELECT name FROM #__jcalpro2_themes WHERE published= '1'" );
$themeName = $db->loadResult();

// Check for template name passed as URL param
$jcal_change_theme = JRequest::getString('jcal_change_theme', 'default');
if( !empty($jcal_change_theme) ) $themeName = $jcal_change_theme;

$CONFIG_EXT['theme'] = $themeName;

if ( !file_exists($CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php" ) )
{
  $CONFIG_EXT['theme'] = 'default';
}

require_once $CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php";
$THEME_DIR = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}";

$legacy_lang = &JFactory::getLanguage();
$CONFIG_EXT['lang'] = $legacy_lang->getBackwardLang();

if (!file_exists($CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php")) $CONFIG_EXT['lang'] = 'english';
require_once $CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php";

// Localizing time
while(list(,$temp_lang_code) = each($lang_info['locale']) ) {
  setlocale (LC_TIME,$temp_lang_code);
}

// load main template
jcload_template();

// Localizing time : we get timestamp
$zone_stamp = extcal_get_local_time();  // time stamp of 'now', including timezone offset as per Joomla global setting

// Initialize time variables with today's date (in user time)
$m = (int) jcServerDateToFormat( $zone_stamp, '%m');
$y = (int) jcServerDateToFormat( $zone_stamp, '%Y');
$d = (int) jcServerDateToFormat( $zone_stamp, '%d');

$today = array(
	'day' => $d,
	'month' => $m,
	'year' => $y
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

    $childs[$childsKey]->text =	JString::strtolower ( $childs[$childsKey]->text );
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

$lang_config_data = array(
$lang_settings_data['general_settings_label'],
array($lang_settings_data['calendar_admin_email'], 'calendar_admin_email', 0),
array($lang_settings_data['cookie_name'], 'cookie_name', 0),
array($lang_settings_data['cookie_path'], 'cookie_path', 0),
array($lang_settings_data['debug_mode'], 'debug_mode', 1),
array('Default Target for URLS in Events', 'url_target_for_events', 0),
array('Capitalize Event Titles', 'capitalize_event_titles', 1),
array('Show Only Start Times', 'show_only_start_times', 1),
array('Show Top Navigation Bar', 'show_top_navigation_bar', 1),
array($lang_settings_data['search_view'], 'search_view', 1),
array('Enable ajax features', 'enable_ajax_features', 1),
array('Enable rss feeds', 'enable_feeds', 1),
array('Only show new events in rss feeds', 'only_new_feeds', 1),
//array('Enable Moovur/Mollom anti-spam check', 'enable_moovur', 1),
array('Enable reCaptcha anti-spam check', 'enable_recaptcha', 1),
array('User level required to bypass captcha (when enabled)', 'who_can_bypass_captcha', 15),
array('Enable iCal export', 'enable_ical_export', 1),
array('Who Can Submit New Events<br /><small>(as long as "'.$lang_settings_data['add_event_view_label'].'" is on the Add Event tab)</small>', 'who_can_add_events', 15),
array('Who Can Submit Event Edits', 'who_can_edit_events', 15),
array('Who Can Delete Events', 'who_can_delete_events', 15),
array('Who Can Approve Events', 'who_can_approve_events', 15),
array('Disable JCalPro Footer', 'disable_footer', 1),
array($lang_settings_data['new_post_notification'].'<br /><small>(Sends an email to the email address above whenever a new or edited event needs approval. Note: ONLY sends an email if approval is required.)</small>', 'new_post_notification', 1),

$lang_settings_data['env_settings_label'],
//	array($lang_settings_data['lang'], 'lang', 5),
//	array($lang_settings_data['charset'], 'charset', 4),
array($lang_settings_data['theme'], 'theme', 6),
array($lang_settings_data['timezone'], 'site_timezone', 7),
array($lang_settings_data['time_format'], 'time_format_24hours', 11),
//array($lang_settings_data['auto_daylight_saving'], 'auto_daylight_saving', 1),
array($lang_settings_data['main_table_width'], 'main_table_width', 0),
array($lang_settings_data['day_start'], 'day_start', 9),
array($lang_settings_data['default_view'], 'default_view', 8),
array($lang_settings_data['archive'], 'archive', 1),
//	array($lang_settings_data['events_per_page'], 'events_per_page', 0),
//	array($lang_settings_data['sort_order'], 'sort_order', 3),
array($lang_settings_data['show_recurrent_events'], 'show_recurrent_events', 16),
array('Delete parent also deletes detached recurrent events', 'update_detached_with_series', 1),
array($lang_settings_data['multi_day_events'], 'multi_day_events', 13),
array('Show iCal export icon in menu bar', 'show_ical_export_menu_icon', 1),
array('Show print icon in menu bar', 'show_print_menu_icon', 1),


$lang_settings_data['integration_view_label'],
array($lang_settings_data['integration_illbethere'], '', 2),
array($lang_settings_data['integration_enable'], 'show_illbethere', 1),
array($lang_settings_data['integration_color'], 'color_illbethere', 23),
array($lang_settings_data['integration_cats'], 'cat_list_illbethere', 21),
array($lang_settings_data['integration_exclude'], 'cat_list_illbethere_exclude', 1),
array($lang_settings_data['integration_itemid'], 'itemid_illbethere', 0),

array(null, null, 99),

array($lang_settings_data['integration_community'], '', 2),
array($lang_settings_data['integration_enable'], 'show_community', 1),
array($lang_settings_data['integration_color'], 'color_community', 23),
array($lang_settings_data['integration_cats'], 'cat_list_community', 22),
array($lang_settings_data['integration_exclude'], 'cat_list_community_exclude', 1),
array($lang_settings_data['integration_showsubs'], 'cat_subs_community', 1),
array($lang_settings_data['integration_itemid'], 'itemid_community', 0),

//	$lang_settings_data['user_settings_label'],
//	array($lang_settings_data['allow_user_registration'], 'allow_user_registration', 1),
//	array($lang_settings_data['reg_duplicate_emails'], 'reg_duplicate_emails', 1),
//	array($lang_settings_data['reg_email_verify'], 'reg_email_verify', 1),

$lang_settings_data['event_view_label'],
array($lang_settings_data['popup_event_mode'], 'popup_event_mode', 1),
array('Show Recurrence Info', 'show_recurrence_info_event_view', 1),
//array($lang_settings_data['popup_event_width'], 'popup_event_width', 0),
//array($lang_settings_data['popup_event_height'], 'popup_event_height', 0),

$lang_settings_data['add_event_view_label'],
array($lang_settings_data['add_event_view'].'<br /><small>(Note that if this is disabled, it overrides "Who Can Submit New Events" above. Administrators will still be able to add events, however.)</small>', 'add_event_view', 1),
array('Allow Javascript in URLS in Event Descriptions', 'allow_javascript_in_event_urls', 1),
array($lang_settings_data['addevent_allow_html'], 'addevent_allow_html', 1),
array($lang_settings_data['addevent_allow_contact'], 'addevent_allow_contact', 1),
array($lang_settings_data['addevent_allow_email'], 'addevent_allow_email', 1),
array($lang_settings_data['addevent_allow_url'], 'addevent_allow_url', 1),

$lang_settings_data['calendar_view_label'],
array($lang_settings_data['monthly_view'], 'monthly_view', 1),
array('Show Event Times', 'show_event_times_in_monthly_view', 1),
array($lang_settings_data['cal_view_show_week'], 'cal_view_show_week', 1),
array($lang_settings_data['cal_view_max_chars'], 'cal_view_max_chars', 0),
array('Show Overlapping Recurrences<br /><small>(only relevant if an event\'s duration is longer than its interval--for example, an event that lasts 3 days but recurs every 2 days.)', 'show_overlapping_recurrences_monthlyview', 1),

$lang_settings_data['flyer_view_label'],
array($lang_settings_data['flyer_view'], 'flyer_view', 1),
array('Show Event Times', 'show_event_times_in_flat_view', 1),
//array($lang_settings_data['flyer_show_picture'], 'flyer_show_picture', 1),
array($lang_settings_data['flyer_view_max_chars'], 'flyer_view_max_chars', 0),
array('Show Overlapping Recurrences<br /><small>(only relevant if an event\'s duration is longer than its interval--for example, an event that lasts 3 days but recurs every 2 days.)', 'show_overlapping_recurrences_flatview', 1),

$lang_settings_data['weekly_view_label'],
array($lang_settings_data['weekly_view'], 'weekly_view', 1),
array('Show Event Times', 'show_event_times_in_weekly_view', 1),
array($lang_settings_data['weekly_view_max_chars'], 'weekly_view_max_chars', 0),
array('Show Overlapping Recurrences<br /><small>(only relevant if an event\'s duration is longer than its interval--for example, an event that lasts 3 days but recurs every 2 days.)', 'show_overlapping_recurrences_weeklyview', 1),

$lang_settings_data['daily_view_label'],
array($lang_settings_data['daily_view'], 'daily_view', 1),
array('Show Event Times', 'show_event_times_in_daily_view', 1),
array($lang_settings_data['daily_view_max_chars'], 'daily_view_max_chars', 0),
array('Show Overlapping Recurrences<br /><small>(only relevant if an event\'s duration is longer than its interval--for example, an event that lasts 3 days but recurs every 2 days.)', 'show_overlapping_recurrences_dailyview', 1),

$lang_settings_data['categories_view_label'],
array($lang_settings_data['cats_view'], 'cats_view', 1),
array('Show Event Times', 'show_event_times_in_cat_view', 1),
array('Show Recurrence Info', 'show_recurrence_info_category_view', 1),
//array($lang_settings_data['sort_order'], 'sort_category_view_by', 3),
array($lang_settings_data['cats_view_max_chars'], 'cats_view_max_chars', 0),
array('Hide empty categories', 'hide_empty_cats', 1),

$lang_settings_data['metadata_label'],
array($lang_settings_data['metadata_global_keywords'], 'metadata_global_keywords', 24),
array($lang_settings_data['metadata_global_description'], 'metadata_global_description', 24),
array($lang_settings_data['metadata_ignore_keywords'], 'metadata_ignore_keywords', 24),

);
//==========================================
// LIFTED FROM config.inc.php   END
//==========================================