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

 $Id: uninstall.jcalpro.php 709 2011-03-01 20:52:31Z jeffchannell $

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Writes an extension parameter to a disk file, located
 * in the /media directory
 *
 * @param string $extName the extension name
 * @param array $shConfig associative array of parameters of the extension, to be written to disk
 * @param array $pub, optional, only if module, an array of the menu item id where the module is published
 * @return boolean, true if no error
 */
function shWriteExtensionConfig( $extName, $params) {

  if (empty($params)) {
    return;
  }

  // calculate target file name
  $extFile = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf'.DS. $extName .'_'
  .str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';

  // remove previous if any
  if (JFile::exists( $extFile)) {
    JFile::delete( $extFile);
  }

  // prepare data for writing
  $data = '<?php // Extension params save file for JCal Pro
//    
if (!defined(\'_JEXEC\')) die(\'Direct Access to this location is not allowed.\');';
  $data .= "\n";

  if (!empty( $params)) {
    foreach( $params as $key => $value) {
      $data .= '$'. $key . ' = ' . var_export($value, true) . ';';
      $data .= "\n";
    }
  }

  // write to disk
  $success = JFile::write( $extFile, $data);

  return $success !== false;
}

/**
 * Save parameters, then delete a module
 *
 * @param string $modName, the module name (matching 'module' column in modules table
 */
function shSaveDeleteModuleParams( $modName) {

  $db = & JFactory::getDBO();
  $modIdsList = array();

  // read module param from db
  $sql = 'SELECT * FROM `#__modules` WHERE `module`= \''.$modName.'\';';
  $db->setQuery($sql);
  $result = $db->loadAssocList();

  if (!empty( $result)) {
    // delete previously saved params, in case a module
    // instance has been deleted
    $baseFolder = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf';
    $baseName = $modName . '_[0-9]{1,10}'.'_'.str_replace('/','_',str_replace('http://', '', JURI::base())).'.php';
	if (JFolder::exists( $baseFolder)) {
    $fileList = JFolder::files( $baseFolder, $baseName);
    if (!empty( $fileList)) {
      foreach( $fileList as $fileName) {
        JFile::delete( $baseFolder . DS . $fileName);
      }
    }
}

    // save data for all modules
    foreach( $result as $mod) {
      $modId = $mod['id'];
      unset($mod['id']); // we don't want to save DB id

      // find pages the module is published on
      $sql = "SELECT menuid FROM #__modules_menu WHERE moduleid = " . (int) $modId;
      $db->setQuery( $sql );
      $rows = $db->loadResultArray();
      $pub = array();
      // $pub contains page where the module is published
      if (!empty( $rows)) {
        foreach($rows as $menuid) {
          $pub[] = $menuid;
          $modIdsList[] = $menuid;
        }
      }
      // write everything on disk
      shWriteExtensionConfig( $modName .'_' .  $modId, array('shConfig'=> $mod, 'shPub' => $pub));
    }
  }

  // now remove module details from db
  // note : though we have saved params for only one instance of the module
  // we of course delete all instances from the db
  $db->setQuery( "DELETE FROM `#__modules` WHERE `module`= '" . $modName . "';");
  $db->query();

  // now remove also module publication pages (for all modules involved
  if (!empty( $modIdsList)) {
    $sql='DELETE FROM #__modules_menu WHERE moduleid in (' . implode( ',', $modIdsList) . ')';
    $db->setQuery( $sql );
    $db->query( $sql );
  }

  // delete the module files, and its subdir
  $basePath = JPATH_ROOT . DS . 'modules'. DS . $modName . DS;
  JFile::delete( array( $basePath . $modName . '.php', $basePath . $modName . '.xml'));
  if ($modName != '') {
    // protect agains deleting the whole module folder !
    JFolder::delete( $basePath);
  }
}

/**
 * Save parameters, then delete a plugin
 *
 * @param string $pluginName, the plugin name, mathcing 'element' column in plugins table
 * @param string $folder, the plugin folder (ie : 'content', 'search', 'system',...
 */
function shSaveDeletePluginParams( $pluginName, $folder, $folders) {

  $db = & JFactory::getDBO();

  // read plugin param from db
  $sql = 'SELECT * FROM `#__plugins` WHERE `element`= \''.$pluginName.'\';';
  $db->setQuery($sql);
  $result = $db->loadAssocList();

  if (!empty( $result)) {
    // remove plugin db id
    unset($result[0]['id']);

    // write everything on disk
    shWriteExtensionConfig( $pluginName, array('shConfig' => $result[0]));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__plugins` WHERE `element`= '" . $pluginName . "';");
    $db->query();
  }

  // delete the plugin files
  $basePath = JPATH_ROOT.DS.'plugins'. DS . $folder . DS;
  if ($folder != '' && JFile::exists($basePath . $pluginName.'.php')) {
    JFile::delete( array( $basePath . $pluginName.'.php', $basePath . $pluginName.'.xml'));
  }

  // delete plugin additional folders
  if (!empty( $folders)) {
    foreach ($folders as $aFolder) {
      JFolder::delete( $basePath . $aFolder);
    }
  }
}

/**
 * Save parameters, then delete a Community builder plugin
 *
 * @param string $pluginName, the plugin name, mathcing 'element' column in plugins table
 */
function shSaveDeleteCBPluginParams( $pluginName) {

  $db = & JFactory::getDBO();

  // check if CB is still installed, in case user removed it in the mean time
  $sql = 'SHOW TABLES LIKE "%_comprofiler_%"';
  $db->setQuery($sql);
  $hasCB = $db->loadResult();

  if (!$hasCB) {
    return;
  }
  // read plugin param from db
  $sql = 'SELECT * FROM `#__comprofiler_plugin` WHERE `element`= \''.$pluginName.'\';';
  $db->setQuery($sql);
  $pluginParams = $db->loadAssocList();
   
  // save plugin params
  if (!empty( $pluginParams)) {
    // remove plugin db id
    $pluginId = $pluginParams[0]['id'];
    unset($pluginParams[0]['id']);
  } else {
    $pluginId = 0;
  }

  // read tab param from db
  $sql = 'SELECT * FROM `#__comprofiler_tabs` WHERE `pluginid`= \''.$pluginId.'\';';
  $db->setQuery($sql);
  $tabParams = $db->loadAssocList();

  if (!empty( $tabParams)) {
    // remove plugin db id
    unset($tabParams[0]['id']);
    // write everything on disk
    shWriteExtensionConfig( $pluginName, array('shPlugin' => $pluginParams[0], 'shTab' => $tabParams[0]));

    // now remove plugin details from db
    $db->setQuery( "DELETE FROM `#__comprofiler_plugin` WHERE `element`= '" . $pluginName . "';");
    $db->query();
    $db->setQuery( "DELETE FROM `#__comprofiler_tabs` WHERE `pluginid`= " . $pluginId . ";");
    $db->query();
  }

  // delete the plugin files
  $basePath = JPATH_ROOT . DS . 'components' . DS . 'com_comprofiler' . DS . 'plugin' . DS . 'user' . DS . 'plug_' . $pluginName . DS;
  if (JFolder::exists($basePath)) {
    JFolder::delete( $basePath);
  }
}

/**
 * Copies any non-default themes to /media to preserve after upgrade
 * 
 */

function shSavePremiumThemes() {
	// backup the themes database...
  $sql = 'SELECT * FROM `#__jcalpro2_themes` WHERE `theme` NOT IN ("default")';
  $db = &JFactory::getDbo();
  $db->setQuery($sql);
  $themedb = $db->loadAssocList();
  // preserve the default
  $published = 'default';

  if (!empty($themedb)) {
  	// fix for keys
  	$themeRows = array();
  	foreach ($themedb as $key => $row) {
  		$themeRows[$row['theme']] = $row;
  		// preserve default
  		if (1 == @$row['published']) {
  			$published = $row['theme'];
  		}
  	}
  }
  // ok, save the default theme for later
  shWriteExtensionConfig("default_theme", array('published' => $published));
	// some paths
  $savePath  = JPATH_ROOT.DS.'media'.DS.'jCalPro_upgrade_conf'.DS.'themes';
	$themePath = JPATH_ROOT.DS.'components'.DS.'com_jcalpro'.DS.'themes';
	// whoa, this shouldn't happen ;)
	if (!JFolder::exists($themePath)) {
		return;
	}
	$themes = JFolder::folders($themePath, '.', false, false, array('default'));
	// no themes? no problem
	if (!is_array($themes) || empty($themes)) {
		return;
	}
	// ok, make a new folder for the theme storage
	if (!JFolder::exists($savePath)) {
		JFolder::create($savePath);
		if (!JFolder::exists($savePath)) {
			// something went wrong... maybe we should throw an error, or at least tell the user?
			return;
		}
	}
	// there's some remains laying around... empty the folder (just nuke & recreate)
	else {
		JFolder::delete($savePath);
		JFolder::create($savePath);
	}
	// loop themes
	foreach ($themes as $theme) {
		$thisThemePath = $themePath.DS.$theme;
		$thisSavePath  = $savePath.DS.$theme;
		// this should never happen...
		if (!JFolder::exists($thisThemePath)) {
			continue;
		}
		// if, for whatever reason, the theme folder is already present, destroy it
		if (JFolder::exists($thisSavePath)) {
			if (!JFolder::delete($thisSavePath)) {
				// hmm, couldn't remove it... ?
			}
		}
		// if we got this far, the environment should be in a good state to copy
		// notice strict bool here - failure sends a JError object
		if (true === JFolder::copy($thisThemePath, $thisSavePath)) {
			// theme was copied, remove original
			JFolder::delete($thisThemePath);
		}
		// whoa, copy failed...
		else {
			// todo: perhaps save the JError from above & output message?
		}
    // write config to disk
    if (isset($themeRows[$theme])) {
	    shWriteExtensionConfig("themes_{$theme}", $themeRows[$theme]);
    }
	}
}

function com_uninstall($quiet = false) {

  // save and remove latest events module details
  shSaveDeleteModuleParams( 'mod_jcalpro_latest_J15');
  // save and remove minical module details
  shSaveDeleteModuleParams( 'mod_jcalpro_minical_J15');

  // save and remove latest events plugins
  $folders = array();
  shSaveDeletePluginParams( 'bot_jcalpro_latest_events', 'content', $folders);
  // save and remove search plugin
  shSaveDeletePluginParams( 'bot_jcalpro_search', 'search', $folders);

  // save and remove Community builder plugins
  shSaveDeleteCBPluginParams( 'cbjcalproevents');
  shSaveDeleteCBPluginParams( 'cbjcalprominical');

  // save and remove Jomsocial builder plugins
  shSaveDeletePluginParams( 'jsjcalproevents', 'community', $folders);
  shSaveDeletePluginParams( 'jsjcalprominical', 'community', $folders);

  // save and remove JCal pro libraries plugins
  $folders = array( 'jcl.shhttpcomm');
  shSaveDeletePluginParams( 'jcllibraries', 'system', $folders);
  $folders = array( ('jcl.recaptcha'));
  shSaveDeletePluginParams( 'jclrecaptcha', 'jcalpro', $folders);
  
  // save the themes
  shSavePremiumThemes();
  
  // only output text if we're not being quiet
	if (!$quiet) {
	  echo 'JCal pro has been uninstalled. Content of database tables has been left untouched, in order to allow for transparent upgrade.';
	}
}
