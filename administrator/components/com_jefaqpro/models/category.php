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
jimport('joomla.filesystem.file');

class jefaqModelCategory extends JModel
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

	function &getData()
	{
		$row =& $this->getTable();
		$row->load( $this->_id );
		return $row;
	}

	// save
	function store()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$row =& $this->getTable();

		// Bind the form fields
		$post			= JRequest::get('post', JREQUEST_ALLOWRAW);

		if (!$row->bind($post)) {
			return 0;
		}
		// Make sure data is valid
		if (!$row->check()) {
			return 0;
		}

		$cert_file		= JRequest::getVar( 'image', '', 'files', 'array' );
		$row->image 		= jefaqModelCategory::uploadImage( $cert_file );

		// get the next order
		if ($post['id'] == '0') {
			$row->ordering  = $row->getNextOrder();
		} else {
		}
		// ordering here..

		if(empty($post[alias])) {
			$row->alias 	= $post['category'];
		}
		$row->alias 	    = JFilterOutput::stringURLSafe($row->alias);

		if (trim($row->image) != 'notupload')
		{
			if ( trim($row->image) != 'format' ) {
				// Store it
				if (!$row->store())	{
					return 0;
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}

		return $row->id;
	}
	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$result     = ($task == 'publish')?1:2;
		$neg_result     = ($task == 'publish')?-1:-2;
		$n			= count( $cid );

		if (empty( $cid )) {
			return 0;
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__je_faq_category'
		. ' SET state = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return $neg_result;
		} else {
			return $result;
		}
	}

	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db    = & JFactory::getDBO();
		$cids  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row   = & $this->getTable();

		JArrayHelper::toInteger( $cids );
		$cids1 = implode( ',', $cids );

		$query = 'SELECT count(*) FROM #__je_faq as f  ' .
				'  LEFT JOIN #__je_faq_category as c ON f.catid=c.id ' .
				'  WHERE c.id IN ( '.$cids1.' )'
				;
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}
		$counts  = $db->loadResult();

		if ( $counts > 0 ) {
			return false;
		} else {
			if (count( $cids )) {
				foreach($cids as $cid) {
					if (!$row->delete( $cid )) {
						return false;
					}
				}
			}
		}
		return true;
	}

	// When edit the categories getting the order details.
	function getOrdering()
	{
		$db 	= & JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(0), '', 'array' );

		$query  = 'SELECT ordering AS value,category AS text ' .
				  'FROM #__je_faq_category ORDER BY ordering';
		$row 	= & JTable::getInstance('category','Table');
		$row->load( $cid[0] );
		$lists	= JHTML::_('list.specificordering',  $row, $cid[0], $query );

		return $lists;
	}

	// move up and down direction..
	function move($direction)
	{
		$row 	= & $this->getTable();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (isset( $cid[0] ))
		{
			$row->load( (int) $cid[0] );
			$row->move($direction);

			$cache = & JFactory::getCache('com_jefaqpro');
			$cache->clean();
		}


		return true;
	}
	// end up and down direction..

	// function for save order
	function saveOrder()
	{
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array(), 'post', 'array' );

		$row =& $this->getTable();
		$total		= count( $cid );
		$conditions	= array();

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		// update ordering values
		for ($i = 0; $i < $total; $i++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return JError::raiseError( 500, $db->getErrorMsg() );
				}
			}
		}

		return true;
	}
	// save order end

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

	// Function for upload and resize images..
	function uploadImage( $cert_file )
	{
		$upload_directory = JPATH_SITE .DS.'images'.DS.'stories'.DS.'jefaqcategory';
		if (isset($cert_file['name'])  && $cert_file['name'] != '') {

			$format  	 = strtolower(JFile::getExt($cert_file['name']));
    		$date  		 =& JFactory::getDate();
			$file_name	 = time().".".$format;
			$cert_filepath_new = $upload_directory . DS . $file_name;

			// Check whether the file in an image format..
			if($format != "jpeg" && $format != "jpg" && $format != "png" && $format != "gif") {
				$msg = JText::_('JE_NOTSAVED');
				JError::raiseWarning(100, $msg );
				$status = 'format';

				return $status;
			} else {
				if (!JFile::upload($cert_file['tmp_name'], $cert_filepath_new)) {
					$msg 	= JText::_('JE_NOTUPLOADED');
					JError::raiseWarning(500, $msg);
					$status = 'notupload';

					return $status;
				} else {

					$file = $cert_filepath_new;
		           	$save = $cert_filepath_new;

					$dimensions = $this->globalConfig();
		           	$modwidth    =  $dimensions->image_width ? $dimensions->image_width : 25 ;
		            $modheight   =  $dimensions->image_height ? $dimensions->image_height : 25 ;

					if ( $dimensions->resize == '1' ) {
						// Resize images..
						$this->resize($cert_filepath_new,$cert_filepath_new,$cert_file['type'],$modwidth,$modheight);
					}

					$photo 		 = $file_name;

					return $photo;
				}
			}
		}
	}

	// function for resize images
	function resize($sourcefile, $destinationfile, $type, $width, $height )
	{

		$img = false;
		switch ($type) {
		  case 'image/jpeg':
		  case 'image/jpg':
		  case 'image/pjpeg':
			$img = imagecreatefromjpeg($sourcefile);
			break;
		  case 'image/png':
			$img = imagecreatefrompng($sourcefile);
			break;
		  case 'image/gif':
			$img = imagecreatefromgif($sourcefile);
			break;
		}

		if(!$img) {
		  return false;
		}

		$curr = @getimagesize($sourcefile);
		if($curr[0] < $width ) {
			$height = (100 / ($curr[0] / $width)) * .01;
			$height = @round ($curr[1] * $height);
		}

		$nwimg = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($nwimg, 0, 0, 0);
        ImageColorTransparent($nwimg, $background);
		imagecopyresampled($nwimg, $img, 0, 0, 0, 0, $width, $height, $curr[0], $curr[1]);

		switch ($type)	{
		  case 'image/jpeg':
		  case 'image/jpg':
		  case 'image/pjpeg':
			imagejpeg($nwimg, $destinationfile);
			break;
		  case 'image/png':
			imagepng($nwimg, $destinationfile);
			break;
		  case 'image/gif':
			imagegif($nwimg, $destinationfile);
			break;
		}

		imagedestroy($nwimg);
		imagedestroy($img);

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