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

 $Id: jcalpro.class.php 683 2011-02-04 04:39:48Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * @package Mambo
 * @subpackage Extcalendar
 */
class mosExtCalendarSettings extends JTable {
	/** @var string */
	var $name				= "";
	/** @var string */
	var $value				= "";
	/** @var int */
	var $checked_out		= 0;
	/** @var date */
	var $checked_out_time	= 0;

	function mosExtCalendarSettings( &$_db ) {
		//$this->mosDBTable( '#__jcalpro2_config', 'name', $_db );
		parent::__construct('#__jcalpro2_config', 'name', $_db);
	}

}

class mosExtCalendarCategories extends JTable {
	/** @var int */
	var $cat_id				= null;
	/** @var int */
	var $cat_parent			= 0;
	/** @var string */
	var $cat_name			= "";
	/** @var string */
	var $description		= "";
	/** @var string */
	var $color				= "#000000";
	/** @var string */
	var $bgcolor			= "#EEF0F0";

	var $level = "default";

	/** @var int */
	var $options			= 0;
	/** @var int */
	var $published			= 0;
	/** @var int */
	var $checked_out		= 0;
	/** @var date */
	var $checked_out_time	= 0;

	function mosExtCalendarCategories( &$_db ) {
		parent::__construct( '#__jcalpro2_categories', 'cat_id', $_db );
	}

	function check() {
		// check for valid category name
		if (JString::trim($this->cat_name) == "") {
			$this->_error = "You must specify a category name.";
			return false;
		}

		// check for valid color
		if (JString::trim($this->color) == "") {
			$this->_error = "You must specify a category color.";
			return false;
		}

		return true;
	}
}

class mosExtCalendarCalendars extends JTable {
	/** @var int */
	var $cal_id				= null;
	/** @var int */
	var $cal_parent			= 0;
	/** @var string */
	var $cal_name			= "";
	/** @var string */
	var $description		= "";
	/** @var int */
	var $options			= 0;
	/** @var string */
	var $level = "default";
	/** @var int */
	var $published			= 0;
	/** @var int */
	var $checked_out		= 0;
	/** @var date */
	var $checked_out_time	= 0;

	function mosExtCalendarCalendars( &$_db ) {
		parent::__construct( '#__jcalpro2_calendars', 'cal_id', $_db );
	}

	function check() {
		// check for valid category name
		if (JString::trim($this->cal_name) == "") {
			$this->_error = "You must specify a calendar name.";
			return false;
		}

		return true;
	}
}

// deprecated : @todo : remove
class mosJCalProEvents extends JTable
{
	var $extid  = null;
	var $title = null;
	var $description = null;
	var $contact = null;
	var $url = null;
	var $email = null;
	var $picture = null;
	var $cat = null;
	var $day = null;
	var $month = 1;
	var $year = null;
	var $approved	= 1;
	var $start_date	= null;
	var $end_date	= null;
	var $recur_type	= null;
	var $recur_val= null;
	var $recur_end_type	= 1;
	var $recur_count= 2;
	var $recur_until= null;
	var $published = 1;
	var $checked_out = null;
	var $checked_out_time	= null;

	function mosJCalProEvents ( &$_db )
	{
		//global $database;

		//$this->mosDBTable ( '#__jcalpro2_events', 'extid', $database );
		parent::__construct( '#__jcalpro2_events', 'extid', $_db );

	}

	function check()
	{
		// no end date for repeat event not allowed any more see bug tracker #10594
		if ($this->rec_type_select != JCL_REC_TYPE_NONE && $this->recur_end_type == '0') {
			$this->setError('A recurring event should have an end-date or a number of occurences');
			return false;
		}
		return true;
	}
}
class JCalEvent extends JTable {
	// Set default variables for all new objects

	// Other info variables
	var $extid = 0;


	var $rec_id = 0;
	var $cal_id = 0;
	var $detached_from_rec = 0;
	var $owner_id = JCL_DEFAULT_OWNER_ID;
	var $title = '';
	var $description = '';
	var $contact = '';
	var $url = '';
	var $registration_url = '';
	var $email = '';
	var $picture = '';
	var $cat = 0;
	var $day = 0;
	var $month = 0;
	var $year = 0;
	var $approved = 0;
	var $private = 0;
	var $start_date = '0000-00-00 00:00:00';
	var $end_date = '0000-00-00 00:00:00';
	var $published = 0;
	var $checked_out =0;
	var $checked_out_time = '0000-00-00 00:00:00';
	var $recur_type = '';
	var $recur_val = 0;
	var $recur_end_type = 0;
	var $recur_count = 0;
	var $recur_until = '0000-00-00 00:00:00';

	// V 2.1.x
	var $rec_type_select = 0;

	// daily
	var $rec_daily_period = 0;

	// weekly
	var $rec_weekly_period = 0;
	var $rec_weekly_on_monday = 0;
	var $rec_weekly_on_tuesday = 0;
	var $rec_weekly_on_wednesday = 0;
	var $rec_weekly_on_thursday = 0;
	var $rec_weekly_on_friday = 0;
	var $rec_weekly_on_saturday = 0;
	var $rec_weekly_on_sunday = 0;

	// monthly
	var $rec_monthly_period = 0;
	var $rec_monthly_type = 0;
	var $rec_monthly_day_number = 0;
	var $rec_monthly_day_list = '';
	var $rec_monthly_day_order = 0;
	var $rec_monthly_day_type = 0;

	// yearly
	var $rec_yearly_period = 0;
	var $rec_yearly_on_month = 0;
	var $rec_yearly_on_month_list = '';
	var $rec_yearly_type = 0;
	var $rec_yearly_day_number = 0;
	var $rec_yearly_day_order = 0;
	var $rec_yearly_day_type = 0;
	
	// others
	var $last_updated = '0000-00-00 00:00:00';
	
	function JCalEvent() {
		// defining the constructor
		$db = &JFactory::getDBO();
		parent::__construct( '#__jcalpro2_events', 'extid', $db );
	}

	/**
	* $date_stamp must be a user timestamp, not UTC
	*
	* @param unknown_type $eventId
	* @param unknown_type $date_stamp
	* @return unknown
	*/
	function loadEvent($eventId,$date_stamp=false) {

		// JCal 2 : added caching of events
		if (empty( $this->eventsCache[$eventId])) {
			// function that retrieves and set event info
			global $CONFIG_EXT, $CFG, $params, $mainframe;
			$db = &JFactory::getDBO();

			$query = "SELECT e.*,cat_id, cat_name, color, c.description AS cat_desc  FROM ".$CONFIG_EXT['TABLE_EVENTS']." AS e ";
			$query .= "LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS c ON e.cat=c.cat_id WHERE extid=".$db->Quote( $eventId);
			$db->setQuery( $query);
			$row = $db->loadAssoc();

			if (empty($row)) {
				return false;
			}
			$this->eventsCache[$eventId] = $row;
		}

		// get it from cache
		$row = $this->eventsCache[$eventId];

		// Store info related variables

		$this->cal_id = $row['cal_id'];
		$this->rec_id = $row['rec_id'];
		$this->detached_from_rec = $row['detached_from_rec'];
		$this->owner_id = $row['owner_id'];

		$this->title = $row['title'];
		$this->description = $row['description'];
		$this->contact = $row['contact'];
		if($row['url']) {
			$this->url = JString::substr($row['url'], 0, 7) == 'http://' ||  JString::substr($row['url'], 0, 8) == 'https://' ? $row['url']:"http://".$row['url'];
		} else {
			$this->url = "";
		}

		if($row['registration_url']) {
			$this->registration_url = JString::substr($row['registration_url'], 0, 7) == 'http://' ||  JString::substr($row['registration_url'], 0, 8) == 'https://' ? $row['registration_url']:"http://".$row['registration_url'];
		} else {
			$this->registration_url = '';
		}

		$this->email = $row['email'];

		$this->picture = $row['picture'];
		$this->color = $row['color'];
		$this->cat = (int)$row['cat'];
		$this->catName = $row['cat_name'];
		$this->catDesc = $row['cat_desc'];

		// Store date related variables
		$this->start_date = $row['start_date'];
		$this->end_date = $row['end_date'];
		$this->recur_type = $row['recur_type'];
		$this->recur_val = $row['recur_val'];
		$this->recur_end_type = $row['recur_end_type'];
		$this->recur_count = $row['recur_count'];
		$this->recur_until = $row['recur_until'];
		$this->startDate = jcUTCDateToTs( $row['start_date']);
		if($row['start_date'] > $row['end_date']) {
			$this->endDate = $this->startDate;
		} else {
			$this->endDate = jclIsAllDay( $row['end_date']) ? $row['end_date'] : jcUTCDateToTs( $row['end_date']);
		}
		$this->startDay = jcUTCDateToFormatNoOffset( $this->startDate, '%d');
		$this->startMonth = jcUTCDateToFormatNoOffset( $this->startDate, '%m');
		$this->startYear = jcUTCDateToFormatNoOffset( $this->startDate, '%Y');
		$this->startHour = jcUTCDateToFormatNoOffset( $this->startDate, '%H');
		$this->startMinute = jcUTCDateToFormatNoOffset( $this->startDate, '%M');

		if (jclIsAllDay( $row['end_date'])) {
			$this->endDay = jcUTCDateToFormatNoOffset(JCL_ALL_DAY_EVENT_END_DATE, '%d');
			$this->endMonth = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%m');
			$this->endYear = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%Y');
			$this->endHour = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%H');
			$this->endMinute = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%M');
		} else {
			$this->endDay = jcUTCDateToFormatNoOffset( $this->endDate, '%d');
			$this->endMonth = jcUTCDateToFormatNoOffset( $this->endDate, '%m');
			$this->endYear = jcUTCDateToFormatNoOffset( $this->endDate, '%Y');
			$this->endHour = jcUTCDateToFormatNoOffset( $this->endDate, '%H');
			$this->endMinute = jcUTCDateToFormatNoOffset( $this->endDate, '%M');
		}

		// Store other info variables
		$this->extid = $eventId;
		$this->catId = (int)$row['cat'];
		$this->status = $row['approved']?true:false;
		$this->approved = $row['approved'];
		$this->private = $row['private']? $row['private'] : JCL_EVENT_PUBLIC;
		$this->published = $row['published']?true:false;
		$this->recType = $row['recur_type'];
		$this->recInterval = (int)$row['recur_val'];
		$this->recEndDate = jcUTCDateToTs( $row['recur_until']);
		//$this->recWeekDays = $row['rec_weekdays'];
		$this->recEndType = (int)$row['recur_end_type'];
		$this->recEndCount = (int)$row['recur_count'];

		// V 2.1.x
		$this->rec_type_select = $row['rec_type_select'];

		// daily
		$this->rec_daily_period = $row['rec_daily_period'];

		// weekly
		$this->rec_weekly_period = $row['rec_weekly_period'];
		$this->rec_weekly_on_monday = $row['rec_weekly_on_monday'];
		$this->rec_weekly_on_tuesday = $row['rec_weekly_on_tuesday'];
		$this->rec_weekly_on_wednesday = $row['rec_weekly_on_wednesday'];
		$this->rec_weekly_on_thursday = $row['rec_weekly_on_thursday'];
		$this->rec_weekly_on_friday = $row['rec_weekly_on_friday'];
		$this->rec_weekly_on_saturday = $row['rec_weekly_on_saturday'];
		$this->rec_weekly_on_sunday = $row['rec_weekly_on_sunday'];

		// monthly
		$this->rec_monthly_period = $row['rec_monthly_period'];
		$this->rec_monthly_type = $row['rec_monthly_type'];
		$this->rec_monthly_day_number = $row['rec_monthly_day_number'];
		$this->rec_monthly_day_list = $row['rec_monthly_day_list'];
		$this->rec_monthly_day_order = $row['rec_monthly_day_order'];
		$this->rec_monthly_day_type = $row['rec_monthly_day_type'];

		// yearly
		$this->rec_yearly_period = $row['rec_yearly_period'];
		$this->rec_yearly_on_month = $row['rec_yearly_on_month'];
		$this->rec_yearly_on_month_list = $row['rec_yearly_on_month_list'];
		$this->rec_yearly_type = $row['rec_yearly_type'];
		$this->rec_yearly_day_number = $row['rec_yearly_day_number'];
		$this->rec_yearly_day_order = $row['rec_yearly_day_order'];
		$this->rec_yearly_day_type = $row['rec_yearly_day_type'];

		// updated
		$this->last_updated = $row['last_updated'];
		
		// common id
		$this->common_event_id = $row['common_event_id'];
		
		return true;
	}

	/**
	* Calculate additional fields for an event,
	*
	* @param unknown_type $event
	* @return unknown
	*/
	function FixUpEvent( &$event) {

		// Store info related variables

		if (@$event->url) {
			if (JString::substr($event->url, 0, 7) != 'http://' && JString::substr($event->url, 0, 8) != 'https://') {
				$event->url = 'http://' . $event->url;
			}
		} else {
			$event->url = "";
		}

		if (!empty($event->registration_url)) {
			if (JString::substr($event->registration_url, 0, 7) != 'http://' && JString::substr($event->registration_url, 0, 8) != 'https://') {
				$event->registration_url = 'http://' . $event->registration_url;
			}
		}

		$event->catName = @$event->cat_name;
		$event->catDesc = @$event->cat_desc;

		// Store date related variables
		$event->startDate = jcUTCDateToTs( $event->start_date);
		if($event->start_date > $event->end_date) {
			$event->endDate = $event->startDate;
		} else {
			$event->endDate = jclIsAllDay( $event->end_date) ? $event->end_date : jcUTCDateToTs( $event->end_date);
		}
		$event->startDay = jcUTCDateToFormatNoOffset( $event->startDate, '%d');
		$event->startMonth = jcUTCDateToFormatNoOffset( $event->startDate, '%m');
		$event->startYear = jcUTCDateToFormatNoOffset( $event->startDate, '%Y');
		$event->startHour = jcUTCDateToFormatNoOffset( $event->startDate, '%H');
		$event->startMinute = jcUTCDateToFormatNoOffset( $event->startDate, '%M');

		if (jclIsAllDay( $event->end_date)) {
			$event->endDay = jcUTCDateToFormatNoOffset(JCL_ALL_DAY_EVENT_END_DATE, '%d');
			$event->endMonth = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%m');
			$event->endYear = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%Y');
			$event->endHour = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%H');
			$event->endMinute = jcUTCDateToFormatNoOffset( JCL_ALL_DAY_EVENT_END_DATE, '%M');
		} else {
			$event->endDay = jcUTCDateToFormatNoOffset( $event->endDate, '%d');
			$event->endMonth = jcUTCDateToFormatNoOffset( $event->endDate, '%m');
			$event->endYear = jcUTCDateToFormatNoOffset( $event->endDate, '%Y');
			$event->endHour = jcUTCDateToFormatNoOffset( $event->endDate, '%H');
			$event->endMinute = jcUTCDateToFormatNoOffset( $event->endDate, '%M');
		}
		// Store other info variables
		$event->catId = @$event->cat;
		$event->status = @$event->approved ? true : false;
		$event->private = @$event->private ? $event->private : JCL_EVENT_PUBLIC;
		$event->published = @$event->published ? true : false;
		$event->recType = @$event->recur_type;
		$event->recInterval = @$event->recur_val;
		$event->recEndDate = jcUTCDateToTs(@$event->recur_until);
		$event->recEndType = @$event->recur_end_type;
		$event->recEndCount = @$event->recur_count;

		return true;
	}

	function getDuration() {
		//function datestoduration ($periods = null) {
		$periods = null;
		$seconds = $this->endDate - $this->startDate;

		// Force the seconds to be numeric
		$seconds = (int)$seconds;
		// Define our periods
		if (!is_array($periods)) {
			$periods = array (
			//'years'     => 31556926,
			//'months'    => 2629743,
			//'weeks'     => 604800,
				'days'      => 86400,                    
				'hours'     => 3600,                    
				'minutes'   => 60,                    
			//'seconds'   => 1
			);
		}

		// Loop through
		foreach ($periods as $period => $value) {
			$count = floor($seconds / $value);
			$values[$period] = $count;
			if ($count == 0) {
				continue;
			}
			$seconds = $seconds % $value;
		}
		// Return array
		if (empty($values)) {
			$values = null;
		}

		// fix the all day value
		if(date("G:i",$this->endDate) == "23:59") {
			$values['days']++;
			$values['hours'] = 0;
			$values['minutes'] = 0;
		}
		
		return $values;
	}

	function isRecurrent() {
		return $this->rec_type_select != JCL_REC_TYPE_NONE;
	}

}