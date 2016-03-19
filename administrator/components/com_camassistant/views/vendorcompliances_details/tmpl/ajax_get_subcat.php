<?PHP
$catid = $_REQUEST['catid'];
$compliance = $_REQUEST['compliance'];
$PLN_title = $_REQUEST['PLN_title'];
$db =& JFactory::getDBO();
$query = "SELECT * FROM #__compliance_license_sub_categories WHERE cat_id = ".$catid." order by subcat_name";
$db->setQuery($query);
$res = $db->loadObjectList();
//echo $discount = $amount - $res;
?>
 <select name="PLN_type[]" id="PLN_type<?PHP echo $PLN_title; ?>" class="t_field" style=" width:170px;">
	   <option value="0">Select License Type</option>
	  <?PHP for($x=0; $x<count($res); $x++) { ?>
        <option value="<?PHP echo $res[$x]->id;?>" ><?PHP echo $res[$x]->subcat_name;?></option>
		<?PHP } ?>
<?PHP exit; ?>