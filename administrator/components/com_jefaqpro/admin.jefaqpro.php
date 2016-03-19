<?php
/**
 * jeFAQ Pro package
 * @version 1.2.0
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.utilities.date');
JHTML::_('behavior.tooltip');

// Added style sheet
$doc 	= & JFactory::getDocument();
$css    = JURI::base().'components/com_jefaqpro/assets/css/style.css';
$doc->addStyleSheet($css);

// check if the controller name is something other than the default, if so, render the submenu appropriately
// note: the second argument in the addEntry helper function is weather or not the sub menu item is active

$controllerName = JRequest::getCmd( 'controller', 'category' );
$control 		= '';
switch($controllerName) {
	case 'faq' :
		JSubMenuHelper::addEntry(JText::_('JE_CATEGORY_CONTROLLER'), 'index.php?option=com_jefaqpro');
		JSubMenuHelper::addEntry(JText::_('JE_FAQ_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=faq', true);
		JSubMenuHelper::addEntry(JText::_('JE_SETTINGS_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=globalsettings');
		$control = 'faq';
		break;
	case 'globalsettings' :
		JSubMenuHelper::addEntry(JText::_('JE_CATEGORY_CONTROLLER'), 'index.php?option=com_jefaqpro');
		JSubMenuHelper::addEntry(JText::_('JE_FAQ_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=faq');
		JSubMenuHelper::addEntry(JText::_('JE_SETTINGS_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=globalsettings', true);
		$control = 'globalsettings';
		break;
	default:
		JSubMenuHelper::addEntry(JText::_('JE_CATEGORY_CONTROLLER'), 'index.php?option=com_jefaqpro', true);
		JSubMenuHelper::addEntry(JText::_('JE_FAQ_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=faq');
		JSubMenuHelper::addEntry(JText::_('JE_SETTINGS_CONTROLLER'), 'index.php?option=com_jefaqpro&controller=globalsettings');
		$control = 'category';
		break;
}

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$control.'.php' );
$controllerName = 'jefaqController'.$control;

// Create the controller
$controller 	= new $controllerName();

// Perform the Request task
$controller->execute( JRequest::getCmd('task') );

// Redirect if set by the controller
$controller->redirect();
?>