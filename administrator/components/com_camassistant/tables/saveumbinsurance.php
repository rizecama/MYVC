<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveumbinsurance extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industryid      = null;
	var $each_occur      = null;
	var $aggregate      = null;
	var $certholder_umbrella      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_umbrellainsurance_standards', 'id', $_db );

	}

}

?>

