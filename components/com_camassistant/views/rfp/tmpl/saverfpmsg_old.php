<script type="text/javascript">
window.load(G('.inviteavendor').html('<img src="templates/camassistant_left/images/loading_icon.gif">'));
</script>

<?php
$globals = $this->globals ;
error_reporting(0); 
$statelist = $this->statelist;
$difference = JRequest::getVar('var',''); 
$ownids = $this->ownprefs;
$db = & JFactory::getDBO(); 
$rfpidval = JRequest::getVar('rfpid','');
$total_invites = "SELECT * FROM #__rfp_invitations  where rfpid=".$rfpidval." ";
$db->Setquery($total_invites);
$totalinvites = $db->loadObjectList();
$count_inv = count($totalinvites) ;
$existing_stand = $this->rfp_stand; 
 ?>
 	
	
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->baseurl ?>/templates/camassistant_left/css/stylesheet.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
function fn_submitvendorsform(){
PR = jQuery.noConflict();
var frm=document.vendorsform;
incount = 0;
var closei = '<?php echo $difference; ?>' ;
var preinvites = '<?php echo $count_inv; ?>' ;
 str = '';
var totalboxes = document.getElementsByName('selectdvendors[]')
var length = totalboxes.length;
 	if(frm.elements["selectdvendors[]"]){
    for(x=0; x<length; x++){
        if(totalboxes[x].checked==true){
        str += totalboxes[x].value + ',';
        incount++;
        }
    }
	}
	
	if(incount<=0 && closei == 'closeinvite'){
	alert("Please invite at least one vendor.");
	}
   else{
   		if(incount == 0 && preinvites == 0 ){
	   		PR('body,html').animate({
				scrollTop: 250
				},800);
		var maskHeight = PR(document).height();
		var maskWidth = PR(window).width();
		PR('#maskemp').css({'width':maskWidth,'height':maskHeight});
		PR('#maskemp').fadeIn(100);
		PR('#maskemp').fadeTo("slow",0.8);
		var winH = PR(window).height();
		var winW = PR(window).width();
		
		PR("#submitemp").css('top',  winH/2-PR("#submitemp").height()/2);
		PR("#submitemp").css('left', winW/2-PR("#submitemp").width()/2);
			
		PR("#submitemp").fadeIn(2000);
       	PR('.windowemp #doneemp').click(function (e) {
		e.preventDefault();
		PR('#maskemp').hide();
		PR('.windowemp').hide();
		frm.submit();
		});
		PR('.windowemp #closeemp').click(function (e) {
		e.preventDefault();
		PR('#maskemp').hide();
		PR('.windowemp').hide();
		});
		
	   }
	   else {
		frm.submit();
		}
	}
}
//Check box clicking function
function submitvendorsformcheckbox(){
PR = jQuery.noConflict();
var frm=document.vendorsform;
incount1 = 0;
 str1 = '';
    for(y=0; y<frm.elements["selectdvendors[]"].length; y++){
        if(frm.elements["selectdvendors[]"][y].checked==true){
        str1 = frm.elements["selectdvendors[]"][y].value;
        incount1++;
        }
    }
	
}
function county(){
H = jQuery.noConflict();
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=rfp&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
if(data.length == '46'){
H("#divcounty").css("opacity",'0.5');
}
else{
H("#divcounty").css("opacity",'');
}
H("#divcounty").html(data);
H("#divcounty").val('<?php echo $_REQUEST['divcounty']; ?>');
}
});
var ownfrm = document.ownvendors;
ownfrm.submit();
}
function county_pre(){
H = jQuery.noConflict();
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=rfp&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
if(data.length == '46'){
H("#divcounty").css("opacity",'0.5');
}
else{
H("#divcounty").css("opacity",'');
}
H("#divcounty").html(data);
H("#divcounty").val('<?php echo $_REQUEST['divcounty']; ?>');
}
});
}
function speccounty(val)
{
	var ownfrm = document.ownvendors;
	ownfrm.submit();
}
function specindus(val)
{
	var ownfrm = document.ownvendors;
	ownfrm.submit();
}
function invitevendor(rfpid){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=rfpcenter&task=getinvitation&rfpid='+rfpid;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:600}}"))
SqueezeBox.fromElement(el,options);
}
</script>
<script type="text/javascript">
		
		G = jQuery.noConflict();
		G(function(){
		G('.sponsored').click(function(){
		if(G(this).is(":checked")){
		vendorid = G(this).val();
			G('body,html').animate({
			scrollTop: 250
			},800);
			var maskHeight = G(document).height();
			var maskWidth = G(window).width();
			G('#maskwm').css({'width':maskWidth,'height':maskHeight});
			G('#maskwm').fadeIn(100);
			G('#maskwm').fadeTo("slow",0.8);
			var winH = G(window).height();
			var winW = G(window).width();
			G("#submitwm").css('top',  winH/2-G("#submitwm").height()/2);
			G("#submitwm").css('left', winW/2-G("#submitwm").width()/2);
			G("#submitwm").fadeIn(2000);
			G('.windowwm #donewm').click(function (e) {
				e.preventDefault();
				G('#maskwm').hide();
				G('.windowwm').hide();
			});
			G('.windowwm #closewm').click(function (e) {
				G('#vendors'+vendorid).prop('checked', false);
				e.preventDefault();
				G('#maskwm').hide();
				G('.windowwm').hide();
			});
		}
		});
});

function unverified(vendorid,type){
if(type == 'unverified')
var height = '290';
if(type == 'both')
var height = '350';
else
var height = '245';
var el ='index.php?option=com_camassistant&controller=rfpcenter&task=vendortype&vendorid='+vendorid+'&type='+type;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
SqueezeBox.fromElement(el,options);
}

function senderrormsg(){
	alert("This Vendor has been Blocked by your Company's Master Account holder");
}

</script>

<style>
#maskemp {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesemp .windowemp {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesemp #submitemp {  width:368px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesemp #submitemp a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneemp {border:0 none; cursor:pointer; height:30px; margin:0 24px 0 0; float:right }
#closeemp { border:0 none; cursor:pointer; height:30px; margin:0 0 0 10px; color:#000000; font-weight:bold; font-size:20px;}

</style>
<style>
#maskwm {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxeswm .windowwm {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxeswm #submitwm {  width:426px;  height:135px;  padding:10px;  background-color:#ffffff;}
#boxeswm #submitwm a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donewm {border:0 none;cursor:pointer;height:30px;margin-right:80px;padding:0; color:#000000; font-weight:bold; font-size:20px;}
#closewm {border:0 none;cursor:pointer;height:30px;margin-left:88px;padding:0;float:left;}
</style>
<?php 
$close = JRequest::getVar('var','');
$rfpidc = JRequest::getVar('rfpid','');
if($close != 'closeinvite'){ ?>
<div align="center"><img src="templates/camassistant_left/images/step2.jpg" /></div>
<p style="height:40px;"></p>
<?php } ?>
<div id="add-vendor">
<div class="clr"></div>

<div id="preferred">
<div id="preferred-vendorsfirst">
<div class="clr"></div>

<div class="preferredvendors-head">
<h5 style="background:none; text-align:center">INVITE VENDORS</h5>
</div>
<?php
$user=JFactory::getUser();
if($user->user_type=='13'){
$itemid = '216';
}
else{
$itemid = '217';
}
?>
<p class="inviteavendor"></p>
<p style="margin-top:5px;">Based on the information and requirements you entered in STEP 1, below is a list of Vendors that are qualified to provide you a quote.  You can select a Vendor by clicking on the checkmark box to the left of each Company.  Any Vendors that you select on this page will be sent a personal invitation to provide a quote for your request, with the ability to accept or decline the invitation.</p>
<p style="margin-top:5px;">Note: If you do NOT see enough, or any, Vendors on this page, we suggest you revise the information (industry, insurance + licensing requirements) entered in STEP 1 and/or personally <a class="hoverinvitevendors" href="index.php?option=com_camassistant&controller=vinvitations&Itemid=<?php echo $itemid; ?>">INVITE VENDORS</a> to join MyVendorCenter.com.</p>
<div class="clr"></div>
</div>
<br /><br />
<?php
if($_REQUEST['var'] == 'closeinvite')
$disp = '';
else
$disp = 'none';
?>
<div style="display:<?php echo $disp; ?> ">
<br /><br />
<form action="" method="post" name="ownvendors" id="ownvendors">

<select name="state" style="width:170px; margin-left:0px;margin-right:5px; word-wrap:normal;" id="stateid" onchange="javascript:county();" >
			 <option value="0">Select State</option>
			<?php
			for ($i=0; $i<count($statelist); $i++){
			$states = $statelist[$i];   ?>
			<option  value="<?php echo $states->state_id; ?>" <?php if($states->state_id==$_REQUEST['state']){ ?> selected="selected" <?php } ?> ><?php echo $states->state_name; ?> </option>
			<?php }  ?>
	  </select>
	  <select style="width: 170px; margin-left:0px;margin-right:5px; word-wrap:normal; opacity:0.5" name="divcounty" id="divcounty" onchange="javascript:speccounty()" >
<option value="">Select County</option>
</select>
 <script type="text/javascript">
county_pre();
</script>
<select style="margin-left:0px; width:317px;margin-right:0px; word-wrap:normal;" name="industrytype" onchange="javascript:specindus('')">
      <option value="">All Industries</option>
	  <?php
	  for($i=0; $i<count($this->industries); $i++){
	  ?> 
<option <?php if($_REQUEST['industrytype'] == $this->industries[$i]->id){ echo "selected"; } ?> value="<?php echo $this->industries[$i]->id; ?>"> <?php echo $this->industries[$i]->industry_name; ?>  </option>
	  <?php }
	  ?>
      </select>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfp" name="controller">
<input type="hidden" value="saverfpmsg1" name="task">
	  </form>
	   </div>
<p style="height:5px"></p>
<form action="" method="post" name="vendorsform" id="vendorsform">
<?php /*?><div class="preferredvendorsvendors-head">
<h5>SPONSORED VENDORS</h5>
</div>
<p style="font-weight:bold; margin-left:24px">SELECT</p>
<div align="right" style="margin-top:5px; padding-top:5px;" id="topborder_row"></div>
<?php 
$items_sponsor = $this->sponsor;
$items = $this->sponsor;
$items1 = $this->sponsor;
$sp1 = 0;
foreach($items1 as $am1 ) { 
	if($am1->vendorstatus == 'eligible'){
	$sp1++;
	}
}


$rfpid = JRequest::getVar('rfpid','');
$var = JRequest::getVar('var','');
//echo "<pre>"; print_r($items);
//echo $sp1; 
if($items) {
if($sp1 > 3){
shuffle($items) ;
}
$sp = 0;
foreach($items as $am ) {  
//echo $sp;
if($sp < 3){
if($am->vendorstatus == 'eligible'){
$sp++;
?> 
 	<div id="preferredvendorsinvitations" style="padding:6px; height:80px;">
   <div class="search-panel-middlepre">
    <?php if($am->pre == 'yes'){ $checked = 'checked'; } else { $checked = ''; } ?>
   	  <?php if($am->vendorstatus == 'eligible' && $am->suspend != 'suspend'){ ?>
	  	<?php if($am->pre == 'yes'){ 
			$decline = "SELECT id from #__cam_vendor_proposals where proposedvendorid=".$am->id." and rfpno=".$rfpid." ";
			$db->setQuery($decline);
			$invitestatus = $db->loadResult();
			$dec = "SELECT not_interested from #__cam_vendor_availablejobs where user_id=".$am->id." and rfp_id=".$rfpid." ";
			$db->setQuery($dec);
			$decline = $db->loadResult();
			$invitationlis = "SELECT id from #__rfp_invitations where vendorid=".$am->id." and rfpid=".$rfpid." ";
			$db->setQuery($invitationlis);
			$invitationlist = $db->loadResult();
			if($invitestatus || ($decline != '2' && $invitationlist) ){
			echo "<span style='color:green; font-weight:bold; margin-left:-6px;'>Invited</span>";
			}
			else if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else{
			}
		}  
		else { ?>
      <input type="checkbox" value="<?php echo  $am->id; ?>" name="selectdvendors[]" <?php echo $checked; ?> id="vendors<?php echo  $am->id; ?>" onclick="submitvendorsformcheckbox();" />
	  <?php } ?><br />
	  
	  <?php //$checked = '';?>
	  <?php } 
	  elseif( $am->suspend == 'suspend' ){
	  echo "<span style='color:red; font-weight:bold;'>Suspended</span>";
	  }
	  else {
	  echo "<span title='This Vendor needs to ACTIVATE their account to receive an invite' style='color:red; font-weight:bold;'>INACTIVE</span>";
		}  ?> 
	      </div>
    <div class="search-panel-left">
      <ul>
        <li><strong><?php echo $am->company_name; ?></strong></li>
        <li><?php echo $am->name; ?> <?php echo $am->lastname; ?>: <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo $am->phone_ext; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
	<li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        
        <li><a style="color:gray; font-weight:normal"  href="mailto:<?php echo $am->email; ?>?cc=support@myvendorcenter.com"><?php echo $am->email; ?></a></li>
        </ul>
      </div>
	 
    <div class="search-panel-right">
	<?php
	$db = & JFactory::getDBO();
$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
		if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}
	
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'10.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'20.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'30.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'40.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			$total = 0; ?>
			<img width="130" src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
			<br /><p align="center" style="margin-top:5px;"><?php echo $rating; ?> out of 5 </p>			
	</div>
    <div class="clr"></div>
  </div>
    <?php } 
	} 
	}
	}
	?> 
	
	
	<!-- For company wide vendors -->
	
	<br /><br /><br /><br /><?php */?>
<?php /*?><div class="preferredvendorsvendors-head">
<h5 style="background:none; text-align:center">MY PREFERRED VENDORS</h5>
</div>
<?php */?>
<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">MY PREFERRED VENDORS </font></span>
</div></div>
<?php
$star_vendors = $this->corporate ;
if($star_vendors){
	foreach($star_vendors as $star){
		$stars[] = $star->v_id;
	}
}
?>
  
  	<?php
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	if( $sort == 'asc' && $type == 'preferred' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'preferred' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}

	?>
	
  
<div id="heading_vendors">
<div class="checkbox_vendor">SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=rfp&rfp_type=review&rfpid=<?php echo $rfpidval ; ?>&task=saverfpmsg1&Itemid=88&sort=<?php echo $sort ; ?>&type=preferred">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor">COMPLIANCE STATUS</div>
</div>


<?php 
$items = $this->items;
 $rfpid = JRequest::getVar('rfpid','');
 $var = JRequest::getVar('var','');
 
		if( $items_sponsor ){
			foreach($items_sponsor as $sid){
				$sponsor[] = $sid->id;
			}
		}
		else{
			$sponsor[] = '';
		}
		
if($items) {
foreach($items as $am ) {  
//if(in_array($am->v_id, $sponsor) || $am->vendorstatus == 'ineligible') {
if($am->vendorstatus == 'ineligible') {
$display = 'none';
}
else {
$display = '';
}

?> 

<?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && $am->special_requirements == 'fail' ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->special_requirements == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}
			
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	

			if($am->special_requirements == 'fail') {
			$onclick = 'getwarningpopup';
			$class = 'sponsored';
			}
			else {
			$onclick = 'submitvendorsformcheckbox';
			$class = '';
			}
				
?>			 


 	<div id="preferredvendorsinvitations" style="padding:6px; display:<?php echo $display; ?>">
   <div class="search-panel-middlepre checkbox_vendor">
    <?php if($am->pre == 'yes'){ $checked = 'checked'; } else { $checked = ''; } ?>
   	  <?php if($am->vendorstatus == 'eligible' && $am->suspend != 'suspend'){ ?>
	  	<?php 
			$decline = "SELECT id, proposaltype from #__cam_vendor_proposals where proposedvendorid=".$am->v_id." and rfpno=".$rfpid." ";
			$db->setQuery($decline);
			$invite = $db->loadObject();
			$invitestatus = $invite->id;
			$invite_un = $invite->proposaltype;
			
			$dec = "SELECT not_interested from #__cam_vendor_availablejobs where user_id=".$am->v_id." and rfp_id=".$rfpid." ";
			$db->setQuery($dec);
			$decline = $db->loadResult();
			$invitationlis = "SELECT id from #__rfp_invitations where vendorid=".$am->v_id." and rfpid=".$rfpid." ";
			$db->setQuery($invitationlis);
			$invitationlist = $db->loadResult();
			if($am->pre == 'yes' && $checkbox == 'show'){ 
				if($decline == '2'){
				echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
				}
				else if($invitestatus || ($decline != '2' && $invitationlist) ){
					if( $invite_un != 'uninvited' ) 
				echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
				else { ?>
				<input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo  $class; ?>" name="selectdvendors[]" id="vendors<?php echo  $am->v_id; ?>"/>
				<?php }
				}
				else{
				}
			
			}  
		else if($am->subscribe != 'yes'){
		echo "<span title='This Vendor needs to ACTIVATE their account to receive an invite' style='color:red; font-weight:bold;'>INACTIVE</span>";
		}  
		else if($invitestatus && $am->pre != 'yes'){
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else{
			echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
			}
		}
		else {
			if($am->special_requirements == 'fail') {
			$onclick = 'getwarningpopup';
			$class = 'sponsored';
			}
			else {
			$onclick = 'submitvendorsformcheckbox';
			$class = '';
			}
		 ?>

		 <?php if( $checkbox != 'show' )	{ ?>
	  <a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'<?php echo $args; ?>');" title="Click for more info"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
		 else if($am->excluded == '') { ?>
      <input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo  $class; ?>" name="selectdvendors[]" <?php echo $checked; ?> id="vendors<?php echo  $am->v_id; ?>"/>
	  <?php } else { ?>
			<a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
			<?php } ?>
			
	  <?php } ?>
	  
	  <?php //$checked = '';?>
	  <?php } 
	  elseif( $am->suspend == 'suspend' ){
	  echo "<span style='color:red; font-weight:bold;'>Suspended</span>";
	  }
	  else {
	  echo "<span style='color:red; font-weight:bold;'>INELIGIBLE</span>";
		}  ?> 
	      </div>
     <div class="search-panel-left_rfp company_vendor">
	
      <ul>
        <li><strong>
		<?php 
	if($stars) {
		if (in_array($am->v_id, $stars)){ ?>
		<img src="templates/camassistant_left/images/star-icon.png" title="Corporate Preferred Vendor" />
		<?php }
		else{
		}
	}	
		?>
		
		<a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->v_id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name; ?> <?php echo $am->lastname; ?>: <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.".$am->phone_ext; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
	<li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        
        <li><a style="color:gray; font-weight:normal"  href="mailto:<?php echo $am->inhousevendors; ?>?cc=support@myvendorcenter.com"><?php echo $am->inhousevendors; ?></a></li>
        </ul>
		
		
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->v_id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
		if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}
	
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'10.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'20.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'30.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'40.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';} 
			$total = 0; ?>
			<img width="130" src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
			
	</div>
	
	<div class="search-panel-image_rfp compliant_vendor">
	  <?php 
	  		if($existing_stand == 'no'){
				$compliant_id = "nostandards";
				$images_text = 'N/A';
			}
			else {
			
				if($am->special_requirements == 'fail') {
				//$images_text = 'NON-COMPLIANT';
				$compliant_id = "noncompliant";
				$title = 'Non-Compliant';
				}
				else {
				//$images_text = 'COMPLIANT';
				$compliant_id = 'compliant';			
				$title = 'Compliant';
				}
			}	
			?>
	  <p align="center" style="color:<?php echo $spe_color; ?>; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
	   <?php if($globals != 'fail'){ ?>
			<a id="<?php echo $compliant_id; ?>" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 700}}" href="index.php?option=com_camassistant&controller=rfp&task=getcompliance&rfpid=<?php echo $rfpid; ?>&vendorid=<?php echo $am->v_id; ?>" title="<?php echo $title ; ?>"><?php echo $images_text ; ?></a>
			<?php } else {
			echo "N/A";
			}?>
			 </p>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			 
	  </div>
	  
    <div class="clr"></div>
  </div>
    <?php } 
	} 
	
	?> 
		
	
	<!-- For corporate vendors -->
	<?php
	$corporate = $this->corporate; 
	//echo "<pre>"; print_r($corporate); echo "</pre>";
	if($corporate){
		foreach($corporate as $cor){
		$corporates[] = $cor->v_id;
		}
	}
	?>
		<?php if($user->accounttype != 'master'){ ?>
<br /><br /><br /><br />
	
	<?php
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	if( $sort == 'asc' && $type == 'corporate' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'corporate' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}

	?>
	
<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">CORPORATE PREFERRED VENDORS</font></span>
</div></div>

<div id="heading_vendors">
<div class="checkbox_vendor">SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=rfp&rfp_type=review&rfpid=<?php echo $rfpidval ; ?>&task=saverfpmsg1&Itemid=88&sort=<?php echo $sort ; ?>&type=corporate">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor">COMPLIANCE STATUS</div>
</div>
	
	<?php
	
//echo "<pre>"; print_r($corporate); echo "</pre>";
if($corporate){
foreach($corporate as $am ) {  
	if($ownids || $am){
				if (in_array($am->v_id, $ownids) || $am->vendorstatus == 'ineligible')
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}
?> 
 	<div id="preferredvendorsinvitations" style="padding:6px; display:<?php echo $display; ?>">
   <div class="search-panel-middlepre checkbox_vendor">

<?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && $am->special_requirements == 'fail' ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->special_requirements == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}
			
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	
?>	

   
    <?php if($am->pre == 'yes'){ $checked = 'checked'; } else { $checked = ''; } ?>
    <?php if($am->vendorstatus == 'eligible' && $am->vendorstatus != 'suspend'){ ?>
		<?php 
			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_comp = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_comp = "";
			}
					
			$decline = "SELECT id, proposaltype from #__cam_vendor_proposals where proposedvendorid=".$am->v_id." and rfpno=".$rfpid." ";
			$db->setQuery($decline);
			$invitecor = $db->loadObject();
			$invitestatus = $invitecor->id;
			$invite_un = $invitecor->proposaltype;
			
			$dec = "SELECT not_interested from #__cam_vendor_availablejobs where user_id=".$am->v_id." and rfp_id=".$rfpid." ";
			$db->setQuery($dec);
			$decline = $db->loadResult();
			$invitationlis = "SELECT id from #__rfp_invitations where vendorid=".$am->v_id." and rfpid=".$rfpid." ";
			$db->setQuery($invitationlis);
			$invitationlist = $db->loadResult();
		if($am->pre == 'yes' && $checkbox == 'show'){ 
			if($decline == '2'){
				echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else if($invitestatus || ($decline != '2' && $invitationlist) ){
				if( $invite_un != 'uninvited' )
				echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
				else{ ?>
					<input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo $class_comp; ?>" name="selectdvendors[]" id="vendors<?php echo  $am->v_id; ?>" />
				<?php }
			}
			else{
			}
		}  
		
 
						
		else if($am->subscribe != 'yes'){
		echo "<span title='This Vendor needs to ACTIVATE their account to receive an invite' style='color:red; font-weight:bold;'>INACTIVE</span>";
		} 
		else if($invitestatus && $am->pre != 'yes'){
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else{
			echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
			}
		}
		else { 
			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_comp = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_comp = "";
			}
		?>
		
		<?php if( $checkbox != 'show' )	{ ?>
	  <a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'<?php echo $args; ?>');" title="Click for more info"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
		else if($am->excluded == '') { ?>
      <input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo $class_comp; ?>" name="selectdvendors[]" <?php echo $checked; ?> id="vendors<?php echo  $am->v_id; ?>" />
	  <?php } else { ?>
			<a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
			<?php } ?>
			
	  <?php } ?>
	  <br />
	  <?php } 
	  elseif($am->vendorstatus == 'suspend'){
	  echo "<span style='color:red; font-weight:bold;'>Suspended</span>";
	  }
	  else {
	  echo "<span style='color:red; font-weight:bold;'>INELIGIBLE</span>";
		}  ?> 
      </div>
    <div class="search-panel-left_rfp company_vendor">
	
      <ul>
        <li><strong><img src="templates/camassistant_left/images/star-icon.png" title="Corporate Preferred Vendor" /><a style="margin-left:2px;" href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->v_id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name; ?> <?php echo $am->lastname; ?>: <?php echo $am->company_phone; ?>	<?php if($am->phone_ext) { echo "&nbsp;Ext.&nbsp;".$am->phone_ext ; }  ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="color:gray; font-weight:normal" href="mailto:<?php echo $am->inhousevendors; ?>?cc=support@myvendorcenter.com"><?php echo $am->inhousevendors; ?></a></li>
        </ul>
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->v_id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
		if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}
	
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'10.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'20.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'30.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'40.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			$total = 0; ?>
			<img width="130" src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
			
	</div>
	
	<div class="search-panel-image_rfp compliant_vendor">
	<?php 
			if($am->special_requirements == 'fail'){
			$compliant_id = "noncompliant";
			//$images_text = 'NON-COMPLIANT';
			$title = 'Non-Compliant';
			}
			else {
			//$images_text = 'COMPLIANT';
			$compliant_id = "compliant";
			$title = 'Compliant';
			}
			?>
	 <p align="center" style="color:<?php echo $spe_color; ?>; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
	 <?php if($globals != 'fail'){ ?>
			<a id="<?php echo $compliant_id; ?>" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 700}}" href="index.php?option=com_camassistant&controller=rfp&task=getcompliance&rfpid=<?php echo $rfpid; ?>&vendorid=<?php echo $am->v_id; ?>" title="<?php echo $title; ?>"><?php echo $images_text ; ?></a>
			<?php } else {
			echo "N/A";
			}?>
<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>

			 </p>
	  </div>
	  
    <div class="clr"></div>
  </div>
    <?php } 
	}
}
	?>
	<br /><br /><br /><br />

<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">CO-WORKER PREFERRED VENDORS</font></span>
</div></div>

	<?php
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	if( $sort == 'asc' && $type == 'coworker' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'coworker' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}

	?>
	
<div id="heading_vendors">
<div class="checkbox_vendor">SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=rfp&rfp_type=review&rfpid=<?php echo $rfpidval ; ?>&task=saverfpmsg1&Itemid=88&sort=<?php echo $sort ; ?>&type=coworker">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor">COMPLIANCE STATUS</div>
</div>

<?php 
$items_hide = $this->allitems;
$items = $this->allitems;
/*echo "<pre>"; print_r($corporates); echo "</pre>";
echo "BIBD11";
echo "<pre>"; print_r($items); echo "</pre>";
echo "BIBD22";
echo "<pre>"; print_r($ownids); echo "</pre>";*/
//echo "<pre>"; print_r($items); echo "</pre>";

if($items) {
foreach($items as $am ) {  
	if($ownids || $corporates){
		if($user->accounttype == 'master'){
				if (in_array($am->v_id, $ownids) || $am->vendorstatus == 'ineligible')
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
		}
		else{
				if (in_array($am->v_id, $ownids) || $am->vendorstatus == 'ineligible' || in_array($am->v_id, $corporates))
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
		}		  
			}
?> 
 	<div id="preferredvendorsinvitations" style="padding:6px; display:<?php echo $display; ?>">
   <div class="search-panel-middlepre checkbox_vendor">
   
 <?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && $am->special_requirements == 'fail' ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->special_requirements == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}
			
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	

			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_comp = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_comp = "";
			}
				
?>	
  
    <?php if($am->pre == 'yes'){ $checked = 'checked'; } else { $checked = ''; } ?>
    <?php if($am->vendorstatus == 'eligible' && $am->vendorstatus != 'suspend'){ ?>
		<?php 
			$decline = "SELECT id, proposaltype from #__cam_vendor_proposals where proposedvendorid=".$am->v_id." and rfpno=".$rfpid." ";
			$db->setQuery($decline);
			$invitest = $db->loadObject();
			$invitestatus = $invitest->id;
			$invite_un = $invitest->proposaltype;
			$dec = "SELECT not_interested from #__cam_vendor_availablejobs where user_id=".$am->v_id." and rfp_id=".$rfpid." ";
			$db->setQuery($dec);
			$decline = $db->loadResult();
			
			$invitationlis = "SELECT id from #__rfp_invitations where vendorid=".$am->v_id." and rfpid=".$rfpid." ";
			$db->setQuery($invitationlis);
			$invitationlist = $db->loadResult();
			
		if($am->pre == 'yes' && $checkbox == 'show'){ 
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else if($invitestatus || ($decline != '2' && $invitationlist) ){
				if( $invite_un != 'uninvited' )
					echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
				else { ?>
			<input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo $class_comp; ?>" name="selectdvendors[]" id="vendors<?php echo  $am->v_id; ?>" />	
				<?php }	
					
			}
			else{
			}
		}
		else if($am->subscribe != 'yes'){
		echo "<span title='This Vendor needs to ACTIVATE their account to receive an invite' style='color:red; font-weight:bold;'>INACTIVE</span>";
		} 
		else if($invitestatus && $am->pre != 'yes'){
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else{
			echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
			}
		}
		else { 
			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_comp = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_comp = "";
			}
		?>


	 


	
		<?php if( $checkbox != 'show' )	{ ?>
	  <a href="javascript:unverified(<?php echo $am->v_id; ?>,'<?php echo $args; ?>');" style="margin-left:-17px;"><img src="templates/camassistant_left/images/Block2.png" /></a>
	 <?php }
	  else if($am->excluded == '') { ?>
      <input type="checkbox" value="<?php echo  $am->v_id; ?>" class="<?php echo $class_comp; ?>" name="selectdvendors[]" <?php echo $checked; ?> id="vendors<?php echo  $am->v_id; ?>" />
	  <?php } else { ?>
			<a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
			<?php } ?>
			
	  <?php } ?>
	  <br />
	  <?php } 
	  elseif($am->vendorstatus == 'suspend'){
	  echo "<span style='color:red; font-weight:bold;'>Suspended</span>";
	  }
	  else {
	  echo "<span style='color:red; font-weight:bold;'>INELIGIBLE</span>";
		}  ?> 
      </div>
    <div class="search-panel-left_rfp company_vendor">
	
      <ul>
        <li><strong><a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->v_id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name; ?> <?php echo $am->lastname; ?>: <?php echo $am->company_phone; ?>	<?php if($am->phone_ext) { echo "&nbsp;Ext.&nbsp;".$am->phone_ext ; }  ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="color:gray; font-weight:normal" href="mailto:<?php echo $am->inhousevendors; ?>?cc=support@myvendorcenter.com"><?php echo $am->inhousevendors; ?></a></li>
        </ul>
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->v_id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
		if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}
	
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'10.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'20.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'30.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'40.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			$total = 0; ?>
			<img width="130" src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
			
	</div>
	
	<div class="search-panel-image_rfp compliant_vendor">
	<?php 
			if($existing_stand == 'no'){
				$compliant_id = "nostandards";
				$images_text = 'N/A';
			}
			else {
				if($am->special_requirements == 'fail'){
				$compliant_id = "noncompliant";
				//$images_text = 'NON-COMPLIANT';
				$title = 'Non-Compliant';
				}
				else {
				//$images_text = 'COMPLIANT';
				$compliant_id = "compliant";
				$title = 'Compliant';
				}
			}	
			?>
	 <p align="center" style="color:<?php echo $spe_color; ?>; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
	 <?php if($globals != 'fail'){ ?>
			<a id="<?php echo $compliant_id; ?>" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 700}}" href="index.php?option=com_camassistant&controller=rfp&task=getcompliance&rfpid=<?php echo $rfpid; ?>&vendorid=<?php echo $am->v_id; ?>" title="<?php echo $title; ?>"><?php echo $images_text ; ?></a>
			<?php } else { 
			
			echo "N/A";
			}?>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			
			 </p>
	  </div>
	  
    <div class="clr"></div>
  </div>
    <?php } 
	} 
	
	?> 
	<br /><br /><br /><br />	
<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">OTHER ELIGIBLE VENDORS</font></span>
</div></div>


<div id="heading_vendors">
<div class="checkbox_vendor">SELECT</div>
	<?php
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	if( $sort == 'asc' && $type == 'othere' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'othere' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}

	?>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=rfp&rfp_type=review&rfpid=<?php echo $rfpidval ; ?>&task=saverfpmsg1&Itemid=88&sort=<?php echo $sort ; ?>&type=othere">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor">COMPLIANCE STATUS</div>
</div>
<?php 
$others = $this->others;
if($items_hide){
		foreach($items_hide as $vid){
		$preferred[] = $vid->v_id;
		}//end for foreach
		}
		else{
		$preferred[] = '';
		}

if($others){
foreach($others as $am ) { 
	if($ownids || $preferred ){
				if (in_array($am->id, $ownids) || in_array($am->id, $preferred) || $am->vendorstatus == 'ineligible' ||  in_array($am->id, $corporates))
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}
	else{
		if($am->vendorstatus == 'ineligible'){
		$display = 'none' ;
		}
		else{
		$display = '' ;
		}
	}
	
if( $am->subscribe_type == 'sponsor' || $am->subscribe_type == 'all' )
$background = '#ebf5da';	
else
$background = '';		
?> 
<?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && $am->special_requirements == 'fail' ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->special_requirements == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}
			
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->special_requirements == 'fail' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	
?>	

 	<div id="preferredvendorsinvitations" style="padding:6px; background:<?php echo $background; ?>; display:<?php echo $display; ?>">
   <div class="search-panel-middlepre checkbox_vendor">
    <?php if($am->pre == 'yes'){ $checked = 'checked'; } else { $checked = ''; } ?>
    <?php if($am->vendorstatus == 'eligible' && $am->vendorstatus != 'suspend'){ ?>
		<?php 
			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_other = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_other = "";
			}
					
			$decline = "SELECT id, proposaltype from #__cam_vendor_proposals where proposedvendorid=".$am->id." and rfpno=".$rfpid." ";
			$db->setQuery($decline);
			$invite = $db->loadObject();
			$invitestatus = $invite->id ;
			$invite_un = $invite->proposaltype ;
			
			$dec = "SELECT not_interested from #__cam_vendor_availablejobs where user_id=".$am->id." and rfp_id=".$rfpid." ";
			$db->setQuery($dec);
			$decline = $db->loadResult();
			
			$invitationlis = "SELECT id from #__rfp_invitations where vendorid=".$am->id." and rfpid=".$rfpid." ";
			$db->setQuery($invitationlis);
			$invitationlist = $db->loadResult();
			
		if($am->pre == 'yes' && $checkbox == 'show'){ 
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else if($invitestatus || ($decline != '2' && $invitationlist) ){
				if( $invite_un != 'uninvited' )
			echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
			else { ?>
		<input type="checkbox" value="<?php echo  $am->id; ?>" class="<?php echo $class_other; ?>" name="selectdvendors[]" id="vendors<?php echo  $am->id; ?>" />	
		<?php 	}
			}
			else{
			}
		}
		
		else if($am->subscribe != 'yes'){
		echo "<span title='This Vendor needs to ACTIVATE their account to receive an invite' style='color:red; font-weight:bold;'>INACTIVE</span>";
		} 
		else if($invitestatus && $am->pre != 'yes'){
			if($decline == '2'){
			echo "<span style='color:red; font-weight:bold; margin-left:-6px;'>Declined</span>";		
			}
			else{
			echo "<span style='color:green; font-weight:bold; margin-left:-18px;'>Invited</span>";
			}
		} 
		else {
			
			if($am->special_requirements == 'fail'){
			$onclick = 'getwarningpopup';
			$class_other = "sponsored";
			}
			else{
			$onclick = 'submitvendorsformcheckbox';
			$class_other = "";
			}
			
		 ?>

		 
		 <?php if( $checkbox != 'show' )	{ ?>
	  <a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'<?php echo $args; ?>');" title="Click for more info"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
		 else if($am->excluded == '') { ?>
      <input type="checkbox" value="<?php echo  $am->id; ?>" class="<?php echo $class_other; ?>" name="selectdvendors[]" <?php echo $checked; ?> id="vendors<?php echo  $am->id; ?>" />
	  <?php } else { ?>
			<a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
			<?php } ?>
	  <?php } ?>
	  <br />
	  <?php } 
	  elseif($am->vendorstatus == 'suspend'){
	  echo "<span style='color:red; font-weight:bold;'>Suspended</span>";
	  }
	  else {
	  echo "<span style='color:red; font-weight:bold;'>INELIGIBLE</span>";
		}  ?> 
      </div>
     <div class="search-panel-left_rfp company_vendor">
      
	  <ul>
        <li><strong><a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name; ?> <?php echo $am->lastname; ?>: <?php echo $am->company_phone; ?>	<?php if($am->phone_ext) { echo "&nbsp;Ext.&nbsp;".$am->phone_ext ; }  ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="color:gray; font-weight:normal" href="mailto:<?php echo $am->email; ?>?cc=support@myvendorcenter.com"><?php echo $am->email; ?></a></li>
        </ul>
		
		
		
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$total = 0;
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	
	$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	} 
	
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';} ?>
			<img width="130" src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
	</div>
	<div class="search-panel-image_rfp compliant_vendor">
	  <?php 
	  		if($existing_stand == 'no'){
				$compliant_id = "nostandards";
				$images_text = 'N/A';
			}
			else {
			
				if($am->special_requirements == 'fail') { 
				//$images_text = 'NON-COMPLIANT';
				$compliant_id = "noncompliant";
				$title = 'Non-Compliant';
				}
				else {
				//$images_text = 'COMPLIANT';
				$compliant_id = "compliant";
				$title = 'Compliant';
				}
			}	
			?>
	 <p align="center" style="color:<?php echo $spe_color; ?>; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
	 <?php if($globals != 'fail'){ ?>
			<a id="<?php echo $compliant_id; ?>" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 700}}" href="index.php?option=com_camassistant&controller=rfp&task=getcompliance&rfpid=<?php echo $rfpid; ?>&vendorid=<?php echo $am->id; ?>" title="<?php echo $title; ?>"><?php echo $images_text ; ?></a>
			<?php } else { 
			echo "N/A";
			}?>
			 </p>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>

			
	  </div>
	
    <div class="clr"></div>
  </div>
    <?php } 
	
}
?>
	<div align="center" id="">
<br />
<?php if($var == 'closeinvite'){ ?>
<table cellpadding="0" cellspacing="0"><tr><td>
<a href="index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125"><img src="templates/camassistant_left/images/CancelButton.gif" /></a></td>&nbsp;&nbsp;&nbsp;<td>
<input type="button" onclick="javascript:fn_submitvendorsform();" name="rfpbtn" class="review_submitvendorspreinvite" style="width:153px;"></td></tr></table>
<?php } else { ?>
<table cellpadding="0" cellspacing="0"><tr><td>
<a href="index.php?option=com_camassistant&controller=rfp&task=editrfp&rfpid=<?php echo $_REQUEST['rfpid']; ?>&var=draft&Itemid=87"><img src="templates/camassistant_left/images/goback.gif" /></a></td>&nbsp;&nbsp;&nbsp;<td>
<input type="button" onclick="javascript:fn_submitvendorsform();" name="rfpbtn" class="review_submitvendorspre"></td></tr></table>
<?php } ?>

</div>
	<input type="hidden" value="com_camassistant" name="option">
	<input type="hidden" value="rfp" name="controller">
	<input type="hidden" value="filtervendors" name="task">
	<input type="hidden" value="<?php echo $rfpid; ?>" name="rfpid">
	<input type="hidden" value="<?php echo $_REQUEST['var']; ?>" name="var">
	</form>
</div>
</div>

<div id="boxesemp" class="boxesemp">
<div id="submitemp" class="windowemp" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray; font-size:13px;">You have not invited any vendors. Are you sure you wish to continue?</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="doneemp"  name="doneemp" value="Ok"><img src="templates/camassistant_left/images/yes.gif" /></div>
<div id="closeemp"  name="closeemp" value="Ok"><img src="templates/camassistant_left/images/goback.gif" /></div>
</div>
</form>

</div>
  <div id="maskemp"></div>
</div>
<?php //if($_REQUEST['var']=='closeinvite'){ exit; } ?>
<div id="boxeswm" style="top:576px; left:582px;">
<div id="submitwm" class="windowwm" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed">
<div style="padding-top:10px; text-align:center"><font color="gray">Warning: This Vendor does NOT meet your Vendor Compliance Standards set in STEP 1. Would you still like to invite this Vendor?</font>
</div>
<div style="padding-top:20px; text-align:center;">
<div id="closewm" name="closewm" value="Cancel"><img src="templates/camassistant/images/No.gif" class="yesimage" /></div>
<div id="donewm" name="donewm" value="Ok"><img src="templates/camassistant/images/yes.gif" class="yesimage" /></div>
</div>
</div>
  <div id="maskwm"></div>
</div>
