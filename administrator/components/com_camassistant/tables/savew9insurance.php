<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavew9insurance extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industry_id      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_w9_standards', 'id', $_db );

	}

}

?>

