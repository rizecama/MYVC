<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tableemailmessage extends JTable
{
    var $id = null;
	var $rfpid = null; 	
	var $email_text = null; 	
	
	function __construct(& $db) {
		parent::__construct('#__cam_awarded_emailtext', 'id', $db);
	}
	
	
}
?>
