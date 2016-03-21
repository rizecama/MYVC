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

 $Id: jclrecaptcha.php 661 2010-08-17 16:49:47Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 *
 * Based on JCCReCaptcha by Júlio Oliveira
 * (C) 2009 - JC e C Informática
 * http://sistemasecia.freehostia.com
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.plugin.plugin');
//JPluginHelper::importplugin( 'system', 'jcl.libraries');

class plgJcalproJclRecaptcha extends JPlugin {

  public function __construct(& $subject, $config) {

    // register our library
    JLoader::register( 'Jclrecaptcha', JPATH_PLUGINS.DS.'jcalpro'. DS .'jcl.recaptcha' . DS."jclrecaptcha.php");
    
    // call parent
    parent::__construct($subject, $config);
  }

  public static function getCaptcha($error = null) {

    // prepare reCaptcha object, sending in a connection object
    $http = & ShHttpcomm::getInstance();
    $options = array(
      'httpConnection' => $http
    );
    $captcha = new Jclrecaptcha( $options);

    // get user set parameters
    $plugin =& JPluginHelper::getPlugin('jcalpro', 'jclrecaptcha');
    $params = new JParameter( $plugin->params );

    // get html from jcl.recaptcha object
    try {
      $html = $captcha->getHtml( $params, $error );
    } catch (Exception $e) {
      // in case of error just don't do nothing
      $html = '';
    }

    // return html we got
    return $html;
  }

  public static function confirm( $challenge, $response) {

    // prepare reCaptcha object, sending in a connection object
    $http = & ShHttpcomm::getInstance();
    $options = array(
      'httpConnection' => $http
    );
    $captcha = new Jclrecaptcha( $options);

    // find about user ip
    $remoteIp = $_SERVER["REMOTE_ADDR"];

    // get user set parameters
    $plugin =& JPluginHelper::getPlugin('jcalpro', 'jclrecaptcha');
    $params = new JParameter( $plugin->params );

    // prepare data object for check
    $options = array(
      'privatekey' => $params->get( 'private_key')
    , 'remoteip' => $remoteIp
    , 'challenge' => $challenge
    , 'response' => $response
    );

    // get check result from jcl.recaptcha object
    try {
      $status = $captcha->checkUserInput( $options );
    } catch (Exception $e) {
      // in case of error just don't do nothing
      $status = false;
      global $mainframe;
      $mainframe->enqueuemessage( $e->getMessage(), 'error');
    }

    return $status;

  }

}
