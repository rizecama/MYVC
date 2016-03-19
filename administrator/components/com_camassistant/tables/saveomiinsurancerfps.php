<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveomiinsurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null;
	var $each_claim      = null;
	var $aggregate_omi      = null;
	var $certholder_omi      = null;
	var $createddate      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_errors_omissions_rfps', 'id', $_db );

	}

}

?>

