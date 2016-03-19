<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablerfp_task_docs_tasks_price extends JTable
{
    var $id = null;
	var $rfp_id = null; 
	var $vendor_id = null;
	var $item_type = null;
	var $item_id = null;
	var $item_price = null;
	var $status = null;
	var $Alt_bid = null;
	
	function __construct(& $db) {
		parent::__construct('#__cam_rfpsow_docs_lineitems_prices', 'id', $db);
	}
}
?>
