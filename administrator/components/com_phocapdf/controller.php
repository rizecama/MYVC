<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
jimport('joomla.application.component.controller');

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

if ($view == '' || $view == 'phocapdfcp') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocapdf', true);
	JSubMenuHelper::addEntry(JText::_('Plugins'), 'index.php?option=com_phocapdf&view=phocaplugins');
	JSubMenuHelper::addEntry(JText::_('Fonts'), 'index.php?option=com_phocapdf&view=phocafonts' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocapdf&view=phocainfo');
}

if ($view == 'phocaplugins') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocapdf');
	JSubMenuHelper::addEntry(JText::_('Plugins'), 'index.php?option=com_phocapdf&view=phocaplugins', true);
	JSubMenuHelper::addEntry(JText::_('Fonts'), 'index.php?option=com_phocapdf&view=phocafonts' );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocapdf&view=phocainfo');
}

if ($view == 'phocafonts') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocapdf');
	JSubMenuHelper::addEntry(JText::_('Plugins'), 'index.php?option=com_phocapdf&view=phocaplugins');
	JSubMenuHelper::addEntry(JText::_('Fonts'), 'index.php?option=com_phocapdf&view=phocafonts', true );
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocapdf&view=phocainfo');
}

if ($view == 'phocainfo') {
	JSubMenuHelper::addEntry(JText::_('Control Panel'), 'index.php?option=com_phocapdf');
	JSubMenuHelper::addEntry(JText::_('Plugins'), 'index.php?option=com_phocapdf&view=phocaplugins');
	JSubMenuHelper::addEntry(JText::_('Fonts'), 'index.php?option=com_phocapdf&view=phocafonts');
	JSubMenuHelper::addEntry(JText::_('Info'), 'index.php?option=com_phocapdf&view=phocainfo', true );
}


class PhocaPDFCpController extends JController
{
	function display() {
		parent::display();
	}
}
?>
