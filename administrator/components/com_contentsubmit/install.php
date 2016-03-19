<?php
/**
 * @version	1.5
 * @package	ContentSubmit
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

/***********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * REMOVE THE ADMIN MENU LINK
 * ---------------------------------------------------------------------------------------------
 ***********************************************************************************************/

	$database = JFactory::getDBO();
	$query = " UPDATE `#__components` SET `admin_menu_link` = '' WHERE `option` = 'com_contentsubmit' ";
	$database->setQuery( $query );
	$database->query();
