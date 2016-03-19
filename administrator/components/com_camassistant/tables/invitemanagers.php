<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableInvitemanagers extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $sender = null; 	
	var $dmanager = null; 	
	var $reciever = null; 
	var $senttime = null;	
	var $licence = null;
	function __construct(& $db) {
	
		parent::__construct('#__cam_invitemanagers', 'id', $db);
	}
	
	
}
?>
