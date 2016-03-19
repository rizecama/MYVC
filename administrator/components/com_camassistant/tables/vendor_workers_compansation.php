<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_workers_compansation  extends JTable
{
    	var $id = null;
	var $vendor_id = null;
	var $wc_end_date = null;
	var $wc_date_verified = null;
	var $wc_upld_cert = null;
	var $wc_status= null;
	var $wc_folder_id=null;
	var $saveddate = null;



	function __construct(& $db) {
		parent::__construct('#__cam_vendor_workers_compansation', 'id', $db);
	}
}
?>
