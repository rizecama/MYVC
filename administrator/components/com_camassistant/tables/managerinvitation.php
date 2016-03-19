<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablemanagerinvitation extends JTable
{
    var $id = null;
	var $rfpid = null; 	
	var $companyname = null; 	
	var $contactname = null;
	var $phone = null;
    var $email = null;	
    var $notes = null;	
	var $date = null;	
	
	
	function __construct(& $db) {
		parent::__construct('#__cam_newmanagerinvitations', 'id', $db);
	}
	
	
}
?>
