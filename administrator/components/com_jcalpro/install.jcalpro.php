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

 $Id: install.jcalpro.php 714 2011-03-31 17:56:25Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

global $installationSource; $installationSource = $this->parent->getPath('source');

/**
 * Retrieves stored params of a given extension (module or plugin)
 * (as saved upon uninstall)
 *
 * @param string $extName the module name, including mod_ if a module
 * @param array $shConfig an array holding the database columns of the extension
 * @param array $shPub, an array holding the publication information of the module (only for modules)
 * @return boolean, true if any stored parameters were found for this extension
 */
function shGetExtensionSavedParams( $extName, &$shConfig, &$shPub = null, $useId = false) {

  static $fileList = array();

  // prepare default return value
  $status = false;

  // read all file names in /media/jCalPro_upgrade_conf dir, for easier processing
  $baseFolder = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf';
  if (empty( $fileList) || !isset($fileList[$extName])) {
    $baseName = $extName . ($useId ? '_[0-9]{1,10}':'').'_'.str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
		if (JFolder::exists( $baseFolder)) {
      $fileList[$extName] = JFolder::files( $baseFolder, $baseName);
		}
  }

  // extract filename from list we've established previously
  $extFile = isset($fileList[$extName]) && $fileList[$extName] !== false ? array_shift( $fileList[$extName]) : '';
  if (empty( $fileList[$extName])) {
    // prevent infinite loop
    $fileList[$extName] = false;
  }
  
  if (!empty( $extFile) && JFile::exists( $baseFolder . DS . $extFile)) {
    $status = true; // operation was successful, regardless of whether user wants to keep config or not
    if (!JCL_KEEP_CONFIG_ON_UPGRADE) {  // we've been told not to preserve modules settings so erase file
      JFile::delete( $baseFolder . DS . $extFile);
    } else {  // we want to read settings for this extension
      include( $baseFolder . DS . $extFile);
    }
  }

  return $status;
}

/**
 * Retrieves stored params of a given extension (module or plugin)
 * (as saved upon uninstall)
 *
 * @param string $extName the module name, including mod_ if a module
 * @param array $shConfig an array holding the database columns of the extension
 * @param array $shPub, an array holding the publication information of the module (only for modules)
 */
function shGetCBExtensionSavedParams( $extName, &$shPlugin, &$shTab) {

  $extFile = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf'.DS. $extName.'_'
  .str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
  if (JFile::exists( $extFile)) {
    if (!JCL_KEEP_CONFIG_ON_UPGRADE) {  // we've been told not to preserve modules settings so erase file
      JFile::delete( $extFile);
    } else {  // we want to read settings for this extension
      if (JFile::exists( $extFile)) {
        include( $extFile);
      }
    }
  }
}

/**
 * Insert in the db the previously retrieved parameters for a plugin
 * including publication information. Also move files as required
 *
 * @param string $basePath , the base path to get original files from
 * @param array $shConfig an array holding the database parameters of the plugin
 * @param array $files, an array holding list of files from the plugin
 */
function shInsertPlugin( $basePath, $shConfig, $files, $folders) {

  // check data
  if (empty( $files)) {
    return;
  }

  // move the files to target location
  $result = array();
  $success = true;
  // create folders as needed
  if (!empty( $folders)) {
    foreach( $folders as $folder) {
      $success = $success && JFolder::create( JPATH_ROOT.DS.'plugins'.DS. $folder);
    }
  }
  // now move files across
  if ($success) {
    foreach( $files as $pluginFile) {
      $hasTarget = JFile::exists(JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.$pluginFile);
      $hasSource = $basePath.DS.$pluginFile;
      $success = $success && true === JFile::move( $basePath.DS.$pluginFile, JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.$pluginFile);
      $result[$pluginFile] = $success;
    }
  }
  // if files moved to destination, setup plugin in Joomla database
  if ($success) {
    // read stored params from disk
    shGetExtensionSavedParams( $shConfig['element'], $shConfig);

    // insert elements in db
    $db = &JFactory::getDBO();
    $sql="INSERT INTO `#__plugins` ( `name`, `element`, `folder`, `access`, `ordering`, `published`,"
    . " `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
    . " VALUES ('{$shConfig['name']}', '{$shConfig['element']}', '{$shConfig['folder']}', '{$shConfig['access']}', '{$shConfig['ordering']}',"
    . " '{$shConfig['published']}', '{$shConfig['iscore']}', '{$shConfig['client_id']}', '{$shConfig['checked_out']}',"
    . " '{$shConfig['checked_out_time']}', '{$shConfig['params']}');";
    $db->setQuery( $sql);
    $db->query();
  } else {
    // don't leave anything behind
    foreach( $files as $pluginFile) {
      if ($result[$pluginFile]) {
        // if file was copied, try to delete it
        JFile::delete( JPATH_ROOT.DS.'plugins' . DS . $shConfig['folder'] . DS . $pluginFile);
      }
    }
    JError::RaiseWarning( 500, JText::_('Could not install plugin'));
  }

  return $success;
}

/**
 * Insert in the db the previously retrieved parameters for a Community Builder plugin
 * including publication information. Also move files as required
 *
 * @param string shFiles , an array with source and target path, and file list
 * @param array $shConfig an array holding the database parameters of the plugin
 */
function shInsertCBPlugin( $shFiles, $shPlugin, $shTab) {

  // move the files to target location
  $result = array();
  $success = JFolder::create($shFiles['targetPath']);
  foreach( $shFiles['files'] as $pluginFile) {
    $success = $success && true === JFile::copy( $shFiles['sourcePath'].DS.$pluginFile, $shFiles['targetPath'].DS.$pluginFile);
    $result[$pluginFile] = $success;
  }

  // if files moved to destination, setup plugin in Joomla database
  if ($success) {
    // read stored params from disk
    shGetCBExtensionSavedParams( $shPlugin['element'], $shPlugin, $shTab);

    // insert elements in db
    $db = &JFactory::getDBO();
    // insert plugin record
    $sql="INSERT INTO `#__comprofiler_plugin` ( `name`, `element`, `type`, `folder`, `access`, `ordering`, `published`,"
    . " `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`)"
    . " VALUES ('{$shPlugin['name']}', '{$shPlugin['element']}', '{$shPlugin['type']}', '{$shPlugin['folder']}', '{$shPlugin['access']}', '{$shPlugin['ordering']}',"
    . " '{$shPlugin['published']}', '{$shPlugin['iscore']}', '{$shPlugin['client_id']}', '{$shPlugin['checked_out']}',"
    . " '{$shPlugin['checked_out_time']}', '{$shPlugin['params']}');";
    $db->setQuery( $sql);
    $db->query();

    $pluginId = $db->insertid();

    // insert tab record
    $sql="INSERT INTO `#__comprofiler_tabs` ( `title`, `description`, `ordering`, `ordering_register`, `width`, `enabled`,"
    . " `pluginclass`, `pluginid`, `fields`, `params`, `sys`, `displaytype`, `position`, `useraccessgroupid`)"
    . " VALUES ('{$shTab['title']}', '{$shTab['description']}', {$shTab['ordering']}, {$shTab['ordering_register']}, '{$shTab['width']}', '{$shTab['enabled']}',"
    . " '{$shTab['pluginclass']}', {$pluginId}, {$shTab['fields']}, NULL,"
    . " {$shTab['sys']}, '{$shTab['displaytype']}', '{$shTab['position']}', {$shTab['useraccessgroupid']});";
    $db->setQuery( $sql);
    $db->query();
  } else {
    // don't leave anything behind
    foreach( $shFiles['files'] as $pluginFile) {
      if ($result[$pluginFile]) {
        // if file was copied, try to delete it
        JFile::delete( $shFiles['targetPath'] . DS .$pluginFile);
      }
    }
    JError::RaiseWarning( 500, JText::_('Could not install CB plugin'));
  }

  return $success;
}

/**
 * Insert in the db the previously retrieved parameters for a module
 * including publication information. Also move files as required
 *
 * @param string $basePath , the base path to get original files from
 * @param array $shConfig an array holding the database parameters of the module
 * @param array $files, an array holding list of files from the module
 */
function shInsertModule( $basePath, $shConfig, $shPub, $files) {

  // check data
  if (empty( $files)) {
    return;
  }

  // move the files to target location
  $result = array();
  $success = true;
  foreach( $files as $moduleFile) {
    if ($success) {
      if(!JFolder::exists( JPATH_ROOT.DS.'modules'.DS.$shConfig['module'])) {
        // create the directory in /modules first
        $success = JFolder::create( JPATH_ROOT.DS.'modules'.DS.$shConfig['module']);
      }
      if ($success) {
        // now copy the module
        $success = true === JFile::move( $basePath.DS.$moduleFile, JPATH_ROOT.DS.'modules'.DS.$shConfig['module'].DS.$moduleFile);
      }
    }
    $result[$moduleFile] = $success;
  }

  if ($success) {
    $c = 0;
    do {
      // read stored params from disk
      $moduleFound = shGetExtensionSavedParams( $shConfig['module'], $shConfig, $shPub, $useId = true);
      if ($c == 0 || $moduleFound) {
        $c++; // insert at least each module once
        // insert elements in db
        $sql = "INSERT INTO `#__modules` (`title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`,"
        . " `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`)"
        . " VALUES ('".$shConfig['title']."', '".$shConfig['content']."', '".$shConfig['ordering']."', '".$shConfig['position']."', '0', '0000-00-00 00:00:00', '"
        . $shConfig['published']."', '".$shConfig['module']."', '" . $shConfig['numnews'] . "', '".$shConfig['access']."', '".$shConfig['showtitle']."', '"
        . $shConfig['params']."', '".$shConfig['iscore'] . "', '".$shConfig['client_id'] . "', '".$shConfig['control'] . "');";
        $db = & JFactory::getDBO();
        $db->setQuery( $sql);
        $db->query();
        $moduleID = $db->insertid();
        // set pages where module is published
        foreach ($shPub as $pub) {
          $db->setQuery( "INSERT INTO `#__modules_menu` (`moduleid`, `menuid`) VALUES ($moduleID, $pub);");
          $db->query();
        }
      }
    } while ($moduleFound);
  } else {
    // don't leave anything behind
    foreach( $files as $moduleFile) {
      if ($result[$moduleFile]) {
        // if file was copied, try to delete it
        JFile::delete( JPATH_ROOT.DS.'modules'.DS.$shConfig['module'].DS.$moduleFile);
      }
    }
    // delete the module directory
    JFolder::delete( JPATH_ROOT.DS.'modules'.DS.$shConfig['module']);

    // raise a warning
    JError::RaiseWarning( 500, JText::_('Could not install module'));
  }

  return $success;
}

function shInsertThemes() {
	global $installationSource;
	// some paths
	$backupPath = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf';
  $savePath   = $backupPath.DS.'themes';
	// no themes? no problem
	if (!JFolder::exists($savePath)) {
		return;
	}
	$themes = JFolder::folders($savePath, '.', false, false, array('default'));
	// no themes? no problem
	if (!is_array($themes) || empty($themes)) {
		return;
	}
	// loop themes
	foreach ($themes as $theme) {
		$thisSavePath  = $savePath.DS.$theme;
		// this should never happen...
		if (!JFolder::exists($thisSavePath)) {
			continue;
		}
		// reinstall
		if (!class_exists('EXTCALThemeInstaller')) {
			require_once ($installationSource.DS.'admin'.DS.'installer'.DS.'installer.class.php');
			require_once ($installationSource.DS.'admin'.DS.'installer'.DS.'themes'.DS.'themes.class.php');
		}
		$installer = new EXTCALThemeInstaller();
		$installer->install($thisSavePath);
	}
}

function shUpgrade() {
  // seamless upgrade hack
  if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcalpro'.DS.'jcalpro.xml')) {
	  require_once (dirname(__FILE__).DS.'uninstall.jcalpro.php');
	  com_uninstall(true);
  }
}

function com_install() {

  define( 'JCL_KEEP_CONFIG_ON_UPGRADE', 1);
  
  shUpgrade();

  $db = & JFactory::getDBO();

  $registry =& JFactory::getConfig();
  foreach (get_object_vars($registry->toObject()) as $k => $v)
  {
    $varname = 'mosConfig_'.$k;
    $$varname = $v;
  }

  // update admin menu images
  $db->setQuery( "SELECT id FROM #__components WHERE name= 'JCal Pro'" );
  $id = $db->loadResult();

  $db->setQuery( "UPDATE #__components SET admin_menu_img = '../components/com_jcalpro/images/calendar_icon_16x16.png' WHERE id = '$id'" );
  $db->query();
  //add new admin menu images
  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/config.png' WHERE parent='$id' AND name = 'Edit Settings'");
  $db->query();
  $db->setQuery( "UPDATE #__components SET admin_menu_img = '../components/com_jcalpro/images/calendar_icon_16x16.png' WHERE parent='$id' AND name = 'Manage Calendars'");
  $db->query();
  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/category.png' WHERE parent='$id' AND name = 'Manage Categories'");
  $db->query();
  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/template.png' WHERE parent='$id' AND name = 'Manage Themes'");
  $db->query();
  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/install.png' WHERE parent='$id' AND name = 'Install Themes'");
  $db->query();

  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/archive.png' WHERE parent='$id' AND name = 'Import'");
  $db->query();

  $db->setQuery( "UPDATE #__components SET admin_menu_img = '../components/com_jcalpro/images/calendar_icon_16x16.png' WHERE parent='$id' AND name = 'About'");
  $db->query();

  $db->setQuery( "UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/help.png' WHERE parent='$id' AND name = 'Documentation'");
  $db->query();

  //add new admin menu links
  $db->setQuery( "UPDATE #__components SET admin_menu_link = 'option=com_jcalpro&task=install&element=themes' WHERE parent='$id' AND name = 'Install Themes'");
  $db->query();

  $db->setQuery( "UPDATE #__components SET admin_menu_link = 'option=com_jcalpro&section=events' WHERE parent='$id' AND name = 'Manage Events'");
  $db->query();

  // fix menu items linking to component
  $query = 'select id from #__menu where `link` like "%index.php?option=com_jcalpro%"';
  $db->setQuery( $query);
  $db->query();
  $menuItems = $db->loadResultArray();
  if (!empty( $menuItems)) {
    // get JCal pro new component id
    $query = 'select id from #__components where `link` like \'%%option=com_jcalpro%%\'';
    $db->setQuery( $query);
    $db->query();
    $jcalProMenuId = $db->loadResult();
    if (!empty( $jcalProMenuId)) {
      // if we have a valid id, update pre-existing menu items
      $menuItemsList = implode( ',', $menuItems);
      $query = 'update #__menu set `componentid` = \'' . $jcalProMenuId . '\' where `id` in (' . $menuItemsList . ')';
      $db->setQuery( $query);
      $db->query();
    }
  }

  // set admin email
  $sql="UPDATE #__jcalpro2_config SET value = '$mosConfig_mailfrom' WHERE name='calendar_admin_email' AND value=''";
  $db->setQuery($sql);
  $db->query();
  
  // delete these keys because they are broken and useless
  $sql="DELETE FROM #__jcalpro2_config WHERE `name` = 'sort_category_view_by'";
  $db->setQuery($sql);
  $db->query();

  // remove records of previously installed custom themes
  $sql = "select count(id) from #__jcalpro2_themes where `id`>'1';";
  $db->setQuery($sql);
  $themesCount = $db->loadResult();
  if ($themesCount > 0) {
    $sql = "delete from #__jcalpro2_themes where `id`>1;";
    $db->setQuery($sql);
    $db->query();
    // make default themes active again
    $sql = "UPDATE #__jcalpro2_themes SET published = '1';";
    $db->setQuery( $sql );
    $db->query();
  }

  // database schema updates

  // # 1 add index on last_updated. Some distributed versions of 2.0.x do not have this index
  $query = 'show index from #__jcalpro2_events';
  $db->setQuery( $query);
  $indexes = $db->loadObjectList();
  if (!empty( $indexes)) {
    $found = false;
    foreach( $indexes as $index) {
      if( $index->Column_name == 'last_updated') {
        $found = true;
        break;
      }
    }
    if (!$found) {
      $query=' ALTER TABLE `#__jcalpro2_events` ADD INDEX `last_updated` ( `last_updated` )';
      $db->setQuery( $query);
      $db->query();
    }
  }
  
  // reinstall themes
  shInsertThemes();
  // reset default theme
  $published = "default";
  $dThemePath = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf'.DS.'default_theme_'.str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
	if (JFile::exists($dThemePath)) {
		include_once ($dThemePath);
	}
  if ("default" != $published) {
  	$db->setQuery("UPDATE #__jcalpro2_themes SET published = 0 WHERE 1");
  	$db->query();
  	$db->setQuery("UPDATE #__jcalpro2_themes SET published = 1 WHERE theme = " . $db->Quote($published));
  	$db->query();
  	$db->setQuery("SELECT theme FROM #__jcalpro2_themes WHERE published = 1");
  	if (!$db->loadResult()) {
  		$db->setQuery("UPDATE #__jcalpro2_themes SET published = 1 WHERE theme = " . $db->Quote('default'));
  		$db->query();
  	}
  }

  // move joomfish content elements files if JF is installed
  global $mainframe;

  $source = DS . 'com_jcalpro' . DS . 'contentelements' . DS;
  $target = DS . 'com_joomfish' . DS . 'contentelements' . DS;
  if ((JFile::exists( JPATH_ROOT.DS.'administrator'.DS.'components' . $target . 'content.xml'))) {
    // joomfish installed, copy files
    $elements = array( 'jcalpro2_events.xml', 'jcalpro2_categories.xml', 'jcalpro2_calendars.xml');
    $result = true;
    foreach ($elements as $element) {
      $result = $result && JFile::copy( $source . $element, $target . $element, JPATH_ROOT.DS.'administrator'.DS.'components');
    }
    $mainframe->enqueueMessage( ($result ? 'Success' : 'Failure') . ' copying JCal pro support files for Joomfish to ' . $target . '<br />');
  } else {
    $mainframe->enqueueMessage( 'Joomfish support for Jcal not installed (Joomfish not detected on this site).');
  }

  $success = true;

  // install Community builder latest events plugin
  if ($success) {
    if ((JFile::exists( JPATH_ROOT.DS.'administrator'.DS.'components' . DS . 'com_comprofiler' . DS . 'admin.comprofiler.php'))) {
      // cb installed, insert plugin
      $shFiles = array();
      // first move the files
      $shFiles['sourcePath'] = JPATH_ROOT . DS . 'administrator'.DS.'components' . DS . 'com_jcalpro' . DS . 'plugins' . DS . 'cb';
      $shFiles['targetPath'] = JPATH_ROOT . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_cbjcalproevents';
      $shFiles['files'] = array( 'cbjcalproevents.xml', 'cbjcalproevents.php', 'index.html');

      $shPlugin = array('name'=>'CB JCal pro events', 'element' => 'cbjcalproevents', 'type' => 'user', 'folder' => 'plug_cbjcalproevents',
      'backend_menu' => '', 'access' => 0, 'ordering' => 30, 'published' => 1, 'iscore' => 0, 'client_id' => 0,
      'checked_out' => 0, 'checked_out_time' => '0000-00-00 00:00:00', 'params' => '');

      $shTab = array('title' => 'Events', 'description' => 'JCal pro 2 latest events plugin for Community Builder : displays events in public and private events. See settings available under Community Builder plugin manager.', 'ordering' => 100, 'ordering_register' => 10, 'width' => .5, 'enabled' => '0',
      'pluginclass' => 'geteventsTab', 'fields' => 0, 'sys' => 0, 'displaytype' => 'tab', 'position' => 'cb_tabmain', 'useraccessgroupid' => -2);

      // actually insert CB plugin
      $success = shInsertCBPlugin( $shFiles, $shPlugin, $shTab);

      // display result message
      $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro Latest events plugin for Community Builder to ' . $shFiles['targetPath'] . '<br />');
    } else {
      $mainframe->enqueueMessage( 'JCal Pro Latest events plugin for Community Builder not installed (CB not detected on this site).');
    }
  }

  // install Community builder minical plugin
  if ($success) {
    if ((JFile::exists( JPATH_ROOT.DS.'administrator'.DS.'components' . DS . 'com_comprofiler' . DS . 'admin.comprofiler.php'))) {
      // cb installed, insert plugin
      $shFiles = array();
      // first move the files
      $shFiles['sourcePath'] = JPATH_ROOT . DS . 'administrator'.DS.'components' . DS . 'com_jcalpro' . DS . 'plugins' . DS . 'cb';
      $shFiles['targetPath'] = JPATH_ROOT . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_cbjcalprominical';
      $shFiles['files'] = array( 'cbjcalprominical.xml', 'cbjcalprominical.php', 'index.html');

      $shPlugin = array('name'=>'CB JCal pro mini-calendar', 'element' => 'cbjcalprominical', 'type' => 'user', 'folder' => 'plug_cbjcalprominical',
      'backend_menu' => '', 'access' => 0, 'ordering' => 31, 'published' => 1, 'iscore' => 0, 'client_id' => 0,
      'checked_out' => 0, 'checked_out_time' => '0000-00-00 00:00:00', 'params' => '');

      $shTab = array('title' => 'Calendar', 'description' => 'JCal pro 2 mini-calendar plugin for Community Builder : displays events in public and private events inside a navigable calendar. See settings available under Community Builder plugin manager.', 'ordering' => 101, 'ordering_register' => 10, 'width' => .5, 'enabled' => '0',
      'pluginclass' => 'getminicalTab', 'fields' => 0, 'sys' => 0, 'displaytype' => 'tab', 'position' => 'cb_tabmain', 'useraccessgroupid' => -2);

      // actually insert CB plugin
      $success = shInsertCBPlugin( $shFiles, $shPlugin, $shTab);

      // display result message
      $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro mini-calendar plugin for Community Builder to ' . $shFiles['targetPath'] . '<br />');
    } else {
      $mainframe->enqueueMessage( 'JCal Pro mini-calendar plugin for Community Builder not installed (CB not detected on this site).');
    }
  }

  // install Jomsocial latest events plugin
  if ($success) {
    if ((JFile::exists( JPATH_ROOT.DS.'administrator'.DS.'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php'))) {
      $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'plugins'.DS.'js';
      $shConfig = array('name'=>'JCalPro Latest Events plugin for Jomsocial', 'element' => 'jsjcalproevents', 'folder'=>'community',
      'access'=>0, 'ordering'=>30, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
      $files = array( 'jsjcalproevents.php', 'jsjcalproevents.xml');
      if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.$shConfig['folder'].DS.'index.html')) {
        // only add index.html if not already there. That would cause install failure. index.html can already
        // be there due to other apps installing it
        $files[] = 'index.html';
      }
      $folders = array();
      $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
      // display result message
      $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro latest events plugin for Jomsocial to joomla plugin directory (community folder). <br />');
    } else {
      $mainframe->enqueueMessage( 'JCal Pro latest events plugin for Jomsocial not installed (Jomsocial 1.6+ not detected on this site).');
    }
  }

  // install Jomsocial minical plugin
  if ($success) {
    if ((JFile::exists( JPATH_ROOT.DS.'administrator'.DS.'components' . DS . 'com_community' . DS . 'libraries' . DS . 'core.php'))) {
      $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'plugins'.DS.'js';
      $shConfig = array('name'=>'JCalPro mini-calendar plugin for Jomsocial', 'element' => 'jsjcalprominical', 'folder'=>'community',
      'access'=>0, 'ordering'=>31, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
      $files = array( 'jsjcalprominical.php', 'jsjcalprominical.xml');
      $folders = array();
      $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
      // display result message
      $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro mini-calendar plugin for Jomsocial to joomla plugin directory (community folder).<br />');
    } else {
      $mainframe->enqueueMessage( 'JCal Pro mini-calendar plugin for Jomsocial not installed (Jomsocial 1.6+ not detected on this site).');
    }
  }

  // install content plugin
  if ($success) {
    $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'plugins';
    $shConfig = array('name'=>'JCalPro Latest Events plugin', 'element' => 'bot_jcalpro_latest_events', 'folder'=>'content',
      'access'=>0, 'ordering'=>10, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
    $files = array( 'bot_jcalpro_latest_events.php', 'bot_jcalpro_latest_events.xml');
    $folders = array();
    $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
  }

  // install search plugin
  if ($success) {
    $shConfig = array('name'=>'JCal Pro Search plugin', 'element' => 'bot_jcalpro_search', 'folder'=>'search',
  'access'=>0, 'ordering'=>10, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
  'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
    $files = array( 'bot_jcalpro_search.php', 'bot_jcalpro_search.xml');
    $folders = array();
    $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
  }

  // install AD common libraries plugin
  if ($success) {
    $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'plugins'.DS.'system';
    $shConfig = array('name'=>'JCal pro common libraries', 'element' => 'jcllibraries', 'folder'=>'system',
      'access'=>0, 'ordering'=>-5, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
     
    $files = array( 'jcllibraries.php', 'jcllibraries.xml', 'jcl.shhttpcomm/shhttpcomm.php', 'jcl.shhttpcomm/index.html');

    $folders = array( 'system' . DS . 'jcl.shhttpcomm');

    $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
    // display result message
    $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro common libraries plugin to joomla system plugin directory. <br />');
  }

  // install AD reCaptcha plugin
  if ($success) {
    $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'plugins' . DS . 'jcalpro';
    $shConfig = array('name'=>'JCal pro reCaptcha plugin', 'element' => 'jclrecaptcha', 'folder'=>'jcalpro',
      'access'=>0, 'ordering'=>-4, 'published' => 1, 'iscore' => 0, 'client_id' => 0, 'checked_out' => 0, 
      'checked_out_time' => '0000-00-00 00:00:00',  'params'=>'');
     
    $files = array( 'jclrecaptcha.php', 'jclrecaptcha.xml', 'index.html'
    , 'jcl.recaptcha'.DS.'jclrecaptcha.php', 'jcl.recaptcha'.DS.'index.html');

    $folders = array( 'jcalpro', 'jcalpro'. DS . 'jcl.recaptcha');

    $success = shInsertPlugin( $basePath, $shConfig, $files, $folders);
    // display result message
    $mainframe->enqueueMessage( ($success ? 'Success' : 'Failure') . ' copying JCal Pro reCaptcha plugin to jcalpro plugin directory. <br />');
  }

  // install latest event module
  if ($success) {
    $shConfig = array('title'=>'JCal Pro Latest Events', 'content' => '', 'ordering'=>10,'position'=>'left',
  'checked_out' => 0, 'checked_out_time' => '0000-00-00 00:00:00', 'published' => 0, 'module' => 'mod_jcalpro_latest_J15',
  'numnews' => 0, 'access'=>0,'showtitle'=>0,'params'=>'', 'iscore' => 0, 'client_id' => 0, 'control' => '');
    $shPub = array('0'); // default : not published anywhere
    $basePath = JPATH_ADMINISTRATOR. DS.'components'.DS.'com_jcalpro'.DS.'modules';
    $files = array( 'mod_jcalpro_latest_J15.php', 'mod_jcalpro_latest_J15.xml');
    $success = shInsertModule( $basePath, $shConfig, $shPub, $files);
  }

  // install minical module
  if ($success) {
    $shConfig = array('title'=>'JCal Pro Mini-calendar', 'content' => '', 'ordering'=>11,'position'=>'left',
  'checked_out' => 0, 'checked_out_time' => '0000-00-00 00:00:00', 'published' => 0, 'module' => 'mod_jcalpro_minical_J15',
  'numnews' => 0, 'access'=>0,'showtitle'=>0,'params'=>'', 'iscore' => 0, 'client_id' => 0, 'control' => '');
    $shPub = array('0'); // default : not published anywhere
    $files = array( 'mod_jcalpro_minical_J15.php', 'mod_jcalpro_minical_J15.xml');
    $success = shInsertModule( $basePath, $shConfig, $shPub, $files);
  }

  // Well done
  if ($success) {
  	$path = JPATH_ROOT . DS .'media' . DS . 'jCalPro_upgrade_conf';
  	if (JFolder::exists($path)) JFolder::delete($path);
    echo "Installation completed";
  } else {
    echo 'Sorry, something went wrong. You should uninstall and try again. Possibly check file permissions before doing so.';
  }
  echo "<div align='left'>";
  include ("../components/com_jcalpro/index.html");
  echo "</div>";
}
