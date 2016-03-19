<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableRfp extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $property_id = null;
	var $rfp_indus_data = null;
	var $work_perform =null;
	var $work_perform_other =null;
	var $site_visit =null;
	var $bidders_info =null;
	var $industry_id = null;
	var $industry_id2 = null;	
	var $projectName = null;	
    var $projectInfo = null;	
    var $startDate = null;	
	var $endDate = null;	
	var $createdDate = null;	
	var $frequency = null;
	var $proposalDueDate = null;
	var $proposalDueTime = null;
	var $maxProposals = null;
	var $rfp_type = null;
	var $defsow_who = null;
	var $choose_tasks = null;
	var $cust_id = null;
	var $awardeddate = null;
	var $unawardeddate 	 = null;
	var $terms 	 = null;
	var $update_rfp 	 = null;
	var $publish = null;	
	var $approve_date = null;	
	var $secondstime = null;	
	var $rfp_pdf  = null;		
	var $update_date  = null;	
	var $followupdate  = null;	
	var $urgency  = null;
	var $rfp_adminstatus  = null;	
	var $assigned  = null;	
	var $bidding  = null;
	var $closedfrom  = null;
	var $apple  = null;
	var $apple_publish  = null;	
	var $rfpfor  = null;
	var $biddingcloseddate  = null;	
	var $jobtype  = null;	
	var $jobnotes  = null;
	var $create_rfptype   = null;

	function __construct(& $db) {
		parent::__construct('#__cam_rfpinfo', 'id', $db);
	}
	
	
}
?>
