<?php
/**
 * @version		1.0.0 promocode $
 * @package		promocode
 * @copyright	Copyright © 2011 - All rights reserved.
 * @license		GNU/GPL
 * @author		anandbabu
 * @author mail	anandbabu@projectsinfo.net
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');

class invitecode_detailsController extends JController
{
	// Your custom code here
    function __construct( $default = array())
	{
		//require_once( JPATH_COMPONENT.DS.'helper.php' );
		parent::__construct( $default );
	}
	
	// function save
	function save()
	{ 
		$db=JFactory::getDBO();
		global $mainframe;
	    JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post	= JRequest::get('post');
		//echo '<pre>'; print_r($_POST);exit;
		$data['invitecode'] = JRequest::getVar( 'invitecode', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$data['amount'] =	'';
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$data['id'] = $cid[0];
		
		if($data['id'])
		{ 
		    $query ="SELECT id,invitecode FROM #__cam_invitecode WHERE invitecode  = '".$data['invitecode']."'";
			$db->setQuery($query);
			$res = $db->loadObjectList();
			if(count($res) > 0)
			{if($res[0]->id == $data['id'])	$cnt = 0; else $cnt = count($res); } else $cnt = count($res);
		}
		else
		{
			$query ="SELECT count(*) FROM #__cam_invitecode WHERE invitecode = '".$data['invitecode']."'";
			$db->setQuery($query);
			$cnt = $db->loadResult();
		}  
		//echo $cnt; exit;
		if($cnt>0)
		{
		 $msg = JText::_('This Invitecode already existed');
		}
		else
		{
			 $model = $this->getModel('invitecode_details');
			if ($model->store($data)) {
				$msg = JText::_( 'Invitecode Saved' );
			} else {
				$msg = JText::_( 'Error Saving Invitecode Code' );
			}
        } 
		
		
       
      // echo "<pre>"; print_r($_REQUEST); 
		//$model->checkin();
		//echo $_SERVER['HTTP_HOST']; exit;
		$this->setRedirect( 'index.php?option=com_camassistant&controller=invitecode',$msg );
	}
    
   
	// function edit
	function edit()
	{
		
		//require_once( JPATH_COMPONENT.DS.'helper.php' );
		JRequest::setVar( 'view', 'invitecode_details' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'hidemainmenu', 1);
        $model = $this->getModel('invitecode_details');
		parent::display();
	}
	// function remove
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('invitecode_details');
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=invitecode','Invite Code Deleted Successfully' );
	}
	
	// function cancel
	function cancel()
	{
	
		// Checkin the detail
	$model = $this->getModel('invitecode_details');
	$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=invitecode' );
	}	
}
?>