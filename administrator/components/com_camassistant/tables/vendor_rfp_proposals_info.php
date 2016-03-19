<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_rfp_proposals_info extends JTable
{
    var $id = null;
	var $rfpno = null; 
	var $warranty_filepath = null;
	var $warranty_file_text = null;
	var $warranty_file_area = null;
	var $proposalno = null; 	
	var $proposedvendorid = null;
	var $proposeddate = null;
	var $proposaltype = null;
	var $price_other_items = null;
	var $proposal_total_price = null;
	var $commission = null;
	var $Alt_bid = null;
	var $contact_name = null;
	var $publish = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_proposals', 'id', $db);
	}
}
?>
