<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class sortingController extends JController
{

	function __construct()
	{
		parent::__construct();
	}

	function display()
	{
		parent::display();
	}
	
	//function to display all draft proposal
	function sorting_rfps_by_propert()
	{
		JRequest::getVar('view','sorting');
	    parent::display();
	}
	
	
}
?>