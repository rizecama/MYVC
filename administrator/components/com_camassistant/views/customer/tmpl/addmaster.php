<script type="text/javascript">
function validate(){
	if(document.getElementById('masterid').value == '0') {
	alert("Please select a master firm from dropdown list." );
	}
	else{
	document.forms["addmasterform"].submit();
	}
}
</script>
<?php
$firmdata = $this->firmdata ;
$masters = $this->masters ;
?>

<link href="<?php echo JURI::root(); ?>administrator/templates/khepri/css/popup.css" rel="stylesheet" type="text/css"/>
<div class="firmdetails" align="center">
<form action="" method="post" name="addmasterform" id="addmasterform">
<table cellpadding="5" cellspacing="5" style="padding-top: 50px; padding-left: 20px;">

<tr class="table_blue_row"><td><h1 style="color:#79B700;">Firm Details</h1></td></tr>
<tr><td><?php echo $firmdata->comp_name ; ?></td></tr>
<tr><td><?php echo $firmdata->mailaddress ; ?></td></tr>
<tr><td><?php echo $firmdata->comp_phno ; ?></td></tr>
<tr><td><h1 style="color:#79B700;">Master Firm List</h1></td></tr>
<tr><td>
<select name="masterid" id="masterid">
<option value="0">Select Master Firm</option>
<?php
for( $i=0; $i<count($masters); $i++ ){ ?>
<option value="<?php echo $masters[$i]->id; ?>"><?php echo $masters[$i]->comp_name . ' - ' . $masters[$i]->name. ' ' . $masters[$i]->lastname; ?></option>	
<?php }
?>
</select>
</td></tr>
<tr>
<td><input type="button" value="SUBMIT" onclick="javascript:validate();" /></td>
</tr>
</table>
<input type="hidden" name="controller" value="customer" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="assignfirm" />
</form>
</div>
<?php
exit;
?>