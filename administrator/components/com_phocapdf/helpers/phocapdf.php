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
defined('_JEXEC') or die();
class PhocaPDFHelper
{
	function getPhocaInfo($pdf = 1) {
		$params = JComponentHelper::getParams('com_phocapdf') ;
		$pdf 	= $params->get( 'pdf_id', 1);
		if ($pdf == 1) {
			return '<'.'a'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'c'.'o'.'l'.'o'.'r'.':'.' '.'r'.'g'.'b'.'('.'1'.'7'.'5'.','.'1'.'7'.'5'.','.'1'.'7'.'5'.')'.'"'.' '.'h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'p'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'/'.'p'.'h'.'o'.'c'.'a'.'p'.'d'.'f'.'"'.'>'.'P'.'h'.'o'.'c'.'a'.' '.'P'.'D'.'F'.'<'.'/'.'a'.'>';
		} else {
			return '';
		}
	}



	function getPhocaVersion($component) {
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.$component;
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.$component;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$xml_items = '';
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
					foreach($data as $key => $value) {
						$xml_items[$key] = $value;
					}
				}
			}
		}
		
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
			return $xml_items['version'];
		} else {
			return '';
		}
	}
	
}

class PhocaPDFCell
{
	function setCell($pdf = 1) {
		$params = JComponentHelper::getParams('com_phocapdf') ;
		$pdf 	= $params->get( 'pdf_id', 1);
		if ($pdf == 1) {
			return '<'.'a'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'c'.'o'.'l'.'o'.'r'.':'.' '.'r'.'g'.'b'.'('.'1'.'7'.'5'.','.'1'.'7'.'5'.','.'1'.'7'.'5'.')'.'"'.' '.'h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'p'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'/'.'p'.'h'.'o'.'c'.'a'.'p'.'d'.'f'.'"'.'>'.'P'.'h'.'o'.'c'.'a'.' '.'P'.'D'.'F'.'<'.'/'.'a'.'>';
		} else {
			return '';
		}
	}

}

class PhocaPDFControlPanel
{
	function quickIconButton( $component, $link, $image, $text ) {
		
		$lang	= &JFactory::getLanguage();
		$button = '';
		if ($lang->isRTL()) {
			$button .= '<div style="float:right;">';
		} else {
			$button .= '<div style="float:left;">';
		}
		$button .=	'<div class="icon">'
				   .'<a href="'.$link.'">'
				   .JHTML::_('image.site',  $image, '/components/'.$component.'/assets/images/', NULL, NULL, $text )
				   .'<span>'.$text.'</span></a>'
				   .'</div>';
		$button .= '</div>';

		return $button;
	}
}
?>