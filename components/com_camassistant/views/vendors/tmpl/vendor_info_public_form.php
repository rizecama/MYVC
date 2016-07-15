<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />

<?php
$pid = $_REQUEST['pid'];

$phoneid = str_replace('/','',$pid);
$cleaned = preg_replace('/[^[:digit:]]/', '', $phoneid);
preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
$fullnumber = $matches[1].'-'.$matches[2].'-'.$matches[3] ;
 
$db = JFactory::getDBO();
$user =& JFactory::getUser($user_id);
$userid = "SELECT user_id FROM #__cam_vendor_company  where company_phone='".$fullnumber."'";
$db->Setquery($userid);
$user_id = $db->loadResult();
//Completed
error_reporting(0) ;
defined('_JEXEC') or die('Restricted access');

$vendor_GLI_compliance_alert = $this->vendor_GLI_compliance_alert;

$states = $this->states;

$GLI_policy = $this->GLI_policy_configurations;

$liscense_categories = $this->liscense_categories;

$PLN_needed = $this->PLN_needed;

$W9_data = $this->W9_data;
 
$WCI_data = $this->WCI_data;
$UMB_data = $this->UMB_data;
$AIP_data = $this->AIP_data;
$WC_data = $this->WC_data;
$GLI_data = $this->GLI_data;

$OMI_data = $this->OMI_data;
$OLN_data = $this->OLN_data;

$PLN_data = $this->PLN_data;
$UMB_count = count($UMB_data);
$OLN_count = count($OLN_data);
$AIP_count = count($AIP_data);
$OMI_count = count($OMI_data);

if($OLN_count == 0)

$OLN_count = 1;

if($UMB_count == 0)
$UMB_count = 1;

$PLN_count = count($PLN_data);

$GLI_count = count($GLI_data);

$WCI_count = count($WCI_data);
if($AIP_count == 0)
$AIP_count = 1;
if($WCI_count == 0)

$WCI_count = 1;

$WC_count = count($WC_data);

if($WC_count == 0)
$WC_count = 1;

if($OMI_count == 0)
$OMI_count = 1;


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

var WCI_compliance = '<?PHP echo $WCI_count; ?>';
var AIP_compliance = '<?PHP echo $AIP_count; ?>';
var WC_compliance = '<?PHP echo $WC_count; ?>';
var OMI_compliance = '<?PHP echo $OMI_count; ?>';

var OLN_title='<?PHP echo $OLN_count; ?>';

var PLN_title='<?PHP echo $PLN_count; ?>';

var GLI_title='<?PHP echo $GLI_count; ?>';
var AIP_title='<?PHP echo $AIP_count; ?>';
var WCI_title='<?PHP echo $WCI_count; ?>';
var WC_title='<?PHP echo $WC_count; ?>';
var OMI_title='<?PHP echo $OMI_count; ?>';
<?php //$id = JRequest::getVar('id','');
$id = $user_id ;
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
				G.post("index.php?option=com_camassistant&controller=vendors&task=marketdocsprofile&id=<?php echo $user_id; ?>&from=public", function(data){
				
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
				G.post("index.php?option=com_camassistant&controller=vendors&task=crefsprofile&id=<?php echo $user_id; ?>&from=public", function(data){
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
	
	});

	
    </script>
	
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
	$thumb_width =231;
	$thumb_height = round($thumb_width * $aspect_ratio);
			
	?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" style="padding-bottom:10px; padding-top:20px;" />
	<div class="details" style="border:none">
	<!--For Account Type-->
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
	<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding:9px 0 0;">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">VENDOR DETAILS</font></span>
</div></div>
<div class="profile_content">
	<div>
	<strong style="text-align:left; display:block;"><?php echo $vendordata->company_name ; ?></strong>
	<?php echo $vendordata->company_address ; ?><br>
	<?php echo $vendordata->city. ', ' . strtoupper($vendordata->state) . ' ' . $vendordata->zipcode; ?><br>
	</div>
	<div><strong>Contact Name:</strong> <?php echo $vendordata->name . ' ' . $vendordata->lastname ; ?></a><br></div>
	<div>
	<strong>Company Phone:</strong> <?php echo $vendordata->company_phone ; ?><br>
	<strong>Alternate Phone:</strong> <?php echo $vendordata->alt_phone ; ?><br>
	<strong>Cell Phone:</strong> <?php echo $vendordata->cellphone ; ?></div>
	<div><strong>Email:</strong> <a href="mailto:<?php echo $vendordata->email ; ?>?support@camassistant.com"><?php echo $vendordata->email ; ?></a><br></div>
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
<p style="height: 100px;"></p>	
	</div>
				

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
<p style="padding-top:5px; margin-right:9px; padding-left:5px; color:gray"><?php echo nl2br($this->aboutus->aboutus); ?> 
</p></div>
<p style="border-bottom: 1px solid rgb(125, 125, 125); height: 2px;"></p>
<p style="height:10px;"></p>


<div id="i_bar_terms" style="margin:0 4px; font-size:14px;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR DOCUMENTS</font></span>
</div></div><br />
<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
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
		$user =& JFactory::getUser($user_id);
		$tax_id="SELECT tax_id FROM #__cam_vendor_company  where user_id='".$user->id."'";
		$db->Setquery($tax_id);
		$taxid = $db->loadResult(); 
		if($taxid==$W9_data->ein_number) {
		$W9_data->ein_number= $taxid;
		} else if(!$W9_data->ein_number){
		$W9_data->ein_number= $taxid;
		} else {
		$W9_data->ein_number= $W9_data->ein_number;
		} //$W9_data->ein_number ?>
        <label>EIN Number</label>
          <span class="greenvalues"><?php echo $W9_data->ein_number; ?></span>
		  </div>
      <?php if( $user->subscribe_type == 'free' ){ ?>
<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
<?php } else { 
	   if($W9_data->w9_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
	   else if($W9_data->w9_date_verified == '00-00-0000' && !$W9_data->w9_upld_cert) echo ""; 
	   else if($W9_data->w9_date_verified == '00-00-0000' && $W9_data->w9_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	   else echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$W9_data->w9_date_verified.'</b></div></div>';
	   
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
	<?php if($GLI_data[0]->GLI_end_date < date('Y-m-d') || !$GLI_data[0]->GLI_end_date || $GLI_data[0]->GLI_end_date == '00-00-0000')
	 { $color_exp = 'red'; } ?>
	 	
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
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_med,2); }?></span>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_policy_occurence,2); }?></span>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_injury,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <span class="greenvalues"><?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_policy_aggregate,2); } ?></span>
		 
		 <?php
		 	if($GLI_data[0]->GLI_applies == 'pol')
			$pol = "checked='checked'";
			elseif($GLI_data[0]->GLI_applies == 'proj')
			$proj = "checked='checked'";
			elseif($GLI_data[0]->GLI_applies == 'loc')
			$loc = "checked='checked'";
		 ?><p style="height:10px"></p>
		 <table cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;"><label>Applies To:&nbsp;</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" <?php echo $pol; ?> type="radio" name="GLI_applies0" value="pol" class="attrInputs1" id="attrInputs1" /></td><td><label>Pol</label></td>
		<td style="vertical-align:top;"><input disabled="disabled" <?php echo $proj; ?> type="radio" name="GLI_applies0" value="proj" class="attrInputs1" id="attrInputs1" /></td><td><label>Proj</label></td>
		 <td style="vertical-align:top;"><input disabled="disabled" <?php echo $loc; ?> type="radio" name="GLI_applies0" value="loc" class="attrInputs1" id="attrInputs1" /></td><td><label>Loc</label>
		 <?php if(!$GLI_data[0]->GLI_applies) { ?> <?php } ?>
		 </td></tr></table>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_products,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <span class="greenvalues"><?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_damage,2); } ?></span>
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
		 <p style="height:4px;"></p>
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
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
		   if($GLI_data[0]->GLI_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
		   else if( $GLI_data[0]->GLI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
		   else if($GLI_data[0]->GLI_date_verified == '00-00-0000' && $GLI_data[0]->GLI_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
		   else echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$GLI_data[0]->GLI_date_verified.'</b></div></div>';
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
		<?php if($GLI_data[$k]->GLI_end_date < date('Y-m-d') || $GLI_data[$k]->GLI_end_date == '00-00-0000') { $color_exp = 'red'; } ?>
		
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
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_med,2); }?></span>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_policy_occurence,2); }?></span>
		 <?php if(!$GLI_data[$k]->GLI_policy_occurence || $GLI_data[$k]->GLI_policy_occurence == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_injury,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	   <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <span class="greenvalues"><?PHP echo number_format($GLI_data[$k]->GLI_policy_aggregate,2); ?></span>
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
		 <td style="vertical-align:top;"><input disabled="disabled" type="radio"  <?php echo $loc; ?> name="GLI_applies<?php echo $k; ?>" value="loc" class="attrInputs" id="attrInputs<?php echo $k; ?>" /></td><td><label>&nbsp;Loc</label>
		 <?php if(!$GLI_data[$k]->GLI_applies) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
		 </td></tr></table>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <span class="greenvalues"><?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_products,2); }?></span>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <span class="greenvalues"><?PHP if($GLI_data) {echo number_format($GLI_data[$k]->GLI_damage,2); } ?></span>
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
         <table cellpadding="0" cellspacing="0"><tr height="8"></tr><tr><td><input type="checkbox" disabled="disabled" <?php echo $primary; ?> value="primary" name="GLI_primary<?php echo $k; ?>" id="GLI_primary<?PHP echo $k+1; ?>"  style="margin-left:0px;" /> </td><td><label style="padding:0px; margin:0px;">Primary Non-Contributory</label></td></tr>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="GLI_certhide<?PHP echo $k+1; ?>"><?php echo $glioccur; ?></span>
		 <p style="height:4px;"></p>
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
		   if($GLI_data[$k]->GLI_status == '-1') echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; 
		   else if( $GLI_data[$k]->GLI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
		   else if($GLI_data[$k]->GLI_date_verified == '00-00-0000' && $GLI_data[$k]->GLI_upld_cert ) echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
		   else echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$GLI_data[$k]->GLI_date_verified.'</b></div></div>';
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
		<?php if($AIP_data[0]->aip_end_date < date('Y-m-d') || $AIP_data[0]->aip_end_date == '00-00-0000'  ) { $color_exp = 'red'; } ?>
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
		 <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_bodily,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_combined,2); }?></span>
		<?php if(!$AIP_data[0]->aip_combined) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php } ?>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_body_injury,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_property,2); }?></span>
		</div>
		 <div class="in-pan1">
		 <?php
		 	if($AIP_data[0]->aip_primary == 'primary')
			$primary = "checked='checked'";
			if($AIP_data[0]->aip_waiver == 'waiver')
			$waiver = "checked='checked'";
		
			?>
		 <table cellpadding="0" cellspacing="0"><tr><tr height="20"></tr><td><input type="checkbox" disabled="disabled" <?php echo $primary; ?> value="primary" name="aip_primary0"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Primary Non-Contributory&nbsp;&nbsp;</label></td></tr>
		<tr><td><input type="checkbox" disabled="disabled" <?php echo $waiver; ?> value="waiver" name="aip_waiver0"  style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation&nbsp;&nbsp;</label></td></tr></table>
		 </div>
      </div>
	  <div class="comm" style="width:407px;">
	  <div class="in-pan" style="width:407px; margin-top:-8px;">
          <label style="padding-top:5px;">MyVC listed as Cert. Holder?</label>
		  <?php if($AIP_data[0]->aip_cert == 'yes')  {
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
        <span style="color:<?php echo  $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="aip_certhide1"><?php echo $aipoccur; ?></span>
		 <p style="height: 10px;"></p>
		 <label>Additional Insured:</label>
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
		 <?php if(!$add_company) 
		 echo '<p style="height:30px;"></p>';
		 else
		 echo '<p style="height:10px;"></p>';
		 ?>
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
        <p style="float:right">
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($AIP_data[0]->aip_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $AIP_data[0]->aip_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($AIP_data[0]->aip_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$AIP_data[0]->aip_date_verified.'</b></div></div>'; }
	} 
}	
 ?>
 	  
	  
    <div class="clear"></div>
  </div>


  <input type="hidden" value="<?PHP echo $AIP_data[0]->id; ?>" /><input type="hidden" name="aip_status[]" value="<?PHP echo $AIP_data[0]->aip_status; ?>" />
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
		<?php if($AIP_data[$mj]->aip_end_date < date('Y-m-d')) { $color_exp = 'red'; } ?>
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
		 <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_bodily,2); }?></span>
		 </div>
		 </div>
		 
		 <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_combined,2); }?></span>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_body_injury,2); }?></span>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <span class="greenvalues"><?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_property,2); }?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="aip_certhide<?PHP echo $mj+1; ?>"><?php echo $aipoccur; ?></span>
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
		 <?php if(!$add_company) 
		 echo '<p style="height:30px;"></p>';
		 else
		 echo '<p style="height:10px;"></p>';
		 ?>
		 
		 
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
        <p style="margin-top:-7px; float:right;">
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($AIP_data[$mj]->aip_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $AIP_data[$mj]->aip_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($AIP_data[$mj]->aip_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$AIP_data[$mj]->aip_date_verified.'</b></div></div>'; }
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
	<?php if($WCI_data[0]->WCI_end_date < date('Y-m-d')) { $color_exp = 'red'; } ?>	
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
	<?php $color_exp = ''; } else { echo "N/A"; } ?>
	
	</div>
	<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
	<span class="greenvalues"><?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_disease_policy,2); } ?></span>
	
	</div>
      </div>
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Each Accident:</label>
    <span class="greenvalues"><?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_each_accident,2); } ?></span>
    
	</div>
	<div class="in-pan1">
	<label>Disease - Each Employee:</label>
	<span class="greenvalues"><?PHP if($GLI_data) {echo number_format($WCI_data[0]->WCI_disease,2); } ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="WCI_certhide1"><?php echo $wcioccur; ?></span>
        </div>
        
        <div class="clear"></div>
      </div>
	  </div>
      
<?php 
if($WCI_data[0]->WCI_date_verified == '00-00-0000' && !$WCI_data[0]->WCI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($WCI_data[0]->WCI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WCI_data[0]->WCI_end_date != '0000-00-00' && $WCI_data[0]->WCI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WCI_data[0]->WCI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WCI_data[0]->WCI_date_verified.'</b></div></div>'; }
	} 
}	
 ?>
 	  
    
    <div class="clear"></div>
  </div>
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
    <span class="greenvalues"><?PHP if($WCI_data[$m]->WCI_disease_policy) {echo number_format($WCI_data[$m]->WCI_disease_policy,2); } else { echo '0.00'; }?></span>
	<p style="height:10px;"></p>
	<label>Disease - Each Employee:</label>
	<span class="greenvalues"><?PHP if($WCI_data[$m]->WCI_disease) {echo number_format($WCI_data[$m]->WCI_disease,2); } else { echo "0.00"; }  ?></span>
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
<table cellpadding="0" cellspacing="0"><tr><td><input type="checkbox" <?php echo $waiver_desd; ?> value="waiver" name="WCI_waiver<?PHP echo $m; ?>" style="margin-left:1px;" /></td><td> <label style="padding:0px; margin:0px;">&nbsp;Waiver of Subrogation</label></td></tr></table> 
		 <?php
		 $waiver_desd = '';
		 ?>
	</div>
      </div>
	  <div class="comm">
	  <div class="in-pan" style="margin-top:-65px;">
        <label>Each Accident:</label>
    <span class="greenvalues"><?PHP if($WCI_data[$m]->WCI_each_accident) {echo number_format($WCI_data[$m]->WCI_each_accident,2); } else { echo "0.00"; }   ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="WCI_certhide<?PHP echo $m+1; ?>"><?php echo $wcioccurp; ?></span>
        </div>
        <div class="clear"></div>
      </div>
      </div>
<?php 
if($WCI_data[$m]->WCI_date_verified == '00-00-0000' && !$WCI_data[$m]->WCI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($WCI_data[$m]->WCI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WCI_data[$m]->WCI_end_date != '0000-00-00' && $WCI_data[$m]->WCI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WCI_data[$m]->WCI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WCI_data[$m]->WCI_date_verified.'</b></div></div>'; }
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
<!-- Workers comp completed -->
<!-- table row end -->

<!-- table row start -->
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
                    } 
            $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP echo $UMB_date[1].'/'.$UMB_date[2].'/'.$UMB_date[0]; ?></span>
        <?php $color_exp = ''; ?>
		</div>
		<div class="in-pan1">
		<label>Aggregate:</label>
	<span class="greenvalues"><?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_aggregate,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
           <?PHP $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
        <span class="greenvalues"><?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_occur,2); } ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="UMB_certhide1"><?php echo $umboccur; ?></span>
        </div>
		</div>
		</div>
<?php 
if($UMB_data[0]->UMB_date_verified == '00-00-0000' && !$UMB_data[0]->UMB_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($UMB_data[0]->UMB_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $UMB_data[0]->UMB_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($UMB_data[0]->UMB_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$UMB_data[0]->UMB_date_verified.'</b></div></div>'; }
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
	<span class="greenvalues"><?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_aggregate,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
        <span class="greenvalues"><?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_occur,2); } ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-14px; display:block;" id="UMB_certhide<?PHP echo $i+1; ?>"><?php echo $umboccurs; ?></span>
        </div>
		</div>
      </div>
<?php 
if($UMB_data[$i]->UMB_date_verified == '00-00-0000' && !$UMB_data[$i]->UMB_upld_cert){
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($UMB_data[$i]->UMB_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $UMB_data[$i]->UMB_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($UMB_data[$i]->UMB_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$UMB_data[$i]->UMB_date_verified.'</b></div></div>'; }
	} 
}	
?>
	  
    
	<div class="clear"></div>
  </div></div>

<?PHP } ?>

   <!-- Completed -->
   
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($OLN_data[0]->OLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OLN_data[0]->OLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($OLN_data[0]->OLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OLN_data[0]->OLN_date_verified.'</b></div></div>'; }
	} 
}	
?>      
    
    <div class="clear"></div>
  </div>
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($OLN_data[$i]->OLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OLN_data[$i]->OLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($OLN_data[$i]->OLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OLN_data[$i]->OLN_date_verified.'</b></div></div>'; }
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
       
         <?php if($PLN_data[0]->PLN_upld_cert!=''){ ?>  <div class="in-pan"><label>Jurisdiction (state/country/city/association):</label>
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
           <input  readonly="readonly"size="25" value="<?php echo $PLN_data[0]->PLN_state; ?>"><?php if(!$PLN_data[0]->PLN_state) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php } ?>
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
        <input  readonly="readonly" size="15" value="<?php echo $PLN_data[0]->PLN_type; ?>" ><?php if(!$PLN_data[0]->PLN_type) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php } ?>
        </div><?php } ?>
        <div class="clear"></div>
      </div>
</div>
<?php 
if($PLN_data[0]->PLN_date_verified == '00-00-0000' && !$PLN_data[0]->PLN_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($PLN_data[0]->PLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $PLN_data[0]->PLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($PLN_data[0]->PLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$PLN_data[0]->PLN_date_verified.'</b></div></div>'; }
	} 
}	
?>
      
    
    
      <div class="clear"></div>
</div>
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
           <input name="PLN_state[]" readonly="readonly" id="PLN_state<?PHP echo $j+1; ?>" class="t_field" size="25" value="<?php echo $PLN_data[$j]->PLN_state; ?>"><?php if(!$PLN_data[$j]->PLN_state) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php } ?>
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
        <input name="PLN_type[]" id="PLN_type<?PHP echo $j+1; ?>" readonly="readonly" class="t_field" size="15" value="<?php echo $PLN_data[$j]->PLN_type; ?>"><?php if(!$PLN_data[$j]->PLN_type) { ?> <!--<span style="color:red; font-size: 20px;">*</span>--><?php } ?>
        </div><?php }	?>
        <div class="clear"></div>
      </div>
 </div>
<?php 
if($PLN_data[$j]->PLN_date_verified == '00-00-0000' && !$PLN_data[$j]->PLN_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($PLN_data[$j]->PLN_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $PLN_data[$j]->PLN_expdate < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($PLN_data[$j]->PLN_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$PLN_data[$j]->PLN_date_verified.'</b></div></div>'; }
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($WC_data[0]->wc_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WC_data[0]->wc_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WC_data[0]->wc_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WC_data[0]->wc_date_verified.'</b></div></div>'; }
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
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($WC_data[$mj]->wc_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $WC_data[$mj]->wc_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($WC_data[$mj]->wc_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$WC_data[$mj]->wc_date_verified.'</b></div></div>'; }
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

<!--<p style="padding-top: 20px;"></p> -->


<!-- table row start -->
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

<?php //echo '<pre>'; print_r($OMI_data); echo "</pre>";?>
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
                    $OMI_data[0]->OMI_end_date = '0000-00-00';                            
                    } 
            $OMI_date = explode('-',$OMI_data[0]->OMI_end_date); ?>
        <span style="color:<?php echo $color_exp; ?>"><?PHP echo $OMI_date[1].'/'.$OMI_date[2].'/'.$OMI_date[0]; ?></span>
        <?php $color_exp = ''; ?>
		</div>
		<div class="in-pan1">
		<label>Each Claim:</label>
	<span class="greenvalues"><?PHP if($OMI_data) {echo number_format($OMI_data[0]->OMI_each_claim,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Aggregate:</label>
           <?PHP $OMI_date = explode('-',$OMI_data[0]->OMI_end_date); ?>
        <span class="greenvalues"><?PHP if($OMI_data) {echo number_format($OMI_data[0]->OMI_aggregate,2); } ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-18px; display:block;" id="OMI_certhide1"><?php echo $omioccur; ?></span>
        </div>
		</div>
		</div>
<?php 
if($OMI_data[0]->OMI_date_verified == '00-00-0000' && !$OMI_data[0]->OMI_upld_cert) {
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($OMI_data[0]->OMI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OMI_data[0]->OMI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($OMI_data[0]->OMI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OMI_data[0]->OMI_date_verified.'</b></div></div>'; }
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
	<span class="greenvalues"><?PHP if($OMI_data) {echo number_format($OMI_data[$i]->OMI_each_claim,2); } ?></span>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Aggregate:</label>
        <span class="greenvalues"><?PHP if($OMI_data) {echo number_format($OMI_data[$i]->OMI_aggregate,2); } ?></span>
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
         <span style="color:<?php echo $color; ?>; margin-left:170px; margin-top:-18px; display:block;" id="OMI_certhide<?PHP echo $i+1; ?>"><?php echo $omioccurs; ?></span>
        </div>
		</div>
      </div>
<?php 
if($OMI_data[$i]->OMI_date_verified == '00-00-0000' && !$OMI_data[$i]->OMI_upld_cert){
echo '<div class="verf"><div class="wse"><font color="gray">NONE</font></div></div>';
}
else{
	if( $user->subscribe_type == 'free' ){ ?>
	<div class="verf"><div class="wse"><font color="red">UNVERIFIED</font></div></div>
	<?php } else { 
	if($OMI_data[$i]->OMI_status == '-1' ){ echo '<div class="verf"><div class="wse"><font color="red">REJECTED</font></div></div>'; } 
	else if( $OMI_data[$i]->OMI_end_date < date('Y-m-d') ){ echo '<div class="verf"><div class="wse"><font color="red">EXPIRED</font></div></div>';  }
	else if($OMI_data[$i]->OMI_date_verified == '00-00-0000') echo '<div class="verfirst"><div class="wse"><font color="gray"><b>VERIFICATION<br />PENDING</b></font></div></div>';
	else { echo '<div class="verfirst"><div class="wse">VERIFIED<b>'.$OMI_data[$i]->OMI_date_verified.'</b></div></div>'; }
	} 
}	
?>
	  
    
	<div class="clear"></div>
  </div></div>

<?PHP } ?>

   <!-- Completed -->


<div class="clear"></div>

<br />

  
<?php //discard_changes.gif ?>


<input type="hidden" name="task" value="" />

<input type="hidden" name="controller" value="vendors" />

<input type="hidden" name="submit_type" value="" />

</form>

<!--<div id="topborder_row" align="right"><a href="#"><img src="templates/camassistant_left/images/saveasdraft.gif" alt="save as draft" width="154" height="46" /><img src="templates/camassistant_left/images/review_submit.gif" alt="review &amp; submit" /></a></div> -->





</div>

<!-- eof right -->
<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
  			  <tbody>
			
			<tr class="table_blue_rowdots_submitted" id="table_blue_rowdotsmarket">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="references" class="proposal_opener" href="javascript:void(0);" style="float:left;"></a>&nbsp;&nbsp;&nbsp;CUSTOMER REFERENCES
			</td>
			</tr>
</tbody></table>
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

<div id="marketdocs">
</div>


<div class="clear"></div>
<br /><br />
<div id="i_bar_terms_rfp" style="background:#a1a1a1; box-shadow:1px 2px 1px #a1a1a1; font-size:14px;">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF;">VENDOR REVIEWS</font></span>
</div></div>
<p class="new_publicpage" align="center">To see any reviews for this Vendor
<a href="index.php?option=com_camassistant&controller=propertymanager&view=propertymanager&Itemid=57"><strong>CLICK HERE</strong></a> to create a free account</p>
</div>

<!-- eof container -->

</div>
<br />






<!-- eof wrapper -->


<?php

exit; ?>