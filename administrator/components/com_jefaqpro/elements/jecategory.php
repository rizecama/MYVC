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


class JElementjecategory extends JElement
{
	var  $_name = 'jecategory';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$query 		  = 'SELECT id, category FROM #__je_faq_category ORDER BY ordering';

		$db    		  = & JFactory::getDBO();

		$categories[] = JHTML::_('select.option', '0', JText::_('JE_UNCATEGORISED'), 'id', 'category');
		$db->setQuery($query);
		$categories   = array_merge($categories, $db->loadObjectList());

		return JHTML::_('select.genericlist',  $categories, ''.$control_name.'['.$name.']', 'class="inputbox" size="1"', 'id', 'category', $value);
	}

}

?>