<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
error_reporting(0) ;
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
$vendor_GLI_compliance_alert = $this->vendor_GLI_compliance_alert;

$states = $this->states;

$GLI_policy = $this->GLI_policy_configurations;

$liscense_categories = $this->liscense_categories;

$PLN_needed = $this->PLN_needed;

$W9_data = $this->W9_data;
 
$WCI_data = $this->WCI_data;
$AIP_data = $this->AIP_data;
$WC_data = $this->WC_data;
$GLI_data = $this->GLI_data;

$OLN_data = $this->OLN_data;

$PLN_data = $this->PLN_data;
$UMB_data = $this->UMB_data;

$OMI_data = $this->OMI_data;
$OMI_count = count($OMI_data);

$OLN_count = count($OLN_data);
$AIP_count = count($AIP_data);
$UMB_count = count($UMB_data);
if($OLN_count == 0)

$OLN_count = 1;

$PLN_count = count($PLN_data);

$GLI_count = count($GLI_data);

$WCI_count = count($WCI_data);

if($OMI_count == 0)
$OMI_count = 1;

if($AIP_count == 0)
$AIP_count = 1;
if($WCI_count == 0)

$WCI_count = 1;

$WC_count = count($WC_data);
if($UMB_count == 0)
$UMB_count = 1;

if($WC_count == 0)

$WC_count = 1;

$GLI_phone = explode('-',$GLI_data[0]->GLI_phone_number);

$WCI_phone = explode('-',$WCI_data[0]->WCI_phone_number);
$vendordata = $this->vendata ;
//echo "<pre>"; print_r($GLI_data);

// Your custom code here



?>
<title>Vendor Profile</title>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />

<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

<script src="objects.js" type="text/javascript"></script>

<script type="text/javascript">

G = jQuery.noConflict();

var PLN_needed='<?PHP echo $PLN_needed; ?>';

var OLN_compliance =  '<?PHP echo $OLN_count; ?>';

var PLN_compliance = '<?PHP echo $PLN_count; ?>';

var GLI_compliance = '<?PHP echo $GLI_count; ?>';
var UMB_compliance = '<?PHP echo $UMB_count; ?>';
var WCI_compliance = '<?PHP echo $WCI_count; ?>';
var WC_compliance = '<?PHP echo $WC_count; ?>';
var AIP_compliance = '<?PHP echo $AIP_count; ?>';
var OLN_title='<?PHP echo $OLN_count; ?>';

var PLN_title='<?PHP echo $PLN_count; ?>';
var UMB_title='<?PHP echo $UMB_count; ?>';
var GLI_title='<?PHP echo $GLI_count; ?>';
var AIP_title='<?PHP echo $AIP_count; ?>';
var WCI_title='<?PHP echo $WCI_count; ?>';
var WC_title='<?PHP echo $WC_count; ?>';
<?php 
$userl =& JFactory::getUser();
$id = JRequest::getVar('id','');
			if(!$id) { 
			$id = $userl->id ;
			 } 
			 else{
			$id = $id ; 
			 }
 ?>
function closewindows(){
window.parent.document.getElementById( 'sbox-window' ).close(); 
}

</script>
<style type="text/css">

.lic-pan{ border:1px solid #c0c0c0; padding:0 0 35px; position:relative; width:650px; margin-bottom:80px; margin-left:4px;}
.lic-pan h2{ font-size:14px; color:#fff; margin:0px 0px 10px; padding:8px 0; text-transform:uppercase; position:relative; float: left; width:650px; text-align:center; padding:8px 0; position:relative; text-align:center; width:100%; background:none repeat scroll 0 0 gray; line-height:14px;}
.lic-pan h2 img{ position:absolute; left:0px; top:6px;}
.lic-pan-left{ width:153px; float:left; padding:0 8px 0 15px;}
.imag-display{ width:127px; height:135px; line-height:22px; background:#d5d4d4; border:1px solid #72aa00; text-align:center; padding:8px; display:table;}
.rmv{ padding:4px 0px 10px 0px;}
/* .rmv span {position: absolute; top:-2px; left: 150px;} */
.rmv img{ position:relative; left:-6px;}
/*.comm{ padding:5px 0px;}*/
.comm{ padding-left:0px; padding-right:0px; padding-bottom:5px; margin-top:-3px; }
.comm label{color:#636363; font-size:12px; font-weight:bold; display:block;}
.comm input{ border:1px solid #abadb3; padding:3px;}
.bak{ background:#f7f7f7; border:2px solid #72aa00 !important; text-align:center; padding:0px; margin:0px;}
.lic-pan-right{ float:left; width:472px;}
.in-pan{ float:left; width:270px; padding-bottom:5px;}
/*.in-pan1{ float:left; width:200px;}*/
.in-pan1{ float:left; width:200px; padding-bottom:5px;}
.sve{ float:right; width:288px; padding-top:15px;}
.clear{ clear:both;}
.verf {
  bottom: -20px;
  left: 0;
  position: absolute;
  text-align: center;
  width: 100%;
}

.verfirst{
  bottom: -26px;
  left: 0;
  position: absolute;
  text-align: center;
  width: 100%;

}
.verf .wse {
  line-height: 20px;
  padding: 9px 0 8px;
}

.wse {
  background: none repeat scroll 0 0 #fff;
  border: 1px solid #ddd;
  color: #8fd800;
  font-size: 18px;
  font-weight: bold;
  line-height: 18px;
  margin: 0 auto;
  padding: 9px 0 5px;
  width: 172px;
}
.wse b {
  color: #898989;
  display: block;
  font-size: 13px;
}
</style>
<?PHP include_once(JPATH_SITE.'/components/com_camassistant/assets/js/vendor_compliaces.js.php'); ?>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery.zclip.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.8.0.min.js"></script>

<!--<div class="head_greenbg2"></div><br/>-->

<?php /*  el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=vendors&task=upload_select&id='+id+'&type='+type+'&type_id='+type_id;
	//var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:300}}"))
	//SqueezeBox.fromElement(el,options); */ ?>
<script type="text/javascript">
    LH = jQuery.noConflict();
    function ajaxFileUpload(type,type_id)
	{
		//alert(type);
		var frm = document.ComplianceFrm;
                document.getElementById('type').value=type
                document.getElementById('type_id').value=type_id
  		frm.submit_type.value = 'Submit';
		frm.task.value = 'imageupload23';
		frm.submit();

		return true;

	}


    </script>

<script type="text/javascript">
    LH = jQuery.noConflict();
	LH(function(){
	LH('.proposal_opener').live('click',function(){
	        if(!LH(this).hasClass('active')){
			if( LH(this).attr('id') == 'market' ) 
			{
				LH('.proposal_opener').removeClass('active');
	            LH('.table_blue_rowdots_submitted').removeClass('active'); 
			    LH(this).addClass('active');
                LH(this).parent().parent().addClass('active'); 	
				
				G.post("index.php?option=com_camassistant&controller=vendors&task=marketdocsprofile&id=<?php echo $_REQUEST['id']; ?>", function(data){
				if(data) {	
				data = "<p style='clear:both; color: #808080; margin-right: 9px; padding-left: 5px; padding-top: 5px;'>Below is a list of this Vendor's Marketing Documents for your review.  You may download any of the documents by clicking on the icon.</p><p style='height:20px;'></p>"+data;					
				LH('#table_pannel').slideUp('slow');
				LH('#companyrefsdocs').slideUp('slow');
				LH('#marketdocs').html(data).slideDown('slow');
				}
				});
			}
			else if( LH(this).attr('id') == 'references' ){
				LH('.proposal_opener').removeClass('active');
	            LH('.table_blue_rowdots_submitted').removeClass('active'); 
			    LH(this).addClass('active');
                LH(this).parent().parent().addClass('active'); 
				G.post("index.php?option=com_camassistant&controller=vendors&task=crefsprofile&id=<?php echo $_REQUEST['id']; ?>", function(data){
				if(data) {	
				data = "<p style='clear:both; color: #808080; margin-right: 9px; padding-left: 5px; padding-top: 5px;'>Below is a list of this Vendor's Customer References for your review.  You may download any of the documents by clicking on the icon.</p><p style='height:20px;'></p>"+data;					
				LH('#table_pannel').slideUp('slow');
				LH('#companyrefsdocs').html(data).slideDown('slow');
				LH('#marketdocs').slideUp('slow');
				}
				});
			}
			else{	
			LH('.proposal_opener').removeClass('active');
	        LH('.table_blue_rowdots_submitted').removeClass('active'); 	
			LH(this).addClass('active');
            LH(this).parent().parent().addClass('active'); 	
			LH('#marketdocs').html('').slideUp('slow');
			LH('#companyrefsdocs').html('').slideUp('slow');
			LH('#table_pannel').slideDown('slow');
			}
		}else{	    
		   LH('.proposal_opener').removeClass('active');
           LH('.table_blue_rowdots_submitted').removeClass('active'); 
		   LH('#marketdocs').slideUp('slow');
		   LH('#companyrefsdocs').slideUp('slow');
		   LH('#table_pannel').slideUp('slow');
		}

	});
	
	LH('#editoption').live('click',function(){
	 LH('#aboutform').show();
	 LH('.detailsextra').hide();
	});
	
	LH('#saveoption').live('click',function(){
	LH( "#aboutformsubmit" ).submit();
	});
	
	
	LH("#ctl00_CPHContent_txtComments").keyup(function(){
	send = parseInt( 500 - LH(this).val().length) ;
	if(send >= 0){
	LH( "#charcount" ).html(send);
	}
	else{
	LH( "#charcount" ).html('0');
	}
    if(LH(this).val().length > '500'){
		alert("You've reached the Character Limit");
        LH(this).val(LH(this).val().substr(0, 500));
	}
	});
	
	LH('#sendvendor_notification').live('click',function(){
		G.post("index.php?option=com_camassistant&controller=vendors&task=senddocstovendor&id=<?php echo $_REQUEST['id']; ?>", function(data){
				if(data) {
				//alert(data);
				alert("A Request has been sent to vendor to Activate his Account.");
				}
				});
	});
	
	});

function unverified(vendorid){
		G('body,html').animate({
		scrollTop: 250
		},800);
		G('#vendorid').val(vendorid);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskun').css({'width':maskWidth,'height':maskHeight});
		G('#maskun').fadeIn(100);
		G('#maskun').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitun").css('top',  winH/2-G("#submitun").height()/2);
		G("#submitun").css('left', winW/2-G("#submitun").width()/2);
		G("#submitun").fadeIn(2000);
		G('.windowun #doneun').click(function (e) {
		G('#unverifiedform').submit();
		e.preventDefault();
		G('#maskun').hide();
		G('.windowun').hide();
		});
		G('.windowun #cancelun').click(function (e) {
		e.preventDefault();
		G('#maskun').hide();
		G('.windowun').hide();
		});
	}	

function verified(vendorid){
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskve').css({'width':maskWidth,'height':maskHeight});
		G('#maskve').fadeIn(100);
		G('#maskve').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitve").css('top',  winH/2-G("#submitve").height()/2);
		G("#submitve").css('left', winW/2-G("#submitve").width()/2);
		G("#submitve").fadeIn(2000);
		G('.windowve #doneve').click(function (e) {
		e.preventDefault();
		G('#maskve').hide();
		G('.windowve').hide();
		});
		G('.windowve #cancelve').click(function (e) {
		e.preventDefault();
		G('#maskve').hide();
		G('.windowve').hide();
		});
		
	}		
	
function aboutfile(){
		/*G('body,html').animate({
		scrollTop: 250
		},800);*/
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskvea').css({'width':maskWidth,'height':maskHeight});
		G('#maskvea').fadeIn(100);
		G('#maskvea').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitvea").css('top',  winH/2-G("#submitvea").height()/2);
		G("#submitvea").css('left', winW/2-G("#submitvea").width()/2);
		G("#submitvea").fadeIn(2000);
		G('.windowvea #donevea').click(function (e) {
		e.preventDefault();
		G('#maskvea').hide();
		G('.windowvea').hide();
		});
		G('.windowvea #cancelvea').click(function (e) {
		e.preventDefault();
		G('#maskvea').hide();
		G('.windowvea').hide();
		});
	}		
    </script>
	<script>
    $(document).ready(function(){
        $("a#copy-dynamic").zclip({
           path:"templates/camassistant_left/images/ZeroClipboard.swf",
           copy:function(){return $("#dynamic").html();}
        });
    });
</script>
<style>
#maskun { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesun .windowun {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesun #submitun {  width:500px;  height:270px;  padding:10px;  background-color:#ffffff;}
#boxesun #submitun a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneun {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeun {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskve { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesve .windowve {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesve #submitve {  width:500px;  height:200px;  padding:10px;  background-color:#ffffff;}
#boxesve #submitve a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneve {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto;}
#closeve {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskvea { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvea .windowvea {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesvea #submitvea {  width:550px;  height:315px;  padding:10px;  background-color:#ffffff;}
#boxesvea #submitvea a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevea {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto;}
#closevea {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>	

<style>
#mask1c {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}

#boxes1c .window1c {
  position:absolute;
  left:0;
  top:0;
  width:1300px;
  height:150px;
  display:none;
  z-index:9999;
  padding:38px 10px 3px 10px;
}


#boxes1c #submit1c {
  width:400px;
  height:250px;
  padding:10px;
  background-color:#ffffff;
}
#boxes1c #submit1c a{
 text-decoration:none;
 color:#000000;
 font-weight:bold;
 font-size:20px;
}
#done1c {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding-left:130px;
float:left;
/*background:url(templates/camassistant/images/yes.gif) no-repeat;
*/
}
#close1c {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
 padding-right:75px;
 color:#000000;
 font-weight:bold;
 font-size:20px;
}

</style>
 <div id="wrapper">
<!-- sof right -->
<header>
        	<div id="maindivinfo">
			<div id="firstmain"><h1><?php echo $vendordata->company_name ; ?></h1></div>
			<div id="secondmain">Powered By:<a target="_blank" href="<?php echo Juri::base(); ?>"><img src="templates/camassistant_left/images/Powered-By.png" /></a></div>
			</div>			
        </header> 
<div class="container clr"> 
	<div class="container_3rd left">
	<?php 
	$path2 = $siteURL."components/com_camassistant/assets/images/vendors/";
	$path1 = $vendordata->image;
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
	$thumb_width =234;
	$thumb_height = round($thumb_width * $aspect_ratio);
			
	?><p style="height: 19px;"></p>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<p style="height: 8px;"></p>

	<div class="details" style="border:none;">
	<div id="i_bar_terms_rfp_account">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">ACCOUNT TYPE</font></span>
</div></div>
<div class="profile_content_account">
<?php
	if( $vendordata->subscribe_type == 'free' ){
		$free_icon = '<li><div class="unverified_vendor"></div></li>';
		$free_head = '<li class="unverified_head">UNVERIFIED</li>';
		$free_text = "<li class='unverified_text'>This Vendor's Compliance Documents have not been verified</li>";
	}
	else if( $vendordata->subscribe_type == 'public' ) {
		$public_icon = '<li class="public_vendor">&nbsp;</li>';
		$public_head = '<li class="public_head">VERIFIED</li>';
		$public_text = "<li class='public_text'>This Vendor's Compliance Documents have been verified</li>";
	}
	else if( $vendordata->subscribe_type == 'all' ){
		$all_icon = '<li class="all_vendor"><div class="all_vendor1"></div><div class="all_vendor2"></div></li>';
		$all_head1 = '<li class="all_head"><span class="green">VERIFIED</span> <span class="normal">+</span> <span class="yellow">SPONSOR</span></li>';
		$all_text = "<li class='public_text'>This Vendor's Compliance Documents have been verified</li>";
	}
	else{
		$all_text = "<li class='public_text'>An account Type has not been chosen yet</li>";
	}
	?>
	<ul class="acciountype_vendor">
<?php 
echo $free_icon;
echo $free_head;
echo $free_text;

echo $public_icon;
echo $public_head;
echo $public_text;

echo $all_icon;
echo $all_head1;
echo $all_text;
?>
</ul>

</div>
	<!--//Completed-->

<?php 
	$user = JFactory::getUser();
	if($user->user_type == 11){ ?>	
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding:9px 0 0;">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">PUBLIC PROFILE</font></span>
</div></div>
<div class="profile_content_buttons">
<div>

	<p style="height: 8px;"></p>
	<?php if( $this->subscription_user == 'yes' ) { ?>
	
	<p class="profilelink_style" id="dynamic">http://myvendorcenter.com/vendor/<?php echo str_replace('-','',$vendordata->company_phone) ; ?> </p>
	<?php } else { ?>
	<p style="margin-right:13px; clear:#77b800" align="center"><span style="font-weight:bold">LINK:</span> N/A</p>
	<?php } ?>
	<p style="height: 8px;"></p>
	</div>
	
	<div class="buttons_send">
	<div class="copy_send"><a href="#copy" id="copy-dynamic" class="copylink_public"></a></div>
	<!--<div class="copy_send"><a class="copylink_public" href="#copy" id="copy-dynamic"></a></div>-->
	<div class="email_send"><a class="email_public" href="mailto:?body=Dear Client,%0A%0AYou can view all of my Compliance Documents, References, and more by visiting the following link:%0A%0Ahttp://myvendorcenter.com/vendor/<?php echo str_replace('-','',$vendordata->company_phone); ?>"></a></div>
	<div class="about_send"><a class="about_public" onclick="aboutfile();" href="javascript:void(0);"></a></div>
	</div>
	<div class="clear"></div>
</div>
	<?php } ?>

	<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding:9px 0 0;">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">VENDOR DETAILS</font></span>
</div></div>
<div class="profile_content">
	<div>
	<strong style="text-align:left; display:block;"><?php echo $vendordata->company_name ; ?></strong>
	<?php echo $vendordata->company_address ; ?><br>
	<?php //echo $vendordata->company_addresss ; ?>
	<?php echo $vendordata->city. ', ' . strtoupper($vendordata->state) . ' ' . $vendordata->zipcode; ?><br>
	</div>
	<div><strong>Contact Name:</strong> <?php echo $vendordata->name . ' ' . $vendordata->lastname ; ?></a><br></div>
	<div>
	<strong>Company Phone:</strong> <?php echo $vendordata->company_phone ; ?><br>
	<strong>Alternate Phone:</strong> <?php echo $vendordata->alt_phone ; ?><br>
	<strong>Cell Phone:</strong> <?php echo $vendordata->cellphone ; ?></div>
	<div><strong>Email:</strong> <a href="mailto:<?php echo $vendordata->email ; ?>?support@myvendorcenter.com"><?php echo $vendordata->email ; ?></a><br></div>
	<?php if($vendordata->company_web_url){ ?>
	<div><strong>Website:</strong> <a href="<?php echo "http://".$vendordata->company_web_url ; ?>" target="_blank"><?php echo $vendordata->company_web_url ; ?></a><br></div>
	<?php } ?>
	<div><strong>Year Established:</strong> <?php echo $vendordata->established_year ; ?><br></div>
	</div>
	</div>
	
	
	<div style="border:none;" class="details">
	<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding:9px 0 0;">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">INDUSTRIES SERVED</font></span>
</div></div>
<div class="profile_content">
<?php $indus = $this->indus ;
	echo "<ul>";
	for( $i=0; $i<count($indus); $i++ ){
		echo "<li>- ".$indus[$i]->industry_name.'</li>' ;
	}
	echo "</ul>";
 ?>
</div>
</div>


	<div class="rating" style="border:none;">
	<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding:9px 0 0;">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">VENDOR RATING</font></span>
</div></div>
<div class="profile_content">
	<p class="vendorating" style="margin-top:16px;"><img src="components/com_camassistant/assets/images/rating/vendorrating/<?php echo $vendordata->rating; ?>"><br><br><?php echo $vendordata->reviews; ?> Out of 5 
</p>
<br /><br />
</div>
	</div>
	
	</div>
				
<p style="height: 8px;"></p>
<div class="container_9th right">



<!-- sof bedcrumb -->
<!--
<div id="bedcrumb">

<ul>

<li class="home"><a href="index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112">Home</a></li> <li><a href="index.php?option=com_camassistant&controller=documents&task=vendor_docs&Itemid=115">My Company Documents</a></li><li>Compliance Documents</li>

</ul>

</div>
-->
<!-- eof bedcrumb -->

<div id="msg_note"></div>
<p style="height:15px;"></p>

<div style="background:#a1a1a1; box-shadow:1px 2px 1px #a1a1a1; font-size:14px; margin:0 4px;" id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">ABOUT US</font></span>
</div></div>

<p style="height:6px;"></p>
<div class="detailsextra">
<p style="padding-top:5px; margin-right:9px; padding-left:5px; color:gray; text-align:left"><?php echo nl2br($this->aboutus->aboutus); ?> 
<?php if($userl->user_type == '11'){ ?>
<a id="editoption" href="#"><strong>(EDIT)</strong></a>
<?php } ?>
</p></div>
<p style="height:20px;"></p>
<div id="aboutform" style="display:none;">
<form action="" method="post" id="aboutformsubmit">
<table cellpadding="0" cellspacing="0">
<tr><td>

 <textarea name="aboutus" id="ctl00_CPHContent_txtComments" style="height:250px; margin-left:6px; width:648px;"><?php echo str_replace('<br />','\n',$this->aboutus->aboutus); ?></textarea>
 </td></tr>
<tr height="10"></tr>
<tr><td style="color: #808080; font-size: 13px; padding-left: 9px; text-align: left;">
<span id="charcount" style="float:left; line-height:normal;">
<?php
echo 500 - strlen($this->aboutus->aboutus). "</span>&nbsp;Characters Left";
?>
<a id="saveoption" href="#" style="float:right; font-weight:bold;">(SAVE)</a>
<!--<input type="submit" value="SAVE" style="float:right" />-->

</td></tr>
</table>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="vendors" name="controller">
<input type="hidden" value="saveaboutus" name="task">
<input type="hidden" value="<?php echo $this->aboutus->id; ?>" name="id">
</form>
</div>
<div id="i_bar_terms" style="margin:0 4px; font-size:14px;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR DOCUMENTS</font></span>
</div></div>

<table width="99%" cellspacing="0" cellpadding="0" style="margin:6px 4px">
  			  <tbody><tr class="table_blue_rowdots_submitted" id="table_blue_rowdots">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="compliance" class="proposal_opener" href="javascript:void(0);" style="float:left;"></a>&nbsp;&nbsp;&nbsp;COMPLIANCE DOCUMENTS
			</td>
			</tr>
			</tbody>
			</table>


<!-- sof table pan -->

<div class="table_pannel" id="table_pannel" style="display:none;">




<!--
<div class="head_bluebg2">

KEEPING DOCUMENTS CURRENT MAXIMIZES YOUR RFP ELIGIBILITY

</div>

-->

  <div class="proposal_form">
<br/>

<?php if($userl->user_type != '11'){ ?>
<div style="text-align:center; margin-bottom:20px;"><a id="sendvendor_notification" href="#">CLICK HERE</a> <span style="color:gray">to request this Vendor to update any expired documents</span></div>
<?php } ?>
  </div>
<form name="ComplianceFrm" method="post" enctype="multipart/form-data"/>

<!-- W9 starts -->
<div class="lineitem_pan_row">

 <?php //print_r($W9_data); exit; //$main = $W9_data->w9_date_verified;
	$w9_date_verified = strtotime($W9_data->w9_date_verified);
	if($W9_data->w9_date_verified=='0000-00-00' || !$W9_data->w9_date_verified){
	$W9_data->w9_date_verified = '00-00-0000';
	} else {
	$W9_data->w9_date_verified = date('m-d-Y', $w9_date_verified);
	}
  /* if($main != '0000-00-00'){

	$date6 = strtotime($main);

	$date6 = date('m-d-Y', $date6);
        $disable = "disabled='disabled'";

	} else{

	$date6 = 'PENDING';

	}
*/
	//echo $date;

   ?>

<div class="lic-pan">
    <h2>W9</h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
       <?php if($W9_data->w9_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $W9_data->w9_upld_cert)); ?>
      <div class="imag-display"  id="imagdisplayW91"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=W9&filename=<?PHP echo $W9_data->w9_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display"  id="imagdisplayW91"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="W9_upld_cert1" id="W9_upld_cert1"  value="<?PHP echo $W9_data->w9_upld_cert; ?>" /><input type="hidden" name="dW91" id="dW91" value="" /><br/>
     </div>
    <div class="lic-pan-right">
      <div class="comm">
      <?php $db = JFactory::getDBO(); 
		$user =& JFactory::getUser();
		
		$id = JRequest::getVar('id','');
			if(!$id) { 
			$id = $user->id ;
			 } 
			 else{
			$id = $id ; 
			 }

		$subscribe = "SELECT subscribe_type FROM #__users  where id='".$id."'";
		$db->Setquery($subscribe);
		$subscribe_type = $db->loadResult();
			 
		$tax_id="SELECT tax_id FROM #__cam_vendor_company  where user_id='".$id."'";
		$db->Setquery($tax_id);
		$taxid = $db->loadResult();
		
		if($taxid==$W9_data->ein_number) {
		$W9_data->ein_number= $taxid;
		} else if(!$W9_data->ein_number){
		$W9_data->ein_number= $taxid;
		} else {
		$W9_data->ein_number= $W9_data->ein_number;
		} 
		$W9_data->ein_number= $taxid;
		//$W9_data->ein_number ?>
		<div class="in-pan">
        <label>EIN Number</label>
          <span><?php echo $W9_data->ein_number; ?></span></div>
		  </div>
		  
	  <?php if( $subscribe_type == 'free' ){ ?>
		<div class="verf"><div class="wse"><font color="red"><?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else { ?>
			<a href="javascript:void(0);" onclick="unverified(<?php echo $id; ?>);">UNVERIFIED</a> 
		<?php }
		?>
		</font></div></div>
<?php } else { 
	   if($W9_data->w9_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
	   else if($W9_data->w9_date_verified == '00-00-0000' && !$W9_data->w9_upld_cert) echo ""; 
	   else if($W9_data->w9_date_verified == '00-00-0000' && $W9_data->w9_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	   else 
	   	{	
			if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$W9_data->w9_date_verified.'</b></div></div>';
			}
			else{ ?>
			<div class='verfirst'><div class='wse'><a href="javascript:void(0);" onclick="verified(<?php echo $id; ?>);">VERIFIED</a><b><?php echo $W9_data->w9_date_verified; ?></b></div></div>
			<?php 
			}
		}
			
	   
 } ?>
 
 
    </div>
    <div class="clear"></div>
</div>

</div>

<!-- W9 Completed-->

<!-- General liability docs starts -->
<div id="line_task_GLI1">
<div class="lic-pan">
<?php //echo '<pre>'; print_r($GLI_data[0]); ?>
    <h2>GENERAL LIABILITY POLICY - 1</h2>
    <div class="clear"></div>
    <?php //$main = $GLI_data[0]->GLI_date_verified;
    $GLI_date_verified = strtotime($GLI_data[0]->GLI_date_verified);
    if($GLI_data[0]->GLI_date_verified=='0000-00-00' || !$GLI_data[0]->GLI_date_verified){
	$GLI_data[0]->GLI_date_verified = '00-00-0000';
	} else {
	$GLI_data[0]->GLI_date_verified = date('m-d-Y', $GLI_date_verified);
	}

if($GLI_data[0]->GLI_date_verified == '00-00-0000' && !$GLI_data[0]->GLI_upld_cert) 
	$disply = 'none';
else
	$disply = '';
   ?>

    <div class="lic-pan-left" style="display:<?php echo $disply ; ?>">
      <?php if($GLI_data[0]->GLI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $GLI_data[0]->GLI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayGLI1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=GLI_<?PHP echo $GLI_data[0]->GLI_folder_id; ?>&filename=<?PHP echo $GLI_data[0]->GLI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayGLI1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>

      <input type="hidden" class="file_input_textbox" name="GLI_upld_cert[]" id="GLI_upld_cert1"  value="<?PHP echo $GLI_data[0]->GLI_upld_cert; ?>" />
      </div>
    <div class="lic-pan-right" id="GLI1" style="display:<?php echo $disply ; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php 
	if($GLI_data[0]->GLI_end_date < date('Y-m-d') || !$GLI_data[0]->GLI_end_date || $GLI_data[0]->GLI_end_date == '00-00-0000')
	 { 
	 $color_exp = 'red';
	  } ?>
	 
	 <?php 
	 	if($GLI_data[0]->GLI_end_date) {
			$GLI_data[0]->GLI_end_date = $GLI_data[0]->GLI_end_date ;
		}
		else{
			$GLI_data[0]->GLI_end_date = '0000-00-00';
		}
	 ?>
     <?PHP $GLI_end_date = explode('-',$GLI_data[0]->GLI_end_date);  ?>
    <span style="color:<?php echo $color_exp; ?>"><?PHP if($GLI_data) { echo $GLI_end_date[1].'/'.$GLI_end_date[2].'/'.$GLI_end_date[0]; } ?></span>
	<?php $color_exp = ''; ?>
	 
	
	 </div>
	 <div class="in-pan1">
          <label>Med. Expenses:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_med,2); }?></span>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_policy_occurence,2); }?></span>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_injury,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <span id="greencolormoney"><?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_policy_aggregate,2); } ?></span>
	 
		 <?php
		 	if($GLI_data[0]->GLI_applies == 'pol')
			$pol = "checked='checked'";
			elseif($GLI_data[0]->GLI_applies == 'proj')
			$proj = "checked='checked'";
			elseif($GLI_data[0]->GLI_applies == 'loc')
			$loc = "checked='checked'";
		 ?><p style="height:12px"></p>
		 <table cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;"><label>Applies To:&nbsp;</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" <?php echo $pol; ?> type="radio" name="GLI_applies0" value="pol" class="attrInputs1" id="attrInputs1" /></td><td><label>Pol</label></td>
		<td style="vertical-align:top;"><input disabled="disabled" <?php echo $proj; ?> type="radio" name="GLI_applies0" value="proj" class="attrInputs1" id="attrInputs1" /></td><td><label>Proj</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" <?php echo $loc; ?> type="radio" name="GLI_applies0" value="loc" class="attrInputs1" id="attrInputs1" /></td><td><label>Loc</label></td>
		 <?php if(!$GLI_data[0]->GLI_applies) { ?><!--<td>*</td>--><?php } ?>
		 </tr></table>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_products,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <span id="greencolormoney"><?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_damage,2); } ?></span>
        </div>
        <div class="in-pan1" style="margin-top:-20px;">
		   <?php
		 	if($GLI_data[0]->GLI_primary == 'primary')
			$primary = "checked='checked'";
			if($GLI_data[0]->GLI_waiver == 'waiver')
			$waiver = "checked='checked'";
			if($GLI_data[0]->GLI_occur == 'occur')
			$occur = "checked='checked'";
			
			?>
         <table cellpadding="0" cellspacing="0"><tr height="8"></tr><tr><td><input disabled="disabled" type="checkbox" <?php echo $primary; ?> value="primary" name="GLI_primary0" style="margin-left:0px;" /> </td>
		 <td><label style="padding:0px; margin:0px;">Primary Non-Contributory</label></td></tr> 
		 <tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver; ?> value="waiver" name="GLI_waiver0" style="margin-left:0px;" /> </td>
		 <td><label style="padding:0px; margin:0px;">Waiver of Subrogation </label></td></tr>
		 <tr><td><input type="checkbox" disabled="disabled" <?php echo $occur; ?> value="occur" name="GLI_occur0" style="margin-left:0px;" /></td> 
		 <td><label style="padding:0px; margin:0px;">Occur</label></td></tr></table>
		 <?php
		 $primary = '';
		 $waiver = '';
		 $occur = '';
		 ?>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan" style="width:500px;">
          <label style="padding-top:5px;">MyVC listed as Cert. Holder?</label>
		  <?php if($GLI_data[0]->GLI_certholder == 'yes')  {
		  $glioccur = 'Yes';
		  $gli_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $glioccur = 'No';
		  $gli_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="GLI_certhide1"><?php echo $glioccur; ?></span>
		 <p style="height:10px;"></p>
		 <label>Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$GLI_data[0]->GLI_additional." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <?php if(!$add_company) { ?>
		 <span class="companyadditional" style="color:red; margin-top:-14px;" id="GLI_addhide1"><?php echo "None"; ?></span>
		 <?php } else { ?>
		 <span class="companyadditional" id="GLI_addhide1" style="margin-top:-14px;"><?php echo $add_company; ?></span>
		 <?php } ?>
        </div>
        
        <div class="clear"></div>
      </div>
    </div>
	
<?php 
if($GLI_data[0]->GLI_date_verified == '00-00-0000' && !$GLI_data[0]->GLI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray"><font color="gray">NONE</font></font></div></div>'; 
}
else {
		if( $subscribe_type == 'free' ){ ?>
<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
<?php } else { 
	   if($GLI_data[0]->GLI_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
	   else if( $GLI_data[0]->GLI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	   else if($GLI_data[0]->GLI_date_verified == '00-00-0000' && $GLI_data[0]->GLI_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	   else 
	   	{
			if( $userl->user_type == '11' ){
			echo "<div class='verfirst'><div class='wse'>VERIFIED<b>".$GLI_data[0]->GLI_date_verified."</b></div></div>";
			}
			else{
			echo "<div class='verfirst'><div class='wse'><a href='javascript:void(0);' onclick='verified(".$id.");'>VERIFIED</a><b>".$GLI_data[0]->GLI_date_verified."</b></div></div>";
			}
		}	
	}	   
 } ?>
	
    <div class="clear"></div>
  </div>
<input type="hidden" name="GLI_status[]" value="<?PHP echo $GLI_data[0]->GLI_status; ?>" />
<input type="hidden" name="GLI_id[]" id="GLI_id1" value="<?PHP echo $GLI_data[0]>id; ?>" />
<input type="hidden" name="dGLI1" id="dGLI1" value="" />
<input type="hidden" name="old_line_task_GLI_ids[]" id="old_line_task_GLI_ids_1" value="<?PHP echo $GLI_data[0]->id; ?>"/>
<input type="hidden" name="current_line_task_GLI_ids[]" id="current_line_task_GLI_ids1" value="1" />
</div>

<!--<!--<p style=" padding-top:20px;"></p>-->

<!-- table row start -->

<?PHP for($k=1; $k<count($GLI_data); $k++) {?>

<div id="line_task_GLI<?PHP echo $k+1; ?>">

<div class="lic-pan">
    <h2>GENERAL LIABILITY POLICY - <?PHP echo $k+1; ?></h2>
    <div class="clear"></div>
    <?php //$main = $GLI_data[$k]->GLI_date_verified;
    $GLI_date_verified1 = strtotime($GLI_data[$k]->GLI_date_verified);
    if($GLI_data[$k]->GLI_date_verified=='0000-00-00' || !$GLI_data[$k]->GLI_date_verified){
	$GLI_data[$k]->GLI_date_verified = '00-00-0000';
	} else {
	$GLI_data[$k]->GLI_date_verified = date('m-d-Y', $GLI_date_verified1);
	}
	
if($GLI_data[$k]->GLI_date_verified == '00-00-0000' && !$GLI_data[$k]->GLI_upld_cert)
	$display = 'none';
else
	$display = '';	

   ?>

    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
      <?php if($GLI_data[$k]->GLI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $GLI_data[$k]->GLI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayGLI<?PHP echo $k+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=GLI_<?PHP echo $GLI_data[$k]->GLI_folder_id; ?>&filename=<?PHP echo $GLI_data[$k]->GLI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayGLI<?PHP echo $k+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="GLI_upld_cert[]" id="GLI_upld_cert<?PHP echo $k+1; ?>"  value="<?PHP echo $GLI_data[$k]->GLI_upld_cert; ?>" /><br/>
 </div>
    <div class="lic-pan-right"  id="GLI<?PHP echo $k+1; ?>" style="display:<?php echo $display; ?>">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
		
		<?php if($GLI_data[$k]->GLI_end_date < date('Y-m-d') || $GLI_data[$k]->GLI_end_date == '00-00-0000') { 
		$color_exp = 'red';
		 } ?>
		<?php 
		if($GLI_data[$k]->GLI_end_date){
			$GLI_data[$k]->GLI_end_date = $GLI_data[$k]->GLI_end_date ;
		} 
		else{
			$GLI_data[$k]->GLI_end_date = '0000-00-00';
		}
		?>
 <?PHP $GLI_end_date2 = explode('-',$GLI_data[$k]->GLI_end_date);  ?>
  <span style="color:<?php echo $color_exp; ?>"><?PHP echo $GLI_end_date2[1].'/'.$GLI_end_date2[2].'/'.$GLI_end_date2[0]; ?></span>
  <?php $color_exp = ''; ?>
  
  </div>
  <div class="in-pan1">
          <label>Med. Expenses:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_med,2); }?></span>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_policy_occurence,2); }?></span>
		 <?php if(!$GLI_data[$k]->GLI_policy_occurence || $GLI_data[$k]->GLI_policy_occurence == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <span id="greencolormoney"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_injury,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	   <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <span id="greencolormoney"><?PHP echo number_format($GLI_data[$k]->GLI_policy_aggregate,2); ?></span>
		 <?php if(!$GLI_data[$k]->GLI_policy_aggregate || $GLI_data[$k]->GLI_policy_aggregate == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
		 <br />
		 <?php
		 	$pol = '' ; $proj = '' ; $loc = '' ;
		 	if($GLI_data[$k]->GLI_applies == 'pol')
			$pol = "checked='checked'";
			elseif($GLI_data[$k]->GLI_applies == 'proj')
			$proj = "checked='checked'";
			elseif($GLI_data[$k]->GLI_applies == 'loc')
			$loc = "checked='checked'";
		 ?><p style="height:10px"></p>
		 <table cellpadding="0" cellspacing="0"><tr><td><label>Applies To</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" type="radio" <?php echo $pol; ?> name="GLI_applies<?php echo $k; ?>" value="pol" class="attrInputs" id="attrInputs<?php echo $k; ?>" /></td><td><label>&nbsp;Pol&nbsp;</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" <?php echo $proj; ?> type="radio" name="GLI_applies<?php echo $k; ?>" value="proj" class="attrInputs" id="attrInputs<?php echo $k; ?>" /></td><td><label>&nbsp;Proj&nbsp;</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" type="radio"  <?php echo $loc; ?> name="GLI_applies<?php echo $k; ?>" value="loc" class="attrInputs" id="attrInputs<?php echo $k; ?>" /></td><td><label>&nbsp;Loc</label></td>
		 <?php if(!$GLI_data[$k]->GLI_applies) { ?> <td style="color:red;">*</td><?php } ?>
		 </tr></table>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <span><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_products,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <span id="greencolormoney"	><?PHP if($GLI_data) {echo number_format($GLI_data[$k]->GLI_damage,2); } ?></span>
        </div>
        <div class="in-pan1"  style="margin-top:-20px;">
          <label></label>
		   <?php
		 	if($GLI_data[$k]->GLI_primary == 'primary')
			$primary = "checked='checked'";
			if($GLI_data[$k]->GLI_waiver == 'waiver')
			$waiver = "checked='checked'";
			if($GLI_data[$k]->GLI_occur == 'occur')
			$occur = "checked='checked'";
			
			?>
         <table cellpadding="0" cellspacing="0"><tr height="8"></tr><tr><td>
		 <input type="checkbox" disabled="disabled" <?php echo $primary; ?> value="primary" name="GLI_primary<?php echo $k; ?>" id="GLI_primary<?PHP echo $k+1; ?>"  style="margin-left:0px;" /> </td><td><label style="padding:0px; margin:0px;">Primary Non-Contributory</label></td></tr>
		 <tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver; ?> value="waiver" name="GLI_waiver<?php echo $k; ?>" id="GLI_waiver<?PHP echo $k+1; ?>"  style="margin-left:0px;" /></td><td> <label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation</label></td> </tr>
		 <td><input type="checkbox" disabled="disabled" <?php echo $occur; ?> value="occur" name="GLI_occur<?php echo $k; ?>" id="GLI_occur<?PHP echo $k+1; ?>"  style="margin-left:0px;"/></td><td> <label style="padding:0px; margin:0px;">&nbsp;Occur</label> </td></tr></table>
		 <?php
		 $primary = '';
		 $waiver = '';
		 $occur = '';
		 ?>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan" style="width:500px;">
		<label style="padding-top:5px;">MyVC listed as Cert. Holder?</label>
		
		 <?php if($GLI_data[$k]->GLI_certholder == 'yes') {
		  $glioccur = 'Yes';
		  $gli_chekcedf = "checked='checked'";
		  $color = '#8FD800';
		  }
		  else {
		  $glioccur = 'No';
		  $gli_chekceds = "checked='checked'";
		  $color = 'red';
		  }
		  ?>
		  
          <p id="GLI_cert<?PHP echo $k+1; ?>" style="display:none;"><input type="radio" <?php echo $gli_chekcedf; ?> value="yes" name="GLI_certholder<?php echo $k; ?>"  style="margin-left:0px;" />&nbsp;YES &nbsp;<input type="radio" <?php echo $gli_chekceds; ?> value="no" name="GLI_certholder<?php echo $k; ?>"  style="margin-left:0px;" />&nbsp;No</p>
         <span style="color:<?php echo $color; ?>; margin-left:170px; display:block; margin-top:-14px;" id="GLI_certhide<?PHP echo $k+1; ?>"><?php echo $glioccur; ?></span>
		 <p style="height:10px;"></p>
		  <label>Additional Insured:</label>
		   <p id="GLI_add<?PHP echo $k+1; ?>" style="display:none;"><select name="GLI_additional<?PHP echo $k; ?>">
		  <option value="0">Select</option>
		  <?php
		  for($c=0; $c<count($this->firmslist); $c++){ 
		  	if($GLI_data[$k]->GLI_additional == $this->firmslist[$c]->userid) {
		  		$selected_opts = "selected='selected'";
				}
		  ?>
		  <option <?php echo $selected_opts; ?> value="<?php echo $this->firmslist[$c]->userid; ?>"><?php echo $this->firmslist[$c]->comp_name; ?></option>
		  <?php $selected_opts = '' ;}
		  ?>
		 </select></p>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$GLI_data[$k]->GLI_additional." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <?php if(!$add_company) { ?>
		 <span class="companyadditional" style="color:red;margin-top:-14px;" id="GLI_addhide<?PHP echo $k+1; ?>"><?php echo "None"; ?></span>
		 <?php } else { ?>
		 <span class="companyadditional" style="margin-top:-14px;"id="GLI_addhide<?PHP echo $k+1; ?>"><?php echo $add_company; ?></span>
		 <?php } ?>
		 
        </div>
        <div class="clear"></div>
      </div>
	  
    </div>
<?php 
if($GLI_data[$k]->GLI_date_verified == '00-00-0000' && !$GLI_data[$k]->GLI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>'; 
}
else {
if( $subscribe_type == 'free' ){ ?>
<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
<?php } else { 
	   if($GLI_data[$k]->GLI_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
	   else if( $GLI_data[$k]->GLI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	   else if($GLI_data[$k]->GLI_date_verified == '00-00-0000' && $GLI_data[$k]->GLI_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	   else {
	   		if( $userl->user_type == '11' ){
	   			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$GLI_data[$k]->GLI_date_verified.'</b></div></div>';
				}
			else{
				echo "<div class='verfirst'><div class='wse'><a href='javascript:void(0);' onclick='verified(".$id.");'>VERIFIED</a><b>".$GLI_data[$k]->GLI_date_verified."</b></div></div>";
			}	
			}
	}   
 } ?>	
    <div class="clear"></div>
  </div>
	<input type="hidden" name="GLI_id[]" id="GLI_id<?PHP echo $k+1; ?>" value="<?PHP echo $GLI_data[$k]->id; ?>" />
	<input type="hidden" name="old_line_task_GLI_ids[]" id="old_line_task_GLI_ids_<?PHP echo $k+1; ?>" value="<?PHP echo $GLI_data[$k]->id; ?>"/>
	<input type="hidden" name="dGLI<?PHP echo $k+1; ?>" id="dGLI<?PHP echo $k+1; ?>" value="" />
	<input type="hidden" name="GLI_status[]" value="<?PHP echo $GLI_data[$k]->GLI_status; ?>" />
	<input type="hidden" name="current_line_task_GLI_ids[]" id="current_line_task_GLI_ids<?PHP echo $k+1; ?>" value="<?PHP echo $k+1; ?>" />
  </div>

<?PHP } ?>
<div id="addcompliance_GLI"></div>

<div id="addcompliance_GLI_loading"></div>

<!-- table row end -->
<!-- General liability docs completed-->
<!-- Workers comp plicies starts -->
<div id="line_task_AIP">

 <?php 
	$aip_date_verified = strtotime($AIP_data[0]->aip_date_verified);
	if($AIP_data[0]->aip_date_verified=='0000-00-00' || !$AIP_data[0]->aip_date_verified){
	$AIP_data[0]->aip_date_verified = '00-00-0000';
	} else {
	$AIP_data[0]->aip_date_verified = date('m-d-Y', $aip_date_verified);
	}

if($AIP_data[0]->aip_date_verified == '00-00-0000' && !$AIP_data[0]->aip_upld_cert)
	$display = 'none';	
else
	$display = '';		
    ?>

<div class="lic-pan">
    <h2>COMMERCIAL VEHICLE POLICY - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
       <?php if($AIP_data[0]->aip_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $AIP_data[0]->aip_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayaip1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=aip_<?PHP echo $AIP_data[0]->aip_folder_id; ?>&filename=<?PHP echo $AIP_data[0]->aip_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayaip1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert1"  value="<?PHP echo $AIP_data[0]->aip_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right" id="aip1" style="display:<?php echo $display; ?>">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($AIP_data[0]->aip_end_date < date('Y-m-d') || $AIP_data[0]->aip_end_date == '00-00-0000'  ) { 
		$color_exp = 'red';
		 } ?>
		 
		 <?php
		 	if($AIP_data[0]->aip_end_date){
				$AIP_data[0]->aip_end_date = $AIP_data[0]->aip_end_date ;
			}
			else{
			$AIP_data[0]->aip_end_date = '0000-00-00';
			}
		 ?>
            <?PHP $aip_date = explode('-',$AIP_data[0]->aip_end_date); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP if($AIP_data[0]->aip_end_date){ echo $aip_date[1].'/'.$aip_date[2].'/'.$aip_date[0]; }  ?></span>
		<?php $color_exp = ''; ?>
		
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Person:</label>
		 <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_bodily,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_combined,2); }?></span>
		<?php //if(!$AIP_data[0]->aip_combined) { ?> <!--<span style="font-size: 20px;">*</span>--><?php //} ?>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_body_injury,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_property,2); }?></span>
		</div>
		 <div class="in-pan1">
		 <?php
		 	if($AIP_data[0]->aip_primary == 'primary')
			$primary = "checked='checked'";
			if($AIP_data[0]->aip_waiver == 'waiver')
			$waiver = "checked='checked'";
		
			?>
		 <table cellpadding="0" cellspacing="0"><tr height="20"></tr><tr><td><input type="checkbox" disabled="disabled" <?php echo $primary; ?> value="primary" name="aip_primary0"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Primary Non-Contributory&nbsp;&nbsp;</label></td></tr>
		<tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver; ?> value="waiver" name="aip_waiver0"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation&nbsp;&nbsp;</label></td></tr></table>
		 </div>
      </div>
	  <div class="comm" style="width:407px;">
	  <div class="in-pan" style="width:407px; margin-top:-8px;">
          <label style="padding-top:5px;">MyVC listed as Cert. Holder?</label>
		  <?php if($AIP_data[0]->aip_cert == 'yes')  {
		  $aipoccur = 'Yes';
		  $aip_classf = "checked='checked'" ;
		  $color="#8FD800";
		   }
		  else {
		  $aipoccur = 'No';
		  $aip_classs = "checked='checked'" ;
		  $color="red";
		  }
		  ?>
        <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="aip_certhide1"><?php echo $aipoccur; ?></span>
		
		 <label style="padding-top:11px;">Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$AIP_data[0]->aip_addition." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <?php if(!$add_company){ ?>
		 <span class="companyadditional" style="color:red;margin-top:-14px;" id="aip_addhide1"><?php echo "None"; ?></span>
		 <?php } else { ?>
		 <span class="companyadditional"  style="margin-top:-14px;"id="aip_addhide1"><?php echo $add_company; ?></span>
		 <?php } ?>
		 <p style="height:30px;"></p>
		 <?php 
		 if($AIP_data[0]->aip_applies_any == 'any') 
		 $aip_any = "checked='checked'";
		 if($AIP_data[0]->aip_applies_owned == 'owned') 
		 $aip_owned = "checked='checked'";		 
		 if($AIP_data[0]->aip_applies_nonowned == 'nonowned') 
		 $aip_nonowned = "checked='checked'";		 
		 if($AIP_data[0]->aip_applies_hired == 'hired') 
		 $aip_hired = "checked='checked'";		 
		 if($AIP_data[0]->aip_applies_scheduled == 'sch') 
		 $aip_sch = "checked='checked'";		 
		 ?>
        <p style="margin-top:-20px; float:right">
		<table cellpadding="0" cellspacing="0"><tr><td><label style="padding:0px; margin:0px;">Applies to:&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="any" <?php echo $aip_any; ?>  name="aip_applies_any0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Any&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="owned" <?php echo $aip_owned; ?> name="aip_applies_owned0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="nonowned" <?php echo $aip_nonowned; ?> name="aip_applies_nonowned0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">No-Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="hired" <?php echo $aip_hired; ?> name="aip_applies_hired0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Hired&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="sch" <?php echo $aip_sch; ?> name="aip_applies_scheduled0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Scheduled&nbsp;&nbsp;</label></td></tr></table></p>
        </div>
		</div>
	  <div class="clr"></div>
    </div>
<?php 
if($AIP_data[0]->aip_date_verified == '00-00-0000' && !$AIP_data[0]->aip_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?></font></div></div>
	<?php } else { 
	if($AIP_data[0]->aip_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $AIP_data[0]->aip_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($AIP_data[0]->aip_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
		echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$AIP_data[0]->aip_date_verified.'</b></div></div>'; 
		}
		else{
		echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$AIP_data[0]->aip_date_verified.'</b></div></div>'; 
		}
		}
	} 
}
 ?>	
    <div class="clear"></div>
  </div>


  <input type="hidden" name="old_line_task_aip_ids[]" id="old_line_task_aip_ids_1" value="<?PHP echo $AIP_data[0]->id; ?>" /><input type="hidden" name="aip_status[]" value="<?PHP echo $AIP_data[0]->aip_status; ?>" />
 <input type="hidden" name="daip1" id="daip1" value="" />
  <input type="hidden" name="current_line_task_aip_ids[]" id="current_line_task_aip_ids1" value="1"  />

   <input type="hidden" name="AIP_id[]" id="aip_id1" value="<?PHP echo $AIP_data[0]->id; ?>" />
</div>
<?PHP for($mj=1; $mj<count($AIP_data); $mj++) { //echo "<pre>"; print_r($WCI_data); ?>

<div  id="line_task_AIP<?PHP echo $mj+1; ?>"><div class="lic-pan">
    <?php 
    $aip_date_verified1 = strtotime($AIP_data[$mj]->aip_date_verified);
	if($AIP_data[$mj]->aip_date_verified=='0000-00-00' || !$AIP_data[$mj]->aip_date_verified){
	$AIP_data[$mj]->aip_date_verified = '00-00-0000';
	} else {
	$AIP_data[$mj]->aip_date_verified = date('m-d-Y', $aip_date_verified1);
	}
    
if($AIP_data[$mj]->aip_date_verified == '00-00-0000' && !$AIP_data[$mj]->aip_upld_cert)
	$display = 'none';	
else
	$display = '';		
   ?>
        <h2>COMMERCIAL VEHICLE POLICY - <?PHP echo $mj+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
       <?php if($AIP_data[$mj]->aip_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $AIP_data[$mj]->aip_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayaip<?PHP echo $mj+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=aip_<?PHP echo $AIP_data[$mj]->aip_folder_id; ?>&filename=<?PHP echo $AIP_data[$mj]->aip_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayaip<?PHP echo $mj+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
       <input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert<?PHP echo $mj+1; ?>"  value="<?PHP echo $AIP_data[$mj]->aip_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right" id="aip<?PHP echo $mj+1; ?>" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($AIP_data[$mj]->aip_end_date < date('Y-m-d')) { 
			$color_exp = 'red';
		 } ?>
	<?php
	if($AIP_data[$mj]->aip_end_date){
		$AIP_data[$mj]->aip_end_date = $AIP_data[$mj]->aip_end_date;
	}
	else{
		$AIP_data[$mj]->aip_end_date = '0000-00-00';
	}
	?>
    <?PHP $aip_date1 = explode('-',$AIP_data[$mj]->aip_end_date); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP echo $aip_date1[1].'/'.$aip_date1[2].'/'.$aip_date1[0]; ?></span>
		<?php $color_exp = ''; ?>
      </div>
	  <div class="in-pan1">
		 <label>Bodily Injury - Per Person:</label>
		 <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_bodily,2); }?></span>
		 </div>
		 </div>
		 
		 <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_combined,2); }?></span>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		<span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_body_injury,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <span id="greencolormoney"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_property,2); }?></span>
		</div>
		 <div class="in-pan1">
		 <?php
		 	$primary = ''; $waiver = ''; 
		 	if($AIP_data[$mj]->aip_primary == 'primary')
			$primary = "checked='checked'";
			if($AIP_data[$mj]->aip_waiver == 'waiver')
			$waiver = "checked='checked'";
		
			?>
		 <table cellpadding="0" cellspacing="0"><tr height="20"></tr><tr><td><input type="checkbox" disabled="disabled" <?php echo $primary; ?> value="primary" name="aip_primary<?PHP echo $mj; ?>"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Primary Non-Contributory&nbsp;&nbsp;</label></td></tr>
		 <tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver; ?> value="waiver" name="aip_waiver<?PHP echo $mj; ?>"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation&nbsp;&nbsp;</label></td></tr></table>
		 </div>
		 <?php $primary = ''; $waiver = '';  ?>
      </div>
	   <div class="comm" style="width:407px;">
	  <div class="in-pan" style="width:407px; margin-top:-8px;">
          <label style="padding-top:8px;">MyVC listed as Cert. Holder?</label>
		  <?php if($AIP_data[$mj]->aip_cert == 'yes')  {
		  $aipoccur = 'Yes';
		  $aip_classf = "checked='checked'" ;
		   $color = '#8FD800';
		   }
		  else {
		  $aipoccur = 'No';
		  $aip_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="aip_certhide<?PHP echo $mj+1; ?>"><?php echo $aipoccur; ?></span>
		 <p style="height:10px;"></p>
		 <label>Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$AIP_data[$mj]->aip_addition." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <?php if(!$add_company){ ?>
		 <span class="companyadditional" style="color:red;margin-top:-14px;" id="aip_addhide<?PHP echo $mj+1; ?>"><?php echo "None"; ?></span>
		 <?php } else { ?>
		 <span class="companyadditional" style="margin-top:-14px;" id="aip_addhide<?PHP echo $mj+1; ?>"><?php echo $add_company; ?></span>
		 <?php } ?>
		 <p style="height:28px;"></p>
		 <?php 
		 $aip_any = ''; $aip_owned = ''; $aip_nonowned = ''; $aip_hired = ''; $aip_sch = ''; 
		 if($AIP_data[$mj]->aip_applies_any == 'any') 
		 $aip_any = "checked='checked'";
		 if($AIP_data[$mj]->aip_applies_owned == 'owned') 
		 $aip_owned = "checked='checked'";		 
		 if($AIP_data[$mj]->aip_applies_nonowned == 'nonowned') 
		 $aip_nonowned = "checked='checked'";		 
		 if($AIP_data[$mj]->aip_applies_hired == 'hired') 
		 $aip_hired = "checked='checked'";		 
		 if($AIP_data[$mj]->aip_applies_scheduled == 'sch') 
		 $aip_sch = "checked='checked'";		 
		 ?>
        <p style="margin-top:-20px; float:right;">
		<table cellpadding="0" cellspacing="0"><tr><td><label>Applies to:&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="any" <?php echo $aip_any; ?>  name="aip_applies_any<?PHP echo $mj; ?>" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Any&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="owned" <?php echo $aip_owned; ?> name="aip_applies_owned<?PHP echo $mj; ?>" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="nonowned" <?php echo $aip_nonowned; ?> name="aip_applies_nonowned<?PHP echo $mj; ?>" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">No-Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="hired" <?php echo $aip_hired; ?> name="aip_applies_hired<?PHP echo $mj; ?>" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Hired&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="sch" <?php echo $aip_sch; ?> name="aip_applies_scheduled<?PHP echo $mj; ?>" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Scheduled&nbsp;&nbsp;</label></td></tr></table></p>
        </div>
		<?php  $aip_any = ''; $aip_owned = ''; $aip_nonowned = ''; $aip_hired = ''; $aip_sch = '';  ?>
	  </div>
	  </div>
<?php 
if($AIP_data[$mj]->aip_date_verified == '00-00-0000' && !$AIP_data[$mj]->aip_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	if($AIP_data[$mj]->aip_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $AIP_data[$mj]->aip_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($AIP_data[$mj]->aip_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$AIP_data[$mj]->aip_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$AIP_data[$mj]->aip_date_verified.'</b></div></div>'; 
			}
		}
	} 
}	
 ?>
    <div class="clear"></div>



  <input type="hidden" name="old_line_task_aip_ids[]" id="old_line_task_aip_ids_<?PHP echo $mj+1; ?>" value="<?PHP echo $AIP_data[$mj]->id; ?>"/>
<input type="hidden" name="aip_status[]" value="<?PHP echo $AIP_data[$mj]->aip_status; ?>" />
  <input type="hidden" name="current_line_task_aip_ids[]" id="current_line_task_aip_ids<?PHP echo $mj+1; ?>" value="<?PHP echo $mj+1; ?>"  />
 <input type="hidden" name="daip<?PHP echo $mj+1; ?>" id="daip<?PHP echo $mj+1; ?>" value="" />
   <input type="hidden" name="AIP_id[]" id="AIP_id<?PHP echo $mj+1; ?>" value="<?PHP echo $AIP_data[$mj]->id; ?>" />

  </div></div>

<?PHP } ?>

<div id="addcompliance_AIP"></div>

<div id="addcompliance_AIP_loading"></div>

<div id="line_task_WC1">

<?php //$main = $WCI_data[0]->WCI_date_verified;
	$WCI_date_verified = strtotime($WCI_data[0]->WCI_date_verified);
	if($WCI_data[0]->WCI_date_verified=='0000-00-00' || !$WCI_data[0]->WCI_date_verified){
	$WCI_data[0]->WCI_date_verified = '00-00-0000';
	} else {
	$WCI_data[0]->WCI_date_verified = date('m-d-Y', $WCI_date_verified);
	}
	
if($WCI_data[0]->WCI_date_verified == '00-00-0000' && !$WCI_data[0]->WCI_upld_cert)
	$display = 'none';
else
	$display = '';	
   ?>
<?php //echo '<pre>'; print_r($WC_data[0]); ?>
<div class="lic-pan">
    <h2>WORKERS COMPENSATION / EMPLOYER'S LIABILITY POLICY - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
    <?php if($WCI_data[0]->WCI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WCI_data[0]->WCI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayWCI1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WCI_<?PHP echo $WCI_data[0]->WCI_folder_id; ?>&filename=<?PHP echo $WCI_data[0]->WCI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayWCI1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>

     <input type="hidden" class="file_input_textbox" name="WCI_upld_cert1" id="WCI_upld_cert1"  value="<?PHP echo $WCI_data[0]->WCI_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right" id="WCI1" style="display:<?php echo $display; ?>">
	<div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($WCI_data[0]->WCI_end_date < date('Y-m-d')) { $color_exp = 'red';  } ?>
		<?php
		if($WCI_data[0]->WCI_end_date){
			$WCI_data[0]->WCI_end_date = $WCI_data[0]->WCI_end_date ;	
		}
		else{
			$WCI_data[0]->WCI_end_date = '0000-00-00';
		}
		?>
          <?PHP $WCI_end_date = explode('-',$WCI_data[0]->WCI_end_date);  ?>
	<?php if( $WCI_data[0]->WCI_end_date != '0000-00-00') { ?>	  
    <span style="color:<?php echo $color_exp; ?>"><?PHP echo $WCI_end_date[1].'/'.$WCI_end_date[2].'/'.$WCI_end_date[0]; ?></span>
	<?php $color_exp = ''; } else { echo "N/A"; }?>
	</div>
	<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
	<span id="greencolormoney"><?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_disease_policy,2); } ?></span>
	
	</div>
      </div>
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Each Accident:</label>
    <span id="greencolormoney"><?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_each_accident,2); } ?></span>
    
	</div>
	<div class="in-pan1">
	<label>Disease - Each Employee:</label>
	<span id="greencolormoney"><?PHP if($GLI_data) {echo number_format($WCI_data[0]->WCI_disease,2); } ?></span>
	<p style="height:10px;"></p>
	<?php
			if($WCI_data[0]->WCI_waiver == 'waiver')
			$waiver_des = "checked='checked'";
			?>
		 <table cellpadding="0" cellspacing="0"><tr height="8"></tr><tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver_des; ?> value="waiver" name="WCI_waiver0"  style="margin-left:1px;" /></td><td> 
		 <label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation</label></td></tr></table> <br />
		 <?php
		 $primary = '';
		 $waiver = '';
		 $occur = '';
		 ?>
	</div>
      </div>
	  <div class="comm">
        <div class="in-pan" style="margin-top:-43px;">
          <label>MyVC listed as Cert. Holder?</label>
		  <?php if($WCI_data[0]->WCI_cert == 'yes')  {
		  $wcioccur = 'Yes';
		  $wci_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $wcioccur = 'No';
		  $wci_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="WCI_certhide1"><?php echo $wcioccur; ?></span>
        </div>
        
        <div class="clear"></div>
      </div>
    </div>	  
<?php 
if($WCI_data[0]->WCI_date_verified == '00-00-0000' && !$WCI_data[0]->WCI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		
	</font></div></div>
	<?php } else { 
	if($WCI_data[0]->WCI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WCI_data[0]->WCI_end_date != '0000-00-00' && $WCI_data[0]->WCI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WCI_data[0]->WCI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
		echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WCI_data[0]->WCI_date_verified.'</b></div></div>'; 
		}
		else{
		echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$WCI_data[0]->WCI_date_verified.'</b></div></div>'; 
			}
		} 
	}	
}	
 ?>
    <div class="clear"></div>
  </div>

   <input type="hidden" name="WCI_id[]" id="WCI_id1" value="<?PHP echo $WCI_data[0]->id; ?>" />

   <input type="hidden" name="old_line_task_WCI_ids[]" id="old_line_task_WCI_ids_1" value="<?PHP echo $WCI_data[0]->id; ?>" />
   <input type="hidden" name="dWCI1" id="dWCI1" value="" />
<input type="hidden" name="WCI_status[]" value="<?PHP echo $WCI_data[0]->WCI_status; ?>" />
   <input type="hidden" name="current_line_task_WCI_ids[]" id="current_line_task_WCI_ids1" value="1" />


<?PHP for($m=1; $m<count($WCI_data); $m++) { ?>


<div id="line_task_WCI<?PHP echo $m+1; ?>">
<div class="lic-pan">
     <?php //$main = $WCI_data[$m]->WCI_date_verified;
	//$disable = '';
	//$dv = '';
	$WCI_date_verified1 = strtotime($WCI_data[$m]->WCI_date_verified);
	if($WCI_data[$m]->WCI_date_verified=='0000-00-00' || !$WCI_data[$m]->WCI_date_verified){
	$WCI_data[$m]->WCI_date_verified = '00-00-0000';
	} else {
	$WCI_data[$m]->WCI_date_verified = date('m-d-Y', $WCI_date_verified1);
	}
	
if($WCI_data[$m]->WCI_date_verified == '00-00-0000' && !$WCI_data[$m]->WCI_upld_cert)
	$display = 'none';   
else
	$display = '';   	

?>

   <h2>WORKERS COMPENSATION / EMPLOYER'S LIABILITY POLICY - <?PHP echo $m+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
     <?php if($WCI_data[$m]->WCI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WCI_data[$m]->WCI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayWCI<?PHP echo $m+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WCI_<?PHP echo $WCI_data[$m]->WCI_folder_id; ?>&filename=<?PHP echo $WCI_data[$m]->WCI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayWCI<?PHP echo $m+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="WCI_upld_cert[]" id="WCI_upld_cert<?PHP echo $m+1; ?>"  value="<?PHP echo $WCI_data[$m]->WCI_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right" id="WCI<?PHP echo $m+1; ?>" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
	<?php if($WCI_data[$m]->WCI_end_date < date('Y-m-d')) { $color_exp = 'red'; } ?>
	<?php 
	if($WCI_data[$m]->WCI_end_date){
		$WCI_data[$m]->WCI_end_date = $WCI_data[$m]->WCI_end_date;	
	}	
	else{
		$WCI_data[$m]->WCI_end_date = '0000-00-00';
	}
	?>
         <?PHP $WCI_end_date2 = explode('-',$WCI_data[$m]->WCI_end_date);  ?>
	<?php if( $WCI_data[$m]->WCI_end_date != '0000-00-00') { ?>	 
    <span style="color:<?php echo $color_exp; ?>"><?PHP echo $WCI_end_date2[1].'/'.$WCI_end_date2[2].'/'.$WCI_end_date2[0]; ?></span>
	<?php $color_exp = ''; } else { echo "N/A"; } ?>
	
	</div>
	<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
    <span id="greencolormoney"><?PHP if($WCI_data[$m]->WCI_disease_policy) {echo number_format($WCI_data[$m]->WCI_disease_policy,2); } else { echo "0.00"; } ?></span>
	<p style="height:10px;"></p>
	<label>Disease - Each Employee:</label>
	<span id="greencolormoney"><?PHP if($WCI_data[$m]->WCI_disease) {echo number_format($WCI_data[$m]->WCI_disease,2); } else { echo "0.00"; } ?></span>
	</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        
	</div>
	<div class="in-pan1">
	<?php
			if($WCI_data[$m]->WCI_waiver == 'waiver')
			$waiver_desd = "checked='checked'";
			?>
<table cellpadding="0" cellspacing="0"><tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver_desd; ?> value="waiver" name="WCI_waiver<?PHP echo $m; ?>" style="margin-left:1px;" /></td><td> <label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation</label></td></tr></table> 
		 <?php
		 $waiver_desd = '';
		 ?>
	</div>
      </div>
	  <div class="comm">
	  <div class="in-pan" style="margin-top:-65px;">
        <label>Each Accident:</label>
    <span id="greencolormoney"><?PHP if($WCI_data[$m]->WCI_each_accident) {echo number_format($WCI_data[$m]->WCI_each_accident,2); } else { echo "0.00"; } ?></span>
	</div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan" style="margin-top:-18px;">
          <label>MyVC listed as Cert. Holder?&nbsp;</label>
		  <?php if($WCI_data[$m]->WCI_cert == 'yes')  {
		  $wcioccurp = 'Yes';
		  $wci_classfp = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $wcioccurp = 'No';
		  $wci_classsp = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="WCI_certhide<?PHP echo $m+1; ?>"><?php echo $wcioccurp; ?></span>
        </div>
        <div class="clear"></div>
      </div>
   </div>   
<?php 
if($WCI_data[$m]->WCI_date_verified == '00-00-0000' && !$WCI_data[$m]->WCI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	
	if($WCI_data[$m]->WCI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WCI_data[$m]->WCI_end_date != '0000-00-00' && $WCI_data[$m]->WCI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WCI_data[$m]->WCI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
		echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WCI_data[$m]->WCI_date_verified.'</b></div></div>'; 
		}
		else{
		echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$WCI_data[$m]->WCI_date_verified.'</b></div></div>'; 
		}
	}
	} 
}	
 ?>

	  	  
    
    <div class="clear"></div>

 <input type="hidden" name="WCI_id[]" id="WCI_id<?PHP echo $m+1; ?>" value="<?PHP echo $WCI_data[$m]->id; ?>" />

   <input type="hidden" name="old_line_task_WCI_ids[]" id="old_line_task_WCI_ids_<?PHP echo $m+1; ?>" value="<?PHP echo $WCI_data[$m]->id; ?>"/>
<input type="hidden" name="WCI_status[]" value="<?PHP echo $WCI_data[$m]->WCI_status; ?>" />
 <input type="hidden" name="dWCI<?PHP echo $m+1; ?>" id="dWCI<?PHP echo $m+1; ?>" value="" />
   <input type="hidden" name="current_line_task_WCI_ids[]" id="current_line_task_WCI_ids<?PHP echo $m+1; ?>" value="<?PHP echo $m+1; ?>" />

  </div></div>

<?PHP } ?>

<div id="addcompliance_WCI"></div>

<div id="addcompliance_WCI_loading"></div>
<br />
<?php 
	$UMB_date_verified = strtotime($UMB_data[0]->UMB_date_verified);
	if($UMB_data[0]->UMB_date_verified=='0000-00-00' || !$UMB_data[0]->UMB_date_verified){
	$UMB_data[0]->UMB_date_verified = '00-00-0000';
	} else {
	$UMB_data[0]->UMB_date_verified = date('m-d-Y', $UMB_date_verified);
	}
  
if($UMB_data[0]->UMB_date_verified == '00-00-0000' && !$UMB_data[0]->UMB_upld_cert)
	$display = 'none';	
else
	$display = '';		
   ?><input type="hidden" name="type" id="type"  value="" />
   <input type="hidden" name="type_id" id="type_id"  value="" />

<?php //echo '<pre>'; print_r($OLN_data[0]); ?>
<!--<script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>-->
  <div  id="line_task_UMB<?PHP echo 1; ?>"><div class="lic-pan">
    <h2>UMBRELLA LIABILITY POLICY - 1 </h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($UMB_data[0]->UMB_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $UMB_data[0]->UMB_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayUMB1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=UMB_<?PHP echo $UMB_data[0]->UMB_folder_id; ?>&filename=<?PHP echo $UMB_data[0]->UMB_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="NO Image" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayUMB1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
       </div>
    <div class="lic-pan-right" id="UMB1" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($UMB_data[0]->UMB_expdate < date('Y-m-d')) { $color_exp = 'red'; } 
                if($UMB_data[0]->UMB_expdate){ 
                    $UMB_data[0]->UMB_expdate=$UMB_data[0]->UMB_expdate;
                   } else { 
                    $UMB_data[0]->UMB_expdate='0000-00-00';                            
                    } ?>
           <?PHP $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
		   
        <span style="color:<?php echo $color_exp; ?>"> <?php echo $UMB_date[1].'/'.$UMB_date[2].'/'.$UMB_date[0]; ?></span>
        <?php $color_exp = ''; ?>
		</div>
		<div class="in-pan1">
		<label>Aggregate:</label>
	<span id="greencolormoney"><?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_aggregate,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Each Occurrence</label>
           <?PHP $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
        <span id="greencolormoney"><?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_occur,2); } ?></span>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert. Holder?</label>
		  <?php if($UMB_data[0]->UMB_certholder == 'yes')  {
		  $umboccur = 'Yes';
		  $umb_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $umboccur = 'No';
		  $umb_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="UMB_certhide1"><?php echo $umboccur; ?></span>
        </div>
		</div>
</div>
<?php 
if($UMB_data[0]->UMB_date_verified == '00-00-0000' && !$UMB_data[0]->UMB_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
	</font></div></div>
	<?php } else { 
	if($UMB_data[0]->UMB_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $UMB_data[0]->UMB_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($UMB_data[0]->UMB_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$UMB_data[0]->UMB_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$UMB_data[0]->UMB_date_verified.'</b></div></div>'; 
			}
		}
	} 
}	
?>
	 	  
    
	<div class="clear"></div>
	

  <div class="clear"></div>
  </div>
   </div>
   <?PHP for($i=1; $i<count($UMB_data); $i++) { ?>
           <?php 
	$UMB_date_verified1 = strtotime($UMB_data[$i]->UMB_date_verified);
	if($UMB_data[$i]->UMB_date_verified=='0000-00-00' || !$UMB_data[$i]->UMB_date_verified){
	$UMB_data[$i]->UMB_date_verified = '00-00-0000';
	} else {
	$UMB_data[$i]->UMB_date_verified = date('m-d-Y', $UMB_date_verified1);
	}

if($UMB_data[$i]->UMB_date_verified == '00-00-0000' && !$UMB_data[$i]->UMB_upld_cert)
	$display = 'none';	
else
	$display = '';			
   ?> 
<div id="line_task_UMB<?PHP echo $i+1; ?>">
<div class="lic-pan">
    <h2>UMBRELLA LIABILITY POLICY - <?PHP echo $i+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($UMB_data[$i]->UMB_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $UMB_data[$i]->UMB_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayUMB<?PHP echo $i+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=UMB_<?PHP echo $UMB_data[$i]->UMB_folder_id; ?>&filename=<?PHP echo $UMB_data[$i]->UMB_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayUMB<?PHP echo $i+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <?php //echo '<pre>'; print_r($OLN_data[$i]); ?>
	  </div>
    <div class="lic-pan-right" id="UMB<?PHP echo $i+1; ?>" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($UMB_data[$i]->UMB_expdate < date('Y-m-d')){ $color_exp = 'red'; } ?>
		<?php
			if($UMB_data[$i]->UMB_expdate){
				$UMB_data[$i]->UMB_expdate = $UMB_data[$i]->UMB_expdate;
			}
			else{
				$UMB_data[$i]->UMB_expdate = '0000-00-00';
			}
		?>
           <?PHP $UMB_date2 = explode('-',$UMB_data[$i]->UMB_expdate); ?>
     <span style="color:<?php echo $color_exp; ?>"><?PHP echo $UMB_date2[1].'/'.$UMB_date2[2].'/'.$UMB_date2[0]; ?></span>
	  <?php $color_exp = ''; ?>
	  </div>
	  <div class="in-pan1">
		<label>Aggregate:</label>
	<span id="greencolormoney"><?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_aggregate,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
        <span id="greencolormoney"><?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_occur,2); } ?></span>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert. Holder?</label>
		  <?php if($UMB_data[$i]->UMB_certholder == 'yes')  {
		  $umboccurs = 'Yes';
		  $umb_classfs = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $umboccurs = 'No';
		  $umb_classss = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="UMB_certhide<?PHP echo $i+1; ?>"><?php echo $umboccurs; ?></span>
        </div>
		</div>
      
	  
 </div>
<?php 
if($UMB_data[$i]->UMB_date_verified == '00-00-0000' && !$UMB_data[$i]->UMB_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		
	</font></div></div>
	<?php } else { 
	if($UMB_data[$i]->UMB_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $UMB_data[$i]->UMB_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>'; }
	else if($UMB_data[$i]->UMB_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$UMB_data[$i]->UMB_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$UMB_data[$i]->UMB_date_verified.'</b></div></div>'; 
		}
	}
	} 
}	
?>
	  
   
	<div class="clear"></div>
  </div></div>

<?PHP } ?>

   <!-- Completed -->
<!-- Workers comp completed -->
<!-- table row end -->

<!-- table row start -->

 <?php //$main = $OLN_data[0]->OLN_date_verified;
//echo '<pre>'; print_r($OLN_data[0]);
	$OLN_date_verified = strtotime($OLN_data[0]->OLN_date_verified);
	if($OLN_data[0]->OLN_date_verified=='0000-00-00' || !$OLN_data[0]->OLN_date_verified){
	$OLN_data[0]->OLN_date_verified = '00-00-0000';
	} else {
	$OLN_data[0]->OLN_date_verified = date('m-d-Y', $OLN_date_verified);
	}

if($OLN_data[0]->OLN_date_verified == '00-00-0000' && !$OLN_data[0]->OLN_upld_cert)
	$display = 'none';
else
	$display = '';	  
  
   ?><input type="hidden" name="type" id="type"  value="" />
   <input type="hidden" name="type_id" id="type_id"  value="" />

<?php //echo '<pre>'; print_r($OLN_data[0]); ?>
<!--<script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>-->
  <div  id="line_task_OLN<?PHP echo 1; ?>"><div class="lic-pan">
    <h2>Bus. Tax Receipt / Occupational License - 1 </h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($OLN_data[0]->OLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OLN_data[0]->OLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOLN1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OLN_<?PHP echo $OLN_data[0]->OLN_folder_id; ?>&filename=<?PHP echo $OLN_data[0]->OLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="NO Image" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOLN1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      
       </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
        <label>Expiration Date:</label>
		 <?php if($OLN_data[0]->OLN_expdate < date('Y-m-d')) { $color_exp = 'red'; } ?>
		 <?php
		 if($OLN_data[0]->OLN_expdate){
		 	$OLN_data[0]->OLN_expdate = $OLN_data[0]->OLN_expdate ;
		 }
		 else{
		 	$OLN_data[0]->OLN_expdate = '0000-00-00';
		 }
		 ?>
           <?PHP $OLN_date = explode('-',$OLN_data[0]->OLN_expdate); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP echo $OLN_date[1].'/'.$OLN_date[2].'/'.$OLN_date[0]; ?></span>
           <?php $color_exp = ''; ?>
        <script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
	  </div>
<?php 
if($OLN_data[0]->OLN_date_verified == '00-00-0000' && !$OLN_data[0]->OLN_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
	</font></div></div>
	<?php } else { 
	if($OLN_data[0]->OLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OLN_data[0]->OLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>'; }
	else if($OLN_data[0]->OLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OLN_data[0]->OLN_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$OLN_data[0]->OLN_date_verified.'</b></div></div>'; 
			}
		}
	} 
}	
?>

    
    <div class="clear"></div>
  </div>

   <input type="hidden" name="del_line_task_OLN_ids[]" id="del_line_task_OLN_ids_1" value="" />

  <input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_1" value="<?PHP echo $OLN_data[0]->id; ?>"/>
   <input type="hidden" name="dOLN1" id="dOLN1" value="" />
<input type="hidden" name="OLN_status[]" value="<?PHP echo $OLN_data[0]->OLN_status; ?>" />
  <input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids1" value="1"  />

   <input type="hidden" name="OLN_id[]" id="OLN_id1" value="<?PHP echo $OLN_data[0]->id; ?>" />

  <?php //echo '<pre>'; print_r($PLN_data); ?>
<?PHP for($i=1; $i<count($OLN_data); $i++) { ?>
           <?php //$main = $OLN_data[$i]->OLN_date_verified;
	$OLN_date_verified1 = strtotime($OLN_data[$i]->OLN_date_verified);
	if($OLN_data[$i]->OLN_date_verified=='0000-00-00' || !$OLN_data[$i]->OLN_date_verified){
	$OLN_data[$i]->OLN_date_verified = '00-00-0000';
	} else {
	$OLN_data[$i]->OLN_date_verified = date('m-d-Y', $OLN_date_verified1);
	}
if($OLN_data[$i]->OLN_date_verified == '00-00-0000' && !$OLN_data[$i]->OLN_upld_cert)
	$display = 'none'; 
else
	$display = ''; 	
	
   ?> <input type="hidden" name="del_line_task_OLN_ids[]" id="del_line_task_OLN_ids_<?PHP echo $i+1; ?>" value="" />
<input type="hidden" name="OLN_status[]" value="<?PHP echo $OLN_data[$i]->OLN_status; ?>" />
<input type="hidden" name="dOLN<?PHP echo $i+1; ?>" id="dOLN<?PHP echo $i+1; ?>" value="" />
  <input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_<?PHP echo $i+1; ?>" value="<?PHP echo $OLN_data[$i]->id; ?>" />
  <input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids<?PHP echo $i+1; ?>" value="<?PHP echo $i+1; ?>" />

   <input type="hidden" name="OLN_id<?PHP echo $i+1; ?>" id="OLN_id<?PHP echo $i+1; ?>" value="<?PHP echo $OLN_data[$i]->id; ?>" />
<!--//(isset($OLN_data[$i]->OLN_expdate) && $OLN_data[$i]->OLN_expdate != '0000-00-00' && $OLN_data[$i]->OLN_expdate < date('Y-m-d'))-->
<div id="line_task_OLN<?PHP echo $i+1; ?>">
<div class="lic-pan">
    <h2>Bus. Tax Receipt / Occupational License - <?PHP echo $i+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($OLN_data[$i]->OLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OLN_data[$i]->OLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOLN<?PHP echo $i+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OLN_<?PHP echo $OLN_data[$i]->OLN_folder_id; ?>&filename=<?PHP echo $OLN_data[$i]->OLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOLN<?PHP echo $i+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <?php //echo '<pre>'; print_r($OLN_data[$i]); ?>
      </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
        <label>Expiration Date:</label>
	<?php if($OLN_data[$i]->OLN_expdate < date('Y-m-d')){ $color_exp = 'red'; } ?>	
	<?php
		if($OLN_data[$i]->OLN_expdate){
			$OLN_data[$i]->OLN_expdate = $OLN_data[$i]->OLN_expdate ;	
		}
		else{
			$OLN_data[$i]->OLN_expdate = '0000-00-00';
		}
	?>
           <?PHP $OLN_date2 = explode('-',$OLN_data[$i]->OLN_expdate); ?>
      <span style="color:<?php echo $color_exp; ?>"><?PHP echo $OLN_date2[1].'/'.$OLN_date2[2].'/'.$OLN_date2[0]; ?></span>
	  <?php $color_exp = ''; ?>
	  <script type="text/javascript">G('#OLN_expdate<?PHP echo $i+1; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      
</div>
<?php 
if($OLN_data[$i]->OLN_date_verified == '00-00-0000' && !$OLN_data[$i]->OLN_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
	</font></div></div>
	<?php } else { 
	if($OLN_data[$i]->OLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OLN_data[$i]->OLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>'; }
	else if($OLN_data[$i]->OLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OLN_data[$i]->OLN_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$OLN_data[$i]->OLN_date_verified.'</b></div></div>'; 
		}
		}
	} 
}	
?>
	  
    
    <div class="clear"></div>
  </div></div>

<?PHP } ?>

<div id="addcompliance_OLN"></div>

<div id="addcompliance_OLN_loading"></div>

<!-- table row end -->
<!--// || (isset($PLN_data[0]->PLN_expdate) && $PLN_data[0]->PLN_expdate != '0000-00-00' && $PLN_data[0]->PLN_expdate < date('Y-m-d'))-->
<div id="line_task_PLN1">
<div class="lic-pan">
    <h2>PROFESSIONAL LICENSE - 1</h2>
    <div class="clear"></div>
    <?php 
    $PLN_date_verified = strtotime($PLN_data[0]->PLN_date_verified);
	if($PLN_data[0]->PLN_date_verified=='0000-00-00' || !$PLN_data[0]->PLN_date_verified){
	$PLN_data[0]->PLN_date_verified = '00-00-0000';
	} else {
	$PLN_data[0]->PLN_date_verified = date('m-d-Y', $PLN_date_verified);
	}
    
if($PLN_data[0]->PLN_date_verified == '00-00-0000' && !$PLN_data[0]->PLN_upld_cert)
	$display = 'none';
else
	$display = '';	
   ?>


<input type="hidden" name="PLN_id[]" id="PLN_id<?PHP echo $j+1; ?>" value="<?PHP echo $PLN_data[0]->id; ?>"/>

   <input type="hidden" name="old_line_task_PLN_ids[]" id="old_line_task_PLN_ids_1" value="<?PHP echo $PLN_data[0]->id; ?>"/>
    <input type="hidden" name="dPLN1" id="dPLN1" value="" />
<input type="hidden" name="PLN_status[]" value="<?PHP echo $PLN_data[0]->PLN_status; ?>" />
   <input type="hidden" name="current_line_task_PLN_ids[]" id="current_line_task_PLN_ids<?PHP echo $PLN_data[0]->id; ?>" value="1" />

<?php //echo '<pre>'; print_r($PLN_data[0]);?>

    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
      <?php if($PLN_data[0]->PLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $PLN_data[0]->PLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayPLN1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=PLN_<?PHP echo $PLN_data[0]->PLN_folder_id; ?>&filename=<?PHP echo $PLN_data[0]->PLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayPLN1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
     <input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert1"  value="<?PHP echo $PLN_data[0]->PLN_upld_cert; ?>" />
        </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Expiration Date:</label>
	<?php if($PLN_data[0]->PLN_expdate < date('Y-m-d')) { $color_exp = 'red'; } ?>	
	<?php
		if($PLN_data[0]->PLN_expdate){
			$PLN_data[0]->PLN_expdate = $PLN_data[0]->PLN_expdate;
		}
		else{
			$PLN_data[0]->PLN_expdate = '0000-00-00';
		}
	?>
        <?PHP $PLN_date = explode('-',$PLN_data[0]->PLN_expdate);  ?>
  <span style="color:<?php echo $color_exp; ?>"><?PHP echo $PLN_date[1].'/'.$PLN_date[2].'/'.$PLN_date[0]; ?></span>
  <?php $color_exp = ''; ?>
  
  <script type="text/javascript">G('#PLN_expdate1').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
	  </div>
      <div class="comm">
        <div class="in-pan">
         <?php if($PLN_data[0]->PLN_upld_cert!=''){ ?> <label>Jurisdiction (state/country/city/association):</label>
		  <?php
		$db = JFactory::getDBO();  
		$statename="SELECT 	state FROM #__cam_vendor_states  where id='".$PLN_data[0]->PLN_state."'";
		$db->Setquery($statename);
		$state_name = $db->loadResult();
		if($state_name){
		$PLN_data[0]->PLN_state = $state_name ;
		}
		else{
		$PLN_data[0]->PLN_state = $PLN_data[0]->PLN_state  ;
		}
		  ?>
           <span id="greencolormoney"><?php echo $PLN_data[0]->PLN_state; ?></span>
		   <?php if(!$PLN_data[0]->PLN_state) { ?> <!--<span style="font-size: 20px;">*</span>--><?php } ?>
        </div>
        <div class="in-pan1">
          <label>License Type:</label>
		  <?PHP $db = JFactory::getDBO();
		$sql_subcat = "SELECT subcat_name FROM #__compliance_license_sub_categories WHERE id= ".$PLN_data[0]->PLN_type." ";
		$db->Setquery($sql_subcat);
		$subcatname = $db->loadResult();
		if($subcatname){
		$PLN_data[0]->PLN_type = $subcatname ;
		}
		else{
		$PLN_data[0]->PLN_type = $PLN_data[0]->PLN_type  ;
		}
		 ?>
        <span id="greencolormoney"><?php echo $PLN_data[0]->PLN_type; ?></span>
	<?php } ?>	<?php //if(!$PLN_data[0]->PLN_type) { ?> <!--<span style="font-size: 20px;">*</span>--><?php //} ?>
        </div>
        <div class="clear"></div>
      </div>
</div>
<?php 
if($PLN_data[0]->PLN_date_verified == '00-00-0000' && !$PLN_data[0]->PLN_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	if($PLN_data[0]->PLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $PLN_data[0]->PLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($PLN_data[0]->PLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
		echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$PLN_data[0]->PLN_date_verified.'</b></div></div>'; 
		}
		else{
		echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$PLN_data[0]->PLN_date_verified.'</b></div></div>'; 
		}
		}
	} 
}	
?>

    
    <div class="clear"></div>
  </div>
      <div class="clear"></div>
</div>

<?PHP for($j=1; $j<count($PLN_data); $j++) {?>

<div id="line_task_PLN<?PHP echo $j+1; ?>" >
<div class="lic-pan">
    <h2>PROFESSIONAL LICENSE - <?PHP echo $j+1; ?></h2>
    <div class="clear"></div>
    <?php
    $PLN_date_verified1 = strtotime($PLN_data[$j]->PLN_date_verified);
	if($PLN_data[$j]->PLN_date_verified=='0000-00-00' || !$PLN_data[$j]->PLN_date_verified){
	$PLN_data[$j]->PLN_date_verified = '00-00-0000';
	} else {
	$PLN_data[$j]->PLN_date_verified = date('m-d-Y', $PLN_date_verified1);
	}
   
if($PLN_data[$j]->PLN_date_verified == '00-00-0000' && !$PLN_data[$j]->PLN_upld_cert)
	$display = 'none';
else
	$display = '';	
   ?>


    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
      <?php if($PLN_data[$j]->PLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $PLN_data[$j]->PLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayPLN<?PHP echo $j+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=PLN_<?PHP echo $PLN_data[$j]->PLN_folder_id; ?>&filename=<?PHP echo $PLN_data[$j]->PLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayPLN<?PHP echo $j+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
     <input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert<?PHP echo $j+1; ?>"  value="<?PHP echo $PLN_data[$j]->PLN_upld_cert; ?>" /><br/>
      </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Expiration Date:</label>
		<?php if($PLN_data[$j]->PLN_expdate < date('Y-m-d')) { $color_exp = 'red'; } ?>
		<?php if($PLN_data[$j]->PLN_expdate){
				$PLN_data[$j]->PLN_expdate = $PLN_data[$j]->PLN_expdate ;
			  }
			  else{
			  $PLN_data[$j]->PLN_expdate = '0000-00-00';
			  }
			  ?>
		
        <?PHP $PLN_date = explode('-',$PLN_data[$j]->PLN_expdate);  ?>
	  <span style="color:<?php echo $color_exp; ?>"><?PHP echo $PLN_date[1].'/'.$PLN_date[2].'/'.$PLN_date[0]; ?></span>
  <?php $color_exp = ''; ?>
  <script type="text/javascript">G('#PLN_expdate<?PHP echo $j+1; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
	  </div>
      <div class="comm">
        <div class="in-pan">
          <?php if($PLN_data[$j]->PLN_upld_cert!=''){ ?> <label>Jurisdiction (state/country/city/association):</label>
		   <?php
		$db = JFactory::getDBO();  
		$statename="SELECT 	state FROM #__cam_vendor_states  where id='".$PLN_data[$j]->PLN_state."'";
		$db->Setquery($statename);
		$state_name = $db->loadResult();
		if($state_name){
		$PLN_data[$j]->PLN_state = $state_name ;
		}
		else{
		$PLN_data[$j]->PLN_state = $PLN_data[$j]->PLN_state  ;
		}
		  ?>
           <span id="greencolormoney"><?php echo $PLN_data[$j]->PLN_state; ?></span>
		   <?php //if(!$PLN_data[$j]->PLN_state) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php //} ?>
        </div>
        <div class="in-pan1">
          <label>License Type:</label>
		   <?PHP $db = JFactory::getDBO();
		$sql_subcat = "SELECT subcat_name FROM #__compliance_license_sub_categories WHERE id= ".$PLN_data[$j]->PLN_type." ";
		$db->Setquery($sql_subcat);
		$subcatname = $db->loadResult();
		if($subcatname){
		$PLN_data[$j]->PLN_type = $subcatname ;
		}
		else{
		$PLN_data[$j]->PLN_type = $PLN_data[$j]->PLN_type  ;
		}
		 ?>
        <span id="greencolormoney"><?php echo $PLN_data[$j]->PLN_type; ?></span>
	<?php }	?><?php //if(!$PLN_data[$j]->PLN_type) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php //} ?>
        </div>
        <div class="clear"></div>
      </div>
	  </div>
<?php 
if($PLN_data[$j]->PLN_date_verified == '00-00-0000' && !$PLN_data[$j]->PLN_upld_cert){ 
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	if($PLN_data[$j]->PLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $PLN_data[$j]->PLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($PLN_data[$j]->PLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$PLN_data[$j]->PLN_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$PLN_data[$j]->PLN_date_verified.'</b></div></div>'; 
		}
		}
	} 
}	
?>

	  
    
    <div class="clear"></div>
  </div>
</div>

<?PHP } ?>

<div id="addcompliance_PLN"></div>

<div id="addcompliance_PLN_loading"></div>

<!-- table row end -->

<!--<p style=" padding-top:20px;"></p>-->

<!-- table row start-->


<!-- table row start -->
<!--//|| (isset($WCI_data[0]->WCI_end_date) && $WCI_data[0]->WCI_end_date != '0000-00-00' && $WCI_data[0]->WCI_end_date < date('Y-m-d'))-->


<!--<p style=" padding-top:20px;"></p>-->
<!-- table row start -->
<!--//|| (isset($WCI_data[0]->WCI_end_date) && $WCI_data[0]->WCI_end_date != '0000-00-00' && $WCI_data[0]->WCI_end_date < date('Y-m-d'))-->
<div id="line_task_WC">

 <?php 
	$wc_date_verified = strtotime($WC_data[0]->wc_date_verified);
	if($WC_data[0]->wc_date_verified=='0000-00-00' || !$WC_data[0]->wc_date_verified){
	$WC_data[0]->wc_date_verified = '00-00-0000';
	} else {
	$WC_data[0]->wc_date_verified = date('m-d-Y', $wc_date_verified);
	}

if($WC_data[0]->wc_date_verified == '00-00-0000' && !$WC_data[0]->wc_upld_cert)
	$display = 'none'; 
else
	$display = ''; 	
   ?>

<div class="lic-pan">
    <h2>WORKERS COMP EXEMPTION FORM - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
       <?php if($WC_data[0]->wc_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WC_data[0]->wc_upld_cert)); ?>
      <div class="imag-display" id="imagdisplaywc1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WC_<?PHP echo $WC_data[0]->wc_folder_id; ?>&filename=<?PHP echo $WC_data[0]->wc_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplaywc1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      
   <input type="hidden" class="file_input_textbox" name="wc_upld_cert[]" id="wc_upld_cert1"  value="<?PHP echo $WC_data[0]->wc_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Expiration Date:</label>
		<?php if($WC_data[0]->wc_end_date < date('Y-m-d')) { $color_exp = 'red'; } ?>
		<?php if($WC_data[0]->wc_end_date) {
			$WC_data[0]->wc_end_date = $WC_data[0]->wc_end_date ;
		}
		else
		{
		$WC_data[0]->wc_end_date = '0000-00-00';
		}
		?>
            <?PHP $wc_date = explode('-',$WC_data[0]->wc_end_date); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP if($WC_data[0]->wc_end_date){ echo $wc_date[1].'/'.$wc_date[2].'/'.$wc_date[0]; }  ?></span>
		<?php $color_exp = ''; ?>
		<script type="text/javascript">G('#wc_end_date1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
	  </div>
</div>
<?php 
if($WC_data[0]->wc_date_verified == '00-00-0000' && !$WC_data[0]->wc_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	if($WC_data[0]->wc_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WC_data[0]->wc_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WC_data[0]->wc_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WC_data[0]->wc_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$WC_data[0]->wc_date_verified.'</b></div></div>'; 
		}
		}
	} 
}	
?>


    
    <div class="clear"></div>
  </div>


  <input type="hidden" name="old_line_task_wc_ids[]" id="old_line_task_wc_ids_1" value="<?PHP echo $WC_data[0]->id; ?>" /><input type="hidden" name="wc_status[]" value="<?PHP echo $WC_data[0]->wc_status; ?>" />
 <input type="hidden" name="dwc1" id="dwc1" value="" />
  <input type="hidden" name="current_line_task_wc_ids[]" id="current_line_task_wc_ids1" value="1"  />

   <input type="hidden" name="WC_id[]" id="wc_id1" value="<?PHP echo $WC_data[0]->id; ?>" />
</div>

<?PHP for($mj=1; $mj<count($WC_data); $mj++) { //echo "<pre>"; print_r($WCI_data); ?>

<div  id="line_task_WC<?PHP echo $mj+1; ?>"><div class="lic-pan">
    <?php 
    $wc_date_verified1 = strtotime($WC_data[$mj]->wc_date_verified);
	if($WC_data[$mj]->wc_date_verified=='0000-00-00' || !$WC_data[$mj]->wc_date_verified){
	$WC_data[$mj]->wc_date_verified = '00-00-0000';
	} else {
	$WC_data[$mj]->wc_date_verified = date('m-d-Y', $wc_date_verified1);
	}
    
if($WC_data[$mj]->wc_date_verified == '00-00-0000' && !$WC_data[$mj]->wc_upld_cert)
	$display = 'none';	
else
	$display = '';		
   ?>
        <h2>WORKERS COMP EXEMPTION FORM - <?PHP echo $mj+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">

       <?php if($WC_data[$mj]->wc_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WC_data[$mj]->wc_upld_cert)); ?>
      <div class="imag-display" id="imagdisplaywc<?PHP echo $mj+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WC_<?PHP echo $WC_data[$mj]->wc_folder_id; ?>&filename=<?PHP echo $WC_data[$mj]->wc_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplaywc<?PHP echo $mj+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
       <input type="hidden" class="file_input_textbox" name="wc_upld_cert[]" id="wc_upld_cert<?PHP echo $mj+1; ?>"  value="<?PHP echo $WC_data[$mj]->wc_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Expiration Date:</label>
		<?php if($WC_data[$mj]->wc_end_date < date('Y-m-d')) { $color_exp = 'red'; } ?>
		<?php
			if($WC_data[$mj]->wc_end_date){
				$WC_data[$mj]->wc_end_date = $WC_data[$mj]->wc_end_date;
			}	
			else{
				$WC_data[$mj]->wc_end_date = '0000-00-00';
			}
		?>
    <?PHP $wc_date1 = explode('-',$WC_data[$mj]->wc_end_date); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP echo $wc_date1[1].'/'.$wc_date1[2].'/'.$wc_date1[0]; ?></span>
		<?php $color_exp = ''; ?>
		<script type="text/javascript">G('#wc_end_date<?PHP echo $mj+1; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
	  </div>
	  </div>
<?php 
if($WC_data[$mj]->wc_date_verified == '00-00-0000' && !$WC_data[$mj]->wc_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		</font></div></div>
	<?php } else { 
	if($WC_data[$mj]->wc_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WC_data[$mj]->wc_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WC_data[$mj]->wc_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WC_data[$mj]->wc_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$WC_data[$mj]->wc_date_verified.'</b></div></div>'; 
		}
		}
	} 
}	
?>	  
    
    <div class="clear"></div>



  <input type="hidden" name="old_line_task_wc_ids[]" id="old_line_task_wc_ids_<?PHP echo $mj+1; ?>" value="<?PHP echo $WC_data[$mj]->id; ?>"/>
<input type="hidden" name="wc_status[]" value="<?PHP echo $WC_data[$mj]->wc_status; ?>" />
  <input type="hidden" name="current_line_task_wc_ids[]" id="current_line_task_wc_ids<?PHP echo $mj+1; ?>" value="<?PHP echo $mj+1; ?>"  />
 <input type="hidden" name="dwc<?PHP echo $mj+1; ?>" id="dwc<?PHP echo $mj+1; ?>" value="" />
   <input type="hidden" name="WC_id[]" id="WC_id<?PHP echo $mj+1; ?>" value="<?PHP echo $WC_data[$mj]->id; ?>" />

  </div></div>

<?PHP } ?>

<div id="addcompliance_WC"></div>

<div id="addcompliance_WC_loading"></div>



<?php 
	$OMI_date_verified = strtotime($OMI_data[0]->OMI_date_verified);
	if($OMI_data[0]->OMI_date_verified=='0000-00-00' || !$OMI_data[0]->OMI_date_verified){
	$OMI_data[0]->OMI_date_verified = '00-00-0000';
	} else {
	$OMI_data[0]->OMI_date_verified = date('m-d-Y', $OMI_date_verified);
	}
  
if($OMI_data[0]->OMI_date_verified == '00-00-0000' && !$OMI_data[0]->OMI_upld_cert)
	$display = 'none';	
else
	$display = '';		
   ?><input type="hidden" name="type" id="type"  value="" />
   <input type="hidden" name="type_id" id="type_id"  value="" />

<?php //echo '<pre>'; print_r($OLN_data[0]); ?>
<!--<script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>-->
  <div  id="line_task_OMI<?PHP echo 1; ?>"><div class="lic-pan">
    <h2>ERRORS & OMISSIONS INSURANCE - 1 </h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($OMI_data[0]->OMI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OMI_data[0]->OMI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOMI1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OMI_<?PHP echo $OMI_data[0]->OMI_folder_id; ?>&filename=<?PHP echo $OMI_data[0]->OMI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="NO Image" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOMI1"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
       </div>
    <div class="lic-pan-right" id="OMI1" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($OMI_data[0]->OMI_end_date < date('Y-m-d')) { $color_exp = 'red'; } 
                if($OMI_data[0]->OMI_end_date){ 
                    $OMI_data[0]->OMI_end_date = $OMI_data[0]->OMI_end_date;
                   } else { 
                    $OMI_data[0]->OMI_end_date='0000-00-00';                            
                    } ?>
           <?PHP $OMI_date = explode('-',$OMI_data[0]->OMI_end_date); ?>
		   
        <span style="color:<?php echo $color_exp; ?>"> <?php echo $OMI_date[1].'/'.$OMI_date[2].'/'.$OMI_date[0]; ?></span>
        <?php $color_exp = ''; ?>
		</div>
		<div class="in-pan1">
		<label style="padding-top:5px;">Each Claim:</label>
           <?PHP $OMI_date = explode('-',$OMI_data[0]->OMI_end_date); ?>
        <span id="greencolormoney"><?PHP if($OMI_data) {echo number_format($OMI_data[0]->OMI_each_claim,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Aggregate:</label>
	<span id="greencolormoney"><?PHP if($OMI_data) {echo number_format($OMI_data[0]->OMI_aggregate,2); } ?></span>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert. Holder?</label>
		  <?php if($OMI_data[0]->OMI_cert == 'yes')  {
		  $omioccur = 'Yes';
		  $omi_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $omioccur = 'No';
		  $omi_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="OMI_certhide1"><?php echo $omioccur; ?></span>
        </div>
		</div>
</div>
<?php 
if($OMI_data[0]->OMI_date_verified == '00-00-0000' && !$OMI_data[0]->OMI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
	</font></div></div>
	<?php } else { 
	if($OMI_data[0]->OMI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OMI_data[0]->OMI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($OMI_data[0]->OMI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OMI_data[0]->OMI_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$OMI_data[0]->OMI_date_verified.'</b></div></div>'; 
			}
		}
	} 
}	
?>
	 	  
    
	<div class="clear"></div>
	

  <div class="clear"></div>
  </div>
   </div>
   <?PHP for($i=1; $i<count($OMI_data); $i++) { ?>
           <?php 
	$OMI_date_verified1 = strtotime($OMI_data[$i]->OMI_date_verified);
	if($OMI_data[$i]->OMI_date_verified=='0000-00-00' || !$OMI_data[$i]->OMI_date_verified){
	$OMI_data[$i]->OMI_date_verified = '00-00-0000';
	} else {
	$OMI_data[$i]->OMI_date_verified = date('m-d-Y', $OMI_date_verified1);
	}

if($OMI_data[$i]->OMI_date_verified == '00-00-0000' && !$OMI_data[$i]->OMI_upld_cert)
	$display = 'none';	
else
	$display = '';			
   ?> 
<div id="line_task_OMI<?PHP echo $i+1; ?>">
<div class="lic-pan">
    <h2>ERRORS & OMISSIONS INSURANCE - <?PHP echo $i+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left" style="display:<?php echo $display; ?>">
        <?php if($OMI_data[$i]->OMI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OMI_data[$i]->OMI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOMI<?PHP echo $i+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OMI_<?PHP echo $OMI_data[$i]->OMI_folder_id; ?>&filename=<?PHP echo $OMI_data[$i]->OMI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="<?php echo Juri::base(); ?>templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOMI<?PHP echo $i+1; ?>"><span id="nofileuploaded">NO FILE UPLOADED</span></div>
      <?php } ?>
      <?php //echo '<pre>'; print_r($OLN_data[$i]); ?>
	  </div>
    <div class="lic-pan-right" id="OMI<?PHP echo $i+1; ?>" style="display:<?php echo $display; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
		<?php if($OMI_data[$i]->OMI_end_date < date('Y-m-d')){ $color_exp = 'red'; } ?>
		<?php
			if($OMI_data[$i]->OMI_end_date){
				$OMI_data[$i]->OMI_end_date = $OMI_data[$i]->OMI_end_date;
			}
			else{
				$OMI_data[$i]->OMI_end_date = '0000-00-00';
			}
		?>
           <?PHP $OMI_date2 = explode('-',$OMI_data[$i]->OMI_end_date); ?>
     <span style="color:<?php echo $color_exp; ?>"><?PHP echo $OMI_date2[1].'/'.$OMI_date2[2].'/'.$OMI_date2[0]; ?></span>
	  <?php $color_exp = ''; ?>
	  </div>
	  <div class="in-pan1">
		<label>Each Claim:</label>
	<span id="greencolormoney"><?PHP if($OMI_data) {echo number_format($OMI_data[$i]->OMI_each_claim,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Aggregate</label>
        <span id="greencolormoney"><?PHP if($OMI_data) {echo number_format($OMI_data[$i]->OMI_aggregate,2); } ?></span>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert. Holder?</label>
		  <?php if($OMI_data[$i]->OMI_cert == 'yes')  {
		  $omioccurs = 'Yes';
		  $omi_classfs = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $omioccurs = 'No';
		  $omi_classss = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; display:block; margin-left:170px; margin-top:-14px;" id="OMI_certhide<?PHP echo $i+1; ?>"><?php echo $omioccurs; ?></span>
        </div>
		</div>
      
	  
 </div>
<?php 
if($OMI_data[$i]->OMI_date_verified == '00-00-0000' && !$OMI_data[$i]->OMI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">
		<?php 
		if($userl->user_type == '11') echo "UNVERIFIED"; 
		else echo "<a href='javascript:void(0);' onclick='unverified(".$id.");'>UNVERIFIED</a>" ;
		?>
		
	</font></div></div>
	<?php } else { 
	if($OMI_data[$i]->OMI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OMI_data[$i]->OMI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>'; }
	else if($OMI_data[$i]->OMI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { 
		if( $userl->user_type == '11' ){
			echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OMI_data[$i]->OMI_date_verified.'</b></div></div>'; 
		}
		else{
			echo '<div class="verfirst"><div class="wse"><a href="javascript:void(0);" onclick="verified('.$id.');">VERIFIED</a><b>'.$OMI_data[$i]->OMI_date_verified.'</b></div></div>'; 
		}
	}
	} 
}	
?>
	  
   
	<div class="clear"></div>
  </div></div>

<?PHP } ?>


<div class="clear"></div>

<br />

  
<?php //discard_changes.gif ?>


<input type="hidden" name="task" value="" />

<input type="hidden" name="controller" value="vendors" />

<input type="hidden" name="submit_type" value="" />

</form>

<!--<div id="topborder_row" align="right"><a href="#"><img src="templates/camassistant_left/images/saveasdraft.gif" alt="save as draft" width="154" height="46" /><img src="templates/camassistant_left/images/review_submit.gif" alt="review &amp; submit" /></a></div> -->

</div>



<!-- eof line item pan -->







</div>



</div>

<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
  			  <tbody>
			
			<tr class="table_blue_rowdots_submitted" id="table_blue_rowdotsmarket">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="references" class="proposal_opener" href="javascript:void(0);" style="float:left;"></a>&nbsp;&nbsp;&nbsp;CUSTOMER REFERENCES
			</td>
			</tr>
</tbody></table>
<p style="height:10px;"></p>
<div id="companyrefsdocs">
</div>

<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
  			  <tbody>
			
			<tr class="table_blue_rowdots_submitted" id="table_blue_rowdotsmarket">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="market" class="proposal_opener" href="javascript:void(0);" style="float:left;"></a>&nbsp;&nbsp;&nbsp;MARKETING DOCUMENTS
			</td>
			</tr>
</tbody></table>

<p style="height:10px;"></p>

<div id="marketdocs">
</div>

<!-- eof right -->



<div class="clear"></div>

<!-- starting of vendor ratings-->
<br />
<div id="manager_ratings">
<div id="i_bar_terms_rfp" style="background:#a1a1a1; box-shadow:1px 2px 1px #a1a1a1; font-size:14px;">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR REVIEWS</font></span>
</div></div>
<?php
$reviews = $this->rfps ;
$reviews_order = $this->rfps_order ;
$list = 0;
for( $s=0; $s<count($reviews_order); $s++ ){	
		for( $r=0; $r<count($reviews); $r++ ){
			if( $reviews_order[$s] == $reviews[$r]->sort_date ){	
				if( $reviews[$r]->publish > '0' && $reviews[$r]->deleted == '0' ){
					$list++;
					?>
					<div class="firstapple">
					<span class="applesstore" id="apple<?php echo $reviews[$r]->publish; ?>">&nbsp;</span>
					<span id="click_result" style="padding-top:6px;">
					<?php 
					if($reviews[$r]->publish == '1')		
					echo "VERY UNSATISFIED";
					if($reviews[$r]->publish == '2')		
					echo "UNSATISFIED";
					if($reviews[$r]->publish == '3')		
					echo "NEUTRAL";
					if($reviews[$r]->publish == '4')		
					echo "SATISFIED";
					if($reviews[$r]->publish == '5')		
					echo "VERY SATISFIED";
					?>
					<?php
					$s_date = explode(' ',$reviews[$r]->c_date);
					?>
					</span>
					<?php if($reviews[$r]->comment) { ?>
					<br /><span class='managercoments'><?php echo nl2br($reviews[$r]->comment); ?></span><div class="clear"></div>
					<?php } ?>
					<br /><span class="submittedtext"><strong>Submitted by</strong>: <?php echo $reviews[$r]->name." ".substr($reviews[$r]->lastname,0,1).". - ".$reviews[$r]->city.", ".strtoupper($reviews[$r]->state)." on ".$s_date[0]."</span>"; ?>
					</div>
					<?php 
				}
			}
		}
	}
if($list == 0){
	echo '<p class="new_publicpage" align="center">No reviews have been submitted for this Vendor</p>';
}	
?>
<br /><br /><br /><br />
</div>
<?php //} ?>
<!-- eof vendor ratings -->

</div>

<!-- eof container -->
</div>
<br />





<!-- eof wrapper -->

<div id="boxesun" style="top:576px; left:582px;">
<div id="submitun" class="windowun" style="top:300px; left:582px; border:4px solid red; position:fixed">
<div float="right" style="float: right;position:absolute;top:-30px;right:-20px;position:absolute;top:-30px;right:-20px; cursor:pointer;" id="cancelun"><img src="media/system/images/closebox.png"></div>
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">UNVERIFIED</font></span>
</div></div>
<div style="text-align:justify"><p class="verifytext">Please be aware that due to this vendor choosing an unverified account, the information and document entered by this vendor has NOT been verified for accuracy by the MyVendorCenter compliance team.  This means there is a chance the vendor has uploaded an incorrect document, expired policy, or provided incorrect information (i.e. policy amounts, types of coverage).  We highly recommend you verify all information entered by this vendor manually, or click the button below to ask this vendor to change their account to obtain a verified status.</p>
</div>
<div style="padding-top:20px; text-align:center;">
<form name="unverifiedform" id="unverifiedform" method="post">
<div id="doneun" name="doneun" value="Ok" class="requestverified"></div>
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfpcenter" name="controller" />
<input type="hidden" value="sendactivationrequest" name="task" />
<input type="hidden" value="" id="vendorid" name="vendorid" />
<input type="hidden" value="info" id="from" name="from" />
</form>
</div>
</div>
  <div id="maskun"></div>
</div>


<div id="boxesve" style="top:576px; left:582px;">
<div id="submitve" class="windowve" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed">
<div float="right" style="float: right;position:absolute;top:-30px;right:-20px;position:absolute;top:-30px;right:-20px; cursor:pointer;" id="cancelve"><img src="media/system/images/closebox.png"></div>
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">VERIFIED</font></span>
</div></div>
<div style="text-align:justify"><p class="verifytext">The information and document entered by this vendor has been verified for accuracy by the MyVendorCenter compliance team on the provided date.  If the Vendor makes any changes to this document, or the related information, it will be verified again and the date will be updated.</p>
</div>
<div style="padding-top:20px; text-align:center;">
<div id="doneve" name="doneve" value="Ok" class="oknewsmall"></div>
</div>
</div>
  <div id="maskve"></div>
</div>

<div id="boxesvea" style="top:576px; left:582px;">
<div id="submitvea" class="windowvea" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed">
<div float="right" style="float: right;position:absolute;top:-30px;right:-20px;position:absolute;top:-30px;right:-20px; cursor:pointer;" id="cancelveA"><img src="media/system/images/closebox.png"></div>
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">PUBLIC PROFILE PAGE</font></span>
</div></div>
<div style="text-align:justify"><p class="public_profile_text">Your Public Profile Page is like your own, free website, accessed by your unique link. You can send this link to any of your clients so they have access to your compliance documents, references, contact information, and more. You can copy and then paste your link by simply clicking on the COPY button. You can email your link by clicking on the EMAIL button. Here are just a few examples of places you can post your link:</p>
<ul>
<li>Business Cards</li>
<li>Email Signatures</li>
<li>Marketing Materials</li>
<li>Company's Primary Website</li>
<li>Proposals</li>
</ul>
</div>
<div style="padding-top:20px; text-align:center;">
<div id="donevea" name="donevea" value="Ok" class="oknewsmall"></div>
</div>
</div>
  <div id="maskvea"></div>
</div>



<?php

exit; ?>