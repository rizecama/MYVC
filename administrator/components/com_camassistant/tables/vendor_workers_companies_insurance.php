<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_workers_companies_insurance  extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $WCI_name = null; 	
	var $WCI_policy = null;
	var $WCI_start_date = null;
	var $WCI_end_date = null;
	var $WCI_agent_first_name = null;
	var $WCI_agent_last_name = null;
	var $WCI_phone_number = null;
	var $WCI_upld_cert = null;
	var $WCI_date_verified = null;
	var $WCI_status = null;
	var $WCI_folder_id = null;
	var $excemption = null;
	var $saveddate = null;
	var $WCI_disease = null;	
	var $WCI_disease_policy = null;	
	var $WCI_waiver = null;	
	var $WCI_each_accident = null;		
	var $WCI_cert = null;	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_workers_companies_insurance', 'id', $db);
	}
}
?>
