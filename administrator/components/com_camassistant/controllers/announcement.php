<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class announcementController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}
	//function to go for Camassistant Control Panel(Prasad 12 Jan 11)
	function lists()
	{
		// Panel 
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}

	function display() {

		parent::display();
	}
	
	 function unpublish()
	{
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= 0;

		
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__cam_announcement'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning(500, $db->getError());
		}
				$this->setRedirect( 'index.php?option=com_camassistant&controller=announcement','Announcement Unpublished Successfully');

	}
	
	function publish()
	{
		// Check for request forgeries


		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__cam_announcement'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
	
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setRedirect( 'index.php?option=com_camassistant&controller=announcement','Announcement Published Successfully');

	}
	
	
}	
?>
