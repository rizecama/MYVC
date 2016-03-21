<?php
/**
 *
 * @version   $Id: shhttpcomm.php 661 2010-08-17 16:49:47Z shumisha $
 * @copyright Copyright (C) 2009 Yannick Gaultier. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * This is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Class implementing a simple http communication library
 *
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );


class ShHttpcomm {

  const DEFAULT_TIME_OUT = 10;

  // storage for options
  private $options = array();

  // holds current status
  private $status = null;

  // hold current response
  private $response = null;

  // holds any currently opened socket
  private $socket = '';

  private static $instances = array();

  private function __construct( $options = null) {

    // set communication method to use
    $this->options['method'] = is_callable('curl_init') ? 'curl' : 'socket';

  }

  /**
   * Implement singleton pattern to manage communication
   * handling objects
   *
   * @param array $options
   * @return object instance of ShHttpcomm
   */
  public static function &getInstance($options = null) {

    // use default or a specific instance ?
    $sig = empty( $options['sig']) ? 'default' : $options['sig'];

    // singleton : if we don't have an instance, create it
    if (empty( self::$instances[$sig])) {
      $instance = new ShHttpcomm( $options);
      self::$instances[$sig] = &$instance;
    }

    // return stored instance
    return self::$instances[$sig];
  }

  public function request($target, $message) {

    // send request
    $sendMethod = '_send' . ucfirst( $this->options['method']);
    if (is_callable( array($this, $sendMethod))) {
      $this->status = $this->$sendMethod($target, $message);
    } else {
      throw new Exception( 'ShHttpcomm : invalid send method ' . $sendMethod);
    }

    // retrieve response
    $this->_getResponse( $target);

    // return stored response
    return $this->response;
  }

  private function _sendSocket($target, $message) {

    // check target host, and make sure miminum options set is configured
    $target = $this->_checkTarget( $target);
    $request = "POST ".$target['path']." HTTP/1.0\r\n";
    $request .= "Host: " . $target['host'] . "\r\n";
    $request .= "Content-length: ".strlen($message)."\r\n";
    $request .= "Connection: close\r\n";
    $request .= "Content-type: application/x-www-form-urlencoded\r\n";
    $request .= "Useragent: ".$target['userAgent']."\r\n";
    $request .= "\r\n";
    $request .= $message;

    $errno = null;
    $errmsg = null;
    $this->socket = @fsockopen($target['host'], $target['port'], $errno, $errmsg, $target['timeout']);

    // try if socket opened
    if ($this->socket) {
      stream_set_timeout($this->socket, $target['timeout']);
      fwrite( $this->socket, $request);
      $status = stream_get_meta_data( $this->socket);

      // check time out
      if($status['timed_out']) {
        throw new Exception('Time out sending request to ' . $target['host']);
      }
    } else {
      throw new Exception('Server ' . $target['url'] . ' is not available at the moment');
    }

  }


  private function _sendCurl($target, $message) {

    $target = $this->_checkTarget( $target);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_USERAGENT, $target['userAgent']);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    curl_setopt($curl, CURLOPT_TIMEOUT, $target['timeout']);
    curl_setopt($curl, CURLOPT_PORT, $target['port']);
    curl_setopt($curl, CURLOPT_URL, $target['url']);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $message);

    // get response
    $this->response = curl_exec($curl);

    $errorNum = (int) curl_errno($curl);
    $errorMsg = curl_error($curl);
    curl_close($curl);
    if($response === false || $errorNum != 0) {
      throw new Exception('Server ' . $target['url'] . ' is not available at the moment, or timed out');
    }
  }

  private function _readSocket( $target) {

    if ($this->socket) {
      $this->response = '';
      while ($line = fgets($this->socket)) {
        $this->response .= $line;
      }
      $status = stream_get_meta_data($this->socket);
      fclose( $this->socket);

      // check time out
      if($status['timed_out']) {
        throw new Exception('Time out during connection to server ' . $target['host']);
      }
    }
  }


  private function _readCurl( $target) {

    // response already read by _sendCurl(), do nothing
    return true;
  }

  private function _getResponse( $target) {

    $readMethod = '_read' . ucfirst( $this->options['method']);
    if (is_callable( array( $this, $readMethod))) {
      $this->status = $this->$readMethod($target);
    } else {
      throw new Exception( 'ShHttpcomm : invalid read method ' . $readMethod);
    }

    // check response and return it if OK
    $this->_checkResponse( $target);

  }

  private function _checkTarget( $target) {

    if (empty( $target['host'])) {
      throw new Exception('No host set for communication');
    }
    $target['port'] = empty( $target['port']) ? 80 : $target['port'];
    $target['path'] = empty( $target['path']) ? '' : '/' . ltrim( $target['path'], '/');
    $target['url'] = (empty($target['scheme']) ? 'http' : $target['scheme']) . '://'. $target['host'] . $target['path'];

    // set user agent
    $target['userAgent'] = empty($target['userAgent']) ? 'Default user agent' : $target['userAgent'];

    // time out
    $target['timeout'] = empty($target['timeout']) ? ShHttpcomm::DEFAULT_TIME_OUT : $target['timeout'];

    return $target;
  }

  private function _checkResponse() {

    $bits = explode("\r\n\r\n", $this->response);

    // is there a response
    if(empty($bits[0]) && empty($bits[1])) {
      // nothing to do
      throw new Exception( 'ShHttpcomm : invalid response calling ' . $target['host']);
    }
    $headers = array_shift($bits);
    $body = implode('', $bits);
    $validHeaders = array('HTTP/1.0 200', 'HTTP/1.1 200');

    // check headers
    if(!in_array(substr($headers, 0, 12), $validHeaders)) {
      throw new Exception( 'ShHttpcomm : invalid response calling ' . $target['host']);
    }

  }


}
