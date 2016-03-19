<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableInviteasinhouse extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $vid = null;
	var $vendortype = null; 	
	var $fei = null; 
	var $v_id = null;	
	var $inhousevendors = null;
	var $licenseno = null;
	var $taxid = null;
	var $userid = null;
    var $inhouse = null;	
    var $inhousetext = null;	
    var $subject = null;	
	var $status = null;	
	 var $invitedate = null;	
	 var $exclude = null;				
	function __construct(& $db) {
		parent::__construct('#__vendor_inviteinfo', 'vid', $db);
	}
	
	
}
?>
