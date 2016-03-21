<?php
/*
 **********************************************
 JCal Pro Latest Events Plugin
 Copyright (c) 2009 Anything-Digital.com
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

 * Latest Events Plugin
 *
 * $Id: bot_jcalpro_latest_events.php 640 2010-05-09 09:55:43Z shumisha $
 *
 * Plugin for displaying upcoming events in connection with the JCal Pro
 * component. The component must be installed before this module will work.

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$mainframe->registerEvent( 'onPrepareContent', 'plgJCalLatest' );

function plgJCalLatest( &$rowContent, &$params, $page=0 ) {

  // save content item params
  $contentParams = $params;
  // get plugin params
  $plugin =& JPluginHelper::getPlugin('content', 'bot_jcalpro_latest_events');
  $matches = array();

  // regexp to catch plugin requests
  $regExp = "#{jcal_latest\s*(.*)}#Us";
  $preV21RegExp = "#{jcal_latest}([\d,?]*){/jcal_latest}#s";

  // Get Plugin info
  // try old style, pre-version 2.1 syntax for calling plugin : {jcal_latest}cat1,cat2,cat3{/jcal_latest}
  if (preg_match_all( $preV21RegExp, $rowContent->text, $matches, PREG_SET_ORDER) > 0) {
    foreach( $matches as $match) {
      $html = '';
      // init params from plugin
      $params = new JParameter($plugin->params);
      if( is_readable(JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php') ) {
        ob_start();
        $params->set('categories',$match[1]);
        include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php' );
        $html = ob_get_contents();
        ob_end_clean();
      }
      $rowContent->text = str_replace( $match[0], $html , $rowContent->text );
    }
  } else {
    // new syntax as of Jcal 2.1 {jcal_latest cat=n show_description=yes ...}
    if (preg_match_all( $regExp, $rowContent->text, $matches, PREG_SET_ORDER) > 0) {
      foreach( $matches as $match) {
        // init params from plugin
        $params = new JParameter($plugin->params);
        // extract parameters passed as attributes
        $attribs = jclGetPluginAttributes( $match[1]);
        // set them up
        jclSetPluginAttributes( $params, $attribs);
        // get output of module
        $html = '';
        if( is_readable(JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php') ) {
          ob_start();
          include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php' );
          $html = ob_get_contents();
          ob_end_clean();
        }
        $rowContent->text = str_replace( $match[0], $html , $rowContent->text );
      }
    }
  }
  //restore content item params
  $params = $contentParams;
}

/**
 * Extract parameters from content text {jcal_latest} entry
 *
 * @param $params the raw parameters string, as extracted by regexp
 * @return array individual parameters as $key => $value
 */
function jclGetPluginAttributes( $params) {

  // attributes allowed as param of plugin call
  $paramList = array( 'cat', 'cal', 'sort', 'direction', 'max_upcoming', 'max_recent', 'show_description', 'show_readmore', 'eventid', 'show_category', 'show_calendar');

  // output
  $attribs = array();

  // get individual params
  $rawAttribs = explode( ' ', trim($params));
  if (!empty( $rawAttribs)) {
    foreach( $rawAttribs as $rawAttrib) {
      $attrib = array();
      parse_str( $rawAttrib, $attrib);
      if (!empty( $attrib)) {
        foreach( $attrib as $key => $value) {
          if (in_array( $key, $paramList, true)) {
            // this is a valid attrib, store it in output
            $attribs[$key] = trim(str_replace(chr(0xc2).chr(0xa0), '', $value));
          }
        }
      }
    }
  }
  return $attribs;
}

/**
 * Set plugin parameters, doing a bit of renaming as we go
 *
 * @param $params the plugin parameter structure, to be filled with parameters
 * @param $attribs arra : the parameters values as extracted by jclGetPluginAttributes
 * @return none
 */
function jclSetPluginAttributes( & $params, $attribs) {

  // check params
  if (empty( $attribs) || empty( $params)) {
    return;
  }

  // now set attributes
  foreach( $attribs as $key => $value) {
    switch ($key) {
      case 'cat':
        $params->set( 'categories', $value);
        break;
      case 'cal':
        $params->set( 'calendars_list', $value);
        break;
      case 'eventid':
        $params->set( 'events_list', $value);
        break;
      case 'max_upcoming':
        $params->set( 'number_of_events_to_list_upcoming', intval( $value));
        break;
      case 'max_recent' :
        $params->set( 'number_of_events_to_list_recent', intval( $value));
        break;
      case 'show_description' :
        $params->set( 'show_description', $value == 'yes' ? 1 : 0);
        break;
      case 'show_readmore' :
        $params->set( 'show_readmore', $value == 'yes' ? 1 : 0);
        break;
      case 'show_calendar' :
        $params->set( 'show_calendar', $value == 'yes' ? 1 : 0);
        break;
      case 'show_category' :
        $params->set( 'show_category', $value == 'yes' ? 1 : 0);
        break;    
      default:
        $params->set( $key, $value);
        break;
    }
  }
}
