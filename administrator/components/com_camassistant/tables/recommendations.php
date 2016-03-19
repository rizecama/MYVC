<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablerecommendations extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */


	var $id = null; 	
	var $sender = null; 	
	var $managerid = null;
    var $vendorid = null;	
    var $accept = null;	
	var $display = null;
	var $view = null;	
	var $senddate = null;	
				
	function __construct(& $db) {
		parent::__construct('#__cam_manager_recommends', 'id', $db);
	}
	
	
}
?>
