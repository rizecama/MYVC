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

 $Id: controller.php 712 2011-03-08 17:45:00Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class JCalProController extends JController {

  function execute( $task ) {
    global $client;
    $option = JRequest::getVar('option');
    $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    JArrayHelper::toInteger($cid, array(0));
    switch ( $task ) {
      case 'theme':
        $theme = JRequest::getVar( 'theme' );

        $file  = JRequest::getVar( 'file' );
        $path  = 'plugins'.DS.'editors'.DS.'jce'.DS.'jscripts'.DS.'tiny_mce'.DS.'themes' .DS. $theme . '/' . $file;
        include_once JPATH_BASE . DS . $path;
        break;

      case 'main':
        // Look like this is never used (!?)
        $view = &$this->getView( 'Main' );
        $view->display();
        break;

      case 'save':
        saveconfig();

        break;

      case 'config':
        global $eid, $mainframe;

        $mainframe->redirect(
            'index.php?option=com_plugins&client=' . $client . '&task=editA&hidemainmenu=1&id=' . $eid . '' );
        break;

      case 'editlayout':
        global $eid;

        editLayout( $option, $client );
        break;

      case 'savelayout':
        saveLayout( $option, $client );

        break;

      case 'applyaccess':
        applyAccess( $cid, $option, $client );

        break;

      case 'showthemes':
      case 'themes':
        global $eid;
        include_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'themes' . DS . 'themes.php';
        viewThemes( $option, $client );
        break;

      case 'default':
        include_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'themes' . DS . 'themes.php';
        defaultTemplate( $cid[0], $option, $client );
        break;

      case 'newtheme':
      case 'edittheme':
        //editThemes( $option, $id, $client );
        break;

      case 'savetheme':
      case 'applytheme':
        include_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'themes' . DS . 'themes.php';
        saveThemes( $option, $client, $task );

        break;

      case 'canceledit':
        include_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'themes' . DS . 'themes.php';
        cancelEdit( $option, $client );

        break;

      case 'removetheme':
        include_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'themes' . DS . 'themes.php';
        removeTheme( $cid[0], $option, $client );

        break;

      case 'installtheme':
        global $mainframe;

        $mainframe->redirect( 'index.php?option=com_jcalpro&client=' . $client . '&task=install&element=themes' );
        break;

      case 'install':
        $CONFIG_EXT['ADMIN_PATH'] = JPATH_COMPONENT_ADMINISTRATOR; // Your admin file system path
        extcalInstaller( $option, $client, 'show' );
        break;

      case 'uploadfile':
        extcalInstaller( $option, $client, 'uploadfile' );
        break;

      case 'installfromdir':
        extcalInstaller( $option, $client, 'installfromdir' );
        break;

      case 'remove':
        extcalInstaller( $option, $client, 'remove' );
        break;

      case 'categories':
        $this->switchToCategoriesPage();
        break;

      case 'newCategory':
        $this->newCategory( $option );
        break;

      case 'editCategory':
        $this->editCategory( $option );

        break;

      case 'saveCategory':
        $this->saveCategory( $option );
        break;

      case 'cancelEditCategory':
        $this->cancelEditCategory( $option );

        break;

      case 'showCategories':
        $this->showCategories( $option );
        break;

      case 'deleteCategories':
        $this->deleteCategories( $option, $cid );
        break;

      case 'publish':
        $this->publish( $option, $cid, 1 );
        break;

      case 'unpublish':
        $this->publish( $option, $cid, 0 );
        break;

      case 'calendars':
        $this->switchToCalendarsPage();
        break;

      case 'newCalendar':
        $this->newCalendar( $option );
        break;

      case 'editCalendar':
        $this->editCalendar( $option );

        break;

      case 'saveCalendar':
        $this->saveCalendar( $option );
        break;

      case 'cancelEditCalendar':
        $this->cancelEditCalendar( $option );

        break;

      case 'showCalendars':
        $this->showCalendars( $option );
        break;

      case 'deleteCalendars':
        $this->deleteCalendars( $option, $cid );
        break;

      case 'editSettings':
        $this->editSettings( $option );
        break;

      case 'saveSettings':
        $this->saveSettings( $option );
        break;

      case 'cancelEditSettings':
        $this->cancelEditSettings( $option );
        break;

      case 'about':
        $this->showSettings( $option );
        break;

      case 'documentation':
        $this->documentation( $option );
        break;

      case 'importCalendar':
        $this->importCalendar( $option );
        break;

        // manage imports : choice between various import sources
      case 'manageImports':
        $this->manageImports( $option );
        break;

        // handle importing from an ics file
      case 'iCalImportFromFile':
      case 'iCalImportFromURL':
        $this->iCalImportFromFile( $task);
        break;

        // just call the view which always should be set to editor insert
      case 'editorinsert' :
        // make sure the view name is correct
        if(JRequest::getCmd('view') == '') {
          JRequest::setVar('view', 'editorinsert');
        }
        // make sure the editorinsert plugin is installed
        jclCheckEditorInsertInstalled();

        /// then just display the view
        parent::display();
        break;

      default:
        require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
        HTML_extcalendar::showAdmin();
        // hide main menu, to avoid sub-menu display
        JRequest::setVar( 'hidemainmenu', 1);
        break;
    }
  }

  function switchToCategoriesPage() {
    global $mainframe;
    $mainframe->redirect( 'index.php?option=com_jcalpro&task=showCategories' );
  }

  function switchToCalendarsPage() {
    global $mainframe;
    $mainframe->redirect( 'index.php?option=com_jcalpro&task=showCalendars' );
  }

  private function _buildExistingCalendarsList() {
    global $mainframe;

    // get db instance
    $db =&JFactory::getDBO();

    // get db name
    $conf = &JFactory::getConfig();
    $dbName = $conf->getValue( 'config.db');

    // look for some specific tables
    $query = "show tables";
    $db->setQuery( $query );
    $rows = $db->loadObjectList();

    $cals = array();

    // @TODO : we must check version !
    foreach ( $rows as $key => $value ) {
      $name = "Tables_in_$dbName";

      if ( $value->$name == $db->getPrefix() . 'jcalpro_categories' ) {
        $cals[$key]['id']   = 'jcalpro';
        $cals[$key]['name'] = 'JCalPro 1.5.x';
      }
    }
    return $cals;
  }

  /**
   * Performs calendar import from JCalpro 1.5.x
   *
   */
  function importCalendar() {

    global $mainframe, $CONFIG_EXT;

    $db = & JFactory::getDBO();

    // get import type name
    $id = JRequest::getVar( 'id','','GET' );

    // let's keep extcal just in case
    if ( $id == 'extcal' ) {
      $cal[0]['newTable'] = 'categories';
      $cal[0]['oldTable'] = 'categories';

      $cal[0]['fields'] = array
      (
          'cat_id'           => 'cat_id',
          'cat_parent'       => 'cat_parent',
          'cat_name'         => 'cat_name',
          'description'      => 'description',
          'color'            => 'color',
          'bgcolor'          => 'bgcolor',
          'options'          => 'options',
          'published'        => 'published',
          'checked_out'      => 'checked_out',
          'checked_out_time' => 'checked_out_time'
          );

          $cal[2]['newTable'] = 'events';
          $cal[2]['oldTable'] = 'events';

          $cal[2]['fields'] = array
          (
          'extid'          => 'extid',
          'title'          => 'title',
          'description'    => 'description',
          'contact'        => 'contact',
          'url'            => 'url',
          'email'          => 'email',
          'cat'            => 'cat',
          'day'            => 'day',
          'month'          => 'month',
          'year'           => 'year',
          'approved'       => 'approved',
          'start_date'     => 'start_date',
          'end_date'       => 'end_date',
          'recur_type'     => 'recur_type',
          'recur_val'      => 'recur_val',
          'recur_end_type' => 'recur_end_type',
          'recur_count'    => 'recur_count',
          'recur_until'    => 'recur_until'
          );
    }

    // information about columns matches
    if ( $id == 'jcalpro' ) {
      $cal['cats']['newTable'] = 'categories';
      $cal['cats']['oldTable'] = 'categories';
      $cal['cats']['itemName'] = 'categories';

      $cal['cats']['fields'] = array
      (
          'cat_id'           => 'cat_id',
          'cat_parent'       => 'cat_parent',
          'cat_name'         => 'cat_name',
          'description'      => 'description',
          'color'            => 'color',
          'bgcolor'          => 'bgcolor',
          'options'          => 'options',
          'level'            => 'level',
          'published'        => 'published',
          'checked_out'      => 'checked_out',
          'checked_out_time' => 'checked_out_time'
          );

          /*$cal[1]['newTable'] = 'config';
           $cal[1]['oldTable'] = 'config';
           $cal[1]['fields'] = array (
           'name' => 'name',
           'value' => 'value',
           'checked_out' => 'checked_out',
           'checked_out_time' => 'checked_out_time'
           );*/

          $cal['events']['newTable'] = 'events';
          $cal['events']['oldTable'] = 'events';
          $cal['events']['itemName'] = 'events';
          $cal['events']['fields'] = array(
          'extid'          => 'extid',
          'title'          => 'title',
          'description'    => 'description',
          'contact'        => 'contact',
          'url'            => 'url',
          'email'          => 'email',
          'picture'		 => '',
          'cat'            => 'cat',
          'day'            => 'day',
          'month'          => 'month',
          'year'           => 'year',
          'approved'       => 'approved',
          'start_date'     => 'start_date',
          'end_date'       => 'end_date',
          'recur_type'     => 'recur_type',
          'recur_val'      => 'recur_val',
          'recur_end_type' => 'recur_end_type',
          'recur_count'    => 'recur_count',
          'recur_until'    => 'recur_until'
          );
    }

    // import values from categories and config
    if (!empty( $cal)) {
      foreach ( $cal as $calKey => $calValue ) {

        // select all data
        $query = "SELECT * FROM #__" . $id . "_" . $cal[$calKey]['oldTable'];
        $db->setQuery( JString::trim( $query ) );
        $vals = $db->loadObjectList();

        $cal[$calKey]['count'] = 0;

        if (!empty( $vals)) {

          if ($calKey == 'cats') {
            // categories, calendars, config
            // iterate over all data
            foreach ( $vals as $valsKey => $valsValue ) {
              $notFirst = 0;

              $query    = "INSERT IGNORE INTO #__jcalpro2_" . $cal[$calKey]['newTable'];

              foreach ( $cal[$calKey]['fields'] as $fieldsKey => $fieldsValue ) {

                // what's that ?
                if ( preg_match( "/default\(([[:alnum:]]*)\)/", $fieldsValue, $matches ) ) {
                  $setValue=$matches[1];
                } else {
                  $setValue=$valsValue->$fieldsValue;
                }

                // some version of Jcal appeats to have aleading space in front of
                // the 'level' value, at least for 'public frontend'
                if ($valsKey == 'level') {
                  $setValue = JString::trim( $setValue);
                }
                // add new value to query
                if ( $notFirst == 1 ) {
                  $query.=", " . $fieldsKey . " = '" . addslashes( $setValue ) . "'";
                } else {
                  $query.=" SET " . $fieldsKey . " = '" . addslashes( $setValue ) . "'";
                }

                $notFirst = 1;
              }

              // write to new tables
              $db->setQuery( $query );
              $db->query();
              if ($db->getErrorNum()) {
                $mainframe->enqueueMessage( $db->getErrorMsg(), 'error');
              } else {
                $cal[$calKey]['count'] += $db->getAffectedRows();
              }
            }

            // show result
            $mainframe->enqueueMessage( 'Imported ' . $cal[$calKey]['count'] . ' ' . $cal[$calKey]['itemName']);

          } else if ($calKey == 'events') {
            // processing events
            // read events from the original event table
            $query = 'select * from #__' . $id . '_' . $cal['events']['oldTable'];
            $db->setQuery( $query);
            $events = $db->loadObjectList();

            // iterate over events

            if (!empty( $events)) {
              foreach ($events as $event) {

                // array to hold raw values, needed by createEvents function
                $rawData = array();

                // up to 2.0, format was 0000-00-00
                // from 2.0, format is 0000-00-00 00:00:00 with 00:00:00 the time of start_date
                $event->recur_until .= empty($event->recur_type) ? '00:00:00' : JString::substr( $event->start_date, -9);

                // fill the gaps
                $event->cal_id = $CONFIG_EXT['default_calendar'];
                $event->owner_id = $CONFIG_EXT['default_owner_id'];
                $event->registration_url = '';
                $event->private = JCL_EVENT_PUBLIC;

                // update end date marker with 2.0+ version
                if ($event->end_date == JCL_ALL_DAY_EVENT_END_DATE_LEGACY) {
                  $event->end_date = JCL_ALL_DAY_EVENT_END_DATE;
                  $rawData['end_date'] = JCL_ALL_DAY_EVENT_END_DATE;
                }

                // adjust all the recurrence related fields to 2.0+ structure
                if (empty( $event->recur_type)) {
                  // this is a static event
                  $event->rec_type_select = JCL_REC_TYPE_NONE;
                  $rawData['rec_type_select'] = JCL_REC_TYPE_NONE;
                } else {
                  // this is a recurring event
                  // transfer number of recurrence to what we use now
                  $rawData['recur_end_count'] = $event->recur_count;
                  $rawData['recur_end_type'] = $event->recur_end_type;

                  // other transfers or setting depends on the type of reccurence
                  // daily
                  $rawData['rec_daily_period'] = 0;

                  // weekly
                  $rawData['rec_weekly_period'] = 0;
                  $rawData['rec_weekly_on_monday'] = 0;
                  $rawData['rec_weekly_on_tuesday'] = 0;
                  $rawData['rec_weekly_on_wednesday'] = 0;
                  $rawData['rec_weekly_on_thursday'] = 0;
                  $rawData['rec_weekly_on_friday'] = 0;
                  $rawData['rec_weekly_on_saturday'] = 0;
                  $rawData['rec_weekly_on_sunday'] = 0;

                  // monthly
                  $rawData['rec_monthly_period'] = 0;
                  $rawData['rec_monthly_type'] = 0;
                  $rawData['rec_monthly_day_number'] = 0;
                  $rawData['rec_monthly_day_list'] = '';
                  $rawData['rec_monthly_day_order'] = 0;
                  $rawData['rec_monthly_day_type'] = 0;

                  // yearly
                  $rawData['rec_yearly_period'] = 0;
                  $rawData['rec_yearly_on_month'] = 0;
                  $rawData['rec_yearly_on_month_list'] = 0;
                  $rawData['rec_yearly_type'] = 0;
                  $rawData['rec_yearly_day_number'] = 0;
                  $rawData['rec_yearly_day_order'] = 0;
                  $rawData['rec_yearly_day_type'] = 0;

                  // calculate detailed times
                  $start_time_minute = intval( JString::substr( $event->start_date, 14, 2));  //2009-07-12 12:34:56
                  $start_time_hour = intval( JString::substr( $event->start_date, 11, 2));
                  $startDateRec = jclExtractDetailsFromDate( JString::substr( $event->start_date, 0, 10), '%Y-%m-%d');
                  $rec_recur_until = jclExtractDetailsFromDate( JString::substr( $event->recur_until, 0, 10), '%Y-%m-%d');

                  // calculate end date and set rec variables according to type of recurrence
                  switch ( $event->recur_type ) {
                    case 'day' :
                      $rawData['rec_type_select'] = JCL_REC_TYPE_DAILY;
                      $rawData['rec_daily_period'] = $event->recur_val;
                      $ts = gmmktime( $start_time_hour,$start_time_minute,0,$startDateRec->month,$day+($rawData['rec_daily_period']*$rawData['recur_end_count']-1),$year);
                      $dst = jclGetDst( $ts);
                      $enddatestamp = TSUTCToUser( $ts, $dst);
                      break;
                    case 'week' :
                      $rawData['rec_type_select'] = JCL_REC_TYPE_WEEKLY;
                      $rawData['rec_weekly_period'] = $event->recur_val;
                      $ts = gmmktime( $start_time_hour,$start_time_minute,0,$startDateRec->month,$day+($rawData['rec_weekly_period']*$rawData['recur_end_count']*6),$year);
                      $dst = jclGetDst( $ts);
                      $enddatestamp = TSUTCToUser( $ts, $dst);
                      break;
                    case 'month' :
                      $rawData['rec_type_select'] = JCL_REC_TYPE_MONTHLY;
                      $rawData['rec_monthly_period'] = $event->recur_val;
                      $rawData['rec_monthly_type'] = JCL_REC_ON_DAY_NUMBER;
                      $rawData['rec_monthly_day_number'] = $day;
                      $ts = gmmktime( $start_time_hour,$start_time_minute,0,$startDateRec->month+($rawData['rec_monthly_period']*$rawData['recur_end_count']-1),$day,$year);
                      $dst = jclGetDst( $ts);
                      $enddatestamp = TSUTCToUser( $ts, $dst);
                      break;
                    default:
                      break;
                  }

                  // Determine the recur_until value by doing actual calculation if necessary. If the recur type
                  // is "recur x number of times" then we calculate the end date.
                  if ( $rawData['recur_end_type'] == JCL_RECUR_NO_LIMIT || $rawData['rec_type_select'] == JCL_REC_TYPE_NONE ) {
                    $recur_until = $event->start_date;
                  }
                  else if ( $rawData['recur_end_type'] == JCL_RECUR_UNTIL_A_DATE ) {
                    // user has selected an end date from the calendar
                    $ts = gmmktime( $start_time_hour, $start_time_minute, 0, $rec_recur_until->month, $rec_recur_until->day, $rec_recur_until->year);
                    $dst = jclGetDst( $ts);
                    $recur_until = jcUTCDateToFormatNoOffset( TSUTCToUser( $ts, $dst), '%Y-%m-%d %H:%M:%S');
                  } else {
                    // user has set to repeat a number of times : $form['recur_end_type'] == JCL_RECUR_SO_MANY_OCCURENCES
                    $recur_until = jcUTCDateToFormatNoOffset( $enddatestamp, '%Y-%m-%d %H:%M:%S');
                  }
                }

                // update event structure with calculated recur until date
                $event->recur_until = $recur_until;
                $rawData['recur_until'] = $recur_until;

                // call function to store event data in database, and create all recurring children events if needed
                $checkOnly = true;
                $successful = createEvent( $event->cal_id, $event->owner_id, $event->title, $event->description, $event->contact, $event->url,
                $event->registration_url, $event->email, $event->picture, $event->cat, $startDateRec->day, $startDateRec->month, $startDateRec->year,
                $event->approved, $event->private, $event->start_date,
                $event->end_date, $event->published, $event->recur_end_type, $event->recur_count,
                $recur_until, $rawData, $rec_id = 0, $detached_from_rec = 0, $checkOnly);

                $checkOnly = false;
                $successful = $successful && createEvent( $event->cal_id, $event->owner_id, $event->title, $event->description, $event->contact, $event->url,
                $event->registration_url, $event->email, $event->picture, $event->cat, $startDateRec->day, $startDateRec->month, $startDateRec->year,
                $event->approved, $event->private, $event->start_date,
                $event->end_date, $event->published, $event->recur_end_type, $event->recur_count,
                $recur_until, $rawData, $rec_id = 0, $detached_from_rec = 0, $checkOnly);
              }

              // show result
              $mainframe->enqueueMessage( 'Imported ' . count( $events) . ' events');
            }
          }
        }
      }
    }
    // done, redirect to control panem display results
    $mainframe->redirect( 'index.php?option=com_jcalpro');
  }



  /**
   * Display a form to select which kind of import
   * to perform
   *
   * @param $option
   * @return none
   */
  function manageImports( $option) {

    // import our html
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');

    // build list of previous versions of JCal pro calendars found in database
    $lists['previousJCalCalendars'] = $this->_buildExistingCalendarsList();

    // Build categories select list
    $template = "<select name='cat_id' class='listbox'>
{OPTIONS}
</select>";
    $lists['categories'] = jclBuildCategoriesList();
    if (!empty($lists['categories'] )) {
      $lists['categories'] = str_replace( '{OPTIONS}', $lists['categories'], $template);
    }

    // Build calendars select list
    $lists['calendars'] = jclBuildSimpleCalendarList();
    if (!empty($lists['calendars'] )) {
      $template = "<select name='cal_id' class='listbox'>
{OPTIONS}
</select>";
      $lists['calendars'] = str_replace( '{OPTIONS}', $lists['calendars'], $template);
    }

    // checkbox to try guess categories
    $options = array(
    array( 'value' => '1', 'name' => 'guess_categories', 'text' => 'Try guess categories from CATEGORIES property of iCal events',
        'checked' => '', 'attrib' => '', 'id' => '')
    );

    $lists['guesscategories'] = jclBuildCheckBoxesList( $options, false, false);

    // call import method selection page
    HTML_extcalendar::manageImports( $lists);

  }

  /**
   * Handles importing some iCal events from an uploaded file
   * or a remote URL (requires allow_url_open)
   *
   * @param $source a string indicating if imorting from file or URL
   * @return none
   */
  function iCalImportFromFile( $source = 'iCalImportFromFile') {

    global $mainframe;

    // check security token
    JRequest::checkToken() or die('Invalid Token');

    // collect params from request
    // id of calendar to receive imported ical events
    $properties['targetCal'] = JRequest::getInt( 'cal_id');
    $properties['targetCat'] = JRequest::getInt( 'cat_id');
    $properties['guessCat'] = JRequest::getInt( 'guess_categories');

    // set owner_id field
    $user = & JFactory::getUser();
    $properties['owner_id'] = $user->guest ? JCL_DEFAULT_OWNER_ID : $user->id;

    // source can be either a local file or an URL
    if ($source == 'iCalImportFromFile') {
      // reading a local file
      // get the uploaded file details
      $userfile = JRequest::getVar( 'userfile', null, 'FILES');
      // store that in our model properties
      $properties['directory'] =  dirname($userfile['tmp_name']);
      $properties['filename'] = basename($userfile['tmp_name']);
      // display file name
      $displayFileName = basename($userfile['name']);
      $mainframe->enqueuemessage( 'Importing iCal events from file ' . $displayFileName);
    } else {
      // fetching from URL
      // store that in our model properties
      $properties['url'] = JRequest::getVar( 'remoteUrl');
      // display url
      $mainframe->enqueuemessage( 'Importing iCal events from ' . htmlspecialchars( $url, ENT_QUOTES, 'UTF-8'));
    }

    // need to set unique id. In case a UID does not exist in the
    // file, it will be created using this unique_id
    $properties['unique_id'] = trim( JURI::base(), '/');
    $properties['unique_id'] = str_replace( '/administrator', '', $properties['unique_id']);

    // Require the events model, and instantiate it
    require_once(JPATH_ROOT.DS. 'components' .DS . 'com_jcalpro' . DS .'models'. DS .'ical.php');
    $model = & JModel::getInstance( 'ical', 'JcalproModel');

    // inject all parameters into the model
    $model->injectProperties( $properties);

    // parse events from source and store them into db
    $model->importFromLocation( $storeIntoDb = true);

    // go back to import screen
    $this->setRedirect('index.php?option=com_jcalpro&task=manageImports');

  }

  function showSettings( $option ) {
    global $mainframe;
    $db = & JFactory::getDBO();

    $query = "SELECT * FROM #__jcalpro2_config";
    $db->setQuery( $query );

    $rows = $db->loadObjectList();
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::showSettings( $rows, $option );
  }

  function documentation( $option ) {
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::documentation();
  }

  function editSettings( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format, $lang_settings_data,
    $lang_info, $theme_info, $lang_general, $lang_config_data, $comp_path;

    $db =& JFactory::getDBO();
    $mosConfig_live_site = JURI::base();
    $my =& JFactory::getUser();


    $query = "SELECT ec.*, u.name as editor FROM #__jcalpro2_config as ec "
    . "\n LEFT JOIN #__users AS u ON u.id = ec.checked_out";
    $db->setQuery( $query );

    if ( !$result=$db->query() ) {
      echo $db->stderr();
      return;
    }

    foreach ( $lang_config_data as $element ) {
      if ( ( is_array( $element )) ) {
        $row = new mosExtCalendarSettings( $db );
        $row->load( $element[1] );
        $row->checkout( $my->id );
      }
    }
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'admin.jcalpro.html.php');
    include( JPATH_COMPONENT_ADMINISTRATOR . DS . 'admin_settings.php' );
    HTML_extcalendar::editSettings( $option );
  }

  function saveSettings( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format, $lang_settings_data,
    $lang_info, $theme_info, $lang_general, $lang_config_data;

    $db =& JFactory::getDBO();
    $registery =& JFactory::getConfig();
    $mosConfig_live_site = $registery->live_site;
    $my =& JFactory::getUser();

    require_once( $CONFIG_EXT['ADMIN_PATH'] . DS . 'admin.config.inc.php' );

    foreach ( $lang_config_data as $element ) {
      if ( ( is_array( $element )) ) {
        //if ((!isset($_POST[$element[1]]))) die("Missing config value for '{$element[1]}'". __FILE__ . __LINE__);
        $value = $_POST[$element[1]];
		if( is_array( $value ) ) {
			$value = implode( '|', $value );
		}
		if (!get_magic_quotes_gpc()) {
			$value = addslashes( $value );
		}
        $query = "UPDATE #__jcalpro2_config SET value = '$value' WHERE name = '{$element[1]}'" ;
        $db->setQuery( $query);
        $db->query();
        $row = new mosExtCalendarSettings( $db );
        $row->load( $element[1] );
        $row->checkin();
      }
    }

    $msg = 'Saved New Settings';

    $mainframe->redirect( 'index.php?option=com_jcalpro', $msg );
  }

  function cancelEditSettings() {
    global $mainframe;

    $db =& JFactory::getDBO();

    $checkInQuery = "SELECT * FROM #__jcalpro2_config";
    $db->setQuery( $checkInQuery );
    $rows = $db->loadObjectList();

    foreach ( $rows as $key => $value ) {
      $row = new mosExtCalendarSettings( $db );
      $row->load( $value->name );
      $row->checkin();
    }

    $mainframe->redirect( 'index.php?option=com_jcalpro', 'Cancelled Settings Change' );
  }

  function showCategories( $option ) {
    global $mainframe;

    $db =& JFactory::getDBO();
    $registery =& JFactory::getConfig();
    $mosConfig_list_limit = $mainframe->getCfg('list_limit');


    $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

    // get the total number of records
    $db->setQuery( "SELECT count(*) FROM #__jcalpro2_categories" );
    $total = $db->loadResult();

    jimport('joomla.html.pagination');
    $pageNav = new JPagination($total, $limitstart, $limit);

    $query   = "SELECT c.*, u.name as editor FROM #__jcalpro2_categories as c "
    . "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
    . "\nORDER BY c.cat_name LIMIT $pageNav->limitstart,$pageNav->limit";
    $db->setQuery( $query );
    $rows = $db->loadObjectList();

    // fix up display of access level
    if (!empty( $rows)) {
      for($i = 0; $i < count( $rows); $i++) {
        $rows[$i]->level = JText::_( JString::trim($rows[$i]->level));
      }
    }

    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::showCategories( $rows, $pageNav, $option );
  }

  function newCategory( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $form, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format,
    $lang_settings_data, $lang_info, $theme_info, $lang_general, $lang_config_data, $template_cat_form,
    $lang_cat_admin_data, $errors;

    $db = &JFactory::getDBO();
    $registery = &JFactory::getConfig();
    $language = &JFactory::getLanguage();
    $mosConfig_live_site = JURI::base();
    $my = &JFactory::getUser();

    require_once( $CONFIG_EXT['ADMIN_PATH'] . DS . 'admin.config.inc.php' );
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'admin.jcalpro.html.php');
    HTML_extcalendar::editCategory( $option );

    $form['published']     = 1;
    $form['adminapproved'] = true;
    $form['userapproved']  = false;

    $form['color']         = "#505054";

    jcPageHeader( '', '', false );
    display_cat_form( 'index.php', 'add', $form );
    echo '
                   <input type="hidden" name="option" value="' . $option . '">
                   <input type="hidden" name="task" value="initial">
                 </form>
            ';

    // footer
    //pagefooter();
  }

  function editCategory( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $form, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format,
    $lang_settings_data, $lang_info, $theme_info, $lang_general, $lang_config_data, $template_cat_form,
    $lang_cat_admin_data, $errors;

    $cat_id = JRequest::getInt('cat_id');
    if (empty( $cat_id)) {
      $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
      JArrayHelper::toInteger($cid, array(0));
      $cat_id = implode (',', $cid);
    }

    $db = &JFactory::getDBO();

    $language = &JFactory::getLanguage();

    $mosConfig_live_site = JURI::base();
    $my = &JFactory::getUser();

    require_once( $CONFIG_EXT['ADMIN_PATH'] . DS . 'admin.config.inc.php' );
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::editCategory( $option );

    $query = "SELECT * FROM #__jcalpro2_categories WHERE cat_id = '$cat_id'";
    $db->setQuery( $query );
    $formObject            = $db->loadObjectList();
    $form                  = get_object_vars( $formObject[0] );

    $form['userapproved']  = $form['options'] & 1;
    $form['adminapproved'] = $form['options'] & 2;

    jcPageHeader( '', '', false );
    display_cat_form( 'index.php', 'edit', $form );
    echo '
                   <input type="hidden" name="option" value="' . $option . '">
                   <input type="hidden" name="task" value="initial">
                 </form>
            ';

    // footer
    pagefooter();
  }

  function cancelEditCategory( $option ) {
    global $mainframe;

    $db = & JFactory::getDBO();
    $row = new mosExtCalendarCategories( $db );
    $row->bind( $_POST );
    $row->checkin();

    $mainframe->redirect( "index.php?option=$option&task=showCategories", 'Cancelled Categories Change' );
  }

  function saveCategory( $option ) {
    global $mainframe;

    $db =& JFactory::getDBO();
    $row = new mosExtCalendarCategories( $db );
    
    $post = JRequest::get('post');

    if ( !$row->bind( $post ) ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    if ( !$row->check() ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    $admin_auto_approve = ( isset( $post['adminapproved'] )) ? 1 : 0;
    $user_auto_approve  = ( isset( $post['userapproved'] )) ? 1 : 0;
    $row->options       = $user_auto_approve + $admin_auto_approve * 2;

    if ( !$row->store() ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    $row->checkin();

    $mainframe->redirect( "index.php?option=$option&task=showCategories", 'Saved Categories Change' );
  }


  /**
   * Publishes or Unpublishes one or more categories or calendars
   * @param $option the main component name, for redirecting
   * @param array An array of unique category id numbers
   * @param integer 0 if unpublishing, 1 if publishing
   * @param string The name of the current user
   */
  function publish( $option, $cid = null, $publish = 1 ) {

    global $mainframe, $CONFIG_EXT;

    // get db and user
    $db =& JFactory::getDBO();
    $my =& JFactory::getUser();

    if ( !is_array( $cid ) ) {
      $cid=array();
    }

    // handle either categories or calendars
    $taskSave = JRequest::getCmd( 'taskSave');
    $allowedTasks = array( 'showCategories', 'showCalendars');
    if (empty( $taskSave) && in_array( $taskSave, $allowedTasks)) {
      // don't know what to do
      return;
    }

    switch ($taskSave) {
      case 'showCategories':
        $displayName = 'category';
        $table = $CONFIG_EXT['TABLE_CATEGORIES'];
        $idName = 'cat_id';
        $dbClass = 'mosExtCalendarCategories';
        break;
      case 'showCalendars' :
        $displayName = 'calendar';
        $table = $CONFIG_EXT['TABLE_CALENDARS'];
        $idName = 'cal_id';
        $dbClass = 'mosExtCalendarCalendars';
        break;
      default:
        // don't know what to do
        return;
        break;
    }

    if ( count( $cid ) < 1 ) {
      $action = $publish ? 'publish' : 'unpublish';
      echo "<script> alert('Select a $displayName to $action'); window.history.go(-1);</script>\n";
      exit;
    }

    $cids  = implode( ',', $cid );

    $query = "UPDATE $table SET published='$publish'"
    . "\nWHERE $idName IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))";
    $db->setQuery( $query );

    if ( !$db->query() ) {
      echo "<script> alert('" . $db->getErrorMsg() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    if ( count( $cid ) == 1 ) {
      $row = new $dbClass( $db );
      $row->checkin( $cid[0] );
    }

    $mainframe->redirect( 'index.php?option=' . $option . '&task=' . $taskSave );
  }

  function deleteCategories( $option, $cid ) {

    global $mainframe, $CONFIG_EXT, $lang_cat_admin_data;

    $db =& JFactory::getDBO();

    $msg = '';

    if ( count( $cid ) ) {
      // check not empty
      $i = 0;
      foreach( $cid as $cat_id) {
        $query = 'select count(extid) from ' . $CONFIG_EXT['TABLE_EVENTS'] . ' where ' . $db->nameQuote( 'cat') . '=' . $db->Quote( $cat_id);
        $db->setQuery( $query);
        $eventsCount = $db->loadResult();
        if (!empty( $eventsCount)) {
          // unset this id, so the calendar does not get deleted
          unset( $cid[$i]);
          // enqueue a message
          $mainframe->enqueueMessage( sprintf( $lang_cat_admin_data['cat_has_events'], $cat_id, $eventsCount) );
        }
        $i++;
      }
      // now delete
      if( !empty( $cid)) {
        $cids = implode( ',', $cid );
        $db->setQuery( "DELETE FROM {$CONFIG_EXT['TABLE_CATEGORIES']} WHERE cat_id IN ($cids)" );
        $db->query();
        $status = $db->getAffectedRows();
        if ( empty( $status) ) {
          $msg = 'Database error : ' . $db->getErrorMsg();
        }
      }
    }

    $msg = empty( $msg) ? (empty( $cid) ? $lang_cat_admin_data['no_cats_to_delete'] : $lang_cat_admin_data['delete_cat_success']) : $msg;

    $mainframe->redirect( 'index.php?option=' . $option . '&task=showCategories',  $msg);

  }

  // JCal pro 2 : calendars management

  function showCalendars( $option ) {
    global $mainframe;

    $db =& JFactory::getDBO();
    $registery =& JFactory::getConfig();
    $mosConfig_list_limit = $mainframe->getCfg('list_limit');


    $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

    // get the total number of records
    $db->setQuery( "SELECT count(*) FROM #__jcalpro2_calendars" );
    $total = $db->loadResult();

    jimport('joomla.html.pagination');
    $pageNav = new JPagination($total, $limitstart, $limit);

    $query   = "SELECT c.*, u.name as editor FROM #__jcalpro2_calendars as c "
    . "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
    . "\nORDER BY c.cal_name LIMIT $pageNav->limitstart,$pageNav->limit";
    $db->setQuery( $query );
    $rows = $db->loadObjectList();

    // fix up display of access level
    if (!empty( $rows)) {
      for($i = 0; $i < count( $rows); $i++) {
        $rows[$i]->level = JText::_( $rows[$i]->level);
      }
    }
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::showCalendars( $rows, $pageNav, $option );
  }

  function newCalendar( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $form, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format,
    $lang_settings_data, $lang_info, $theme_info, $lang_general, $lang_config_data, $template_cat_form,
    $lang_cat_admin_data, $errors;

    $db = &JFactory::getDBO();
    $registery = &JFactory::getConfig();
    $language = &JFactory::getLanguage();
    $mosConfig_live_site = JURI::base();
    $my = &JFactory::getUser();

    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::editCalendar( $option );

    $form['published']     = 1;
    $form['adminapproved'] = true;
    $form['userapproved']  = false;

    $form['color']         = "#505054";

    jcPageHeader( '', '', false );
    display_cal_form( 'index.php', 'add', $form );
    echo '
                   <input type="hidden" name="option" value="' . $option . '">
                   <input type="hidden" name="task" value="initial">
                 </form>
            ';

    // footer
    //pagefooter();
  }

  function editCalendar( $option ) {
    global $mainframe, $CONFIG_EXT,
    $THEME_DIR, $form, $today, $zone_stamp, $DB_DEBUG, $ME, $REFERER, $lang_date_format,
    $lang_settings_data, $lang_info, $theme_info, $lang_general, $lang_config_data, $template_cat_form,
    $lang_cat_admin_data, $errors;

    $cal_id = JRequest::getInt('cal_id');
    if (empty( $cal_id)) {
      $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
      JArrayHelper::toInteger($cid, array(0));
      $cal_id = implode (',', $cid);
    }
    $db = &JFactory::getDBO();

    $mosConfig_live_site = JURI::base();
    $my = &JFactory::getUser();

    require_once( $CONFIG_EXT['ADMIN_PATH'] . DS . 'admin.config.inc.php' );
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'admin.jcalpro.html.php');
    HTML_extcalendar::editCalendar( $option );

    $query = "SELECT * FROM #__jcalpro2_calendars WHERE cal_id = '$cal_id'";
    $db->setQuery( $query );
    $formObject            = $db->loadObjectList();
    $form                  = get_object_vars( $formObject[0] );

    $form['userapproved']  = $form['options'] & 1;
    $form['adminapproved'] = $form['options'] & 2;

    jcPageHeader( '', '', false );
    display_cal_form( 'index.php', 'edit', $form );
    echo '
                   <input type="hidden" name="option" value="' . $option . '">
                   <input type="hidden" name="task" value="initial">
                 </form>
            ';

    // footer
    pagefooter();
  }

  function cancelEditCalendar( $option ) {
    global $mainframe;

    $db = & JFactory::getDBO();
    $row = new mosExtCalendarCalendars( $db );
    $row->bind( $_POST );
    $row->checkin();

    $mainframe->redirect( "index.php?option=$option&task=showCalendars", 'Cancelled Calendars Change' );
  }

  function saveCalendar( $option ) {
    global $mainframe;

    $db =& JFactory::getDBO();
    $row = new mosExtCalendarCalendars( $db );

    if ( !$row->bind( $_POST ) ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    if ( !$row->check() ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    $admin_auto_approve = JRequest::getInt('adminapproved') ? 1 : 0;
    $user_auto_approve  = JRequest::getInt('userapproved') ? 1 : 0;
    $row->options       = $user_auto_approve + $admin_auto_approve * 2;

    if ( !$row->store() ) {
      echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
      exit();
    }

    $row->checkin();

    $mainframe->redirect( "index.php?option=$option&task=showCalendars", 'Saved Calendars Change' );
  }


  function deleteCalendars( $option, $cid ) {
    global $mainframe, $CONFIG_EXT, $lang_cal_admin_data;

    $db =& JFactory::getDBO();

    $msg = '';

    if ( count( $cid ) ) {
      // check not empty
      $i = 0;
      foreach( $cid as $cal_id) {
        $query = 'select count(extid) from ' . $CONFIG_EXT['TABLE_EVENTS'] . ' where ' . $db->nameQuote( 'cal_id') . '=' . $db->Quote( $cal_id);
        $db->setQuery( $query);
        $eventsCount = $db->loadResult();
        if (!empty( $eventsCount)) {
          // unset this id, so the calendar does not get deleted
          unset( $cid[$i]);
          // enqueue a message
          $mainframe->enqueueMessage( sprintf( $lang_cal_admin_data['cal_has_events'], $cal_id, $eventsCount) );
        }
        $i++;
      }
      // now delete
      if( !empty( $cid)) {
        $cids = implode( ',', $cid );
        $db->setQuery( "DELETE FROM {$CONFIG_EXT['TABLE_CALENDARS']} WHERE cal_id IN ($cids)" );
        $db->query();
        $status = $db->getAffectedRows();
        if ( empty( $status) ) {
          $msg = 'Database error : ' . $db->getErrorMsg();
        }
      }
    }

    $msg = empty( $msg) ? (empty( $cid) ? $lang_cal_admin_data['no_cals_to_delete'] : $lang_cal_admin_data['delete_cal_success']) : $msg;

    $mainframe->redirect( 'index.php?option=' . $option . '&task=showCalendars',  $msg);
  }

}
