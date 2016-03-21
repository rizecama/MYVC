<?php
/**
 * @version		$Id: contact.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * @package		Joomla
 * @subpackage	Contact
 */
class ContactModelDemo extends JModel
{
	
	function storedemo($data){
		JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
		$row =& $this->getTable('demo');
		$row = JTable::getInstance('demo','Table');
        if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->store()) {
                $this->setError($row->getErrorMsg());
                return false;
        }
        return true;

	} 
}