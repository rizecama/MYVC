<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavelicinsurance extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industryid      = null;
	var $professional      = null;
	var $occupational      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_licinsurance_standards', 'id', $_db );

	}

}

?>

