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

 $Id: admin_events.php 684 2011-02-04 17:02:35Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $today, $lang_add_event_view, $extmode, $errors, $lang_settings_data, $mainframe, $show_main_menu;

if (!defined('ADMIN_EVENTS_PHP')) {
	define('ADMIN_EVENTS_PHP', true);
	include $CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php";
}

if(!empty($event_mode)) {

	switch($event_mode) {
		case 'add':
			// process cancellation
			admin_event_cancel();
			// we can't re-display the same page, if user is not allowed to view it,
			// as this would cause an infinite loop
			$redirectToIfNotAuth = str_replace( '&extmode=event', '', $CONFIG_EXT['calendar_calling_page']);
			$redirectToIfNotAuth = str_replace( '&event_mod=add', '', $redirectToIfNotAuth) . '&view=calendar';
			// process if not cancelled
			if (require_priv('add', $redirectToIfNotAuth)) {
				$event_mode = 'view';
				$show_main_menu = false;
				jcPageHeader($lang_event_admin_data['add_event'] . " :: " . $lang_event_admin_data['section_title']);
				print_admin_add_event_form($date);
			}
			break;

		case 'edit':
			// process cancellation
			admin_event_cancel();
			// process if not cancelled
			if(!empty($extid) && require_priv('edit')) {
				$event_mode = 'view';
				$show_main_menu = false;
				jcPageHeader($lang_event_admin_data['edit_event'] . " :: " . $lang_event_admin_data['section_title']);
				print_edit_event_form($extid);
			} else if (has_priv('Administrator')) {
				jcPageHeader($lang_event_admin_data['section_title']);
				print_event_list();
			}
			break;

		case 'view' :
			if(!empty($extid) && require_priv('approve'))  {
				jcPageHeader($lang_event_admin_data['view_event'] . " :: " . $lang_event_admin_data['section_title']);
				print_event_view($extid);
			} else if (has_priv('approve')) {
				jcPageHeader($lang_event_admin_data['section_title']);
				print_event_list();
			}
			break;

		case 'del' :
			// process cancellation
			admin_event_cancel();
			// process if not cancelled
			if( !empty($extid) && require_priv('delete') ) {
				$event_mode = 'view';
				jcPageHeader($lang_event_admin_data['delete_event'] . " :: " . $lang_event_admin_data['section_title']);
				delete_event($extid);
			} else if (has_priv('Administrator')) {
				jcPageHeader($lang_event_admin_data['section_title']);
				print_event_list();
			}
			break;

		case 'apr' :
			if(!empty($extid) && require_priv('approve')) {
				$event_mode = 'view';
				jcPageHeader($lang_event_admin_data['approve_event'] . " :: " . $lang_event_admin_data['section_title']);
				approve_event($extid);
			} else if (has_priv('Administrator')) {
				jcPageHeader($lang_event_admin_data['section_title']);
				print_event_list();
			}
			break;

		default:
			if (require_priv('add')) {
				$event_mode = 'view';
				jcPageHeader($lang_event_admin_data['section_title']);
				print_event_list();
			}
			else $event_mode = '';
			break;
	}


} else {
	if (require_priv('add')) {
		jcPageHeader($lang_event_admin_data['section_title']);
		print_event_list();
	}
}

// Functions

/**
 * Process cancellation from an add, delete or edit form
 *
 */
function admin_event_cancel() {

	$fromAdd = JRequest::getCmd( 'cancel_add_event');
	$fromDel = JRequest::getCmd( 'cancel_del_event');
	$fromEdit = JRequest::getCmd( 'cancel_edit_event');

	if (!empty( $fromAdd) || !empty( $fromDel) || !empty( $fromEdit)) {
		// user did cancel one of these actions
		//$return_to = JRequest::getString( 'return_to');
		$returnTo = jclGetCookie( 'return_to');
		if (!empty( $returnTo)) {
			// redirect to cancel target
			jc_shRedirect( str_replace( '&amp;', '&', JRoute::_($returnTo)));
		}
	}
}

function print_admin_add_event_form($date = '') {
	// function to display events under a specific category
	global $CONFIG_EXT, $today, $lang_add_event_view, $lang_system, $mainframe;
	global $lang_general, $extmode, $errors, $lang_settings_data, $lang_date_format;

	$db = &JFactory::getDBO();

	if (($CONFIG_EXT['add_event_view'] || has_priv('add')) && require_priv('add')) { // enabled or not ?
		$successful = false;

		// get possible POSTed values
		if(count($_POST)) {
			foreach( $_POST as $postKey => $postValue) {
				if ($postKey == 'description' && $CONFIG_EXT['addevent_allow_html']) {
					$form[$postKey] = JRequest::getVar( $postKey, null, 'POST', 'STRING', JREQUEST_ALLOWRAW);
				} else {
					$form[$postKey] = JRequest::getVar( $postKey, null, 'POST');
				}
			}
		}

		// Check date. if no date is passed as argument, then we pick today
		if (empty($date)) {
			$day = $today['day'];  // warning these have timezone offset in them, not suitable
			$month = $today['month'];  // for writing to DB, which must have UTC times
			$year = $today['year'];
		} else {
			$day = $date['day'];
			$month = $date['month'];
			$year = $date['year'];
		}

		// check if "show past events" is enabled, else force the date to today's date
		// note : $today has timezone offset
		if(mktime(0,0,0,$month,$day,$year) < mktime(0,0,0,$today['month'],1,$today['year']) && !$CONFIG_EXT['archive']) {
			$day = $today['day'];
			$month = $today['month'];
			$year = $today['year'];
		}

		$day = isset($form['day'])?$form['day']:$day;
		$month = isset($form['month'])?$form['month']:$month;
		$year = isset($form['year'])?$form['year']:$year;

		if (isset($form['title'])) $title = $form['title']; else $title = '';
		if (isset($form['description'])) $description = $form['description']; else $description = '';
		if (isset($form['contact'])) $contact = $form['contact']; else $contact = '';
		if (isset($form['email'])) $email = $form['email']; else $email = '';
		if (isset($form['url'])) $url = $form['url']; else $url = '';
		if (isset($form['cat']) && intval($form['cat'])>0) $cat = $form['cat']; else $cat = '';
		if (isset($form['cal_id']) && intval($form['cal_id'])>0) $cal_id = $form['cal_id']; else $cal_id = $CONFIG_EXT['default_calendar'];

		// Clean description

		if ( !$CONFIG_EXT['addevent_allow_html'] ) {
			$description = strip_tags ( $description );
			$description = preg_replace("'<script[^>]*?>.*?</script>'si", "", $description);
			$description = preg_replace("'<head[^>]*?>.*?</head>'si", "", $description);
			$description = preg_replace("'<body[^>]*?>.*?</body>'si", "", $description);
			$description = str_replace('&','&amp;',$description);
		}

		$description = preg_replace( '#<[\s]*meta#isU', '', $description);
		
		$description = html_entity_decode($description, ENT_COMPAT, 'UTF-8');


		if(!empty($form)) {
			// Process user submission

			// Form Validation
			$errors = '';

			// check captcha
			if ($CONFIG_EXT['enable_recaptcha'] && !has_priv('bypass_captcha')) {
				JPluginHelper::importplugin( 'jcalpro', 'jclrecaptcha');
				$captchaOk = plgJcalproJclRecaptcha::confirm( $form['recaptcha_challenge_field'], $form['recaptcha_response_field']);
				if (!$captchaOk) {
					$errors .= theme_error_string( 'Invalid captcha');
				}
			}

			if (empty($title)) $errors .=  theme_error_string($lang_add_event_view['no_title']);
			if (empty($cat)) $errors .= theme_error_string($lang_add_event_view['no_cat']);
			if (empty($cal_id)) $errors .= theme_error_string($lang_add_event_view['no_calendar']);
			if (empty($day) || empty($month) || empty($year) || !checkdate($month,$day,$year)) $errors .= theme_error_string($lang_add_event_view['date_invalid']);

			// no end date for repeat event not allowed any more see bug tracker #10594
			if ($form['rec_type_select'] == JCL_REC_TYPE_NONE && $form['recur_end_type'] == JCL_RECUR_NO_LIMIT) {
				$errors .= theme_error_string($lang_add_event_view['no_recur_end_date']);
			}

			// get repeat until date, extract elements and check them
			$rec_recur_until = jclExtractDetailsFromDate( $form['rec_recur_until'], $lang_date_format['date_entry']);
			if (!$rec_recur_until) {
				if ($form['recur_end_type'] == JCL_RECUR_UNTIL_A_DATE) {
					// if we are supposed to use this date, declare an error
					$errors .= theme_error_string($lang_add_event_view['recur_end_until_invalid']);
				}
			}

			if ($form['duration_type'] == '1') {
				$form['end_days'] = empty($form['end_days'])?'0':$form['end_days'];
				$form['end_hours'] = empty($form['end_hours'])?'0':$form['end_hours'];
				$form['end_minutes'] = empty($form['end_minutes'])?'0':$form['end_minutes'];
				if (!is_numeric($form['end_days'])) { $errors .= theme_error_string($lang_add_event_view['end_days_invalid']); }
				if (!is_numeric($form['end_hours'])) { $errors .= theme_error_string($lang_add_event_view['end_hours_invalid']); }
				if (!is_numeric($form['end_minutes'])) { $errors .= theme_error_string($lang_add_event_view['end_minutes_invalid']); }
			}

			// check recurrence information
			switch((int)$form['rec_type_select']) {
				case JCL_REC_TYPE_DAILY:
					if (!is_numeric($form['rec_daily_period']) || (int)$form['rec_daily_period'] < 1) { $errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']); }
					break;
				case JCL_REC_TYPE_WEEKLY:
					if (!is_numeric($form['rec_weekly_period']) || (int)$form['rec_weekly_period'] < 1) { $errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']); }
					break;
				case JCL_REC_TYPE_MONTHLY:
					if (!is_numeric($form['rec_monthly_period']) || (int)$form['rec_monthly_period'] < 1) { $errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']); }
					break;
				case JCL_REC_TYPE_YEARLY:
					if (!is_numeric($form['rec_yearly_period']) || (int)$form['rec_yearly_period'] < 1) { $errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']); }
					break;
				case JCL_REC_TYPE_NONE:
				default:
					break;
			}
			switch((int)$form['recur_end_type']) {
				case 0:
					break;
				case JCL_RECUR_SO_MANY_OCCURENCES:
					if (!is_numeric($form['recur_end_count']) || (int)$form['recur_end_count'] < 1) { $errors .= theme_error_string($lang_add_event_view['recur_end_count_invalid']); }
					break;
				case JCL_RECUR_UNTIL_A_DATE:
					if (mktime(0,0,0,$month,$day,$year) > mktime(0,0,0,$rec_recur_until->month,$rec_recur_until->day,$rec_recur_until->year)) {
						$errors .= theme_error_string($lang_add_event_view['recur_end_until_invalid']);
					}
					break;
				default:

			}

			if(!$errors) {

				if ( has_priv ( 'add') ) {
					$approve = ( isset ( $form['autoapprove'] ) ) ? 1 : 0;
				}

				// JCal Pro 2 : private events
				$private = empty( $form['private'] ) ? JCL_EVENT_PUBLIC : intval($form['private']);

				// now always 24 hours mode
				$start_time_hour = $form['start_time_hour']; // 24 hours mode

				// convert from user time to UTC time, for db storage
				$startTs = gmmktime($start_time_hour, $form['start_time_minute'], 0, $month, $day, $year);
				$dst = jclGetDst( $startTs);
				$start_date = TSUTCToUser( $startTs, $dst);
				$start_date = jcUTCDateToFormatNoOffset( $start_date, '%Y-%m-%d %H:%M:%S'); // find timestamp based on interpreting input data as user tim

				// Here is where we deal with what kind of duration to use. If a duration is specified, we calculate the end_date to enter into the database.
				// If not, we enter a special end_date instead.

				if ($form['duration_type'] == '1') { // This is a normal event, with a SPECIFIED duration
					$ts = $startTs + 86400 * intval($form['end_days']) + 3600 * intval($form['end_hours']) + 60 * $form['end_minutes'];
					$dst = jclGetDst( $ts);
					$end_date = TSUTCToUser( $ts, $dst);
					$end_date = jcUTCDateToFormatNoOffset( $end_date, '%Y-%m-%d %H:%M:%S');
				} else if ($form['duration_type'] == '2') {
					$end_date = JCL_ALL_DAY_EVENT_END_DATE;
				} else { // This is an event where "No end date" was checked instead
					$end_date = JCL_EVENT_NO_END_DATE;
				}

				// Set recurrence information

				// type of recurrence
				$form['rec_type_select'] = (int)$form['rec_type_select'];

				// Determine the recur_until value by doing actual calculation if necessary. If the recur type
				// is "recur x number of times" then we calculate the end date.
				if ( $form['recur_end_type'] == JCL_RECUR_NO_LIMIT || $form['rec_type_select'] == JCL_REC_TYPE_NONE )  {
					$recur_until = JString::substr($start_date,0,10);
				}
				else if ( $form['recur_end_type'] == JCL_RECUR_UNTIL_A_DATE ) {
					// user has selected an end date from the calendar
					$ts = gmmktime( $start_time_hour, $form['start_time_minute'], 0, $rec_recur_until->month, $rec_recur_until->day, $rec_recur_until->year);
					$dst = jclGetDst( $ts);
					$recur_until = jcUTCDateToFormatNoOffset( TSUTCToUser( $ts, $dst), '%Y-%m-%d %H:%M:%S');
				} else {
					// user has set to repeat a number of times : $form['recur_end_type'] == JCL_RECUR_SO_MANY_OCCURENCES
					switch ( $form['rec_type_select'] ) {
						case JCL_REC_TYPE_DAILY:
							$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day+($form['rec_daily_period']*$form['recur_end_count']-1),$year);
							$dst = jclGetDst( $ts);
							$enddatestamp = TSUTCToUser( $ts, $dst);
							break;
						case JCL_REC_TYPE_WEEKLY:
							$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day+($form['rec_weekly_period']*$form['recur_end_count']*6),$year);
							$dst = jclGetDst( $ts);
							$enddatestamp = TSUTCToUser( $ts, $dst);
							break;
						case JCL_REC_TYPE_MONTHLY:
							$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month+($form['rec_monthly_period']*$form['recur_end_count']-1),$day,$year);
							$dst = jclGetDst( $ts);
							$enddatestamp = TSUTCToUser( $ts, $dst);
							break;
						case JCL_REC_TYPE_YEARLY:
							$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day,$year+($form['rec_yearly_period']*$form['recur_end_count']-1));
							$dst = jclGetDst( $ts);
							$enddatestamp = TSUTCToUser( $ts, $dst);
							break;
						default:
							break;
					}
					$recur_until = jcUTCDateToFormatNoOffset( $enddatestamp, '%Y-%m-%d %H:%M:%S');
				}

				// other parameters
				$registration_url = '';
				$published = 1;

				// readjust day, month, year to the UTC values
				$startDateTS = jcUTCDateToTs( $start_date);
				$day = jcUTCDateToFormatNoOffset( $startDateTS, '%d');
				$month = jcUTCDateToFormatNoOffset( $startDateTS, '%m');
				$year = jcUTCDateToFormatNoOffset( $startDateTS, '%Y');

				// first check that start_date is first recurrence of a series (for recurring events only)
				// this can only be done very late in the process, as the event data must be complete before checking
				$checkOnly = true;
				$successful = createEvent( $cal_id, $form['owner_id'], $title, $description, $contact, $url, $registration_url, $email, $picture, $cat, $day, $month, $year, $approve, $private, $start_date,
				$end_date, $published, $form['recur_end_type'], $form['recur_end_count'], $recur_until, $form, $rec_id = 0, $detached_from_rec = 0, $checkOnly);

				if ($successful) {
					// call function to store event data in database, and create all recurring children events if needed
					$successful = createEvent( $cal_id, $form['owner_id'], $title, $description, $contact, $url, $registration_url, $email, $picture, $cat, $day, $month, $year, $approve, $private, $start_date,
					$end_date, $published, $form['recur_end_type'], $form['recur_end_count'], $recur_until, $form);

					if ($successful && !$approve && !has_priv("approve")) {
						if ($CONFIG_EXT['new_post_notification']) {
							// send email notification
							if ($end_date == JCL_EVENT_NO_END_DATE) { // This is an event with NO duration specified or an all day event
								$durationString = '';
							} else if (jclIsAllDay( $end_date)) { // This is an event with NO duration specified. Zero the duration fields.
								$durationString = EXTCAL_TEXT_ALL_DAY;
								$start_date = JString::substr( $start_date, 0, 10);
							} else {
								$duration_array = datestoduration ($start_date,$end_date);
								$days_string = $duration_array['days']?$duration_array['days']." ".$lang_general['day']. " ":'';
								$days_string = $duration_array['days']>1?$duration_array['days']." ".$lang_general['days']. " ":$days_string;
								$hours_string = $duration_array['hours']?$duration_array['hours']." ".$lang_general['hour']. " ":'';
								$hours_string = $duration_array['hours']>1?$duration_array['hours']." ".$lang_general['hours']. " ":$hours_string;
								$minutes_string = $duration_array['minutes']?$duration_array['minutes']." ".$lang_general['minute']:'';
								$minutes_string = $duration_array['minutes']>1?$duration_array['minutes']." ".$lang_general['minutes']:$minutes_string;
								$durationString = $days_string . $hours_string . $minutes_string;
							}

							// create an instance of the mail class
							$mail =& JFactory::getMailer();

							// Now you only need to add the necessary stuff
							$mail->AddRecipient($CONFIG_EXT['calendar_admin_email'], " ");
							$mail->setSubject(sprintf($lang_system['new_event_subject'], $CONFIG_EXT['app_name']));

							$sef_href = JRoute::_( JURI::base() .$CONFIG_EXT['calendar_calling_page']
							.'&extmode=event&event_mode=view&extid=' . $db->insertid() );
							$event_link = str_replace( '&amp;', '&', $sef_href);
							$template_vars = array(
								'{CALENDAR_NAME}' => $CONFIG_EXT['app_name'],
								'{TITLE}' => $title,
								'{DATE}' => $start_date,
								'{DURATION}' => $durationString,
								'{LINK}' => $event_link
							);

							$mail->setBody (strtr($lang_system['event_notification_body'], $template_vars));

							if(!$mail->Send() && $CONFIG_EXT['debug_mode'])
							{
								// An error occurred while trying to send the email
								$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
								theme_redirect_dialog($lang_system['system_caption'], $lang_system['event_notification_failed'], $lang_general['back'], $sef_href);
								pagefooter();
								exit;
							}
						}
					}
					/*$returnTo = JRequest::getString( 'return_to');
					if (!empty( $returnTo)) {
					$sef_href = JRoute::_( str_replace( '&amp;', '&', base64_decode( $returnTo)));
					} else {
					$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
					}*/
					$returnTo = jclGetCookie( 'return_to');
					if (!empty( $returnTo)) {
						$sef_href = JRoute::_( str_replace( '&amp;', '&', $returnTo));
					} else {
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
					}
					$link = JRoute::_($CONFIG_EXT['calendar_calling_page'] . '&extmode=view&extid=' . $db->insertid());
					// Successfull message
					if ($successful) {
						if($approve)  {
							theme_redirect_dialog($lang_add_event_view['section_title'], sprintf( $lang_add_event_view['submit_event_approved'], $link), '', $sef_href);
						} else {
							theme_redirect_dialog($lang_add_event_view['section_title'], $lang_add_event_view['submit_event_pending'], '', $sef_href);
						}
					}else {
						// error writing to db
						jc_shRedirect( $sef_href, $lang_add_event_view['failed_event_creation'], null, 'error');
					}
				} else {
					// recurrence is not valid. We must redisplay the form with an error message
					$errors .= theme_error_string($lang_add_event_view['recur_start_date_invalid']);
				}
			}
		} else {
			// No HTTP post or get requests found. THESE ARE THE DEFAULT VALUES FOR ADDING NEW EVENTS:
			$form['autoapprove'] = true;
			$form['end_days'] = '0';
			$form['end_hours'] = '1';
			$form['end_minutes'] = '0';
			$form['start_time_hour'] = '8';
			$form['start_time_minute'] = '0';
			$form['start_time_ampm'] = 'am';
			$form['day'] = $day;
			$form['month'] = $month;
			$form['year'] = $year;
			$form['cat'] = 1;
			$form['cal_id'] = $CONFIG_EXT['default_calendar'];
			$user = &JFactory::getUser();
			$form['owner_id'] = $user->guest ? JCL_DEFAULT_OWNER_ID : $user->id;
			$form['private'] = JCL_EVENT_PUBLIC;
			// initial values for recurrence
			$form['recur_end_type'] = JCL_RECUR_SO_MANY_OCCURENCES;
			$form['recur_end_count'] = '2';
			$form['duration_type'] = '1';

			// V 2.1.x : new recurrence type options
			// general
			$form['rec_type_select'] = JCL_REC_TYPE_NONE;

			// daily
			$form['rec_daily_period'] = 1;

			// weekly
			$form['rec_weekly_period'] = 1;
			$form['rec_weekly_on_monday'] = 0;
			$form['rec_weekly_on_tuesday'] = 0;
			$form['rec_weekly_on_wednesday'] = 0;
			$form['rec_weekly_on_thursday'] = 0;
			$form['rec_weekly_on_friday'] = 0;
			$form['rec_weekly_on_saturday'] = 0;
			$form['rec_weekly_on_sunday'] = 0;

			// monthly
			$form['rec_monthly_period'] = 1;
			$form['rec_monthly_type'] = JCL_REC_ON_DAY_NUMBER;
			$form['rec_monthly_day_number'] = 1;
			$form['rec_monthly_day_list'] = '';
			$form['rec_monthly_day_order'] = JCL_REC_FIRST;
			$form['rec_monthly_day_type'] = JCL_REC_DAY_TYPE_DAY;

			// yearly
			$form['rec_yearly_period'] = 1;
			$form['rec_yearly_on_month'] = JCL_REC_JANUARY;
			$form['rec_yearly_on_month_list'] = '';
			$form['rec_yearly_type'] = JCL_REC_ON_DAY_NUMBER;
			$form['rec_yearly_day_number'] = 1;
			$form['rec_yearly_day_order'] = JCL_REC_FIRST;
			$form['rec_yearly_day_type'] = JCL_REC_DAY_TYPE_DAY;

			// end date
			$form['rec_recur_until'] = jcServerDateToFormat( extcal_get_local_time(), $lang_date_format['date_entry']);

		}

		// Render the form
		/*if(!$successful) {
		$returnTo = JRequest::getString( 'return_to');
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&extmode=event&event_mode=add' . (empty( $returnTo) ? '' : '&return_to=' . $returnTo) );
		display_event_form($sef_href,'event',$form,'add');
		}*/
		if(!$successful) {
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&extmode=event&event_mode=add' );
			display_event_form($sef_href,'event',$form,'add');
		}
	} else if (require_priv('add')) {
		//$returnTo = JRequest::getString( 'return_to');
		$returnTo = jclGetCookie( 'return_to');
		if (!empty( $returnTo)) {
			//$sef_href = JRoute::_( str_replace( '&amp;', '&', base64_decode( $returnTo)));
			$sef_href = JRoute::_( str_replace( '&amp;', '&', $returnTo));
		} else {
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
		}
		theme_redirect_dialog($lang_add_event_view['section_title'], $lang_system['section_disabled'], $lang_general['back'], $sef_href);
	}
}

function print_edit_event_form($eventid) {
	/* print a blank owner form so we can add a new owner */

	global $CONFIG_EXT, $my, $zone_stamp, $errors, $lang_event_admin_data, $lang_general, $lang_add_event_view, $lang_system, $lang_settings_data, $lang_date_format;

	$db = & JFactory::getDBO();

	if(count($_POST)) {
		foreach( $_POST as $postKey => $postValue) {
			if ($postKey == 'description' && $CONFIG_EXT['addevent_allow_html']) {
				$form[$postKey] = JRequest::getVar( $postKey, null, 'POST', 'STRING', JREQUEST_ALLOWRAW);
			} else {
				$form[$postKey] = JRequest::getVar( $postKey, null, 'POST');
			}
		}
	} else {
		$query = 'SELECT * FROM '.$CONFIG_EXT['TABLE_EVENTS'].' WHERE extid='. $eventid . ';';
		$db->setQuery($query);
		$form = $db->loadAssoc();
		$form['origpicture'] = $form['picture'];

		$form['autoapprove'] = 1;

		$form['start_time_hour'] = (int) jcUTCDateToFormat( $form['start_date'], '%H');
		$form['start_time_ampm'] = '';

		$form['start_time_minute'] = jcUTCDateToFormat( $form['start_date'], '%M');
		$form['day'] = jcUTCDateToFormat( $form['start_date'], '%d');
		$form['month'] = jcUTCDateToFormat( $form['start_date'], '%m');
		$form['year'] = jcUTCDateToFormat( $form['start_date'], '%Y');

		if ( jclIsNoEndDate( $form['end_date']) || jclIsAllDay( $form['end_date']) ) { // This is an event with NO duration specified. Zero the duration fields.
			$form['duration_type'] = jclIsAllDay( $form['end_date']) ? 2:0; // This sets which radio button ('duration_type') to check by reading the last digit of the end_date
			$form['end_days'] = '0';
			$form['end_hours'] = '0';
			$form['end_minutes'] = '0';
		} else {
			$duration_array = datestoduration ($form['start_date'],$form['end_date']);

			$form['end_days'] = $duration_array['days'];
			$form['end_hours'] = $duration_array['hours'];
			$form['end_minutes'] = $duration_array['minutes'];
			$form['duration_type'] = 1;
		}

		// Additional Reccurrence info processing
		$form['rec_recur_until'] = jcUTCDateToFormat( $form['recur_until'], $lang_date_format['date_entry']);
		$form['recur_end_count'] = $form['recur_count'];

	}
	$successful = false;

	$day = $form['day'];
	$month = $form['month'];
	$year = $form['year'];

	if (isset($form['title'])) $title = $form['title']; else $title = '';
	if (isset($form['description'])) $description = $form['description']; else $description = '';
	if (isset($form['contact'])) $contact = $form['contact']; else $contact = '';
	if (isset($form['email'])) $email = $form['email']; else $email = '';
	if (isset($form['url'])) $url = $form['url']; else $url = '';
	if (isset($form['cat'])) $cat = $form['cat']; else $cat = '';
	if (isset($form['cal_id'])) $cal_id = $form['cal_id']; else $cal_id = $CONFIG_EXT['default_calendar'];

	$description = preg_replace( '#<[\s]*meta#isU', '', $description);
	$description = html_entity_decode($description, ENT_COMPAT, 'UTF-8');
	if(count($_POST)) {
		// Process user submission
		// Form Validation
		$errors = '';

		// check captcha
		if ($CONFIG_EXT['enable_recaptcha']  && !has_priv('bypass_captcha')) {
			JPluginHelper::importplugin( 'jcalpro', 'jclrecaptcha');
			$captchaOk = plgJcalproJclRecaptcha::confirm( $form['recaptcha_challenge_field'], $form['recaptcha_response_field']);
			if (!$captchaOk) {
				$errors .= theme_error_string( 'Invalid captcha');
			}
		}

		$dateok = true;
		if (empty($title)) $errors .=  theme_error_string($lang_event_admin_data['no_event_name']);
		if (empty($cat)) $errors .= theme_error_string($lang_event_admin_data['no_cat']);
		if (empty($day) || empty($month) || empty($year) || !checkdate($month,$day,$year)) $errors .= theme_error_string($lang_event_admin_data['non_valid_date']);

		// no end date for repeat event not allowed any more see bug tracker #10594
		if ($form['rec_type_select'] == JCL_REC_TYPE_NONE && $form['recur_end_type'] == JCL_RECUR_NO_LIMIT) {
			$errors .= theme_error_string($lang_add_event_view['no_recur_end_date']);
		}

		// get repeat until date, extract elements and check them
		$rec_recur_until = jclExtractDetailsFromDate( $form['rec_recur_until'], $lang_date_format['date_entry']);
		if ($form['rec_type_select'] != JCL_REC_TYPE_NONE && empty( $form['rec_id'])) {
			if (empty( $form['rec_id']) && !$rec_recur_until) {
				if ($form['recur_end_type'] == JCL_RECUR_UNTIL_A_DATE) {
					// if we are supposed to use this date, declare an error
					$errors .= theme_error_string($lang_add_event_view['recur_end_until_invalid']);
				}
			}

			if ($form['duration_type'] == '1') {
				$form['end_days'] = empty($form['end_days'])?'0':$form['end_days'];
				$form['end_hours'] = empty($form['end_hours'])?'0':$form['end_hours'];
				$form['end_minutes'] = empty($form['end_minutes'])?'0':$form['end_minutes'];
				if (!is_numeric($form['end_days'])) { $errors .= theme_error_string($lang_add_event_view['end_days_invalid']); }
				if (!is_numeric($form['end_hours'])) { $errors .= theme_error_string($lang_add_event_view['end_hours_invalid']); }
				if (!is_numeric($form['end_minutes'])) { $errors .= theme_error_string($lang_add_event_view['end_minutes_invalid']); }
			}

			// check recurrence information
			switch((int)$form['rec_type_select']) {
				case JCL_REC_TYPE_DAILY:
					if (!is_numeric($form['rec_daily_period']) || (int)$form['rec_daily_period'] < 1) {
						$errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']);
					}
					break;
				case JCL_REC_TYPE_WEEKLY:
					if (!is_numeric($form['rec_weekly_period']) || (int)$form['rec_weekly_period'] < 1) {
						$errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']);
					}
					break;
				case JCL_REC_TYPE_MONTHLY:
					if (!is_numeric($form['rec_monthly_period']) || (int)$form['rec_monthly_period'] < 1) {
						$errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']);
					}
					break;
				case JCL_REC_TYPE_YEARLY:
					if (!is_numeric($form['rec_yearly_period']) || (int)$form['rec_yearly_period'] < 1) {
						$errors .= theme_error_string($lang_add_event_view['recur_val_1_invalid']);
					}
					break;
				case JCL_REC_TYPE_NONE:
				default:
					break;
			}
			switch((int)$form['recur_end_type']) {
				case 0:
					break;
				case JCL_RECUR_SO_MANY_OCCURENCES:
					if (!is_numeric($form['recur_end_count']) || (int)$form['recur_end_count'] < 1) {
					}
					break;
				case JCL_RECUR_UNTIL_A_DATE:
					if (mktime(0,0,0,$month,$day,$year) > mktime(0,0,0,$rec_recur_until->month,$rec_recur_until->day,$rec_recur_until->year)) {
						$errors .= theme_error_string($lang_add_event_view['recur_end_until_invalid']);
					}
					break;
				default:
					break;
			}
		}

		$valid_pic = false;

		$picture = '';

		// added/edited event has passed all checks, let's write it to database
		if(!$errors) {

			if ( has_priv ( "edit" ) ) {
				$approve = ( isset ( $form['autoapprove'] ) ) ? 1 : 0;
			}

			// now always 24 hours mode
			$start_time_hour = $form['start_time_hour']; // 24 hours mode

			// since build 276, we store date in db as UTC.
			//$start_date = date("Y-m-d H:i:s", mktime($start_time_hour, $form['start_time_minute'], 0, $month, $day, $year));
			$startTs = gmmktime($start_time_hour, $form['start_time_minute'], 0, $month, $day, $year);
			$dst = jclGetDst( $startTs);
			$start_date = TSUTCToUser( $startTs, $dst);
			$start_date = jcUTCDateToFormatNoOffset( $start_date, '%Y-%m-%d %H:%M:%S'); // find timestamp based on interpreting input data as user tim

			// Here is where we deal with what kind of duration to use. If a duration is specified, we calculate the end_date to enter into the database.
			// If not, we enter a special end_date instead.

			if ( $form['duration_type'] == '1' ) { // This is a normal event, with a SPECIFIED duration
				$ts = $startTs + 86400 * intval($form['end_days']) + 3600 * intval($form['end_hours']) + 60 * $form['end_minutes'];
				$dst = jclGetDst( $ts);
				$end_date = TSUTCToUser( $ts, $dst);
				$end_date = jcUTCDateToFormatNoOffset( $end_date, '%Y-%m-%d %H:%M:%S');
			} else if ( $form['duration_type'] == '2' ) { // This is an all-day event
				$end_date = JCL_ALL_DAY_EVENT_END_DATE;
			} else { // This is an event where "No end date" was checked instead
				$end_date = JCL_EVENT_NO_END_DATE;
			}

			// Set recurrence information
			$form['rec_type_select'] = (int)$form['rec_type_select'];

			// Determine the recur_until value by doing actual calculation if necessary. If the recur type
			// is "recur x number of times" then we calculate the end date.
			if ( $form['recur_end_type'] == JCL_RECUR_NO_LIMIT || $form['rec_type_select'] == JCL_REC_TYPE_NONE )  {
				$recur_until = JString::substr($start_date,0,10);
			}
			else if ( $form['recur_end_type'] == JCL_RECUR_UNTIL_A_DATE ) {
				// user has selected an end date from the calendar
				$ts = gmmktime( $start_time_hour, $form['start_time_minute'], 0, $rec_recur_until->month, $rec_recur_until->day, $rec_recur_until->year);
				$dst = jclGetDst( $ts);
				$recur_until = jcUTCDateToFormatNoOffset( TSUTCToUser( $ts, $dst), '%Y-%m-%d %H:%M:%S');
			} else {
				// user has set to repeat a number of times : $form['recur_end_type'] == JCL_RECUR_SO_MANY_OCCURENCES
				switch ( $form['rec_type_select'] ) {
					case JCL_REC_TYPE_DAILY:
						$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day+($form['rec_daily_period']*$form['recur_end_count']-1),$year);
						$dst = jclGetDst( $ts);
						$enddatestamp = TSUTCToUser( $ts, $dst);
						break;
					case JCL_REC_TYPE_WEEKLY:
						$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day+($form['rec_weekly_period']*$form['recur_end_count']*6),$year);
						$dst = jclGetDst( $ts);
						$enddatestamp = TSUTCToUser( $ts, $dst);
						break;
					case JCL_REC_TYPE_MONTHLY:
						$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month+($form['rec_monthly_period']*$form['recur_end_count']-1),$day,$year);
						$dst = jclGetDst( $ts);
						$enddatestamp = TSUTCToUser( $ts, $dst);
						break;
					case JCL_REC_TYPE_YEARLY:
						$ts = gmmktime($start_time_hour,$form['start_time_minute'],0,$month,$day,$year+($form['rec_yearly_period']*$form['recur_end_count']-1));
						$dst = jclGetDst( $ts);
						$enddatestamp = TSUTCToUser( $ts, $dst);
						break;
					default:
						break;
				}
				$recur_until = jcUTCDateToFormatNoOffset( $enddatestamp, '%Y-%m-%d %H:%M:%S');
			}

			// prepare storage
			// create a structure for easier handling
			$event = new stdClass();

			$event->cal_id = jclSetNotNull( $form['cal_id'], 0);
			$event->rec_id = jclSetNotNull( $form['rec_id'], 0);
			$event->detached_from_rec = jclSetNotNull( $form['detached_from_rec'], 0);
			$event->owner_id = jclSetNotNull( $form['owner_id'], 0);
			$event->title = $title;
			$event->description = $description;
			$event->contact = $contact;
			$event->url = $url;
			$event->registration_url = jclSetNotNull( $form['registration_url'], '');
			$event->email = $email;
			$event->picture = $picture;
			$event->cat = $cat;
			$event->day = $day;
			$event->month = $month;
			$event->year = $year;
			$event->approved = $approve;
			$event->private = jclSetNotNull( $form['private'], 0);
			$event->start_date = $start_date;
			$event->end_date = $end_date;
			$event->published = '1';
			$event->checked_out = '0';
			$event->checked_out_time = JCL_EVENT_NO_END_DATE;
			$event->recur_type = '';
			$event->recur_val = '';
			$event->recur_end_type = jclSetNotNull( $form['recur_end_type'], 0);
			$event->recur_count = jclSetNotNull( $form['recur_end_count'], 0);
			$event->recur_until = $recur_until;
			$event->extid = $form['extid'];

			// V 2.1.x
			$event->rec_type_select = jclSetNotNull( $form['rec_type_select'], 0);

			// daily
			$event->rec_daily_period = jclSetNotNull( $form['rec_daily_period'], 0);

			// weekly
			$event->rec_weekly_period = jclSetNotNull( $form['rec_weekly_period'], 0);
			$event->rec_weekly_on_monday = jclSetNotNull( $form['rec_weekly_on_monday'], 0);
			$event->rec_weekly_on_tuesday = jclSetNotNull( $form['rec_weekly_on_tuesday'], 0);
			$event->rec_weekly_on_wednesday = jclSetNotNull( $form['rec_weekly_on_wednesday'], 0);
			$event->rec_weekly_on_thursday = jclSetNotNull( $form['rec_weekly_on_thursday'], 0);
			$event->rec_weekly_on_friday = jclSetNotNull( $form['rec_weekly_on_friday'], 0);
			$event->rec_weekly_on_saturday = jclSetNotNull( $form['rec_weekly_on_saturday'], 0);
			$event->rec_weekly_on_sunday = jclSetNotNull( $form['rec_weekly_on_sunday'], 0);

			// monthly
			$event->rec_monthly_period = jclSetNotNull( $form['rec_monthly_period'], 0);
			$event->rec_monthly_type = jclSetNotNull( $form['rec_monthly_type'], 0);
			$event->rec_monthly_day_number = jclSetNotNull( $form['rec_monthly_day_number'], 0);
			$event->rec_monthly_day_list = jclSetNotNull( $form['rec_monthly_day_list'], '');
			$event->rec_monthly_day_order = jclSetNotNull( $form['rec_monthly_day_order'], 0);
			$event->rec_monthly_day_type = jclSetNotNull( $form['rec_monthly_day_type'], 0);

			// yearly
			$event->rec_yearly_period = jclSetNotNull( $form['rec_yearly_period'], 0);
			$event->rec_yearly_on_month = jclSetNotNull( $form['rec_yearly_on_month'], 0);
			$event->rec_yearly_on_month_list = jclSetNotNull( $form['rec_yearly_on_month_list'], '');
			$event->rec_yearly_type = jclSetNotNull( $form['rec_yearly_type'], 0);
			$event->rec_yearly_day_number = jclSetNotNull( $form['rec_yearly_day_number'], 0);
			$event->rec_yearly_day_order = jclSetNotNull( $form['rec_yearly_day_order'], 0);
			$event->rec_yearly_day_type = jclSetNotNull( $form['rec_yearly_day_type'], 0);

			// common id
			if (!empty($form['common_event_id'])) {
				$event->common_event_id = $form['common_event_id'];
			}

			$successful = false;
			// now update database, various cases based on what was the recurring option of
			// the event before user started editing it
			if ($form['previous_recur_type'] == JCL_REC_TYPE_NONE && $event->rec_type_select == JCL_REC_TYPE_NONE ) {
				// was non-recurrent and stays non-recurrent, only update the event
				$successful = updateExistingEvent( $event);
			} else {
				// all other cases
				if ($event->rec_id != 0 && $event->detached_from_rec != 0) {
					// child and detached event, save as if an independant event (those may not have been altered by the user, they are internal data)
					$successful = updateExistingEvent( $event);
				} else if ($event->rec_id != 0) {
					// child event, but was not detached : detach it and save (this may not have been altered by the user)
					$event->detached_from_rec = 1;
					$successful = updateExistingEvent( $event);
				} else if ($form['previous_recur_type'] != JCL_REC_TYPE_NONE){
					// was a parent recurring event, and is now either recurrent or static
					$successful = updateExistingRecurringEvent( $event);
					if (!$successful) {
						// recurrence is not valid. We must redisplay the form with an error message
						$errors .= theme_error_string($lang_add_event_view['recur_start_date_invalid']);
					}
				} else {
					// last case : was a static, and now becomes recurrent
					$successful = updateExistingStaticEventToRecurring( $event);
					if (!$successful) {
						// recurrence is not valid. We must redisplay the form with an error message
						$errors .= theme_error_string($lang_add_event_view['recur_start_date_invalid']);
					}
				}
			}

			if ($successful && !$approve && !has_priv("Administrator")) {
				if ($CONFIG_EXT['new_post_notification']) {
					// send email notification
					if ($end_date == JCL_EVENT_NO_END_DATE) { // This is an event with NO duration specified or an all day event
						$durationString = '';
					} else if (jclIsAllDay( $end_date)) { // This is an event with NO duration specified. Zero the duration fields.
						$durationString = EXTCAL_TEXT_ALL_DAY;
						$start_date = JString::substr( $start_date, 0, 10);
					} else {
						$duration_array = datestoduration ($start_date,$end_date);
						$days_string = $duration_array['days']?$duration_array['days']." ".$lang_general['day']. " ":'';
						$days_string = $duration_array['days']>1?$duration_array['days']." ".$lang_general['days']. " ":$days_string;
						$hours_string = $duration_array['hours']?$duration_array['hours']." ".$lang_general['hour']. " ":'';
						$hours_string = $duration_array['hours']>1?$duration_array['hours']." ".$lang_general['hours']. " ":$hours_string;
						$minutes_string = $duration_array['minutes']?$duration_array['minutes']." ".$lang_general['minute']:'';
						$minutes_string = $duration_array['minutes']>1?$duration_array['minutes']." ".$lang_general['minutes']:$minutes_string;
						$durationString = $days_string . $hours_string . $minutes_string;
					}

					// create an instance of the mail class
					$mail =& JFactory::getMailer();

					// Now you only need to add the necessary stuff
					$mail->AddRecipient($CONFIG_EXT['calendar_admin_email'], " ");
					$mail->setSubject( sprintf($lang_system['new_event_subject'], $CONFIG_EXT['app_name']));

					$sef_href = JRoute::_( JURI::base() . $CONFIG_EXT['calendar_calling_page']
					.'&extmode=event&event_mode=view&extid=' . $db->insertid());
					$event_link = str_replace( '&amp;', '&', $sef_href);
					$template_vars = array(
								'{CALENDAR_NAME}' => $CONFIG_EXT['app_name'],
								'{TITLE}' => $title,
								'{DATE}' => $start_date,
								'{DURATION}' => $durationString,
								'{LINK}' => $event_link
					);

					$mail->setBody( strtr($lang_system['event_notification_body'], $template_vars));

					if(!$mail->Send() && $CONFIG_EXT['debug_mode'])
					{
						// An error occurred while trying to send the email
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
						theme_redirect_dialog($lang_system['system_caption'], $lang_system['event_notification_failed'], $lang_general['back'], $sef_href);
						pagefooter();
						exit;
					}
				}
			}

			// Successfull message
			//$returnTo = JRequest::getString( 'return_to');
			$returnTo = jclGetCookie( 'return_to');
			if (!empty( $returnTo)) {
				//$redirectUrl = JRoute::_( str_replace( '&amp;', '&', base64_decode( $returnTo)));
				$redirectUrl = JRoute::_( str_replace( '&amp;', '&', $returnTo));
			} else {
				$redirectUrl = has_priv('Administrator') ? JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&extmode=event&event_mode=view' ) : JRoute::_( $CONFIG_EXT['calendar_calling_page'] );
			}
			if ( $successful && $approve ) {
				theme_redirect_dialog($lang_event_admin_data['edit_event'], sprintf( $lang_event_admin_data['edit_event_success'], $redirectUrl), $lang_general['continue'], $redirectUrl);
			} else if ($successful) {
				theme_redirect_dialog($lang_event_admin_data['edit_event'], $lang_add_event_view['submit_event_pending'], $lang_general['continue'], $redirectUrl);
			} else {
				// error writing to db
				// recurrence is not valid. We must redisplay the form with an error message
				$msg = empty($errors) ? sprintf( $lang_add_event_view['failed_existing_event_update'], $event->title, 0) : $errors;
				jc_shRedirect( $redirectUrl, $msg , null, 'error');
			}
			// to remember not to display the form again
			$successful = true;
		}
	}

	// Render the form
	if(!$successful) {
		$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&event_mode=edit' );
		display_event_form($sef_href,'event',$form,'edit');
	}


}

function approve_event($eventid) {

	global $CONFIG_EXT, $lang_event_admin_data, $lang_general;

	$db = & JFactory::getDBO();

	$query = "UPDATE ".$CONFIG_EXT['TABLE_EVENTS']." SET approved = 1 WHERE extid= '$eventid'";
	$db->setQuery( $query);
	$db->query();
	$success = $db->getAffectedRows();
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&extmode=event&event_mode=view' );
	if (!$success) {
		theme_redirect_dialog($lang_event_admin_data['approve_event'], $lang_event_admin_data['approve_event_failed'], $lang_general['back'], $sef_href);
	} else {
		theme_redirect_dialog($lang_event_admin_data['approve_event'], $lang_event_admin_data['approve_event_success'],  $lang_general['continue'], $sef_href);
	}

}

function delete_event($eventid) {

	global $CONFIG_EXT, $lang_event_admin_data, $lang_general;

	$db = & JFactory::getDBO();

	// load event details
	$event = new JCalEvent();
	$event->loadEvent($eventid);
	if (!empty( $event)) {
		// if a repeat event,
		$query = "DELETE FROM ".$CONFIG_EXT['TABLE_EVENTS']." WHERE extid= '$eventid'";
		// if a repeat event (a parent one)
		if ($event->rec_type_select != JCL_REC_TYPE_NONE && $event->rec_id == 0) {
			// delete children events
			$query .= ' OR (rec_id=\'' . $eventid . '\''
			. ($CONFIG_EXT['update_detached_with_series'] ? ')' : ' AND detached_from_rec=\'0\')');
		}
		$db->setQuery( $query);
		$db->query();
		$success = $db->getAffectedRows();
		$buttonURL = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&extmode=event&event_mode=view' );
	} else {
		$success = false;
	}
	if (!$success) {
		theme_redirect_dialog($lang_event_admin_data['delete_event'], $lang_event_admin_data['delete_event_failed'], $lang_general['back'], $buttonURL);
	} else {
		theme_redirect_dialog($lang_event_admin_data['delete_event'], $lang_event_admin_data['delete_event_success'], $lang_general['continue'], $buttonURL);
	}
}

function print_event_list() {

	global $CONFIG_EXT, $my, $zone_stamp, $lang_event_admin_data, $lang_system, $lang_date_format;

	$db = &JFactory::getDBO();

	$filter = JRequest::getInt('eventfilter', 1);
	$query = "SELECT extid,title,e.description,url,e.picture,approved,cat,cat_name,day,month,year,color,start_date, end_date,recur_type,recur_val,recur_until, c.cat_id FROM ".$CONFIG_EXT['TABLE_EVENTS']." AS e LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS c ON e.cat=c.cat_id ";
	//$today = gmdate("Ymd",$zone_stamp);
	$today = gmdate('Ymd');  // don't use global $zone_stamp, it has timezone offset in it
	switch((int)$filter) {
		case 0:
			$section_title = $lang_event_admin_data['section_title'];
			break;
		case 1:
			$query .= "WHERE approved = 0 ";
			$section_title = $lang_event_admin_data['events_to_approve'];
			break;
		case 2:
			$query .= "WHERE (DATE_FORMAT(e.start_date,'%Y%m%d') >= $today) ";
			$section_title = $lang_event_admin_data['upcoming_events'];
			break;
		case 3:
			$query .= "WHERE (DATE_FORMAT(e.end_date,'%Y%m%d') < $today) ";
			$section_title = $lang_event_admin_data['past_events'];
			break;
		default:
			$section_title = $lang_event_admin_data['section_title'];
			break;
	}

	$query .= "ORDER BY year ASC, month ASC, day ASC";

	$db->setQuery( $query);
	$rows = $db->loadObjectList();

	$num_rows = count( $rows);

	$count = 0;
	$event_results = array();

	if ($num_rows > 0) {
		foreach( $rows as $row) {
			$event_results[$count]['event_id'] = $row->extid;
			$event_results[$count]['event_title'] = format_text($row->title,false,$CONFIG_EXT['capitalize_event_titles']);

			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&extmode=event&event_mode=view&extid=".$row->extid );
			$event_results[$count]['event_link'] = $sef_href;

			$description = format_text($row->description,true,false);

			$event_results[$count]['event_desc'] = $description;

			$event_results[$count]['event_status'] = (int)$row->approved;
			$event_results[$count]['event_picture'] = empty($row->picture)?false:true;
			$event_results[$count]['event_recur_type'] = empty($row->recur_type)?false:true;

			$event_results[$count]['cat_id'] = $row->cat;
			$event_results[$count]['cat_name'] = $row->cat_name;
			$event_results[$count]['color'] = $row->color;
			$event_results[$count]['date'] = jcTSToFormat( mktime(0,0,1,$row->month,$row->day,$row->year), $lang_date_format['day_month_year']);
			$count++;
		}
	}

	theme_admin_events($event_results, $num_rows, $section_title, $filter);

}

