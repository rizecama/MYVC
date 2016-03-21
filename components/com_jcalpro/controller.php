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

 $Id: controller.php 667 2011-01-24 21:02:32Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');


class JcalproController extends JController {

	/**
	* Main display method
	* @see libraries/joomla/application/component/JController#display($cachable)
	*/
	function display( $cachable = false) {

		// we use extmode instead of view for historical reasons
		$viewName = $this->getViewName();

		// get the view
		$document =& JFactory::getDocument();
		$viewType = $document->getType();
		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));

		// set the model in the view
		if ($model = & $this->getModel( 'events')) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Display the view
		// TODO : need to calculate an id, filtering DOS attacks
		// when we start using this code
		if ($cachable && $viewType != 'feed') {
			global $option;
			$cache =& JFactory::getCache($option, 'view');
			$id = $this->_getCacheId(); // TODO : voluntarily did not implement the method, to cause fatal error if used
			$cache->get($view, 'display', $id);
		} else {
			$view->display();
		}
	}


	/**
	* Process a request to perform insert of events data
	* into an editor field. The code lives in the backend
	* so this is piping the request to backend view
	*/
	function jclEditorInsert() {

		$viewName = 'editorinsert';
		$layout = JRequest::getCmd( 'layout', 'default' );

		$document = &JFactory::getDocument();
		$type    = $document->getType();

		// Attach path to templates to view, as they are in the backend and thus can't be found automatically
		$view = &$this->getView( $viewName, $type);
		$view->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.strtolower($viewName).DS.'tmpl');

		// Set the layout
		$view->setLayout( $layout);

		// Display the view
		$view->display();

	}

	/**
	* Calculate view name, using extmode param
	* extmore is used for historical reasons in url
	*
	* @return string  the view name
	*/
	function getViewName() {

		global $mainframe;

		$viewName = JRequest::getCmd( 'view');
		if (empty( $viewName)) {
			// get default params for JCal, in case no extmode has been requested
			$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');
			// Find about the requested view
			$viewName = JRequest::getCmd( 'extmode', $pageParams->get( 'extmode'));
		}

		return $viewName;
	}

	/**
	* Display calendar monthly view
	* @return void
	*/
	function cal() {

	}

	/*
	* Display calendar flat view
	* @return void
	*/
	function flat() {

	}

	/**
	* Display calendar week view
	* @return void
	*/
	function week() {

	}

	/**
	* Display calendar daily view
	* @return void
	*/
	function day() {

	}

	/**
	* Display calendar category view
	* @return void
	*/
	function cat() {

	}

	/**
	* Builds rss feed for all front end views
	* @return void
	*/
	function jclFeeds() {

	}
}

