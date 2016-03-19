<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class announcement_detailController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'announcement_detail' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();

		$model = $this->getModel('announcement_detail');
		$model->checkout();
	}
      
	// function save

	function save()
	{
		//print_r($_REQUEST); exit;
		$task = JRequest::getVar("task",'');
		$post = JRequest::get('post');
		$data['user_type']	= $post['usertype'];
		$data['industry_name']	= $post['industry_name'];
		$data['state_name']	= $post['state_name'];
		$data['announcement']	= JRequest::getVar( 'announcement', '', 'post', 'string', JREQUEST_ALLOWHTML );
		$data['published']	= $post['published'];
		$data['id']	= $post['cid'][0];
		$model = $this->getModel('announcement_detail');
		
		if($model->store($data))
		{
		$msg = 'Announcement Updated Successfully';
		$url = 'index.php?option=com_camassistant&controller=announcement';
		$this->setRedirect( $url, $msg );
		}
		else {
		$msg = 'Announcement Updated';
		$url = 'index.php?option=com_camassistant&controller=announcement';
		$this->setRedirect( $url, $msg );
		}

		
		
	}
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
       
		/***************end of code Case 3. Retailers assigned as primary categories************/
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('announcement_detail');
/*		if($res <= 0)
		{
*/			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Announcement Deleted Successfully';
		/*}*/
		/*else	
        $msg = $catnames.' cannot  be removed as they contain Retailers as a primary reference.';
		if($msg == 'Industry Deleted Successfully')
		header("Location: index.php?option=com_camassistant&controller=category&msg=deleted");
		else*/
		$this->setRedirect( 'index.php?option=com_camassistant&controller=announcement',$msg);
	}
	
	// function cancel

	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('announcement_detail');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=announcement' );
	}	
	
}

?>