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

?>

<?php if($sizeStyle == '1') : ?>
	<?php 
	
	 
	echo "
		<script type='text/javascript'>
		<!--
		universalFontSize = $originalFontper;
		maxSize = $maxSizeper;
		minSize = $minSizeper;
		//-->
		</script>"
		;
	
	?>
	<script type="text/javascript" src="<?php echo $SiteUrl; ?>modules/mod_fhw_fontadjust/js/mod_fhw-fontadjust<?php echo $noC; ?>.js"></script>
<?php endif; ?>

<?php if($sizeStyle == '2') : ?>
	<?php 
	
	 
	echo "
		<script type='text/javascript'>
		<!--
		universalFontSize = $originalFontpx;
		maxSize = $maxSizepx;
		minSize = $minSizepx;
		//-->
		</script>"
		;
	
	?>
<script type="text/javascript" src="<?php echo $SiteUrl; ?>modules/mod_fhw_fontadjust/js/mod_fhw-fontadjust-px<?php echo $noC; ?>.js"></script>
<?php endif; ?>

<?php if($sizeStyle == '3') : ?>
		<?php 
	
	 
	echo "
		<script type='text/javascript'>
		<!--
		universalFontSize = $originalFontpt;
		maxSize = $maxSizept;
		minSize = $minSizept;
		//-->
		</script>"
		;
	
	?>
<script type="text/javascript" src="<?php echo $SiteUrl; ?>modules/mod_fhw_fontadjust/js/mod_fhw-fontadjust-pt<?php echo $noC; ?>.js"></script>
<?php endif; ?>

<?php if($sizeStyle == '4') : ?>
	<?php 
	
	 
	echo "
		<script type='text/javascript'>
		<!--
		universalFontSize = $originalFontem;
		maxSize = $maxSizeem;
		minSize = $minSizeem;
		//-->
		</script>"
		;
	
	?>
	<script type="text/javascript" src="<?php echo $SiteUrl; ?>modules/mod_fhw_fontadjust/js/mod_fhw-fontadjust-em<?php echo $noC; ?>.js"></script>
<?php endif; ?>


<?php
//GET IMAGES:
switch ($params->get('ImageOption','5')) {
	
	//color 1:
	case '1' :
	$LgImg = '<img src="'.$BaseUrl.'larger.jpg" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default.jpg" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller.jpg" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//color 2:
	case '2' :
	$LgImg = '<img src="'.$BaseUrl.'larger2.jpg" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default2.jpg" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller2.jpg" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//color 3:
	case '3' :
	$LgImg = '<img src="'.$BaseUrl.'larger3.jpg" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default3.jpg" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller3.jpg" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//transparent black:
	case '4' :
	$LgImg = '<img src="'.$BaseUrl.'larger4.jpg" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default4.jpg" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller4.jpg" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//transparent black:
	case '6' :
	$LgImg = '<img src="'.$BaseUrl.'larger6.gif" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default6.gif" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller6.gif" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//transparent white:
	case '7' :
	$LgImg = '<img src="'.$BaseUrl.'larger7.png" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default7.png" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller7.png" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//transparent white:
	case '8' :
	$LgImg = '<img src="'.$BaseUrl.'larger7.gif" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default7.gif" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller7.gif" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//begin custom images:
	case '9' :
	$LgImg = '<img src="'.$SiteUrl.'images/'.$LgCustom.'" width="'.$customWidth.'" height="'.$customHeight.'" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$SiteUrl.'images/'.$RtCustom.'" width="'.$customWidth.'" height="'.$customHeight.'" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$SiteUrl.'images/'.$SmCustom.'" width="'.$customWidth.'" height="'.$customHeight.'" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
	//default transparent black:
	default :
	$LgImg = '<img src="'.$BaseUrl.'larger6.png" width="30" height="25" border="0" alt="'.JText::_('INCREASEFONTSIZE').'" />';
	$RtImg = '<img src="'.$BaseUrl.'default6.png" width="30" height="25" border="0" alt="'.JText::_('RESETFONTSIZE').'" />';
	$SmImg = '<img src="'.$BaseUrl.'smaller6.png" width="30" height="25" border="0" alt="'.JText::_('DECREASEFONTSIZE').'" />';
	break;
	
}

?>


