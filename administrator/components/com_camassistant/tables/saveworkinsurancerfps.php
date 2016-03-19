<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveworkinsurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null;
	var $workers_not      = null;
	var $each_accident      = null;
	var $disease_policy      = null;
	var $disease_eachemp      = null;
	var $waiver_work      = null;
	var $certholder_work      = null;
	var $workers_accepted      = null;
	var $createddate      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_workers_standards_rfps', 'id', $_db );

	}

}

?>

