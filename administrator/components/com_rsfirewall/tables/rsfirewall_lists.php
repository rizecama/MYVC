<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

class TableRSFirewall_Lists extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	var $ip = null;
	var $type = null;
	var $reason = null;
	var $date = null;
	var $published = 1;
		
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableRSFirewall_Lists(& $db)
	{
		parent::__construct('#__rsfirewall_lists', 'id', $db);
	}
}