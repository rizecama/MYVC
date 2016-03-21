<?php
/**
 * jeFAQ pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @license GNU/GPL, see LICENSE.php for full license.
 * @copyright (C) 2010 - 2011 J-Extension
 
 * @Copyright 2009 Michael Gyen <GyenMic@autartica.be>
 *      This file is part of autartimonial.
 *      captcha.php
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

/* Change it to have a specific encoding ! */
define("AUTARTICAPTCHA_ENTROPY","AutarTICa Captcha");

/* Choose length (max 32) */
define("AUTARTICAPTCHA_LENGTH",2);

$GLOBALS["autarticaptcha_akey"] = md5(uniqid(rand(), true));

/**
 * Helper to generate html form tags
 *
 */
class AutarticaptchaHelper
{
	/**
	 * Generate IMG Tag
	 *
	 * @param string $baseuri : relative or absolute path to folder containing this file on web
	 * @return IMG Tag
	 */
	function generateImgTags($baseuri)
	{
		$str=$baseuri."captcha.php?pck=".$GLOBALS['autarticaptcha_akey']."\"".
			" id=\"autarticaptcha\"".
			" onclick=\"javascript:this.src='".$baseuri."captcha.php?pck=".
			$GLOBALS['autarticaptcha_akey'].
			"&z='+Math.random();return false;\"";

		return JHTML::_('image',$str,"???");
	}

	/**
	 * Generate hidden tag (must be in a form)
	 *
	 * @return input hidden tag
	 */
	function generateHiddenTags()
	{
		return "<input type=\"hidden\" name=\"autarticaptcha_key\" value=\"".$GLOBALS['autarticaptcha_akey']."\"/>";
	}

	/**
	 * Generate input tag (must be in a form)
	 *
	 * @return input tag
	 */
	function generateInputTags()
	{
		return "<input type=\"text\" class=\"input required\" id=\"autarticaptcha_entry\" name=\"autarticaptcha_entry\" value=\"\" size=\"5\" maxlength=\"2\" />";
	}

	/**
	 * Check if user input is correct
	 *
	 * @return boolean (true=correct, false=incorrect)
	 */
	function checkCaptcha($test)
	{
		if($test){
			if(	isset($_POST['autarticaptcha_entry']) &&
				$_POST['autarticaptcha_entry'] == autarticaptchaHelper::_getDisplayText($_POST['autarticaptcha_key']))
			{
				return true;
			}
			return false;
		}else{return true;}
	}

	/**
	 * Internal function
	 *
	 * @param string $pck
	 * @return string
	 */
	function _getDisplayText($pck)	// internal function
	{
		$src=md5(AUTARTICAPTCHA_ENTROPY.$pck);
		$txt="";
		for($i=0;$i<AUTARTICAPTCHA_LENGTH;$i++)
			$txt.=substr($src,$i*32/AUTARTICAPTCHA_LENGTH,1);
		return $txt;
	}
}


// If script called directly : generate image
if(basename($_SERVER["SCRIPT_NAME"])=="captcha.php" && isset($_GET["pck"]))
{
	$width = AUTARTICAPTCHA_LENGTH*10+20;
	$height = 25;

	$image = imagecreatetruecolor($width, $height);
	$bgCol = imagecolorallocate($image, 204, 204, 204);
	imagefilledrectangle($image,0,0,$width,$height,$bgCol);

	$txt = autarticaptchaHelper::_getDisplayText($_GET["pck"]);

	for($c=0;$c<AUTARTICAPTCHA_LENGTH*2;$c++)
	{
		$bgCol = imagecolorallocate($image, 204, 204, 204);
		$x=rand(0,$width);
		$y=rand(0,$height);
		$w=rand(5,$width/2);
		$h=rand(5,$height/2);
		imagefilledrectangle($image,$x,$y,$x+$w,$y+$h,$bgCol);
		imagecolordeallocate($image,$bgCol);
	}
	for($c=0;$c<AUTARTICAPTCHA_LENGTH;$c++)
	{
		$txtCol = imagecolorallocate($image, 0,0,0);
		imagestring($image,5,5+10*$c,rand(0,10),substr($txt,$c,1),$txtCol);
		imagecolordeallocate($image,$txtCol);
	}

	header("Content-type: image/png");
	imagepng($image);
	imagedestroy($image);
}
?>
