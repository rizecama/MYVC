<script type="text/javascript">
G = jQuery.noConflict();
function getalert(){
	var maskHeight = G(document).height();
	var maskWidth = G(window).width();
	G('#masknans').css({'width':maskWidth,'height':maskHeight});
	G('#masknans').fadeIn(100);
	G('#masknans').fadeTo("slow",0.8);
	var winH = G(window).height();
	var winW = G(window).width();
	G("#submitnans").css('top',  winH/2-G("#submitnans").height()/2);
	G("#submitnans").css('left', winW/2-G("#submitnans").width()/2);
	G("#submitnans").fadeIn(2000);
	G('.windownans #closenans').click(function (e) {
	e.preventDefault();
	G('#masknans').hide();
	G('.windownans').hide();
	});
}
</script>
<style>
#masknans { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesnans .windownans {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesnans #submitnans {  width:452px;  height:131px;  padding:10px;  background-color:#ffffff;}
#boxesnans #submitnans a{ text-decoration:none; color:#609e00; font-size:13px; font-weight:bold;}
#boxesnans #submitnans a:hover{ text-decoration:underline; color:#609e00; font-size:13px; font-weight:bold;}
#donenans {  border: 0 none;  color: #000000;  cursor: pointer;  float: left;  font-size: 20px;  font-weight: bold;  margin: 0 auto;  padding: 0;  text-align: left;  width: 49%;}
#closenans {  border: 0 none;  cursor: pointer;  text-align: center; }
</style>

<?php
error_reporting(0);
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
//To get the rating
$user = JFactory::getUser();
$db = & JFactory::getDBO();

	if($user->user_type == 13){
	$getfirmimage = "SELECT comp_logopath FROM `#__cam_customer_companyinfo`  where cust_id=".$user->id." ";
	$db->setQuery($getfirmimage);
	$firmlogo = $db->loadResult();
	}
	else{
	$getcid = "SELECT comp_id FROM `#__cam_customer_companyinfo`  where cust_id=".$user->id." ";
	$db->setQuery($getcid);
	$cid = $db->loadResult();
	$firmid = "SELECT cust_id FROM `#__cam_camfirminfo`  where id=".$cid." ";
	$db->setQuery($firmid);
	$firm_id = $db->loadResult();
	$getfirmimage = "SELECT comp_logopath FROM `#__cam_customer_companyinfo`  where cust_id=".$firm_id." ";
	$db->setQuery($getfirmimage);
	$firmlogo = $db->loadResult();
	}
	if($user->user_type == 16){
	$getfirmimage = "SELECT propertyowner_image  FROM `#__cam_propertyowner_image`  where user_id=".$user->id." ";
	$db->setQuery($getfirmimage);
	$firmlogo = $db->loadResult();
	}
	$path2 = $siteURL."components/com_camassistant/assets/images/properymanager/";
	$path1 = $firmlogo;
	if($path1){
	$path1 = $path1 ;
	}
	else {
	$path1 = 'emptylogo.jpg' ;
	}
	$image = $path2.$path1;	
	$image = str_replace(' ','%20',$image);
	$apath= getimagesize($image);
	$height_orig=$apath[1];
	$width_orig=$apath[0];
	$aspect_ratio = (float) $height_orig / $width_orig;
	$thumb_width =220;
	$thumb_height = round($thumb_width * $aspect_ratio);
	if($thumb_height == 0){
	$thumb_height = '220';
	}		
	?>
	<div style="margin-left:0px">
	<?php if($path1 == 'emptylogo.jpg' && $user->user_type == '13'){ ?>
	<a href="index2.php?option=com_camassistant&controller=propertymanager&task=getuploadpopup" rel="{handler: 'iframe', size: {x: 500, y: 300}}" class="modal"><img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" /></a>
	<?php } else if($user->user_type == '13') { 
	?>
	<a href="index2.php?option=com_camassistant&controller=propertymanager&task=getuploadpopup" rel="{handler: 'iframe', size: {x: 500, y: 300}}" class="modal"><img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" /></a>
	<?php }
	 else if($user->user_type == '16') { 
	?>
	<a href="index2.php?option=com_camassistant&controller=propertymanager&task=getuploadpopup" rel="{handler: 'iframe', size: {x: 500, y: 300}}" class="modal"><img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" /></a>
	<?php } 
	else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } 
	?>
	</div>
	<?php if($path1 ){ ?>
	<div style="margin-top:10px; padding-top:10px;" id="topborder_row"></div>
	<?php } ?>
	
	<div id="boxesnans" style="top:576px; left:582px;">
<div id="submitnans" class="windownans" style="top:300px; left:582px; border:6px solid #609e00; position:fixed">
<div style="text-align:justify"><p class="namessagetext_upload">The file you are trying to upload exceeds the 5MB limit. Please upload a different file or <a href="http://smallpdf.com/compress-pdf" target="_blank">CLICK HERE</a> to reduce the size.</p>
</div>
<div align="center">
<div id="closenans"  name="closenans" value="Cancel" class="oknewsmall_upload"></div>
</div>
</div>
  <div id="masknans"></div>
</div>