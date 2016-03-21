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
 * $Id: minical.inc.php 703 2011-02-15 21:02:20Z jeffchannell $
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

/**
 * Build the complete minical output and returns it
 *
 * @param unknown_type $params the module parameters
 * @return string the module output
 */
if (!function_exists( 'jclMinical')) {

	function jclMinical( $params, $moduleId, $profiledUserId = 0) {

		$db = &JFactory::getDBO();
		$user	=& JFactory::getUser();
		if ( !defined('USER_IS_ADMIN') ) define('USER_IS_ADMIN',((($user->usertype == 'Administrator') || ($user->usertype == 'Super Administrator')) ? true : false));
		if ( !defined('USER_IS_LOGGED_IN') ) define('USER_IS_LOGGED_IN',!($user->usertype == ''));

		global $CONFIG_EXT, $zone_stamp, $today, $template_mini_cal_view, $ME, $THEME_DIR, $lang_mini_cal, $lang_system, $info_data, $picture, $lang_info;
		global $lang_general, $lang_date_format, $event_icons, $todayclr, $cat_id, $cal_id, $cat_list, $cat_list_illbethere, $cat_list_community, $cal_list, $cats_limit, $extcal_code_insert, $Itemid, $private_events_mode;
		$jconfig = &JFactory::getConfig();

		$mosConfig_locale = $jconfig->getValue('config.language');
		$legacy_lang = &JFactory::getLanguage();
		$mosConfig_lang = $legacy_lang->getBackwardLang();
		$mosConfig_live_site = JURI::root();
		$info_data = array();

		$db = &JFactory::getDBO();

		$option = "com_jcalpro";
		require_once( JPATH_ROOT . DS . "components" . DS . "com_jcalpro" . DS . "config.inc.php" );
		require_once( JPATH_ROOT . DS . "components" . DS . "com_jcalpro" . DS . "include" . DS . "functions.inc.php" );

		// use specific Itemid if requested
		$defaultItemid = jclGetItemid( 'com_jcalpro', $published = true);
		// but default to default menu item going to jcalpro 
		$jcal_itemid = intval($params->get('specific_itemid_mini', $defaultItemid));
		// last solution : current page Itemid
		$jcal_itemid = $jcal_itemid ? $jcal_itemid : $Itemid;
		// build base url with this Itemid
		$CONFIG_EXT['calendar_calling_page'] = "index.php?option=com_jcalpro&amp;Itemid=" . $jcal_itemid;
		
		/* end of block new in 1.5.0.2 */

		// Set the path and name and querystring of the current page, to make "$ME",
		// which the minicalendar uses to create its hyperlinks for clicking on events
		// and on the Next/Last month navigational arrows. Remove the "date" querystring
		// variable, however; we'll usually be replacing it.
		//$pathArray = explode('/', $_SERVER['PHP_SELF']);
		//array_shift( $pathArray );
		$pathArray = 'index.php';
		$query_string = array();
		$ajax_query_string = array();
		// force option to jcalpro
		$ajax_query_string[] = 'option=com_jcalpro';
		$ajax_query_string[] = 'minical_id=' . $moduleId;
		$ajax_query_string[] = 'extmode=minical';
		$ajax_query_string[] = 'Itemid=' . $Itemid;

		foreach($_GET as $key => $value) {
			$param = JRequest::getVar( $key);
			//if ($key != 'date') $query_string[] = $key.'='.$param;
			if (!in_array($key, array('date', 'cat_id'))) $query_string[] = $key.'='.$param;
			if ($key == 'lang') $ajax_query_string[] = $key.'='.$param;
		}

		if (sizeof($query_string) > 0) {
			$query_string = '?'.implode('&',$query_string).'&';
			$ajax_query_string = '?'.implode('&',$ajax_query_string).'&';
		} else {
			$query_string = '?';
		}

		$ME = htmlentities($pathArray.$query_string);
		$ME_ajax = htmlentities($pathArray.$ajax_query_string);
		$CONFIG_EXT['LANGUAGES_DIR'] = $CONFIG_EXT['FS_PATH']."languages/";
		$CONFIG_EXT['MINI_PICS_DIR'] = $CONFIG_EXT['FS_PATH']."images/minipics/";
		$CONFIG_EXT['MINI_PICS_URL'] = $CONFIG_EXT['calendar_url']."images/minipics/";

		// Set error logging level
		if ($CONFIG_EXT['debug_mode']) {
			error_reporting (E_ALL);
			$DB_DEBUG = true;
		} else {
			error_reporting (E_ALL ^ E_NOTICE);
			$DB_DEBUG = false;
		}
		/*
		@comment_do_not_remove@
		*/
		if( !function_exists('minical_theme_mini_cal_view') )
		{
			function minical_theme_mini_cal_view($date, &$results, &$info_data)
			{
				global $template_mini_cal_view, $THEME_DIR, $ME, $lang_mini_cal, $cat_id, $cats_limit;
				global $CONFIG_EXT, $today, $lang_date_format, $lang_general, $event_icons, $extcal_code_insert;
				global $todayclr, $weekdayclr, $sundayclr;
				global $sundayclrHl, $weekdayclrHl, $todayclrHl;
				global $mainframe;

				$template_mini_cal_view1 = $template_mini_cal_view;
				// replace global variables
				$template_mini_cal_view1 = str_replace('{THEME_DIR}', $THEME_DIR,$template_mini_cal_view1);
				$template_mini_cal_view1 = str_replace('{TARGET}', $info_data['target'],$template_mini_cal_view1);


				$header_row = minical_template_extract_block($template_mini_cal_view1, 'header_row');
				$navigation_row = minical_template_extract_block($template_mini_cal_view1, 'navigation_row');
				$picture_row = minical_template_extract_block($template_mini_cal_view1, 'picture_row');
				$footer_row = minical_template_extract_block($template_mini_cal_view1, 'footer_row');

				$weekday_header_row = minical_template_extract_block($template_mini_cal_view1, 'weekday_header_row');
				$weekday_cell_row = minical_template_extract_block($template_mini_cal_view1, 'weekday_cell_row');
				$weekday_footer_row = minical_template_extract_block($template_mini_cal_view1, 'weekday_footer_row');

				$day_cell_header_row = minical_template_extract_block($template_mini_cal_view1, 'day_cell_header_row');
				$weeknumber_cell_row = minical_template_extract_block($template_mini_cal_view1, 'weeknumber_cell_row');
				$day_cell_row_original = minical_template_extract_block($template_mini_cal_view1, 'day_cell_row');
				$other_month_cell_row = minical_template_extract_block($template_mini_cal_view1, 'other_month_cell_row');
				$day_cell_footer_row = minical_template_extract_block($template_mini_cal_view1, 'day_cell_footer_row');
				$inline_style_row = minical_template_extract_block($template_mini_cal_view1, 'inline_style_row');

				//  make the days of week, consisting of seven days
				$firstday = date ("w", mktime(0,0,0,$date['month'],1,$date['year']));
				if ($CONFIG_EXT['day_start']) $firstday-=1;
				$firstday = ($firstday < 0)? $firstday + 7: $firstday%7;

				// number of days in asked month
				$nr = date("t",mktime(0,0,0,$date['month'],1,$date['year']));

				$today_date = extcal_get_local_time();
				$today_date = jcTSToFormat( $today_date, $lang_date_format['full_date']);

				$displayParams = array(
						'{MINICAL_ID}' => $info_data['minical_id']
				);
				// each instance of the module should have a unique id (needed for ajax at least)
				echo minical_template_eval( $header_row, $displayParams);

				$displayParams = array(
			'{PREVIOUS_MONTH}' => ucwords( strftime($lang_date_format['month_year'], mktime(0,0,0,$date['month']-1,1,$date['year']))),
			'{PREVIOUS_MONTH_URL}' => $info_data['previous_month_url'],
			'{CURRENT_MONTH}' => ucwords( strftime($lang_date_format['month_year'], mktime(0,0,0,$date['month'],1,$date['year']))),
			'{NEXT_MONTH}' => ucwords( strftime($lang_date_format['month_year'], mktime(0,0,0,$date['month']+1,1,$date['year']))),
			'{NEXT_MONTH_URL}' => $info_data['next_month_url'],
			'{MINICAL_ID}' => $info_data['minical_id'],
			'{URL_MAP_JAVASCRIPT}' => $info_data['url_map_javascript'] 

				);
				if(!$CONFIG_EXT['cal_view_show_week']) minical_template_extract_block($weekday_header_row, 'weeknumber_header_row');
				if(!$info_data['show_past_months']) minical_template_extract_block($navigation_row, 'previous_month_link_row');
				else minical_template_extract_block($navigation_row, 'no_previous_month_link_row');
				if($info_data['navigation_controls']) minical_template_extract_block($navigation_row, 'without_navigation_row');
				else minical_template_extract_block($navigation_row, 'with_navigation_row');
				echo minical_template_eval($navigation_row, $displayParams);

				if(isset($info_data['picture_info'])) {
					$displayParams = array(
				'{PICTURE_URL}' => $CONFIG_EXT['MINI_PICS_URL'].$info_data['picture_info']['picture_url'],
				'{PICTURE_MESSAGE}' => $info_data['picture_info']['picture_message'],
				'{STATUS_MESSAGE}' => ucwords( strftime($lang_date_format['month_year'], mktime(0,0,0,$date['month'],1,$date['year']))),
				'{MINI_PICTURE_LINK}' => $CONFIG_EXT['calendar_calling_page']
					);
					
					echo minical_template_eval($picture_row, $displayParams);
				}

				//echo $weekdays_row;

				// print weekday labels
				echo $weekday_header_row;
				for ($i=0;$i<count($info_data['weekdays']);$i++)
				{
					$displayParams = array(
				'{WEEK_DAY}' => $info_data['weekdays'][$i]['name'],
				'{CSS_CLASS}' => $info_data['weekdays'][$i]['class']
					);
					echo minical_template_eval($weekday_cell_row, $displayParams);
				}
				echo $weekday_footer_row;

				
				// print day cells
				for ($i=1-$firstday;$i<=count($results);$i+=7)
				{
					echo $day_cell_header_row;
					if($CONFIG_EXT['cal_view_show_week']) {
						$weeknumber_cell_row1 = $weeknumber_cell_row;
						$weeknumber = $results[$i<1?1:$i]['week_number'];
						$week_stamp = mktime(0,0,0,$date['month'],$i + 6,$date['year']);
						$url_week_date = date("Y-m-d", $week_stamp);
						$displayParams = array(
					'{URL_WEEK_VIEW}' => JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=week&amp;date=".$url_week_date ),
					'{WEEK_NUMBER}' => sprintf($lang_mini_cal['selected_week'],$weeknumber)
						);
						echo minical_template_eval( $weeknumber_cell_row1, $displayParams);
					}
					for ($row=0;$row<7;$row++)
					{
						$day_stamp = mktime(0,0,0,$date['month'],$i + $row,$date['year']);
						if($i+$row<1 || $i+$row> $nr) {
							$date_string = "";
							echo str_replace('{CELL_CONTENT}', $date_string,$other_month_cell_row);
						} else {
							$url_target_date = $results[($i + $row)]['date_link'];
							$events = $results[($i + $row)]['num_events'];
							$num_events =  $info_data['day_link']?(int)$events:0;
							$date_string = ucwords( strftime($lang_date_format['day_month_year'], $day_stamp));
							if ($day_stamp == mktime(0,0,0,$today['month'],$today['day'],$today['year'])) {
								// higlight today's day
								$css_class = "extcal_todaycell";
								$link_class = $num_events?"extcal_busylink":"extcal_daylink";
								$hlColor = $todayclrHl;
								$regColor = $todayclr;
							} elseif (!(int)date('w', $day_stamp)) {
								// use sunday colors
								$css_class = "extcal_sundaycell";
								$link_class = $num_events?"extcal_busylink":"extcal_sundaylink";
								$hlColor = $sundayclrHl;
								$regColor = $sundayclr;
							} else  {
								// use regular day colors
								$css_class = "extcal_daycell";
								$link_class = $num_events?"extcal_busylink":"extcal_daylink";
								$hlColor = $weekdayclrHl;
								$regColor = $weekdayclr;
							}


							$displayParams = array(
								'{DAY}' => $i + $row,
								'{URL_TARGET_DATE}' => $url_target_date,
								'{DAY_CLASS}' => $css_class,
								'{NOFOLLOW}' => $results[$i+$row]['nofollow'] ? 'rel="nofollow"' : '',
								'{DAY_LINK_CLASS}' => $link_class,
								'{CELL_CONTENT}' => sprintf($lang_mini_cal['num_events'],$num_events) . ' : ' .htmlspecialchars(empty( $results[$i + $row]['summary']) ? '' : $results[$i + $row]['summary']),
								'{BG_COLOR}' => $regColor,
								'{HOVER_BG_COLOR}' => $hlColor,
								'{DATE_STRING}' => $date_string,
								'{DAY_DESCRIPTION}' => htmlspecialchars(empty( $results[$i + $row]['summary']) ? '' : $results[$i + $row]['summary'])
							);

							// restore original sub-template
							$day_cell_row = $day_cell_row_original;
							//decide whether to use a static display or a link to date url
							// @TODO: add params to decide whether to display day links
							if( !$num_events )  {
								$displayParams['{CELL_CONTENT}'] = '';
								minical_template_extract_block($day_cell_row, 'linkable_row');
							} else {
								minical_template_extract_block($day_cell_row, 'static_row');
							}
							echo minical_template_eval($day_cell_row, $displayParams);
						}
					}
					echo $day_cell_footer_row;
				}
				if(!$CONFIG_EXT['add_event_view'] || !has_priv('add') || !$CONFIG_EXT['show_minical_add_event_button']) minical_template_extract_block($footer_row, 'add_event_row');
				$displayParams = array(
			'{ADD_EVENT_URL}' => JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=event&amp;event_mode=add" ),
			'{ADD_EVENT_TITLE}' => $lang_mini_cal['post_event']
				);
				echo minical_template_eval($footer_row, $displayParams);
				if(!$extcal_code_insert) {
					//$extcal_code_insert = 1;
					echo $inline_style_row;
				}
			}
		}

		##-------------------functions used:

		if( !function_exists('minical_extcal_get_picture_file') )
		{
			function minical_extcal_get_picture_file($file) {
				global $CONFIG_EXT;
				if($file) {
					if(file_exists($CONFIG_EXT['MINI_PICS_DIR'].$file.".jpg")) $file = $file.".jpg";
					elseif(file_exists($CONFIG_EXT['MINI_PICS_DIR'].$file.".gif")) $file = $file.".jpg";
					else $file = $CONFIG_EXT['mini_cal_def_picture'];
				} else $file = $CONFIG_EXT['mini_cal_def_picture'];
				return $file;
			}
		}

		if( !function_exists('minical_extcal_dir_list') )
		{
			function minical_extcal_dir_list($dirname)
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
		}

		if( !function_exists('minical_template_extract_block') )
		{
			function minical_template_extract_block(&$template, $block_name, $subst='')
			{
				if(!$template) return;
				$pattern = "#(<!-- BEGIN $block_name -->)(.*?)(<!-- END $block_name -->)#s";
				if ( !preg_match($pattern, $template, $matches)){
					die ('<b>Template error<b><br />Failed to find block \''.$block_name.'\' in :<br /><pre>'.htmlspecialchars($template).'</pre>');
				}
				$template = str_replace($matches[1].$matches[2].$matches[3], $subst, $template);
				return $matches[2];
			}
		}

		// Eval a template (substitute vars with values)
		if( !function_exists('minical_template_eval') )
		{
			function minical_template_eval(&$template, &$vars)
			{
				return strtr($template, $vars);
			}
		}

		if( !function_exists('minical_sub_string') )
		{
			function minical_sub_string($string,$max,$suffix) {
				// returns a substring that may be encoded in utf-8 or other character encodings.
				// and adds a suffix in case the substring is smaller than the original string
				global $CONFIG_EXT;
				if(preg_match('/(.{1,'.$max.'})/u', $string, $matches)) $new_string = $matches[0];
				else $new_string = $string; // this state occurs if the string contains chars with mixed encodings
				$new_string = strlen($new_string)==strlen($string)?$new_string:$new_string.$suffix;
				return $new_string;
			}
		}

		// Get the week number in ISO 8601:1988 format
		if( !function_exists('minical_get_week_number') )
		{
			function minical_get_week_number($day, $month, $year) {
				global $CONFIG_EXT;
				if($CONFIG_EXT['day_start']) $week = strftime("%W", mktime(0, 0, 0, $month, $day, $year));
				else $week = strftime("%U", mktime(0, 0, 0, $month, $day, $year));
				$yearBeginWeekDay = strftime("%w", mktime(0, 0, 0, 1, 1, $year));
				$yearEndWeekDay  = strftime("%w", mktime(0, 0, 0, 12, 31, $year));
				// make the checks for the year beginning
				if($yearBeginWeekDay > 0 && $yearBeginWeekDay < 5) {
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
		}

		if (!file_exists($CONFIG_EXT['FS_PATH']."themes/{$CONFIG_EXT['theme']}/theme.php")) {
			$CONFIG_EXT['theme'] = 'default';
		}

		$THEME_DIR = $CONFIG_EXT['calendar_url']."themes/{$CONFIG_EXT['theme']}";

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

		$day = $date['day'];
		$month = $date['month'];
		$year = $date['year'];

		// If this module is configured to display previous month or next month,
		// adjust the month and year variables
		$month_offset = intval($params->def('month_to_display',0));
		$month += $month_offset;
		if( $month == 0 ) { $month = 12; --$year; }
		if( $month > 12 ) { $month = 1; ++$year; }

		#------------------------END necessary stuff from config.inc.php

		##-------------------Gather parameters from the module administration section:

		$info_data['navigation_controls'] = intval($params->def('navigation_controls',1));
		$CONFIG_EXT['show_minical_add_event_button'] = intval($params->def('show_minical_add_event_button',1));
		$target = JString::trim($params->get('target'));
		if( $target == "" ) { $target = "_self"; }
		$info_data['target'] = $target;
		$CONFIG_EXT['mini_cal_def_picture'] = htmlspecialchars(JString::trim($params->def('mini_cal_def_picture','def_pic.gif')));
		$picture = intval($params->def('picture','0'));

		##-------------------HTML template:

		// HTML template to display a monthly calendar view
		$template_mini_cal_view = <<<EOT
<!-- BEGIN inline_style_row -->
<!--
	@import url('{THEME_DIR}/style.css');
-->

<script type="text/javascript">
	function extcal_showOnBar(Str)
	{
		window.status=Str;
		return true;
	}
</script>
<!-- END inline_style_row -->
<!-- BEGIN header_row -->
<div class="extcal_minical" id="extcal_minical{MINICAL_ID}">
	<table class="extcal_minical" align="center" border="0" cellspacing="1" cellpadding="0" width="100%">
		<tr>
			<td>
<!-- END header_row -->
<!-- BEGIN navigation_row -->
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="extcal_navbar">
				<tr>
<!-- BEGIN with_navigation_row -->
<!-- BEGIN no_previous_month_link_row -->
					<td align="center" height="18" valign="middle"><img src="{THEME_DIR}/images/mini_arrowleft_inactive.gif" border="0" alt="" title="" /></td>
					{URL_MAP_JAVASCRIPT}
<!-- END no_previous_month_link_row -->
<!-- BEGIN previous_month_link_row -->
					<td align="center" height="18" valign="middle"
						onmouseover="extcal_showOnBar('{PREVIOUS_MONTH}');return true;" 
						onmouseout="extcal_showOnBar('');return true;">
						{URL_MAP_JAVASCRIPT}
						<a href="{PREVIOUS_MONTH_URL}" rel="shajaxLinkPrevMonthMinical{MINICAL_ID} extcal_minical{MINICAL_ID} prefetch" >
							<span id='shajaxProgressPrevMonthMinical{MINICAL_ID}'>
								<img src="{THEME_DIR}/images/mini_arrowleft.gif" border="0" alt="{PREVIOUS_MONTH}" title="{PREVIOUS_MONTH}" />
							</span>
						</a>
					</td>
<!-- END previous_month_link_row -->
					<td align="center" height="18" valign="middle" width="98%" class='extcal_month_label' nowrap="nowrap">{CURRENT_MONTH}</td>
					<td align="center" height="18" valign="middle"
						onmouseover="extcal_showOnBar('{NEXT_MONTH}');return true;" 
						onmouseout="extcal_showOnBar('');return true;">
						<a href="{NEXT_MONTH_URL}" rel="shajaxLinkNextMonthMinical{MINICAL_ID} extcal_minical{MINICAL_ID} prefetch">
							<span id='shajaxProgressNextMonthMinical{MINICAL_ID}'>
								<img src="{THEME_DIR}/images/mini_arrowright.gif" border="0" alt="{NEXT_MONTH}" title="{NEXT_MONTH}" />
							</span>	
						</a>
					</td>
<!-- END with_navigation_row -->
<!-- BEGIN without_navigation_row -->
					<td colspan="3" align="center" height="18" valign="middle" width="98%" class='extcal_month_label' nowrap="nowrap">{CURRENT_MONTH}</td>
<!-- END without_navigation_row -->
				</tr>
			</table>
<!-- END navigation_row -->

<!-- BEGIN picture_row -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="extcal_picture">
						<a href='{MINI_PICTURE_LINK}' 
							onmouseover="extcal_showOnBar('{STATUS_MESSAGE}');return true;" 
							onmouseout="extcal_showOnBar('');return true;">
					<img src='{PICTURE_URL}' width='100%' alt='{PICTURE_MESSAGE}' border='0' /></a></td>
				</tr>
			</table>
<!-- END picture_row -->

<!-- BEGIN weekday_header_row -->
	<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%"  class="extcal_weekdays">
		<tr>
<!-- BEGIN weeknumber_header_row -->
			<!-- <td></td> -->
<!-- END weeknumber_header_row -->
<!-- END weekday_header_row -->
<!-- BEGIN weekday_cell_row -->
			<td height='24' class="{CSS_CLASS}" valign="top" align="center">
				{WEEK_DAY}
			</td>
<!-- END weekday_cell_row -->
<!-- BEGIN weekday_footer_row -->
		</tr>
<!-- END weekday_footer_row -->

<!-- BEGIN day_cell_info_row -->
<!-- BEGIN day_cell_header_row -->
		<tr>
<!-- END day_cell_header_row -->
<!-- BEGIN weeknumber_cell_row -->
		<!-- <td class='extcal_weekcell' align='center'
				onmouseover="extcal_showOnBar('{WEEK_NUMBER}');return true;" 
				onmouseout="extcal_showOnBar('');return true;">
			<a href="{URL_WEEK_VIEW}" target="{TARGET}"><img src="{THEME_DIR}/images/icon-mini-week.gif" width="5" height="20" border="0" alt="{WEEK_NUMBER}" /></a>
			</td> -->
<!-- END weeknumber_cell_row -->
<!-- BEGIN other_month_cell_row -->
		<td height='15' class='extcal_othermonth' align='center' valign='middle'>{CELL_CONTENT}</td>
<!-- END other_month_cell_row -->
<!-- BEGIN day_cell_row -->
		<td height='15' class='{DAY_CLASS}' align='center' valign='top' onmouseover="extcal_showOnBar('{DATE_STRING}');return true;" onmouseout="extcal_showOnBar('');return true;">
<!-- BEGIN linkable_row -->
			<a href="{URL_TARGET_DATE}" title="{CELL_CONTENT}" {NOFOLLOW} class="{DAY_LINK_CLASS}" target="{TARGET}">{DAY}</a>
<!-- END linkable_row -->
<!-- BEGIN static_row -->
			<span title="{CELL_CONTENT}" class="{DAY_CLASS}">{DAY}</span>
<!-- END static_row -->
		</td>
<!-- END day_cell_row -->

<!-- BEGIN day_cell_footer_row -->
		</tr>
<!-- END day_cell_footer_row -->
<!-- END day_cell_info_row -->
<!-- BEGIN footer_row -->
			</table>
		</td>
	</tr>
</table>
<!-- BEGIN add_event_row -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="center" nowrap="nowrap" class="extcal_navbar">
			<a href="{ADD_EVENT_URL}"
				onmouseover="extcal_showOnBar('{ADD_EVENT_TITLE}');return true;" 
				onmouseout="extcal_showOnBar('');return true;" style="display:block;" class="extcal_tiny_add_event_link"><img src="{THEME_DIR}/images/addsign_a.gif" style="vertical-align: text-bottom" alt="{ADD_EVENT_TITLE}" border="0" vspace="2" /> {ADD_EVENT_TITLE}</a>
		</td>
	</tr>
</table>
<!-- END add_event_row -->
</div>
<!-- END footer_row -->
EOT;
		/*
		@comment_do_not_remove@
		*/
		ob_start();

		// check if "show past events" is enabled, else force the date to today's date
		if(mktime(0,0,0,$month,$day,$year) < mktime(0,0,0,$today['month'],1,$today['year']) && !$CONFIG_EXT['archive']) {
			$info_data['day_link'] = false;
		} else $info_data['day_link'] = true;

		// insert date into an array an pass it to the mini calendar theme function
		$target_date = array(
	'day' => $day,
	'month' => $month,
	'year' => $year
		);

		$pic_message = ucwords( strftime ($lang_date_format['full_date'], extcal_get_local_time()))."\n";

		switch($picture) {
			case '0': // Picture not displayed
			case 'none':
				$z = '';
				break;
			case '1': // Default Picture
				$z = $CONFIG_EXT['mini_cal_def_picture'];
				$pic_message .= $lang_mini_cal['def_pic'];
				break;
			case '2': // Daily Picture
			case 'daily':
				$z = (int)date("z",extcal_get_local_time()); // 0 through 366
				$pic_message .= sprintf($lang_mini_cal['daily_pic'],$z);
				$z = minical_extcal_get_picture_file($z);
				break;
			case '3': // Weekly Picture
			case 'weekly':
				//$z = (int)date("W",extcal_get_local_time()); // 0 through 53
				$z = (int) minical_get_week_number($today['day'], $today['month'], $today['year']); // 1 through 53
				$pic_message .= sprintf($lang_mini_cal['weekly_pic'],$z);
				$z = minical_extcal_get_picture_file($z);
				break;
			case '4': // Random Picture
			case 'random':
				$pictures = minical_extcal_dir_list($CONFIG_EXT['MINI_PICS_DIR']);
				srand((float)microtime() * 1000000);
				shuffle($pictures);
				$z = $pictures[0];
				$pic_message .= sprintf($lang_mini_cal['rand_pic'],$z);
				break;
			default: // Default Picture by default
				$z = $CONFIG_EXT['mini_cal_def_picture'];
				$pic_message .= $lang_mini_cal['def_pic'];
		}
		if(!empty($z)) $info_data['picture_info'] = array('picture_message' => $pic_message, 'picture_url' => $z);

		// number of days in selected month
		$nr = date("t",mktime(0,0,0,$month,1,$year));

		$previous_month_date = date("Y-m-d", mktime(0,0,0,$month-1-$month_offset,1,$year));
		$next_month_date = date("Y-m-d", mktime(0,0,0,$month+1-$month_offset,1,$year));

		$info_data['previous_month_url'] = JRoute::_( $ME."date=".$previous_month_date );
		$info_data['next_month_url'] = JRoute::_( $ME."date=".$next_month_date );

		// ajax special : we want the ajax function to call an url which is different from the non-ajax url
		// set the minical id, as there may be several instances of the same module
		$info_data['minical_id'] = $moduleId;
		if ($CONFIG_EXT['enable_ajax_features']) {
			$shajax = shajaxSupport::getInstance();
			$shajax->addUrlMapItem( 'shajaxLinkPrevMonthMinical'.$moduleId, JRoute::_( $ME_ajax."date=".$previous_month_date ));
			$shajax->addUrlMapItem( 'shajaxLinkNextMonthMinical'.$moduleId, JRoute::_( $ME_ajax."date=".$next_month_date ));
			$info_data['url_map_javascript'] =  $shajax->getUrlMapJavascript( 'extcal_minical' . $moduleId);
		}
		$info_data['current_month_url'] = JString::substr($ME,0,-1);

		$info_data['current_month_color'] = ($month == $today['month'] && $year == $today['year'])?"background-color: ".$todayclr:"";

		if ($CONFIG_EXT['archive'] || ($month != date("n") || $year != date("Y")))
		$info_data['show_past_months'] = true;
		else $info_data['show_past_months'] = false;

		// get the weekdays
		for ($i=0;$i<=6;$i++)
		{
			$array_index = $CONFIG_EXT['day_start']?($i+1)%7:$i;
			if ($array_index) $css_class = "extcal_weekdays"; // weekdays
			else $css_class = "extcal_weekdays"; // sunday
			$info_data['weekdays'][$i]['name'] = minical_sub_string($lang_date_format['day_of_week'][$array_index],2,'');
			$info_data['weekdays'][$i]['class'] = $css_class;
		}

		$event_stack = array();

		// get all events in one query
		$date_stamp = jcUserTimeToUTC( 0,0,0,$month,1,$year);
		$dateStampOfLastDay = jcUserTimeToUTC( 23,59,59,$month,$nr,$year);
		// save current global data, so as not to destroy those of the extension or other instances of the module
		$scat_list = $cat_list;
		$scat_list_illbethere = $cat_list_illbethere;
		$scat_list_community = $cat_list_community;
		$scal_list = $cal_list;
		$scat_id = $cat_id;
		$scal_id = $cal_id;
		// set this module values
		$cat_id = false;
		$cal_id = false;
		$cat_list = $params->get('categories_list', '');
		$cat_list_illbethere = $params->get('categories_illbethere', '');
		$cat_list_community = $params->get('categories_community', '');
		if (!strlen((string) $cat_list_illbethere)) {
			$cat_list_illbethere = -2;
		}
		if (!strlen((string) $cat_list_community)) {
			$cat_list_community = -2;
		}
		$cal_list = $params->get('calendars_list', '');
		// do the same for private_event_mode : we need to do better than that in the future :(

		$sprivate_events_mode = $private_events_mode;
		$private_events_mode = $params->get( 'private_events_mode', JCL_SHOW_ALL_EVENTS);
		$events = get_events( $date_stamp, $dateStampOfLastDay, $CONFIG_EXT['show_recurrent_events'],$CONFIG_EXT['show_overlapping_recurrences_monthlyview'], $last_updated = false, $profiledUserId);
		// restore global values
		$cat_list = $scat_list;
		$cat_list_illbethere = $scat_list_illbethere;
		$cat_list_community = $scat_list_community;
		$cal_list = $scal_list;
		$cat_id = $scat_id;
		$cal_id = $scal_id;
		$private_events_mode = $sprivate_events_mode;

		// 'existing' days in month
		for ($i=1;$i<=$nr;$i++)
		{
			$date_stamp = mktime(0,0,0,$month,$i,$year);
			// generate the url for each day cell
			$url_target_date = date("Y-m-d", $date_stamp);

			// count the number of events occurring in a given date
			$event_stack[$i]['num_events'] = empty($events[$i]) ? 0 : count($events[$i]);

			// only add a link to day if there are some events
			$event_stack[$i]['date_link'] = $event_stack[$i]['num_events'] ? JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=day&amp;date=".$url_target_date):'';
			// store a sumary description for hover display
			$event_stack[$i]['summary'] = '';
			if (!empty( $events[$i])) {
				$desc = '';
				foreach($events[$i] as $event) {
					$desc .= (empty( $desc) ? '' : ' | ') . format_text(sub_string($event[3]->title,$CONFIG_EXT['cal_view_max_chars'],'...'),false,$CONFIG_EXT['capitalize_event_titles']);
				}
				$event_stack[$i]['summary'] = $desc;
				$event_stack[$i]['nofollow'] = false;
			} else {
				$event_stack[$i]['nofollow'] = true;
			}
			//$event_stack[$i]['events'] = $events;
			$event_stack[$i]['week_number'] = (int) minical_get_week_number($i, $month, $year);

		}

		minical_theme_mini_cal_view($target_date, $event_stack, $info_data);

		$output = ob_get_contents(); // read buffer
		ob_end_clean();

		return $output;

	}
}