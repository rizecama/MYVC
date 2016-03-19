<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tableunawarding extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */


	var $id = null; 	
	var $proposal_id = null; 
	var $rfpno = null; 		
	var $proposedvendorid = null;
    var $not_awarded = null;	
    var $other = null;	
	var $additional_details = null;	
    var $other_feedback = null;	
	
				
	function __construct(& $_db) {
		parent::__construct('#__cam_unawardlist', 'id', $_db);
	}
	
	
}
?>
