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

class PhocaPDFCpViewPhocaInfo extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$component 		= 'phocapdf';
		$componentName	= 'Phoca PDF';
		
		JHTML::stylesheet( $component.'.css', 'administrator/components/com_phocapdf/assets/' );
		
		$version = PhocaPDFHelper::getPhocaVersion('com_'.$component);
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Link', 'back', JText::_('Control Panel'), 'index.php?option=com_phocapdf');	
		JToolBarHelper::title(  JText::_( 'Phoca PDF Info' ), 'info' );
		JToolBarHelper::preferences('com_phocapdf', '460');
		JToolBarHelper::help( 'screen.phocapdf', true );
	}
}
?>
