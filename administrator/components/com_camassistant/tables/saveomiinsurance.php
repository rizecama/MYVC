<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveomiinsurance extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industryid      = null;
	var $each_claim      = null;
	var $aggregate_omi      = null;
	var $certholder_omi      = null;
	var $createddate      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_errors_omissions', 'id', $_db );

	}

}

?>

