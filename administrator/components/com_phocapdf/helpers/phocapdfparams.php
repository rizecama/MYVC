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
class PhocaPDFHelperParams
{
	function renderSite($parameters, $name = 'params', $group = '_default') {

		if (!isset($parameters->_xml[$group])) {
			return false;
		}

		$params = $parameters->getParams($name, $group);
		$html = array ();

		$e = count($params) - 1;// count of items which don't begin with 1 but with 0
		$i = 0;
		foreach ($params as $param) {
			switch($param[5]) {
				case 'margin_top':
					if ($param[0]) {
						$html[] = '<table><tr><td></td><td align="center">'
								 .'<div><span class="editlinktip">'.$param[0].':</span> '
								 .'<span>'.$param[1] . '</span></div></td><td></td></tr>';
					} else {
						$html[] = '<table><tr><td></td><td align="center">'.$param[1] . '</td><td></td></tr>';
					}
				break;
				
				case 'margin_left':
					$img = JHTML::_('image.site', 'params-site.png', 'components/com_phocapdf/assets/images/', NULL, NULL, '');
				
					if ($param[0]) {
						$html[] = '<tr><td align="center">'
								 .'<div><span class="editlinktip">'.$param[0].':</span> '
								 .'<span>'.$param[1] . '</span></div></td><td align="center">'.$img.'</td>';
					} else {
						$html[] = '<tr><td>'.$param[1] . '</td><td align="center">'.$img.'</td>';
					}
				break;
				
				case 'margin_right':
				
					if ($param[0]) {
						$html[] = '<td align="center">'
								 .'<div><span class="editlinktip">'.$param[0].':</span> '
								 .'<span>'.$param[1] . '</span></div></td></tr>';
					} else {
						$html[] = '<td>'.$param[1] . '</td></tr>';
					}
				break;
				
				case 'margin_bottom':
					if ($param[0]) {
						$html[] = '<tr><td></td><td align="center">'
								 .'<div><span class="editlinktip">'.$param[0].':</span> '
								 .'<span>'.$param[1] . '</span></div></td><td></td></tr></table>'
								 .'<div class="phocapdf-hr"></div>';
					} else {
						$html[] = '<tr><td></td><td align="center">'.$param[1] . '</td><td></td></tr></table>'
								 .'<div class="phocapdf-hr"></div>';
					}
				break;
				
				default:
					if ($i == 4) {//margin-top, margin-bottom, margin-left, margin-right
						$html[] = '<table>';
					}
					if ($param[0]) {
						$html[] = '<tr><td><span class="editlinktip">'.$param[0].':</span></td>'
								 .'<td>'.$param[1] . '</td></tr>';
					} else {
						$html[] = '<tr><td></td><td>'.$param[1] . '</td></tr>';
					}
					if ($i == $e) {
						$html[] = '</table>';
					}
					
				break;
				
				
			}
			$i++;
			
		}

		if (count($params) < 1) {
			$html[] = '<div>'.JText::_('There are no Parameters for this item').'</div>';
		}

		

		return implode("\n", $html);
	}
	
	
	function renderMisc($parameters, $name = 'params', $group = '_default') {
		
		if (!isset($parameters->_xml[$group])) {
			return false;
		}

		$params = $parameters->getParams($name, $group);
		$html = array ();
		
		$e = count($params) - 1;// count of items which don't begin with 1 but with 0
		$i = 0;
		foreach ($params as $param) {
	
			if ($i == 0) {
				$html[] = '<table>';
			}
			switch($param[5]) {
				case 'header_margin':
					$img = JHTML::_('image.site', 'params-header.png', 'components/com_phocapdf/assets/images/', NULL, NULL, '');
					if ($param[0]) {
						$html[] = '<tr><td>'
								 .'<span class="editlinktip">'.$param[0].':</span></td>'
								 .'<td align="center">'.$param[1] . '<br />'.$img.'</td></tr>';
					} else {
						$html[] = '<tr><td>'.$param[1] . '<br />'.$img.'</td></tr>';
					}
				break;
				
				case 'footer_margin':
					$img = JHTML::_('image.site', 'params-footer.png', 'components/com_phocapdf/assets/images/', NULL, NULL, '');
					if ($param[0]) {
						$html[] = '<tr><td>'
								 .'<span class="editlinktip">'.$param[0].':</span></td>'
								 .'<td align="center">'.$param[1] . '<br />'.$img.'</td></tr>';
					} else {
						$html[] = '<tr><td>'.$param[1] . '<br />'.$img.'</td></tr>';
					}
				break;
			
				default:
			
				if ($param[0]) {
					$html[] = '<tr><td>'
							 .'<span class="editlinktip">'.$param[0].':</span></td>'
							 .'<td>'.$param[1] . '</td></tr>';
				} else {
					$html[] = '<tr><td></td><td>'.$param[1] . '</td></tr>';
				}
				break;
			}
			

			if ($i == $e) {
				$html[] = '</table>';
			}
			$i++;
		}
		
		return implode("\n", $html);
	}
}
?>