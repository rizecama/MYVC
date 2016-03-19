<?php


defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablesavegeneralinsurance extends JTable

{

	

	var $id			= null;
	var $masterid  = null;
	var $industry_id      = null;
	var $occur      = null;
	var $each_occurrence      = null;
	var $damage_retend      = null;
	var $med_expenses      = null;
	var $personal_inj      = null;
	var $general_aggr      = null;
	var $applies_to      = null;
	var $products_aggr      = null;
	var $waiver_sub      = null;
	var $primary_noncontr      = null;
	var $additional_insured      = null;
	var $cert_holder      = null;
	var $created_date      = null;
	
	function __construct( &$_db )

	{

		parent::__construct( '#__cam_master_generalinsurance_standards', 'id', $_db );

	}

}

?>

