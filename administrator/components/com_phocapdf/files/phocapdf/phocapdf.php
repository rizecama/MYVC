<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Library
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL  
 *  
 */
defined('JPATH_BASE') or die();
jimport('joomla.filesystem.file');

class JDocumentPhocaPDF extends JDocument
{ 
	var $_header	= null;
	var $_name		= 'Phoca';

	function __construct($options = array()) {
		parent::__construct($options);
		$this->_mime = 'application/pdf';
		$this->_type = 'pdf';
	}

	// Called from article
	function setHeader($text) {
		$this->_header = $text;
	}
	function getHeader() {
		return $this->_header;
	}

	function setName($name = 'Phoca') {
		$this->_name = $name;
	}

	function getName() {
		return $this->_name;
	}

	function render( $cache = false, $params = array()) {
	
	//Call static function because of using on different places by different extensions
	if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'helpers'.DS.'phocapdfrender.php')) {
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'helpers'.DS.'phocapdfrender.php');
	} else {
		return JError::raiseError('PDF ERROR', 'Document cannot be created - Loading of Phoca PDF library (Render) failed');
	}
	
	$data = PhocaPdfRender::renderPDF($this);
	// Set document type headers
	parent::render();
	JResponse::setHeader('Content-disposition', 'inline; filename="'.$this->getName().'.pdf"', true);
	//Close and output PDF document
	return $data;
	
/*
		// Define - must be called before calling the plugin (because plugin includes definition file of tcpdf,
		// so it must be defined before
		define('K_TCPDF_EXTERNAL_CONFIG', true);
		define("K_PATH_MAIN", JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'assets'.DS.'tcpdf');// Installation path		
		define("K_PATH_URL", JPATH_BASE);// URL path
		define("K_PATH_FONTS", JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'fonts'.DS);// Fonts path
		define("K_PATH_CACHE", K_PATH_MAIN.DS.'cache'.DS);// Cache directory path
		$urlPath = JURI::base(true) . '/administrator/components/com_phocapdf/assets/tcpdf/';// Cache URL path
		define("K_PATH_URL_CACHE", $urlPath.'cache/');
		define("K_PATH_IMAGES", K_PATH_MAIN.DS.'images'.DS);// Images path
		define("K_BLANK_IMAGE", K_PATH_IMAGES.DS."_blank.png");// Blank image path
		define("K_CELL_HEIGHT_RATIO", 1.25);// Cell height ratio
		define("K_TITLE_MAGNIFICATION", 1.3);// Magnification scale for titles
		define("K_SMALL_RATIO", 2/3);// Reduction scale for small font
		define("HEAD_MAGNIFICATION", 1.1);// Magnication scale for head
		define('PDF_PAGE_FORMAT', 'A4');// page format
		define('PDF_PAGE_ORIENTATION', 'P');// page orientation (P=portrait, L=landscape)
		define('PDF_CREATOR', 'Phoca PDF');// document creator
		define('PDF_AUTHOR', 'Phoca PDF');// document author
		define('PDF_HEADER_TITLE', 'Phoca PDF');// header title
		define('PDF_HEADER_STRING', "Phoca PDF");// header description string
		//define('PDF_HEADER_LOGO', 'tcpdf_logo.jpg');// image logo
		//define('PDF_HEADER_LOGO_WIDTH', 30);// header logo image width [mm]
		define('PDF_UNIT', 'mm');// document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch]
		define('PDF_header_margin', 10);// header margin
		define('PDF_footer_margin', 10);// footer margin
		define('PDF_MARGIN_TOP', 33);// top margin
		define('PDF_MARGIN_BOTTOM', 25);// bottom margin
		define('PDF_MARGIN_LEFT', 15);// left margin
		define('PDF_MARGIN_RIGHT', 15);// right margin
		define('PDF_FONT_NAME_MAIN', 'freemono');// main font name
		define('PDF_FONT_SIZE_MAIN', 10);// main font size
		define('PDF_FONT_NAME_DATA', 'freemono');// data font name
		define('PDF_FONT_SIZE_DATA', 8);// data font size
		define('PDF_IMAGE_SCALE_RATIO', 4);// Ratio used to scale the images
		define('K_TCPDF_CALLS_IN_HTML', true);
		
		
		// LOADING OF HELPER FILES (extended TCPDF library), LISTENING TO Phoca PDF Plugins
		$option = JRequest::getCmd('option');
		$t 		= JString::ucfirst(str_replace('com_', '', $option)); 		
		switch ($option) {
			case 'com_content':
				
				$content 	= new JObject();
				// Get info from Phoca PDF Content Plugin
				$dispatcher	= &JDispatcher::getInstance();
				JPluginHelper::importPlugin('system');
				$results 	= $dispatcher->trigger('onBeforeCreatePDFContent', array (&$content));
			
				if (JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'helpers'.DS.'phocapdfcontenttcpdf.php')) {
					require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocapdf'.DS.'helpers'.DS.'phocapdfcontenttcpdf.php');
					$pdf = new PhocaPDFContentTCPDF($content->page_orientation, 'mm', $content->page_format, true, 'UTF-8', $content->use_cache);
				} else {
					return JError::raiseError('PDF ERROR', 'Document cannot be created - Loading of Phoca PDF library (Content) failed');
				}
			break;
			
			case 'com_phocamenu':
			
				// Get info from Phoca PDF Restaurant Menu Plugin
				$content 	= new JObject();
				$dispatcher	= &JDispatcher::getInstance();
				JPluginHelper::importPlugin('phocapdf');
				
				$results 	= $dispatcher->trigger('onBeforeCreatePDFRestaurantMenu', array (&$content));
				
				if (JFile::exists(JPATH_SITE.DS.'plugins'.DS.'phocapdf'.DS.'restaurantmenu.php')) {
					require_once(JPATH_SITE.DS.'plugins'.DS.'phocapdf'.DS.'restaurantmenu.php');
					$pdf = new PhocaPDFRestaurantMenuTCPDF($content->page_orientation, 'mm', $content->page_format, true, 'UTF-8', $content->use_cache);
				} else {
					return JError::raiseError('PDF ERROR', 'Document cannot be created - Loading of Phoca PDF Plugin (Restaurant Menu) failed');
				}
			break;
			
			case 'com_virtuemart':
			
				// Get info from Phoca PDF VirtueMart Plugin
				$content 	= new JObject();
				$dispatcher	= &JDispatcher::getInstance();
				JPluginHelper::importPlugin('phocapdf');
				$results 	= $dispatcher->trigger('onBeforeCreatePDFVirtueMart', array (&$content));
				
				if (JFile::exists(JPATH_SITE.DS.'plugins'.DS.'phocapdf'.DS.'virtuemart.php')) {
					require_once(JPATH_SITE.DS.'plugins'.DS.'phocapdf'.DS.'virtuemart.php');
					$pdf = new PhocaPDFVirtueMartTCPDF($content->page_orientation, 'mm', $content->page_format, true, 'UTF-8', $content->use_cache);
					
					
				} else {
					return JError::raiseError('PDF ERROR', 'Document cannot be created - Loading of Phoca PDF Plugin (VirtueMart) failed');
				}
			break;
			
			default:
				$results = $dispatcher->trigger('onBeforeDisplayPDF'.$t, array (&$pdf, &$content, &$this));
				//return JError::raiseError('PDF ERROR', 'Document cannot be created (No known option)');
			break;
		}
		
		
		$pdf->SetMargins($content->margin_left, $content->margin_top, $content->margin_right);
		
		$pdf->SetAutoPageBreak(TRUE, $content->margin_bottom);
		$pdf->setCellHeightRatio($content->site_cell_height);
		$pdf->setFont($content->font_type);
		
		$siteFontColor = $pdf->convertHTMLColorToDec($content->site_font_color);
		$pdf->SetTextColor($siteFontColor['R'], $siteFontColor['G'], $siteFontColor['B']);
		
		//$pdf->setPageFormat($content->page_format, $content->page_orientation);
		$pdf->SetHeaderMargin($content->header_margin);
		$pdf->SetFooterMargin($content->footer_margin);
		$pdf->setImageScale($content->image_scale);
		
		
		// PDF Metadata
		$pdf->SetCreator(PDF_CREATOR);
		
		
		// Content
		switch ($option) {
			case 'com_content':
		
				$results = $dispatcher->trigger('onBeforeDisplayPDFContent', array (&$pdf, &$content, &$this));

			break;
			
			case 'com_phocamenu':
			
				$results = $dispatcher->trigger('onBeforeDisplayPDFRestaurantMenu', array (&$pdf, &$content, &$this));
				
			break;
			
			case 'com_virtuemart':
			
				$results = $dispatcher->trigger('onBeforeDisplayPDFVirtueMart', array (&$pdf, &$content, &$this));
		
			break;
		}
		
		// Called from administrator area (administrator calls frontend view, but it still administrator area)
		$adminView	= JRequest::getVar('admin', 0, '', 'int');
		if ($adminView == 1) { 
			$content->pdf_destination = 'S';
		}
		
	
		if ($content->pdf_destination == 'D' || $content->pdf_destination == 'I') {
			$pdf->Output($content->pdf_name, $content->pdf_destination);
			return true;
		}
				
		$data = $pdf->Output($content->pdf_name, $content->pdf_destination);

		// Set document type headers
		parent::render();
		JResponse::setHeader('Content-disposition', 'inline; filename="'.$this->getName().'.pdf"', true);

		//Close and output PDF document
		
		return $data;*/
	}
}