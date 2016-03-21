<?php
/*
 **********************************************
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

 $Id: com_jcalpro_lib.php 667 2011-01-24 21:02:32Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );


// ------------------  Parameters to change urls construction ---------------------------------------

// ------------------  Utility functions ------------------------------------------------------------

if (!function_exists( 'jclLoadPluginLanguage')) {
	/**
	* Will load language string for various languages to build up
	* sef urls. Default to english if language does not exists
	*
	* @param string $fileName the language string file to load
	* @param string $language the required language
	* @param string $defaultString a string to look for in the required language
	* @return string the language code actually found, either the requested one or 'en' if not found
	*/
	function jclLoadPluginLanguage ( $fileName, $language, $defaultString) {  // V 1.2.4.m
		global $sh_LANG;
		
		// import file utility
		jimport( 'joomla.filesystem.file');
		// load the Language File
		$file = JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'sef_ext'.DS.$fileName.'.php';
		if (JFile::exists( $file)) {
			include_once( $file );
		}
		else JError::RaiseError( 500, 'Missing language file for SEF plugin '.$fileName.'. Cannot continue.');

		if (!isset($sh_LANG[$language][$defaultString]))
		return 'en';
		else return $language;
	}
}


if (!function_exists( 'jclGetEventData')) {
	/**
	* Returns an event title
	*
	* @param integer $id
	* @param object $data base data for the event : rec_id, cat_id, cal_id, start_date, end_date
	* @param $option the component name
	* @param $shLangName the current language
	* @return string the event title
	* @return boolean $isARecurrence is set to true or false
	*/
	function jclGetEventData( $id, & $data, $option, $shLangName) {

		static $titles = array();

		$id = intval( $id);

		// check params
		if (empty( $id)) {
			return '';
		}

		// fetch title from db if needed
		if (empty( $titles[$id])) {
			// this particular title has not been found before, need to read from db
			$db = & JFactory::getDBO();
			$query = 'select ' . $db->nameQuote( 'extid')
			. ', ' . $db->nameQuote( 'title')
			. ', ' . $db->nameQuote( 'rec_id')
			. ', ' . $db->nameQuote( 'cat')
			. ', ' . $db->nameQuote( 'cal_id')
			. ', ' . $db->nameQuote( 'start_date')
			. ', ' . $db->nameQuote( 'end_date')
			. ' from #__jcalpro2_events'
			. ' where ' . $db->nameQuote( 'extid') . ' = ' . $db->Quote( $id) . ';';
			$db->setQuery( $query);
			if (shTranslateUrl($option, $shLangName)) {
				$title = $db->loadObject();
			} else {
				$title = $db->loadObject( false);
			}
			// we must include event id in url, as all recurrences of an event will
			// have the same title.
			if (!empty( $title)) {
				$sefConfig = & shRouter::shGetConfig();
				$titles[$id] = $title;
				$titles[$id]->SefTitle = ( $sefConfig->jclInsertEventId ? $id : '') . (empty( $title) ? '' : ' ' . $title->title);
			}
		}

		if (!empty( $titles[$id])) {
			// return cached value
			$data = $titles[$id];
			return $titles[$id]->SefTitle;
		} else {
			// something's wrong
			return '';
		}
	}
}

if (!function_exists( 'jclGetCategoryTitle')) {
	/**
	* Returns a category title
	*
	* @param integer $cat_id
	* @param $option the component name
	* @param $shLangName the current language
	* @return string the category title
	*/
	function jclGetCategoryTitle( $cat_id, $cat_ext, $option, $shLangName) {

		static $titles = array();

		$cat_id = intval( $cat_id);

		// check params
		if (empty( $cat_id)) {
			return '';
		}

		$id = $cat_id;
		if ( $cat_ext ) {
			$id = $cat_ext.'_'.$cat_id;
		}
		
		// fetch title from db if needed
		if (empty( $titles[$id])) {
			$db = & JFactory::getDBO();
			switch ( $cat_ext ) {
				case 'illbethere':
					// this particular title has not been found before, need to read from db
					$query = "SELECT cat_id, name as cat_name
						FROM #__illbethere_categories
						WHERE cat_id = ".(int) $cat_id
						;
					break;
				case 'community':
					// this particular title has not been found before, need to read from db
					$query = "SELECT id as cat_id, name as cat_name
						FROM #__community_events_category
						WHERE id = ".(int) $cat_id
						;
					break;
				default:
					// this particular title has not been found before, need to read from db
					$query = "SELECT cat_id, cat_name
						FROM #__jcalpro2_categories
						WHERE cat_id = ".(int) $cat_id
						;
					break;
			}
			$db->setQuery( $query);
			if (shTranslateUrl($option, $shLangName)) {
				$title = $db->loadObject();
			} else {
				$title = $db->loadObject( false);
			}
			// we must include event id in url, as all recurrences of an event will
			// have the same title.
			$sefConfig = & shRouter::shGetConfig();
			$titles[$id] = ( $sefConfig->jclInsertCategoryId ? $cat_id : '') . (empty( $title) ? '' : ' ' . $title->cat_name);
		}

		// return cached value
		return $titles[$id];
	}
}

if (!function_exists( 'jclGetCalendarTitle')) {
	/**
	* Returns a calendar title
	*
	* @param integer $cal_id
	* @param $option the component name
	* @param $shLangName the current language
	* @return string the category title
	*/
	function jclGetCalendarTitle( $cal_id, $option, $shLangName) {

		static $titles = array();

		$cal_id = intval( $cal_id);

		// check params
		if (empty( $cal_id)) {
			return '';
		}

		// fetch title from db if needed
		if (empty( $titles[$cal_id])) {
			// this particular title has not been found before, need to read from db
			$db = & JFactory::getDBO();
			$query = 'select ' . $db->nameQuote( 'cal_id')
			. ', ' . $db->nameQuote( 'cal_name')
			. ' from #__jcalpro2_calendars'
			. ' where ' . $db->nameQuote( 'cal_id') . ' = ' . $db->Quote( $cal_id) . ';';
			$db->setQuery( $query);
			if (shTranslateUrl($option, $shLangName)) {
				$title = $db->loadObject();
			} else {
				$title = $db->loadObject( false);
			}
			// we must include event id in url, as all recurrences of an event will
			// have the same title.
			$sefConfig = & shRouter::shGetConfig();
			$titles[$cal_id] = ( $sefConfig->jclInsertCalendarId ? $cal_id : '') . (empty( $title) ? '' : ' ' . $title->cal_name);
		}

		// return cached value
		return $titles[$cal_id];
	}
}

if (!function_exists( 'jclGetPageCurrentCalendar')) {

	function jclGetPageCurrentParams( $param, $trimTo = 0) {
		global $mainframe;

		// get default vars set by admin either globally or on a menu item basis
		$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');

		$out = '';
		switch ($param) {
			case 'cal' :
				$pageCalList = $pageParams->get( 'cal_list');
				$cals = explode( ',', $pageCalList);
				if (count( $cals) > 0) {
					// only one cal
				}
				break;
			case 'cat' :
				break;

				$pageCatList = $pageParams->get( 'cat_list');
		}

		return $trimTo == 0 ? $out : JString::substr( $out, $trimTo) . '...';
	}
}



// ------------------  Utility functions ------------------------------------------------------------

