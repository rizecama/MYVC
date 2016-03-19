<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
class PhocaPDFCpControllerPhocaPDFInstall extends PhocaPDFCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );		
	}

	
	
	function install() {		
		$db			= &JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// ------------------------------------------
		// Phoca PDF Config
		// ------------------------------------------
		
		
		
		// Install View
		$msgFile = PhocaPDFCpControllerPhocaPDFInstall::installView();

		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
			
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca PDF not successfully installed' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca PDF successfully installed' );
		}
		
		$link = 'index.php?option=com_phocapdf';
		$this->setRedirect($link, $msg);
	}
	
	
	function upgrade() {
		
		$db			=& JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// CHECK TABLES
		/*
		$query =' SELECT * FROM `'.$dbPref.'phocamenu_config` LIMIT 1;';
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		
		$query=' SELECT * FROM `'.$dbPref.'phocamenu_day` LIMIT 1;'."\n";
		*/
		
		// Install View
		$msgFile = PhocaPDFCpControllerPhocaPDFInstall::installView();

		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
			
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca PDF not successfully upgraded' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca PDF successfully upgraded' );
		}
		
		$link = 'index.php?option=com_phocapdf';
		$this->setRedirect($link, $msg);
	}
	
	
	function AddColumnIfNotExists($table, $column, $attributes = "INT( 11 ) NOT NULL DEFAULT '0'", $after = '' ) {
		
		global $mainframe;
		$db				=& JFactory::getDBO();
		$columnExists 	= false;

		$query = 'SHOW COLUMNS FROM '.$table;
		$db->setQuery( $query );
		if (!$result = $db->query()){return false;}
		$columnData = $db->loadObjectList();
		
		
		foreach ($columnData as $valueColumn) {
			if ($valueColumn->Field == $column) {
				$columnExists = true;
				break;
			}
		}
		
		if (!$columnExists) {
			if ($after != '') {
				$query = "ALTER TABLE `".$table."` ADD `".$column."` ".$attributes." AFTER `".$after."`";
			} else {
				$query = "ALTER TABLE `".$table."` ADD `".$column."` ".$attributes."";
			}
			$db->setQuery( $query );
			if (!$result = $db->query()){return false;}
		}
		
		return true;
	}
	
	function installView() {
		$msgFile = '';
		jimport('joomla.client.helper');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		$ftp 	=& JClientHelper::setCredentialsFromRequest('ftp');
		
		// - - - - - - - - - - - - - - - 
		// View
		// - - - - - - - - - - - - - - - 
		
		$src 		= JPATH_ROOT . DS . 'administrator' .DS.'components' . DS . 'com_phocapdf' . DS . 'files' . DS . 'phocapdf' . DS .'phocapdf.php';
		$dest 		= JPATH_ROOT . DS . 'libraries' . DS . 'joomla' . DS . 'document' . DS . 'phocapdf' . DS . 'phocapdf.php';
		$folderPath = JPATH_ROOT . DS . 'libraries' . DS . 'joomla' . DS . 'document' . DS . 'phocapdf';
		
		if(!JFolder::create($folderPath, 0755)) {
			$msgFile = JText::_( 'Folder Not Created' ). ': ' . $folderPath;
		}
		
		if(!JFile::write($folderPath.DS."index.html", "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>")) {
			$msgFile .= '<br />'.JText::_( 'File Not Created' ). ': ' . $folderPath
					 . '<br />' . JText::_( 'Destination' ). ': ' . $folderPath.DS."index.html";
		}
		
		
		if (file_exists($src)) {
			JFile::copy($src, $dest);
		}
		
		if (!file_exists($dest)) {
			$msgFile .= JText::_( 'File Not Copied' )
					. '<br />' . JText::_( 'Source' ). ': ' . $src
					. '<br />' . JText::_( 'Destination' ). ': ' . $dest;

		}
		
		// - - - - - - - - - - - - - - - 
		// Rename bak to xml
		// - - - - - - - - - - - - - - -
		$rsrc 		= JPATH_ROOT . DS . 'administrator' .DS.'components' . DS . 'com_phocapdf' . DS . 'fonts' . DS .'freemono.bak';
		$rdest 		= JPATH_ROOT . DS . 'administrator' .DS.'components' . DS . 'com_phocapdf' . DS . 'fonts' . DS .'freemono.xml';
		
		if (file_exists($rsrc) && !file_exists($rdest)) {
			JFile::move($rsrc, $rdest);
		}

		if (!file_exists($rdest)) {
			$msgFile .= JText::_( 'File Not Renamed' )
					. '<br />' . JText::_( 'Source' ). ': ' . $rsrc
					. '<br />' . JText::_( 'Destination' ). ': ' . $rdest;

		}
		
		$rsrc 		= JPATH_ROOT . DS . 'administrator' .DS.'components' . DS . 'com_phocapdf' . DS . 'fonts' . DS .'helvetica.bak';
		$rdest 		= JPATH_ROOT . DS . 'administrator' .DS.'components' . DS . 'com_phocapdf' . DS . 'fonts' . DS .'helvetica.xml';
		
		if (file_exists($rsrc) && !file_exists($rdest)) {
			JFile::move($rsrc, $rdest);
		}

		if (!file_exists($rdest)) {
			$msgFile .= JText::_( 'File Not Renamed' )
					. '<br />' . JText::_( 'Source' ). ': ' . $rsrc
					. '<br />' . JText::_( 'Destination' ). ': ' . $rdest;

		}
		
		return $msgFile;
	}
}
// utf-8 test: ä,ö,ü,ř,ž
?>