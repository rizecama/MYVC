<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavelicinsurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null;
	var $professional      = null;
	var $occupational      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_licinsurance_standards_rfps', 'id', $_db );

	}

}

?>

