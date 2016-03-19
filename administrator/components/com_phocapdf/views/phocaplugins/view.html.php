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
jimport( 'joomla.html.pane' );
jimport( 'joomla.application.component.view' );

class PhocaPDFCpViewPhocaPlugins extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$uri				= &JFactory::getURI();
		$document			= &JFactory::getDocument();
		$db		    		= &JFactory::getDBO();
		$user				= &JFactory::getUser();
		$tmpl				= array();
		$tmpl['plugin']		= '';
		$tmpl['plugins']	= '';
		$cid 				= JRequest::getVar( 'cid', array(0), '', 'array' );
		$tmpl['cid']		= (int)$cid[0];
		
		JHTML::stylesheet( 'phocapdf.css', 'administrator/components/com_phocapdf/assets/' );
		
		// Get All Phoca Plugins
		$query = 'SELECT p.name, p.id, p.published, u.name AS editor, g.name AS groupname'
			. ' FROM #__plugins AS p'
			. ' LEFT JOIN #__users AS u ON u.id = p.checked_out'
			. ' LEFT JOIN #__groups AS g ON g.id = p.access'
			. ' WHERE p.folder = '.$db->Quote('phocapdf')
			. ' OR ( p.folder = '.$db->Quote('system').' AND p.element = '.$db->Quote('phocapdfcontent').')'
			. ' GROUP BY p.id';
		$db->setQuery( $query );
		$plugins = $db->loadObjectList();
		if ($db->getErrorNum()) {
			echo $db->stderr();
			return false;
		}
		
		$i = 0;
		foreach ($plugins as $key => $value) {
		
			if ((int)$tmpl['cid'] > 0) {
				if ($value->id == (int)$tmpl['cid']) {
					$value->current = 'class="current"';
				} else {
					$value->current = '';
				}
			} else {
				if ($i == 0) {
					$value->current = 'class="current"';
					$tmpl['cid'] 			= (int)$value->id;
				} else {
					$value->current = '';
				}
			}
			$value->name = str_replace('Phoca PDF - ', '', $value->name);
			$link		 = 'index.php?option=com_phocapdf&view=phocaplugins&cid[]='.(int)$value->id;
			$value->link = '<a href="'.$link.'">'.JText::_($value->name).'</a>';
			$i++;
		}
		
/*		// Plugin
		if ((int)$tmpl['cid'] > 0) {
			$query = 'SELECT p.*, u.name AS editor, g.name AS groupname'
				. ' FROM #__plugins AS p'
				. ' LEFT JOIN #__users AS u ON u.id = p.checked_out'
				. ' LEFT JOIN #__groups AS g ON g.id = p.access'
				. ' WHERE p.id = '.(int)$tmpl['cid'];
			
			$db->setQuery( $query );
			$plugin = $db->loadObject();
			if ($db->getErrorNum()) {
				echo $db->stderr();
				return false;
			}
		
		}
*/		
		$tmpl['plugins']	= $plugins;
		
		$plugin 	=& JTable::getInstance('plugin');

		// load the row from the db table
		$plugin->load( (int)$tmpl['cid'] );
	
		$lang =& JFactory::getLanguage();
		$lang->load( 'plg_' . trim( $plugin->folder ) . '_' . trim( $plugin->element ), JPATH_ADMINISTRATOR );
		// get params definitions
		$params = new JParameter( $plugin->params, JApplicationHelper::getPath( 'plg_xml', $plugin->folder.DS.$plugin->element ), 'plugin' );
	

		$tmpl['plugin']		= $plugin;		
	
		$this->assignRef('tmpl',		$tmpl);
		$this->assignRef('params',		$params);
		$this->assignRef('request_url',	$uri->toString());
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca PDF Plugins' ), 'pdf' );
		$bar = & JToolBar::getInstance( 'toolbar' );
		$bar->appendButton( 'Link', 'back', JText::_('Control Panel'), 'index.php?option=com_phocapdf' );	
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::preferences( 'com_phocapdf', '460' );
		JToolBarHelper::help( 'screen.phocapdf', true );
	}
}
?>