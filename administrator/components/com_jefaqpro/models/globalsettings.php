<?php
/**
 * jeFAQ package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class jefaqModelGlobalsettings extends JModel
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

		$row =& $this->getTable();
		// Bind the form fields
		$post	= JRequest::get( 'post' );

		if (!$row->bind($post)) {
			return 0;
		}

		// Make sure data is valid
		if (!$row->check())	{
			return 0;
		}
		// Store it
		if (!$row->store())	{
			return 0;
		}
		return $row->id;
	}

	// get global settings
	function globalConfig()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT * FROM #__je_faq_settings ';
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows  = $db->loadObject();

		return $rows;
	}

	function getThemes()
	{
		$db		 	  = & JFactory::getDBO();

		$query 	 	  = 'SELECT id AS value, themes AS text FROM #__je_faq_themes ';
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$themes 	  = $db->loadObjectList() ;

		return $themes;
	}

	function getPreview()
	{
		$theme_id = & JRequest::getVar('theme');
		$path	  = JURI::base();

		// preview image here..
		echo '<img width="350px" src="'.$path.'components/com_jefaqpro/assets/images/preview/style'.$theme_id.'.jpg" title="" />';
		exit;
	}

	function faqHelp()
	{
		?>
			<script>
				window.open('http://www.jextn.com/support/','_blank');
			</script>
		<?php
	}
}
?>