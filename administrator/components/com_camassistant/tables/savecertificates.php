<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavecertificates extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industryid      = null;
	var $propertyid      = null;
	var $filepath      = null;
	var $filename      = null;
	var $type      = null;
	var $upload_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_certificates', 'id', $_db );

	}

}

?>

