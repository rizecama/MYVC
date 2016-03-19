<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablepropertyownerdetails extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $user_id = null;
	var $steetaddress = null;
	var $city = null;
	var $state = null;
	var $zipcode = null;
	var $altemail = null;
	var $altphone_ext = null;
	var $fax = null;
	  
	  
	
	function __construct(& $db) {
		parent::__construct('#__cam_propertyowner_info', 'id', $db);
	}
	
	
}
?>
