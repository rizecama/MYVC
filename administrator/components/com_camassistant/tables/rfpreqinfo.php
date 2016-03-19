<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableRfpreqinfo extends JTable
{
	/**
	 * Primary Key
	 * @var int
	 */
	 var $splreq_id = null;
    var $rfp_id = null;
	var $req_parentid = null; 	
	var $req_subparentid = null;
	var $req_id = null; 	
	var $price = null; 	
    //var $price = null;	
	function __construct(& $db) {
		parent::__construct('#__cam_rfpreq_info', 'splreq_id', $db);
	}
	
	
}
?>
