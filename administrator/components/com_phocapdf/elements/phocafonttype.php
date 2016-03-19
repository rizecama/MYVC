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

class JElementPhocaFontType extends JElement
{

	var	$_name 	= 'PhocaFontType';
	var $_path	= null;

	function fetchElement($name, $value, &$node, $control_name) {
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );

		$font = $this->_getXmlFiles();
		$options = array();
		if (!empty($font)) {
			foreach($font as $option) {
				if (isset($option->tag)) {
					$val	= $option->tag;
					$text	= $option->tag;
					$options[] = JHTML::_('select.option', $val, JText::_($text));
				}
			}
		}
		if (empty($options)) {
			return JText::_('No font found');
		} else {
			return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', $class, 'value', 'text', $value, $control_name.$name);
		}
	}
	
	function _getXmlFiles() {
		$xmlFiles 		= JFolder::files($this->_getPath(), '.xml$', 1, true);
		$font			= array();
		
		// If at least one xml file exists
		if (count($xmlFiles) > 0) {
			foreach ($xmlFiles as $key => $value) {
				
				$xml = $this->_isManifest($value);	
				if(!is_null($xml->document->children())) {
					foreach ($xml->document->children() as $key => $value) {
						if ($value->_name == 'tag') {
							$font[]->tag = $value->_data;
						}
					}
				}
			}
		}
		return $font;
	}
	
	function &_isManifest($file) {
		// Initialize variables
		$null	= null;
		$xml	=& JFactory::getXMLParser('Simple');

		// If we cannot load the xml file return null
		if (!$xml->loadFile($file)) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		
		$root =& $xml->document;
		if (!is_object($root) || ($root->name() != 'install' )) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		return $xml;
	}
	
	function _getPath() {
		if (empty($this->_path)) {
			$this->_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'fonts';
		}
		return $this->_path;
	}
}
