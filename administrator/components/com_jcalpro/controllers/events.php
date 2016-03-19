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

 $Id: events.php 694 2011-02-07 23:05:46Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Direct access to this location is not allowed.');

//include_once dirname(__FILE__) . '/events.html.php';

jimport( 'joomla.application.component.controller' );

class JCalProControllerEvents extends JController {

  function execute($task=null) {
    $id    = JRequest::getVar( 'id', 0);
    $option        = JRequest::getCmd( 'option' );
    $section = JRequest::getVar( 'section' );
    $cid        = JRequest::getVar( 'cid', array(), 'post', 'array' );

    JArrayHelper::toInteger($cid);

    if ( $task == 'edit' && $id == 0 )
    {
      $id = implode ( ',', $cid );
    }

    switch ( $task )
    {
      case 'new':
        $this->editEvent ( '0', $option, $section );
        break;

      case 'save':
      case 'edit':
        $this->editEvent ( $id, $option, $section );
        break;

      case 'editA':
        $this->editEvent ( $id, $option, $section );
        break;

        /*case 'save':
         $this->saveEvent ( $option, $section );
         break;*/

      case 'remove':
        $this->removeEvents ( $cid, $option, $section );
        break;

      case 'publish':
        $this->changeEvent ( $cid, 1, $option, $section );
        break;

      case 'unpublish':
        $this->changeEvent ( $cid, 0, $option, $section );
        break;

      case 'notapprove':
        $this->changeEvent ( $cid, 2, $option, $section );
        break;

      case 'approve':
        $this->changeEvent ( $cid, 3, $option, $section );
        break;

      case 'cancel':
        $this->cancelEvent ( $option, $section );
        break;

      case 'cancelToMain':
        $this->cancelToMain ( $option, $section);
        break;

      case 'copyEvent':
        $this->copyEvent ( $cid, $option, $section );
        break;

      default:
        $this->showEvents ( $option, $section );
        break;
    }
  }

  /**
   * List the records
   * @param string The current GET/POST option
   */
  function showEvents ( $option, $section )
  {
    
    $data = JCalProControllerEvents::getShowEventsData ( $option, $section );
    
    include_once dirname(__FILE__) . DS . 'events.html.php';
    HTML_events::showEvents( $data->rows, $data->pageNav, $data->search, $data->option, $data->section, $data->lists );
  }

  
function getShowEventsData ( $option, $section )
  {
    global $mainframe, $lang_date_format, $today;
    
    $output = new stdClass();
    
    $output->option = $option;
    $output->section = $section;
    
    
    $db = &JFactory::getDBO();
    $mosConfig_list_limit = $mainframe->getCfg('list_limit');

    $limit         = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    $output->search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
    $output->search = JString::strtolower( $output->search );
    $output->search = JString::trim( $output->search );
    $output->search     = $db->getEscaped( $output->search);
    $cat = intval( $mainframe->getUserStateFromRequest( "cat{$option}", 'cat', 0 ) );
    $cal_id = intval( $mainframe->getUserStateFromRequest( "cal_id{$option}", 'cal_id', 0 ) );

    // ordering of event display
    $order = $mainframe->getUserStateFromRequest( "eventsview{$option}order", 'filter_order', 'order_by_start_time' );
    $orderDir = $mainframe->getUserStateFromRequest( "eventsview{$option}order_dir", 'filter_order_Dir', 'ASC' );
    $output->lists['order'] = $order;
    $output->lists['order_dir'] = $orderDir;

    $showChildren = intval( $mainframe->getUserStateFromRequest( "show_children{$option}", 'show_children', 1 ) );
    $published = intval( $mainframe->getUserStateFromRequest( "published{$option}", 'published', 0 ) );
    $approved = intval( $mainframe->getUserStateFromRequest( "approved{$option}", 'approved', 0 ) );
    $dateRange = intval( $mainframe->getUserStateFromRequest( "date_range{$option}", 'date_range', 0 ) );
    $monthToShow = intval( $mainframe->getUserStateFromRequest( "month_to_show{$option}", 'month_to_show', 0 ) );
    $yearToShow = intval( $mainframe->getUserStateFromRequest( "year_to_show{$option}", 'year_to_show', 0 ) );

    // process search request
    if ( $output->search )     {
      $where[] = "#__jcalpro2_events.title LIKE '%$output->search%'";
    }
    
    // process published & approved
    foreach (array('published', 'approved') as $filter) {
    	$f = $$filter; // don't want to bother with lots of variable variables
    	$v = 1; // default value
    	// only filter if set
	    if (0 != $f) {
	    	// if filter val is negative, that means off
	    	if (0 > $f) {
	    		$v = 0;
	    	}
		    $where[] = "#__jcalpro2_events.$filter = $v";
	    }
    }

    if ( $cat > 0 ) {
      $where[] = "#__jcalpro2_events.cat = $cat";
    }

    if ( $cal_id > 0 ) {
      $where[] = "#__jcalpro2_events.cal_id = $cal_id";
    }

    if (empty($showChildren)) {
      $where[] = '(#__jcalpro2_events.rec_type_select = ' . JCL_REC_TYPE_NONE
      . ' OR (#__jcalpro2_events.rec_type_select != ' . JCL_REC_TYPE_NONE . ' AND #__jcalpro2_events.rec_id = 0))';
    }

    if (!empty($yearToShow)) {
      // if month not selected, use full year
      if (empty( $monthToShow)) {
        $rangeStart = jcUserTimeToUTC( 0,0,0,1,1,$yearToShow);  // we must use server time, not UTC
        $rangeEnd = jcUserTimeToUTC( 23,59,59,12,31,$yearToShow);
      } else {
        // we have a month and a year, use them
        // number of days in current month
        $nr = date("t", TSServerToUser( mktime(1,0,1,$monthToShow,5,$yearToShow)));
        // find range
        $rangeStart = jcUserTimeToUTC( 0,0,0,$monthToShow,1,$yearToShow);  // we must use server time, not UTC
        $rangeEnd = jcUserTimeToUTC( 23,59,59,$monthToShow,$nr,$yearToShow);
      }

      // create condition
      // convert to mysql date time, for query
      $startOfFirstDaySql = $db->Quote( $rangeStart);
      $endOfLastDaySql = $db->Quote( $rangeEnd);

      // conditions on date of the event
      $rangeCondition  = "( ( (#__jcalpro2_events.end_date != '" . JCL_ALL_DAY_EVENT_END_DATE . "' AND #__jcalpro2_events.end_date != '"
      . JCL_ALL_DAY_EVENT_END_DATE_LEGACY . "' AND #__jcalpro2_events.end_date != '" . JCL_ALL_DAY_EVENT_END_DATE_LEGACY_2
      . "')  AND (( #__jcalpro2_events.start_date <= $startOfFirstDaySql AND #__jcalpro2_events.end_date >= $endOfLastDaySql) ";
      $rangeCondition .= "  OR ( #__jcalpro2_events.end_date > $startOfFirstDaySql AND #__jcalpro2_events.end_date <= $endOfLastDaySql )) )";
      $rangeCondition .= "  OR ( #__jcalpro2_events.start_date > $startOfFirstDaySql AND #__jcalpro2_events.start_date <= $endOfLastDaySql) )";

      $where[] = $rangeCondition;

      // reset dateRange
      $dateRange = JCL_LIST_ALL_EVENTS;
    } else {
      // reset month selection, if there is no year selected
      $monthToShow = 0;
    }

    if ($dateRange != JCL_LIST_ALL_EVENTS) {
      $where[] = jclBuildRangeWhereCondition( $dateRange);
    }

    if ( isset ( $where ) )  {
      $where = "\n WHERE ". implode( ' AND ', $where );
    } else{
      $where = '';
    }

    // build the ordering
    $orderBy = "\n ORDER BY ";
    //
    switch ($order) {
      case 'order_by_title':
        $orderBy .= '#__jcalpro2_events.title ' . $orderDir . ', calendarName, categoryName,  UNIX_TIMESTAMP(#__jcalpro2_events.start_date) ASC';
        break;
      case 'order_by_calendar':
        $orderBy .= 'calendarName ' . $orderDir . ', categoryName, UNIX_TIMESTAMP(#__jcalpro2_events.start_date),  #__jcalpro2_events.title ASC';
        break;
      case 'order_by_category':
        $orderBy .= 'categoryName ' . $orderDir . ', calendarName, UNIX_TIMESTAMP(#__jcalpro2_events.start_date),  #__jcalpro2_events.title ASC';
        break;
      case  'order_by_end_time' :
        $orderBy .= 'UNIX_TIMESTAMP(#__jcalpro2_events.end_date) ' . $orderDir . ', calendarName, categoryName,  #__jcalpro2_events.title ASC';
        break;
      case 'order_by_kind':
        $orderBy .= '#__jcalpro2_events.rec_type_select ' . $orderDir . ', calendarName, categoryName,  UNIX_TIMESTAMP(#__jcalpro2_events.start_date) ASC, #__jcalpro2_events.title';
        break;
      case 'order_by_owner':
        $orderBy .= 'userName ' . $orderDir . ', calendarName, categoryName,  UNIX_TIMESTAMP(#__jcalpro2_events.start_date) ASC, #__jcalpro2_events.title';
        break;
      case 'order_by_privacy':
        $orderBy .= '#__jcalpro2_events.private ' . $orderDir . ', calendarName, categoryName,  UNIX_TIMESTAMP(#__jcalpro2_events.start_date) ASC, #__jcalpro2_events.title';
        break;
      case 'order_by_start_time':
      default:
        $orderBy .= 'UNIX_TIMESTAMP(#__jcalpro2_events.start_date) ' . $orderDir . ', calendarName, categoryName,  #__jcalpro2_events.title ASC';
        break;
    }
    // get the total number of records
    $db->setQuery( "SELECT COUNT(*) FROM #__jcalpro2_events $where" );
    $total = $db->loadResult();

    jimport('joomla.html.pagination');
    $output->pageNav = new JPagination($total, $limitstart, $limit);

    // get the subset (based on limits) of required records
    $query = "SELECT #__jcalpro2_events.*, #__jcalpro2_calendars.cal_name as calendarName, #__jcalpro2_categories.cat_name as categoryName, #__users.username as userName"
    . "\n FROM #__jcalpro2_events"
    . "\n LEFT JOIN #__jcalpro2_calendars"
    . "\n ON #__jcalpro2_events.cal_id = #__jcalpro2_calendars.cal_id"
    . "\n LEFT JOIN #__jcalpro2_categories"
    . "\n ON #__jcalpro2_events.cat = #__jcalpro2_categories.cat_id"
    . "\n LEFT JOIN #__users"
    . "\n ON #__jcalpro2_events.owner_id = #__users.id"
    . $where
    . $orderBy
    . "\n LIMIT " . $output->pageNav->limitstart . ", " . $output->pageNav->limit
    ;

    $db->setQuery( $query );
    $output->rows = $db->loadObjectList();

    // build categories select list
    $db->setQuery ( "SELECT * FROM #__jcalpro2_categories WHERE published = '1' ORDER BY cat_name" );
    $categoriesList[]     = JHTML::_('select.option', '0', 'Select Category', 'cat_id', 'cat_name' );
    $categoriesList     = array_merge ( $categoriesList, $db->loadObjectList ( ) );
    $output->lists['categories']     = JHTML::_('select.genericlist', $categoriesList, 'cat', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"','cat_id', 'cat_name', $cat );

    // build calendars select list
    $db->setQuery ( "SELECT * FROM #__jcalpro2_calendars WHERE published = '1' ORDER BY cal_name" );
    $calendarsList[]     = JHTML::_('select.option', '0', 'Select calendar', 'cal_id', 'cal_name' );
    $calendarsList     = array_merge ( $calendarsList, $db->loadObjectList ( ) );
    $output->lists['calendars']     = JHTML::_('select.genericlist', $calendarsList, 'cal_id', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"','cal_id', 'cal_name', $cal_id );

    // build date range select list
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_ALL_EVENTS, 'Select a date range', 'range_id', 'range_name' );
    $dateRangeList[]      = JHTML::_('select.option', JCL_LIST_PAST_EVENTS, 'Past events', 'range_id', 'range_name' );
    $dateRangeList[]      = JHTML::_('select.option', JCL_LIST_UPCOMING_EVENTS, 'Upcoming events', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_THIS_WEEK_EVENTS, 'This week', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_LAST_WEEK_EVENTS, 'Last week', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_NEXT_WEEK_EVENTS, 'Next week', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_THIS_MONTH_EVENTS, 'This month', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_LAST_MONTH_EVENTS, 'Last month', 'range_id', 'range_name' );
    $dateRangeList[]     = JHTML::_('select.option', JCL_LIST_NEXT_MONTH_EVENTS, 'Next month', 'range_id', 'range_name' );
    $output->lists['date_range']     = JHTML::_('select.genericlist', $dateRangeList, 'date_range', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"','range_id', 'range_name', $dateRange );

    // building month list
    $monthList[] = JHTML::_( 'select.option', 0, 'Select month', 'month_id', 'month_name' );
    for ( $i = 1; $i <= 12; $i++ ) {
      $monthList[] = JHTML::_( 'select.option', $i, $lang_date_format['months'][$i-1], 'month_id', 'month_name' );
    }
    $onChange =  !empty($yearToShow) && empty( $monthToShow) ? ' onchange="document.adminForm.submit();"' : '';
    $output->lists['month_to_show']     = JHTML::_('select.genericlist',  $monthList, 'month_to_show',
  'class="inputbox" size="1"' . $onChange,'month_id', 'month_name', $monthToShow );

    // building year list
    $y = jcServerDateToFormat( extcal_get_local_time(), '%Y') - JCL_NUMBER_YEARS_TO_SHOW_BEFORE;
    $yearList[] = JHTML::_( 'select.option', 0, 'Select year', 'year_id', 'year_name' );
    for ( $i = 1; $i <= JCL_NUMBER_YEARS_TO_SHOW_AFTER; $i++ ) {
      $yearList[] = JHTML::_( 'select.option', $y, $y, 'year_id', 'year_name' );
      $y++;
    }
    $output->lists['year_to_show']     = JHTML::_('select.genericlist',  $yearList, 'year_to_show',
  'class="inputbox" size="1" onchange="document.adminForm.submit();"','year_id', 'year_name', $yearToShow );

    // build show children check box
    $showChildrenList[]     = JHTML::_('select.option', '1', 'Show recurring events children', 'show_children_id', 'show_children_name');
    $showChildrenList[]     = JHTML::_('select.option', '0', 'Hide recurring events children', 'show_children_id', 'show_children_name' );
    $output->lists['show_children'] = JHTML::_('select.genericlist', $showChildrenList, 'show_children', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"','show_children_id', 'show_children_name', $showChildren );
    
    // build published/approved selects
    foreach (array('published', 'approved') as $filter) {
    	$filterList = array();
	    $filterList[] = JHTML::_('select.option', '0', 'Select state', "{$filter}_id", "{$filter}_name");
	    $filterList[] = JHTML::_('select.option', '1', "{$filter}", "{$filter}_id", "{$filter}_name");
	    $filterList[] = JHTML::_('select.option', '-1', "un{$filter}", "{$filter}_id", "{$filter}_name");
	    $output->lists[$filter] = JHTML::_('select.genericlist', $filterList, $filter, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', "{$filter}_id", "{$filter}_name", $$filter);
    }

    return $output;
  }
  
  
  /**
   * Creates a new or edits and existing user record
   * @param int The id of the record, 0 if a new entry
   * @param string The current GET/POST option
   */
  function editEvent ( $id, $option, $section )
  {

    global $lang_date_format, $today, $CONFIG_EXT, $lang_add_event_view, $mainframe, $lang_general;

    $db = &JFactory::getDBO();
    $acl = &JFactory::getACL();
    $user = &JFactory::getUser();

    include_once JPATH_COMPONENT_SITE . DS . 'jcalpro.class.php';
    include_once JPATH_COMPONENT_SITE . DS . 'include' . DS . 'functions.inc.php';

    $row = new JCalEvent();

    // if processing user entry, try to save
    $errors = '';
    $form = array();
    $task = JRequest::getCmd('task');
    if($task == 'save' && count($_POST)) {
      $saved = $this->saveEvent($option, $section, $form, $row);
    } else {
      $saved = false;
    }

    // if saved, we can go back to event list
    if ($saved) {
      $mainframe->redirect( "index.php?option=$option&section=$section");
    }

    // load the row from the db table (only if empti, ie: we are not returning
    // from trying to save some previous data entry with errors

    if ( empty( $form) && $id )    {
      // do stuff for existing records
      $row->loadEvent( $id );
      $row->checkout ( $user->id );
      // histoiral bad thing
      $row->recur_end_count = $row->recur_count;
    } else if (empty( $form)) {  // creating a new event
      // do stuff for new records
      $day = $today['day'];
      $month = $today['month'];
      $year = $today['year'];
      $dst = jclGetDst( $ts);
      $shStart= TSUTCToUser( gmmktime(8, 0, 0, $month, $day, $year), $dst);  // default start = today at 8 am
      $shEnd = $shStart + 3600; // defaul duration = 1h
      $row->start_date = jcUTCDateToFormatNoOffset( $shStart, '%Y-%m-%d %H:%M:%S');
      $row->end_date = jcUTCDateToFormatNoOffset( $shEnd, '%Y-%m-%d %H:%M:%S');
      $row->published = 1;
      $row->approved = 1;
      $row->cat = 1;

      $row->autoapprove = true;
      $row->end_days = '0';
      $row->end_hours = '1';
      $row->end_minutes = '0';
      $row->start_time_hour = '8';
      $row->start_time_minute = '0';
      $row->start_time_ampm = 'am';
      $row->day = $day;
      $row->month = $month;
      $row->year = $year;
      $row->cal_id = $CONFIG_EXT['default_calendar'];
      $user = &JFactory::getUser();
      $row->owner_id = $user->guest ? JCL_DEFAULT_OWNER_ID : $user->id;
      $row->private = JCL_EVENT_PUBLIC;
      // initial values for recurrence
      $row->recur_end_type = JCL_RECUR_SO_MANY_OCCURENCES;
      $row->recur_end_count = '2';
      $row->duration_type = '1';

      // V 2.1.x : new recurrence type options
      // general
      $row->rec_type_select = JCL_REC_TYPE_NONE;

      // daily
      $row->rec_daily_period = 1;

      // weekly
      $row->rec_weekly_period = 1;
      $row->rec_weekly_on_monday = 0;
      $row->rec_weekly_on_tuesday = 0;
      $row->rec_weekly_on_wednesday = 0;
      $row->rec_weekly_on_thursday = 0;
      $row->rec_weekly_on_friday = 0;
      $row->rec_weekly_on_saturday = 0;
      $row->rec_weekly_on_sunday = 0;

      // monthly
      $row->rec_monthly_period = 1;
      $row->rec_monthly_type = JCL_REC_ON_DAY_NUMBER;
      $row->rec_monthly_day_number = 1;
      $row->rec_monthly_day_list = '';
      $row->rec_monthly_day_order = JCL_REC_FIRST;
      $row->rec_monthly_day_type = JCL_REC_DAY_TYPE_DAY;

      // yearly
      $row->rec_yearly_period = 1;
      $row->rec_yearly_on_month = JCL_REC_JANUARY;
      $row->rec_yearly_on_month_list = '';
      $row->rec_yearly_type = JCL_REC_ON_DAY_NUMBER;
      $row->rec_yearly_day_number = 1;
      $row->rec_yearly_day_order = JCL_REC_FIRST;
      $row->rec_yearly_day_type = JCL_REC_DAY_TYPE_DAY;

      // end date
      $row->recur_until = jcServerDateToFormat( extcal_get_local_time(), '%Y-%m-%d %H:%M:%S');

    } else  {
      //reset task : we are editing an event on which an error was detected
      JRequest::setVar( 'task', 'edit');
    }

    // quick fix
    if (empty( $row->recur_end_count)) {
      $row->recur_end_count = $row->recur_count;
    }

    $lists = array();

    $startDateArr = array();
    $startDateArr['mday'] = jcUTCDateToFormat( $row->start_date, '%d');
    $startDateArr['mon'] = jcUTCDateToFormat( $row->start_date, '%m');
    $startDateArr['year'] = jcUTCDateToFormat( $row->start_date, '%Y');
    $startDateArr['minutes'] = jcUTCDateToFormat( $row->start_date, '%M');

    $startDateArr['hours'] = (int) jcUTCDateToFormat( $row->start_date, '%H');
    $row->start_time_ampm = '';

    if( $row->recur_until == "0000-00-00" ) {
      $recurUntilStamp = $row->start_date;
    } else {
      $recurUntilStamp = $row->recur_until . '23:59:59' ;
    }

    $recurUntilArr = array();
    $recurUntilArr['mday'] = jcUTCDateToFormat( $recurUntilStamp, '%d');
    $recurUntilArr['mon'] = jcUTCDateToFormat( $recurUntilStamp, '%m');
    $recurUntilArr['year'] = jcUTCDateToFormat( $recurUntilStamp, '%Y');
    $recurUntilArr['hours'] = jcUTCDateToFormat( $recurUntilStamp, '%H');
    $recurUntilArr['minutes'] = jcUTCDateToFormat( $recurUntilStamp, '%M');

    $lists['recuringDay'] = $recurUntilArr['mday'];
    $lists['recuringMonth'] = $recurUntilArr['mon'];
    $lists['recuringYear'] = $recurUntilArr['year'];

    if ( jclIsNoEndDate( $row->end_date) || jclIsAllDay( $row->end_date) ) {
      $row->durationType = jclIsAllDay( $row->end_date) ? 2 : 0;
      $row->endDays = '0';
      $row->endHours = '0';
      $row->endMinutes = '0';
    } else {
      $duration_array = datestoduration ( $row->start_date, $row->end_date );
      $row->endDays = $duration_array['days'];
      $row->endHours = $duration_array['hours'];
      $row->endMinutes = $duration_array['minutes'];
      $row->durationType = 1;
    }

    $lists['previous_recur_type'] = $row->rec_type_select;

    $checked['normal'] = ( ( int ) $row->durationType == 1 ) ? 'checked' : '';
    $checked['allday'] = ( ( int ) $row->durationType == 2 ) ? 'checked' : '';
    $checked['none'] = ( ( int ) $row->durationType == 0 ) ? 'checked' : '';

    $lists['published'] = JHTML::_( 'select.booleanlist', 'published', '', $row->published );
    $lists['approved'] = JHTML::_( 'select.booleanlist', 'approved', '', $row->approved );

    // build privacy options list
    $privateMsgs = array( JCL_EVENT_PUBLIC => $lang_add_event_view['public_event'], JCL_EVENT_PRIVATE => $lang_add_event_view['private_event'],
    JCL_EVENT_PRIVATE_READ_ONLY => $lang_add_event_view['private_event_read_only']);

    $privacyList = array();
    foreach( $privateMsgs as $key => $value) {
      $privacyList[] = JHTML::_( 'select.option', $key, $value, 'priv_id', 'priv_name');
    }

    $lists['private']     = JHTML::_('select.genericlist',  $privacyList, 'private', 'class="inputbox" size="1"', 'priv_id', 'priv_name', $row->private );

    // Build categories select list
    $template = "<select name='cat' class='listbox'>
                                        {OPTIONS}
                                </select>";
    $lists['categories'] = jclBuildCategoriesList( $row->catId);
    if (!empty($lists['categories'] )) {
      $lists['categories'] = str_replace( '{OPTIONS}', $lists['categories'], $template);
    }
    $lists['calendars'] = jclBuildSimpleCalendarList( $row->cal_id);
    if (!empty($lists['calendars'] )) {
      $template = "<select name='cal_id' class='listbox'>
                                        {OPTIONS}
                                </select>";
      $lists['calendars'] = str_replace( '{OPTIONS}', $lists['calendars'], $template);
    }
    // building day list
    for ( $i = 1; $i <= 31; $i++ ) {
      $daysList[] = JHTML::_( 'select.option', $i, $i, 'day_id', 'day_name' );
    }

    $lists['days']     = JHTML::_('select.genericlist',  $daysList, 'day', 'class="inputbox" size="1"','day_id', 'day_name', $startDateArr['mday'] );

    // building month list
    for ( $i = 1; $i <= 12; $i++ ) {
      $monthList[] = JHTML::_( 'select.option', $i, $lang_date_format['months'][$i-1], 'month_id', 'month_name' );
    }

    $lists['months']     = JHTML::_('select.genericlist',  $monthList, 'month', 'class="inputbox" size="1"','month_id', 'month_name', $startDateArr['mon'] );

    // building year list

    $y = jcServerDateToFormat( extcal_get_local_time(), '%Y') - JCL_NUMBER_YEARS_TO_SHOW_BEFORE;

    for ( $i = 1; $i <= JCL_NUMBER_YEARS_TO_SHOW_AFTER; $i++ ) {
      $yearList[] = JHTML::_( 'select.option', $y, $y, 'year_id', 'year_name' );
      $y++;
    }

    $lists['years']     = JHTML::_('select.genericlist',  $yearList, 'year', 'class="inputbox" size="1"','year_id', 'year_name', $startDateArr['year'] );

    // building time list options
    // we now always use the 24 hours template, in order to remove ambiguity between noon and midnight on am/pm mode
    $hour_init = 0;
    $hour_limit = 23;
    $start_hour_list = array();
    for ($i = $hour_init;$i<=$hour_limit;$i++)
    {
      // find display value depending on setting :
      if($CONFIG_EXT['time_format_24hours']) {
        // 24 hours
        $displayItem = sprintf("%02d",$i);
      } else {
        // amp/pm
        if ($i == 0) {
          $displayItem = '00 '. $lang_general['midnight'];
        } else if ($i == 12) {
          $displayItem = '12 '. $lang_general['noon'];
        } else if ($i > 0 && $i < 12) {
          $displayItem = sprintf("%02d",$i) . ' ' . $lang_general['am'];
        } else {
          $displayItem = sprintf("%02d",$i - 12) . ' ' . $lang_general['pm'];
        }

      }
      $start_hour_list[] = JHTML::_( 'select.option', $i, $displayItem, 'hour_id', 'hour_name' );

    }
    $lists['hours']     = JHTML::_('select.genericlist',  $start_hour_list, 'hours', 'class="inputbox" size="1"','hour_id', 'hour_name', $startDateArr['hours'] );


    // building minutes list
    for ( $i = 0; $i <= 59; $i++ ) {
      $minutesList[] = JHTML::_( 'select.option', sprintf ( "%02d", $i ), sprintf ( "%02d", $i ), 'minute_id', 'minute_name' );
    }

    $lists['minutes']     = JHTML::_('select.genericlist',  $minutesList, 'minutes', 'class="inputbox" size="1"','minute_id', 'minute_name', $startDateArr['minutes'] );

    // @TODO : remove
    $lists['ampm'] = '';

    $row->description = html_entity_decode ( $row->description, ENT_COMPAT, 'UTF-8');  // J 1.5.x+ needs utf-8

    // V 2.1.x : new recurrence options

    if (empty($row->rec_id)) {
      // this is a regular event, not a child of another recurring event
      // recurrence type selection : none, daily, weekly, monthly, yearly
      $options = array(
      array( 'value' => JCL_REC_TYPE_NONE, 'text' => $lang_add_event_view['repeat_none'], 'attrib' => 'onclick = "jclShowRecOptions(\'none\');"', 'id' => '')
      ,array( 'value' => JCL_REC_TYPE_DAILY, 'text' => $lang_add_event_view['repeat_daily'], 'attrib' => 'onclick = "jclShowRecOptions(\'daily\');"', 'id' => '')
      ,array( 'value' => JCL_REC_TYPE_WEEKLY, 'text' => $lang_add_event_view['repeat_weekly'], 'attrib' => 'onclick = "jclShowRecOptions(\'weekly\');"', 'id' => '')
      ,array( 'value' => JCL_REC_TYPE_MONTHLY, 'text' => $lang_add_event_view['repeat_monthly'], 'attrib' => 'onclick = "jclShowRecOptions(\'monthly\');"', 'id' => '')
      ,array( 'value' => JCL_REC_TYPE_YEARLY, 'text' => $lang_add_event_view['repeat_yearly'], 'attrib' => 'onclick = "jclShowRecOptions(\'yearly\');"', 'id' => '')
      );
      $lists['recTypeSelectHtml'] = jclBuildRadioList( $options, 'rec_type_select', $row->rec_type_select, null, false, true);

      // weekly recurrence options
      $options = array(
      array( 'value' => '1', 'name' => 'rec_weekly_on_monday', 'text' => $lang_date_format['day_of_week'][1], 'checked' => $row->rec_weekly_on_monday ? $row->rec_weekly_on_monday : '', 'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_tuesday', 'text' => $lang_date_format['day_of_week'][2], 'checked' => $row->rec_weekly_on_tuesday ? $row->rec_weekly_on_tuesday : '', 'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_wednesday', 'text' => $lang_date_format['day_of_week'][3], 'checked' => $row->rec_weekly_on_wednesday ? $row->rec_weekly_on_wednesday : '',  'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_thursday', 'text' => $lang_date_format['day_of_week'][4], 'checked' => $row->rec_weekly_on_thursday ? $row->rec_weekly_on_thursday : '', 'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_friday', 'text' => $lang_date_format['day_of_week'][5], 'checked' => $row->rec_weekly_on_friday ? $row->rec_weekly_on_friday : '', 'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_saturday', 'text' => $lang_date_format['day_of_week'][6], 'checked' => $row->rec_weekly_on_saturday ? $row->rec_weekly_on_saturday : '',  'attrib' => '', 'id' => '')
      , array( 'value' => '1', 'name' => 'rec_weekly_on_sunday', 'text' => $lang_date_format['day_of_week'][0], 'checked' => $row->rec_weekly_on_sunday ? $row->rec_weekly_on_sunday : '',  'attrib' => '', 'id' => '')
      );

      if (!$CONFIG_EXT['day_start']) {
        // week starts on sunday
        $tmp = $options[6];
        array_unshift( $options, $tmp);
        unset( $options[7]);
      }

      $lists['rec_weekly_on_day_checkboxes'] = jclBuildCheckBoxesList( $options, false, false);

      // monthly recurrence options
      $lists['recMonthlyTypeOnDayNumber'] = jclBuildRadioListItem( 'rec_monthly_type', 'rec_monthly_type0', '0', $row->rec_monthly_type == JCL_REC_ON_DAY_NUMBER, $lang_add_event_view['rec_monthly_on'], '', false);
      $lists['recMonthlyTypeOnSpecificDay'] = jclBuildRadioListItem( 'rec_monthly_type', 'rec_monthly_type1', '1', $row->rec_monthly_type == JCL_REC_ON_SPECIFIC_DAY, $lang_add_event_view['rec_monthly_on'], '', false);
      $lists['rec_monthly_day_order'] = jclBuildDayOrderList( 'rec_monthly_day_order', $row->rec_monthly_day_order, 'class="listbox" onChange="document.getElementById(\'rec_monthly_type0\').checked=false; document.getElementById(\'rec_monthly_type1\').checked=true;"');
      $lists['rec_monthly_day_type'] = jclBuildDayTypeList( 'rec_monthly_day_type', $row->rec_monthly_day_type, 'class="listbox" onChange="document.getElementById(\'rec_monthly_type0\').checked=false; document.getElementById(\'rec_monthly_type1\').checked=true;"');

      // yearly recurrence options
      $lists['recYearlyTypeOnDayNumber'] = jclBuildRadioListItem( 'rec_yearly_type', 'rec_yearly_type0', '0', $row->rec_yearly_type == JCL_REC_ON_DAY_NUMBER,
      $lang_add_event_view['rec_yearly_on'], '', false);
      $lists['recYearlyTypeOnSpecificDay'] = jclBuildRadioListItem( 'rec_yearly_type', 'rec_yearly_type1', '1', $row->rec_yearly_type == JCL_REC_ON_SPECIFIC_DAY,
      $lang_add_event_view['rec_yearly_on'], '', false);
      $lists['rec_yearly_day_order'] = jclBuildDayOrderList( 'rec_yearly_day_order', $row->rec_yearly_day_order, 'class="listbox" onChange="document.getElementById(\'rec_yearly_type0\').checked=false; document.getElementById(\'rec_yearly_type1\').checked=true;"');
      $lists['rec_yearly_day_type'] = jclBuildDayTypeList( 'rec_yearly_day_type', $row->rec_yearly_day_type, 'class="listbox" onChange="document.getElementById(\'rec_yearly_type0\').checked=false; document.getElementById(\'rec_yearly_type1\').checked=true;"');
      $lists['rec_yearly_on_month'] = jclBuildGenericList( 'rec_yearly_on_month', $row->rec_yearly_on_month,  $lang_date_format['months'], 'class="listbox"');
      $lists['rec_recur_until'] = JHTML::_( 'calendar', jcUTCDateToFormatNoOffset( $row->recur_until, $lang_date_format['date_entry']), 'rec_recur_until', 'rec_recur_until', $lang_date_format['date_entry'], 'class="textinput"');
    } else {
      // this is a child of a recurrent event, we don't display recurrence options, but we need to pass them on as hidden fields to preserve them
      $options = array(
      array( 'name'=>'rec_weekly_on_monday', 'value'=>$row->rec_weekly_on_monday),
      array( 'name'=>'rec_weekly_on_tuesday', 'value'=>$row->rec_weekly_on_tuesday),
      array( 'name'=>'rec_weekly_on_wednesday', 'value'=>$row->rec_weekly_on_wednesday),
      array( 'name'=>'rec_weekly_on_thursday', 'value'=>$row->rec_weekly_on_thursday),
      array( 'name'=>'rec_weekly_on_friday', 'value'=>$row->rec_weekly_on_friday),
      array( 'name'=>'rec_weekly_on_saturday', 'value'=>$row->rec_weekly_on_saturday),
      array( 'name'=>'rec_weekly_on_sunday', 'value'=>$row->rec_weekly_on_sunday)
      );
      $lists['rec_weekly_on_day_checkboxes'] = jclBuildHiddenFields( $options);
      $options = array(
      array( 'name'=>'rec_monthly_day_order', 'value'=>$row->rec_monthly_day_order)
      );
      $lists['rec_monthly_day_order'] = jclBuildHiddenFields( $options);
      $options = array(
      array( 'name'=>'rec_monthly_day_type', 'value'=>$row->rec_monthly_day_type)
      );
      $lists['rec_monthly_day_type'] = jclBuildHiddenFields( $options);
      $options = array(
      array( 'name'=>'rec_yearly_on_month', 'value'=>$row->rec_yearly_on_month)
      );
      $lists['rec_yearly_on_month'] = jclBuildHiddenFields( $options);
      $options = array(
      array( 'name'=>'rec_yearly_day_order', 'value'=>$row->rec_yearly_day_order)
      );
      $lists['rec_yearly_day_order'] = jclBuildHiddenFields( $options);
      $options = array(
      array( 'name'=>'rec_yearly_day_type', 'value'=>$row->rec_yearly_day_type)
      );
      $lists['rec_yearly_day_type'] = jclBuildHiddenFields( $options);

      $recRecurUntil = jclBuildHiddenFields( array( array('name' => 'recur_until', 'value' => $row->rec_recur_until)));
    }
    // end of recurrence calendar input

    include_once dirname(__FILE__) . DS . 'events.html.php';
    HTML_events::editEvent ( $row, $lists, $checked, $option, $section );
  }

  /**
   * Saves the record from an edit form submit
   * @param string The current GET/POST option
   */
  function saveEvent ( $option, $section, & $form, &$event )
  {
    global $CONFIG_EXT, $mainframe, $lang_event_admin_data, $lang_add_event_view, $lang_date_format, $mainframe;
    $db = &JFactory::getDBO();

    include_once JPATH_COMPONENT_SITE . DS . 'jcalpro.class.php';

    $form = array();

    // get POSTed values
    if(count($_POST)) {
      foreach( $_POST as $postKey => $postValue) {
        if ($postKey == 'description' && $CONFIG_EXT['addevent_allow_html']) {
          $form[$postKey] = JRequest::getVar( $postKey, null, 'POST', 'STRING', JREQUEST_ALLOWRAW);
        } else {
          $form[$postKey] = JRequest::getVar( $postKey, null, 'POST');
        }
      }
    }

    $day = isset($form['day'])?$form['day']:$today['day'];  // warning these have timezone offset in them, not suitable
    $month = isset($form['month'])?$form['month']:$today['month'];  // for writing to DB, which must have UTC times
    $year = isset($form['year'])?$form['year']:$today['year'];

    if (isset($form['title'])) $title = $form['title']; else $title = '';
    if (isset($form['description'])) $description = $form['description']; else $description = '';
    if (isset($form['contact'])) $contact = $form['contact']; else $contact = '';
    if (isset($form['email'])) $email = $form['email']; else $email = '';
    if (isset($form['url'])) $url = $form['url']; else $url = '';
    if (intval($form['cat'])>0) $cat = $form['cat']; else $cat = '';
    if (intval($form['cal_id'])>0) $cal_id = $form['cal_id']; else $cal_id = $CONFIG_EXT['default_calendar'];

    // Clean description

    if ( !$CONFIG_EXT['addevent_allow_html'] ) {
      $description = strip_tags ( $description );
      $description = preg_replace("'<script[^>]*?>.*?</script>'si", "", $description);
      $description = preg_replace("'<head[^>]*?>.*?</head>'si", "", $description);
      $description = preg_replace("'<body[^>]*?>.*?</body>'si", "", $description);
      $description = str_replace('&','&amp;',$description);
    }

    $description = html_entity_decode($description, ENT_COMPAT, 'UTF-8');

    if(count($form)) {
      // Process user submission

      // Form Validation
      $errors = '';
      if (empty($title)) $errors .=  $lang_add_event_view['no_title'];
      if (empty($cat)) $errors .= !empty( $errors) ? '' : $lang_add_event_view['no_cat'];
      if (empty($cal_id)) $errors .= !empty( $errors) ? '' : $lang_add_event_view['no_calendar'];
      if (empty($day) || empty($month) || empty($year) || !checkdate($month,$day,$year)) $errors .= !empty( $errors) ? '' : $lang_add_event_view['date_invalid'];

      // no end date for repeat event not allowed any more see bug tracker #10594
      if ($form['rec_type_select'] == JCL_REC_TYPE_NONE && $form['recur_end_type'] == JCL_RECUR_NO_LIMIT) {
        $errors .= theme_error_string($lang_add_event_view['no_recur_end_date']);
      }

      // get repeat until date, extract elements and check them
      $rec_recur_until = jclExtractDetailsFromDate( $form['rec_recur_until'], $lang_date_format['date_entry']);
      if ($form['rec_type_select'] != JCL_REC_TYPE_NONE && empty( $form['rec_id'])) {
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
          if (!is_numeric($form['end_days'])) { $errors .= !empty( $errors) ? '' : $lang_add_event_view['end_days_invalid']; }
          if (!is_numeric($form['end_hours'])) { $errors .= !empty( $errors) ? '' : $lang_add_event_view['end_hours_invalid']; }
          if (!is_numeric($form['end_minutes'])) { $errors .= !empty( $errors) ? '' : $lang_add_event_view['end_minutes_invalid']; }
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
            break;
        }
      }
      if(!$errors) {

        // JCal Pro 2 : private events
        $private = empty( $form['private'] ) ? 0 : 1;

        $start_time_hour = $form['hours']; // 24 hours mode

        $startTs = gmmktime($start_time_hour, $form['minutes'], 0, $month, $day, $year);
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
        $picture = '';
        $owner_id = $form['owner_id'];
        $approve = jclSetNotNull( $form['approved'], 0);
        $registration_url = '';
        $published = $form['published'];

        // readjust day, month, year to the UTC values
        $startDateTS = jcUTCDateToTs( $start_date);
        $day = jcUTCDateToFormatNoOffset( $startDateTS, '%d');
        $month = jcUTCDateToFormatNoOffset( $startDateTS, '%m');
        $year = jcUTCDateToFormatNoOffset( $startDateTS, '%Y');


        $successful = false;
        if (empty( $form['extid'])) {
          // first check that start_date is first recurrence of a series (for recurring events only)
          // this can only be done very late in the process, as the event data must be complete before checking
          $checkOnly = true;
          $successful = createEvent( $cal_id, $form['owner_id'], $title, $description, $contact, $url, $registration_url, $email, $picture, $cat, $day, $month, $year, $approve, $private, $start_date,
          $end_date, $published, $form['recur_end_type'], $form['recur_end_count'], $recur_until, $form, $rec_id = 0, $detached_from_rec = 0, $checkOnly);

          if ($successful) {
            // call function to store event data in database, and create all recurring children events if needed
            $successful = createEvent( $cal_id, $form['owner_id'], $title, $description, $contact, $url, $registration_url, $email, $picture, $cat, $day, $month, $year, $approve, $private, $start_date,
            $end_date, $published, $form['recur_end_type'], $form['recur_end_count'], $recur_until, $form);
          } else {
            $errors .= $lang_add_event_view['recur_start_date_invalid'];
          }
        }

        if (!$successful) {
          // updating an existing event or preparing for new user input, in case an error was detected
          // prepare storage
          // create a structure for easier handling

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

          // now update database, various cases based on what was the recurring option of
          // the event before user started editing it
          if (!empty( $form['extid'])) {
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
          }
        }

        // show feedback
        if ( $successful && $approve ) {
          $message = $lang_event_admin_data['edit_event_success'];
          $mainframe->enqueueMessage( $message);
          return true;
        } else if ($successful) {
          $message = $lang_add_event_view['submit_event_pending'];
          $mainframe->enqueueMessage( $message);
          return true;
        } else {
          // there was an error
          $mainframe->enqueueMessage( $errors);
          return false;
        }
      }
    }

    if (empty( $errors)) {
      return true;
    } else {
      $mainframe->enqueueMessage( $errors);
      return false;
    }
  }

  /**
   * Removes records
   * @param array An array of id keys to remove
   * @param string The current GET/POST option
   */
  function removeEvents( &$cid, $option, $section )
  {
    global $mainframe, $CONFIG_EXT;
    $db = &JFactory::getDBO();

    if ( count ( $cid ) )
    {
      $cids = implode ( ',', $cid );

      $query = 'DELETE FROM ' . $CONFIG_EXT['TABLE_EVENTS'] . ' where ' . $db->nameQuote( 'extid') . ' IN (' . $cids . ')';
      // delete children events
      $query .= ' OR (' . $db->nameQuote( 'rec_id') . ' in (' . $cids . ')'
      . ($CONFIG_EXT['update_detached_with_series'] ? ')' : ' AND ' . $db->nameQuote( 'detached_from_rec') . '=\'0\')');

      $db->setQuery( $query);
      $db->query();
      $count = $db->getAffectedRows();
      if ($errNum = $db->getErrorNum()) {
        $msg = 'There was an error trying to delete these events (' . $errNum . ' | ' . $db->getErrorMsg().')';
      } else {
        $msg = 'Deleted ' . $count . ' events from the database';
      }

      $mainframe->redirect( "index.php?option=$option&section=$section", $msg);
    }
  }

  /**
   * Changes the state of one or more content pages
   * @param array An array of unique category id numbers
   * @param integer 0 if unpublishing, 1 if publishing
   * @param string The current option
   */
  function changeEvent ( $cid=null, $state=0, $option, $section )
  {
    global $mainframe;
    $db = &JFactory::getDBO();
    $my = &JFactory::getUser();

    $actions = array( 0=>"unpublish", 1=>"publish", 2=>"remove approval", 3=>"approve" );

    if ( count( $cid ) < 1 )
    {
      echo "<script> alert('Select a record to ".$actions[$state]."'); window.history.go(-1);</script>\n";
      exit;
    }

    $cids = implode ( ',', $cid );

    // 0 = not published, 1 = published
    if( $state == 0 || $state == 1 ) {
      $db->setQuery ( "UPDATE #__jcalpro2_events SET published='$state'"
      . "\nWHERE extid IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
      );
    }
    // 2 = not approved, 3 = approved
    if( $state == 2 || $state == 3 ) {
      $state -= 2;
      $db->setQuery ( "UPDATE #__jcalpro2_events SET approved='$state'"
      . "\nWHERE extid IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
      );
    }

    if ( !$db->query ( ) )
    {
      echo "<script> alert('".$db->getErrorMsg ( )."'); window.history.go(-1); </script>\n";
      exit();
    }

    if ( count( $cid ) == 1 )
    {
      include_once JPATH_COMPONENT_SITE . DS . 'jcalpro.class.php';
      $row = new JCalEvent ();
      $row->checkin ( intval ( $cid[0] ) );
    }

    $mainframe->redirect( "index.php?option=$option&section=$section" );
  }

  /**
   * Copy an event, only changing it database id
   *
   * @param unknown_type $cid
   * @param unknown_type $option
   * @param unknown_type $section
   */
  function copyEvent ( $cid=null, $option, $section ) {
    global $mainframe, $CONFIG_EXT;
    $db = &JFactory::getDBO();
    $my = &JFactory::getUser();

    $status = '';
    $insertId = 0;

    if ( count( $cid ) != 1 ) {
      $status = 'Please select a record to copy';
    }

    if ($status == '') {
      $eventId = intval ($cid[0]);
      $status = empty( $eventId) ? 'Invalid event identifier. Please try again' : '';
    }

    if ($status == '') {
      // now read event from DB
      $query = 'select * from ' . $CONFIG_EXT['TABLE_EVENTS'] . ' where ' . $db->nameQuote( 'extid') . '=' . $db->Quote( $eventId);
      $db->setQuery( $query);
      $event = $db->loadObject();
      $status = empty( $event) ? 'Invalid event identifier. Please try again' : '';
    }

    if ($status == '') {
      
      include_once JPATH_COMPONENT_SITE . DS . 'jcalpro.class.php';
      
      // change afew things in event record
      // new id will be set when inserting
      $event->extid = '';
      $event->checked_out = '0';
      $event->checked_out_time = '0000-00-00 00:00:00';
      if (!empty( $event->rec_id) && empty( $event->detached_from_rec)) {
        // this is a child event, not yet detached, we must copy it as a detached event
        $event->detached_from_rec = '1';
      }

      // setup data as per createEvent function requirements
      $rawData = array();

      $rawData['rec_type_select'] = $event->rec_type_select;

      // daily
      $rawData['rec_daily_period'] = $event->rec_daily_period;

      // weekly
      $rawData['rec_weekly_period'] = $event->rec_weekly_period;
      $rawData['rec_weekly_on_monday'] = $event->rec_weekly_on_monday;
      $rawData['rec_weekly_on_tuesday'] = $event->rec_weekly_on_tuesday;
      $rawData['rec_weekly_on_wednesday'] = $event->rec_weekly_on_wednesday;
      $rawData['rec_weekly_on_thursday'] = $event->rec_weekly_on_thursday;
      $rawData['rec_weekly_on_friday'] = $event->rec_weekly_on_friday;
      $rawData['rec_weekly_on_saturday'] = $event->rec_weekly_on_saturday;
      $rawData['rec_weekly_on_sunday'] = $event->rec_weekly_on_sunday;

      // monthly
      $rawData['rec_monthly_period'] = $event->rec_monthly_period;
      $rawData['rec_monthly_type'] = $event->rec_monthly_type;
      $rawData['rec_monthly_day_number'] = $event->rec_monthly_day_number;
      $rawData['rec_monthly_day_list'] = $event->rec_monthly_day_list;
      $rawData['rec_monthly_day_order'] = $event->rec_monthly_day_order;
      $rawData['rec_monthly_day_type'] = $event->rec_monthly_day_type;

      // yearly
      $rawData['rec_yearly_period'] = $event->rec_yearly_period;
      $rawData['rec_yearly_on_month'] = $event->rec_yearly_on_month;
      $rawData['rec_yearly_on_month_list'] = $event->rec_yearly_on_month_list;
      $rawData['rec_yearly_type'] = $event->rec_yearly_type;
      $rawData['rec_yearly_day_number'] = $event->rec_yearly_day_number;
      $rawData['rec_yearly_day_order'] = $event->rec_yearly_day_order;
      $rawData['rec_yearly_day_type'] = $event->rec_yearly_day_type;

      // now we can write it to db
      $insertId = createEvent( $event->cal_id, $event->owner_id, $event->title, $event->description, $event->contact, $event->url,
      $event->registration_url, $event->email, $event->picture, $event->cat, $event->day, $event->month, $event->year,
      $event->approved, $event->private, $event->start_date, $event->end_date, $event->published, $event->recur_end_type, $event->recur_count, $event->recur_until,
      $rawData, $event->rec_id, $event->detached_from_rec);

      if (empty( $insertId)) {
        $status = 'Error (' . $db->getErrorNum() . ') inserting the copied event in the database';
      }
    }

    if (empty( $status)) {
      // redirect to edit page of the newly created event
      $target = "index.php?option=$option&section=$section&task=editA&hidemainmenu=1&id=" . $insertId;
    } else {
      // redirect to event list
      $target = "index.php?option=$option&section=$section";
    }
    $mainframe->redirect( $target, $status);
  }

  /** PT
   * Cancels editing and checks in the record
   */
  function cancelEvent ( $option, $section )
  {
    global $mainframe;
    $db = &JFactory::getDBO();
    include_once JPATH_COMPONENT_SITE . DS . 'jcalpro.class.php';
    $row = new JCalEvent();
    $row->bind ( $_POST );
    $row->checkin ( ) ;

    $mainframe->redirect( "index.php?option=$option&section=$section" );
  }

  /** PT
   * goback to main menu
   */
  function cancelToMain ( $option, $section)
  {
    global $mainframe;
    $mainframe->redirect( "index.php?option=$option" );
  }

}

