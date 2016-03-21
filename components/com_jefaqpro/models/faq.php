<?php
/**
 * jeFAQ Pro package
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

	// save
	function store()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$row 	= & $this->getTable();

		// Bind the form fields
		$post	= JRequest::get('post');

		if (!$row->bind($post)) {
			return 0;
		}
		// Make sure data is valid
		if (!$row->check()) {
			return 0;
		}

		// if new item order last in appropriate group
		if (!$row->id)
		{
			$where = 'catid = '.(int) $row->catid;
			$row->ordering = $row->getNextOrder( $where );
		}

		// Store it
		if (!$row->store())	{
			return 0;
		}
		return $row->id;
	}

	function getCategory()
	{
		$db 	   = & JFactory::getDBO();

		$cat[] 	   = JHTML::_('select.option', '', JText::_('SELECT_CATEGORY') );
		$cat[] 	   = JHTML::_('select.option', '0', JText::_('JE_UNCATEGORISED') );

		$query 	   = "SELECT * FROM #__je_faq_category where state = '1'";
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows      = $db->loadObjectList();

		if ( count($rows) >0 ) {
			foreach ( $rows as $row ) {
				$cat[] = JHTML::_('select.option', $row->id, $row->category );
			}
		}

		return $cat;
	}

	function getGlobalsettings()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT * FROM #__je_faq_settings WHERE id= 1';

		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows  = $db->loadObject();

		return $rows;
	}

	function getCategorydet()
	{

		$db 		   = & JFactory::getDBO();
		$catid	   	   = & JRequest::getInt('catid');

		if ( $catid === 0 ){
			$rows  	   = & JText::_( 'JE_UNCATEGORISED' );
		} else {
			$query 	   = "SELECT category FROM #__je_faq_category where state = '1' AND id = '$catid' ";
			$db->setQuery( $query );

			if (!$db->query())	{
				echo $db->getErrorMsg();
			}

			$rows      = $db->loadResult();
		}

		return $rows;
	}

	// Functions for email notifications.
	function sendAdminmail( $post )
	{

		$app 		= & JFactory::getApplication();
		$settings	= $this->getGlobalsettings();

		if ( $settings->emailid == 'admin@email.com' || $settings->emailid == '' ) {
			$to		= $app->getCfg('mailfrom');  //outputs mailfrom
		} else {
			$to		= $settings->emailid;
		}

		$from		= $post['posted_email'];
		$name		= $post['posted_by'];
		$site		= $app->getCfg('sitename'); //outputs sitename

		$question	= $post['questions'];
		$category   = $this->getCategorydet();

		$sender 	= array( $from, $name );
		$mailer 	= & JFactory::getMailer();
		$mailer->setSender( $sender );

		$mailer->addRecipient( $to );

		$subject 	= sprintf ( JText::_( 'SEND_MSG_ADMIN_SUB' ), $name );
		$subject 	= html_entity_decode($subject, ENT_QUOTES);

		$message 	= sprintf ( JText::_( 'SEND_MSG_ADMIN' ), $name, $category, $question, $name );
		$message 	= html_entity_decode($message, ENT_QUOTES);

		$mailer->setSubject( $subject );
		$mailer->setBody( $message );

		$mailer->IsHTML(true);

		if ($mailer->Send() == true) {
			return true;
		} else {
			return false;
		}

	}

	function getResponses()
	{
		global $mainframe;

		$db 							= & JFactory::getDBO();
		$user 							= & JFactory::getUser();
		$settings						= $this->getGlobalsettings();
		$remote_ip 						= $_SERVER['REMOTE_ADDR'];

		$i							= JRequest::getVar( 'ival' );

		$post['faqid']				= JRequest::getVar( 'faqid' );
		$post['catid']				= JRequest::getVar( 'catid' );
		$post['remote_ip']			= $remote_ip;
		$res						= JRequest::getVar( 'response' );
		$msg= '';
		$post['userid']				= $user->get('id');

		if ( $res == '1' ) {
			$post['response_yes']	= 1;
		}

		if ( $res == '2' ) {
			$post['response_no']	= 1;
		}

		$row =& $this->getTable( 'responses' );
		// Bind the form fields

		if (!$row->bind($post)) {
			return 0;
		}

		// Make sure data is valid
		if (!$row->check())	{
			return 0;
		}

		$response					= $this->getResponsedet( $post['faqid'], $post['catid'] );
		$count						= $this->getResponsecount( $post['faqid'], $post['catid'] );

		if ( isset($response) ) {

			if ( $user->get('id') > 0 && $settings->allow_reg == 1 ) {
				if ( $user->get('id') == $response->userid && $post['faqid'] == $response->faqid && ($count->response_yes > 0 || $count->response_no > 0) )	{
					$msg = JText::_('JE_FAQ_ALREADY');
				}
			} else if ( $remote_ip == $response->remote_ip && $post['faqid'] == $response->faqid && ($count->response_yes > 0 || $count->response_no > 0) )	{
					$msg = JText::_('JE_FAQ_ALREADY');
			}

		} else {
			if (!$row->store())	{
				return 0;
			}
		}

		$count						= $this->getResponsecount( $post['faqid'], $post['catid'] );

		if ( $res == '1' ) {
			echo $count->response_yes."|".$msg;
		}

		if ( $res == '2' ) {
			echo $count->response_no."|".$msg;
		}

		exit;
	}

	function getResponsedet( $id, $catid )
	{
		$userid		='';
		$user 		= & JFactory::getUser();

		if ( $user->get('id') > 0 ) {
			$userid		=  ' AND userid='.$user->get('id');
		}
		
		$query 	= 'SELECT userid, faqid, remote_ip FROM #__je_faq_responses where faqid="'.$id.'" AND catid="'.$catid.'"'.$userid;

		$db    	= & JFactory::getDBO();
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$res  	= $db->loadObject();

		return $res;
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
	
	function getHits()
	{
			$db 			= & JFactory::getDBO();
			$faqid		    = & JRequest::getVar('faqid');
			$hits 			= $this->getHitsdet($faqid);
			$query 			= 'UPDATE '.$db->nameQuote('#__je_faq').'
					 		   SET '.$db->nameQuote('hits').' = '.$hits.' WHERE id = '.$faqid;
			$db->setQuery( $query );
			$db->query();

			echo JText::_('JE_FAQ_HITS').'&nbsp;'.$hits;

			exit;

	}

	function getHitsdet($faqid)
	{
		$query 	= 'SELECT hits FROM #__je_faq where id='.$faqid;

		$db    	= & JFactory::getDBO();
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$hits  	= $db->loadResult();

		return $hits + 1;
	}
	
	function getAllfaqs()
	{
		$all_id		   = '';
		$db 		   = & JFactory::getDBO();
		$rows->id[]	   = 0;
		$query 	   = "SELECT id FROM #__je_faq_category where state = '1' ";
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows      = $db->loadObjectList();

		$id[] = 0;
		for( $i=0; $i<count($rows); $i++ ) {
			$row = &$rows[$i];
			$id[] = $row->id;
		}

		for( $i=0; $i<count($id); $i++ ) {

			if ( $i == count($id) - 1 ) {
				$val = '';
			} else {
				$val = ',';
			}

			$all_id .= $id[$i].$val;

		}

		return $all_id;
	}
}
?>