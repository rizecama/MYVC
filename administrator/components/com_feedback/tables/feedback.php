<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class TableFeedback extends JTable {
    var $id = null;
	var $submitter_name = null;
	var $submitter_email = null;
	var $submitter_id = null;
	var $submitted_ts = null;
	var $url = null;
	var $browser = null;
	var $browser_version = null;
	var $feedback = null;
	var $operating_system = null;
	var $screen_resolution = null;
	var $user_agent = null;
	var $script_name = null;
	var $referer = null;
	var $time_split = null;
	var $user_ip = null;
	
    function TableFeedback( &$db ) {
        parent::__construct('#__feedback', 'id', $db);
    }
}