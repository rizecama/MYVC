<?php 
//Simple Font Resizer Javascript//
/**
* Simple Font Resizer Javascript
* @package Joomla 1.5
* @copyright Copyright (C) 2008 UnDesign. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
$defaultSize = $params->get( 'defaultSize', '30' );
$useImg = $params->get( 'useImg', '1' );
$app = & JFactory::getApplication();
$template = $app->getTemplate();

echo "
<script language='javascript' type='text/javascript'>
<!--
defaultSize = $defaultSize;
//-->
</script>"
;
?>
<script type="text/javascript" src="modules/mod_fontsize/js/md_stylechanger.js"></script>

<div id="fontsize">
  <script type="text/javascript">
				//<![CDATA[
					document.write('<?php 
					//uncomment below if you want to show 'font size' text
					//echo JText::_('FONTSIZE'); ?>');
		document.write('<a href="index.php" title="<?php echo JText::_('Decrease size'); ?>" onclick="changeFontSize(-1); return false;" class="reset"><?php 
					if ($params->get('useImg', 1))
		{
		if($template == 'camassistant_left' || $template == 'camassistant_center'){
		echo '<img style="margin:0 padding:0;" src="images/SC.png" alt="Reset size" />';
		}
		else {
		echo '<img style="margin:0 padding:0;" src="images/S.gif" alt="Reset size" />';
		}
		}
		else{
		echo JText::_(' reset');
		} ?></a>');			
					document.write('<a href="index.php" title="<?php echo JText::_('Reset font size to default'); ?>" onclick="revertStyles(); return false;" class="smaller"><?php 
					if ($params->get('useImg', 1))
		{
		if($template == 'camassistant_left' || $template == 'camassistant_center'){
		echo '<img style="margin:0 padding:0;" src="images/MC.png" alt="Increase size" />';
		}
		else {
		echo '<img style="margin:0 padding:0;" src="images/M.gif" alt="Increase size" />';
		}
		}
		else{
		echo JText::_(' -');
		} ?></a>');
					
		document.write(' <a href="index.php" title="<?php echo JText::_('Increase size'); ?>" onclick="changeFontSize(1); return false;" class="larger"><?php 
					if ($params->get('useImg', 1))
		{
		if($template == 'camassistant_left' || $template == 'camassistant_center'){
		echo '<img style="margin-left:-4px; padding:0;" src="images/LC.png" alt="Increase size" />';
		}
		else {
		echo '<img style="margin-left:-4px; padding:0;" src="images/L.gif" alt="Increase size" />';
		}
		}
		else{
		echo JText::_('+');
		} ?></a>');
				//]]>
				</script>
</div>
