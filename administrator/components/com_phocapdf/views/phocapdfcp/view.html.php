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
jimport( 'joomla.html.pane' );

class PhocaPDFCpViewPhocaPDFCp extends JView
{
	function display($tpl = null) {
		
		JHTML::stylesheet( 'phocapdf.css', 'administrator/components/com_phocapdf/assets/' );
		JHTML::_('behavior.tooltip');
		$version = PhocaPDFHelper::getPhocaVersion('com_phocapdf');
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca PDF Control Panel' ), 'phoca' );
		JToolBarHelper::preferences('com_phocapdf', '460');
		JToolBarHelper::help( 'screen.phocapdf', true );	
	}
}
?>