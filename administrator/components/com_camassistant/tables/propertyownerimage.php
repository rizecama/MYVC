<?php

/**

 * @version		$Id: banner.php 10381 2008-06-01 03:35:53Z pasamio $

 * @package		Joomla

 * @subpackage	Banners

 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.

 * @license		GNU/GPL, see LICENSE.php

 * Joomla! is free software. This version may have been modified pursuant

 * to the GNU General Public License, and as distributed it includes or

 * is derivative of works licensed under the GNU General Public License or

 * other free or open source software licenses.

 * See COPYRIGHT.php for copyright notices and details.

 */

echo "can";exit;

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );



/**

 * @package		Joomla

 * @subpackage	Banners

 */

class Tablepropertyownerimage extends JTable

{

	

	var $id			= null;
	var $user_id			= null;
	var $propertyowner_image  = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_propertyowner_image', 'id', $_db );

	}

}

?>

