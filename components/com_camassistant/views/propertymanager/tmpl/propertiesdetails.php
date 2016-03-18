<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<style>
a:link {
    color: #7AB800;
    font-size: 12px;
    font-weight: bold;
    text-decoration: none;
	font-weight: bold; 
	text-align:center
}

</style>
<br />
<div id="i_bar_terms" style="margin-left:20px; margin-right:20px;">
<div id="i_bar_txt_terms" style="text-align:center">
<span> <font style="font-weight:bold; color:#FFF; font-size:15px;">PROPERTIES</font></span>
</div></div>
<div style="text-align:center; padding:20px; font-size:13px;"> 
<?php 
$properties = $this->propertynames;
//echo "<pre>"; print_r($this->propertynames); exit;
if($properties){
for($p=0; $p<=count($properties); $p++){ ?>
	 <a style=" color: #636363; font-size: 12px;font-weight: bold; text-decoration: none; font-weight: bold; font-size:14px;"><?php echo str_replace('_',' ',$properties[$p]->property_name); ?></a><br />
<?php } } else { 
echo "No properties have been assigned to this Manager.  You can revise who manages a property by clicking on 'My Properties'.";
}
?>
</div>
<?php 
exit;

?>
