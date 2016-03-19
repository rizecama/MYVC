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

 $Id: view.html.php 661 2010-08-17 16:49:47Z shumisha $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view');

/**
 * This class will display and manage insertion of events
 * links or content into content being edited
 * by Joomla editor. Works together with
 * @author yannick
 *
 */
class JcalproViewEditorinsert extends JView

{

  function display( $tpl = null) {

    global $mainframe;

    // this view can be used from frontend so make sure the templates (located in backend)
    // will be found when doing that
    if (!$mainframe->isAdmin()) {
      $this->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'editorinsert'.DS.'tmpl');
    }

    //get plugin data
    $plugin = &JPluginHelper::getPlugin( 'editors-xtd', 'jclinsert');
    if (empty( $plugin)) {
      JError::raiseError( 500, 'JCal pro insert event plugin not enabled. unable to continue.');
    }

    // setup parameters
    $params = new JParameter($plugin->params);
    
    // load our language file
    JPlugin::loadLanguage( 'plg_editors-xtd_jclinsert', JPATH_ADMINISTRATOR);

    // load required events data
    include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jcalpro' .DS . 'controllers' . DS . 'events.php';
    $data = JCalProControllerEvents::getShowEventsData ( $option = 'com_jcalpro', $section ='');

    // get default Itemid
    $defaultItemid = intval($params->get('calendar_itemid_default'));
    
    // assign it to template
    $this->assign('rows', $data->rows);
    $this->assign('option', $data->option);
    $this->assign('pagenav', $data->pageNav);
    $this->assign('search', $data->search);
    $this->assign('lists', $data->lists);
    $this->assign('defaultItemid', $defaultItemid);

    // assign parameters default data to template
    $this->assign( 'jcl_insert_options_event_title', $params->get('jcl_insert_options_event_title_default', 1));
    
    // insert link to tooltips library
    jimport( 'joomla.html.html');
    JHTML::_('behavior.tooltip');

    // get document, to be able to insert links
    $document =& JFactory::getDocument();

    // insert link to custom javascript
    $js = JURI::root() . 'administrator/components/com_jcalpro/views/editorinsert/editorinsert.js';
    $document->addScript( $js);

    // store global data
    $js = 'var jclEditorInsertBaseUrl = "' . JURI::root() . 'index.php?option=com_jcalpro";';
    $js .= 'var jclEditorInsertEName = "' . htmlspecialchars( JRequest::getVar('e_name') ) . '";';
    $js .= 'var jclEditorInsertDefaultItemid = "' . $defaultItemid . '";';
    $document->addScriptDeclaration( $js);

    // insert link to additionnal css
    if(!$mainframe->isAdmin()) {
      $css = JURI::root() . 'administrator/templates/khepri/css/general.css';
      $document->addStyleSheet( $css );
      $css = JURI::root() . 'administrator/templates/khepri/css/component.css';
      $document->addStyleSheet( $css );
    }

    $css = JURI::root() . 'administrator/templates/khepri/css/rounded.css';
    $document->addStyleSheet( $css );
    $css = JURI::root() . 'administrator/templates/khepri/css/icon.css';
    $document->addStyleSheet( $css );

    // call parent
    parent::display( $tpl);

  }

}
