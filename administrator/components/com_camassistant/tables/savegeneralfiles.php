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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * @package		Joomla
 * @subpackage	Banners
 */
class TableSavegeneralfiles extends JTable
{
	var $id			= null;
	var $vendorid  = null;
	var $rfpid     = null;
	var $proposalid      = null;
	var $proposal_type      = null;
	var $filename      = null;
	var $filepath      = null;
	var $upload_date      = null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__cam_generalfiles', 'id', $_db );
	}
}
?>

