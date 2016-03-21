<?php
/*
 **********************************************
 Copyright (c) 2006-20010 Anything-Digital.com
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

 $Id: jclrecaptcha.php 713 2011-03-08 19:37:04Z jeffchannell $

 Based on JCCReCaptcha by Júlio Oliveira
 (C) 2009 - JC e C Informática
 http://sistemasecia.freehostia.com

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class Jclrecaptcha {

  // urls to the reCaptcha servers
  const RECAPTCHA_API_SERVER = 'http://api.recaptcha.net';
  const RECAPTCHA_API_SECURE_SERVER = 'https://api-secure.recaptcha.net';
  const RECAPTCHA_VERIFY_SERVER = 'api-verify.recaptcha.net';
  const RECAPTCHA_GETKEY_URL = 'http://recaptcha.net/api/getkey';

  // storage for options
  private $options = array();

  public function __construct( $options = null) {

    // store options
    $this->options = $options;

  }

  /**
   * gets a URL where the user can sign up for reCAPTCHA. If your application
   * has a configuration page where you enter a key, you should provide a link
   * using this function.
   * @param string $domain The domain where the page is hosted
   * @param string $appname The name of your application
   */
  public function getSignupUrl ($domain = null, $appname = null) {

    return Jclrecaptcha::RECAPTCHA_GETKEY_URL . '?' .  $this->_urlEncodeData (array ('domain' => $domain, 'app' => $appname));
  }


  public function getHtml ($params, $error = null) {

    $key = $params->get('public_key');
    if (empty( $key)) {
      throw new Exception( 'Invalid or missing reCaptcha key. Check configuration.');
    }

    $server = ($params->get('use_ssl')) ? Jclrecaptcha::RECAPTCHA_API_SECURE_SERVER : Jclrecaptcha::RECAPTCHA_API_SERVER;

    // add theme and language configuration
    $theme = $params->get( 'theme' );
    $lang = $params->get( 'lang' );
     
    $html = "<script type='text/javascript'> var RecaptchaOptions = { theme : '$theme', lang : '$lang' , tabindex : 0}; </script>";

    // add main part of html
    $errorpart = "";
    if (!empty($error)) {
      $errorpart = "&amp;error=" . $error;
    }
    $html .='<script type="text/javascript" src="'. $server . '/challenge?k=' . $key . $errorpart . '"></script>

  <noscript>
      <iframe src="'. $server . '/noscript?k=' . $key . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
      <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
      <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
  </noscript>';

    // add optional buttons
    $styles = '';
    if ( $params->get( 'showAudioBtn', 1 ) == 0 ) {
      $styles .= "#recaptcha_switch_audio {display:none;display:none !important}\n";
    }
    if ( $params->get( 'showHelpBtn', 1 ) == 0 ) {
      $styles .= "#recaptcha_whatsthis_btn {display:none;display:none !important}\n";
    }
    if (!empty($styles)) {
    	$html .= "<style type=\"text/css\">\n{$styles}\n</style>";
    }

    // return complete html
    return $html;
  }

  /**
   * Calls an HTTP POST function to verify if the user's guess was correct
   * @param string $privkey
   * @param string $remoteip
   * @param string $challenge
   * @param string $response
   * @param array $extra_params an array of extra variables to post to the server
   * @return ReCaptchaResponse
   */
  public function checkUserInput ( $options) {

    if (empty( $options['privatekey'])) {
      throw new Exception( 'Invalid or missing reCaptcha key. Check configuration.');
    }

    if (empty( $options['remoteip'])) {
      throw new Exception( 'Missing user remote IP in reCaptcha call. Check configuration or software.');
    }

    //discard obvious spam submissions
    if (empty( $options['challenge']) || empty( $options['response'])) {
      return false;
    }

    // make request to check user input
    $response = $this->_makeRequest (Jclrecaptcha::RECAPTCHA_VERIFY_SERVER, '/verify', $options);

    // analyse reChaptcha server response
    $answers = explode ("\n", $response [1]);
    $recaptcha_response = new JclrecaptchaResponse();

    if (trim ($answers [0]) == 'true') {
      $recaptcha_response->is_valid = true;
    }
    else {
      $recaptcha_response->is_valid = false;
      $recaptcha_response->error = $answers [1];
      if ('incorrect-captcha-sol' != $recaptcha_response->error) {
        // we throw an exception for anything else than a bad captcha input
        // as it means we have either a bad connection or maybe a wrong privat/public key
        throw new Exception( 'reCaptcha error : ' . $recaptcha_response->error);
      }
    }

    // return only boolean value for now
    return $recaptcha_response->is_valid;

  }

  /**
   * Submits an HTTP POST to a reCAPTCHA server
   * @param string $host
   * @param string $path
   * @param array $data
   * @param int port
   * @return array response
   */
  private function _makeRequest( $host, $path, $data, $port = 80) {

    // check that we have an http connect object
    if (empty( $this->options['httpConnection']) || !is_object( $this->options['httpConnection'])) {
      throw new Exception( 'Internal error : no valid http connection object supplied to reCaptcha lib');
    }

    // encode data to be sent
    $message = $this->_urlEncodeData ($data);

    // prepare information for http connection object
    $target = array(
      'host' => $host
    , 'path' => $path
    , 'port' => $port
    , 'userAgent' => 'JCal pro from Anything digital'
    );

    // make request to server
    $response = $this->options['httpConnection']->request( $target, $message);

    // break down response, first boolean with success/failure
    // then details of error if any
    $response = explode("\r\n\r\n", $response, 2);

    return $response;
  }

  private function _urlEncodeData( $data) {

    $req = "";
    foreach ( $data as $key => $value ) {
      $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';
    }

    // Cut the last '&'
    $req=substr($req,0,strlen($req)-1);

    return $req;
  }

}
/**
 * A ReCaptchaResponse is returned from recaptcha_check_answer()
 */
class JclrecaptchaResponse {
  var $is_valid;
  var $error;
}


