<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveoutsidevendor extends JTable

{

	

	var $id			= null;
	var $cust_id  = null;
	var $rfpid      = null;
	var $companyname      = null;
	var $contactname      = null;
	var $phonenumber      = null;
	var $emailid      = null;
	var $amount      = null;
	var $sumitdate      = null;
	
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_external_vendors', 'id', $_db );

	}

}

?>

