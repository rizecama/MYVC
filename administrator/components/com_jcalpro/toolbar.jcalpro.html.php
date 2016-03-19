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

 $Id: toolbar.jcalpro.html.php 714 2011-03-31 17:56:25Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * @package Mambo
 * @subpackage Extcalendar
 */
class TOOLBAR_extcalendar {
  /**
   * Draws the menu for to Edit settings
   */
  function _THEMES() {
    JToolBarHelper::title( 'Themes Menu', 'generic.png' );
    JToolBarHelper::makeDefault();
    JToolBarHelper::custom('installtheme', 'upload.png', 'upload_f2.png', 'Install',false);
    JToolBarHelper::custom('cancel', 'cancel.png', 'cancel_f2.png', 'Cancel', false);
  }
  function _EDIT_THEMES() {
    global $id;

    JToolBarHelper::title( 'Themes Menu', 'generic.png' );
    JToolBarHelper::custom('savetheme', 'save.png', 'save_f2.png', 'Save', false);
    if ( $id ) {
      // for existing content items the button is renamed `close`
      JToolBarHelper::custom('canceledit', 'cancel.png', 'cancel_f2.png', 'Close', false);
    } else {
      JToolBarHelper::custom('canceledit', 'cancel.png', 'cancel_f2.png', 'Cancel', false);
    }
    JToolBarHelper::help( 'screen.mambots.edit' );
  }
  function _INSTALL( $element )
  {
    if( $element == 'themes' )
    {
      JToolBarHelper::title( 'Install themes', 'generic.png' );
      JToolBarHelper::custom('removetheme', 'delete.png', 'delete_f2.png', 'Uninstall', false);
      JToolBarHelper::custom('cancel', 'cancel.png', 'cancel_f2.png', 'Cancel', false);
    }
  }

  function _EDIT() {
    JToolBarHelper::title('Edit Config', 'generic.png');
    //JToolBarHelper::preferences( 'com_jcalpro', 230);
    JToolBarHelper::save('saveSettings');
    JToolBarHelper::cancel('canceleditSettings');
  }
  function _DEFAULT() {
    JToolBarHelper::title( 'Themes Menu', 'generic.png' );
    if (is_callable(array('mosMenuBar', 'editListX'))) {
      JToolBarHelper::editListX('editSettings','Settings');
    } else {
      JToolBarHelper::editList('editSettings','Settings');
    }
    JToolBarHelper::custom('showthemes', 'new.png', 'new_f2.png', 'Themes', false);

    JToolBarHelper::custom('categories','move.png','move_f2.png','Categories',false);
  }

  function _DOCUMENTATION() {
    JToolBarHelper::title( 'Documentation', 'generic.png' );
    JToolBarHelper::cancel();
  }

  function _ABOUT() {
    JToolBarHelper::title( 'About', 'generic.png' );
    JToolBarHelper::cancel();
  }

  function _IMPORT() {
    JToolBarHelper::title( 'Import', 'generic.png' );
    JToolBarHelper::cancel();
  }

  /* Events toolbars */
  function EDIT_EVENTS_MENU ( )
  {
    JToolBarHelper::title( 'Event Menu', 'generic.png' );
    JToolBarHelper::save();
    JToolBarHelper::cancel();
  }

  function EVENTS_MENU ( )
  {
    JToolBarHelper::title( 'Manage Events Menu', 'generic.png' );
    JToolBarHelper::publishList();
    JToolBarHelper::unpublishList();
    JToolBarHelper::addNew('new', 'Add');
    JToolBarHelper::editList();
    JToolBarHelper::custom( 'copyEvent', 'copy.png', 'copy_f2.png', 'Copy', true, false);
    JToolBarHelper::deleteList();
    JToolBarHelper::cancel('cancelToMain', 'Cancel');
  }

  function _JCAL_MAIN ( )
  {
    JToolBarHelper::title( 'JCal Pro control panel', 'generic.png' );
    JToolBarHelper::back('Back to Joomla', 'index.php');
    //JToolBarHelper::preferences( 'com_jcalpro', 230);
  }

}

/**
 * @package Mambo
 * @subpackage Extcalendar
 */
class TOOLBAR_extcalendarCategories {
  /**
   * Draws the menu for to Edit a category
   */
  function _EDITCATEGORY() {
    JToolBarHelper::title( 'Category Menu', 'generic.png' );
    JToolBarHelper::save('saveCategory');
    JToolBarHelper::cancel('cancelEditCategory');
  }
  function _DEFAULTCATEGORIES() {
    JToolBarHelper::title( 'Categories Menu', 'generic.png' );
    JToolBarHelper::addNewX('newCategory');
    JToolBarHelper::publishList();
    JToolBarHelper::unpublishList();

    JToolBarHelper::editListX('editCategory');
    JToolBarHelper::deleteList('','deleteCategories');
    JToolBarHelper::custom('cancel', 'cancel.png', 'cancel_f2.png', 'Cancel', false);
  }
}

class TOOLBAR_extcalendarCalendars {
  /**
   * Draws the menu for to Edit a category
   */
  function _EDITCALENDAR() {
    JToolBarHelper::title( 'Create/Edit calendar', 'generic.png' );
    JToolBarHelper::save('saveCalendar');
    JToolBarHelper::cancel('cancelEditCalendar');
  }
  function _DEFAULTCALENDARS() {
    JToolBarHelper::title( 'Calendars Menu', 'generic.png' );
    JToolBarHelper::addNewX('newCalendar');
    JToolBarHelper::publishList();
    JToolBarHelper::unpublishList();

    JToolBarHelper::editListX('editCalendar');
    JToolBarHelper::deleteList('','deleteCalendars');
    JToolBarHelper::custom('cancel', 'cancel.png', 'cancel_f2.png', 'Cancel', false);
  }
}

?>