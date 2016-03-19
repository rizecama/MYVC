<?php
/**
 * jeFAQ pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');

function com_uninstall() {
	
	$db			= & JFactory::getDBO();

	//Delete files from joomfish component.
	if(JFolder::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements')) {
		if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq.xml')) {
			JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq.xml');
		}

		if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq_category.xml')) {
			JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'je_faq_category.xml');
		}
	}

	//Delete files from component.
	if(JFolder::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins')) {
		if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins'.DS.'com_jefaq.php')) {
			JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_sh404sef'.DS.'language'.DS.'plugins'.DS.'com_jefaq.php');
		}
	}
	
	// Code for uninstall jetestimonial plugin.
	if (JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.php')) {
		JFile::delete(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.php');
	}

	if (JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.xml')) {
		JFile::delete(JPATH_ROOT.DS.'plugins'.DS.'search'.DS.'jefaqpro.xml');
	}

	if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_search_jefaqpro.ini')) {
		JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_search_jefaqpro.ini');
	}

	$query = "DELETE  FROM `#__plugins` WHERE `element`='jefaqpro' AND `folder` = 'search'";
	$db->setQuery( $query );
	$db->query();

	// Code ended for uninstall jetestimonial plugin.
	
	// Message area.
	echo '<p> <b> <span style="color:#009933"> JE FAQ Pro Component & plugin has been Uninstalled successfully </span></b> </p>';
}
?>

