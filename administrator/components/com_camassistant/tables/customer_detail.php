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
class Tablecustomer_detail extends JTable
{
	var $id = null;
	var $cust_id = null;
	var $comp_id = null;
	var $camfirm_license_no = null;
    var $comp_name = null;
    var $tax_id = null;
	var $mailaddress = null;
    var $comp_city = null;
	var $comp_state = null;
	var $comp_zip = null;
	var $comp_phno = null;
	var $comp_extnno = null;
	var $comp_alt_phno = null;
	var $comp_alt_extnno = null;
	var $comp_website = null;
	var $comp_logopath = null;
	var $is_providing_proposals = null;
	var $is_manage_cproperties = null;
	var $status = null;
	var $activation = null;
	var $published = null;

	function __construct( &$_db )
	{
		parent::__construct('#__cam_customer_companyinfo', 'id', $_db);

	}

	function clicks()
	{
		$query = 'UPDATE #__banner'
		. ' SET clicks = ( clicks + 1 )'
		. ' WHERE bid = ' . (int) $this->bid
		;
		$this->_db->setQuery( $query );
		$this->_db->query();
	}

	/**
	 * Overloaded check function
	 *
	 * @access public
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check()
	{
		// check for valid client id
		if (is_null($this->cid) || $this->cid == 0) {
			$this->setError(JText::_( 'BNR_CLIENT' ));
			return false;
		}

		// check for valid name
		if(trim($this->name) == '') {
			$this->setError(JText::_( 'BNR_NAME' ));
			return false;
		}

		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);

		/*if(trim($this->imageurl) == '') {
			$this->setError(JText::_( 'BNR_IMAGE' ));
			return false;
		}
		if(trim($this->clickurl) == '' && trim($this->custombannercode) == '') {
			$this->setError(JText::_( 'BNR_URL' ));
			return false;
		}*/

		return true;
	}
}
?>
