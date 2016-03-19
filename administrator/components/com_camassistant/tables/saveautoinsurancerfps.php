<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesaveautoinsurancerfps extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $rfpid      = null; 
	var $applies_to_any      = null;
	var $applies_to_owned      = null;
	var $applies_to_nonowned      = null;
	var $applies_to_hired      = null;
	var $applies_to_scheduled      = null;
	var $combined_single      = null;
	var $bodily_injusy_person      = null;
	var $bodily_injusy_accident      = null;
	var $property_damage      = null;
	var $waiver      = null;
	var $primary      = null;
	var $additional_ins      = null;
	var $cert_holder      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_autoinsurance_standards_rfps', 'id', $_db );

	}

}

?>

