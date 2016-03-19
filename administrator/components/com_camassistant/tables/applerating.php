<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableApplerating  extends JTable
{
    var $id = null;
	var $rfpid = null;
	var $comment = null;
	var $apples = null;
	var $managerid = null;
	var $rate_date = null;

	function __construct(& $db) {
		parent::__construct('#__cam_rfp_ratings', 'id', $db);
	}
}
?>
