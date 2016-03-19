<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveumbinsurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null;
	var $each_occur      = null;
	var $aggregate      = null;
	var $certholder_umbrella      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_umbrellainsurance_standards_rfps', 'id', $_db );

	}

}

?>

