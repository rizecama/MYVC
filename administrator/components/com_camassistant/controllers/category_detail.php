<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class category_detailController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'category_detail' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();

		$model = $this->getModel('category_detail');
		$model->checkout();
	}
      
	// function save

	function save()
	{
	
		$task = JRequest::getCmd( 'task' ); 
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = $cid[0];
		$model = $this->getModel('category_detail');
        //validation to restirct duplicate category names
		$db		= &JFactory::getDBO();
		if($post['id'])
		{ 
		    $query ="SELECT id,industry_name FROM #__cam_industries WHERE industry_name = '".$post['industry_name']."'";
			$db->setQuery($query);
			$res = $db->loadObjectList();
			if(count($res) > 0)
			{if($res[0]->id == $post['id'])	$cnt = 0; else $cnt = count($res); } else $cnt = count($res);
		}
		else
		{
			$query ="SELECT count(*) FROM #__cam_industries WHERE industry_name = '".$post['industry_name']."'";
			$db->setQuery($query);
			$cnt = $db->loadResult();
		}  
		//echo $cnt; exit;
		if($cnt>0)
		{
		 $msg = JText::_('This industry already existed');
		}
		else
		{
			if ($model->store($post)) {
				$msg = JText::_( 'Industry Saved' );
			} else {
				$msg = JText::_( 'Error Saving Industry' );
			}
        } 
		$model->checkin();
		$db		=& JFactory::getDBO();
		$query = "SELECT max(id) FROM #__cam_industries"; 
		$db->setQuery( $query );
		$catid = $db->loadResult();
		switch ($task)
		{
			case 'apply':
			if($post['id']) $cat_id = $post['id']; else  $cat_id = $catid;
				$link = 'index.php?option=com_camassistant&controller=category_detail&task=edit&cid[]='. $cat_id ;
				break;
			case 'save':
			default:
				$link = $link = 'index.php?option=com_camassistant&controller=category';
				break;
		}
		$this->setRedirect( $link,$msg );
		//$this->setRedirect( $link, JText::_( 'Item Saved' ) );
	}

	// function remove
	function remove()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
       /* $db = JFactory::getDBO();
		$query ="SELECT catname FROM #__camassistant_category WHERE id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
		$catname = $db->loadResultArray ();
		$catnames = implode( ',', $catname );*/
		/***************Case 3. Retailers assigned as primary categories*********************/
		/*$query ="SELECT count(*) FROM #__camassistant_retailer WHERE catid IN (".$cids.")"; 
		$db->setQuery($query);
		$db->query();
		$res = $db->loadResult();   */
		
		/***************end of code Case 3. Retailers assigned as primary categories************/
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('category_detail');
/*		if($res <= 0)
		{
*/			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Industry Deleted Successfully';
		/*}*/
		/*else	
        $msg = $catnames.' cannot  be removed as they contain Retailers as a primary reference.';
		if($msg == 'Industry Deleted Successfully')
		header("Location: index.php?option=com_camassistant&controller=category&msg=deleted");
		else*/
		$this->setRedirect( 'index.php?option=com_camassistant&controller=category',$msg);
	}
	
	// function cancel
	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('category_detail');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=category' );
	}	
	
}

?>