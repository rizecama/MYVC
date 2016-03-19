<?php
/**
 * @version		$Id: banner.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package		Joomla
 * @subpackage	Banners
 */
class Tableconfiguration extends JTable
{
	var $id = null; 	
	var $closedrfp_limit = null; 	
	var $unsubrfp_limit = null;
    var $subrfp_limit = null;
	var $awardrfp_limit = null;
	var $unawardrfp_limit = null;
	var $draftproposals_limit = null;
	var $submittedproposals_limit = null;
	var $reviewproposals_limit = null;
	var $awardedproposals_limit = null;
	var $unawarderproposals_limit = null;
	var $rfps_by_property_limit = null;
	var $vendor_logo_height = null;
	var $vendor_logo_width = null;
	var $vendor_policy_limits = null;
	var $vendor_aggregate = null;
	var $payment_type = null;
	var $pay_name = null;
	var $pay_currency = null;
	var $pay_busness_email = null;
	var $auth_tx_key = null;
	var $auth_login_id = null;
	var $av_page = null;
	var $calender_on_off = null;
	var $survey_days = null;
   

	function __construct( & $db )
	{
		parent::__construct('#__cam_configuration', 'id', $db);



	}
}
?>
