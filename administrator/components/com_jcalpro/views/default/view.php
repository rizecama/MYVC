<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla!
 (com_extcal_0_9_2_RC4.zip from mamboguru.com).
 Extcal (http://sourceforge.net/projects/extcal) was renamed
 and adapted to become a Mambo/Joomla! component by
 Matthew Friedman, and further modified by David McKinnis
 (mamboguru.com) to repair some security holes.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************

 $Id: view.php 661 2010-08-17 16:49:47Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

/**
 * Extension Manager Default View
 *
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class InstallerViewDefault extends JView
{
  function __construct($config = null)
  {
    parent::__construct($config);
    $this->_addPath('template', $this->_basePath.DS.'views'.DS.'default'.DS.'tmpl');
  }

  function display($tpl=null)
  {
    /*
     * Set toolbar items for the page
     */
    JToolBarHelper::title( JText::_( 'Extension Manager'), 'install.png' );

    // Document
    $document = & JFactory::getDocument();
    $document->setTitle(JText::_('Extension Manager').' : '.JText::_( $this->getName() ));

    // Get data from the model
    $state		= &$this->get('State');

    // Are there messages to display ?
    $showMessage	= false;
    if ( is_object($state) )
    {
      $message1		= $state->get('message');
      $message2		= $state->get('extension.message');
      $showMessage	= ( $message1 || $message2 );
    }

    $this->assign('showMessage',	$showMessage);
    $this->assignRef('state',		$state);

    JHTML::_('behavior.tooltip');
    parent::display($tpl);
  }

  /**
   * Should be overloaded by extending view
   *
   * @param	int $index
   */
  function loadItem($index=0)
  {
  }
}