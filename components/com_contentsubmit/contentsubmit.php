<?php
/**

 * @package	ContentSubmit
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Require the defines
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_contentsubmit'.DS.'defines.php' );

// Require the base controller
require_once( JPATH_SITE.DS.'components'.DS.'com_contentsubmit'.DS.'controller.php' );

// Require specific controller if requested
if ($controller = JRequest::getWord('controller', JRequest::getVar( 'view' ) )) 
{
	$path = JPATH_COMPONENT_SITE.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// load the plugins
JPluginHelper::importPlugin( 'contentsubmit' );

// Create the controller
$classname    = 'ContentsubmitController'.$controller;
$controller   = new $classname( );

// Perform the requested task
$user = JFactory::getUser();
if ($user->id != 0) 
{
	// Perform the requested task
	$controller->execute( JRequest::getVar( 'task' ) );
} 
	else 
{
	$redirect = JRoute::_( 'index.php', false );
	$msg = JText::_( "Please Login" );
	$controller->setRedirect( $redirect, $msg, 'notice' );
}

// Redirect if set by the controller
$controller->redirect();

?>
