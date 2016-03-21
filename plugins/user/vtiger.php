<?php
/**
 * @version		$Id: example.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

/**
 * Example User Plugin
 *
 * @package		Joomla
 * @subpackage	JFramework
 * @since 		1.5
 */
class plgUserVtiger extends JPlugin {

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgUserVtiger(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is stored in the database
	 *
	 * @param 	array		holds the old user data
	 * @param 	boolean		true if a new user is stored
	 */
	function onBeforeStoreUser($user, $isnew)
	{
		global $mainframe;
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param 	array		holds the new user data
	 * @param 	boolean		true if a new user is stored
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterStoreUser($user, $isnew, $success, $msg)
	{
		global $mainframe;

		// convert the user parameters passed to the event
		// to a format the external application

		$args = array();
		$args['username']	= $user['username'];
		$args['email'] 		= $user['email'];
		$args['fullname']	= $user['name'];
		$args['password']	= $user['password'];
		$args['lastvisitDate']	= $user['lastvisitDate'];
		$args['registerDate']	= $user['registerDate'];
		$vtiger_url = $this->params->get( 'vtigerurl');
		$leadsource = $this->params->get( 'leadsource'); // waar vandaan.
		$back 	    = $this->params->get( 'back'); // wilt u elke inlog vastleggen?
		//echo 'params : '.$vtiger_url.' '.$leadsource;

		if ($isnew)
		{
			// Call a function in the external app to create the user
			// ThirdPartyApp::createUser($user['id'], $args);

			include_once dirname(__FILE__) . '/curl_http_client.php';
			$module = 'Leads';
			$post_data = array();			// Just to be on safer side, we are populating it later.
			$post_data['firstname'] = $args['username'];
			$post_data['lastname'] = $args['fullname'];
			$post_data['email'] = $args['email'];
			$post_data['company'] = 'registerDate : '.$args['registerDate'];
			$homeip  = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$post_data['website'] = $homeip;
			$post_data['moduleName'] = $module;   // Leads
			$post_data['leadsource'] = $leadsource;
			
			if(empty($vtiger_url)) {
			   //$vtiger_url='http://www.robusoft.net/vtigercrm'; 
			   return false;
			}
			// Suffix the URL where data needs to be sent.
			$service_url = $vtiger_url . '/modules/Webforms/post.php';

			$client = new Curl_HTTP_Client();

			// Escape SSL certificate hostname verification
			curl_setopt($client->ch, CURLOPT_SSL_VERIFYHOST, 0);
	
			$client->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			$html_data = $client->send_post_data($service_url, $post_data);
			//echo $html_data;
		}
		else
		{
			// Call a function in the external app to update the user
			// ThirdPartyApp::updateUser($user['id'], $args);
		   if ($back) {
		     if ($back<>'0') {
			include_once dirname(__FILE__) . '/curl_http_client.php';
			$module = 'Leads';
			$post_data = array();			// Just to be on safer side, we are populating it later.
			$post_data['firstname'] = $args['username'];
			$post_data['lastname'] = $args['fullname'];
			$post_data['email'] = $args['email'];
			$post_data['company'] = 'lastvisitDate : '.$args['lastvisitDate'].'Changed user data!';
			$homeip  = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$post_data['website'] = $homeip;
			$post_data['moduleName'] = $module;   // Leads
			$post_data['leadsource'] = $leadsource;
			
			if(empty($vtiger_url)) {
			   //$vtiger_url='http://www.robusoft.net/vtigercrm'; 
			   return false;
			}
			// Suffix the URL where data needs to be sent.
			$service_url = $vtiger_url . '/modules/Webforms/post.php';

			$client = new Curl_HTTP_Client();

			// Escape SSL certificate hostname verification
			curl_setopt($client->ch, CURLOPT_SSL_VERIFYHOST, 0);
	
			$client->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			$html_data = $client->send_post_data($service_url, $post_data);
			//echo $html_data;
		     } // if ($back)
		   } // if $back

		}
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is deleted from the database
	 *
	 * @param 	array		holds the user data
	 */
	function onBeforeDeleteUser($user)
	{
		global $mainframe;
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param 	array		holds the user data
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterDeleteUser($user, $succes, $msg)
	{
		global $mainframe;

	 	// only the $user['id'] exists and carries valid information

		// Call a function in the external app to delete the user
		// ThirdPartyApp::deleteUser($user['id']);
	}

	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @access	public
	 * @param 	array 	holds the user data
	 * @param 	array    extra options
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function onLoginUser($user, $options)
	{
		// Initialize variables
		// ThirdPartyApp::loginUser($user['username'], $user['password']);
		$success = false;
		// Here you would do whatever you need for a login routine with the credentials
		//
		// Remember, this is not the authentication routine as that is done separately.
		// The most common use of this routine would be logging the user into a third party
		// application.
		//
		// In this example the boolean variable $success would be set to true
		// if the login routine succeeds

		$vtiger_url = $this->params->get( 'vtigerurl');
		$leadsource = $this->params->get( 'leadsource'); // waar vandaan.
		$getlogin   = $this->params->get( 'getlogin'); // wilt u elke inlog vastleggen?

		jimport('joomla.user.helper');

      		// Register the needed session variables
      		$session =& JFactory::getSession();

      		// Get the session object
      		$table = & JTable::getInstance('session');
      		$table->load( $session->getId() );

		//echo '<br>params : '.$vtiger_url.' '.$leadsource.' '.$getlogin.'<br>';
		//print_r($user);

      		//If login to backend client_id will be 1
      		//If login to frontend client_id will be 0
		$success = true;		
      		if($table->client_id == 1) { //backend
         		//enter your code here
     		 } else {  //frontend
      		   	//enter your code here
		   if ($getlogin) {
		     if ($getlogin<>'0') {
			include_once dirname(__FILE__) . '/curl_http_client.php';
			$module = 'Leads';
			$post_data = array();			// Just to be on safer side, we are populating it later.
			$post_data['firstname'] = $user['username'];
			$post_data['lastname'] = $user['fullname'];
			$post_data['email'] = $user['email'];
			$post_data['company'] = date('l jS \of F Y h:i:s A').' Login!';
			$homeip  = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$post_data['website'] = $homeip;
			$post_data['moduleName'] = $module;   // Leads
			$post_data['leadsource'] = $leadsource;
			
			if(empty($vtiger_url)) {
			   //$vtiger_url='http://www.robusoft.net/vtigercrm'; 
			   $succes = false;
			}
			// Suffix the URL where data needs to be sent.
			$service_url = $vtiger_url . '/modules/Webforms/post.php';

			$client = new Curl_HTTP_Client();

			// Escape SSL certificate hostname verification
			curl_setopt($client->ch, CURLOPT_SSL_VERIFYHOST, 0);
	
			$client->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			$html_data = $client->send_post_data($service_url, $post_data);
			echo $html_data;
//		die('we zijn in functie');
		     } // if ($getlogin)
		   } // if $getlogin

      		}

		return $success;
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @access public
	 * @param array holds the user data
	 * @return boolean True on success
	 * @since 1.5
	 */
	function onLogoutUser($user)
	{
		// Initialize variables
		$success = false;

		// Here you would do whatever you need for a logout routine with the credentials
		//
		// In this example the boolean variable $success would be set to true
		// if the logout routine succeeds
		$success = true;

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

		return $success;
	}
}
