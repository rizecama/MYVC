<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableDemo  extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $firstname = null; 	
	var $lastname = null; 	
	var $companyname  = null;
	var $phonenumber  = null;
	var $email = null;
    var $rep = null;	
    var $pickdate = null;
	var $spec = null;	
    var $demodate = null;
		
	function __construct(& $db) {
//	exit;
		parent::__construct('#__cam_demopage', 'id', $db);
	}
	
	
}
?>
