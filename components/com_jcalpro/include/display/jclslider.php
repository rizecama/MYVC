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

 $Id: jclslider.php 667 2011-01-24 21:02:32Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

//--No direct access
defined('_JEXEC') or die('=;)');

/**
 * JclVerticalPaneSliders decorates JclPaneSliders
 * with a vertical display
 *
 */
class JclVerticalPaneSliders extends JPaneSliders {

	// property holding the slider params
	private $_params = null;

	/**
	* Constructor, needed to load up required javascript
	*
	*/
	public function __construct( $params = array() ) {

		static $loaded = false;

		// store params
		if (!empty($params)) {
			$this->_params = $params;
		}
		// insert js for joomla slider
		if(!$loaded) {
			$this->_jclLoadBehavior();
			//$loaded = true;
		}
	}

	/**
	* Creates a pane and creates the javascript object for it
	*
	* @param string The pane identifier
	*/
	function startPane( $id ) {
		return '<div id="'.$id.'" class="pane-sliders">';
	}

	/**
	* Ends the pane
	*/
	function endPane() {
		return '</div>';
	}

	/**
	* Creates a tab panel with title text and starts that panel
	*
	* @param string  $text - The name of the tab
	* @param string  $id - The tab identifier
	*/
	function startPanel( $text, $id ) {

		return '<div class="panel">'
		.'<h3 class="jclToggler'.$this->_params['moduleId'].' jpane-toggler title" id="'.$id.'"><span>'.$text.'</span></h3>'
		.'<div class="jpane-slider'.$this->_params['moduleId'].' content">';
	}

	/**
	* Ends a tab page
	*/
	function endPanel() {
		return '</div></div>';
	}

	/**
	* Load the javascript behavior and attach it to the document
	*
	* pass all parameters to underlying mootools functions, instead of some only
	*
	*/
	function _jclLoadBehavior() {

		// Include mootools framework
		JHTML::_('behavior.mootools');

		$document =& JFactory::getDocument();

		$options = '{';
		$opt['onActive']   = 'function(toggler'.$this->_params['moduleId'].', i) { 
			toggler'.$this->_params['moduleId'].'.addClass(\'jclToggler'.$this->_params['moduleId'].' jpane-toggler-down\'); 
			toggler'.$this->_params['moduleId'].'.removeClass(\'jclToggler'.$this->_params['moduleId'].'\');
			toggler'.$this->_params['moduleId'].'.removeClass(\'jpane-toggler\');  
		}';
		$opt['onBackground'] = 'function(toggler'.$this->_params['moduleId'].', i) {
			toggler'.$this->_params['moduleId'].'.addClass(\'jclToggler'.$this->_params['moduleId'].' jpane-toggler\');
			toggler'.$this->_params['moduleId'].'.removeClass(\'jclToggler'.$this->_params['moduleId'].'\');
			toggler'.$this->_params['moduleId'].'.removeClass(\'jpane-toggler-down\');
		}';
		$opt['duration']   = (isset($this->_params['duration'])) ? (int)$this->_params['duration'] : 300;
		if (isset($this->_params['startOffset']) && $this->_params['startOffset'] === false) {
			$opt['display'] = 'false';
			$opt['show'] = 'false';
		} else {
			$opt['display'] = (isset($this->_params['startOffset']) && (!$this->_params['startTransition'])) ? (int)$this->_params['startOffset'] : 'false' ;
			$opt['show'] = $opt['display'];
		}
		$opt['opacity']    = (isset($this->_params['opacityTransition']) && ($this->_params['opacityTransition'])) ? 'true' : 'false' ;
		$opt['alwaysHide']   = (isset($this->_params['allowAllClose']) && ($this->_params['allowAllClose'])) ? 'true' : 'false' ;
		foreach ($opt as $k => $v)
		{
			if ($v) {
				$options .= $k.': '.$v.',';
			}
		}
		if (substr($options, -1) == ',') {
			$options = substr($options, 0, -1);
		}
		$options .= '}';

		$js = '   window.addEvent(\'domready\', function(){ new Accordion($$(\'.panel h3.jclToggler'.$this->_params['moduleId'].'\'), $$(\'.panel div.jpane-slider'.$this->_params['moduleId'].'\'), '.$options.'); });';

		$document->addScriptDeclaration( $js );
	}
}

/**
 * JclHorizontalPaneSliders extending JPanesliders
 * with a horizontal display
 *
 */
class JclHorizontalPaneSliders extends JPaneSliders {

	// property holding the slider params
	private $_params = null;

	/**
	* Constructor, needed to load up required javascript
	*
	*/
	public function __construct( $params = array() ) {

		// store params
		if (!empty($params)) {
			$this->_params = $params;
		}

	}

	/**
	* Creates a pane and creates the javascript object for it
	*
	* @param string The pane identifier
	*/
	function startPane( $id ) {

		$html = '<table class="jcalpro_flex_horizontal" id="' . $id . '">';

		return $html;
	}

	/**
	* Ends the pane
	*/
	function endPane() {
		return '</table>';
	}

	/**
	* Creates a panel with title text and starts that panel
	*
	* @param string  $text - The name of the tab
	* @param string  $id - The tab identifier
	*/
	function startPanel( $text, $id ) {

		$html  = '<td class="jcalpro_flex_panel_horizontal">' . "\n";
		$html .= '<h3>' . htmlspecialchars( $text) . '</h3>';

		return $html;
	}

	/**
	* Ends a tab page
	*/
	function endPanel() {
		return '</div></div>';
	}

}