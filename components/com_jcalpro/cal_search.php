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

 $Id: cal_search.php 705 2011-02-15 21:33:34Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe, $CONFIG_EXT;

$acl = &JFactory::getACL();
$my = &JFactory::getUser();
$db = & JFactory::getDBO();

require_once( JPATH_BASE."/components/com_jcalpro/config.inc.php" );

$mainframe =& JFactory::getApplication();
$pageParams =& $mainframe->getPageParameters( 'com_jcalpro' );

// Modified for Mambo integration. No longer a standalone page; used as an include file in the main file extcalendar.php

$num_rows = 0;

$extcal_search  = JRequest::getString( 'extcal_search');
$extcal_search_clean = $db->Quote( '%'.$db->getEscaped( $extcal_search, true ).'%', false );

if (strlen($extcal_search) >= 3) {
	// must be longer or equal to 3 characters !

	if($CONFIG_EXT['archive']) {
		$query = "SELECT extid,title,e.description,e.recur_type,url,cat,cat_name,e.start_date, color, c.cat_id,
			DATE_FORMAT( e.start_date, '%Y%m%d' ) as date
			FROM ".$CONFIG_EXT['TABLE_EVENTS']." AS e
			LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS c
			ON e.cat=c.cat_id ";
		$query .= 'WHERE (title LIKE ' . $extcal_search_clean . ' OR e.description LIKE ' . $extcal_search_clean . ') AND c.published = \'1\' AND approved = \'1\' ';
		$query .= "ORDER BY e.start_date";
	} else {
		$day_pattern = sprintf("%04d%02d%02d",$today['year'],$today['month'],1); // day pattern: 20041231 for 'December 31, 2004'
		$query = "SELECT extid,title,e.description,e.recur_type,url,cat,cat_name,e.start_date, color, c.cat_id,
			DATE_FORMAT( e.start_date, '%Y%m%d' ) as date
			FROM ".$CONFIG_EXT['TABLE_EVENTS']." AS e
			LEFT JOIN ".$CONFIG_EXT['TABLE_CATEGORIES']." AS c
			ON e.cat=c.cat_id ";
		$query .= 'WHERE (title LIKE ' . $extcal_search_clean . ' OR e.description LIKE ' . $extcal_search_clean . ') AND c.published = \'1\' AND approved = \'1\' ';
		$query .= "AND (DATE_FORMAT(e.start_date,'%Y%m%d') >= $day_pattern OR DATE_FORMAT(e.end_date,'%Y%m%d') >= $day_pattern) ";
		$query .= "ORDER BY e.start_date";
	}

	$db->setQuery( $query);
	$extra_rows = $db->loadObjectList();

	$rows = array();
	foreach ( $extra_rows as $i => $row ) {
		$rows[$row->date.'_'.$i] = $row;
	}
	
	$cat_list = jclValidateList( $pageParams->get( 'cat_list' ) );
	$exclude = $pageParams->get( 'cat_list_exclude' );
	// read applicable categories list
	$query = "SELECT cat_id, cat_name FROM " . $CONFIG_EXT['TABLE_CATEGORIES'] . " WHERE published = '1'";
	// apply category restrictions
	if ( !empty( $cat_list ) ) {
		$query .= " AND cat_id ".( $exclude ? 'NOT' : '' )." IN ( " . $cat_list . " )";
	}
	// apply sort order
	$query .= " ORDER BY cat_name";
	// query db
	$db->setQuery( $query );
	$catnames = $db->loadObjectList( 'cat_id' );

	foreach ( $catnames as $i => $row ) {
		$catnames[$i] = $row->cat_name;
	}

	if( $pageParams->get( 'show_illbethere', '' ) === '1' || ( $pageParams->get( 'show_illbethere', '' ) !== '0' && $CONFIG_EXT['show_illbethere'] ) ) {
		$cat_list_illbethere = jclValidateList( $pageParams->get( 'cat_list_illbethere' ) );
		if ( empty( $cat_list_illbethere ) ) {
			$cat_list_illbethere = @$CONFIG_EXT['cat_list_illbethere'];
		}
		if ( $cat_list_illbethere == -1 ) {
			$cat_list_illbethere = '';
		}
		$exclude_illbethere = $pageParams->get( 'cat_list_exclude_illbethere' );
		// Add RSVP events
		if( !$CONFIG_EXT['archive'] ) {
			$where_date = "AND ( DATE_FORMAT( e.session_up,'%Y%m%d' ) >= $day_pattern )";
		}
		$query = "SELECT e.session_id as extid, e.title, e.introtext as description,
			'' as recur_type, '' as url, e.cat_id as cat, c.name as cat_name, e.session_up as start_date, c.cat_id,
			DATE_FORMAT( e.session_up, '%Y%m%d' ) as date
			FROM #__illbethere_sessions AS e
			LEFT JOIN #__illbethere_categories as c
			ON c.cat_id = e.cat_id
			WHERE (e.title LIKE ".$extcal_search_clean." OR e.introtext LIKE ".$extcal_search_clean.")
			AND e.published = 1 ".$where_date;
		if ( !empty( $cat_list_illbethere ) ) {
			$query .= " AND e.cat_id ".( $exclude_illbethere ? 'NOT' : '' )." IN ( " . $cat_list_illbethere . " )";
		}
		$query .= " ORDER BY start_date";
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		foreach ( $extra_rows as $i => $row ) {
			if ( in_array( $row->cat_name, $catnames ) ) {
				$row->cat_id = array_search( $row->cat_name, $catnames );
			} else {
				$row->cat_ext_link = 'illbethere';
			}
			$row->cat_ext = 'illbethere';
			$row->color = $CONFIG_EXT['color_illbethere'];
			$rows[$row->date.'_'.$i.'_i'] = $row;
		}
	}

	if( $pageParams->get( 'show_community', '' ) === '1' || ( $pageParams->get( 'show_community', '' ) !== '0' && $CONFIG_EXT['show_community'] ) ) {
		$cat_list_community = jclValidateList( $pageParams->get( 'cat_list_community' ) );
		if ( empty( $cat_list_community ) ) {
			$cat_list_community = @$CONFIG_EXT['cat_list_community'];
		}
		if ( $cat_list_community == -1 ) {
			$cat_list_community = '';
		}
		$exclude_community = $pageParams->get( 'cat_list_community_exclude' );
		// read JomSocial categories list
		if( !$CONFIG_EXT['archive'] ) {
			$where_date = "AND ( DATE_FORMAT( e.startdate,'%Y%m%d' ) >= $day_pattern )";
		}
		$query = "SELECT e.id as extid, e.title, e.description,
			'' as recur_type, '' as url, e.catid as cat, c.name as cat_name, e.startdate as start_date, c.id as cat_id,
			DATE_FORMAT( e.startdate, '%Y%m%d' ) as date
			FROM #__community_events AS e
			LEFT JOIN #__community_events_category as c
			ON c.id = e.catid
			WHERE (e.title LIKE ".$extcal_search_clean." OR e.description LIKE ".$extcal_search_clean.")
			AND e.published = 1 ".$where_date;
		if ( !empty( $cat_list_illbethere ) ) {
			$query .= " AND e.cat_id ".( $exclude_community ? 'NOT' : '' )." IN ( " . $cat_list_community . " )";
		}
		$query .= " ORDER BY start_date";
		// query db
		$db->setQuery( $query );
		$extra_rows = $db->loadObjectList();
		foreach ( $extra_rows as $i => $row ) {
			if ( in_array( $row->cat_name, $catnames ) ) {
				$row->cat_id = array_search( $row->cat_name, $catnames );
			} else {
				$row->cat_ext_link = 'community';
			}
			$row->cat_ext = 'community';
			$row->color = $CONFIG_EXT['color_community'];
			$rows[$row->date.'_'.$i.'_c'] = $row;
		}
	}

	ksort( $rows );

	$count = 0;
	$search_results = array();

	if (!empty( $rows)) {
		foreach( $rows as $row) {
			if (  isset( $row->cat_ext ) || has_priv ( 'category' . $row->cat ) ) {
				$title = format_text($row->title,false,$CONFIG_EXT['capitalize_event_titles']);
				$search_results[$count]['search_title'] = highlight($extcal_search,$title,"<span class='titlehighlight'>","</span>");

				# popup or not ?
				if ($CONFIG_EXT['popup_event_mode']) {
					if ( isset( $row->cat_ext ) && $row->cat_ext == 'illbethere' ) {
						$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$row->extid . '&amp;tmpl=component'.$Itemid_Querystring;
					} else if ( isset( $row->cat_ext ) && $row->cat_ext == 'community' ) {
						$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$row->extid . '&amp;tmpl=component'.$Itemid_Querystring;
					} else {
						$non_sef_href = "index.php?option=" . $option . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$row->extid. '&amp;tmpl=component';
					}
					$search_results[$count]['search_link'] = 'href="'.JRoute::_($non_sef_href).'" class="jcal_modal" rel="{handler: \'iframe\'}" ';
				} else {
					if ( isset( $row->cat_ext ) && $row->cat_ext == 'illbethere' ) {
						$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$row->extid.$Itemid_Querystring );
					} else if ( isset( $row->cat_ext ) && $row->cat_ext == 'community' ) {
						$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$row->extid.$Itemid_Querystring );
					} else {
						$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$row->extid );
					}
					$search_results[$count]['search_link'] = "href='$sef_href'";
				}

				$description = process_content(format_text(sub_string($row->description,100,"..."),false,false));

				$search_results[$count]['search_desc'] = highlight($extcal_search,$description,"<span class='highlight'>","</span>");

				$search_results[$count]['cat_id'] = $row->cat;
				if ( isset( $row->cat_ext_link ) &&$row->cat_ext_link ) {
					$search_results[$count]['cat_id'] .= '&amp;cat_ext='.$row->cat_ext_link;
				}
				$search_results[$count]['cat_name'] = $row->cat_name;
				$search_results[$count]['date'] = jcUTCDateToFormat( $row->start_date, $lang_date_format['day_month_year'] );
				$count++;

				$num_rows = $count;
			}
		}
	}

}

theme_search_results($search_results, $num_rows);