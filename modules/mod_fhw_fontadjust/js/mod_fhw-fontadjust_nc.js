//FHW User Font Size Adjustment Module//
/**
* mod_fhw-fontadjust version 3.9
* @author Kevin Florida, 04/04/2009
* **customersupport@floridahostweb.com
* **www.floridahostweb.com
* ---------------------------------------------------------------------------
* This module is distributed free of charge under the GNU/GPL License.  This
* module is distributed without any warranties.  Use at your own risk. This module is based upon Simple Font Resizer by, UnDesign.
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
*----------------------------------------------------------------------------
*/


var prefsLoaded = false;
var defaultFontSize = universalFontSize;
var currentFontSize = defaultFontSize;
var maxSize = maxSize;
var minSize = minSize;

function revertStyles(){

	currentFontSize = defaultFontSize;
	changeFontSize(0);

}



function changeFontSize(sizeDifference){
	currentFontSize = parseInt(currentFontSize) + parseInt(sizeDifference * 5);

	if(currentFontSize > maxSize){
		currentFontSize = maxSize;
	}else if(currentFontSize < minSize){
		currentFontSize = minSize;
	}

	setFontSize(currentFontSize);
};

function setFontSize(fontSize){
	var stObj = (document.getElementById) ? document.getElementById('content_area') : document.all('content_area');
	document.body.style.fontSize = fontSize + '%';

	//alert (document.body.style.fontSize);
};

function setUserOptions(){
	if(!prefsLoaded){

		cookie = readCookie("FHWfontSize34per");
		currentFontSize = cookie ? cookie : defaultFontSize;
		setFontSize(currentFontSize);

		prefsLoaded = true;
	}

}