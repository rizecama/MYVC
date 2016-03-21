<?php
// JCalPro router
function jcalproBuildRoute(&$query){
	$segments = array();
	//if(isset($query['option'])) $segments[] = $query['option'];
	if(isset($query['extmode'])) {
		$segments[] = $query['extmode'];
		unset($query['extmode']);
	}
	if(isset($query['event_mode'])) {
		$segments[] = $query['event_mode'];
		// if we are trying to view events, but we don't have an extid
		// then we must add a segment, or else the Itemid (at the end of the url)
		// will be mistaken for the extid
		if (empty($query['extid']) && $query['event_mode'] == 'view') {
			$segments[]='all';
		}
		unset($query['event_mode']);
	}
	if(isset($query['extid'])) {
		$segments[] = $query['extid'];
		unset($query['extid']);
	}
	if(isset($query['date'])){
		$segments[] = 'date';
		$segments[] = $query['date'];
		unset($query['date']);
	}
	if(isset($query['cat_id'])){
		$segments[] = 'cat_id';
		$segments[] = $query['cat_id'];
		unset($query['cat_id']);
	}
	if(isset($query['Itemid'])) {
		// don't add Itemid if this is a menu item
		if (empty($query['Itemid']) || empty($query['option']) || count( $query) != 2) {
			$segments[] = $query['Itemid'];
		}
	}
	return $segments;
}

function jcalproParseRoute(&$segments) {
	$vars = array();
	$count = 0;
	$segmentCount = count($segments);
	while( $count <  $segmentCount) {
		if($segments[$count] == 'view') {
			$count++;
			$vars['extmode'] = 'view';
			$vars['extid'] = $segments[$count];
		}
		if($segments[$count] == 'cat') {
			$count += 2;
			$vars['extmode'] = 'cat';
			$vars['cat_id'] = $segments[$count];
		}
		if( $segments[$count] == 'cal' || $segments[$count] == 'minical' || $segments[$count] == 'flat' || $segments[$count] == 'week' || $segments[$count] == 'day' || $segments[$count] == 'cats' || $segments[$count] == 'extcal_search' ) {
			$vars['extmode'] = $segments[$count];
		}
		if( $segments[$count] == 'date' ) {
			$count++;
			$vars['date'] = $segments[$count];
		}
		if( $segments[$count] == 'add' ) {
			$vars['event_mode'] = 'add';
		}
		if( $segments[$count] == 'edit' ) {
			$count++;
			$vars['event_mode'] = 'edit';
			$vars['extid'] = $segments[$count];
		}
		if( $segments[$count] == 'del' ) {
			$count++;
			$vars['extmode'] = 'event';
			$vars['event_mode'] = 'del';
			$vars['extid'] = $segments[$count];
		}
		if( $segments[$count] == 'event' ) {
			$vars['extmode'] = 'event';
			$count++;
			$vars['event_mode'] = $segments[$count];
			$count++;
			switch ($vars['event_mode']) {
				case 'all':
					break;
				case 'add':
					if (!empty( $segments[$count]) && $segments[$count] == 'date') {
						$count++;
						$vars['date'] = $segments[$count];
						$count++;
					}
				default:
					if (isset($segments[$count])) {
						$vars['extid'] = $segments[$count];
					}
					break;
			}
		}
		$count++;
	}

	if (!empty( $vars['date'])) {
		// compensate for Joomla simplistic routing
		$vars['date'] = str_replace( ':', '-', $vars['date']);
	}
	if ($segmentCount > 1 && empty($vars['extmode']) && isset($segments[count($segments)-1])) {
		$vars['Itemid'] = $segments[count($segments)-1];
	}
	// set a default view if not set 
	if (empty($vars['extmode'])) {
		$vars['extmode'] = 'cal';
	}
	return $vars;
}
