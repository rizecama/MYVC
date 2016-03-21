<?php
/*
# "VOTItaly" Plugin for Joomla! 1.5.x - Version 1.2
# License: http://www.gnu.org/copyleft/gpl.html
# Authors: Luca Scarpa & Silvio Zennaro
# Copyright (c) 2006 - 2009 Siloos snc - http://www.siloos.it
# Project page at http://www.joomitaly.com - Demos at http://demo.joomitaly.com
# ***Last update: Aug 27th, 2009***
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onBeforeDisplayContent', 'plgVotitaly' );

function plgVotitaly( &$row, &$params, $page=0 ) {

	global $my, $addScriptVotitalyPlugin;
	
	$database = & JFactory::getDBO();
	$uri = & JFactory::getURI();
	$plugin = & JPluginHelper::getPlugin('content', 'ji_votitaly');
	$plgParams = new JParameter( $plugin->params );
		$show_stars = $plgParams->get('show_stars', 1);
		$star_description = $plgParams->get('star_description', '');
		
	$id = $row->id;
	$html = '';
	
	if (isset($row->rating_count) && $params->get( 'show_vote' ) && !$params->get( 'popup' )) {

			if(JPlugin::loadLanguage( 'plg_content_ji_votitaly' ) === false)
				JPlugin::loadLanguage( 'plg_content_ji_votitaly', JPATH_ADMINISTRATOR );		
	
			$id 	= $row->id;
			$query = 'SELECT *' .
					' FROM #__content_rating' .
					' WHERE content_id = '.(int) $id;
			$database->setQuery($query);
			$rating = $database->loadObject();
			
			if (!$rating)	{
				$rating_count = 0;
				$rating_sum   = 0;
				$average      = 0;
				$width        = 0;
			} else {
				$rating_count = $rating->rating_count;
				$rating_sum = $rating->rating_sum;		
				$average = number_format(intval($rating_sum) / intval( $rating_count ),2);
				$width   = $average * 20;
			}
			$trans_star_description = _plgVotitaly_replaceDescString($star_description, $rating_count, $average);
			
			// +++++++++++++++++++++++++++++++++++++++
			// ++++++ Printing javascript code +++++++
			// +++++++++++++++++++++++++++++++++++++++
			$script='
<!-- VOTItaly Plugin v1.1 starts here -->
';

$script.='<link href="'.JURI::base().'plugins/content/ji_votitaly/css/votitaly.css" rel="stylesheet" type="text/css" />';	

$script.='
<script type="text/javascript">
'."
	window.addEvent('domready', function(){
	  var ji_vp = new VotitalyPlugin({
	  	submiturl: '".JURI::base()."plugins/content/ji_votitaly_ajax.php',
			loadingimg: '".JURI::base()."plugins/content/ji_votitaly/images/loading.gif',
			show_stars: ".($show_stars ? 'true' : 'false').",
			star_description: '".addslashes($star_description)."',		
			language: {
				updating: '".addslashes(JText::_( 'VOTITALY_UPDATING'))."',
				thanks: '".addslashes(JText::_( 'VOTITALY_THANKS'))."',
				already_vote: '".addslashes(JText::_( 'VOTITALY_ALREADY_VOTE'))."',
				votes: '".addslashes(JText::_( 'VOTITALY_VOTES'))."',
				vote: '".addslashes(JText::_( 'VOTITALY_VOTE'))."',
				average: '".addslashes(JText::_( 'VOTITALY_AVERAGE'))."',
				outof: '".addslashes(JText::_( 'VOTITALY_OUTOF'))."',
				error1: '".addslashes(JText::_( 'VOTITALY_ERR1'))."',
				error2: '".addslashes(JText::_( 'VOTITALY_ERR2'))."',
				error3: '".addslashes(JText::_( 'VOTITALY_ERR3'))."',
				error4: '".addslashes(JText::_( 'VOTITALY_ERR4'))."',
				error5: '".addslashes(JText::_( 'VOTITALY_ERR5'))."'
			}
	  });
	});
".'
</script>
<script type="text/javascript" src="'.JURI::base().'plugins/content/ji_votitaly/js/votitalyplugin.js"></script>
<!-- VOTItaly Plugin v1.1 ends here -->';		

			if(!$addScriptVotitalyPlugin){	
				$addScriptVotitalyPlugin = 1;
				JApplication::addCustomHeadTag($script);
			}
			// +++++++++++++++++++++++++++++++++++++++
			// +++++ /Printing javascript code +++++++
			// +++++++++++++++++++++++++++++++++++++++
						
// +++++++++++++++++++++++++++++++++++++++
// ++++++++ Printing html code +++++++++++
// +++++++++++++++++++++++++++++++++++++++
$html = '
<!-- Votitaly Plugin v1.2 starts here -->
<div class="votitaly-inline-rating" id="votitaly-inline-rating-'. $id .'">
	<div class="votitaly-get-id" style="display:none;">'. $id .'</div> 
';
if ($show_stars) {
	$html .= '
	<div class="votitaly-inline-rating-stars">
	  <ul class="votitaly-star-rating">
	    <li class="current-rating" style="width:'. $width .'%;">&nbsp;</li>
	    <li><a title="1 '. JText::_( 'VOTITALY_STAR' ) .'" class="votitaly-toggler one-star">1</a></li>
	    <li><a title="2 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler two-stars">2</a></li>
	    <li><a title="3 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler three-stars">3</a></li>
	    <li><a title="4 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler four-stars">4</a></li>
	    <li><a title="5 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler five-stars">5</a></li>
	  </ul>
	</div>
	';
}
$html .= '
	<div class="votitaly-box">
';
/*if ($show_votes || $show_average) {
	$html .= '('. 
		($show_votes ? $rating_count .' '. ($rating_count==1 ? JText::_( 'VOTITALY_VOTE' ) : JText::_( 'VOTITALY_VOTES' )) : '') .
		($show_votes && $show_average ? ', ' : '') .
		($show_average ? JText::_( 'VOTITALY_AVERAGE' ) .': '. $average .' '. JText::_( 'VOTITALY_OUTOF' ) : '') .
		')';
}
*/$html .= $trans_star_description;
$html .= '
	</div>
</div>
<!-- Votitaly Plugin v1.2 ends here -->
';
	}
// +++++++++++++++++++++++++++++++++++++++
// ++++++++ Printing html code +++++++++++
// +++++++++++++++++++++++++++++++++++++++	
	return $html;
}

function _plgVotitaly_replaceDescString($string, $num_votes, $num_average) 
{
	$patterns = array(
		'/{num_votes}/',
		'/{num_average}/',
		'/#LANG_VOTES/',
		'/#LANG_AVERAGE/',
		'/#LANG_OUTOF/',
	);
	$replacements = array( 
		$num_votes, 
		$num_average, 
		($num_votes==1 ? JText::_( 'VOTITALY_VOTE') : JText::_( 'VOTITALY_VOTES')),
		JText::_( 'VOTITALY_AVERAGE'),
		JText::_( 'VOTITALY_OUTOF')
	);
	
	return preg_replace($patterns, $replacements, $string);
}

