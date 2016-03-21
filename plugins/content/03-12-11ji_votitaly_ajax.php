<?php
/*
# "VOTItaly" Plugin for Joomla! 1.5.x - Version 1.2
# License: http://www.gnu.org/copyleft/gpl.html
# Authors: Luca Scarpa & Silvio Zennaro
# Copyright (c) 2006 - 2009 Siloos snc - http://www.siloos.it
# Project page at http://www.joomitaly.com - Demos at http://demo.joomitaly.com
# ***Last update: Aug 27th, 2009***
*/

// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) . '/../..' );
define('JPATH_CORE', JPATH_BASE . '/../..');
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe =& JFactory::getApplication('site');
$cfg =& JFactory::getConfig();
$db  =& JFactory::getDBO();

//$rate = (int) JRequest::getVar( 'rating', false );
$rate = JRequest::getVar( 'rating', false );  
$cid  = (int) JRequest::getVar( 'cid', false );


/** RETRIEVING VOTITALY PLUGIN PARAMETERS **/
	jimport( 'joomla.plugin.helper' );
	$plg = JPluginHelper::getPlugin('content', 'ji_votitaly');
	$pluginParams    = new JParameter( $plg->params );
	$vi_params = new stdClass();
		$vi_params->rating_access 		= $pluginParams->get('rating_access', 'all');
		$vi_params->rating_periodical	= $pluginParams->get('rating_periodical', '0');
		$vi_params->only_registered		= $vi_params->rating_access == "reg";
		$vi_params->check_dbtable		= $pluginParams->get('check_dbtable', $vi_params->only_registered);
/** /RETRIEVING VOTITALY PLUGIN PARAMETERS **/




/** /CHECKING FOR DATABASE INTEGRITY **/
	if ($vi_params->check_dbtable) {
		_votitaly_checkDatabaseIntegrity();
		
	}
/** /CHECKING FOR DATABASE INTEGRITY **/



// calling the _votitaly_storeVote function to submit the rating action
 $status_code = _votitaly_storeVote($cid, $rate); 


// end here!







/**
 * FUNCTION _votitaly_storeVote
 **/
function _votitaly_storeVote($content_id, $user_rating) {

	global $db, $vi_params;
	
	$error = 0;
	$message = '';
		
	/** CHECKING FOR RATING ACCESS **/
	if ($vi_params->only_registered) {
	
		$my =& JFactory::getUser();
		$content_id = $_POST['cid']; 
		$user->id = $_POST['cusid']; 
		$user_type = $_POST['user_type'];  
		if ($user->guest) {
			$error = 4; // only logged users can vote
		} else {
			// retrieving last rating
			$query = 'SELECT COUNT(id) as num FROM #__vi_rating'
				. ' WHERE content_id='.intval($content_id)
				. '   AND user_id='.intval($user->id);
			if ($vi_params->rating_periodical > 0) 
				$query .= '   AND DATE_ADD(submitted, INTERVAL '.intval($vi_params->rating_periodical).' HOUR) > NOW()';

			$db->setQuery($query);		
			if (!$db->query()) {
				$error = 1;
				$message = $db->stderr();
			} else {
				$obj = $db->loadObject();
				//echo "<pre>"; print_r($obj); exit;
				if ($obj->num > 0 && $user_type != 'admin' ) {
					$error = 5;
				} else {
					// inserting new rating
					//echo "<pre>"; print_r($_REQUEST);
					if($user_type == 'admin')
					{
					$query = 'DELETE FROM #__vi_rating  WHERE content_id = '.$content_id.' AND user_id =  '.$user->id; 
					$db->setQuery($query);	
					$db->query();
					}
					/*$query = 'INSERT INTO #__vi_rating (content_id, user_id, rating, submitted) '
						. ' VALUES ('.intval($content_id).', '.intval($user->id).', '.intval($user_rating).', NOW()) ';*/
					$query = 'INSERT INTO #__vi_rating (content_id, user_id, rating, submitted) ' 
						. ' VALUES ('.intval($content_id).', '.intval($user->id).', '.$user_rating.', NOW()) '; 
					$db->setQuery($query);			
					if (!@$db->query()) {
						$error = 1;
						$message = $db->stderr();
					}
				}
			}
		}
	}
	/** /CHECKING FOR RATING ACCESS **/
	
	
	
	/** RETRIEVING OLD RATING VALUES **/
	$query = 'SELECT *' .
			' FROM #__content_rating' .
			' WHERE content_id = '.(int) $content_id;
	$db->setQuery($query);
	$rating = $db->loadObject();
	
	if (!$rating)	{
		$prev_rating_count = 0;
		$prev_rating_sum = 0;
	} else {
		$prev_rating_count = $rating->rating_count;
		$prev_rating_sum = $rating->rating_sum;		
	}
	/** /RETRIEVING OLD RATING VALUES **/



	/** TRYING TO SUBMIT JOOMLA RATING **/
	if (!$error && $user_rating >= 1 && $user_rating <= 5) {
		$userIP =  $_SERVER['REMOTE_ADDR'];
		//echo $rating;
		if (!$rating) {
			// There are no ratings yet, so lets insert our rating
			$query = 'INSERT INTO #__content_rating ( content_id, lastip, rating_sum, rating_count )' .
					' VALUES ( '.(int) $content_id.', '.$db->Quote($userIP).', '.$user_rating.', 1 )';
			$db->setQuery($query);
			if (!$db->query()) {
				$error = 1;
				$message = $db->stderr();
			} else {
				$rating_count = 1;
				$rating_sum = $user_rating;
			}
		} else {
			// if only registered we disable the latest ip check
			/*if ($userIP != ($rating->lastip) || $vi_params->only_registered) {*/
				// We weren't the last voter so lets add our vote to the ratings totals for the article
				/*if($user_type != 'admin')
				{*/
					/*$query = 'UPDATE #__content_rating' .
							' SET rating_count = rating_count + 1, rating_sum = rating_sum + '.(int) $user_rating.', lastip = '.$db->Quote($userIP) .
							' WHERE content_id = '.(int) $content_id;*/
					 $query = 'UPDATE #__content_rating' .
					' SET rating_count = 1, rating_sum =  '.$user_rating.', lastip = '.$db->Quote($userIP) .
					' WHERE content_id = '.(int) $content_id; 
					$db->setQuery($query);
					if (!$db->query()) {
						$error = 1;
						$message = $db->stderr();
					} else {
						$rating_count = $prev_rating_count + 1;
						$rating_sum = $prev_rating_sum + $user_rating;
					}
				/*}*/
			/*} else {
				$error = 2; // already rated (check with ip address)! 
			}*/
		}
	} else if (!$error) // at this point we can have error 4
		$error = 3;
	// ... else $error = $error!
	/** /TRYING TO SUBMIT JOOMLA RATING **/
	
	
	/** CALCULATE ACTUAL AVERAGE AND STAR WIDTH **/
	if (!$error) {
		$average = number_format(($rating_sum) / intval( $rating_count ),2);
		$width   = $average * 20;
	} else {
		$average = ($prev_rating_count ? number_format(($prev_rating_sum) / intval( $prev_rating_count ),2) : 0 );
		$width   = $average * 20;
	}
	/** /CALCULATE ACTUAL AVERAGE AND STAR WIDTH **/


	/** PRINT OUT RATING RESULTS **/
?>
{
	success: <?php echo ( $error ? 'false' : 'true' ); ?>, 
	return_code: <?php echo $error; ?>,
	message: "<?php echo addslashes($message); ?>",
	width: <?php echo ( false ? '""' : '"'.$width.'%"' ); ?>,
	num_votes: <?php echo ( $error ? $prev_rating_count : $rating_count ); ?>, 
	average: <?php echo ( false ? '""' : $average ); ?>, 
	out_of: 5
}
<?php


	/** /PRINT OUT RATING RESULTS **/

} // end of _votitaly_storeVote function






/**
 * FUNCTION _votitaly_checkDatabaseIntegrity
 * - this function will try to create the table that will contain all the registered user rating submissions
 **/
function _votitaly_checkDatabaseIntegrity() {
	global $db;

	$query = 'CREATE TABLE IF NOT EXISTS `#__vi_rating` ( '
		. ' 	`id` int(10) unsigned NOT NULL auto_increment, '
		. ' 	`content_id` int(10) unsigned NOT NULL, '
		. ' 	`user_id` int(10) unsigned NOT NULL, '
		. ' 	`rating` tinyint(3) unsigned NOT NULL, '
		. ' 	`submitted` datetime NOT NULL, '
		. '		PRIMARY KEY  (`id`), '
		. '  	KEY `idx_content_id_user_id` (`content_id`,`user_id`) '
		. ' )';
	$db->setQuery($query);	
	
	return $db->query();

}