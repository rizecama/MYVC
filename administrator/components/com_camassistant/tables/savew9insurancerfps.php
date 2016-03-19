<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavew9insurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_w9_standards_rfps', 'id', $_db );

	}

}

?>

