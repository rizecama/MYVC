<?php
/**
 * jeFAQ package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class jefaqModelFaq extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		$row =& $this->getTable();
		$row->load( $this->_id );
		return $row;
	}

	// save
	function store()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$row 		= & $this->getTable();

		// Bind the form fields
		$post		= JRequest::get('post', JREQUEST_ALLOWRAW);
		$settings 	= $this->getGlobalsettings();
		
		$form_catid		= & JRequest::getInt('catid');
		$row_catid		= & JRequest::getInt('cat_id');

		if (!$row->bind($post)) {
			return 0;
		}
		// Make sure data is valid
		if (!$row->check()) {
			return 0;
		}

		// if new item order last in appropriate group
		if ( $form_catid != $row_catid) {
			$where 	= 'catid = '.(int) $form_catid;
			$row->ordering = $row->getNextOrder( $where );
		} else {
			if (!$row->id) {
				$where 	= 'catid = '.(int) $row->catid;
				$row->ordering = $row->getNextOrder( $where );
			}
		}

		if ( $settings->user_email == '1' ) {
			if ( $row->gid < 25 && $row->email_status == '0' ) {
				$row->email_status = '1';
				$this->sendMail( $row );
			}
		}

		// Store it
		if (!$row->store())	{
			return 0;
		}

		return $row->id;
	}

	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$result     = ($task == 'publish')?1:2;
		$neg_result     = ($task == 'publish')?-1:-2;
		$n			= count( $cid );

		if (empty( $cid )) {
			return 0;
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__je_faq'
				. ' SET state = ' . (int) $publish
				. ' WHERE id IN ( '. $cids.'  )'
				;

		$db->setQuery( $query );

		if (!$db->query()) {
			return $neg_result;
		} else {
			return $result;
		}
	}

	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$cids  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row   = & $this->getTable();
		
		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					return false;
				}
			}
		}
		return true;
	}

	function getCategory()
	{
		$db 	   = & JFactory::getDBO();

		$query 	   = "SELECT * FROM #__je_faq_category where state = '1' ";
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows      = $db->loadObjectList();

		$cat[] 	   = JHTML::_('select.option', '', JText::_('SELECT_CATEGORY') );
		$cat[] 	   = JHTML::_('select.option', '0', 'Uncategorised' );
		foreach ( $rows as $row ) {
			$cat[] = JHTML::_('select.option', $row->id, $row->category );
		}

		return $cat;
	}

	// move up and down direction..
	function moveOrder($direction)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db		= & JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (isset( $cid[0] ))
		{
			$row	= & $this->getTable();
			$row->load( (int) $cid[0] );

			$row->move($direction, 'catid = ' . (int) $row->catid );

			$cache = & JFactory::getCache('com_jefaqpro');
			$cache->clean();
		}

		return true;
	}
	// end up and down direction..

	// function for save order
	function saveOrder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db			= & JFactory::getDBO();
		$row		= & $this->getTable();

		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array(), 'post', 'array' );
		$total		= count( $cid );
		$conditions	= array();

		if (empty( $cid )) {
			return JError::raiseWarning(2, 500, JText::_( 'No items selected' ) );
		}

		// update ordering values
		for ($i = 0; $i < $total; $i++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return JError::raiseError(2, 500, $db->getErrorMsg() );
				}

				// remember to reorder this category
				$condition = 'catid = '.(int) $row->catid;
				$found = false;
				foreach ($conditions as $cond) {
					if ($cond[1] == $condition)
					{
						$found = true;
						break;
					}
				}
				if (!$found) {
					$conditions[] = array ( $row->bid, $condition );
				}
			}
		}

		// execute reorder for each category
		foreach ($conditions as $cond)
		{
			$row->load( $cond[0] );
			$row->reorder( $cond[1] );
		}

		// Clear the component's cache
		$cache =& JFactory::getCache('com_jefaqpro');
		$cache->clean();

		return true;
	}
	// save order end

	// Build category filter.
	function filterCategory($query, $active = NULL)
	{
		// Initialize variables
		$db	= & JFactory::getDBO();

		$categories[] = JHTML::_('select.option', '-1', JText::_('SELECT_CATEGORY'));
		$categories[] = JHTML::_('select.option', '0', JText::_('JE_UNCATEGORISED'));
		$db->setQuery($query);
		$categories = array_merge($categories, $db->loadObjectList());

		$category = JHTML::_('select.genericlist',  $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $active);

		return $category;
	}

	// Function for send mail
	function sendMail( $row ) {
		$app 		= & JFactory::getApplication();
		$to			= $row->posted_email ;
		$from		= $app->getCfg('mailfrom'); //outputs mailfrom
		$name		= $row->posted_by;
		$site		= $app->getCfg('sitename'); //outputs sitename

		$question	= $row->questions;
		$answers	= $row->answers;
		$category_name   = $this->getCategorydet( $row->catid );

		$sender 	= array( $from, $site );
		$mailer 	= & JFactory::getMailer();
		$mailer->setSender( $sender );

		$mailer->addRecipient( $to );

		// Subject
		$subject 		= sprintf ( JText::_( 'SEND_MSG_ADMIN_SUB' ), $site );
		$subject 		= html_entity_decode($subject, ENT_QUOTES);

		// Message
		$message 	   	= sprintf ( JText::_( 'SEND_MSG_ADMIN' ),$name, $category_name, $question, $answers, $name );
		$message 	   	= html_entity_decode($message, ENT_QUOTES);

		$img_tag_count 	= substr_count($message, '<img');
		$regex 			= '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';

		if($img_tag_count > 0) {
			preg_match_all ( $regex, $message, $matches1,PREG_SET_ORDER );

			foreach ($matches1 as $val) {
				$imageurl[] = $val[2];
			}

			$matches = array_unique($imageurl);

			foreach ($matches as $val) {
				$image 					= '';
				$img_path_check_http 	= '';
				$img_path_check_www 	= '';
				$image_new				= '';
				$image 					= trim ( $val );
				$img_path_check_http 	= substr_count($image, 'http');
				$img_path_check_www 	= substr_count($image, 'www');
				if($img_path_check_http == '0' && $img_path_check_www == '0') {
					$image_new 			= JURI::root().$image;
					$message 			= str_replace($image, $image_new, $message);
				}
			}
		}

		$mailer->setSubject( $subject );
		$mailer->setBody( $message );

		$mailer->IsHTML(true);

		if ($mailer->Send() == true) {
			return true;
		} else {
			return false;
		}
	}

	function getCategorydet( $catid )
	{

		$db 		   = & JFactory::getDBO();

		if ( $catid == 0 ){
			$category_name 	   = & JText::_( 'JE_UNCATEGORISED' );
		} else {
			$query 	   = "SELECT category FROM #__je_faq_category where state = '1' AND id = '$catid' ";
			$db->setQuery( $query );

			if (!$db->query())	{
				echo $db->getErrorMsg();
			}

			$category_name      = $db->loadResult();
		}

		return $category_name;
	}

	function getGlobalsettings()
	{
		$db 		= & JFactory::getDBO();

		$query 		= 'SELECT * FROM #__je_faq_settings';
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$settings  	= $db->loadObject();

		return $settings;
	}

	function getResponsecount( $id, $catid )
	{
		$db    	= & JFactory::getDBO();

		$query 	= 'SELECT sum(response_no) as response_no , sum(response_yes) as response_yes FROM #__je_faq_responses where faqid="'.$id.'" AND catid="'.$catid.'"';

		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$count  	= $db->loadObject();

		return $count;
	}

	
	function faqHelp()
	{
		?>
			<script>
				window.open('http://www.jextn.com/support/','_blank');
			</script>
		<?php
	}
}
?>