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
jimport('joomla.application.component.controller');

class jefaqControllerFaq extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct( $config );
	}

	function display()
	{
		JRequest::setVar( 'view', 'faq');
		parent::display();
	}

	function save()
	{
		$enablecaptcha = false;
		$model    	   = $this->getModel('faq');
		$settings	   = $model->getGlobalsettings();
		
		// Get session
		$session 	   = & JFactory::getSession();
		$catid	 	   = &JRequest::getInt('catid');
		$post		   = &JRequest::get('post');

		if ( $post['view'] != '' ) {
			if ( $catid >= 0 ) {
				$con = '&view=category';
			} else {
				$con = '&view='.$post['view'];
			}
		}

		if ( $catid >= 0  ) {
			$cid	= '&catid='.$catid;
			$lay 	= '&layout=categorylist&catid='.$catid;
		}

		if ($settings->show_captcha == '1' ) {
			$enablecaptcha = true;
		}

		// check captch variables..
		if (AutartiCaptchaHelper::checkCaptcha( $enablecaptcha )) {

			if ( $model->store() ) {

				if ( $settings->admin_email == '1' ) {
					
					// Clear sessions.
					$session->clear('formvalues');
					if ( $model->sendAdminmail( $post ) ) {
						$msg  = JText::_( 'JE_ITEM_SAVE_MAIL' );
						$link = JRoute::_(JURI::base().'index.php?option=com_jefaqpro'.$con.$lay.'&Itemid='.$post['Itemid']) ;
					} else {
						$msg  = JText::_( 'JE_ITEM_SAVE' );
						$link = JRoute::_(JURI::base().'index.php?option=com_jefaqpro'.$con.$lay.'&Itemid='.$post['Itemid']) ;
					}
				} else {
					$msg  = JText::_( 'JE_ITEM_SAVE' );
					$link = JRoute::_(JURI::base().'index.php?option=com_jefaqpro'.$con.$lay.'&Itemid='.$post['Itemid']) ;
				}

			} else {
				JError::raiseWarning('SOME_ERROR',JText::_('JE_ITEM_SAVE_FAILED'));
				$link 	  = JRoute::_(JURI::base().'index.php?option=com_jefaqpro&view=faq&layout=form'.$cid.'&Itemid='.$post['Itemid'] ) ;
			}

		} else {
		
			// get the raw value of myField
			$formValue = JRequest::get('POST');
			// add the value to the session namespace myForm
			$session->set('formvalues', $formValue);
			
			JError::raiseWarning('SOME_ERROR',JText::_('JE_CAPTCHAERROR'));
			$link 	  = JRoute::_(JURI::base().'index.php?option=com_jefaqpro&view=faq&layout=form'.$cid.'&Itemid='.$post['Itemid']) ;
		}

		$this->setRedirect( $link, $msg );
	}

	function response()
	{
		$model    	   = $this->getModel('faq');
		$model->getResponses();
	}

	function hits()
	{
		$model    	   = $this->getModel('faq');
		$model->getHits();
	}
}
?>