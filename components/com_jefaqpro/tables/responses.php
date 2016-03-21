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

class Tableresponses extends JTable
{
  var $id  		 		  = null;
  var $faqid	  		  = null;
  var $catid     		  = null;
  var $userid	 		  = null;
  var $response_yes	      = null;
  var $response_no	      = null;
  var $remote_ip		  = null;

	function Tableresponses( &$db )
	{
		parent::__construct( '#__je_faq_responses', 'id', $db );

	}
}
?>