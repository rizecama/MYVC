<?php
/*
	**********************************************
	JCal Pro
	Copyright ( c ) 2006-2010 Anything-Digital.com
	**********************************************
	JCal Pro is a fork of the existing Extcalendar component for Joomla!
	( com_extcal_0_9_2_RC4.zip from mamboguru.com ).
	Extcal ( http://sourceforge.net/projects/extcal ) was renamed
	and adapted to become a Mambo/Joomla! component by
	Matthew Friedman, and further modified by David McKinnis
	( mamboguru.com ) to repair some security holes.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	( at your option ) any later version.

	This header must not be removed. Additional contributions/changes
	may be added to this header as long as no information is deleted.
	**********************************************

	$Id: jcalpro.php 714 2011-03-31 17:56:25Z jeffchannell $

	**********************************************
	Get the latest version of JCal Pro at:
	http://dev.anything-digital.com//
	**********************************************
	*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

require_once( JPATH_BASE."/components/com_jcalpro/config.inc.php" );

// If using pop-up event view, and request is for an event view
// disable main menu and search calendar blocks
$show_main_menu = TRUE;
$isAPopup = JRequest::getCmd( 'tmpl', '' ) == 'component';
$isShajax = JRequest::getCmd( 'shajax', false );
$isPrint = JRequest::getInt( 'print', 0 ) == 1;

if( ( $CONFIG_EXT['popup_event_mode'] &&  !$isShajax && $isAPopup ) || $isPrint ) {
	$show_main_menu = FALSE;
	$CONFIG_EXT['search_view'] = FALSE;
}

/*@comment_do_not_remove@*/
// starting to switch to MVC architecture
$format = JRequest::getCmd( 'format' );

// for now, feeds requests are handled separately
if ( $format == 'feed' ) {

	// Require the display feeds library
	require_once( JPATH_COMPONENT.DS.'include'.DS. 'feeds.inc.php' );

	// display the feeds
	$view = new JclFeeds();
	$view->display();

	// for now we need to return, as there is old code left behind
	return;
} 

// editing from front-end, editorinsert editor plugin
// uses MVC
$task = JRequest::getCmd( 'task' );
if ( $task == 'editorinsert' ) {
	// Require the base controller
	require_once ( JPATH_COMPONENT_ADMINISTRATOR.DS.'controller.php' );

	// Create the controller
	$controller = new JCalproController();

	// view is in backend, so say that to controller
	$controller->addViewPath( JPATH_COMPONENT_ADMINISTRATOR.DS.'views' );

	// Perform the Request task
	$controller->execute( $task );
	$controller->redirect();
	
	// don't go any further or we'll display the JCal pro default page
	return;
}

// another special case : insert event in editor, which uses MVC

switch( $extmode ) {
	case 'addevent' :
	case 'eventform' :
		if ( require_priv( 'add' ) ) {
		//jcPageHeader( $lang_main_menu['add_event'] );
		//print_add_event_form( $date );
		}
		break;

	case 'event' :
		include( $CONFIG_EXT['FS_PATH'].'admin_events.php' );
		break;

	case 'view' :
		jcPageHeader( $lang_event_view['section_title'] );
		if( !empty( $event_id ) ) print_event_view( $event_id );
		else print_monthly_view();
		break;

	case 'day':
		jcPageHeader( $lang_main_menu['daily_view'] );
		print_daily_view( $date );
		break;

	case 'week':
		jcPageHeader( $lang_main_menu['weekly_view'] );
		print_weekly_view( $date );
		break;

	case 'cats' :
		jcPageHeader( $lang_main_menu['categories_view'] );
		print_categories_view();
		break;

	case 'cat' :
		if( !empty( $cat_id ) ) {
			$cat_info = get_cat_info( $cat_id );
			jcPageHeader( sprintf( $lang_cat_events_view['section_title'], $cat_info['cat_name'] ) );
			print_cat_content( $cat_id );
		} else {
			jcPageHeader( $lang_main_menu['categories_view'] );
			print_categories_view();
		}
		break;

	case 'flyer' :
	case 'flat' :
		jcPageHeader( $lang_main_menu['flat_view'] );
		print_flat_view( $date );
		break;

	case 'month' :
	case 'cal' :
		jcPageHeader( $lang_main_menu['cal_view'] );
		print_monthly_view( $date );
		break;

	case 'extcal_search' :
		jcPageHeader( $lang_event_search_data['section_title'] );
		include( $CONFIG_EXT['FS_PATH'].'cal_search.php' );
		break;

	case 'minical' :
		print_minical();
		break;

	case 'calendar_select':
		$target = JRequest::getString( 'cal_id_selector' );
		if ( !empty( $target ) ) {
		jc_shRedirect( $target );
		}
		break;

	default:
		$extmode = '';
		jcPageHeader( $lang_main_menu['cal_view'] );
		print_monthly_view( $date );
		break;
}

// footer : don't show when replying to an ajax call for minical
if ( $extmode != 'minical' ) {
	pagefooter();
}


// Functions

function print_event_view( $extid ) {
	// function to display details on a specific event
	global $CONFIG_EXT, $lang_system, $lang_general, $lang_add_event_view;
	$event = new JCalEvent();
	if ( !$event->loadEvent( $extid ) ) {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_system['system_caption'], $lang_system['non_exist_event'], $lang_general['back'], $sef_href );
	} else {
		if ( !jclCanViewEvent( $event ) ) {
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
			theme_redirect_dialog( $lang_system['system_caption'], $lang_system['non_exist_event'], $lang_general['back'], $sef_href );
		} else {
			// additional field processing
			$event->title = format_text( $event->title,false,$CONFIG_EXT['capitalize_event_titles'] );
			$event->description = process_content( format_text( $event->description,true,false ) );
	
			// check if request is for iCal response, and if yes, process it
			// if this is an ical request, we won't return from this function call
			$filename = 'event_' . $extid;
			$eventList = array( 0 => array( 3 => $event ) );  // right now, we must fake other views data format
			jclProcessICalRequest( $filename, null, null, $eventList );
	
			// add rss feeds link
			$feeds_main_link = $CONFIG_EXT['enable_feeds'] ?
			JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' ) : '';
	
			theme_view_event( $event,$CONFIG_EXT['popup_event_mode'],$feeds_main_link );
		}
		if ( $CONFIG_EXT['search_view'] ) extcal_search();
	}
	jclSetPageMetadata(jclExtractKeywords(@$event->description . ' ' . @$event->title), @$event->description);
}

function print_daily_view( $date = '' ) {
	// function to display daily events
	global $CONFIG_EXT, $today, $lang_daily_event_view, $lang_system;
	global $lang_general, $lang_date_format, $todayclr, $mainframe;
	global $option, $Itemid_Querystring, $cat_id, $cal_id;

	$mosConfig_live_site = rtrim( JURI::base(), '/' );

	if ( $CONFIG_EXT['daily_view'] || has_priv( 'add' ) ) {
		// Check date. if no date is passed as argument, then we pick today
		if ( empty( $date ) ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		} else {
			$day = $date['day'];
			$month = $date['month'];
			$year = $date['year'];
		}

		// check if "show past events" is enabled, else force the date to today's date
		if( mktime( 0,0,0,$month,$day,$year ) < mktime( 0,0,0,$today['month'],$today['day'],$today['year'] ) && !$CONFIG_EXT['archive'] ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}
		$we = mktime( 0,0,0,$month,$day,$year );
		$we = jcTSToFormat( $we, '%w' );
		$we++;

		$nextday = mktime( 0,0,0,$month,$day + 1,$year );
		$nextday = jcTSToFormat( $nextday, '%d' );
		$nextmonth = mktime( 0,0,0,$month,$day + 1,$year );
		$nextmonth = jcTSToFormat( $nextmonth, '%m' );
		$nextyear = mktime( 0,0,0,$month,$day + 1,$year );
		$nextyear = jcTSToFormat( $nextyear, '%Y' );

		$previousday = mktime( 0,0,0,$month,$day - 1,$year );
		$previousday = jcTSToFormat( $previousday, '%d' );
		$previousmonth = mktime( 0,0,0,$month,$day - 1,$year );
		$previousmonth = jcTSToFormat( $previousmonth, '%m' );
		$previousyear = mktime( 0,0,0,$month,$day - 1,$year );
		$previousyear = jcTSToFormat( $previousyear, '%Y' );

		// Build the category and calendar filters for the url
		$cat_filter = '';
		if( isset( $cat_id ) && is_numeric( $cat_id ) ) $cat_filter .= "&cat_id=".$cat_id;
		$cal_filter = '';
		if( isset( $cal_id ) && is_numeric( $cal_id ) ) $cal_filter .= "&cal_id=".$cal_id;

		// get all events in one query
		$date_stamp = jcUserTimeToUTC( 0,0,0,$month,$day,$year, '%Y-%m-%d %H:%M:%S' );
		$startTS = jcUTCDateToTs( $date_stamp );
		$endTS = $startTS + 86399;
		$end_date = jcTSToUTC( $endTS, '%Y-%m-%d %H:%M:%S' );

		// are we printing ?
		$isPrint = JRequest::getInt( 'print', 0 ) == 1;

		// check if request is for iCal response, and if yes, process it
		// if this is an ical request, we won't return from this function call
		$filename = 'daily_' . $year . '_' . $month . '_' . $day;
		jclProcessICalRequest( $filename, $date_stamp, $end_date );

		// insert rss feeds link in head if allowed
		if ( !$isPrint ) {
			$feedsLink = $CONFIG_EXT['enable_feeds'] ? JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' ) : '';
			jclInsertFeedsLinks( $feedsLink );
		}

		// get events from database
		$events = get_events( $date_stamp, $end_date, $CONFIG_EXT['show_recurrent_events'],$CONFIG_EXT['show_overlapping_recurrences_dailyview'] );

		// start output
		starttable( '100%', $lang_daily_event_view['section_title'], 3 );

		$previous_day_date = jcTSToFormat( mktime( 0,0,0,$previousmonth,$previousday,$previousyear ), '%Y-%m-%d' );
		$next_day_date = jcTSToFormat( mktime( 0,0,0,$nextmonth,$nextday,$nextyear ), '%Y-%m-%d' );
		$date = jcTSToFormat( mktime( 0,0,0,( int )$month,( int )$day,( int )$year ), $lang_date_format['full_date'] );

		if ( $isPrint ) {
			// if printing echo current month name and a print button
			echo jclGetPrintHeader( $date );
		} else {
			echo "<tr class='tablec'>";
			// link to previous day
			echo "<td class='previousday' nowrap='nowrap' width='33%'>";
			if ( (mktime( 0,0,0,$previousmonth,$previousday,$previousyear ) >= mktime( 0,0,0,$today['month'],1,$today['year'] ) ) || $CONFIG_EXT["archive"] ) {
				$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=day&date=".$previous_day_date . $cat_filter . $cal_filter );
				echo "<span id='shajaxProgressPrevDay'></span><a href=\"$sef_href\" rel='shajaxLinkPrevDay extcalendar prefetch' >" . $lang_daily_event_view['previous_day'] . "</a>";
			}
	
			$bgcolor = ( $day == $today['day'] && $month == $today['month'] && $year == $today['year'] ) ? 'background: '.$todayclr : '';
			// Current day cell
			$class = 'currentday' . ( ($day == $today['day'] && $month == $today['month'] && $year == $today['year'] ) ? ' currentdaytoday' : '' );
			echo "</td><td class='$class' nowrap='nowrap'>";
			echo $date."</td>";
	
			// link to next day
			echo "<td class='nextday' nowrap='nowrap' width='33%'>";
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=day&date=".$next_day_date . $cat_filter . $cal_filter );
			echo "<a href=\"$sef_href\" rel='shajaxLinkNextDay extcalendar prefetch' >" . $lang_daily_event_view['next_day'] . "</a><span id='shajaxProgressNextDay'></span>";
	
			echo "</td></tr>\n";
		}
		if ( empty( $events[intval( $day )] ) ) {
			// display no events on selected day message
			echo "
			<!-- BEGIN message_row -->
			<tr class='tableb'>
			<td class='tableb' colspan='3'>
			<p class='cal_message'>{$lang_daily_event_view['no_events']}</p>
	
			</td>
			</tr>
			<!-- END message_row -->
			";

		} else {
			// print results of query
			while ( list( ,$event_row ) = each( $events[intval( $day )] ) ) {
				$event = $event_row[3];
				JCalEvent::FixUpEvent( $event );
	
				$urlTargetDate = jcUTCDateToFormat( $event->start_date, '%Y-%m-%d' );
	
				// popup or link ?
				if ($CONFIG_EXT['popup_event_mode']) {
					if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
						$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . '&amp;tmpl=component' . getIllBeThereItemid();
					} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
						$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$event->extid . '&amp;tmpl=component' . getJomSocialItemid();
					} else {
						$non_sef_href = "index.php?option=" . $option . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$event->extid. '&amp;tmpl=component' . "&amp;date=$urlTargetDate";
					}
					$link = 'href="'.JRoute::_( $non_sef_href ).'" class="jcal_modal" rel="{handler: \'iframe\'}" ';
				} else {
					if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
						$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . getIllBeThereItemid() );
					} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
						$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$event->extid . getJomSocialItemid() );
					} else {
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$event->extid  . "&amp;date=$urlTargetDate" );
					}
					$link = "href=\"$sef_href\"";
				}
				if ( $CONFIG_EXT['show_event_times_in_daily_view'] ) {
					$event_date_string = ' ( '.mf_get_timerange( $event, $day ).' )';
				} else {
					$event_date_string = '';
				}
	
				echo "<tr><td colspan='3'>\n<table width='100%' cellpadding='0' cellspacing='0' border='0'>\n";
				echo "<tr><td width='6' bgcolor='".$event->color."'><img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='6' height='1' alt='' /></td>\n";
				echo "<td class='tableb' width='100%'><div class='eventdesc'><a ".$link." class='eventtitle'>".format_text( sub_string( $event->title,$CONFIG_EXT['daily_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] ).$event_date_string."</a>\n";
				echo "</div></td></tr></table></td></tr>\n";
	
			}
		}
		display_cat_legend ( 3 );

		endtable();

		// set the page title
		$menu =& JSite::getMenu();
		$currentMenuItem = $menu->getActive();
		$currentMenuItemName = empty( $currentMenuItem ) ? '' : ' | ' . $currentMenuItem->name;
		jclSetPageTitle( $date . $currentMenuItemName, 'extcalendar' );

		// prepare return to url
		jclSetReturnValue( $month,$day,$year );

		if ( $CONFIG_EXT['search_view'] ) extcal_search();
	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_daily_event_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function print_weekly_view( $date = '' ) {
	// function to display weekly events
	global $CONFIG_EXT, $today, $lang_weekly_event_view, $lang_daily_event_view, $lang_system, $mainframe;
	global $lang_general, $lang_date_format, $todayclr;
	global $option, $Itemid_Querystring, $cat_id, $cal_id;

	$mosConfig_live_site = rtrim( JURI::base(), '/' );

	if ( $CONFIG_EXT['weekly_view'] || has_priv( 'add' ) ) {
		// Check date. if no date is passed as argument, then we pick today
		if ( empty( $date ) ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		} else {
			$day = $date['day'];
			$month = $date['month'];
			$year = $date['year'];
		}

		$current_weeknumber = get_week_number( $today['day'], $today['month'], $today['year'] );
		// Calculationg the week number
		$weeknumber = get_week_number( $day, $month, $year );

		// check if "show past events" is enabled, else force the date to today's date
		if( mktime( 0,0,0,$month,$day,$year ) < mktime( 0,0,0,$today['month'],$today['day'],$today['year'] ) && !$CONFIG_EXT['archive'] ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
			$weeknumber = $current_weeknumber;
		}

		// Build the category and calendar filters for the url
		$cat_filter = '';
		if( isset( $cat_id ) && is_numeric( $cat_id ) ) $cat_filter .= "&cat_id=".$cat_id;
		$cal_filter = '';
		if( isset( $cal_id ) && is_numeric( $cal_id ) ) $cal_filter .= "&cal_id=".$cal_id;

		// are we printing ?
		$isPrint = JRequest::getInt( 'print', 0 ) == 1;

		if ( $isPrint ) {
			// add rss feeds link
			$feedsLink = $CONFIG_EXT['enable_feeds'] ?  JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' ) : '';

			// insert rss feeds link in head if allowed
			jclInsertFeedsLinks( $feedsLink );
		}

		$week_bound = array();
		$week_bound = get_week_bounds( $day,$month,$year );

		$fdy = $week_bound['first_day']['year'];
		$fdm = $week_bound['first_day']['month'];
		$fdd = $week_bound['first_day']['day'];

		$ldy = $week_bound['last_day']['year'];
		$ldm = $week_bound['last_day']['month'];
		$ldd = $week_bound['last_day']['day'];

		$period = sprintf( $lang_weekly_event_view['week_period'],jcUTCDateToFormatNoOffset( "$fdy-$fdm-$fdd", $lang_date_format['mini_date'] ),
		jcUTCDateToFormatNoOffset( "$ldy-$ldm-$ldd", $lang_date_format['mini_date'] ) );

		// compute date range
		$date_stamp = jcUserTimeToUTC( 0,0,0,$fdm,$fdd,$fdy );
		$dateStampOfLastDay = jcUserTimeToUTC( 23,59,59,$ldm,$ldd,$ldy );

		// check if request is for iCal response, and if yes, process it
		// if this is an ical request, we won't return from this function call
		$filename = 'weekly_' . $year . '_' . $weeknumber;
		jclProcessICalRequest( $filename, $date_stamp, $dateStampOfLastDay );

		// get events from database
		$events = get_events( $date_stamp, $dateStampOfLastDay, $CONFIG_EXT['show_recurrent_events'],$CONFIG_EXT['show_overlapping_recurrences_monthlyview'] );

		// start output

		// header ( with links )
		starttable( '100%', $lang_weekly_event_view['section_title'], 3, '', $period );

		// current week string :
		$currentWeekTitle = sprintf( $lang_weekly_event_view['selected_week'], $weeknumber );
		if ( $isPrint ) {
			echo jclGetPrintHeader( $currentWeekTitle );
		} else {
			echo "<tr class='tablec'>";

			echo "<td class='previousweek'>";
			// previous and next week links

			// Calculationg the week number that contains the first day of current month and year

			if ( $CONFIG_EXT['archive'] || mktime( 0,0,0,$fdm,$fdd,$fdy ) >= mktime( 0,0,0,$today['month'], $today['day'],$today['year'] ) ) {
				$time_stamp = ( mktime( 0,0,0,$fdm,$fdd-7,$fdy ) >= mktime( 0,0,0,$today['month'], $today['day'],$today['year'] ) || $CONFIG_EXT['archive'] ) ? mktime( 0,0,0,$fdm,$fdd-7,$fdy ):mktime( 0,0,0,$today['month'], $today['day'],$today['year'] );
				$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=week&date=".date( "Y-m-d", $time_stamp ) . $cat_filter . $cal_filter  );
				echo "<span id='shajaxProgressPrevWeek'></span>";
				echo "<a href=\"$sef_href\" rel='shajaxLinkPrevWeek extcalendar prefetch' >";
				echo $lang_weekly_event_view['previous_week'];
				echo "</a> ";
			}
			// Current week cell
			$class = 'currentweek' . ( $weeknumber == ( $current_weeknumber ) ? ' currentweektoday' : '' );
			echo "</td><td class='$class'>";
			echo $currentWeekTitle. "</td>";

			// link to next week
			echo "<td class='nextweek'>";
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=week&date=".date( "Y-m-d", mktime( 0,0,0,$ldm,$ldd+1,$ldy ) ) . $cat_filter . $cal_filter );
			echo "<a href=\"$sef_href\" rel='shajaxLinkNextWeek extcalendar prefetch' >";
			echo $lang_weekly_event_view['next_week'];
			echo "</a>";
			echo "<span id='shajaxProgressNextWeek'></span>";
			echo "</td></tr>\n";
		}
		$i = 0;

		while ( $i < 7 ) {

		$currentDay = intval( $fdd );
		$previousweekday = 0;

		if ( !empty( $events[$currentDay] ) ) {

			// iterate over events
			while ( list( ,$event_row ) = each( $events[$currentDay] ) ) {

				$event = $event_row[3]; // now we get the whole event from the db
				JCalEvent::FixUpEvent( $event );

				$weekday = jcTSToFormat( mktime( 0,0,0,$fdm,$fdd,$fdy ), '%w' );
				$weekday++;

				$date_stamp = mktime( 0,0,0,$fdm,$fdd,$fdy ); // added to pass date to recurring events
				$date = jcTSToFormat( $date_stamp, $lang_date_format['full_date'] );

				if( $previousweekday != $weekday ) {
					echo "<tr class='tableh2'><td colspan='3' class='tableh2'><a id=\"w".$weekday."\" name=\"w".$weekday."\"></a>$date</td></tr>";
				}
				$previousweekday = $weekday;

				$urlTargetDate = jcUTCDateToFormat( $event->start_date, '%Y-%m-%d' );

				if ($CONFIG_EXT['popup_event_mode']) {
					if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
						$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . '&amp;tmpl=component' . getIllBeThereItemid();
					} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
						$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$event->extid . '&amp;tmpl=component' . getJomSocialItemid();
					} else {
						$non_sef_href = "index.php?option=" . $option . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$event->extid. '&amp;tmpl=component' . "&amp;date=$urlTargetDate";
					}
					$link = 'href="'.JRoute::_( $non_sef_href ).'" class="jcal_modal" rel="{handler: \'iframe\'}" ';
				} else {
					if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
						$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . getIllBeThereItemid() );
					} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
						$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$event->extid . getJomSocialItemid() );
					} else {
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$event->extid  . "&amp;date=$urlTargetDate" );
					}
					$link = "href=\"$sef_href\"";
				}

				if ( $CONFIG_EXT['show_event_times_in_weekly_view'] ) {
					$event_date_string = ' ( '.mf_get_timerange( $event, $currentDay ).' )';
				} else {
					$event_date_string = '';
				}

				echo "<tr><td colspan='3'>\n<table width='100%' cellpadding='0' cellspacing='0' border='0'>\n";
				echo "<tr><td width='6' bgcolor='".$event->color."'><img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='6' height='1' alt='' /></td>\n";
				echo "<td class='tableb' width='100%'><div class='eventdesc'><a $link class='eventtitle'>".format_text( sub_string( $event->title,$CONFIG_EXT['weekly_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] ).$event_date_string."</a>\n";

				echo "</div></td>\n";

				echo "</tr></table></td></tr>\n";
			}
		} else if ( empty( $events[$currentDay] ) && JC_SHOW_EMPTY_DAYS_ON_WEEK_VIEWS ) {
			// no events on this day
			$weekday = jcTSToFormat( mktime( 0,0,0,$fdm,$fdd,$fdy ), '%w' );
			$weekday++;
			$date_stamp = mktime( 0,0,0,$fdm,$fdd,$fdy ); // added to pass date to recurring events
			$date = jcTSToFormat( $date_stamp, $lang_date_format['full_date'] );
			echo "<tr class='tableh2'><td colspan='3' class='tableh2'><a id=\"w".$weekday."\" name=\"w".$weekday."\"></a>$date</td></tr>";
			echo "
			<!-- BEGIN message_row -->
			<tr class='tableb'>
			<td align='center' class='tableb' colspan='3'>
			<br />
			<strong>{$lang_daily_event_view['no_events']}</strong>
			<br /><br />
			</td>
			</tr>
			<!-- END message_row -->
				";

		}

		$fdy = jcTSToFormat( mktime( 0,0,0,$fdm,$fdd+1,$fdy ), '%Y' );
		if ( jcTSToFormat( mktime( 0,0,0,$fdm,$fdd+1,$fdy ), '%m' )==$fdm ) {
			$fdd = jcTSToFormat( mktime( 0,0,0,$fdm,$fdd+1,$fdy ), '%d' );
		} else {
			$fdm = jcTSToFormat( mktime( 0,0,0,$fdm,$fdd+1,$fdy ), '%m' );
			$fdd = jcTSToFormat( mktime( 0,0,0,$fdm,1,$fdy ), '%d' );
		}
		$i++;
		}
		if( !$weekday ) {
		// display no events on selected week message
		echo "
		<!-- BEGIN message_row -->
		<tr class='tableb'>
		<td align='center' class='tableb' colspan='3'>
		<br /><br />
		<strong>{$lang_weekly_event_view['no_events']}</strong>
		<br /><br /><br />
		</td>
		</tr>
		<!-- END message_row -->
		";

		}
		display_cat_legend ( 3 );
		endtable();

		// set the page title
		$menu =& JSite::getMenu();
		$currentMenuItem = $menu->getActive();
		$currentMenuItemName = empty( $currentMenuItem ) ? '' : ' | ' . $currentMenuItem->name;
		jclSetPageTitle( sprintf( $lang_weekly_event_view['selected_week'], $weeknumber ) . $currentMenuItemName, 'extcalendar' );

		// prepare return to url
		jclSetReturnValue( $fdm,$fdd,$fdy );

		if ( $CONFIG_EXT['search_view'] )	extcal_search();
	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_weekly_event_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function print_monthly_view( $date = '' ) {
	// function to display monthly events
	global $CONFIG_EXT, $today, $lang_monthly_event_view, $lang_system, $THEME_DIR;
	global $lang_general, $lang_date_format, $event_icons, $template_monthly_view, $todayclr, $cat_id, $cal_id;
	global $lang_event_search_data;

	if ( $CONFIG_EXT['monthly_view'] || has_priv( 'add' ) ) {
		// Check date. if no date is passed as argument, then we pick today
		if ( empty( $date ) ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		} else {
			$day = $date['day'];
			$month = $date['month'];
			$year = $date['year'];
		}

		// check if "show past events" is enabled, else force the date to today's date
		if( mktime( 0,0,0,$month,$day,$year ) < mktime( 0,0,0,$today['month'],1,$today['year'] ) && !$CONFIG_EXT['archive'] ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}

		// insert date into an array an pass it to the theme monthly view
		$target_date = array(
			'day' => $day,
			'month' => $month,
			'year' => $year
		);
		// Build the category and calendar filters for the url
		$cat_filter = '';
		if( isset( $cat_id ) && is_numeric( $cat_id ) ) $cat_filter .= "&cat_id=".$cat_id;
		$cal_filter = '';
		if( isset( $cal_id ) && is_numeric( $cal_id ) ) $cal_filter .= "&cal_id=".$cal_id;
		// number of days in asked month
		$nr = date( "t", TSServerToUser( mktime( 1,0,1,$month,5,$year ) ) );

		$previous_month_date = jcTSToFormat( mktime( 0,0,0,$month-1,1,$year ), '%Y-%m-%d' );
		$next_month_date = jcTSToFormat( mktime( 0,0,0,$month+1,1,$year ), '%Y-%m-%d' );

		$printing = JRequest::getInt( 'print', 0 );
		$printing = $printing ? '&print=1' : '';
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=cal&date=".$previous_month_date . $cat_filter . $cal_filter . $printing  );
		$info_data['previous_month_url'] = $sef_href;
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=cal&date=".$next_month_date . $cat_filter . $cal_filter . $printing );
		$info_data['next_month_url'] = $sef_href;

		$info_data['current_month_color'] = ( $month == $today['month'] && $year == $today['year'] ) ? 'background: '.$todayclr : '';

		if ( $CONFIG_EXT['archive'] || ( $month != date( "n" ) || $year != date( "Y" ) ) ) {
			$info_data['show_past_months'] = true;
		} else {
			$info_data['show_past_months'] = false;
		}

		// get the weekdays
		for ( $i=0;$i<=6;$i++ ) {
			$array_index = $CONFIG_EXT['day_start']?( $i+1 )%7:$i;

			if ( $array_index ) {
				$css_class = "weekdaytopclr"; // weekdays
			} else {
				$css_class = "sundaytopclr"; // sunday
			}
			$info_data['weekdays'][$i]['name'] = $lang_date_format['day_of_week'][$array_index];
			$info_data['weekdays'][$i]['class'] = $css_class;
		}

		// add rss feeds link
		$info_data['feeds_main_link'] = $CONFIG_EXT['enable_feeds'] ? JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' . ( !empty( $cat_id ) ? '&cat_id='.$cat_id : '' ). ( !empty( $cal_id ) ? '&cal_id='.$cal_id : '' ) ) : '';

		$event_stack = array();

		// get all events in one query
		$date_stamp = jcUserTimeToUTC( 0,0,0,$month,1,$year );  // we must use server time, not UTC
		$dateStampOfLastDay = jcUserTimeToUTC( 23,59,59,$month,$nr,$year );

		// check if request is for iCal response, and if yes, process it
		// if this is an ical request, we won't return from this function call
		$filename = 'monthly_' . $year . '_' . $month;
		jclProcessICalRequest( $filename, $date_stamp, $dateStampOfLastDay );

		// continue if this was not an iCal request
		$events = get_events( $date_stamp, $dateStampOfLastDay, $CONFIG_EXT['show_recurrent_events'],$CONFIG_EXT['show_overlapping_recurrences_monthlyview'] );

		// 'existing' days in month
		for ( $i=1;$i<=$nr;$i++ ) {
			$date_stamp = jcUserTimeToUTC( 0,0,0,$month,$i,$year );  // we must use not UTC

			//$event_stack[$i]['events'] = $events;
			$event_stack[$i]['week_number'] = ( int ) get_week_number( $i, $month, $year );

			// iterate over each event for this day
			if ( !empty( $events[$i] ) ) {
				while ( list( ,$event_info ) = each( $events[$i] ) ) {
					// Initialize the event object RP: moved from outside the while loop as we need a new event created each time
					$event = $event_info[3]; // now we get the whole event from the db
					JCalEvent::FixUpEvent( $event );

					$event_style = jclGetStyle(jcUTCDateToTs($date_stamp), $event_info[1], $event_info[2], @$event->rec_type_select, @$event->rec_id, @$event->detached_from_rec);
					$event_icon = $event_icons[$event_style];
					$title = format_text( sub_string( $event->title,$CONFIG_EXT['cal_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] );
					$event_stack[$i]['events'][] = array(
						'title' => $title,
						'style' => $event_style,
						'icon' => $event_icon,
						'color' => $event->color,
						'extid' => $event->extid,
						'eventdata' => $event,
						'isPrivate' => $event->private
					);
				}
			}
		}
		
		theme_monthly_view( $target_date, $event_stack, $info_data );

		if ( $CONFIG_EXT['search_view'] ) extcal_search();

	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_weekly_event_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function print_flat_view( $date = '' ) {
	// function to display monthly events in a flat view mode
	global $CONFIG_EXT, $today, $lang_flat_event_view, $lang_system, $THEME_DIR;
	global $lang_general, $lang_date_format, $todayclr, $mainframe;
	global $option, $Itemid_Querystring, $cal_id, $cat_id;

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );
	$db =& JFactory::getDBO();

	$mosConfig_live_site = rtrim( JURI::base(), '/' );

	if ( $CONFIG_EXT['flyer_view'] || has_priv( 'add' ) ) {

		// are we printing ?
		$isPrint = JRequest::getInt( 'print', 0 ) == 1;

		// add rss feeds link
		if ( $isPrint ) {
		$feedsLink = $CONFIG_EXT['enable_feeds'] ?
		JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' ) : '';
		// insert rss feeds link in head if allowed
		jclInsertFeedsLinks( $feedsLink );
		}

		// Check date. if no date is passed as argument, then we pick today
		if ( empty( $date ) ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		} else {
			$day = $date['day'];
			$month = $date['month'];
			$year = $date['year'];
		}

		// check if "show past events" is enabled, else force the date to today's date
		if( mktime( 0,0,0,$month,$day,$year ) < mktime( 0,0,0,$today['month'],1,$today['year'] ) && !$CONFIG_EXT['archive'] ) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}

		// previous month
		$pm = $month;
		if ( $month == "1" ) $pm = "12"; else  $pm--;
		// previous year
		$py = $year;
		if ( $pm == "12" ) $py--;

		// next month
		$nm = $month;
		if ( $month == "12" ) $nm = "1"; else $nm++;
		// next year
		$ny = $year;
		if ( $nm == 1 ) $ny++;

		$firstday = jcTSToFormat( mktime( 12,0,0,$month,1,$year ), '%w' );
		$firstday++;
		// nr of days in askedmonth
		$nr = date( "t", TSServerToUser( mktime( 12,0,0,$month,1,$year ) ) );

		// Build the category and calendar filters for the url
		$cat_filter = '';
		if( isset( $cat_id ) && is_numeric( $cat_id ) ) $cat_filter .= "&cat_id=".$cat_id;
		$cal_filter = '';
		if( isset( $cal_id ) && is_numeric( $cal_id ) ) $cal_filter .= "&cal_id=".$cal_id;

		// get all events in one query
		$currentMonth = jcTSToFormat( mktime( 0,0,0,$month,1,$year ), $lang_date_format['month_year'] );
		$date_stamp = jcUserTimeToUTC( 0,0,0,$month,1,$year );  // we must use server time, not UTC
		$dateStampOfLastDay = jcUserTimeToUTC( 23,59,59,$month,$nr,$year );

		// check if request is for iCal response, and if yes, process it
		// if this is an ical request, we won't return from this function call
		if ( !$isPrint ) {
			$filename = 'flat_' . $year . '_' . $month;
			jclProcessICalRequest( $filename, $date_stamp, $dateStampOfLastDay );
		}

		// load events from DB
		$events = get_events( $date_stamp, $dateStampOfLastDay, $CONFIG_EXT['show_recurrent_events'],$CONFIG_EXT['show_overlapping_recurrences_monthlyview'] );

		// start output
		$today_date = jcTSToFormat( mktime( 0,0,0,$today['month'],$today['day'],$today['year'] ), $lang_date_format['full_date'] );

		// print header
		if ( $isPrint ) {
			echo jclGetPrintHeader( $currentMonth );
		}

		starttable( '100%', $lang_flat_event_view['section_title'], 3, '', $today_date );
		if ( !$isPrint ) {
			echo "<tr class='tablec'>";
			echo "<td class='previousmonth' nowrap='nowrap' width='33%'>&nbsp;";

			$previous_month_date = jcTSToFormat( mktime( 0,0,0,$pm,1,$py ), '%Y-%m-%d' );
			$next_month_date = jcTSToFormat( mktime( 0,0,0,$nm,1,$ny ), '%Y-%m-%d' );

			if ( $month != date( "n" ) || $year != date( "Y" ) ) {
				// date for previous month
				$date = jcTSToFormat( mktime( 0,0,0,$pm,1,$py ), $lang_date_format['month_year'] );
				$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=flat&date=".$previous_month_date . $cat_filter . $cal_filter );
				echo '<span id="shajaxProgressPrevMonth"></span>';
				echo "<a href=\"$sef_href\" rel=\"shajaxLinkPrevMonth extcalendar prefetch\">";

				echo $date;
				echo "</a>";
			}
			elseif ( $CONFIG_EXT['archive'] == '1' ) {
				// date for previous month
				$date = jcTSToFormat( mktime( 0,0,0,$pm,1,$py ), $lang_date_format['month_year'] );
				$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=flat&date=".$previous_month_date . $cat_filter . $cal_filter );
				echo '<span id="shajaxProgressPrevMonth"></span>';
				echo "<a href=\"$sef_href\" rel=\"shajaxLinkPrevMonth extcalendar prefetch\" >";
				echo $date;
				echo "</a>";
			}
			// date for current month
			$class = 'currentmonth' . ( $month == $today['month'] && $year == $today['year'] ? ' currentmonthtoday' : '' );
			echo "</td><td class='$class' nowrap='nowrap'>";
			echo $currentMonth."</td>";

			// date for next month
			$date = jcTSToFormat( mktime( 0,0,0,$nm,1,$ny ), $lang_date_format['month_year'] );
			echo "<td class='nextmonth' nowrap='nowrap' width='33%'>";
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=flat&date=".$next_month_date . $cat_filter . $cal_filter );
			echo "<a href=\"$sef_href\" rel=\"shajaxLinkNextMonth extcalendar prefetch\" >";
			echo $date;
			echo "</a>";
			echo '<span id="shajaxProgressNextMonth"></span>';

			echo "</td></tr>\n";
		}

		for ( $i=1;$i<=$nr;$i++ ) {
			$date_stamp = mktime( 0,0,0,$month,$i,$year );

			// if result, let's go for that day !
			if ( !empty( $events[$i] ) ) {

				// set date
				$date = jcTSToFormat( mktime( 0,0,0,$month,$i,$year ), $lang_date_format['full_date'] );
				echo "<tr class='tableh2'><td colspan='3' class='tableh2'><a id=\"w$i\" name=\"w$i\"></a>".$date."</td></tr>";

				while ( list( ,$event_info ) = each( $events[$i] ) ) {
					$event = $event_info[3]; // now we get the whole event from the db
					JCalEvent::FixUpEvent( $event );

					if ( $CONFIG_EXT['show_event_times_in_flat_view'] ) {
						$event_date_string = ' ( '.mf_get_timerange( $event ).' )';
					} else {
						$event_date_string = '';
					}

					echo "<tr><td colspan='3'>\n<table width='100%' cellpadding='0' cellspacing='0' border='0'>\n";
					echo "<tr><td width='6' bgcolor='".$event->color."'><img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='6' height='1' alt='' /></td>\n";

					$urlTargetDate = jcUTCDateToFormat( $event->start_date, '%Y-%m-%d' );

					if ($CONFIG_EXT['popup_event_mode']) {
						if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
							$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . '&amp;tmpl=component' . getIllBeThereItemid();
						} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
							$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$event->extid . '&amp;tmpl=component' . getJomSocialItemid();
						} else {
							$non_sef_href = "index.php?option=" . $option . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$event->extid. '&amp;tmpl=component' . "&amp;date=$urlTargetDate";
						}
						echo "<td class='tableb' width='100%'><div class='eventdesc'><a href=\"".JRoute::_( $non_sef_href )."\" class=\"jcal_modal\" rel=\"{handler: 'iframe'}\" >";
					} else {
						if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
							$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . getIllBeThereItemid() );
						} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
							$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$event->extid . getJomSocialItemid() );
						} else {
							$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$event->extid  . "&amp;date=$urlTargetDate" );
						}
						echo "<td class='tableb' width='100%'><div class='eventdesc'><a href=\"$sef_href\" class='eventtitle'>";
					}

					echo format_text( $event->title,false,$CONFIG_EXT['capitalize_event_titles'] ).$event_date_string."</a><br />\n";

					// picture
					if ( $CONFIG_EXT["flyer_show_picture"] ) {
						if ( @$event->picture ) echo "<img src=\"".$CONFIG_EXT['calendar_url'].'/upload/'.$event->picture."\" align=\"right\" alt=\"\" /><br />";
					}
					// title
					// description
					echo process_content( format_text( sub_string( @$event->description,$CONFIG_EXT['flyer_view_max_chars'],'...' ),true,false ) )."<br />\n";
					echo "<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='1' height='4' alt='' /><br />\n";
					// contact
					if ( @$event->contact ) echo "<strong>".$lang_flat_event_view['contact_info']." :</strong> ".stripslashes( $event->contact )." \n";
					// email
					if ( @$event->email ) echo "<strong>".$lang_flat_event_view['contact_email']." :</strong> $event->email\n";
					// url
					if ( @$event->url ) echo "<strong>Url:</strong> <a href=".$event->url.">".$event->url."</a>\n";
					echo "<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='1' height='8' alt='' /><br />\n";
					echo "</div></td></tr></table></td></tr>\n";
				}
			}
		}
		display_cat_legend ( 3 );

		endtable();

		// set the page title
		$menu =& JSite::getMenu();
		$currentMenuItem = $menu->getActive();
		$currentMenuItemName = empty( $currentMenuItem ) ? '' : ' | ' . $currentMenuItem->name;
		jclSetPageTitle( $currentMonth . $currentMenuItemName, 'extcalendar' );

		// prepare return to url
		jclSetReturnValue( $month,1,$year );

		if ( $CONFIG_EXT['search_view'] ) extcal_search();
	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_flat_event_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function print_categories_view() {
	// function to display a list of event categories
	global $CONFIG_EXT, $today, $lang_cats_view, $lang_system, $cal_id;
	global $lang_general, $lang_date_format;

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );
	$db =& JFactory::getDBO();
	
	$cat_list = jclValidateList( $pageParams->get( 'cat_list' ) );
	$cal_list = jclValidateList( $pageParams->get( 'cal_list' ) );

	if ( $CONFIG_EXT['cats_view'] || has_priv( 'add' ) ) //  enabled or not ?
	{
		// are we printing ?
		$isPrint = JRequest::getInt( 'print', 0 ) == 1;

		if ( $isPrint ) {
			// add rss feeds link
			$feedsLink = $CONFIG_EXT['enable_feeds'] ?
			JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed' ) : '';
			// insert rss feeds link in head if allowed
			jclInsertFeedsLinks( $feedsLink );
		}

		$exclude = $pageParams->get( 'cat_list_exclude' );

		// read applicable categories list
		$query = "SELECT * FROM " . $CONFIG_EXT['TABLE_CATEGORIES'] . " WHERE published = '1'";
		// apply category restrictions
		if ( !empty( $cat_list ) ) {
			$query .= " AND cat_id ".( $exclude ? 'NOT' : '' )." IN ( " . $cat_list . " )";
		}
		// apply sort order
		$query .= " ORDER BY cat_name";
		// query db
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		$catnames = array();
		foreach ( $rows as $row ) {
			$catnames[] = $row->cat_name;
		}

		if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && $CONFIG_EXT['show_illbethere'] ) ) {
			$cat_list_illbethere = jclValidateList( $pageParams->get( 'cat_list_illbethere' ) );
			if ( empty( $cat_list_illbethere ) ) {
				$cat_list_illbethere = @$CONFIG_EXT['cat_list_illbethere'];
			}
			if ( $cat_list_illbethere == -1 ) {
				$cat_list_illbethere = '';
			}
			$exclude_illbethere = $pageParams->get( 'cat_list_exclude_illbethere' );
			// read RSVP categories list
			$query = "SELECT * FROM #__illbethere_categories WHERE published = '1'";
			// apply category restrictions
			if ( !empty( $cat_list_illbethere ) ) {
				$query .= " AND cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
			}
			// apply sort order
			$query .= " ORDER BY name";
			// query db
			$db->setQuery( $query );
			$extra_rows = $db->loadObjectList();
			foreach ( $extra_rows as $row ) {
				if ( !in_array( $row->name, $catnames ) ) {
					$row->cat_ext = 'illbethere';
					$row->cat_name = $row->name;
					$row->color = $CONFIG_EXT['color_illbethere'];
					$rows[] = $row;
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
			// read JomSocial categories list
			$query = "SELECT * FROM #__community_events_category WHERE 1";
			// apply category restrictions
			if ( !empty( $cat_list_community ) ) {
				$query .= " AND id ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
			}
			// apply sort order
			$query .= " ORDER BY name";
			// query db
			$db->setQuery( $query );
			$extra_rows = $db->loadObjectList();
			foreach ( $extra_rows as $row ) {
				if ( !in_array( $row->name, $catnames ) ) {
					$row->cat_ext = 'community';
					$row->cat_id = $row->id;
					$row->cat_name = $row->name;
					$row->color = $CONFIG_EXT['color_community'];
					$rows[] = $row;
				}
			}
		}

		if ( empty( $rows ) ) {
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
			theme_redirect_dialog( $lang_system['system_caption'], $lang_cats_view['no_cats'], $lang_general['back'], $sef_href );
		} else {

			$total_cats = 0;
			$all_events = 0;
			$count = 0;
			$cat_rows = '';
			// apply calendar restrictions
			$calendarQuery = '';
			if ( !empty( $cal_i1 ) ) {
				$calendarQuery = " AND cal_id = ".$db->Quote( $cal_i1 ) . ' ';
			} else if ( !empty( $cal_list ) ) {
				// if not a specific cal requested, apply calendars list restrictions
				$calendarQuery = " AND cal_id IN ( " . $cal_list . " ) ";
			}
			foreach( $rows as $row ) {
				if ( has_priv ( 'category' . $row->cat_id ) || ( isset( $row->cat_ext ) && $row->cat_ext != '' ) ) {
					$where_date = '';
					if( $CONFIG_EXT['archive'] ) {
						$day_pattern = JString::substr( JCL_DATE_MIN, 0, 10 );
						$day_pattern = str_replace( '-', '', $day_pattern );
					} else {
						$day_pattern = sprintf( "%04d%02d%02d",$today['year'],$today['month'],$today['day'] ); // day pattern: 20041231 for 'December 31, 2004'
					}
					if( isset( $row->cat_ext ) && $row->cat_ext == 'illbethere' ) {
						// ALL
						if( !$CONFIG_EXT['archive'] ) {
							$where_date = "AND ( DATE_FORMAT( e.session_up,'%Y%m%d' ) >= $day_pattern )";
						}
						$query = "SELECT count( * ) FROM #__illbethere_sessions as e
							WHERE e.cat_id = '".$row->cat_id."' AND e.published = 1 ".$where_date;
						$db->setQuery( $query );
						$total_events = $db->loadResult();

						// UPCOMING
						$day_pattern = sprintf( "%04d%02d%02d",$today['year'],$today['month'],$today['day'] );
						$query = "SELECT count( * ) FROM #__illbethere_sessions AS e
							WHERE ( DATE_FORMAT( e.session_up,'%Y%m%d' ) > $day_pattern )
							AND e.cat_id = '".$row->cat_id."' AND e.published = 1";
						$db->setQuery( $query );
						$upcoming_events = $db->loadResult();
					} else if( isset( $row->cat_ext ) && $row->cat_ext == 'community' ) {
						// ALL
						if( !$CONFIG_EXT['archive'] ) {
							$where_date = "AND ( DATE_FORMAT( e.startdate,'%Y%m%d' ) >= $day_pattern )";
						}
						$query = "SELECT count( * ) FROM #__community_events as e
							WHERE e.catid = '".$row->cat_id."' AND e.published = 1 ".$where_date;
						$db->setQuery( $query );
						$total_events = $db->loadResult();

						// UPCOMING
						$day_pattern = sprintf( "%04d%02d%02d",$today['year'],$today['month'],$today['day'] );
						$query = "SELECT count( * ) FROM #__community_events AS e
							WHERE ( DATE_FORMAT( e.startdate,'%Y%m%d' ) > $day_pattern )
							AND e.catid = '".$row->cat_id."' AND e.published = 1";
						$db->setQuery( $query );
						$upcoming_events = $db->loadResult();
					} else {
						// ALL
						if( !$CONFIG_EXT['archive'] ) {
							$where_date = "AND ( DATE_FORMAT( e.start_date,'%Y%m%d' ) >= $day_pattern )";
						}
						$query = "SELECT count( * ) FROM ".$CONFIG_EXT['TABLE_EVENTS'] . " AS e
								WHERE e.cat = '$row->cat_id' $calendarQuery AND e.approved = 1 AND e.published = 1 ".$where_date;
						$db->setQuery( $query );
						$total_events = $db->loadResult();

						if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && $CONFIG_EXT['show_illbethere'] ) ) {
							// Add RSVP events
							if( !$CONFIG_EXT['archive'] ) {
								$where_date = "AND ( DATE_FORMAT( e.session_up,'%Y%m%d' ) >= $day_pattern )";
							}
							$query = "SELECT count( * ) FROM #__illbethere_sessions AS e
								LEFT JOIN #__illbethere_categories as c
								ON c.cat_id = e.cat_id
								WHERE c.name = ".$db->Quote($row->cat_name)." AND e.published = 1 ".$where_date;
							if ( !empty( $cat_list_illbethere ) ) {
								$query .= " AND e.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
							}
							$db->setQuery( $query );
							$total_events += $db->loadResult();
						}

						if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && $CONFIG_EXT['show_community'] ) ) {
							// Add JomSocial events
							if( !$CONFIG_EXT['archive'] ) {
								$where_date = "AND ( DATE_FORMAT( e.startdate,'%Y%m%d' ) >= $day_pattern )";
							}
							$query = "SELECT count( * ) FROM #__community_events AS e
								LEFT JOIN #__community_events_category as c
								ON c.id = e.catid
								WHERE c.name = ".$db->Quote($row->cat_name)." AND e.published = 1 ".$where_date;
							if ( !empty( $cat_list_community ) ) {
								$query .= " AND c.id ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
							}
							$db->setQuery( $query );
							$total_events += $db->loadResult();
						}
						
						// UPCOMING
						$day_pattern = sprintf( "%04d%02d%02d",$today['year'],$today['month'],$today['day'] );
						$query = "SELECT count( * ) FROM ".$CONFIG_EXT['TABLE_EVENTS'] . " AS e
							WHERE ( DATE_FORMAT( e.start_date,'%Y%m%d' ) > $day_pattern  )
							AND e.cat = $row->cat_id $calendarQuery AND e.approved = 1 and e.published = 1";
						$db->setQuery( $query );
						$upcoming_events = $db->loadResult();
						if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && $CONFIG_EXT['show_illbethere'] ) ) {
							// Add RSVP events
							$query = "SELECT count( * ) FROM #__illbethere_sessions AS e
								LEFT JOIN #__illbethere_categories as c
								ON c.cat_id = e.cat_id
								WHERE ( DATE_FORMAT( e.session_up,'%Y%m%d' ) > $day_pattern )
								AND c.name = ".$db->Quote($row->cat_name)." AND e.published = 1";
							if ( !empty( $cat_list_illbethere ) ) {
								$query .= " AND e.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
							}
							$db->setQuery( $query );
							$upcoming_events += $db->loadResult();
						}
						if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && $CONFIG_EXT['show_community'] ) ) {
							// Add JomSocial events
							$query = "SELECT count( * ) FROM #__community_events AS e
								LEFT JOIN #__community_events_category as c
								ON c.id = e.catid
								WHERE ( DATE_FORMAT( e.startdate,'%Y%m%d' ) > $day_pattern )
								AND c.name = ".$db->Quote($row->cat_name)." AND e.published = 1";
							if ( !empty( $cat_list_community ) ) {
								$query .= " AND e.catid ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
							}
							$db->setQuery( $query );
							$upcoming_events += $db->loadResult();
						}
					}

					if ( $total_events || $upcoming_events || $pageParams->get( 'hide_empty_cats' ) === 0 || ( $pageParams->get( 'hide_empty_cats' ) == '' && !@$CONFIG_EXT['hide_empty_cats'] ) ) {
						$cat_rows[$count] = array();
						$cat_rows[$count]['total_events'] = $total_events;
						$cat_rows[$count]['upcoming_events'] = $upcoming_events;
						$cat_rows[$count]['color'] = $row->color;
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=cat&cat_id=".$row->cat_id.( isset( $row->cat_ext ) ? '&cat_ext='.$row->cat_ext : '' ) );
						$cat_rows[$count]['link'] = $sef_href;
						$cat_rows[$count]['cat_id'] = $row->cat_id;
						$cat_rows[$count]['cat_name'] = stripslashes( $row->cat_name );
						$cat_rows[$count]['description'] = stripslashes( $row->description );

						$all_events += $total_events;
						$total_cats ++;
						$count ++;
					}
				}
			}
			$stat_string = sprintf( $lang_cats_view['stats_string'], $all_events, $total_cats );

			theme_cats_list( $cat_rows, $stat_string );
		}
		if ( $CONFIG_EXT['search_view'] ) extcal_search();
	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_cats_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function print_cat_content( $cat_id ) {
	// function to display events under a specific category
	global $CONFIG_EXT, $today, $lang_cat_events_view, $lang_system, $next_recurrence_stamp;
	global $lang_general, $lang_date_format;
	global $option, $Itemid_Querystring;
	global $cat_list, $cal_id, $cal_list;

	$db =& JFactory::getDBO();
	$cat_ext = JRequest::getCmd( 'cat_ext' );

	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );

	if ( ( $CONFIG_EXT['cats_view'] || has_priv( 'add' ) ) AND ( $cat_ext || has_priv ( 'category' . $cat_id ) ) ) //  enabled or not ?
	{

		// are we printing ?
		$isPrint = JRequest::getInt( 'print', 0 ) == 1;

		// add rss feeds link
		if ( $isPrint ) {
			$feedsLink = $CONFIG_EXT['enable_feeds'] ?
			JRoute::_( $CONFIG_EXT['calendar_calling_page']. '&view=feeds&format=feed&cat_id='.$cat_id ) : '';
			// insert rss feeds link in head if allowed
			jclInsertFeedsLinks( $feedsLink );
		}

		// check requested cat_id is within the current page authorized cat list ( from menu item parameter )
		/*if ( !empty( $cat_list ) ) {
			$list = explode( ',', $cat_list );
			if ( !empty( $list ) ) {
				foreach( $list as $key => $listItem ) {
					$list[$key] = intval( $listItem );
				}
				if ( !in_array( $cat_id, $list ) ) {
					$cat_id = '';
				}
			}
		}*/

		if ( $cat_ext == 'illbethere' ) {
			list( $event_rows, $cat_info ) = getEventsIllbethere( $cat_id );
		} else if ( $cat_ext == 'community' ) {
			$getsubs = ( $pageParams->get( 'cat_subs_community', '' ) === '1' || ( $pageParams->get( 'cat_subs_community', '' ) !== '0' && $CONFIG_EXT['cat_subs_community'] ) );
			list( $event_rows, $cat_info ) = getEventsCommunity( $cat_id, $getsubs );
		} else {
			list( $event_rows, $cat_info ) = getEvents( $cat_id );
		}

		ksort( $event_rows );
		$event_rows = array_values($event_rows);
		$stats['total_events'] = is_array( $event_rows ) ? count( $event_rows ) : 0;

		// check if request is for iCal response, and if yes, process it
		// if this is an ical request, we won't return from this function call
		$filename = 'cat_' . $cat_id;
		$eventList = null;
		$format = JRequest::getVar( 'format', 'html' );
		if ( $format == 'ical' && $total_events ) {
			// pre-process events, to match format of other views
			foreach( $rows as $event ) {
				$eventList[] = $event;
			}
		}
		jclProcessICalRequest( $filename, null, null, $eventList );

		theme_cat_events_list( $event_rows, $cat_info, $stats );

		if ( $CONFIG_EXT['search_view'] ) extcal_search();

	} else {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		theme_redirect_dialog( $lang_cats_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href );
	}
	jclSetPageMetadata();
}

function getEvents( $cat_id ) {
	global $CONFIG_EXT, $today;
	global $cat_list, $cal_id, $cal_list;
	global $Itemid_Querystring;
	
	$mainframe =& JFactory::getApplication();
	$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );

	$db =& JFactory::getDBO();
	$cat_info = get_cat_info( $cat_id );
	$cat_ext = JRequest::getCmd( 'cat_ext' );
	if ( !$cat_info ) {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&extmode=cats" );
		theme_redirect_dialog( $lang_system['system_caption'], $lang_system['non_exist_cat'], $lang_general['back'], $sef_href );
	} else {
		// apply calendar restrictions
		if ( !empty( $cal_id ) ) {
			$calendarQuery = " AND cal_id = ".$db->Quote( $cal_id ) . ' ';
		} else if ( !empty( $cal_list ) ) {
			// if not a specific cal requested, apply calendars list restrictions
			$calendarQuery = " AND cal_id IN ( " . $cal_list . " ) ";
		}

		// find time constraints
		$date_stamp = @$CONFIG_EXT['archive'] ? JCL_DATE_MIN : jcUserTimeToUTC( 0,0,0,$today['month'],$today['day'],$today['year'] );  // we must use server time, not UTC
		$dateStampOfLastDay = JCL_DATE_MAX;

		// Require the events model, and instantiate it
		require_once( JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'models'.DS.'events.php' );
		$model =& JModel::getInstance( 'events', 'JcalproModel' );

		// then inject those params into the model
		$properties = array(
				'showRecurringEvents' => $CONFIG_EXT['show_recurrent_events'],
				'catId' => $cat_id,
				'catExt' => $cat_ext,
				'calId' => $cal_id,
				'calList' => $cal_list,
				'maxNumberOfEvents' => PHP_INT_MAX, // no limit on number of events
				'lastUpdated' => false
		);

		$model->injectProperties( $properties );
		// ask the model for events
		$rows = $model->getEvents( $date_stamp, $dateStampOfLastDay, $dispatchByDay = false );
	}

	// count the returned data set
	$total_events = is_array( $rows ) ? count( $rows ) : 0;
	$event_rows = array();

	if ( $total_events ) {
		$count = 0;
		foreach( $rows as $rawRow ) {
			$row = $rawRow[3];
			$r = array();
			$r['date'] = mf_process_category_date( $row );
			
			$href = 'com_jcalpro' . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$row->extid;
			if ( isset( $row->cat_ext ) && $row->cat_ext == 'illbethere' ) {
				$href = "com_illbethere&controller=events&task=view&id=".$row->extid . getIllBeThereItemid();
			} else if ( isset( $row->cat_ext ) && $row->cat_ext == 'community' ) {
				$href = "com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$row->extid . getJomSocialItemid();
			}
			$href = JRoute::_( 'index.php?option=' . $href . (@$CONFIG_EXT['popup_event_mode'] ? '&amp;tmpl=component' : '' ) );
			$r['link'] = "href=\"$href\"" . (@$CONFIG_EXT['popup_event_mode'] ? '" class="jcal_modal" rel="{handler: \'iframe\'}" ' : '' );
			$r['extid'] = $row->extid;
			$r['title'] = format_text( sub_string( $row->title,$CONFIG_EXT['cats_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] );
			$event_rows[$rawRow[1].'_'.$count] = $r;
			$count ++;
		}
	}
	return array( $event_rows, $cat_info );
}
function getEventsIllbethere( $cat_id ) {
	global $CONFIG_EXT, $Itemid_Querystring;

	$db =& JFactory::getDBO();
	$query = "SELECT name as cat_name, description as cat_description
		FROM #__illbethere_categories
		WHERE cat_id = ".(int) $cat_id."
		LIMIT 1";
	$db->setQuery($query);
	$cat_info = $db->loadAssoc();

	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_illbethere'.DS.'tables');
	require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_illbethere'.DS.'helpers'.DS.'syslog.php';
	require_once JPATH_ROOT.DS.'components'.DS.'com_illbethere'.DS.'models'.DS.'events.php';

	$model = new IllBeThereModelEvents;
	$ext_rows = $model->getData();
	$rows = array();
	foreach ( $ext_rows as $i => $row ) {
		$row->extid = $row->session_id;
		$row->start_date = $row->session_up;
		$row->end_date = null;
		$rows[] = array( $row->extid, jcUTCDateToTs($row->start_date), jcUTCDateToTs($row->end_date), $row );

	}
	// count the returned data set
	$total_events = is_array( $rows ) ? count( $rows ) : 0;
	$event_rows = array();

	if ( $total_events ) {
		$count = 0;
		foreach( $rows as $rawRow ) {
			$row = $rawRow[3];
			$r = array();
			$r['date'] = mf_process_category_date( $row );
			if ( $CONFIG_EXT['popup_event_mode'] ) {
				$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$row->extid . '&amp;tmpl=component'.getIllBeThereItemid();
				$r['link'] = 'href="' . $non_sef_href . '" class="jcal_modal" rel="{handler: \'iframe\'}" ';
			} else {
				$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$row->extid . getIllBeThereItemid() );
				$r['link'] = "href='$sef_href'";
			}
			$r['extid'] = $row->extid;
			$r['title'] = format_text( sub_string( $row->title,$CONFIG_EXT['cats_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] );
			$event_rows[$rawRow[1].'_'.$count.'_c'] = $r;
			$count ++;
		}
	}
	return array( $event_rows, $cat_info );
}

function getEventsCommunity( $cat_id, $getsubs = 0 ) {
	global $CONFIG_EXT, $Itemid_Querystring;
	
	$db =& JFactory::getDBO();
	$query = "SELECT name as cat_name, description as cat_description
		FROM #__community_events_category
		WHERE id = ".(int) $cat_id."
		LIMIT 1";
	$db->setQuery($query);
	$cat_info = $db->loadAssoc();

	require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';
	require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'events.php';

	$model = new CommunityModelEvents;
	$ext_rows = $model->getEvents( $cat_id );
	$rows = array();
	foreach ( $ext_rows as $i => $row ) {
		$row->extid = $row->id;
		$row->start_date = $row->startdate;
		$row->end_date = $row->enddate;
		$rows[] = array( $row->extid, jcUTCDateToTs($row->start_date), jcUTCDateToTs($row->end_date), $row );

	}

	if ( $getsubs ) {
		$subcats = get_community_subcats( $cat_id );
		foreach ( $subcats as $subcat ) {
			$subcat_rows = $model->getEvents( $subcat->id );
			foreach ( $subcat_rows as $i => $row ) {
				if ( $CONFIG_EXT['popup_event_mode'] ) {
					$non_sef_href = "index.php?option=com_jcalpro&amp;extmode=cat&amp;cat_id=".$subcat->id . '&amp;cat_ext=community&amp;tmpl=component'.getJomSocialItemid();
					$link = 'href="' . $non_sef_href . '" class="jcal_modal" rel="{handler: \'iframe\'}" ';
				} else {
					$sef_href = JRoute::_( "index.php?option=com_jcalpro&amp;extmode=cat&amp;cat_id=".$subcat->id . '&amp;cat_ext=community'.getJomSocialItemid() );
					$link = "href='$sef_href'";
				}
				$row->title .= '</a> <a '.$link.'>('.$subcat->name.')';
				$row->extid = $row->id;
				$row->start_date = $row->startdate;
				$row->end_date = $row->enddate;
				$rows[] = array( $row->extid, jcUTCDateToTs($row->start_date), jcUTCDateToTs($row->end_date), $row );

			}
		}
	}

	// count the returned data set
	$total_events = is_array( $rows ) ? count( $rows ) : 0;
	$event_rows = array();

	if ( $total_events ) {
		$count = 0;
		foreach( $rows as $rawRow ) {
			$row = $rawRow[3];
			$r = array();
			$r['date'] = mf_process_category_date( $row );
			if ( $CONFIG_EXT['popup_event_mode'] ) {
				$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$row->extid . '&amp;tmpl=component'.getJomSocialItemid();
				$r['link'] = 'href="' . $non_sef_href . '" class="jcal_modal" rel="{handler: \'iframe\'}" ';
			} else {
				$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$row->extid.getJomSocialItemid() );
				$r['link'] = "href='$sef_href'";
			}
			$r['extid'] = $row->extid;
			$r['title'] = format_text( sub_string( $row->title,$CONFIG_EXT['cats_view_max_chars'],'...' ),false,$CONFIG_EXT['capitalize_event_titles'] );
			$event_rows[$rawRow[1].'_'.$count.'_i'] = $r;
			$count ++;
		}
	}
	return array( $event_rows, $cat_info );
}

function get_community_subcats( $cat_id  ) {
	require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php';
	require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'events.php';

	$model = new CommunityModelEvents;

	$subcats = $model->getCategories( CEventHelper::ALL_TYPES, $cat_id );
	foreach ( $subcats as $subcat ) {
		$subsubcats = $model->getCategories( CEventHelper::ALL_TYPES, $subcat->id );
		if ( !empty( $subsubcats ) ) {
			$subcats = array_merge( $subcats, get_community_subcats( $subcat->id ) );
		}
	}
	return $subcats;
}


/**
	* Echoes the content of the minical. Used for ajax updates
	*
	*/
function print_minical() {

	// fetch the module parameters
	$moduleId = JRequest::getString( 'minical_id', 0 );
	if ( $moduleId == 'cbjcalprominical' ) {
		// calling from CB plugin, need to get params from CB
		$db =& JFactory::getDBO();
		$query = 'SELECT params FROM `#__comprofiler_plugin` WHERE element = ' . $db->Quote( 'cbjcalprominical' );
		$db->setQuery( $query );
		$rawParams = $db->loadResult();
		$params = new JParameter( $rawParams );
	} else if ( $moduleId == 'jsjcalprominical' ) {
		// calling from joomsocial plugin, need to get params from js
		$db =& JFactory::getDBO();
		$query = 'SELECT params FROM `#__plugins` WHERE element = ' . $db->Quote( 'jsjcalprominical' );
		$db->setQuery( $query );
		$rawParams = $db->loadResult();
		$params = new JParameter( $rawParams );
	} else {
		// sanitize
		$moduleId = intval( $moduleId );
		// normal call, from main page : get params from module
		jimport( 'joomla.application.module.helper' );
		$mod = jclGetModuleById( $moduleId );
		if ( $mod->name != 'jcalpro_minical_J15' ) {
			return;
		}
		$params = new JParameter( $mod->params );
	}


	// include the required code
	if( is_readable( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'minical.inc.php' ) ) {
		include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'minical.inc.php' );
	} else {
		// don't do anything
		return;
	}

	// get the module output
	$moduleContent = jclMinical( $params, $moduleId );

	// echo it
	echo $moduleContent;

}

