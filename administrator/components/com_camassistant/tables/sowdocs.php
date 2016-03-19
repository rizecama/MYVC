<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableSowdocs extends JTable
{
	/**
	 * Primary Key
	 * @var int
	 */
    var $doc_id = null;
	var $rfp_id = null; 
    var $linetaskname = null; 
	var $rfpreference = null; 
	var $taskuploads = null; 
	var $doc_path = null; 	
    var $is_req_docvendors = null;	
	function __construct(& $db) {
		parent::__construct('#__cam_rfpsow_docs', 'doc_id', $db);
	}
	
	
}
?>
