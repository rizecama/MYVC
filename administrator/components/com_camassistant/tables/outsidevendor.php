<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tableoutsidevendor extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */


	var $id = null; 	
	var $rfpid = null; 		
	var $awarded_vendor = null;
	var $criteria = null;
    var $addendum = null;
    var $amount = null;
	 var $award_date = null;
	  var $cust_id = null;
	  var $company_name = null;
	  var $contact_name = null;
	  var $phone = null;
	  var $email = null;
	  var $awardedid = null;
				
	function __construct(& $_db) {
		parent::__construct('#__cam_outsidevendor', 'id', $_db);
	}
	
	
}
?>
