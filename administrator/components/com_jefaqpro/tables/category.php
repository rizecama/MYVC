<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class Tablecategory extends JTable
{
  var $id  		 		  = null;
  var $category  		  = null;
  var $alias     		  = null;
  var $ordering 		  = null;
  var $image     	      = null;
  var $image_position     = null;
  var $introtext	      = null;
  var $state     		  = null;

	function Tablecategory( &$db )
	{
		parent::__construct( '#__je_faq_category', 'id', $db );

	}
}
?>