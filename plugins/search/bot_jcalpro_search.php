<?php

/*
 **********************************************
 JCal Pro Search Mambot v1.5.3
 Copyright (c) 2006 Anything-Digital.com
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

 * Search Mambot
 *
 * $Id: bot_jcalpro_search.php 683 2011-02-04 04:39:48Z jeffchannell $
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

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );


jimport( 'joomla.utilities.date');
jimport( 'joomla.html.html' );

$mainframe->registerEvent( 'onSearch', 'plgSearchCalendar' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchCalendarAreas' );
// Advanced Search API
$mainframe->registerEvent( 'onSearchAdvancedCategories', 'plgSearchCalendarCategories' );

/**
 * @return array An array of search areas
 */
function &plgSearchCalendarAreas()
{
  static $areas = array(
		'bot_jcalpro_search' => 'Calendar event'
		);
		return $areas;
}


/**
 * Menu search method for Joomla 1.5.x
 *
 * @param unknown_type $text
 * @param unknown_type $phrase
 * @param unknown_type $ordering
 * @param unknown_type $areas
 */
function plgSearchCalendar( $text, $phrase='', $ordering='', $areas=null ) {

  if (is_array( $areas )) {
    if (!array_intersect( $areas, array_keys( plgSearchCalendarAreas() ) )) {
      return array();
    }
  }

  $database	=& JFactory::getDBO();
  $my	=& JFactory::getUser();

  $gids = array(
    "Super Administrator"=>25,
    "Admin"=>24,
    "Manager"=>23,
    "Publisher"=>21,
    "Editor"=>20,
    "Author"=>19,
    "Registered"=>18,
    "Public Frontend"=>0,
  );

  $levels = array(
    "Super Administrator"=>25,
    "Administrator"=>24,
    "Manager"=>23,
    "Publisher"=>21,
    "Editor"=>20,
    "Author"=>19,
    "Registered"=>18,
    "Public Frontend"=>0,

    "default"=>0,
  );

  $text = trim( $text );
  if ($text == '') {
    return array();
  }
  $wheres = array();
  switch ($phrase) {
    case 'exact':
      $wheres2 = array();
      $quotedEscTxt = $database->Quote( '%'.$database->getEscaped( $text, true ).'%', false );
      $wheres2[] = 'LOWER(b.title) LIKE ' . $quotedEscTxt;
      $wheres2[] = 'LOWER(b.description) LIKE ' . $quotedEscTxt;
      $wheres2[] = 'LOWER(c.cat_name) LIKE ' . $quotedEscTxt;
      $wheres2[] = 'LOWER(c.description) LIKE ' . $quotedEscTxt;
      $where = '(' . implode( ') OR (', $wheres2 ) . ')';
      break;
    case 'all':
    case 'any':
    default:
      $words = explode( ' ', $text );
      $wheres = array();
      foreach ($words as $word) {
        $wheres2 = array();
        $quotedEscWord = $database->Quote( '%'.$database->getEscaped( $word, true ).'%', false );
        $wheres2[] = 'LOWER(b.title) LIKE ' . $quotedEscWord;
        $wheres2[] = 'LOWER(b.description) LIKE ' . $quotedEscWord;
        $wheres2[] = 'LOWER(c.cat_name) LIKE ' . $quotedEscWord;
        $wheres2[] = 'LOWER(c.description) LIKE ' . $quotedEscWord;
        $wheres[] = implode( ' OR ', $wheres2 );
      }
      $where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
      break;
  }

  switch ($ordering) {
    case 'newest':
    default:
      $order = 'start_date DESC';
      break;
    case 'oldest':
      $order = 'start_date ASC';
      break;
    case 'popular':
      $order = '';
      break;
    case 'alpha':
      $order = 'title';
      break;
    case 'category':
      $order = '';
      break;
  }
  
  // Advanced Search API

	$advancedSearch = '';
	$plugin = JPATH_ADMINISTRATOR.'/components/com_searchadvanced/libraries/sa/plugin.php';
	if (@file_exists($plugin)) {
		require_once ($plugin);
		$conditions = array(
			'date' => array(
				'column' => array('b.start_date', 'b.end_date')
			),
			'catid' => array(
				'column' => 'b.cat',
				'data' => array('prefix' => 'com_jcalpro2')
			)
		);
		$adv = &SearchAdvancedPlugin::getInstance();
		$advancedSearch = $adv->buildWhere($conditions);
	}


  // shumisha

  $eventType = 'Calendar event';

  // find about calendar Itemid
  // load plugin params info
  $plugin =& JPluginHelper::getPlugin('search', 'bot_jcalpro_search');
  $pluginParams = new JParameter( $plugin->params );

  // and get user-set Itemid from plugin params
  $JCalItemid = $pluginParams->def( 'component_itemid', 0);

  // if we have not yet an Itemid, try to get it from the menu system
  // if there are several menu items leading to a calendar page, we'll just pcik the first
  if (empty($JCalItemid)) {
    require_once( JPATH_SITE . DS . 'components' . DS . 'com_jcalpro' . DS . 'include' . DS . 'functions.inc.php');
    $JCalItemid = jclGetItemid( 'com_jcalpro');
  }
  
  // now query the DB
  $query = "SELECT extid,title as title,"
  . "\n b.start_date AS created,"
  . "\n b.description as text,"
  . "\n CONCAT_WS( '/', " . $database->Quote( $eventType). ", c.cat_name ) as section,"
  . "\n CONCAT('index.php?option=com_jcalpro" . (empty($JCalItemid) ? '' : '&Itemid='.$JCalItemid) . "&extmode=view&extid=',extid) as href,"
  . "\n b.cat as category,"
  . "\n c.level as level,"
  . "\n '3' as browsernav,"
	. "\n '1' as AdvancedSearch"
  . "\n FROM #__jcalpro2_events AS b LEFT JOIN #__jcalpro2_categories AS c ON c.cat_id=b.cat"
  . "\n WHERE $where"
  . "\n AND approved=1"
  . $advancedSearch;

  $database->setQuery( $query );
  $data = $database->loadObjectList();
  $row = array();

  foreach( $data as $item )
  {
    // bad fix, to preserve compat with previous versions : just made sure every occurence of 'public frontend' is now
    // (correctly) 'Public Frontend'. However, that will break stuff with users upgrading from past versions
    // as events already stored in DB will not work. Hence the bad fix. Could have used ucwords, but not reliable
    // with utf-8
    $item->level = ucwords( trim($item->level));
    if( $levels[ucfirst($item->level)] <= @$gids[$my->usertype] )
    {
      $item->created = JHTML::date(strtotime($item->created));
      $item->text = html_entity_decode($item->text);
      $row[] = $item;
    }
  }

  return $row;
}

/**
 * Method for Advanced Search API integration
 * 
 */
function &plgSearchCalendarCategories() {
	static $catoptions = array();
	$prefix = 'com_jcalpro2';
	$query = 'SELECT cat_id AS id, cat_name AS name FROM #__jcalpro2_categories WHERE published = 1 ORDER BY cat_name';
	$db = JFactory::getDbo();
	$db->setQuery($query);
	if ($opts = $db->loadObjectList()) {
		if (is_array($opts) && !empty($opts)) {
			$catoptions[] = JHtml::_('select.optgroup', JText::_($prefix));
			foreach ($opts as $opt) {
				$catoptions[] = JHtml::_('select.option', "{$prefix}::{$opt->id}", $opt->name);
			}
		}
	}
	return $catoptions;
}