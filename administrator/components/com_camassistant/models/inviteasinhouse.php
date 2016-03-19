<?php
/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class camassistantModelInviteasinhouse extends Jmodel
{
	function __construct(){
		parent::__construct();
	}

function store($data){
        // get the table
//echo "<pre>"; print_r($data); exit;
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('inviteasinhouse');
$row = JTable::getInstance('inviteasinhouse','Table');

        // Bind the form fields to the invite table
        if (!$row->bind($data)) {
		
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Make sure the hello record is valid
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Store the web link table to the database
        if (!$row->store()) {

                $this->setError( $row->getErrorMsg() );
                return false;
        }
 
        return true;         

}

/* 03/02/2011 to get the invite as inhouse mail message */
function getInhousevendors()
{
$db = JFactory::getDBO();
if($_REQUEST['id']=="inhouse")
$query1 ="SELECT introtext  FROM #__content where id='151' ";
else
$query1 ="SELECT introtext  FROM #__content where id='152' ";

$db->setQuery($query1);
$message = $db->loadResult();

$query2 = ' SELECT comp_name as name FROM #__cam_camfirminfo WHERE cust_id='.$_REQUEST['userid'];
$db->setQuery($query2);
$name = $db->loadResult();

$msg = str_replace("{Customer Name}", $_REQUEST['username'], $message);
$msg = str_replace("{CAM Firm}", $name, $msg);

	return $msg;
}

}
?>