<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableSavecause  extends JTable
{
    var $id = null;
	var $rfpid = null;
	var $vendorid = null;
	var $big = null;
	var $small = null;
	var $busy = null;
	var $indus = null;
	var $loc = null;
	var $other_reason = null;
	var $created_date = null;

	function __construct(& $db) {
		parent::__construct('#__cam_rfpdeclined_cause', 'id', $db);
	}
}
?>
