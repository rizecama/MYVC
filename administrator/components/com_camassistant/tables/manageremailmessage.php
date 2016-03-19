<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablemanageremailmessage extends JTable
{
    var $id = null;
	var $managerid = null; 	
	var $email_text = null; 	
	
	function __construct(& $db) {
		parent::__construct('#__cam_manager_emailtext', 'id', $db);
	}
	
	
}
?>
