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

 $Id: admin.jcalpro.php 706 2011-02-28 16:23:10Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize( 'com_components', 'manage' )) {
  $mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// Load installer script to make any necessary updates.
require_once( JPATH_COMPONENT.DS.'installer'.DS.'installer.php' );

// Load JCalPro specific configuration.
require_once (JPATH_COMPONENT.DS.'admin.config.inc.php');

$jCalOffset = $GLOBALS['CONFIG_EXT']['timezone'] * 3600;

$offsetPostValue = JRequest::getFloat( 'timezone', -1000.0, 'POST');
$offsetBeingSet = $offsetPostValue != -1000.0;

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Require specific controller if requested
if($controller = JRequest::getVar('section')) {
  require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Create the controller
$classname    = 'JCalProController'. ucfirst( $controller );
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar('task') );

// Redirect if set by the controller
$controller->redirect();
