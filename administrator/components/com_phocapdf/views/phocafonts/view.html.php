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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport('joomla.client.helper');
jimport('joomla.filesystem.file');

class PhocaPDFCpViewPhocaFonts extends JView
{
	function display($tpl = null) {
		
		global $mainframe;
		$uri		= &JFactory::getURI();
		JHTML::stylesheet( 'phocapdf.css', 'administrator/components/com_phocapdf/assets/' );

		$ftp	=& JClientHelper::setCredentialsFromRequest('ftp');
		
		$items		= & $this->get( 'Data');
		$pagination = & $this->get( 'Pagination' );
		
		$this->assignRef('ftp',	$ftp);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title(   JText::_( 'Phoca PDF Fonts' ), 'font' );
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', 'back', JText::_('Control Panel'), 'index.php?option=com_phocapdf');
		JToolBarHelper::deleteList(JText::_('Warning Delete selected items'));
		JToolBarHelper::preferences('com_phocapdf', '460');
		JToolBarHelper::help( 'screen.phocapdf', true );
	}
}
?>
