<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableCamadminemailsinfo extends JTable
{

	/**
	 * Primary Key
	 * @var int
	 */

    var $id = null;
	var $camfirmadmin_id = null; 	
	var $company_id = null; 	
	var $preferedto = null;
    var $preferedcc = null;	
    var $preferedbcc = null;	
    var $preferedsubject = null;	
	var $invite_prefered = null;	
	var $inhouseto = null;	
    var $inhousecc = null;	
	var $inhousebcc = null;	
	var $inhousesubject = null;	
	var $invite_vinhouse = null;	
	function __construct(& $db) {
		parent::__construct('#__cam_camfirmadmin_vendormails', 'id', $db);
	}
	
	
}
?>
