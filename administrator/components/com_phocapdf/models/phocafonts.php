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
jimport( 'joomla.application.component.model' );
jimport( 'joomla.installer.installer' );
jimport( 'joomla.installer.helper' );
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );
class PhocaPDFCpModelPhocaFonts extends JModel
{
	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_pathd			= null;
	var $_paths 		= array();

	function __construct() {
		parent::__construct();

		global $mainframe, $option;		

		$context	= 'com_phocapdf.phocafont.list.';
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $context.'limitstart',	'limitstart',	0, 'int' );
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

	}
	
	function getData($removeInfo = 0) {

		if (empty($this->_data)) {
			$xmlFiles 		= JFolder::files($this->_getPathDst(), '.xml$', 1, true);
			$this->_total 	= count($xmlFiles);
			
			$cF = count($xmlFiles);
			$iV = (int)$this->getState('limitstart');
			$nV	= (int)$this->getState('limitstart') + (int)$this->getState('limit');
			if ($nV > $cF) {
				$nV = $cF;
			}
			// If at least one xml file exists
			if ($cF > 0) {
				$j = 0;
				for ($i = $iV, $n = $nV; $i < $n; $i++) {
					$row = &$xmlFiles[$i];
					// Is it a valid joomla installation manifest file?
					$xml = $this->_isManifest($row);					
					if(!is_null($xml->document->children())) {
						foreach ($xml->document->children() as $key => $value) {
							$this->_data[$j]->id			=	$i + 1;
							$this->_data[$j]->checked_out	=	false;
							if ($value->_name == 'name') {
								$this->_data[$j]->name		=	$value->_data;
							}
							if ($value->_name == 'tag') {
								$this->_data[$j]->tag		=	$value->_data;
							}
							
							if ($removeInfo == 1) {
								if ($value->_name == 'files') {
									if(!is_null($value->children())) {
										foreach ($value->children() as $key2 => $value2) {
											$this->_data[$j]->files[] 		= $value2->_data;
											$this->_data[$j]->manifestfile	= $row;
										}
									}
								}
							}
						}
					}
					$j++;
				}
			}
		}
		
		return $this->_data;
	}
	
	function &_isManifest($file) {
		// Initialize variables
		$null	= null;
		$xml	=& JFactory::getXMLParser('Simple');

		// If we cannot load the xml file return null
		if (!$xml->loadFile($file)) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		
		$root =& $xml->document;
		if (!is_object($root) || ($root->name() != 'install' )) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		return $xml;
	}

	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function getTotal() {
		if (empty($this->_total)) {
			// Should not happen, because we should got $this->_total by getData()
			$xmlFiles 		= JFolder::files($this->_getPathDst(), '.xml$', 1, true);
			$this->_total 	= count($xmlFiles);
		}
		return $this->_total;
	}
	
	function _getPathDst() {
		if (empty($this->_pathd)) {
			$this->_pathd = JPATH_COMPONENT_ADMINISTRATOR.DS.'fonts';
		}
		return $this->_pathd;
	}
	
	
	function delete($cid = array()) {
		
		global $mainframe;
		$errorMsg 	= '';
		$items 		= $this->getData(1);
		
		foreach ($cid as $key => $value) {

			foreach($items as $key2 => $value2) {
		
				if ($value2->id == $value && $value2->tag == 'freemono') {
					$errorMsg .= $value2->name . ': '.JText::_('Basic font cannot be deleted') . '<br />';
				} else {
					if ((int)$value2->id == (int)$value) {
						if (isset($value2->files)) {
							foreach($value2->files as $key3 => $value3) {
								if ($value3 != 'index.html') {
									if (JFile::exists($this->_getPathDst() . DS . $value3)) {
										if(JFile::delete($this->_getPathDst() . DS . $value3)) {
											
										} else {
											$errorMsg .= $value3 . ': '.JText::_('This file could not be deleted') . '<br />';
										}
									} else {
										// $errorMsg .= $value3 . ': '.JText::_('This file doesn\'t exist') . '<br />';
									}
								}
							}
							
							// Delete the manifest file too
							if (isset($value2->manifestfile)) {
								if (JFile::exists($value2->manifestfile)) {
									if(JFile::delete($value2->manifestfile)) {
											
									} else {
										$errorMsg .= $value3 . ': '.JText::_('This XML Installation file could not be deleted') . '<br />';
									}
								}
							} else {
								$errorMsg .= JText::_('The XML file could not be found') . '<br />';
							}
						} else {
							$errorMsg .= JText::_('The list of files could not be found in XML file') . '<br />';
						}
					} 
				}
			}
		}

		return $errorMsg;
	}
	
	
	function install() {
		global $mainframe;
		$package = $this->_getPackageFromUpload();
	
		if (!$package) {
			JError::raiseWarning(1, JText::_('Unable to find install package'));
			$this->deleteTempFiles();
			return false;
		}
		
		if ($package['dir'] && JFolder::exists($package['dir'])) {
			$this->setPath('source', $package['dir']);
		} else {
			JError::raiseWarning(1, JText::_('Install path does not exist'));
			$this->deleteTempFiles();
			return false;
		}

		// We need to find the installation manifest file
		if (!$this->_findManifest()) {
			JError::raiseWarning(1, JText::_('Unable to find required information in install package'));
			$this->deleteTempFiles();
			return false;
		}
		
		// Files - copy files in manifest
		foreach ($this->_manifest->document->children() as $child)
		{
			if (is_a($child, 'JSimpleXMLElement') && $child->name() == 'files') {
				if ($this->parseFiles($child) === false) {
					JError::raiseWarning(1, JText::_('Unable to find required information in install package'));
					$this->deleteTempFiles();
					return false;
				}
			}
		}
		
		// File - copy the xml file
		$copyFile 		= array();
		$path['src']	= $this->getPath( 'manifest' ); // XML file will be copied too
		$path['dest']	= $this->_getPathDst() . DS. basename($this->getPath('manifest')); 
		$copyFile[] 	= $path;
		$this->copyFiles($copyFile);
		$this->deleteTempFiles();
		
		return true;
	}
	
	function _getPackageFromUpload() {
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLFILE'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('No file selected'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Build the appropriate paths
		$config 	=& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.$userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest);
		$this->_manifest =& $manifest;
		
		$this->setPath('packagefile', $package['packagefile']);
		$this->setPath('extractdir', $package['extractdir']);
		
		return $package;
	}
	
	function getPath($name, $default=null){
		return (!empty($this->_paths[$name])) ? $this->_paths[$name] : $default;
	}
	
	function setPath($name, $value) {
		$this->_paths[$name] = $value;
	}
	
	function _findManifest() {
		// Get an array of all the xml files from the installation directory
		$xmlfiles = JFolder::files($this->getPath('source'), '.xml$', 1, true);
		
		// If at least one xml file exists
		if (count($xmlfiles) > 0) {
			foreach ($xmlfiles as $file)
			{
				// Is it a valid joomla installation manifest file?
				$manifest = $this->_isManifest($file);
				if (!is_null($manifest)) {
				
					// If the root method attribute is set to phoca pdf font
					$root =& $manifest->document;
					if ($root->attributes('type') != 'phocapdffonts') {
						JError::raiseWarning(1, JText::_('No Phoca PDF Font Installation File'));
						return false;
					}

					// Set the manifest object and path
					$this->_manifest =& $manifest;
					$this->setPath('manifest', $file);

					// Set the installation source path to that of the manifest file
					$this->setPath('source', dirname($file));
					
					return true;
				}
			}

			// None of the xml files found were valid install files
			JError::raiseWarning(1, JText::_('ERRORNOTFINDJOOMLAXMLSETUPFILE'));
			return false;
		} else {
			// No xml files were found in the install folder
			JError::raiseWarning(1, JText::_('ERRORXMLSETUP'));
			return false;
		}
	}
	
	
	function parseFiles($element, $cid=0) {
		// Initialize variables
		$copyfiles = array ();

		if (!is_a($element, 'JSimpleXMLElement') || !count($element->children())) {
			// Either the tag does not exist or has no children therefore we return zero files processed.
			return 0;
		}
		
		// Get the array of file nodes to process
		$files = $element->children();
		if (count($files) == 0) {
			// No files to process
			return 0;
		}

		$source 	 = $this->getPath('source');
		$destination = $this->_getPathDst();
		// Process each file in the $files array (children of $tagName).
		
		foreach ($files as $file) {
			$path['src']	= $source.DS.$file->data();
			$path['dest']	= $destination.DS.$file->data();

			// Add the file to the copyfiles array
			$copyfiles[] = $path;
		}
		return $this->copyFiles($copyfiles);
	}
	
	function copyFiles($files) {
		if (is_array($files) && count($files) > 0) {
			foreach ($files as $file)
			{
				// Get the source and destination paths
				$filesource	= JPath::clean($file['src']);
				$filedest	= JPath::clean($file['dest']);

				if (!file_exists($filesource)) {
					JError::raiseWarning(1, JText::sprintf('File does not exist', $filesource));
					return false;
				} else {
					if (!(JFile::copy($filesource, $filedest))) {
						JError::raiseWarning(1, JText::sprintf('Failed to copy file to', $filesource, $filedest));
						return false;
					}					
				}
			}
		} else {
			JError::raiseWarning(1, JText::sprintf('Problem while installation'));
			return false;
		}
		
		return count($files);
	}
	
	function deleteTempFiles () {
		// Delete Temp files
		$path = $this->getPath('source');
		if (is_dir($path)) {
			$val = JFolder::delete($path);
		} else if (is_file($path)) {
			$val = JFile::delete($path);
		}
		$packageFile = $this->getPath('packagefile');
		if (is_file($packageFile)) {
			$val = JFile::delete($packageFile);
		}
		$extractDir = $this->getPath('extractdir');
		if (is_dir($extractDir)) {
			$val = JFolder::delete($extractDir);
		}
	}
}

?>