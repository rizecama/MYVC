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

 $Id: jcllibraries.php 661 2010-08-17 16:49:47Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.plugin.plugin');

class plgSystemJcllibraries extends JPlugin {

  public function __construct( &$subject, $config) {
    
    $libs = array( 'ShHttpcomm');
    // register our various libraries with Joomla loader class
    foreach ($libs as $lib) {
      $lowerLib = strtolower( $lib);
      JLoader::register( $lib,
      JPATH_PLUGINS . DS . 'system' . DS . 'jcl.' .  str_replace( 'jcl', '', $lowerLib) . DS . $lowerLib . '.php');
    }
    
    // call parent
    parent::__construct($subject, $config);

  }
}