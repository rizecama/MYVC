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

 $Id: ical.php 714 2011-03-31 17:56:25Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * iCal import/export model
 *
 */
class JcalproModelIcal extends JModel {

	// the various parameters needed to fetch events from DB
	private $_params = null;

	// the vcalendar object being worked upon
	private $_cal = null;

	// store timezones definition found in the ics file
	private $_timezones = null;

	/**
	* Constructor set default values for some parameters
	* @return none
	*/
	public function __construct() {

		// as we actually have some events to return, require ical library
		require_once(JPATH_ROOT.DS. 'components' . DS . 'com_jcalpro' . DS .'lib'.DS.'iCalcreator.class.php');

	}

	/**
	* Inject private properties into the object
	*
	* @param properties an array holding the names/values pairs
	* @return none
	*/
	public function injectProperties( $properties) {

		if (!empty( $properties)) {
			foreach( $properties as $name => $value) {
				$this->_params->$name = $value;
			}
		}
	}

	/**
	* Read iCal events from a local file or remote url
	* parses them, and store them into DB
	*
	* @param $storeIntoDb boolean true if need to store parsed event into db as JCal events
	* @return mixed : boolean false if error occured | true if parsing events only
	*                 integer the number of events imported into db if importing to db
	*/
	public function importFromLocation( $storeIntoDb = true) {

		global $mainframe;

		// create a calendar object, and ask iCalCreator to parse the file
		$this->_cal = new vcalendar();

		// store target file/url in iCalCreator object
		if(isset($this->_params->directory)) {
			$this->_cal->setConfig( 'directory', $this->_params->directory);
		}
		if (isset($this->_params->filename)) {
			$this->_cal->setConfig( 'filename', $this->_params->filename);
		}
		if (isset($this->_params->url)) {
			$this->_cal->setConfig( 'url', $this->_params->url);
		}

		// need to set unique id. In case a UID does not exist in the
		// file, it will be created using this unique_id
		$this->_cal->setConfig( 'unique_id', $this->_params->unique_id);

		// let iCalCreator parse the file into the calendar object
		$parseResult = $this->_cal->parse();

		// if error, return
		if (!$parseResult) {
			$mainframe->enqueueMessage( 'Error while parsing ics file content.', 'error');
		}

		// import the iCal calendar into JCalPro database
		if ($parseResult && $storeIntoDb) {
			$parseResult = $this->_iCalImportToDB();
		}

		// send feedback
		return $parseResult;
	}

	/**
	* Turn a iCalCreator calendar object
	* into records in jCalPro database
	*
	* @return integer, the number of events imported, or false if error
	*/
	private function _iCalImportToDB() {

		global $mainframe;

		// a counter
		$eventsInFile = 0;
		$eventsInDB = 0;

		// iterate through parsed events from ical file
		do {
			$c = $this->_cal->getComponent();
			$status = true;
			if (!empty( $c)) {
				if ($c instanceof vevent) {
					// we have one more event from ics file, increase counter
					$eventsInFile++;
					// try storing it in database
					$status = $this->_storeiCalEventInDB( $c);
					// if success, increase imported events counter
					if ($status) {
						$eventsInDB++;
					}
				}
				if ($c instanceof vtimezone) {
					$tzid = stripslashes($this->_getICalProperty( $c, 'tzid'));
					$zones = array();
					do {
						$zone = $c->getComponent();
						if (!empty( $zone)) {
							$zones[] = $zone;
						}
					} while (!empty($zone));
					if (!empty( $zones)) {
						$this->_timezones[$tzid] = $zones;
					}
				}
			}
			// repeat until no more events in ics file, or error occured while storing
		} while (!empty($c));

		// display feedback
		$msg = (empty( $eventsInFile) ? 'No' : $eventsInFile) .  ' events found in file/URL.';
		$mainframe->enqueueMessage( $msg);
		$msg = (empty( $eventsInDB) ? 'No' : $eventsInDB) .  ' events stored in database.';
		$mainframe->enqueueMessage( $msg);

		// send feedback
		return $status  ? $eventsInDB : false;
	}

	/**
	* Transform a supplied ical calendar component object into
	* its jcal equivalent and store it into the database
	*
	* @param $c a calendarComponent object from iCalCreator.class.php
	* @return boolean true upon success
	*/
	private function _storeiCalEventInDB( calendarComponent $c) {

		static $categoryNames = null;

		global $mainframe;

		// retrieve and store Jcal pro categories names list
		// so as to be able to match jcal categories to those
		// found in the imported ical file
		if (is_null( $categoryNames)) {
			// not yet fetched the categories
			$categories = jclGetCategories();
			$categories = explode( ',', $categories);
			// store category names in an array indexed by category id
			foreach( $categories as $category) {
				// only add a category to the list if user has access to it
				if ( has_priv ( 'category' . $category)) {
					$categoryNames[$category] = JString::strtolower( jclGetCategoryName( $category));
				}
			}
		}

		// try creating event

		// find about the category in which to put the event
		// for now, events can be stored in only one category, so if the event
		// has several CATEGORIES properties, we'll only use the first
		if ($this->_params->guessCat) {
			// admin asked to use the CATEGORIES property to try find the category for the event
			$eventCat =  $this->_getICalProperty( $c, 'CATEGORIES');
			if (!is_null($eventCat)) {
				if (is_array($eventCat)) {
					$eventCat = JString::strtolower(JString::trim($eventCat[0]));
				}
				// event record has at least one CATEGORIES property. Does it match one of ours ?
				foreach( $categoryNames as $catId => $catName) {
					if ($catName == $eventCat) {
						// we have a match, adjust category id target
						$this->_params->targetCat = $catId;
						break;
					}
				}
			}
		}

		// set the static parts of the event
		$this->_setEventStaticElements( $event, $c);

		// set everything dealing with recurrency
		$this->_setEventRecurrencyElements( $event, $c);

		// common id : we use that of the original event. If there is none, it will be created
		// automatically when the event is stored to DB anyway
		// trim it, as there may be some trailing \r for instance
		$event->common_event_id = $this->_cleanUID($this->_getICalProperty( $c, 'uid'));

		// we have our object, find if this event already exists in the db, in order to update it
		// if so. We use the common_event_id to do that, as it is unique across the board
		$previousEvent = jclFindEventByCommonId($event->common_event_id, $noChild = true);
		$event->extid = empty($previousEvent) ? null : $previousEvent->extid;

		if (!empty($event->extid)) {
			// this event already exists, update it. There are several cases to consider
			if ($previousEvent->rec_type_select == JCL_REC_TYPE_NONE && $event->rec_type_select == JCL_REC_TYPE_NONE ) {
				// was non-recurrent and stays non-recurrent, only update the event
				$status = updateExistingEvent( $event);
			} else if ($previousEvent->rec_type_select != JCL_REC_TYPE_NONE) {
				// was a parent recurring event, and is now either recurrent or static
				$status = updateExistingRecurringEvent( $event);
			} else {
				// last case : was a static, and now becomes recurrent
				$status = updateExistingStaticEventToRecurring( $event);
			}
		}

		if (empty($event->extid)) {
			// this event does not already exist, create it
			// this is simply storing, as we do not handle recurring events importing
			// at this stage
			//$eventId = storeNewEvent( $event);

			$rawData = get_object_vars( $event);

			// no tags allowed in title
			@$event->title = strip_tags($event->title);
			// filter description using JFilterInput
			jimport('joomla.filter.filterinput');
			$filter = &JFilterInput::getInstance(null, null, 1, 1);
			@$event->description = $filter->clean($event->description);

			$successful = createEvent( $event->cal_id, $event->owner_id, $event->title, $event->description, $event->contact, $event->url,
			$event->registration_url, $event->email, $event->picture,
			$event->cat, $event->day, $event->month, $event->year, $event->approved, $event->private, $event->start_date, $event->end_date,
			$event->published, $event->recur_end_type,
			$event->recur_count, $event->recur_until, $rawData, $event->rec_id = 0,
			$event->detached_from_rec = 0, $checkOnly = true);

			if ($successful) {
				$successful = createEvent( $event->cal_id, $event->owner_id, $event->title, $event->description, $event->vontact, $event->url,
				$event->registration_url, $event->email, $event->picture,
				$event->cat, $event->day, $event->month, $event->year, $event->approved, $event->private, $event->start_date, $event->end_date,
				$event->published, $event->recur_end_type,
				$event->recur_count, $event->recur_until, $rawData, $event->rec_id = 0,
				$event->detached_from_rec = 0, $checkOnly = false);
			}

			$status = !empty( $successful);
		}

		// returns boolean status, true if success
		return $status;
	}

	/**
	* Initialize all static elements of a Jcal pro event object,
	* using data from a iCalCreator vevent object
	*
	* @param $event the target Jcal pro event object
	* @param $c the source iCalCreator vevent object
	* @return none
	*/
	private function _setEventStaticElements( & $event, $c) {

		global $CONFIG_EXT;

		// other elements that we won't find in iCal record
		// readjust day, month, year to the UTC values
		$startDate = $this->_getICalProperty( $c, 'dtstart');
		$endDate = $this->_getICalProperty( $c, 'dtend');

		// turn those array into our (mysql) format
		$dates = $this->_iCalDatesToJCalPro( $startDate, $endDate);

		// find about legacy columns
		$startDateTS = jcUTCDateToTs( $dates['start']);
		$day = jcUTCDateToFormatNoOffset( $startDateTS, '%d');
		$month = jcUTCDateToFormatNoOffset( $startDateTS, '%m');
		$year = jcUTCDateToFormatNoOffset( $startDateTS, '%Y');

		// create a $event object, to work with existing update functions
		$event->cal_id = $this->_params->targetCal;
		$event->rec_id = 0;
		$event->detached_from_rec = 0;
		$event->owner_id = $this->_params->owner_id;
		$event->title = $this->_getICalProperty( $c, 'summary');
		$event->description = $this->_getICalProperty( $c, 'description');
		if (is_array( $event->description)) {
			$event->description = $event->description[0];
		}
		// replace \n with <br/>
		if ($CONFIG_EXT['addevent_allow_html']) {
			$event->title = str_replace('\n', '<br />', $event->title);
			$event->description = str_replace('\n', '<br />', $event->description);
		}

		$event->contact = $this->_getICalProperty( $c, 'contact');
		$event->url = $this->_getICalProperty( $c, 'url');
		$event->registration_url = '';
		$event->email = $this->_getICalProperty( $c, 'contact', 1); // email address : try using contact #2, if any;
		$event->picture = '';
		$event->cat = $this->_params->targetCat;
		$event->start_date = $dates['start'];
		$event->end_date = $dates['end'];
		$event->day = $day;
		$event->month = $month;
		$event->year = $year;
		$event->approved = 1;
		$event->private = JCL_EVENT_PUBLIC;
		$event->published = 1;
		$event->checked_out = '0';
		$event->checked_out_time = '0000-00-00 00:00:00';
	}

	/**
	* Initialize all elements dealing with recurrency in a Jcal pro event object,
	* using data from a iCalCreator vevent object
	*
	* @param $event the target Jcal pro event object
	* @param $c the source iCalCreator vevent object
	* @return none
	*/
	private function _setEventRecurrencyElements( & $event, $c) {

		static $rDaysList = array('SU' => JCL_REC_DAY_TYPE_SUNDAY,  'MO' => JCL_REC_DAY_TYPE_MONDAY,  'TU' => JCL_REC_DAY_TYPE_TUESDAY,  'WE' => JCL_REC_DAY_TYPE_WEDNESDAY,
		'TH' => JCL_REC_DAY_TYPE_THURSDAY,  'FR' => JCL_REC_DAY_TYPE_FRIDAY,  'SA' => JCL_REC_DAY_TYPE_SATURDAY);

		// first set default values for each element,
		// which will possibly overriden when parsing the recurrence rules
		// found in the ical event
		$this->_setDefaultEventRecurrencyElements( $event);


		// find about recurrency information
		$recRules = $this->_getICalProperty( $c, 'rrule');

		// first parse recurrence rules
		if (!empty( $recRules)) {
			$freq = null;
			$rinterval = null;
			$until = null;
			$count = null;
			$rByDay = null;
			$rByMonthDay = null;
			$rByYearDay = null;
			$rByMonth = null;
			$rBySetPos = null;
			foreach( $recRules as $rule) {
				// frequency rule
				if (isset($rule['FREQ'])) {
					$freq = strtolower($rule['FREQ']);
				}
				// number of occurence rule
				if (isset($rule['COUNT'])) {
					$count = intval($rule['COUNT']);
					$event->recur_count = $count;
					$event->recur_end_type = JCL_RECUR_SO_MANY_OCCURENCES;
				}
				// repeat interval rule
				if (isset($rule['RINTERVAL'])) {
					$rinterval = intval($rule['INTERVAL']);
				}
				// repeat until a date rule
				if (isset($rule['UNTIL'])) {
					$until = intval($rule['UNTIL']);
					$event->recur_until = $this->_iCalDateRecordToJCalPro( $until);
				}
				// we don't accept events that recur infinitely
				if (empty($until) && empty( $count) && !empty($freq)) {
					// don't repeat past our maximum date
					$event->recur_until = JCL_DATE_MAX;
					$event->recur_end_type = JCL_RECUR_UNTIL_A_DATE;
				}
				// repeat by day rule
				if (isset($rule['BYDAY'])) {
					if (is_array($rule['BYDAY'])) {
						if (!empty( $rule['BYDAY'])) {
							foreach( $rule['BYDAY'] as $key => $value) {
								if (array_key_exists( $value, $rDaysList)) {
									$rByDay[] = $rDaysList[$value];
								}
							}
						}
					} else {
						$rByDay = intval($rule['BYDAY']);
					}
				}
				// repeat by year rule
				if (isset($rule['BYYEARDAY'])) {
					if (is_array($rule['BYYEARDAY'])) {
						if (!empty( $rule['BYYEARDAY'])) {
							foreach( $rule['BYYEARDAY'] as $key => $value) {
								if (array_key_exists( $value, $rDaysList)) {
									$rByYearDay[] = $rDaysList[$value];
								}
							}
						}
					} else {
						$rByYearDay = intval($rule['BYYEARDAY']);
					}
				}
				// repeat by month rule
				if (isset($rule['BYMONTHDAY'])) {
					if (is_array($rule['BYMONTHDAY'])) {
						if (!empty( $rule['BYMONTHDAY'])) {
							foreach( $rule['BYMONTHDAY'] as $key => $value) {
								if (array_key_exists( $value, $rDaysList)) {
									$rByMonthDay[] = $rDaysList[$value];
								}
							}
						}
					} else {
						$rByMonthDay = intval($rule['BYMONTHDAY']);
					}
				}
				// repeat by month rule
				if (isset($rule['BYMONTH'])) {
					if (is_array($rule['BYMONTH'])) {
						if (!empty( $rule['BYMONTH'])) {
							foreach( $rule['BYMONTH'] as $value) {
								$rByMonth[] = intval($value);
							}
						}
					} else {
						$rByMonth = intval($rule['BYMONTH']);
					}
				}
				// set value for repeat rule
				if (isset($rule['BYSETPOS'])) {
					$rBySetPos = intval(trim($rule['BYSETPOS']));
				}
			}

			// now store the results
			switch ($freq) {
				case 'daily':
					$event->rec_type_select = JCL_REC_TYPE_DAILY;
					$event->rec_daily_period = empty( $rinterval) ? $event->rec_daily_period : $rinterval;
					break;
				case 'weekly':
					$event->rec_type_select = JCL_REC_TYPE_WEEKLY;
					$event->rec_weekly_period = empty( $rinterval) ? $event->rec_weekly_period : $rinterval;
					if (!empty($rByDay)) {
						if (is_array($rByDay)) {
							foreach( $rByDays as $byDay) {
								switch ($byDay) {
									case 'SU':
						$event->rec_weekly_on_sunday = 1;
						break;
									case 'MO':
						$event->rec_weekly_on_monday = 1;
						break;
									case 'TU':
						$event->rec_weekly_on_tuesday = 1;
						break;
									case 'WE':
						$event->rec_weekly_on_wednesday = 1;
						break;
									case 'TH':
						$event->rec_weekly_on_thursday = 1;
						break;
									case 'FR':
						$event->rec_weekly_on_friday = 1;
						break;
									case 'SA':
						$event->rec_weekly_on_saturday = 1;
						break;
								}
							}
						}
					}

					break;

				case 'monthly':
					$event->rec_type_select = JCL_REC_TYPE_MONTHLY;
					$event->rec_monthly_period = empty( $rinterval) ? $event->rec_monthly_period : $rinterval;

					if (!empty($rByDay)) {
						$event->rec_monthly_day_type = is_array($rByDay) ? $rByDay[0] : $rByDay;
					}
					if (!empty($rByMonthDay)) {
						if (is_array($rByMonthDay)) {
							foreach( $rByMonthDay as $monthDay) {
								$event->rec_monthly_day_number = $monthDay;
							}
						} else {
							$event->rec_monthly_day_number = $rByMonthDay;
						}
					}
					if (!empty( $rBySetPos)) {
						if (is_numeric( $rBySetPos)) {
							$event->rec_monthly_type = JCL_REC_ON_SPECIFIC_DAY;
							$event->rec_monthly_day_order = intval( $rBySetPos);
						}
					}

					break;
				case 'yearly':
					$event->rec_type_select = JCL_REC_TYPE_YEARLY;
					$event->rec_yearly_period = empty( $rinterval) ? $event->rec_yearly_period : $rinterval;
					if (!empty($rByDay)) {
						$event->rec_yearly_day_type = is_array($rByDay) ? $rByDay[0] : $rByDay;
					}
					if (!empty($rByYearDay)) {
						$event->rec_yearly_day_number = is_array($rByYearDay) ? $rByYearDay[0] : $rByYearDay;
					}
					if (!empty( $rBySetPos)) {
						if (is_numeric( $rBySetPos)) {
							$event->rec_yearly_type = JCL_REC_ON_SPECIFIC_DAY;
							$event->rec_yearly_day_order = intval( $rBySetPos);
						}
					}
					if (!empty( $rByMonth)) {
						$event->rec_yearly_on_month = is_array($rByMonth) ? $rByMonth[0] : $rByMonth;
					}

					break;
			}

			if (!empty($count)) {
				$event->recur_count = $count;
				$event->recur_end_type = JCL_RECUR_SO_MANY_OCCURENCES;
			}
		}
	}

	/**
	* Initialize all elements dealing with recurrency with default values
	* in a Jcal pro event object
	* Some of them maybe later overriden when injecting
	* data from an iCal object into the jcalpro event object
	*
	* @param $event the target Jcal pro event object
	* @param $c the source iCalCreator vevent object
	* @return none
	*/
	private function _setDefaultEventRecurrencyElements( & $event) {

		$event->recur_type = '';
		$event->recur_val = '';
		$event->recur_end_type = JCL_RECUR_SO_MANY_OCCURENCES;
		$event->recur_count = 2;
		$event->recur_until = '';

		// general
		$event->rec_type_select = JCL_REC_TYPE_NONE;

		// daily
		$event->rec_daily_period = 1;

		// weekly
		$event->rec_weekly_period = 1;
		$event->rec_weekly_on_monday = 0;
		$event->rec_weekly_on_tuesday = 0;
		$event->rec_weekly_on_wednesday = 0;
		$event->rec_weekly_on_thursday = 0;
		$event->rec_weekly_on_friday = 0;
		$event->rec_weekly_on_saturday = 0;
		$event->rec_weekly_on_sunday = 0;

		// monthly
		$event->rec_monthly_period = 1;
		$event->rec_monthly_type = JCL_REC_ON_DAY_NUMBER;
		$event->rec_monthly_day_number = 1;
		$event->rec_monthly_day_list = '';
		$event->rec_monthly_day_order = JCL_REC_FIRST;
		$event->rec_monthly_day_type = JCL_REC_DAY_TYPE_DAY;

		// yearly
		$event->rec_yearly_period = 1;
		$event->rec_yearly_on_month = JCL_REC_JANUARY;
		$event->rec_yearly_on_month_list = '';
		$event->rec_yearly_type = JCL_REC_ON_DAY_NUMBER;
		$event->rec_yearly_day_number = 1;
		$event->rec_yearly_day_order = JCL_REC_FIRST;
		$event->rec_yearly_day_type = JCL_REC_DAY_TYPE_DAY;

		// end date
		$event->recur_until = jcServerDateToFormat( extcal_get_local_time(), '%Y-%m-%d %H:%M:%S');

	}

	/**
	* find and returns a given property from an iCal record
	* checking if it exists and handling special cases
	* like decide if array or not array
	*
	* @param $event an iCalCreator.class.php iCal event record
	* @param $property string, the property name
	* @param $index integer, if property may be an array, $index optionnally specify which element to retrieve
	* @return mixed, the property value
	*/
	private function _getICalProperty( $event, $property, $index = null) {

		$property = strtolower($property);
		switch (strtoupper($property)) {

			case 'ATTACH':
			case 'ATTENDEE':
			case 'CATEGORIES':
			case 'COMMENT':
			case 'CONTACT':
			case 'DESCRIPTION':
			case 'EXDATE':
			case 'EXRULE':
			case 'RDATE':
			case 'RELATED-TO':
			case 'REQUEST-STATUS':
			case 'RESOURCES':
			case 'RRULE':
				$tmp = isset($event->$property) ? $event->$property : null;
				// if user has requested one specific item in the property array
				if (!is_null($index)) {
					$tmp = isset($tmp[$index]) ? $tmp[$index] : $tmp;
				}
				// there is actually an array of property,
				// we must iterate the array to only return an
				// array of values, excluding the PARAMS
				$value = array();
				if (!empty($tmp)) {
					foreach( $tmp as $item) {
						$value[] = $item['value'];
					}
				}
				break;
				// for dtstart and dtend, we need the params field as well,
				// as iCalCreator sotres TZID in there
			case 'DTSTART':
			case 'DTEND':
				$value = isset($event->$property) ? $event->$property : null;
				break;
			default:
				$tmp = isset($event->$property) ? $event->$property : null;
				// there is only one instance of the property,
				// we can directly return its 'value' element
				$value = !empty( $tmp) ? $tmp['value'] : null;
				break;
		}

		return $value;
	}

	/**
	* Turns start and end dates as per iCal property format
	* into UTC datetime string, needed for DB storage
	* Handles detecting all-day events
	*
	* @param $dateStart
	* @param $dateEnd
	* @return array start and end date as strings
	*/
	private function _iCalDatesToJCalPro( $startDate, $endDate) {

		$jCalDates = array( 'start' => null, 'end' => null);

		// work on start date first, to identify all-day event
		if (!isset( $startDate['value']['hour']) && !isset( $startDate['value']['min']) && !isset( $startDate['value']['sec'])) {
			// this is an all-day event, mark it as such
			$jCalDates['end'] = JCL_ALL_DAY_EVENT_END_DATE;
			$startDate['value']['hour'] = 0;
			$startDate['value']['min'] = 0;
			$startDate['value']['sec'] = 0;
		}

		// now create start date
		$jCalDates['start'] = $this->_iCalDateRecordToJCalPro( $startDate);

		// if not already done, create end date
		if (is_null($jCalDates['end'])) {
			$jCalDates['end'] = $this->_iCalDateRecordToJCalPro( $endDate);
		}
		return $jCalDates;
	}

	/**
	* Turns an iCalCreator date record into its
	* jCal equivalent, allowing database storage
	*
	* @param $date array with date details
	* @return string a datetime string
	*/
	private function _iCalDateRecordToJCalPro( $date) {

		global $mainframe;

		// quick check
		if (empty( $date)) {
			return null;
		}

		// check timezone
		$iCalOffset = $this->_calculateTZOffset( $date);

		// create time, assuming everything is UTC
		$dateTime = jcTimeToUTCNoDst( $date['value']['hour'], $date['value']['min'], $date['value']['sec'], $date['value']['month'], $date['value']['day'], $date['value']['year']);

		// make it a timestamp
		$ts = jcUTCDateToTs( $dateTime);

		// if the iCal time has an offset in it, compensate for it so we do have an UTC time
		// suitable for storage in database
		$ts = $ts - $iCalOffset;

		// turn it back to date time
		return jcUTCDateToFormatNoOffset( $ts, '%Y-%m-%d %H:%M:%S');
	}

	/**
	* Calculates the timezone offset based on the date
	* May require using a vtimezone, if any, found in
	* in the ics file itself (Outlook files for instance)
	*
	* @param $date a date record, array indexed on year, month, day, etc
	* @return string
	*/
	private function _calculateTZOffset($date) {

		global $CONFIG_EXT;

		static $foundZones = null;

		$offset = null;
		if (!empty($date['value']['tz'])) {

			// UTC time
			if (strtolower($date['value']['tz']) == 'z') {
				$offset = 0;
			}
			// offset is directly listed : ex +0100
			$matches = null;
			if (preg_match('/[+-]?[0-9]{4}/', JString::trim($date['value']['tz']), $matches)) {
				$offset = $matches[0];
				$sign = $offset < 0 ? -1 : 1;
				$offset = abs( $offset);
				$offsetHours = floor( $offset / 100);
				$offsetMinutes = $offset - 100 * $offsetHours;

				$offset = $sign * 3600 * $offsetHours + 60 * $offsetMinutes;
			}
		}

		// something else, in the TZID parameter
		if (is_null($offset) && !empty($date['params']['TZID'])) {
			// if we have not found an offset yet, search for the timezone name
			// in php list of timezones
			if (is_null($offset) && !empty($this->_timezones)) {
				// found the timezone name amongst the timezones definition embedded in the ical file
				// @TODO now we must decode it ! this requires implementing a full RRULE parser
				// to be able to identify dst transition dates as used in Outlook ics files
				// workaround : we search for cities, in PHP timezone list
				$found = false;
				// first check if we have not already recognized this timezone
				if (!empty($foundZones) && array_key_exists($date['params']['TZID'], $foundZones)) {
					$offset = $foundZones[$tzid];
					$found = true;
				}
				// iterate through all timezones records found in ics files
				if (!$found) {
					$phpZones = jclGetPhpTimezonesList();
					foreach ($this->_timezones as $tzid => $tz) {
						// explode cities, and search for them
						$cities = explode(',', $tzid);
						if (!empty($cities)) {
							foreach ($cities as $city) {
								$city = JString::trim(JString::strtolower( $city));
								foreach ($phpZones as $phpZoneId => $phpZoneDetails) {
									if (JString::strpos(JString::strtolower($phpZoneId), $city) !== false) {
										// found a city name in our list, just use it and break
										$offset = $phpZoneDetails['offset'];
										$foundZones[$tzid] = $offset;
										$found = true;
										break(3);
									}
								}
							}
						}
					}
				}
			}
		}
		// if we don't have any offset information, this is a floating date, so we should use
		// the web site time zone as default
		if (is_null($offset)) {
			// sometimes $date has invalid values & will error
			try {
				$dateString = $date['value']['year'] . '-' . $date['value']['month'] . '-' . $date['value']['day'] . ' ' . $date['value']['hour'] . ':' . $date['value']['min'] . ':' . $date['value']['sec'];
				$dateString .= $CONFIG_EXT['site_timezone'];
				$date = new DateTime($dateString);
				$offset = $date->getOffset();
			} catch (Exception $e) {
				return 0;
			}
		}

		// return calculated offset value
		return intval($offset);

	}

	/**
	* Clean an incoming uid from an ical event
	* as they may have spaces, cr, lf, etc
	*
	* @param $UID string
	* @return string
	*/
	private function _cleanUID($UID) {
		$UID = trim("$UID");
		// convert spaces
		$UID = preg_replace('#[\s\r\t\n]#', '-', $UID);
		// remove all non-alpha chars (except a few specials)
		$UID = preg_replace('#([^a-z0-9\+\/\.\-\_])#i', '', $UID);
		// the uid is cut off at 240 caracters to make room for the trailing sequence number added for children, in case
		// of repeating events
		$UID = JString::substr($UID, 0, 240);
		// all done
		return $UID;
		//return Jfilteroutput::stringURLSafe( JString::substr($UID, 0, 240));
	}
}
