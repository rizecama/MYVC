<?php
/*
 **********************************************
 JCal Pro events plugin for Jomsocial
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
 *
 * $Id: jsjcalproevents.php 574 2010-02-09 22:53:38Z shumisha $
 *
 * Plugin for displaying upcoming events in connection with the JCal Pro
 * component. The component must be installed before this module will work.

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_BASE . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');

class plgCommunityJsjcalproevents extends CApplications {

  var $name 		= "JCal pro 2 events";
  var $_name		= 'jsjcalproevents';

  function plgCommunityJsjcalproevents(& $subject, $config) {
    parent::__construct($subject, $config);
  }

  function onSystemStart() {

    if(! class_exists('CFactory')) {
      require_once( JPATH_BASE . DS . 'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php');
    }

    //initialize the toolbar object
    $toolbar =& CFactory::getToolbar();
    
    // jomsocial 1.6.x requires userid to be sent in the url
    $user     =& CFactory::getActiveProfile();
    $useridString = !is_object( $user) ? '' : '&userid='.$user->id;

    //adding new tab "Events" in JomSocial toolbar
    $toolbar->addGroup('JCALPROEVENTS', 'Events', CRoute::_('index.php?option=com_community&view=profile&task=app&app=jsjcalproevents' . $useridString));

  }

  function onProfileDisplay() {

    global $mainframe;

    //No display in backend
    if( $mainframe->isAdmin() ) return;

    // get params from plugin
    $plugin =& JPluginHelper::getPlugin('community', 'jsjcalproevents');
    $params = new JParameter( $plugin->params );

    // get user whose profile we are requesting, to be used by latest events code
    $profiledUserId = CFactory::getActiveProfile()->id;

    // get output of module
    $html = '';
    if( is_readable(JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php') ) {
      ob_start();
      include( JPATH_ROOT. DS. 'components'.DS.'com_jcalpro'.DS.'include'.DS.'latest.inc.php' );
      $html = ob_get_contents();
      ob_end_clean();
    }

    return $html;
  }

  function onAppDisplay() {

    return $this->onProfileDisplay();
  }
}
