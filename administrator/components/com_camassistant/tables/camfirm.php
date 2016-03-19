<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablecamfirm extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */


	var $id = null; 	
	var $cust_id = null; 
	var $camfirm_license_no = null;
    var $comp_name = null;	
    var $tax_id = null;	
	
				
	function __construct(& $db) {
		parent::__construct('#__cam_camfirminfo', 'id', $db);
	}
	
	
}
?>
