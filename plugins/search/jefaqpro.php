<?php
/*
 * @version             $Id: jefaqpro.php 1.0 Oct - 2010 JExtension
 * @copyright           Copyright
 * @license             License, for example GNU/GPL
 * All other information you would like to add
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onSearch', 'plgSearchjefaqpro' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchjefaqproAreas' );

JPlugin::loadLanguage( 'plg_search_jefaqpro' );

function &plgSearchjefaqproAreas()
{
	static $areas = array(
							'jefaqpro' => 'Jefaqpro'
					);
	return $areas;
}

function plgSearchjefaqpro( $text, $phrase='', $ordering='', $areas=null )
{
	// Joomla predefined function for db connection
		$db    		= & JFactory::getDBO();
	$searchText = $text;

	//If the array is not correct, return it:
		if (is_array( $areas )) {
				if (!array_intersect( $areas, array_keys( plgSearchjefaqproAreas() ) )) {
						return array();
				}
		}

	//Define the parameters. First get the right plugin; 'search' (the group), 'jefaqpro'.
		$plugin			= & JPluginHelper::getPlugin('search', 'jefaqpro');

	//Then load the parameters of the plugin.
		$pluginParams	= new JParameter( $plugin->params );

	//Now define the parameters like this:
		$limit 			= $pluginParams->get( 'searchlimit',	50 );
		$categorised	= $pluginParams->get( 'searchcategory',	0 );

	//Use the function trim to delete spaces in front of or at the back of the searching terms
		$text = trim( $text );

	//Return Array when nothing was filled in.
		if ($text == '') {
			return array();
		}

		$lists = array();
		$wheres = array();

		switch ($phrase) {

			//search exact
				case 'exact':
						$text		= $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );
						$wheres2	= array();

						if ( $categorised ) {
							$wheres2[]	= 'LOWER(cat.category) LIKE '.$text;
						} else {
							$wheres2[]	= 'LOWER(faq.questions) LIKE '.$text;
							$wheres2[]	= 'LOWER(faq.answers) LIKE '.$text;
						}
						$where		= '(' . implode( ') OR (', $wheres2 ) . ')';
						break;

			//search all or any
				case 'all':
				case 'any':

			//set default
				default:
						$words		= explode( ' ', $text );
						$wheres		= array();
						foreach ($words as $word)
						{
								$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
								$wheres2	= array();

								if ( $categorised ) {
									$wheres2[]	= 'LOWER(cat.category) LIKE '.$word;
								} else {
									$wheres2[]	= 'LOWER(faq.questions) LIKE '.$word;
									$wheres2[]	= 'LOWER(faq.answers) LIKE '.$word;
								}
								$wheres[]	= implode( ' OR ', $wheres2 );
						}
						$where	= '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
						break;
		}

	//ordering of the results
		switch ( $ordering ) {

			//alphabetic, ascending
				case 'alpha':
						if ( $categorised ) {
							$order = 'cat.category ASC';
						} else {
							$order = 'faq.questions ASC';
						}
						break;

			//oldest first
				case 'oldest':
						if ( $categorised ) {
							$order = 'cat.ordering ASC';
						} else {
							$order = 'faq.ordering ASC';
						}
						break;

			//popular first
				case 'popular':

			//newest first
				case 'newest':
						if ( $categorised ) {
							$order = 'cat.ordering DESC';
						} else {
							$order = 'faq.ordering DESC';
						}
						break;

			//default setting: alphabetic, ascending
				default:
						if ( $categorised ) {
							$order = 'cat.category ASC';
						} else {
							$order = 'faq.questions ASC';
						}
		}

		if ( $categorised ) {
			$query 	= ' SELECT cat.category AS title, ' .
						' CONCAT(cat.introtext, cat.alias) AS text,' .
						' cat.id as slug '.
						' FROM #__je_faq_category AS cat'
						. ' WHERE ( '. $where .' ) '
						. ' AND cat.state = 1' .
						' ORDER BY '. $order
						;

		} else {
			$query 	= ' SELECT faq.questions AS title, ' .
						' faq.answers AS text, ' .
						' faq.id as slug, '.
						' faq.catid as catslug'
						. ' FROM #__je_faq AS faq'
						. ' WHERE ( '. $where .' )'
						. ' AND faq.state = 1'
						. ' ORDER BY '. $order
						;
		}

	//Set query
		$db->setQuery( $query, 0, $limit );
		$lists = $db->loadObjectList();

	//The 'output' of the displayed title with link & text

		$itemid	= & JRequest::getVar('Itemid', 1);

		 foreach($lists as $key => $row) {
		 	if ( $categorised ) {
				$rows[] = (object) array(
				                        'href'       => 'index.php?option=com_jefaqpro&view=category&sid='.$row->slug.'&Itemid='.$itemid,
				                        'title'      => $row->title,
				                        'text'       => $row->text,
					                );
		 	} else {
		 		$rows[] = (object) array(
								 		'href'       => 'index.php?option=com_jefaqpro&view=faq&sid='.$row->slug.'&Itemid='.$itemid,
					                    'title'      => $row->title,
					                    'text'       => $row->text,
					                );
		 	}
		 }

	//Return the search results in an array
		return $rows;
}
?>