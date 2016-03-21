<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

// Added style sheet
$doc = & JFactory::getDocument();
$css    = JURI::base().'components/com_jefaqpro/assets/css/style.css';
$doc->addStyleSheet($css);

// Include Tables
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
require_once (JPATH_COMPONENT.DS.'captcha'.DS.'captcha.php');

$controllerName = JRequest::getCmd( 'view', 'faq' );

switch($controllerName) {
	case 'category' :
		$controllerName = 'category';
		break;
	default:
		$controllerName = 'faq';
		break;
}


require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );
$controllerName = 'jefaqController'.$controllerName;

// Create the controller
$controller = new $controllerName();

// Perform the Request task
$controller->execute( JRequest::getCmd('task') );

// Redirect if set by the controller
$controller->redirect();
?>