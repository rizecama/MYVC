<?php
//FHW User Font Size Adjustment Module//
/**
* mod_fhw-fontadjust
* @author Kevin Florida, 04/04/2009
* **For support, visit www.floridahostweb.com/fhw-forum
* **www.floridahostweb.com
* ---------------------------------------------------------------------------
* This module is distributed free of charge under the GNU/GPL License.  This
* module is distributed without any warranties.  Use at your own risk.
* Always backup your files and database prior to any new extension install.
* ---------------------------------------------------------------------------
* @package Joomla 1.5
* @copyright Copyright (C) 2009 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
* This module is based upon Simple Font Resizer by, UnDesign.
* --------------------------------------------------------------------------- 
* --------------VERSION CONTROL----------------------------------------------
* --VERSION 3.0 BY: KEVIN FLORIDA, 08/17/2009
* ----1) Updated code, removed excessive javascript
* --VERSION 3.2 by: Kevin Florida, 08/19/2009
* ----1) Removed invalid Div Tags
* ----2) Added classes to image buttons
* ----3) Added Reset link class
* --VERSION 3.3 BY: KEVIN FLORIDA, 09/03/2009
* ----1) Added Pixel, Point, and Percentage params.
* --VERSION 3.4 BY: KEVIN FLORIDA, 09/04/2009
* ----1) Fixed default size issue.
* --VERSION 3.5 BY: KEVIN FLORIDA, 09/08/09
* ----1) Fixed img URL, made automatic detection
* --VERSION 3.5.5 BY: KEVIN FLORIDA, 09/17/09
* ----1) Added base URL to all tags to fix joomfish conflict
* --VERSION 3.6 BY: KEVIN FLORIDA, 09/17/2009
* ----1) Added new params to control max and min font sizes.
* --VERSION 3.8 By: Kevin Florida, 09/26/2009
* ----1) changed em typo to %
* ----2) Added em option
* ----3) Added Custom Text Option
* ----4) Added em.js file
* ------note: em option has a bug, commented out until fixed.
* --VERSION 3.9 BY: KEVIN FLORIDA, 10/02/2009
* ----1)  Fixed Artisteer Conflict
* ----2) Added tutorial link to language file.
* --VERSION 4.0 BY: KEVIN FLORIDA, 10/09/09
* ----1) Added German language file
* ----2) Added custom image option
* ----3) Updated documentation
* ----4) Updated image options
* --VERSION 4.3 BY: KEVIN FLORIDA, 10/05/2010
* ----1) Text Version Error Fixed.
* --VERSION 4.5 BY: KEVIN FLORIDA 01/23/2010
* ----1) Added helper file
* ----2) Added Macedonian language file
*----------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$originalFontpx = $params->get( 'originalFontpx');
$originalFontem = $params->get( 'originalFontem');
$originalFontper = $params->get( 'originalFontper');
$originalFontpt = $params->get( 'originalFontpt');
$TextOrImage = $params->get( 'TextOrImage');
$ImageOption = $params->get( 'ImageOption');
$preText = $params->get('PreFixText');
$class_sfx = $params->get( 'moduleclass_sfx', "");
$Lgclass_sfx = $params->get( 'LGclass_sfx', "");
$Smclass_sfx = $params->get( 'SMclass_sfx', "");
$Rsclass_sfx = $params->get('Rsclass_sfx', "");
$sizeStyle = $params->get('sizeStyle', "");
$maxSizeem = $params->get('maxSizeem');
$minSizeem = $params->get('minSizeem');
$maxSizepx = $params->get('maxSizepx');
$minSizepx = $params->get('minSizepx');
$maxSizept = $params->get('maxSizept');
$minSizept = $params->get('minSizept');
$maxSizeper = $params->get('maxSizeper');
$minSizeper = $params->get('minSizeper');
$largerTxt = $params->get('largerTxt');
$resetTxt = $params->get('resetTxt');
$smallerTxt = $params->get('smallerTxt');
$customWidth = $params->get('customWidth');
$customHeight = $params->get('customHeight');
$RtCustom = $params->get('RtButton');
$LgCustom = $params->get('LgButton');
$SmCustom = $params->get('SmButton');
$FHWfontAlign = $params->get('FHWfontAlign');
$newLine = $params->get('newLine');
$disableCookies = $params->get('disableCookies');

if($disableCookies == '2') {
	$noC = '_nc';
}else{
	$noC = '';
}

$PreFloat = $params->get( 'float', "");
	if ($PreFloat != '1')
		{
		$float = $PreFloat;
		}	

//set site url
$path = 'modules/mod_fhw_fontadjust/images/';
$BaseUrl = JURI::base() . $path;
$SiteUrl = JURI::base();

//get helper
require_once(dirname(__FILE__).DS.'helper.php');

//get template
require(JModuleHelper::getLayoutPath('mod_fhw_fontadjust'));

?>

