<?php
/**
 * @version		2.5.8
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$relName = 'colorbox';
$extraClass = ' sigProColorbox';

$stylesheets = array('example1/colorbox.css');
$stylesheetDeclarations = array();
$scripts = array(
	'colorbox/jquery.colorbox-min.js'
);
$scriptDeclarations = array('
	//<![CDATA[
	jQuery.noConflict();
	jQuery(document).ready(function(){
		jQuery(".sigProColorbox").colorbox({
			transition:"fade",
			contentCurrent:"Image {current} of {total}",
			bgOpacity:"0.9",
			//slideshow:true,
			//width:"75%",
			//height:"75%"
		});
	});
	//]]>
');
