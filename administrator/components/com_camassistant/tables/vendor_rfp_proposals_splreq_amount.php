<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_rfp_proposals_splreq_amount extends JTable
{
    var $id = null;
	var $rfp_id = null; 
	var $req_id = null; 	
	var $vendor_id = null;
	var $amount = null;
	var $status = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_rfpsow_splreq_price', 'id', $db);
	}
}
?>
