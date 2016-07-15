<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<style type="text/css">

   body {
	font: 0.8em/21px arial,sans-serif;
}

.checkbox {
	width: 19px;
	height: 25px;
	padding: 0 5px 0 0;
	background: url(checkbox.png) no-repeat;
	display: block;
	clear: left;
	float: left;
}
</style>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
G = jQuery.noConflict();
var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "190";


/* No need to change anything after this */


document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');

var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(a = 0; a < inputs.length; a++) {
			if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && inputs[a].className == "styled") {
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type;

				if(inputs[a].checked == true) {
					if(inputs[a].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					}
				}
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				inputs[a].onchange = Custom.clear;
				if(!inputs[a].getAttribute("disabled")) {
					span[a].onmousedown = Custom.pushed;
					span[a].onmouseup = Custom.check;
				} else {
					span[a].className = span[a].className += " disabled";
				}
			}
		}
		inputs = document.getElementsByTagName("select");
		for(a = 0; a < inputs.length; a++) {
			if(inputs[a].className == "styled") {
				option = inputs[a].getElementsByTagName("option");
				active = option[0].childNodes[0].nodeValue;
				textnode = document.createTextNode(active);
				for(b = 0; b < option.length; b++) {
					if(option[b].selected == true) {
						textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
					}
				}
				span[a] = document.createElement("span");
				span[a].className = "select";
				span[a].id = "select" + inputs[a].name;
				span[a].appendChild(textnode);
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				if(!inputs[a].getAttribute("disabled")) {
					inputs[a].onchange = Custom.choose;
				} else {
					inputs[a].previousSibling.className = inputs[a].previousSibling.className += " disabled";
				}
			}
		}
		document.onmouseup = Custom.clear;
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
window.onload = Custom.init;

function accepted_terms(masterid,vendorid,type){
	G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=gettermsdata", {vendorid: ""+vendorid+"", masterid: ""+masterid+"", type: ""+type+""},function(data){
		if( type == 'acc' ){
			G('#returnmessage_accepted').html(data);
			getgreenpopup();
			}
		else if(type == 'dec'){
			G('#returnmessage_declined').html(data);
			getredpopup();
			}
		else{
			G('#returnmessage_notread').html(data);
			getgraypopup();
		}
		
	});
}

function getredpopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskex').css({'width':maskWidth,'height':maskHeight});
		G('#maskex').fadeIn(100);
		G('#maskex').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitex").css('top',  winH/2-G("#submitex").height()/2);
		G("#submitex").css('left', winW/2-G("#submitex").width()/2);
		G("#submitex").fadeIn(2000);
		G('.windowex #cancelex').click(function (e) {
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
}

function getgreenpopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexg').css({'width':maskWidth,'height':maskHeight});
		G('#maskexg').fadeIn(100);
		G('#maskexg').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexg").css('top',  winH/2-G("#submitexg").height()/2);
		G("#submitexg").css('left', winW/2-G("#submitexg").width()/2);
		G("#submitexg").fadeIn(2000);
		G('.windowexg #cancelexg').click(function (e) {
		e.preventDefault();
		G('#maskexg').hide();
		G('.windowexg').hide();
		});
}	

function getgraypopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexgr').css({'width':maskWidth,'height':maskHeight});
		G('#maskexgr').fadeIn(100);
		G('#maskexgr').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexgr").css('top',  winH/2-G("#submitexgr").height()/2);
		G("#submitexgr").css('left', winW/2-G("#submitexgr").width()/2);
		G("#submitexgr").fadeIn(2000);
		G('.windowexgr #cancelexgr').click(function (e) {
		e.preventDefault();
		G('#maskexgr').hide();
		G('.windowexgr').hide();
		});
}	

</script>
</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}


#maskexg { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexg .windowexg {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexg #submitexg {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesexg #submitexg a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexg {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexg {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}


#maskexgr { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexgr .windowexgr {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexgr #submitexgr {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesexgr #submitexgr a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexgr {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexgr {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

</style>

<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<?php 
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
$w9data = $this->w9_compliane ;
$generaldata = $this->gli_compliane ;
$autodata = $this->aip_compliane ;
$workdata = $this->wci_compliane ;
$umbrelladata = $this->umb_compliane ;
$licdata = $this->lic_compliane ;
$omidata = $this->omi_compliane ;

$vendor_w9data = $this->w9_vendor ;
$vendor_generaldata = $this->gli_vendor ;
$vendor_autodata = $this->aip_vendor ;
$vendor_workdata = $this->wci_vendor ;
$vendor_umbrelladata = $this->umb_vendor ;
$vendor_licdata = $this->lic_vendor ;
$vendor_occdata = $this->occ_vendor ;
$vendor_omidata = $this->omi_vendor ;
$status	= JRequest::getVar('status','');
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($vendor_omidata); echo "</pre>";

//exit;
?>


<?php 
		if( $status == 'Compliant' ){
		$background = '#77b800';
		$addclass = 'greenhighlight';
		$borderclass = 'greenborderlight';
		}
		else{
		$background = 'red';
		$addclass = 'redhighlight';
		$borderclass = 'redborderlight';
		}
?>
<div class="lineitem_pan_row" style="background-color:#fff;">
<div id="i_bar_terms" style="margin-bottom:20px; position:fixed; width:100%; background:<?php echo $background; ?>">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;"><?php echo strtoupper($this->vname); ?></font></span>
</div></div>
<?php 
	$vendorid = JRequest::getVar( 'vendorid','');	
	$user =& JFactory::getUser();
		$db=&JFactory::getDBO();
			if($user->user_type == '12'){
				$query_c = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$user->id." ";
				$db->setQuery($query_c);
				$cid = $db->loadResult();	
				$camfirmid = "SELECT cust_id FROM #__cam_camfirminfo WHERE id=".$cid." ";
				$db->setQuery($camfirmid);
				$camfirm = $db->loadResult();
				$masterid = "SELECT masterid FROM #__cam_masteraccounts WHERE firmid=".$camfirm." ";
				$db->setQuery($masterid);
				$masterid = $db->loadResult();
				}
			elseif($user->user_type == '13' && $user->accounttype!='master'){
				$masterid = "SELECT masterid FROM #__cam_masteraccounts WHERE firmid=".$user->id." "; 
				$db->setQuery($masterid);
				$masterid = $db->loadResult();
			}
			else{
			$masterid = $user->id;
			}	

			if( $status == 'Non-Compliant' || $status == 'Compliant & Non-Compliant' )
				$color_status = 'red';
			else
				$color_status = '#77b800';	
			?>	
		<p class="terms_conditions_noborder_status">Compliance Status: <font color="<?php echo $color_status; ?>"><?php echo $status; ?></font></p>
		<?php 
// Displays verified vendor or not
		$query_sub = "SELECT subscribe_type FROM #__users where id =".$vendorid." "; 
		$db->setQuery($query_sub);
		$vendor_subscribe = $db->loadResult();
		if( $vendor_subscribe == 'free' ) {
		?>
		<p class="terms_conditions_noborder_docs">Compliance Documents:<span style="color:red;">&nbsp;Unverified</span></p>
		<?php } else { ?>
		<p class="terms_conditions_noborder_docs">Compliance Documents:<span style="color:#77b800;">&nbsp;Verified</span></p>
		<?php }
//COmpleted

		$query_conditon = "SELECT termsconditions FROM #__cam_vendor_aboutus  WHERE vendorid=".$masterid." ";
		$db->setQuery( $query_conditon );
		$terms = $db->loadResult();
		if($terms == '1'){
			$result = $this->terms;
		} ?>
		<p class="terms_conditions_noborder"><?php echo $result; ?></p>
		<div class="lineitem_pan_row_standards <?php echo $borderclass; ?>" style="background:#fff;">
<h1 class="<?php echo $addclass; ?>"><?php echo $this->industry; ?></h1>
<div class="lineitem_pan" style="border:none;">
	<div class="insurancedotline" style="border-bottom:none; margin-left:17px; pointer-events:none;">
	<table cellpadding="0" cellspacing="0" border="0">
	<?php
	if($w9data) { $w9_main = 'checked="checked"'; $w9_class = 'styled active';  
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="w9liability" class="<?php echo $w9_class; ?>" name="w9liability" <?php echo $w9_main; ?> /></td><td><strong>W9</strong></td></tr>
	<?php } ?>
	<?php 
	$w9_main = '';
	$w9_class = '';
	if($w9data) {
	?>
	<tr><td></td><td>
	<ul class="pre_general">
		<?php
			if(!$vendor_w9data[0]->w9_upld_cert){
				echo '<li><span style="color:red;">No Certificate Uploaded</span></li>';
			}
			if( $vendor_w9data[0]->w9_status == '-1' ){
				echo '<li><span style="color:red;">Rejected By MyVC</span></li>';
			}
			$vendor_w9data = '';
		?>
	</ul>
	</td></tr>
	<tr height="15"></tr>
	<?php 	
	}
	?>
	
	<?php
	
	if($generaldata) { $general_main = 'checked="checked"'; $gen_class = 'styled active';  
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="generalliability" class="<?php echo $gen_class; ?>" name="generalliability" <?php echo $general_main; ?> /></td><td><strong>General Liability</strong></td></tr>
	<?php } ?>
	<?php 
	$general_main = '';
	$gen_class = '';
	if($generaldata) {
	?>
	<tr><td></td><td>
	<ul class="pre_general">
			<?php
			$success_gli_file = '';
			for( $file=0; $file<count($vendor_generaldata); $file++ ){
							if($vendor_generaldata[$file]->GLI_upld_cert){
							$success_gli_file[] = $vendor_generaldata[$file];
						}
					}
			if(!$success_gli_file) { ?>
			<li><span style="color:red;">No Certificate Uploaded</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_exp = $success_gli_file ;
				else
				$success_arr_exp = $vendor_generaldata ;
				$success_gli_exp = '';
				
			for( $exp=0; $exp<count($success_arr_exp); $exp++ ){
				if( $success_arr_exp[$exp]->GLI_end_date > date('Y-m-d') ){
					$success_gli_exp[] = $success_arr_exp[$exp];
				}
			}
			if( !$success_gli_exp && $success_gli_file ) { ?>
			<li><span style="color:red;">Expired</span></li>
			<?php }
			?>
		 
		 	<?php 
				if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_rej = $success_gli_file ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_rej = $success_gli_file ;
				else
				$success_arr_rej = $vendor_generaldata ;
				$success_gli_rej = '';
				
			for( $rej=0; $rej<count($success_arr_rej); $rej++ ){
				if( $success_arr_rej[$rej]->GLI_status == '-1' ){
					$success_gli_rej[] = $success_arr_rej[$rej];
				}
			}
			if($success_gli_rej) { ?>
			<li><span style="color:red;">Rejected By MyVC</span></li>
			<?php }
			?>
			
			<?php 
			if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_rej = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_rej = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_rej = $success_gli_file ;
				else
				$success_arr_rej = $vendor_generaldata ;
				$success_gli_occ = '';	
			for( $occ=0; $occ<count($success_arr_rej); $occ++ ){
						if( $generaldata->occur == 'yes' ){
							if($success_arr_rej[$occ]->GLI_occur == 'occur'){
							$success_gli_occ[] = $success_arr_rej[$occ];
							}
						}
					}
			if($success_gli_occ)
			$class_occ = '';
			else
			$class_occ = 'red';
			
		 ?>
		<?php if($generaldata->occur){ $selected_occur = 'checked'; $class = 'styled active'; ?>
		<li><input type="checkbox" value="yes" name="occur" class="<?php echo $class; ?>" checked="<?php echo $selected_occur; ?>" /> <label><span style="color:<?php echo $class_occ; ?>">Occur</span></label></li>
		<?php } ?>
		<?php 
				if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_occ = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_occ = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_occ = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_occ = $success_gli_file ;
				else
				$success_arr_occ = $vendor_generaldata ;
				
				$success_gli_each = '';
			for( $vg=0; $vg<count($success_arr_occ); $vg++ ){
				if( $generaldata->each_occurrence <= $success_arr_occ[$vg]->GLI_policy_occurence ){
					$success_gli_each[] = $success_arr_occ[$vg];
				}
			}
			if($success_gli_each)
			$class_each = '';
			else
			$class_each = 'red';
			
		 ?>
		 <?php if($generaldata->each_occurrence && $generaldata->each_occurrence != '0.00'){ ?>
		<li><span style="color:<?php echo $class_each; ?>">Each Occurrence:&nbsp;<?php echo "$".number_format($generaldata->each_occurrence,2); ?></span></li>
		<?php } ?>
		<?php 
				if( count($success_gli_each) >= 1 && !empty($success_umb_agg) )
				$success_arr = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr = $success_gli_file ;
				else
				$success_arr = $vendor_generaldata ;
				$success_gli_damage = '';
					for( $dr=0; $dr<count($success_arr); $dr++ ){
						if( $generaldata->damage_retend <= $success_arr[$dr]->GLI_damage ){
							$success_gli_damage[] = $success_arr[$dr];
						}
					}
			if($success_gli_damage)
			$class_damage = '';
			else
			$class_damage = 'red';
			
			?>
			<?php 
			if($generaldata->damage_retend && $generaldata->damage_retend != '0.00'){
		 ?>
		<li><span style="color:<?php echo $class_damage; ?>">Damage to Rented Premises:&nbsp;<?php echo "$".number_format($generaldata->damage_retend,2); ?></span></li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_med = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_med = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_med = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_med = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_med = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_med = $success_gli_file ;
				else
				$success_arr_med = $vendor_generaldata ;
				
				$success_gli_med = '';
					for( $dam=0; $dam<count($success_arr_med); $dam++ ){
						if( $generaldata->med_expenses <= $success_arr_med[$dam]->GLI_med ){
							$success_gli_med[] = $success_arr_med[$dam];
						}
					}
			if($success_gli_med)
			$class_med = '';
			else
			$class_med = 'red';
			
		 ?>
		 <?php if($generaldata->med_expenses && $generaldata->med_expenses != '0.00'){ ?>
		<li><span style="color:<?php echo $class_med; ?>">Med Expenses:&nbsp;<?php echo "$".number_format($generaldata->med_expenses,2); ?></span></li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_inj = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_inj = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_inj = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_inj = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_inj = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_inj = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_inj = $success_gli_file ;
				else
				$success_arr_inj = $vendor_generaldata ;
				
				$success_gli_pi = '';
					for( $pi=0; $pi<count($success_arr_inj); $pi++ ){
						if( $generaldata->personal_inj <= $success_arr_inj[$pi]->GLI_injury ){
							$success_gli_pi[] = $success_arr_inj[$pi];
						}
					}
				
			if($success_gli_pi)
			$class_pi = '';
			else
			$class_pi = 'red';
		 ?>
		 <?php if($generaldata->personal_inj && $generaldata->personal_inj != '0.00'){ ?>
		<li><span style="color:<?php echo $class_pi; ?>">Personal & Adv injury:&nbsp;<?php echo "$".number_format($generaldata->personal_inj,2); ?></span></li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_aggr = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_aggr = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_aggr = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_aggr = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_aggr = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_aggr = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_aggr = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_aggr = $success_gli_file ;
				else
				$success_arr_aggr = $vendor_generaldata ;
					$success_gli_ga = '';
					for( $ga=0; $ga<count($success_arr_aggr); $ga++ ){
						if( $generaldata->general_aggr <= $success_arr_aggr[$ga]->GLI_policy_aggregate ){
							$success_gli_ga[] = $success_arr_aggr[$ga];
						}
					}
				
			if($success_gli_ga)
			$class_ga = '';
			else
			$class_ga = 'red';
		?>
		<?php if($generaldata->general_aggr && $generaldata->general_aggr != '0.00'){ ?>
		<li><span style="color:<?php echo $class_ga; ?>">General Aggregate:&nbsp;<?php echo "$".number_format($generaldata->general_aggr,2); ?></span>
		<?php } ?>
				
				<?php 
				if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_app = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_app = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_app = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_app = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_app = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_app = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_app = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_app = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_app = $success_gli_file ;
				else
				$success_arr_app = $vendor_generaldata ;
				$success_gli_app = '';
					for( $app=0; $app<count($success_arr_app); $app++ ){
						if($generaldata->applies_to){
							if( $success_arr_app[$app]->GLI_applies == $generaldata->applies_to ){
								$success_gli_app[] = $success_arr_aggr[$app];
							}
						}
					}
				
			if($success_gli_app)
			$class_app = '';
			else
			$class_app = 'red';
				?>
		<?php if($generaldata->applies_to){ ?>
		<?php if($generaldata->applies_to == 'pol') {
			  $pols = "checked='checked'";
			 // $class_app_opt1 = 'red';
			  }
		      else if($generaldata->applies_to == 'proj') {
			  $proj = "checked='checked'";
			 // $class_app_opt2 = 'red';
			  }
			  else if($generaldata->applies_to == 'loc') {
			 // $class_app_opt3 = 'red';
			  $loc = "checked='checked'";
			  }
			  
			  if($generaldata->applies_to == 'pol' && !$success_gli_app) {
			  	$class_app_opt1 = 'red';
			  }
			   else if($generaldata->applies_to == 'proj' && !$success_gli_app) {
			   $class_app_opt2 = 'red';
			   }
			    else if($generaldata->applies_to == 'loc' && !$success_gli_app) {
			   $class_app_opt3 = 'red';
			   }
		 ?>
		<span style="color:<?php echo $class_app; ?>">| Applies To: </span>
		<input type="radio" <?php echo $pols; ?> style="vertical-align:top; margin-top:2px;" /><span style="color:<?php echo $class_app_opt1; ?>">Pol</span>&nbsp;
		<input type="radio" <?php echo $proj; ?> style="vertical-align:top; margin-top:2px;" /><span style="color:<?php echo $class_app_opt2; ?>">Proj</span>&nbsp;
		<input type="radio" <?php echo $loc; ?> style="vertical-align:top; margin-top:2px;" /><span style="color:<?php echo $class_app_opt3; ?>">Loc</span>
		</li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_app) >= 1 && !empty($success_gli_app) )
				$success_arr_pro = $success_gli_app ;
				else if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_pro = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_pro = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_pro = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_pro = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_pro = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_pro = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_pro = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_pro = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_pro = $success_gli_file ;
				else
				$success_arr_pro = $vendor_generaldata ;
				$success_gli_pro = '';
					for( $pro=0; $pro<count($success_arr_pro); $pro++ ){
						if( $generaldata->products_aggr <= $success_arr_pro[$pro]->GLI_products ){
							$success_gli_pro[] = $success_arr_pro[$pro];
						}
					}
				if($success_gli_pro)
				$class_pro = '';
				else
				$class_pro = 'red';	
		?>
		<?php if($generaldata->products_aggr && $generaldata->products_aggr != '0.00'){ ?>
		<li><span style="color:<?php echo $class_pro; ?>">Products - COMP/OP Aggregate:&nbsp;<?php echo "$".number_format($generaldata->products_aggr,2); ?></span></li>
		<?php } ?>
		
		<?php 
				
				if( count($success_gli_pro) >= 1 && !empty($success_gli_pro) )
				$success_arr_waiver = $success_gli_pro ;
				else if( count($success_gli_app) >= 1 && !empty($success_gli_app) )
				$success_arr_waiver = $success_gli_app ;
				else if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_waiver = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_waiver = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_waiver = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_waiver = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_waiver = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_waiver = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_waiver = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_waiver = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_waiver = $success_gli_file ;
				else
				$success_arr_waiver = $vendor_generaldata ;
				
				$success_gli_wai = '';
					for( $wai=0; $wai<count($success_arr_waiver); $wai++ ){
						if( $generaldata->waiver_sub == 'yes' ){
							if($success_arr_waiver[$wai]->GLI_waiver == 'waiver'){
							$success_gli_wai[] = $success_arr_wai[$wai];
							}
						}
					}
				if($success_gli_wai)
				$class_wai = '';
				else
				$class_wai = 'red';	
		?>
		
		
		<?php if($generaldata->waiver_sub == 'yes'){ $waiv = 'checked'; $class_waiver_sub = 'styled'; ?>
		<li><input type="checkbox" value="yes" name="waiver_sub" checked="<?php echo $waiv; ?>" class="<?php echo $class_waiver_sub; ?>" /> <label><span style="color:<?php echo $class_wai; ?>">Waiver of Subrogation</span></label></li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_wai) >= 1 && !empty($success_gli_wai) )
				$success_arr_primary = $success_gli_wai ;
				else if( count($success_gli_pro) >= 1 && !empty($success_gli_pro) )
				$success_arr_primary = $success_gli_pro ;
				if( count($success_gli_app) >= 1 && !empty($success_gli_app) )
				$success_arr_primary = $success_gli_app ;
				else if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_primary = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_primary = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_primary = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_primary = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_primary = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_primary = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_primary = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_primary = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_primary = $success_gli_file ;
				else
				$success_arr_primary = $vendor_generaldata ;
				
				$success_gli_primary = '';
					for( $pri=0; $pri<count($success_arr_primary); $pri++ ){
						if( $generaldata->primary_noncontr == 'yes' ){
							if($success_arr_primary[$pri]->GLI_primary == 'primary'){
							$success_gli_primary[] = $success_arr_primary[$pri];
							}
						}
					}
				if($success_gli_primary)
				$class_pri = '';
				else
				$class_pri = 'red';	
				
		?>
		
		<?php if($generaldata->primary_noncontr == 'yes'){ $prim = 'checked'; $class_primary_noncontr = 'styled';?>
		<li><input type="checkbox" value="yes" name="primary_noncontr" checked="<?php echo $prim; ?>" class="<?php echo $class_primary_noncontr; ?>" /> <label><span style="color:<?php echo $class_pri; ?>">Primary Non-Contributory</span></label></li>
		<?php } ?>
		<?php 
				if( count($success_gli_primary) >= 1 && !empty($success_gli_primary) )
				$success_arr_add = $success_gli_primary ;
				else if( count($success_gli_wai) >= 1 && !empty($success_gli_wai) )
				$success_arr_add = $success_gli_wai ;
				else if( count($success_gli_pro) >= 1 && !empty($success_gli_pro) )
				$success_arr_add = $success_gli_pro ;
				if( count($success_gli_app) >= 1 && !empty($success_gli_app) )
				$success_arr_add = $success_gli_app ;
				else if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_add = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_add = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_add = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_add = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_add = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_add = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_add = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_add = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_add = $success_gli_file ;
				else
				$success_arr_add = $vendor_generaldata ;
				//echo "<pre>"; print_r($success_arr_add); echo "</pre>";
				//echo "<pre>"; print_r($generaldata); echo "</pre>";
				$success_gli_add = '';
					for( $add=0; $add<count($success_arr_add); $add++ ){
						if( $generaldata->additional_insured == 'yes' ){
							if($success_arr_add[$add]->GLI_additional){
							$success_gli_add[] = $success_arr_add[$add];
							}
						}
					}
					
				if($success_gli_add)
				$class_add = '';
				else
				$class_add = 'red';	
		?>
		<?php if($generaldata->additional_insured == 'yes'){ $add = 'checked'; $class_additional_insured = 'styled';?>
		<li><input type="checkbox" value="yes" name="additional_insured" checked="<?php echo $add; ?>" class="<?php echo $class_additional_insured; ?>" /><label> <span style="color:<?php echo $class_add; ?>">List my Company as as "Additional Insured"</span></label></li>
		<?php } ?>
		
		<?php 
				if( count($success_gli_add) >= 1 && !empty($success_gli_add) )
				$success_arr_cert = $success_gli_add ;
				else if( count($success_gli_primary) >= 1 && !empty($success_gli_primary) )
				$success_arr_cert = $success_gli_primary ;
				else if( count($success_gli_wai) >= 1 && !empty($success_gli_wai) )
				$success_arr_cert = $success_gli_wai ;
				else if( count($success_gli_pro) >= 1 && !empty($success_gli_pro) )
				$success_arr_cert = $success_gli_pro ;
				if( count($success_gli_app) >= 1 && !empty($success_gli_app) )
				$success_arr_cert = $success_gli_app ;
				else if( count($success_gli_ga) >= 1 && !empty($success_gli_ga) )
				$success_arr_cert = $success_gli_ga ;
				else if( count($success_gli_pi) >= 1 && !empty($success_gli_pi) )
				$success_arr_cert = $success_gli_pi ;
				else if( count($success_gli_med) >= 1 && !empty($success_gli_med) )
				$success_arr_cert = $success_gli_med ;
				else if( count($success_gli_damage) >= 1 && !empty($success_gli_damage) )
				$success_arr_cert = $success_gli_damage ;
				else if( count($success_gli_each) >= 1 && !empty($success_gli_each) )
				$success_arr_cert = $success_gli_each ;
				else if( count($success_gli_occ) >= 1 && !empty($success_gli_occ) )
				$success_arr_cert = $success_gli_occ ;
				else if( count($success_gli_rej) >= 1 && !empty($success_gli_rej) )
				$success_arr_cert = $success_gli_rej ;
				else if( count($success_gli_exp) >= 1 && !empty($success_gli_exp) )
				$success_arr_cert = $success_gli_exp ;
				else if( count($success_gli_file) >= 1 && !empty($success_gli_file) )
				$success_arr_cert = $success_gli_file ;
				else
				$success_arr_cert = $vendor_generaldata ;
				//echo "<pre>"; print_r($success_arr_cert); echo "</pre>";
				$success_gli_cert = '';
					for( $cert=0; $cert<count($success_arr_cert); $cert++ ){
						//if( $generaldata->cert_holder == 'yes' ){
							if( $generaldata->cert_holder == $success_arr_cert[$cert]->GLI_certholder ){
							$success_gli_cert[] = $success_arr_cert[$cert];
							}
						//}
					}
				if($success_gli_cert)
				$class_cert = '';
				else
				$class_cert = 'red';	
		?>
		<?php if($generaldata->cert_holder == 'yes'){ $cert = 'checked'; $class_cert_holder = 'styled'; ?>
		<li><input type="checkbox" value="yes" name="cert_holder" checked="<?php echo $cert; ?>" class="<?php echo $class_cert_holder; ?>"  /><label> <span style="color:<?php echo $class_cert; ?>">MyVendorCenter listed as Cert. Holder</span></label></li>
		<?php } ?>
		</ul>		
		</td>
		</td></tr>
	<?php } ?>	
	<tr id="generalliability_sub"></tr>
	<?php
		if($autodata){ $auto_main = 'checked="checked"'; $class_auto="styled active"; 
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="autoliability" class="<?php echo $class_auto; ?>" name="autoliability" <?php echo $auto_main; ?> /></td><td><strong>Auto Liability</strong></td></tr>
	<?php } ?>
	<?php if($autodata){ ?>
	<tr><td></td><td>
	<ul class="pre_auto">
		<?php 
				$success_aip_file = '';
				for( $file=0; $file<count($vendor_autodata); $file++ ){
						if( $vendor_autodata[$file]->aip_upld_cert ){
							$success_aip_file[] = $vendor_autodata[$file];
						}
				}
				
			if(!$success_aip_file) { ?>
			<li><span style="color:red;">No Certificate Uploaded</span></li>
			<?php }
			?>
				
				
			<?php 
				if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_exp = $success_aip_file ;
				else
				$success_arr_exp = $vendor_autodata ;
				
				$success_aip_exp = '';
				for( $exp=0; $exp<count($success_arr_exp); $exp++ ){
						if( $success_arr_exp[$exp]->aip_end_date > date('Y-m-d' ) ){
							$success_aip_exp[] = $success_arr_exp[$exp];
						}
				}
				
			if( !$success_aip_exp && $success_aip_file ) { ?>
			<li><span style="color:red;">Expired</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_rej = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_rej = $success_aip_file ;
				else
				$success_arr_rej = $vendor_autodata ;
//				echo "<pre>"; print_r($success_arr_rej); echo "</pre>";
				$success_aip_rej = '';
				for( $rej=0; $rej<count($success_arr_rej); $rej++ ){
						if( $success_arr_rej[$rej]->aip_status == '-1' ){
							$success_aip_rej[] = $success_arr_rej[$rej];
						}
				}
				
				if($success_aip_rej) { ?>
			<li><span style="color:red;">Rejected By MyVC</span></li>
			<?php }
			?>
			
		<?php 
				$auto_main = '';
				$class_auto = '';
			  if($autodata->applies_to_any == 'any') { 
			  $any = 'checked="checked"';
			  $class_cert_1 = 'styled';
			  }
		      if($autodata->applies_to_owned == 'owned') {
			  $owned = 'checked="checked"';
			  $class_cert_2 = 'styled';
			  }
			  if ($autodata->applies_to_nonowned == 'nonowned') {
			  $nonowned = 'checked="checked"';
			  $class_cert_3 = 'styled';
			  }
			  if ($autodata->applies_to_hired == 'hired') {
			  $hired = 'checked="checked"';
			  $class_cert_4 = 'styled';
			  }
			  if ($autodata->applies_to_scheduled == 'scheduled') {
			  $scheduled = 'checked="checked"';
			  $class_cert_5 = 'styled';
			  }
		?>
	
<?php if($autodata->applies_to_any || $autodata->applies_to_owned || $autodata->applies_to_nonowned || $autodata->applies_to_hired || $autodata->applies_to_scheduled){ ?>		
<li>
		<table cellpadding="0" cellspacing="0"><tr><td><span style="display:block; margin-top:2px;">Applies To:&nbsp;&nbsp;</span></td>
		<?php } ?>
			<?php 
				if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_any = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_any = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_any = $success_aip_file ;
				else
				$success_arr_any = $vendor_autodata ;
				
				$success_aip_any = '';
				for( $aa=0; $aa<count($success_arr_any); $aa++ ){
					if($autodata->applies_to_any == 'any'){
						if( $autodata->applies_to_any == $success_arr_any[$aa]->aip_applies_any ){
							$success_aip_any[] = $success_arr_any[$aa];
						}
					}
				}
				if($success_aip_any)
					$class_any = '';
				else
					$class_any = 'red';
					
			?>
		<?php if($autodata->applies_to_any == 'any') { ?>
		<td><input type="checkbox" name="applies_to_any" class="<?php echo $class_cert_1; ?>" value="any" <?php echo $any; ?>   /></td><td> <label><span style="color:<?php echo $class_any; ?>">Any&nbsp;</span> </label></td>
		<?php } ?>
		<?php
				if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_owned = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_owned = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_owned = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_owned = $success_aip_file ;
				else
				$success_arr_owned = $vendor_autodata ;
				
				$success_aip_owned = '';
				for( $own=0; $own<count($success_arr_owned); $own++ ){
					if($autodata->applies_to_owned == 'owned'){
						if( $autodata->applies_to_owned == $success_arr_owned[$own]->aip_applies_owned ){
							$success_aip_owned[] = $success_arr_owned[$own];
						}
					}
				}
				
				if($success_aip_owned)
					$class_own = '';
				else
					$class_own = 'red';
					
		?>
		<?php if($autodata->applies_to_owned) {?>
		<td><input type="checkbox" name="applies_to_owned" class="<?php echo $class_cert_2; ?>" value="owned" <?php echo $owned; ?> /></td><td><label><span style="color:<?php echo $class_own; ?>"> Owned&nbsp;</span></label></td>
		<?php } ?>
		<?php	
				if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_nonowned = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_nonowned = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_nonowned = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_nonowned = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_nonowned = $success_aip_file ;
				else
				$success_arr_nonowned = $vendor_autodata ;

				$success_aip_nonowned = '';
				for( $nown=0; $nown<count($success_arr_nonowned); $nown++ ){
					if($autodata->applies_to_nonowned == 'nonowned'){
						if( $autodata->applies_to_nonowned == $success_arr_nonowned[$nown]->aip_applies_nonowned ){
							$success_aip_nonowned[] = $success_arr_nonowned[$nown];
						}
					}
				}
				
				if($success_aip_nonowned)
					$class_nown = '';
				else
					$class_nown = 'red';
					
		?>
		<?php if($autodata->applies_to_nonowned) { ?>		
		<td><input type="checkbox" name="applies_to_nonowned" class="<?php echo $class_cert_3; ?>" value="nonowned" <?php echo $nonowned; ?> /></td><td><label><span style="color:<?php echo $class_nown; ?>">Non-Owned&nbsp;</span></label></td>
		<?php } ?>
		<?php	if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_hired = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_hired = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_hired = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_hired = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_hired = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_hired = $success_aip_file ;
				else
				$success_arr_hired = $vendor_autodata ;
				
				$success_aip_hired = '';	
				for( $hir=0; $hir<count($success_arr_hired); $hir++ ){
					if($autodata->applies_to_hired == 'hired'){
						if( $autodata->applies_to_hired == $success_arr_hired[$hir]->aip_applies_hired ){
							$success_aip_hired[] = $success_arr_hired[$hir];
						}
					}
				}
				
				if($success_aip_hired)
					$class_hire = '';
				else
					$class_hire = 'red';
					
		?>
		<?php if($autodata->applies_to_hired) { ?>		
		<td><input type="checkbox" name="applies_to_hired" class="<?php echo $class_cert_4; ?>" value="hired" <?php echo $hired; ?> /></td> <td><label><span style="color:<?php echo $class_hire; ?>">Hired&nbsp;</span></label></td>
		<?php } ?>
		<?php	
				if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_sch = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_sch = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_sch = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_sch = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_sch = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_sch = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_sch = $success_aip_file ;
				else
				$success_arr_sch = $vendor_autodata ;
				
				$success_aip_sch = '';
				for( $sch=0; $sch<count($success_arr_sch); $sch++ ){
					if($autodata->applies_to_scheduled == 'scheduled'){
						if( $success_arr_sch[$sch]->aip_applies_scheduled == 'sch' ){
							$success_aip_sch[] = $success_arr_sch[$sch];
						}
					}
				}
				
				if($success_aip_sch)
					$class_sch = '';
				else
					$class_sch = 'red';
					
		?>
		<?php if($autodata->applies_to_scheduled) { ?>		
		<td><input type="checkbox" name="applies_to_scheduled" class="<?php echo $class_cert_5; ?>" value="scheduled" <?php echo $scheduled; ?> /></td><td> <label>
		<span style="color:<?php echo $class_sch; ?>">Scheduled</span></label></td>
		<?php } ?>
		<?php if($autodata->applies_to_any || $autodata->applies_to_owned || $autodata->applies_to_nonowned || $autodata->applies_to_hired || $autodata->applies_to_scheduled){ ?>		
</tr></table></li>
		<?php } ?>
		
		<?php	
				if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_com = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_com = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_com = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_com = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_com = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_com = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_com = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_com = $success_aip_file ;
				else
				$success_arr_com = $vendor_autodata ;
				
				$success_aip_com = '';
				for( $com=0; $com<count($success_arr_com); $com++ ){
					if( $autodata->combined_single <= $success_arr_com[$com]->aip_combined ){
							$success_aip_com[] = $success_arr_com[$com];
						}
				}
				
				if($success_aip_com)
					$class_com = '';
				else
					$class_com = 'red';
					
		?>
		
		<?php if($autodata->combined_single  && $autodata->combined_single != '0.00'){ ?>
		<li><span style="color:<?php echo $class_com; ?>">Combined Single Limit: <?php echo "$".number_format($autodata->combined_single,2); ?></span></li>
		<?php } ?>		
		<?php	
				if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_body = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_body = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_body = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_body = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_body = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_body = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_body = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_body = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_body = $success_aip_file ;
				else
				$success_arr_body = $vendor_autodata ;
				
				$success_aip_bod = '';
				for( $bod=0; $bod<count($success_arr_body); $bod++ ){
					if( $autodata->bodily_injusy_person <= $success_arr_body[$bod]->aip_bodily ){
							$success_aip_bod[] = $success_arr_body[$bod];
						}
				}
				if($success_aip_bod)
					$class_bod = '';
				else
					$class_bod = 'red';
					
		?>
		<?php if($autodata->bodily_injusy_person && $autodata->bodily_injusy_person != '0.00'){ ?>
		<li><span style="color:<?php echo $class_bod; ?>">Bodily Injury - Per Person: <?php echo "$".number_format($autodata->bodily_injusy_person,2); ?></span></li>
		<?php } ?>	
		<?php	
				if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_acc = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_acc = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_acc = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_acc = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_acc = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_acc = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_acc = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_acc = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_acc = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_acc = $success_aip_file ;
				else
				$success_arr_acc = $vendor_autodata ;
				
				$success_aip_acc = '';
				for( $acc=0; $acc<count($success_arr_acc); $acc++ ){
					if( $autodata->bodily_injusy_accident <= $success_arr_acc[$acc]->aip_body_injury ){
							$success_aip_acc[] = $success_arr_acc[$acc];
						}
				}
				if($success_aip_acc)
					$class_acc = '';
				else
					$class_acc = 'red';
					
		?>	
		<?php if($autodata->bodily_injusy_accident && $autodata->bodily_injusy_accident != '0.00'){ ?>
		<li><span style="color:<?php echo $class_acc; ?>">Bodily Injury - Per Accident: <?php echo "$".number_format($autodata->bodily_injusy_accident,2); ?></span></li>
		<?php } ?>
		<?php	
				if( count($success_aip_acc) >= 1 && !empty($success_aip_acc) )
				$success_arr_pro = $success_aip_acc ;
				else if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_pro = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_pro = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_pro = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_pro = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_pro = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_pro = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_pro = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_pro = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_pro = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_pro = $success_aip_file ;
				else
				$success_arr_pro = $vendor_autodata ;
				
				$success_aip_pro = '';
				for( $pro=0; $pro<count($success_arr_pro); $pro++ ){
					if( $autodata->property_damage <= $success_arr_pro[$pro]->aip_property ){
							$success_aip_pro[] = $success_arr_pro[$pro];
						}
				}
				if($success_aip_pro)
					$class_pro = '';
				else
					$class_pro = 'red';
					
		?>			
		<?php if($autodata->property_damage && $autodata->property_damage != '0.00'){ ?>
		<li><span style="color:<?php echo $class_pro; ?>">Property Damage - Per Accident: <?php echo "$".number_format($autodata->property_damage,2); ?></span></li>
		<?php } ?>
		<?php	
				if( count($success_aip_pro) >= 1 && !empty($success_aip_pro) )
				$success_arr_waiver = $success_aip_pro ;
				else if( count($success_aip_acc) >= 1 && !empty($success_aip_acc) )
				$success_arr_waiver = $success_aip_acc ;
				else if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_waiver = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_waiver = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_waiver = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_waiver = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_waiver = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_waiver = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_waiver = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_waiver = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_waiver = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_waiver = $success_aip_file ;
				else
				$success_arr_waiver = $vendor_autodata ;

				$success_aip_wai = '';
				for( $wai=0; $wai<count($success_arr_waiver); $wai++ ){
					if( $autodata->waiver == 'yes' ){	
						if( $success_arr_waiver[$wai]->aip_waiver == 'waiver' ){
							$success_aip_wai[] = $success_arr_waiver[$wai];
						}
					}	
				}
				if($success_aip_wai)
					$class_wai = '';
				else
					$class_wai = 'red';
					
		?>		
		<?php if($autodata->waiver){ ?>
		<?php if($autodata->waiver == 'yes'){ $waiv = 'checked="checked"'; $class_waiver = 'styled'; }?>
		<li><input type="checkbox" value="yes" name="waiver" <?php echo $waiv; ?> class="<?php echo $class_waiver; ?>" /> <label><span style="color:<?php echo $class_wai; ?>">Waiver of Subrogation</span></label></li>
		<?php } ?>
		<?php	
				if( count($success_aip_wai) >= 1 && !empty($success_aip_wai) )
				$success_arr_primary = $success_aip_wai ;
				else if( count($success_aip_pro) >= 1 && !empty($success_aip_pro) )
				$success_arr_primary = $success_aip_pro ;
				else if( count($success_aip_acc) >= 1 && !empty($success_aip_acc) )
				$success_arr_primary = $success_aip_acc ;
				else if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_primary = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_primary = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_primary = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_primary = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_primary = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_primary = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_primary = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_primary = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_primary = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_primary = $success_aip_file ;
				else
				$success_arr_primary = $vendor_autodata ;
				
				$success_aip_pri = '';
				for( $pri=0; $pri<count($success_arr_primary); $pri++ ){
					if( $autodata->primary == 'yes' ){	
						if( $success_arr_primary[$pri]->aip_primary == 'primary' ){
							$success_aip_pri[] = $success_arr_primary[$pri];
						}
					}	
				}
				if($success_aip_pri)
					$class_pri = '';
				else
					$class_pri = 'red';
					
		?>		
		<?php if($autodata->primary){ ?>
		<?php if($autodata->primary == 'yes'){ $prim = 'checked="checked"'; $class_primary = 'styled';} ?>
		<li><input type="checkbox" value="yes" name="primary" <?php echo $prim; ?>  class="<?php echo $class_primary; ?>" /><label> <span style="color:<?php echo $class_pri; ?>">Primary Non-Contributory</span></label></li>
		<?php } ?>
		<?php	
				if( count($success_aip_pri) >= 1 && !empty($success_aip_pri) )
				$success_arr_addi = $success_aip_pri ;
				else if( count($success_aip_wai) >= 1 && !empty($success_aip_wai) )
				$success_arr_addi = $success_aip_wai ;
				else if( count($success_aip_pro) >= 1 && !empty($success_aip_pro) )
				$success_arr_addi = $success_aip_pro ;
				else if( count($success_aip_acc) >= 1 && !empty($success_aip_acc) )
				$success_arr_addi = $success_aip_acc ;
				else if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_addi = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_addi = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_addi = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_addi = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_addi = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_addi = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_addi = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_addi = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_addi = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_addi = $success_aip_file ;
				else
				$success_arr_addi = $vendor_autodata ;
				
				$success_aip_addi = '';
				for( $add=0; $add<count($success_arr_addi); $add++ ){
					if( $autodata->additional_ins == 'yes' ){	
						if( $success_arr_addi[$add]->aip_addition ){
							$success_aip_addi[] = $success_arr_addi[$add];
						}
					}	
				}
				if($success_aip_addi)
					$class_addi = '';
				else
					$class_addi = 'red';
					
		?>
		<?php if($autodata->additional_ins){ ?>
		<?php if($autodata->additional_ins == 'yes'){ $add = 'checked="checked"'; $class_additional_ins = 'styled';} ?>
		<li><input type="checkbox" value="yes" name="additional_ins" <?php echo $add; ?> class="<?php echo $class_additional_ins; ?>" /> <label><span style="color:<?php echo $class_addi; ?>">List my Company as as "Additional Insured"</span></label></li>
		<?php } ?>
		<?php	
				if( count($success_aip_addi) >= 1 && !empty($success_aip_addi) )
				$success_arr_cert = $success_aip_addi ;
				else if( count($success_aip_pri) >= 1 && !empty($success_aip_pri) )
				$success_arr_cert = $success_aip_pri ;
				else if( count($success_aip_wai) >= 1 && !empty($success_aip_wai) )
				$success_arr_cert = $success_aip_wai ;
				else if( count($success_aip_pro) >= 1 && !empty($success_aip_pro) )
				$success_arr_cert = $success_aip_pro ;
				else if( count($success_aip_acc) >= 1 && !empty($success_aip_acc) )
				$success_arr_cert = $success_aip_acc ;
				else if( count($success_aip_bod) >= 1 && !empty($success_aip_bod) )
				$success_arr_cert = $success_aip_bod ;
				else if( count($success_aip_com) >= 1 && !empty($success_aip_com) )
				$success_arr_cert = $success_aip_com ;
				else if( count($success_aip_sch) >= 1 && !empty($success_aip_sch) )
				$success_arr_cert = $success_aip_sch ;
				else if( count($success_aip_hired) >= 1 && !empty($success_aip_hired) )
				$success_arr_cert = $success_aip_hired ;
				else if( count($success_aip_nonowned) >= 1 && !empty($success_aip_nonowned) )
				$success_arr_cert = $success_aip_nonowned ;
				else if( count($success_aip_owned) >= 1 && !empty($success_aip_owned) )
				$success_arr_cert = $success_aip_owned ;
				else if( count($success_aip_any) >= 1 && !empty($success_aip_any) )
				$success_arr_cert = $success_aip_any ;
				else if( count($success_aip_rej) >= 1 && !empty($success_aip_rej) )
				$success_arr_cert = $success_aip_file ;
				else if( count($success_aip_exp) >= 1 && !empty($success_aip_exp) )
				$success_arr_cert = $success_aip_exp ;
				else if( count($success_aip_file) >= 1 && !empty($success_aip_file) )
				$success_arr_cert = $success_aip_file ;
				else
				$success_arr_cert = $vendor_autodata ;

				$success_aip_cert = '';
				for( $cert=0; $cert<count($success_arr_cert); $cert++ ){
					if( $autodata->cert_holder == 'yes' ){	
						if( $success_arr_cert[$cert]->aip_cert == 'yes' ){
							$success_aip_cert[] = $success_arr_cert[$cert];
						}
					}	
				}
				if($success_aip_cert)
					$class_cert = '';
				else
					$class_cert = 'red';
					
		?>
		<?php if($autodata->cert_holder){ ?>
		<?php if($autodata->cert_holder == 'yes'){ $cert = 'checked="checked"'; $class_cert_holder2 = 'styled';} ?>
		<li><input type="checkbox" value="yes" name="cert_holder" <?php echo $cert; ?> class="<?php echo $class_cert_holder2; ?>"  /> <label><span style="color:<?php echo $class_cert; ?>">MyVendorCenter listed as Cert. Holder</span></label></li>
		<?php } ?>
		</ul>
	
	</td></tr>
	<?php } ?>
	<tr id="autoliability_sub"></tr>
	<?php
		if($workdata){ $work_main = 'checked="checked"'; $class_work="styled active";
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="workersliability" class="<?php echo $class_work; ?>" name="workersliability" <?php echo $work_main; ?> /></td><td><strong>Worker`s Comp Policy/Employer`s Liability</strong></td></tr>
	<?php } ?>
	<tr><td></td><td>
	<?php if($workdata){  ?>
	<ul class="pre_workers">
	<?php
			$success_wci_file = '';
			for( $file=0; $file<count($vendor_workdata); $file++ ){
							if($vendor_workdata[$file]->WCI_upld_cert){
							$success_wci_file[] = $vendor_workdata[$file];
						}
					}
			if(!$success_wci_file) { ?>
			<li><span style="color:red;">No Certificate Uploaded</span></li>
			<?php }
			?>
			<?php 
				if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_exp = $success_wci_file ;
				else
				$success_arr_exp = $vendor_workdata ;
				$success_wci_exp = '';
				
			for( $exp=0; $exp<count($success_arr_exp); $exp++ ){
				if( $success_arr_exp[$exp]->WCI_end_date > date('Y-m-d') ){
					$success_wci_exp[] = $success_arr_exp[$exp];
				}
			}
			if(!$success_wci_exp && $success_wci_file ) { ?>
			<li><span style="color:red;">Expired</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_rej = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_rej = $success_wci_file ;
				else
				$success_arr_rej = $vendor_workdata ;
				
				$success_wci_rej = '';
				
			for( $rej=0; $rej<count($success_arr_rej); $rej++ ){
				if( $success_arr_rej[$rej]->WCI_status == '-1' ){
					$success_wci_rej[] = $success_arr_rej[$rej];
				}
			}
			if($success_wci_rej) { ?>
			<li><span style="color:red;">Rejected By MyVC</span></li>
			<?php }
			?>
			
		<?php 
		$work_main = '';
		$class_work = '';
		if($workdata->workers_not == 'not') {
		$not = 'checked="checked"';
		if($workdata->workers_not){ ?>
		<li><input type="radio" id="workers_not" <?php echo $not; ?> style="vertical-align:top;"  /> Worker`s Comp Exemptions NOT accepted</li>
		<?php } ?>	
		<li><ul class="notaccepted" style="list-style-type:none;"><li>
		
			<?php
				if( count($success_wci_rej) >= 1 && !empty($success_wci_rej) )
				$success_arr_eachacc = $success_wci_rej ;
				else if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_eachacc = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_eachacc = $success_wci_file ;
				else
				$success_arr_eachacc = $vendor_workdata ;
				
				for( $ea=0; $ea<count($success_arr_eachacc); $ea++ ){
					if( $workdata->each_accident <= $success_arr_eachacc[$ea]->WCI_each_accident ){
							$success_wci_each[] = $success_arr_eachacc[$ea];
						}
				}
				if($success_wci_each)
					$class_each = '';
				else
					$class_each = 'red';
			?>	
		<?php if($workdata->each_accident && $workdata->each_accident !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_each; ?>">Each Accident: <?php echo "$".number_format($workdata->each_accident,2); ?></span></li>
		<?php } ?>	
			<?php
				if( count($success_wci_each) >= 1 && !empty($success_wci_each) )
				$success_arr_desc = $success_wci_each ;
				else if( count($success_wci_rej) >= 1 && !empty($success_wci_rej) )
				$success_arr_desc = $success_wci_rej ;
				else if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_desc = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_desc = $success_wci_file ;
				else
				$success_arr_desc = $vendor_workdata ;
				$success_wci_des = '';
				for( $des=0; $des<count($success_arr_desc); $des++ ){
					if( $workdata->disease_policy <= $success_arr_desc[$des]->WCI_disease_policy ){
							$success_wci_des[] = $success_arr_desc[$des];
						}
				}
				if($success_wci_des)
					$class_des = '';
				else
					$class_des = 'red';
			?>	
		<?php if($workdata->disease_policy && $workdata->disease_policy !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_des; ?>">Desease - Policy Limit: <?php echo "$".number_format($workdata->disease_policy,2); ?></span></li>
		<?php } ?>	
		<?php
				if( count($success_wci_des) >= 1 && !empty($success_wci_des) )
				$success_arr_emp = $success_wci_des ;
				else if( count($success_wci_each) >= 1 && !empty($success_wci_each) )
				$success_arr_emp = $success_wci_each ;
				else if( count($success_wci_rej) >= 1 && !empty($success_wci_rej) )
				$success_arr_emp = $success_wci_rej ;
				else if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_emp = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_emp = $success_wci_file ;
				else
				$success_arr_emp = $vendor_workdata ;
				
				$success_wci_emp = '';
				for( $emp=0; $emp<count($success_arr_emp); $emp++ ){
					if( $workdata->disease_eachemp <= $success_arr_emp[$emp]->WCI_disease ){
							$success_wci_emp[] = $success_arr_emp[$emp];
						}
				}
				if($success_wci_emp)
					$class_emp = '';
				else
					$class_emp = 'red';
			?>		
		<?php if($workdata->disease_eachemp && $workdata->disease_eachemp !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_emp; ?>">Desease - Each Employee: <?php echo "$".number_format($workdata->disease_eachemp,2); ?></span></li>
		<?php } ?>
		<?php
				if( count($success_wci_emp) >= 1 && !empty($success_wci_emp) )
				$success_arr_waiver = $success_wci_emp ;
				else if( count($success_wci_des) >= 1 && !empty($success_wci_des) )
				$success_arr_waiver = $success_wci_des ;
				else if( count($success_wci_each) >= 1 && !empty($success_wci_each) )
				$success_arr_waiver = $success_wci_each ;
				else if( count($success_wci_rej) >= 1 && !empty($success_wci_rej) )
				$success_arr_waiver = $success_wci_rej ;
				else if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_waiver = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_waiver = $success_wci_file ;
				else
				$success_arr_waiver = $vendor_workdata ;
				
				$success_wci_waiv = '';
				for( $waiv=0; $waiv<count($success_arr_waiver); $waiv++ ){
					if($workdata->waiver_work == 'yes'){
						if( $success_arr_waiver[$waiv]->WCI_waiver == 'waiver' ){
								$success_wci_waiv[] = $success_arr_waiver[$waiv];
							}
					}	
				}
				if($success_wci_waiv)
					$class_waiv = '';
				else
					$class_waiv = 'red';
			?>
		<?php if($workdata->waiver_work){ ?>
		<?php if($workdata->waiver_work == 'yes'){ $waiver_work = 'checked="checked"'; $class_waiver_work = 'styled';}?>
		<li><input type="checkbox" value="yes" name="waiver_work" <?php echo $waiver_work; ?> class="<?php echo $class_waiver_work; ?>" /> <label><span style="color:<?php echo $class_waiv; ?>">Waiver of Subrogation</span></label></li>
		<?php } ?>
		<?php
				if( count($success_wci_waiv) >= 1 && !empty($success_wci_waiv) )
				$success_arr_cert = $success_wci_waiv ;
				else if( count($success_wci_emp) >= 1 && !empty($success_wci_emp) )
				$success_arr_cert = $success_wci_emp ;
				else if( count($success_wci_des) >= 1 && !empty($success_wci_des) )
				$success_arr_cert = $success_wci_des ;
				else if( count($success_wci_each) >= 1 && !empty($success_wci_each) )
				$success_arr_cert = $success_wci_each ;
				else if( count($success_wci_rej) >= 1 && !empty($success_wci_rej) )
				$success_arr_cert = $success_wci_rej ;
				else if( count($success_wci_exp) >= 1 && !empty($success_wci_exp) )
				$success_arr_cert = $success_wci_exp ;
				else if( count($success_wci_file) >= 1 && !empty($success_wci_file) )
				$success_arr_cert = $success_wci_file ;
				else
				$success_arr_cert = $vendor_workdata ;
				
				$success_wci_cert = '';
				for( $cer=0; $cer<count($success_arr_cert); $cer++ ){
					if($workdata->certholder_work == 'yes'){
						if( $success_arr_cert[$cer]->WCI_cert == 'yes' ){
								$success_wci_cert[] = $success_arr_cert[$cer];
							}
					}	
				}
				if($success_wci_cert)
					$class_cert = '';
				else
					$class_cert = 'red';
			?>
		<?php if($workdata->certholder_work){ ?>
		<?php if($workdata->certholder_work == 'yes'){ $certholder_work = 'checked="checked"'; $class_certholder_work = 'styled';} ?>
		<li><input type="checkbox" value="yes" name="certholder_work" <?php echo $certholder_work; ?> class="<?php echo $class_certholder_work; ?>" /> <label><span style="color:<?php echo $class_cert; ?>">MyVendorCenter listed as Cert. Holder</label></li>
		</li></ul></li>
		<?php } ?>
		<?php 
		}
		else if($workdata->workers_not == 'yes'){ 
		$workers_accepted = 'checked="checked"';
		?>
		<li><input type="radio" id="workers_yes" name="workers_not" value="yes" <?php echo $workers_accepted; ?> style="vertical-align:top;" /> Worker`s Comp Exemptions accepted
		<br />WARNING: Worker`s Comp. Exemption Certificates are commonly mistaken for a Worker`s Comp policy. Please be aware that this "exemption" does NOT offer the property manager/association/building owner any form of protection against liability for an injured worker`s loss of wages and/or medical expenses if an on-the-job injury occurs. Consult your legal advisor for your unique situation, as laws vary by jurisdiction.
		</li>
		<?php } ?>
		</ul>
	
	</td></tr>
	<?php } ?>
	<tr id="workersliability_sub"></tr>
	<?php
		if($umbrelladata){ $umb_main = 'checked="checked"'; $class_umb = 'styled active';  
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="umbrellaliability" class="<?php echo $class_umb; ?>" name="umbrellaliability" <?php echo $umb_main; ?> /></td><td><strong>Umbrella Liability</strong></td></tr>
	<?php } ?>
	<?php if($umbrelladata){ ?>
	<tr><td></td><td>
	<ul class="pre_umbrella">
	<?php
			$success_umb_file = '';
			for( $file=0; $file<count($vendor_umbrelladata); $file++ ){
							if($vendor_umbrelladata[$file]->UMB_upld_cert){
							$success_umb_file[] = $vendor_umbrelladata[$file];
						}
					}
			if(!$success_umb_file) { ?>
			<li><span style="color:red;">No Certificate Uploaded</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_umb_file) >= 1 && !empty($success_umb_file) )
				$success_arr_exp = $success_umb_file ;
				else
				$success_arr_exp = $vendor_umbrelladata ;
				$success_umb_exp = '';
				
			for( $exp=0; $exp<count($success_arr_exp); $exp++ ){
				if( $success_arr_exp[$exp]->UMB_expdate > date('Y-m-d') ){
					$success_umb_exp[] = $success_arr_exp[$exp];
				}
			}
			if(!$success_umb_exp && $success_umb_file ) { ?>
			<li><span style="color:red;">Expired</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_umb_exp) >= 1 && !empty($success_umb_exp) )
				$success_arr_rej = $success_umb_exp ;
				else if( count($success_umb_file) >= 1 && !empty($success_umb_file) )
				$success_arr_rej = $success_umb_file ;
				else
				$success_arr_rej = $vendor_umbrelladata ;
				$success_umb_rej = '';
				
			for( $rej=0; $rej<count($success_arr_rej); $rej++ ){
				if( $success_arr_rej[$rej]->UMB_status == '-1' ){
					$success_umb_rej[] = $success_arr_rej[$rej];
				}
			}
			if($success_umb_rej) { ?>
			<li><span style="color:red;">Rejected By MyVC</span></li>
			<?php }
			?>
			
		<?php
				if( count($success_umb_rej) >= 1 && !empty($success_umb_rej) )
				$success_arr_rej = $success_umb_rej ;	
				else if( count($success_umb_exp) >= 1 && !empty($success_umb_exp) )
				$success_arr_rej = $success_umb_exp ;
				else if( count($success_umb_file) >= 1 && !empty($success_umb_file) )
				$success_arr_rej = $success_umb_file ;
				else
				$success_arr_rej = $vendor_umbrelladata ;
				
				$success_umb_each = '';	
				
				for( $each=0; $each<count($success_arr_rej); $each++ ){
						if( $umbrelladata->each_occur <= $success_arr_rej[$each]->UMB_occur ){
								$success_umb_each[] = $success_arr_rej[$each];
							}
				}
				if($success_umb_each)
					$class_each = '';
				else
					$class_each = 'red';
			?>
			
		<?php 
		$umb_main = '';
		$class_umb = '';
		if($umbrelladata->each_occur && $umbrelladata->each_occur !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_each; ?>">Each Occurrence: <?php echo "$".number_format($umbrelladata->each_occur,2); ?></span></li>
		<?php } ?>		
		<?php
				if( count($success_umb_each) >= 1 && !empty($success_umb_each) )
				$success_arr_agg = $success_umb_each ;
				else if( count($success_umb_rej) >= 1 && !empty($success_umb_rej) )
				$success_arr_agg = $success_umb_rej ;	
				else if( count($success_umb_exp) >= 1 && !empty($success_umb_exp) )
				$success_arr_agg = $success_umb_exp ;
				else if( count($success_umb_file) >= 1 && !empty($success_umb_file) )
				$success_arr_agg = $success_umb_file ;
				else 
				$success_arr_agg = $vendor_umbrelladata ;
				$success_umb_agg = '';
				for( $agg=0; $agg<count($success_arr_agg); $agg++ ){
						if( $umbrelladata->aggregate <= $success_arr_agg[$agg]->UMB_aggregate ){
								$success_umb_agg[] = $success_arr_agg[$agg];
							}
				}
				if($success_umb_agg)
					$class_agg = '';
				else
					$class_agg = 'red';
				
			?>
		<?php if($umbrelladata->aggregate && $umbrelladata->aggregate !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_agg; ?>">Aggregate: <?php echo "$".number_format($umbrelladata->aggregate,2); ?></span></li>
		<?php } ?>
		<?php
				if( count($success_umb_agg) >= 1 && !empty($success_umb_agg) )
				$success_arr_cert = $success_umb_agg ;
				else if( count($success_umb_each) >= 1 && !empty($success_umb_each) )
				$success_arr_cert = $success_umb_each ;
				else if( count($success_umb_rej) >= 1 && !empty($success_umb_rej) )
				$success_arr_cert = $success_umb_rej ;	
				else if( count($success_umb_exp) >= 1 && !empty($success_umb_exp) )
				$success_arr_cert = $success_umb_exp ;
				else if( count($success_umb_file) >= 1 && !empty($success_umb_file) )
				$success_arr_cert = $success_umb_file ;
				else 
				$success_arr_cert = $vendor_umbrelladata ;
				
				$success_umb_cert = '';	
				for( $cert=0; $cert<count($success_arr_cert); $cert++ ){
						if( $umbrelladata->certholder_umbrella == 'yes' ) {
							if( $success_arr_cert[$cert]->UMB_certholder == 'yes' ){
									$success_umb_cert[] = $success_arr_cert[$cert];
								}
						}	
				}
				if($success_umb_cert)
					$class_cert_umb = '';
				else
					$class_cert_umb = 'red';
			?>	
		<?php if($umbrelladata->certholder_umbrella){ ?>
		<?php if($umbrelladata->certholder_umbrella == 'yes'){ $waiver_umbrella = 'checked="checked"'; $class_certholder_umbrella = 'styled'; }?>
		<li><input type="checkbox" value="yes" name="certholder_umbrella" <?php echo $waiver_umbrella; ?> class="<?php echo $class_certholder_umbrella; ?>" /> <label><span style="color:<?php echo $class_cert_umb; ?>">MyVendorCenter listed as Cert. Holder</span></label></li>
		<?php } ?>	
		<?php 
//	$success_umb_agg = '';
//	$success_umb_each = '';
//	$success_arr_cert = '';
//	count($success_umb_agg) = '';
	?>
		</ul>
	</td></tr>
		<?php } ?>	
	<tr id="umbrellaliability_sub"></tr>
	<?php
		
		if($licdata){ $lic_main = 'checked="checked"'; $class_lic = 'styled active'; 
	?>
	<tr height="15"></tr>
	<tr><td><input type="checkbox" value="yes" id="licensingliability" class="<?php echo $class_lic; ?>" name="licensingliability" <?php echo $lic_main; ?> /></td><td><strong>Licensing</strong></td></tr>
	<?php } ?>
	<?php if($licdata){ ?>
	<tr><td></td><td>
	<ul class="pre_lic">
			<?php
				$success_lic_pro = '';
				for( $pro=0; $pro<count($vendor_licdata); $pro++ ){
						if( $licdata->professional == 'yes' ) {
							if( $vendor_licdata[$pro]->PLN_expdate >= date('Y-m-d') && $vendor_licdata[$pro]->PLN_upld_cert && $vendor_licdata[$pro]->PLN_status == '1' ){
								$success_lic_pro[] = $vendor_licdata[$pro];
							}
						}	
				}
				if($success_lic_pro)
					$class_pro_lic = '';
				else
					$class_pro_lic = 'red';
					
					
				
				$success_occ_pro = '';
				for( $occ=0; $occ<count($vendor_occdata); $occ++ ){
						if( $licdata->occupational == 'yes' ) {
							if( $vendor_occdata[$occ]->OLN_expdate >= date('Y-m-d') && $vendor_occdata[$occ]->OLN_upld_cert && $vendor_occdata[$occ]->OLN_status == '1' ){
								$success_occ_pro[] = $vendor_occdata[$occ];
							}
						}	
				}
				if($success_occ_pro)
					$class_pro_occ = '';
				else
					$class_pro_occ = 'red';
						
			?>
			
		<?php 
		$lic_main = '';
		$class_lic = '';
		if($licdata->professional){ ?>
		<?php if($licdata->professional == 'yes'){ $professional = 'checked="checked"'; $class_professional = 'styled';}?>
		<li><input type="checkbox" value="yes" name="professional" <?php echo $professional; ?> class="<?php echo $class_professional; ?>" /> <label><span style="color:<?php echo $class_pro_lic; ?>">Professional License</span></label></li>
		<?php } ?>		
		<?php if($licdata->occupational){ ?>
		<?php if($licdata->occupational == 'yes'){ $occupational = 'checked="checked"'; $class_occupational = 'styled';}?>
		<li><input type="checkbox" value="yes" name="occupational" <?php echo $occupational; ?> class="<?php echo $class_occupational; ?>" /> <label><span style="color:<?php echo $class_pro_occ; ?>">Occupational License</span></label></li>
		<?php } ?>	
		</ul>
	</td></tr>
		<?php } ?>	
	<tr id="licensingliability_sub"></tr>
	
	<?php
		if($omidata){ $omi_main = 'checked="checked"'; $class_omi = 'styled active';  
	?>
	<tr><td width="10">
	<input type="checkbox" value="yes" id="errorsomissions" class="<?php echo $class_omi; ?>" name="errorsomissions" <?php echo $omi_main; ?> /></td><td><strong><label style="display:block; padding-top:3px;">Errors & Omissions</label></strong></td></tr>
	<?php } ?>
	<?php if($omidata){ ?>
	<tr><td></td><td>
	<ul class="pre_omi">
	<?php
			$success_omi_file = '';
			for( $file=0; $file<count($vendor_omidata); $file++ ){
							if($vendor_omidata[$file]->OMI_upld_cert){
							$success_omi_file[] = $vendor_omidata[$file];
						}
					}
			if(!$success_omi_file) { ?>
			<li><span style="color:red;">No Certificate Uploaded</span></li>
			<?php }
			?>

			<?php 
				if( count($success_omi_file) >= 1 && !empty($success_omi_file) )
				$success_arr_exp = $success_omi_file ;
				else
				$success_arr_exp = $vendor_omidata ;
				$success_omi_exp = '';
				
			for( $exp=0; $exp<count($success_arr_exp); $exp++ ){
				if( $success_arr_exp[$exp]->OMI_end_date >= date('Y-m-d') ){
					$success_omi_exp[] = $success_arr_exp[$exp];
				}
			}
			if(!$success_omi_exp && $success_omi_file ) { ?>
			<li><span style="color:red;">Expired</span></li>
			<?php }
			?>
			
			<?php 
				if( count($success_omi_exp) >= 1 && !empty($success_omi_exp) )
				$success_arr_rej = $success_omi_exp ;
				else if( count($success_omi_file) >= 1 && !empty($success_omi_file) )
				$success_arr_rej = $success_omi_file ;
				else
				$success_arr_rej = $vendor_omidata ;
				$success_omi_rej = '';
				
			for( $rej=0; $rej<count($success_arr_rej); $rej++ ){
				if( $success_arr_rej[$rej]->OMI_status == '-1' ){
					$success_omi_rej[] = $success_arr_rej[$rej];
				}
			}
			if($success_omi_rej) { ?>
			<li><span style="color:red;">Rejected By MyVC</span></li>
			<?php }
			?>
			
		<?php
				if( count($success_omi_rej) >= 1 && !empty($success_omi_rej) )
				$success_arr_rej = $success_omi_rej ;	
				else if( count($success_omi_exp) >= 1 && !empty($success_omi_exp) )
				$success_arr_rej = $success_omi_exp ;
				else if( count($success_omi_file) >= 1 && !empty($success_omi_file) )
				$success_arr_rej = $success_omi_file ;
				else
				$success_arr_rej = $vendor_omidata ;
				
				$success_omi_each = '';	
				
				for( $each=0; $each<count($success_arr_rej); $each++ ){
						if( $omidata->each_claim <= $success_arr_rej[$each]->OMI_each_claim ){
								$success_omi_each[] = $success_arr_rej[$each];
							}
				}
				if($success_omi_each)
					$class_each = '';
				else
					$class_each = 'red';
			?>
			
		<?php 
		$omi_main = '';
		$class_omi = '';
		if($omidata->each_claim && $omidata->each_claim !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_each; ?>">Each Claim: <?php echo "$".number_format($omidata->each_claim,2); ?></span></li>
		<?php } ?>		
		<?php
				if( count($success_omi_each) >= 1 && !empty($success_omi_each) )
				$success_arr_agg = $success_omi_each ;
				else if( count($success_omi_rej) >= 1 && !empty($success_omi_rej) )
				$success_arr_agg = $success_omi_rej ;	
				else if( count($success_omi_exp) >= 1 && !empty($success_omi_exp) )
				$success_arr_agg = $success_omi_exp ;
				else if( count($success_omi_file) >= 1 && !empty($success_omi_file) )
				$success_arr_agg = $success_omi_file ;
				else 
				$success_arr_agg = $vendor_omidata ;
				$success_omi_agg = '';
				for( $agg=0; $agg<count($success_arr_agg); $agg++ ){
						if( $omidata->aggregate_omi <= $success_arr_agg[$agg]->OMI_aggregate ){
								$success_omi_agg[] = $success_arr_agg[$agg];
							}
				}
				if($success_omi_agg)
					$class_agg = '';
				else
					$class_agg = 'red';
				
			?>
		<?php if($omidata->aggregate_omi && $omidata->aggregate_omi !='0.00' ){ ?>
		<li><span style="color:<?php echo $class_agg; ?>">Aggregate: <?php echo "$".number_format($omidata->aggregate_omi,2); ?></span></li>
		<?php } ?>
		<?php
				if( count($success_omi_agg) >= 1 && !empty($success_omi_agg) )
				$success_arr_cert = $success_omi_agg ;
				else if( count($success_omi_each) >= 1 && !empty($success_omi_each) )
				$success_arr_cert = $success_omi_each ;
				else if( count($success_omi_rej) >= 1 && !empty($success_omi_rej) )
				$success_arr_cert = $success_omi_rej ;	
				else if( count($success_omi_exp) >= 1 && !empty($success_omi_exp) )
				$success_arr_cert = $success_omi_exp ;
				else if( count($success_omi_file) >= 1 && !empty($success_omi_file) )
				$success_arr_cert = $success_omi_file ;
				else 
				$success_arr_cert = $vendor_omidata ;
				
				$success_omi_cert = '';	
				for( $cert=0; $cert<count($success_arr_cert); $cert++ ){
						if( $omidata->certholder_omi == 'yes' ) {
							if( $success_arr_cert[$cert]->OMI_cert == 'yes' ){
									$success_omi_cert[] = $success_arr_cert[$cert];
								}
						}	
				}
				if($success_omi_cert)
					$class_cert_omi = '';
				else
					$class_cert_omi = 'red';
			?>	
		<?php if($omidata->certholder_omi){ ?>
		<?php if($omidata->certholder_omi == 'yes'){ $waiver_omi = 'checked="checked"'; $class_certholder_omi = 'styled'; }?>
		<li><input type="checkbox" value="yes" name="certholder_omi" <?php echo $waiver_omi; ?> class="<?php echo $class_certholder_omi; ?>" /> <label><span style="color:<?php echo $class_cert_omi; ?>">MyVendorCenter listed as Cert. Holder</span></label></li>
		<?php } ?>	
		<?php 
//	$success_umb_agg = '';
//	$success_umb_each = '';
//	$success_arr_cert = '';
//	count($success_umb_agg) = '';
	?>
		</ul>
	</td></tr>
		<?php } ?>
			
	<tr height="15"></tr>
	</table></div>
		 </div>
</div>

<div class="clear"></div>
</div>
</body>
</html>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">DECLINED</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_declined"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskex"></div>
</div>


<div id="boxesexg" style="top:576px; left:582px;">
<div id="submitexg" class="windowexg" style="top:300px; left:582px; border:6px solid #609e00; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 #609e00; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ACCEPTED</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_accepted"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelexg" name="doneexg" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexg"></div>
</div>


<div id="boxesexgr" style="top:576px; left:582px;">
<div id="submitexgr" class="windowexgr" style="top:300px; left:582px; border:6px solid #609e00; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 gray; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">UNREAD</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_notread"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelexgr" name="doneexgr" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexgr"></div>
</div>
<?php exit; ?>