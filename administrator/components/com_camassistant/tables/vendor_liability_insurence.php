<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendor_liability_insurence   extends JTable
{
    var $id = null;
	var $vendor_id = null; 
	var $GLI_name = null; 	
	var $GLI_policy = null;
	var $GLI_start_date = null;
	var $GLI_end_date = null;
	var $GLI_agent_first_name = null;
	var $GLI_agent_last_name = null;
	var $GLI_phone_number = null;
	var $GLI_policy_aggregate = null;
	var $GLI_policy_occurence = null;
	var $GLI_upld_cert = null;
	var $GLI_date_verified = null;
	var $GLI_status = null;
	var $GLI_folder_id = null;
	var $saveddate = null;
	var $GLI_med = null;	
	var $GLI_injury = null;	
	var $GLI_products = null;		
	var $GLI_applies = null;	
	var $GLI_damage = null;	
	var $GLI_primary = null;	
	var $GLI_waiver = null;	
	var $GLI_occur = null;	
	var $GLI_certholder = null;	
	var $GLI_additional = null;	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendor_liability_insurence', 'id', $db);
	}
}
?>
