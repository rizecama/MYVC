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

 $Id: jcloutputfilter.php 667 2011-01-24 21:02:32Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

//--No direct access
defined('_JEXEC') or die('=;)');


// include class implementing decorator pattern
require_once( JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'lib'.DS.'shDecorator.php' );

/**
 * Base class to filter incoming strings
 * into outgoing strings
 * Meant to be used to alter the output of existing code
 * 
 */
class JclOutputFilter extends ShAbstractDecorator {

	public function output( $input, $options = null) {
		// default filter has no effect
		return $input;
	}

}

/**
 * Implements a basic hCal mark-up (microformatting)
 * output filter
 * 
 */
class JclOutputFilter_hCal extends JclOutputFilter {

	public function output( $input, $options = null) {

		// check input, we should throw an exception ?
		if (is_null($options) || empty($options['type'])) {
			return parent::output( $input);
		}

		// get the correct element to apply formatting to
		$element = empty( $options['element']) ?  $this->_getElement( $options['type']) : $options['element'];

		// do the formatting according to request
		switch ($options['type']) {

			case 'vevent':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'summary':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'description':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'category':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;  
			case 'dtstart':
				$title = empty( $options['startDate']) ? '' : ' title="' . $this->_toDateTime( $options['startDate']) . '"';
				$out = '<' . $element . ' class="' . $options['type'] . '"' . $title . ' >' . $input . '</' . $element . '>';
				break;
			case 'dtend':
				$title = empty( $options['title']) ? '' : ' title="' . $this->_toDateTime( $options['endDate']) . '"';
				$out = '<' . $element . ' class="' . $options['type'] . '"' . $title . ' >' . $input . '</' . $element . '>';
				break;
			case 'location':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'uid':
				$out = '<' . $element . ' class="' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'dtstamp':
				$title = empty( $options['title']) ? '' : ' title="' . $options['title'] . '"';
				$out = '<' . $element . ' class="' . $options['type'] . '"' . $title . ' >' . $input . '</' . $element . '>';
				break;
			default:
				$out = parent::output( $input);
				break;
		}
		
		// send back result
		return $out;
		
	}

	/**
	* Make a hcal-formatted date-time string from
	* a mysql date time string
	* 
	* @param $dateTime, in mysql format, expressed as UTC
	* @return string, the formatted date time, using current Joomla TZ and DST
	*/
	private function _toDateTime( $dateTime) {

		global $mainframe;
		
		// format the date
		$out = jcUTCDateToFormat( $dateTime, '%Y-%m-%dT%H:%M:%S');
		// figure out the current timezone, including dst
		$ts = jcUTCDateToTs( $dateTime);
		$offset = $mainframe->getCfg( 'offset') + jclGetDst( $ts);
		$out .= jcOffsetToText( $offset, $addSign = true, $withColon = true, $zeroPad = true);
		// return string
		return $out;
		
	}
	
	private function _getElement( $type) {

		$element = '';

		switch ($type) {
			case 'vevent':
				$element = 'div';
				break;
			case 'summary':
				$element = 'div';
				break;
			case 'category':
				$element = 'span';
				break;  
			case 'description':
				$element = 'span';
				break;
			case 'dtstart':
				$element = 'abbr';
				break;
			case 'dtend':
				$element = 'abbr';
				break;
			case 'location':
				$element = 'span';
				break;
			case 'uid':
				$element = 'span';
				break;
			case 'dtstamp':
				$element = 'abbr';
				break;
			default:
				$element = 'span';
				break;
		}
		
		return $element;
	}

}

/**
 * Implements a basic RDFa mark-up (microformatting)
 * output filter
 * 
 */
class JclOutputFilter_RDFa extends JclOutputFilter {

	public function output( $input, $options = null) {

		// check input, we should throw an exception ?
		if (is_null($options) || empty($options['type'])) {
			return parent::output( $input);
		}

		// get the correct element to appy formatting to
		$element = empty( $options['element']) ?  $this->_getElement( $options['type']) : $options['element'];

		// do the formatting according to request
		switch ($options['type']) {

			case 'vevent':
				$out = '<' . $element . ' xmlns:jcl="http://www.w3.org/2002/12/cal/ical" rel="jcl:' . ucfirst($options['type']) . '">' . $input . '</' . $element . '>';
				break;
			case 'summary':
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'description':
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'category':
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;  
			case 'dtstart':
				$title = empty( $options['startDate']) ? '' : $this->_toDateTime( $options['startDate']);
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '" content="' . $title . '" >' . $input . '</' . $element . '>';
				break;
			case 'dtend':
				$title = empty( $options['endDate']) ? '' : $this->_toDateTime( $options['endDate']);
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '" content="' . $title . '" >' . $input . '</' . $element . '>';
				break;
			case 'location':
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'uid':
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '">' . $input . '</' . $element . '>';
				break;
			case 'dtstamp':
				$title = empty( $options['title']) ? '' : ' title="' . $options['title'] . '"';
				$out = '<' . $element . ' property="jcl:' . $options['type'] . '"' . $title . ' >' . $input . '</' . $element . '>';
				break;
			default:
				$out = parent::output( $input);
				break;
		}
		
		// send back result
		return $out;
		
	}

	/**
	* Make a hcal-formatted date-time string from
	* a mysql date time string
	* 
	* @param $dateTime, in mysql format, expressed as UTC
	* @return string, the formatted date time, using current Joomla TZ and DST
	*/
	private function _toDateTime( $dateTime) {

		global $mainframe;
		
		// format the date
		$out = jcUTCDateToFormat( $dateTime, '%Y-%m-%dT%H:%M:%S');
		// figure out the current timezone, including dst
		$ts = jcUTCDateToTs( $dateTime);
		$offset = $mainframe->getCfg( 'offset') + jclGetDst( $ts);
		$out .= jcOffsetToText( $offset, $addSign = true, $withColon = true, $zeroPad = true);
		// return string
		return $out;
		
	}
	
	private function _getElement( $type) {

		$element = '';

		switch ($type) {
			case 'vevent':
				$element = 'div';
				break;
			case 'summary':
				$element = 'div';
				break;
			case 'category':
				$element = 'span';
				break;  
			case 'description':
				$element = 'span';
				break;
			case 'dtstart':
				$element = 'abbr';
				break;
			case 'dtend':
				$element = 'abbr';
				break;
			case 'location':
				$element = 'span';
				break;
			case 'uid':
				$element = 'span';
				break;
			case 'dtstamp':
				$element = 'abbr';
				break;
			default:
				$element = 'span';
				break;
		}
		
		return $element;
	}

}