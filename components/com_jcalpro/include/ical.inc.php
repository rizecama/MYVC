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

 $Id: ical.inc.php 710 2011-03-04 18:12:04Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com/
 **********************************************
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );


/**
 * Create an ics file for iCal import and return it to user
 * Makes use of the iCalCreator library
 * copyright (c) 2007-2008 Kjell-Inge Gustafsson kigkonsult
 *
 */
class JclIcal {

	// start date, in Jcal pro format (ie mysql/UTC)
	private $_startDate = '';

	// end date, in Jcal pro format (ie mysql/UTC)
	private $_endDate = '';

	// array of events, to be displayed
	private $_data = null;

	// var holding the current number of events stored in _data
	private $_dataCount = 0;

	// the various parameters needed to fetch events from DB
	private $_params = null;

	// the calendar object being built
	private $_cal = null;

	/**
	* Constructor set default values for some parameters
	*
	* @param
	* @return none
	*/
	public function __construct( $startDate, $endDate, $eventList = null) {

		// store incoming parameters
		$this->_startDate = $startDate;
		$this->_endDate = $endDate;
		// optionnally, a list of events can be passed directly
		// if so, they won't be read from the db by this class
		if (!is_null( $eventList)) {
			$this->_data = $eventList;
			$this->_dataCount = count( $eventList);
		}

		// initialize default values for some parameters
		$this->_params->calName = '';
		$this->_params->calDescription = '';
		$this->_params->timezone = '';

		// use site url as a default unique id
		$this->_params->uniqueId = trim( JURI::base(), '/');
		$this->_params->uniqueId = str_replace( '/administrator', '', $this->_params->uniqueId);

	}

	/**
	* Actually create the ics file and returns it
	*
	* @return none
	*/
	public function display() {

		global $mainframe, $CONFIG_EXT;

		// Get some data from the model
		if (empty($CONFIG_EXT['enable_ical_export'])) {
			// if iCal display is disabled by admin, we render a 404 error page
			JError::RaiseError( 404, 'Page not found');
		} else {

			// as we actually have some events to return, require ical library
			require_once(JPATH_COMPONENT.DS.'lib'.DS.'iCalcreator.class.php');

			// get the event list from the db, except if it was sent
			// already through the constructor
			if (empty( $this->_dataCount)) {
				$this->_loadData();
			}

			// init
			$status = $this->_iCalStart();
			if ($status && $this->_dataCount) {
				// iterate over events
				foreach ( $this->_data as $eventRecord ) {
					// use only the real event record
					$event = $eventRecord[3];
					// create current event record
					$status = $this->_iCalEvent( $event);
					if (!$status) {
						// if there was an error, no reason to keep trying, just exit and fail
						break;
					}
				}
			}

			// finalize ics file creation
			if ($status) {
				$status = $this->_iCalEnd();
			}

			// if an error occured, returns a 500 error page
			// if we reach this point, then an error must have occured
			// as otherwise $this->_iCalEnd() should have finished and returned the response
			JError::raiseError( 500, 'Error while retrieving feed data');
		}
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
	* Get event list from database
	*
	* @return number of events fetched
	*/
	private function _loadData() {

	global $CONFIG_EXT, $cat_id, $cal_id, $cat_list, $cal_list;
	
		// Require the events model, and instantiate it
		require_once(JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'models'.DS.'events.php');
		$model = & JModel::getInstance( 'events', 'JcalproModel');

		// then inject those params into the model
		$properties = array(
					'showRecurringEvents' => $CONFIG_EXT['show_recurrent_events'],
					'catId' => $cat_id,
					'catList' => $cat_list,
					'calId' => $cal_id,
					'calList' => $cal_list,
					'maxNumberOfEvents' => PHP_INT_MAX, // no limit on number of events
					'lastUpdated' => false
		);

		$model->injectProperties( $properties);
		// ask the model for events
		$this->_data = $model->getEvents( $this->_startDate, $this->_endDate, $dispatchByDay = false);

		// count the returned data set
		$this->_dataCount = is_array($this->_data) ? count( $this->_data) : 0;

		return $this->_dataCount;

	}

	/**
	* Performs initialization of iCal file creation
	*
	* @return boolean true if success
	*/
	protected function _iCalStart() {

		// instantiate new calendar
		$this->_cal = new vcalendar();
		
		// better for outlook 2003 : set method = publish
		$this->_cal->setMethod( 'PUBLISH');

		// set main properties
		$this->_cal->setConfig( 'filename', $this->_params->filename);
		$this->_cal->setConfig( 'unique_id', $this->_params->uniqueId);

		// set some X-properties
		$this->_cal->setProperty( "X-WR-CALNAME", $this->_params->calName );
		$this->_cal->setProperty( "X-WR-CALDESC", $this->_params->calDescription );
		$this->_cal->setProperty( "X-WR-TIMEZONE", $this->_params->timezone );

		return true;

	}

	/**
	* Finalize iCal file creation, after events have been added
	*
	* @return boolean true if success
	*/
	protected function _iCalEnd() {

		// return calendar we just created to the user,
		// as a download
		$this->_cal->returnCalendar();

		return false;
	}

	/**
	* Create iCal record for a given event
	*
	* @param $eventRecord event object, as per Jcal Pro format
	* @return boolean true if success
	*/
	protected function _iCalEvent( $event) {

		jimport( 'joomla.filter.filteroutput');
		
		// strip html from title
		$title = htmlspecialchars( $event->title, ENT_COMPAT, 'UTF-8');
		$title = JString::trim( html_entity_decode( $title ));

		// strip html from description
		$description = JFilterOutput::cleanText( $event->description);
		
		// prepare vevent object with elements from current event
		$item = new vevent();
		// use method to extract date elements, as per vcalendar requirements
		$this->_setDate( 'dtstart', $item, $event->start_date);

		// several cases for end date
		if (jclIsAllDay($event->end_date)) {
			// set end date to end of start day
			$startOfDayTS = startOfDayInUserTime( jcUTCDateToTs($event->start_date));
			$this->_setDate('dtstart', $item, jcTSToUTC($startOfDayTS));
			$endOfDayTS = $startOfDayTS  + 86399;  // end of day where start of event falls
			$endOfDay = jcTSToUTC($endOfDayTS);
			$this->_setDate('dtend', $item, $endOfDay);
		} else if (!jclIsNoEndDate( $event->end_date)) {
			// event has an end date, just use it
			$this->_setDate( 'dtend', $item, $event->end_date);
		} // else : event has no end date, just don't set DTEND

		// set title and description
		if (!empty( $title)) {
			$item->setProperty( 'summary', $title);
		}
		if (!empty( $description)) {
			$item->setProperty( 'description', $description );
		}
		// calendars and categories - not yet implemented
		//$item->setProperty( 'categories', null);
		if (!empty( $event->contact)) {
			$item->setProperty( 'contact', $event->contact);
		}
		if (!empty( $event->url)) {
			$url = JString::substr($event->url, 0, 7) == 'http://' ||  JString::substr($event->url, 0, 8) == 'https://' ? $event->url:"http://".$event->url;
			$url = JString::rtrim( $url, '/') . '/';
			$item->setProperty( 'url', $url);
		}
		$this->_setDate( 'last-modified', $item, @$event->last_updated);

		// set event unique id
		$item->setProperty('uid', @$event->common_event_id);

		// add event to calendar
		$this->_cal->addComponent( $item);

		return true;
	}

	/**
	* Set a date property of a vevent, transforming JCal Pro
	* date format into vevent requirement
	*
	* @param $element the vevent element being set (dtstart, dtend, etc)
	* @param $item  the vevent object being prepared
	* @param $date the jcal pro formatted date
	* @return none
	*/
	private function _setDate( $element, & $item, $date) {

		global $mainframe;

		// now we can set the property, using iCalCreator adhoc method
		switch ($element) {
			default:
				// break down the date into its needed parts
				// using UTC time format only
				$year = jcUTCDateToFormatNoOffset( $date, '%Y');
				$month = jcUTCDateToFormatNoOffset( $date, '%m');
				$day =  jcUTCDateToFormatNoOffset( $date, '%d');
				$hour = jcUTCDateToFormatNoOffset( $date, '%H');
				$minute = jcUTCDateToFormatNoOffset( $date, '%M');
				$second = 0;

				$item->setProperty( $element, $year, $month, $day, $hour, $minute, $second, 'Z');
				break;
		}
	}
}
