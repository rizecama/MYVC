<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class vendorcompliancesController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	// function cancel
	function cancel()
	{
		// Checkin the detail
		//$model = $this->getModel('category_detail');
		//$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}	
	function display() {
		parent::display();
	}
	
	//function to go for Camassistant Control Panel(Prasad 12 Jan 11)
	function lists()
	{
		// Panel 
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}

}	
?>
