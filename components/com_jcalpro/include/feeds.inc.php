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

 $Id: feeds.inc.php 660 2010-07-18 08:11:26Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com/
 **********************************************
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * RSS feeds View class
 *
 * @static
 */
class JclFeeds {

	function display() {

		global $mainframe, $CONFIG_EXT, $Itemid_Querystring;

		// Require the events model, and instantiate it
		require_once(JPATH_COMPONENT.DS.'models'.DS.'events.php');
		$model = & JModel::getInstance( 'events', 'JcalproModel');

		// Joomla objects
		$document	= & JFactory::getDocument();

		// get parameters
		$calendar = $model->get( 'calendar');
		$category = $model->get( 'category');

		// link to the base rss feed url
		$document->link = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . '&extmode=cal&format=feed'
			. (!empty($calendar->id) ? '&cal_id=' . $calendar : '')
			. (!empty($category->id) ? '&cat_id=' . $category : '')
		);

		// set metadata
		JclFeeds::insertMetadata();

		// Get some data from the model
		JRequest::setVar('limit', $mainframe->getCfg('feed_limit'));
		$rows = & $model->getFeedsEvents();
		if (is_null( $rows)) {
			// event list is null if feeds are disabled
			JError::RaiseError( 404, 'Page not found');
		} else if (!empty( $rows)) {
			// event list can be an empty array, if feeds are enabled, but there is just no event to display
			foreach ( $rows as $row ) {

				// strip html from feed item title
				$title = htmlspecialchars( $row->title, ENT_COMPAT, 'UTF-8');
				$title = html_entity_decode( $title );

				// url link to article
				// THIS SHOULD BE DONE IN THE MODEL! WTF
				if ( isset( $row->isIllbethere ) ) {
					$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$row->extid . getIllBeThereItemid();
				} else if ( isset( $row->isCommunity ) ) {
					$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$row->extid . getJomSocialItemid();
				} else {
					$non_sef_href = "index.php?option=com_jcalpro" . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$row->extid;
				}
				$link = JRoute::_( $non_sef_href );
				//$link = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . '&extmode=view&extid=' . $row->extid );

				// optionally strip html from description
				$description	= $row->description;// . ' ' . $row->start_date . ' ' . strtotime($row->start_date);
				if (JCL_FEEDS_STRIP_DESCRIPTION_HTML) {
					$description = htmlspecialchars( $description, ENT_COMPAT, 'UTF-8');
					$description = html_entity_decode( $description );
				}

				// load individual item creator class
				$item = new JFeedItem();
				$item->title = $title;
				$item->link = $link;
				$item->description = $description;
				$item->date = $row->start_date;
				$item->pubDate = $row->last_updated;
				$item->guid = $row->id;

				// loads item info into rss array
				$document->addItem( $item );
			}
		}
	}

	/**
	* Insert metadata into the current response document
	*
	* @return void
	*/
	function insertMetadata( ) {

		// Joomla objects
		$document	=& JFactory::getDocument();

		// Require the events model, and instantiate it
		require_once(JPATH_COMPONENT.DS.'models'.DS.'events.php');
		$model = & JModel::getInstance( 'events', 'JcalproModel');

		// get parameters
		$calendar = $model->get( 'calendar');
		$category = $model->get( 'category');

		// set into document
		//$document->setTitle( 'Events for this month');
		$description = (!empty($calendar->title) ? $calendar->title : '') . (!empty($category->title) ? ' [' . $category->title . ']' : '');
		$description = (empty( $description) ? 'Events from ' . JURI::base() : 'Events for ' . $description);
		$document->setMetadata( 'description', $description);
		$document->setMetaData( 'generator', 'JCal Pro - http://dev.anything-digital.com');
	}
}
