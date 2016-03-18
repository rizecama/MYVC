  <?php
/*echo "123<pre>";
print_r($_REQUEST);exit;*/
$countids=$_REQUEST['countids'];
$arr_counties = explode(',',$countids);
//echo "<pre>"; print_r($arr_counties);
$id=$_REQUEST['id'];
$path=$_REQUEST['path'];
$flag=$_REQUEST['flag'];
require_once($path."/configuration.php");
$obj= new JConfig;
$host = $obj->host;
$username = $obj->user;
$password = $obj->password;
$database = $obj->db;
$con = mysql_connect( $host, $username, $password) or die('Could not connect to server.' );
mysql_select_db($database, $con) or die('Could not select database.');
 $qry="SELECT * FROM jos_cam_counties WHERE State='$id' ORDER BY County"; 
$result = mysql_query($qry);
$countyList = array();
if($result) {
//$catList = mysql_fetch_array($result);
  while($row = mysql_fetch_array($result))
  {
 	 $countyList[]=$row;
  }
}

//echo $_GET['type'];

if($_GET['type']=="states")
{
		if($_GET['flag']=="1")
		{
			?>
             <div style="position:absolute; width:100px; margin-left:288px; margin-top: -10px; ">
            
             <img style="cursor:pointer" src="templates/camassistant_left/images/closecounty.gif" align="right"  onclick="closecounty('<?php echo $_GET['Fid'].$_GET['Len']; ?>')" /></div><?php } ?><select name="county[]" onchange="javascript:change();"  id="<?php echo $_GET['Fid']."_".$_GET['Len']; ?>" class="inputbox" style="width:252px"><option value="" >Please Select County</option><option value="<?php echo $id."_All";?>">All Counties</option>
			 <!--<option value="All">All Counties</option>-->
		 	<?php
			for($c=0;$c<count($countyList);$c++) 
			{
				$value = $countyList[$c]['id'];
				$text = $countyList[$c]['County'];
				?>				
				<option <?PHP if($arr_counties[$i] == $id."_".$value) { ?> selected="selected" <?PHP } ?>value="<?php echo $id."_".$value;?>"><?php echo $text;?></option>
				<?php
			} 
			?>	
			</select>
            
			
			<?php 

 }

if($_GET['type']=="morestates")
{
	mysql_select_db($database, $con) or die('Could not select database.');
	$stateqry="SELECT * FROM jos_state"; 
	$stateresult = mysql_query($stateqry);
	$stateList = array();
	if($stateresult) {
	//$catList = mysql_fetch_array($result);
	  while($row = mysql_fetch_array($stateresult))
	  {
		 $stateList[]=$row;
	  }
	}

		for($i=0;$i<$_GET['fieldcnt'];$i++) 
		{
			?>
			<input name="field_cnt<?php echo $i;?>" id="field_cnt<?php echo $i;?>" type="hidden" value="1"/>
			<div class="signup">
			<label>In what State are you licensed to do business?:<span class="redstar">*</span></label>
			<select style="width:282px;" name="stateid[]" id="stateid<?php echo $i;?>" onchange="javascript:getCounty(this.value,'','divmoreStates<?php echo $i;?>','field_cnt<?php echo $i;?>');">
			<option value="0">Please Select State</option>
			<?php  foreach($stateList as $slist) {  ?>
			<option value="<?php echo $slist['id']; ?>"><?php echo $slist['state_name']; ?></option>
			<?php } ?>
			</select>
			</div>
				 
			<div class="signup">
			<label>Specify County/Counties: <span class="redstar">*</span></label>
			<div id="divmoreStates<?php echo $i;?>" style="display:block">
			<div id="fields_div_1">
			<select style="width: 282px;" name="county[]" >
			<option value="0">Please Select County</option>
			<?php  foreach($countylist as $clist) {  ?>
			<option value="document.getElementById('stateid<?php echo $i;?>').value<?php echo "_".$clist->id; ?>"> <?php echo $clist->county_name; ?></option>
			<?php } ?>
			</select>
			</div><?php /*?><?php if($i != 0){?><div><a class="orange-links" href="javascript:void(0);" onclick="javascript: removeSpecificDiv('divmoreStates<?php echo $i;?>','divStates','field_cnt<?php echo $i;?>');">remove</a></div><?php }?><?php */?>
			</div>
			</div>
			<a href="javascript:void(0);" onclick="javascript: getCounty(document.getElementById('stateid<?php echo $i;?>').value,'1','divmoreStates<?php echo $i;?>','field_cnt<?php echo $i;?>');" class="orange-links"><img src="templates/camassistant_left/images/addanothercountry.gif" alt="add another country"  width="131" height="23" style="padding-top:10px;"/></a>
			<?php
		}
		
	?>			
<?php	
		
 }

mysql_close($con);

?>