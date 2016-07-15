<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2010 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Tablevendorinvitationmail  extends JTable
{
    var $id = null;
	var $managerid = null; 	
	var $email_text = null; 
	var $email_new = null; 
	var $subject_new = null; 
	var $status = null; 	
	
	function __construct(& $db) {
		parent::__construct('#__cam_vendorinviation_mail', 'id', $db);
	}
	
	
}
?>
