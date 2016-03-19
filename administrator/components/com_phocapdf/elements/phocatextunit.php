<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('JPATH_BASE') or die();

class JElementPhocaTextUnit extends JElement
{
	var	$_name 			= 'PhocaTextUnit';

	function fetchElement($name, $value, &$node, $control_name) {
		$document	= &JFactory::getDocument();
		$option 	= JRequest::getCmd('option');
		
		if (preg_match('/font_size/', $name)) {
			$unit = 'pt';
		} else {
			$unit = 'mm';
		}
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
		
		$html ='<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' /> '.$unit;
		
		return $html;
	}
}
?>