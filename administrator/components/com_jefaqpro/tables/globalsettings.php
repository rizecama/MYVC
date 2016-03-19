<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class Tableglobalsettings extends JTable
{
  var $id           	  = null;
  var $show_form		  = null;
  var $show_reguser		  = null;
  var $show_author		  = null;
  var $show_date		  = null;
  var $footer_text		  = null;
  var $user_email		  = null;
  var $admin_email		  = null;
  var $emailid 			  = null;
  var $introtext		  = null;
  var $show_title		  = null;
  var $show_image		  = null;
  var $show_captcha		  = null;
  var $show_hits		  = null;
  var $allow_reg		  = null;
  var $show_response	  = null;
  var $themes			  = null;
  var $cat_perpage		  = null;
  var $resize			  = null;
  var $image_width		  = null;
  var $image_height		  = null;
  var $date_format		  = null;
  var $group			 = null;
  var $sorting			 = null;

	function Tableglobalsettings( &$db )
	{
		parent::__construct( '#__je_faq_settings', 'id', $db );
	}
}
?>