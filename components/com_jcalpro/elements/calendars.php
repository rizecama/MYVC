<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla!
 (com_extcal_0_9_2_RC4.zip from mamboguru.com).
 Extcal (http://sourceforge.net/projects/extcal) was renamed
 and adapted to become a Mambo/Joomla! component by
 Matthew Friedman, and further modified by David McKinnis
 (mamboguru.com) to repair some security holes.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************

 $Id: functions.inc.php 658 2010-06-30 20:17:09Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Calendars Element
 */
class JElementCalendars extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Calendars';

	function fetchElement( $name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();
		$sql = "SHOW tables like '".$db->getPrefix()."jcalpro2_calendars'";
		$db->setQuery( $sql );
		$tables = $db->loadObjectList();

		if ( !count( $tables ) ) {
			return 'JCal Pro calendar table not found in database...';
		}

		$multiple =			$node->attributes( 'multiple' );
		$size =				$this->def( $node->attributes( 'size' ), 0 );

		if ( !is_array( $value ) ) {
			$value = explode( ',', $value );
		}

		$where = 'published = \'1\'';

		$sql = "SELECT cal_id as id, cal_parent as parent, cal_name as name FROM #__jcalpro2_calendars WHERE ".$where." ORDER BY name";
		$db->setQuery( $sql );
		$menuItems = $db->loadObjectList();

		// establish the hierarchy of the menu
		// TODO: use node model
		$children = array();

		if ( $menuItems )
		{
			// first pass - collect children
			foreach ( $menuItems as $v )
			{
				$pt =	$v->parent;
				$list =	@$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}

		// second pass - get an indent list of the items
		require_once JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'html'.DS.'menu.php';
		$list = JHTMLMenu::treerecurse( 0, '', array(), $children, 9999, 0, 0 );

		// assemble items to the array
		$options =	array();
		foreach ( $list as $item )
		{
			$options[] = JHTML::_( 'select.option', $item->id, $item->treename, 'value', 'text', 0 );
		}

		$attribs = 'class="inputbox"';
		if ( $size ) {
			$attribs .= ' size="'.$size.'"';
		} else {
			$attribs .= ' size="'.( ( count( $options) > 10 ) ? 10 : count( $options) ).'"';
		}
		if( $multiple ) $attribs .= ' multiple="multiple"';

		return JHTML::_( 'select.genericlist', $options, ''.$control_name.'['.$name.'][]', $attribs, 'value', 'text', $value, $control_name.$name );
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}