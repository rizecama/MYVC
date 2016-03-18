<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>

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

$OLN_data = $this->OLN_data;

$PLN_data = $this->PLN_data;
$UMB_count = count($UMB_data);
$OLN_count = count($OLN_data);
$AIP_count = count($AIP_data);
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

var OLN_title='<?PHP echo $OLN_count; ?>';

var PLN_title='<?PHP echo $PLN_count; ?>';

var GLI_title='<?PHP echo $GLI_count; ?>';
var AIP_title='<?PHP echo $AIP_count; ?>';
var WCI_title='<?PHP echo $WCI_count; ?>';
var WC_title='<?PHP echo $WC_count; ?>';
<?php //$id = JRequest::getVar('id','');
$id = $user_id ;
 ?>
function closewindows(){
window.parent.document.getElementById( 'sbox-window' ).close(); 
}

</script>
<style type="text/css">

.lic-pan{ border-bottom:dotted 1px #c0c0c0; padding:8px 0px; width:650px;}
.lic-pan h2{ font-size:13px; font-family:Arial Black; color:#686868; margin:0px 0px 10px 0px; padding:8px 0 8px 40px; text-transform:uppercase; position:relative; float: left; width:468px;}
.lic-pan h2 img{ position:absolute; left:0px; top:6px;}
.lic-pan-left{ width:153px; float:left; padding-right:8px;}
.imag-display{ width:127px; height:135px; line-height:22px; background:#d5d4d4; border:1px solid #72aa00; text-align:center; padding:8px;}
.rmv{ padding:4px 0px 10px 0px;}
/* .rmv span {position: absolute; top:-2px; left: 150px;} */
.rmv img{ position:relative; left:-6px;}
/*.comm{ padding:5px 0px;}*/
.comm{ padding-left:0px; padding-right:0px; padding-bottom:5px; margin-top:-3px; }
.comm label{color:#636363; font-size:12px; font-weight:bold; display:block;}
.comm input{ border:1px solid #abadb3; padding:3px;}
.bak{ background:#f7f7f7; border:1px solid #d7d7d7 !important;}
.lic-pan-right{ float:left; width:482px;}
.in-pan{ float:left; width:280px; padding-bottom:5px;}
/*.in-pan1{ float:left; width:200px;}*/
.in-pan1{ float:left; width:200px; padding-bottom:5px;}
.sve{ float:right; width:288px; padding-top:15px;}
.clear{ clear:both;}
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
				LH('#marketdocs').html(data).slideDown('slow');
				}
				});
			}
			else{	
			LH('.proposal_opener').removeClass('active');
	        LH('.table_blue_rowdots_submitted').removeClass('active'); 	
			LH(this).addClass('active');
            LH(this).parent().parent().addClass('active'); 	
			LH('#marketdocs').html('').slideUp('slow');
			LH('#table_pannel').slideDown('slow');
			}
		}else{	    
		   LH('.proposal_opener').removeClass('active');
           LH('.table_blue_rowdots_submitted').removeClass('active'); 
		   LH('#marketdocs').slideUp('slow');
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
        	<h1><?php echo $vendordata->company_name ; ?></h1>
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
	<h3>Vendor details</h3>
	<div>
	<strong><?php echo $vendordata->company_name ; ?></strong><br>
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
	<div class="rating" style="border:none;">
	<h3>vendor rating</h3>
	<p class="vendorating" style="margin-top:16px;"><img src="components/com_camassistant/assets/images/rating/vendorrating/<?php echo $vendordata->rating; ?>"><br><br><?php echo $vendordata->reviews; ?> Out of 5 
</p>
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
<p style="color:gray; font-size:15px;" align="center">ABOUT US...</p>
<p style="height:6px;"></p>
<div class="detailsextra">
<p style="padding-top:5px; margin-right:9px; padding-left:5px; color:gray"><?php echo nl2br($this->aboutus->aboutus); ?> 
</p></div>
<p style="height:40px;"></p>
<p style="border-bottom: 1px solid rgb(125, 125, 125); height: 2px;"></p>
<p style="height:10px;"></p>


<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
  			  <tbody><tr class="table_blue_rowdots_submitted" id="table_blue_rowdots">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="compliance" class="proposal_opener" href="#" style="float:left;"></a>&nbsp;&nbsp;&nbsp;COMPLIANCE DOCUMENTS
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
<p style="padding-top:5px; margin-right:9px; padding-left:5px; color:gray">Below is a list of this Vendor's Compliance Documents. This information has been entered directly by the Vendor and can be reviewed for accuracy by clicking on the DOCUMENT ICONS to Download/View a copy. A GREEN "CHECKMARK" means that the Vendor has entered in all of the required information. A RED "X" means the Vendor did NOT enter in any of the information required, and probably does not posses that particular compliance document..</p><br/>

<p style=" padding-top:5px; border-bottom: 1px dotted #C0C0C0;"></p>
  </div>
<form name="ComplianceFrm" method="post" enctype="multipart/form-data" style="margin-left:17px;"/>

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
    <h2><?php if(!$W9_data->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if(!$W9_data->w9_upld_cert || $W9_data->w9_status == '-1' ) { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else { ?>
       <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php } ?>W9</h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
       <?php if($W9_data->w9_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $W9_data->w9_upld_cert)); ?>
      <div class="imag-display"  id="imagdisplayW91"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=W9&filename=<?PHP echo $W9_data->w9_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display"  id="imagdisplayW91"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
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
          <input type="text" size="20" name="ein_number" id="ein_number" readonly="readonly" value="<?php echo $W9_data->ein_number; ?>"/></div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
         <input name="W9_date_verified" type="text" size="20" readonly="readonly" value="<?PHP if($W9_data->w9_status == '-1') echo 'Rejected'; else echo $W9_data->w9_date_verified; ?>"/>
   <input type="hidden" name="w9_status" value="<?PHP echo $W9_data->w9_status; ?>" />
   <input type="hidden" name="W9_id" id="W9_id" value="<?PHP echo $W9_data->id; ?>" />
      </div>
    </div>
    <div class="clear"></div>
</div>

</div>

<!-- W9 Completed-->

<!-- General liability docs starts -->
<div id="line_task_GLI1">
<div class="lic-pan">
<?php //echo '<pre>'; print_r($GLI_data[0]); ?>
    <h2><?php if(!$GLI_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($GLI_data[0]->GLI_end_date < date('Y-m-d') || !$GLI_data[0]->GLI_upld_cert || !$GLI_data[0]->GLI_policy_occurence || !$GLI_data[0]->GLI_policy_aggregate || $GLI_data[0]->GLI_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?>GENERAL LIABILITY POLICY - 1</h2>
    <div class="clear"></div>
    <?php //$main = $GLI_data[0]->GLI_date_verified;
    $GLI_date_verified = strtotime($GLI_data[0]->GLI_date_verified);
    if($GLI_data[0]->GLI_date_verified=='0000-00-00' || !$GLI_data[0]->GLI_date_verified){
	$GLI_data[0]->GLI_date_verified = '00-00-0000';
	} else {
	$GLI_data[0]->GLI_date_verified = date('m-d-Y', $GLI_date_verified);
	}
	
//echo "<pre>"; print_r($GLI_data);
	/*if($main != '0000-00-00'){

	$date4 = strtotime($main);

	$date4 = date('m-d-Y', $date4);

	} else{

	$date4 = '00-00-0000';

	}
*/
	//echo $date;

   ?>

    <div class="lic-pan-left">
      <?php if($GLI_data[0]->GLI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $GLI_data[0]->GLI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayGLI1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=GLI_<?PHP echo $GLI_data[0]->GLI_folder_id; ?>&filename=<?PHP echo $GLI_data[0]->GLI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayGLI1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>

      <input type="hidden" class="file_input_textbox" name="GLI_upld_cert[]" id="GLI_upld_cert1"  value="<?PHP echo $GLI_data[0]->GLI_upld_cert; ?>" />
      </div>
    <div class="lic-pan-right" id="GLI1">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
     <?PHP $GLI_end_date = explode('-',$GLI_data[0]->GLI_end_date);  ?>
    <input readonly="" name="GLI_end_date[]" id="GLI_end_date1" type="text" class="t_field" size="10" value="<?PHP if($GLI_data) { echo $GLI_end_date[1].'-'.$GLI_end_date[2].'-'.$GLI_end_date[0]; } ?>" />
	<?php 
	if($GLI_data[0]->GLI_end_date < date('Y-m-d') || !$GLI_data[0]->GLI_end_date || $GLI_data[0]->GLI_end_date == '00-00-0000')
	 { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
	 
	
	 </div>
	 <div class="in-pan1">
          <label>Med. Expenses:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_med[]" id="GLI_med1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_med,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_policy_occurence[]" id="GLI_policy_occurence1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_policy_occurence,2); }?>" onClick="if(this.value == '0.00') this.value='';"/><?php if(!$GLI_data[0]->GLI_policy_occurence || $GLI_data[0]->GLI_policy_occurence == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_injury[]" id="GLI_injury1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_injury,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_policy_aggregate[]" id="GLI_policy_aggregate1" size="20"  style="color: green; text-align: left;" value="<?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_policy_aggregate,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/><?php if(!$GLI_data[0]->GLI_policy_aggregate || $GLI_data[0]->GLI_policy_aggregate == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
		 
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
		 <?php if(!$GLI_data[0]->GLI_applies) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
		 </td></tr></table>
        </div>
        <div class="in-pan1">
          <label>Products - COMP/OP Agg:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_products[]" id="GLI_products1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[0]->GLI_products,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_damage[]" id="GLI_damage1" size="20"  style="color: green; text-align: left;" value="<?PHP if($GLI_data) {echo number_format($GLI_data[0]->GLI_damage,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
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
          <label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		  <?php if($GLI_data[0]->GLI_certholder == 'yes')  {
		  $glioccur = 'YES';
		  $gli_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $glioccur = 'NO';
		  $gli_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="GLI_certhide1"><?php echo $glioccur; ?></span>
		 <p style="height:4px;"></p>
		 <label>Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$GLI_data[0]->GLI_additional." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <span class="companyadditional" id="GLI_addhide1"><?php echo $add_company; ?></span>
        </div>
        
        <div class="clear"></div>
      </div>
	  
      <div class="comm">
	   <div class="in-pan">
        <label style="padding-top:15px;">Last Verified By MyVendorCenter On:</label>
       <input name="GLI_date_verified[]" id="GLI_date_verified1" type="text" readonly="readonly" size="10" value="<?PHP if($GLI_data[0]->GLI_status == '-1') echo 'Rejected';  else echo $GLI_data[0]->GLI_date_verified;  ?>"/>
      </div>
	  <div class="comm" style="display:none;">
	  <div class="in-pan">
          <label style="color:red;">Last Saved:</label>
         <input readonly="" value="<?php echo $GLI_data[0]->saveddate ; ?> " style="color:red;" />
        </div>
		</div>
		</div>
    </div>
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
    <h2><?php if($GLI_data[$k]->GLI_end_date < date('Y-m-d') || !$GLI_data[$k]->GLI_upld_cert || !$GLI_data[$k]->GLI_policy_occurence || !$GLI_data[$k]->GLI_policy_aggregate || $GLI_data[$k]->GLI_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?>GENERAL LIABILITY POLICY - <?PHP echo $k+1; ?></h2>
    <div class="clear"></div>
    <?php //$main = $GLI_data[$k]->GLI_date_verified;
    $GLI_date_verified1 = strtotime($GLI_data[$k]->GLI_date_verified);
    if($GLI_data[$k]->GLI_date_verified=='0000-00-00' || !$GLI_data[$k]->GLI_date_verified){
	$GLI_data[$k]->GLI_date_verified = '00-00-0000';
	} else {
	$GLI_data[$k]->GLI_date_verified = date('m-d-Y', $GLI_date_verified1);
	}
	
//echo "<pre>"; print_r($GLI_data);
	/* if($main != '0000-00-00'){

	$date4 = strtotime($main);

	$date4 = date('m-d-Y', $date4);

	} else{

	$date4 = 'PENDING';

	}
*/
	//echo $date;

   ?>

    <div class="lic-pan-left">
      <?php if($GLI_data[$k]->GLI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $GLI_data[$k]->GLI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayGLI<?PHP echo $k+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=GLI_<?PHP echo $GLI_data[$k]->GLI_folder_id; ?>&filename=<?PHP echo $GLI_data[$k]->GLI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayGLI<?PHP echo $k+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="GLI_upld_cert[]" id="GLI_upld_cert<?PHP echo $k+1; ?>"  value="<?PHP echo $GLI_data[$k]->GLI_upld_cert; ?>" /><br/>
 </div>
    <div class="lic-pan-right"  id="GLI<?PHP echo $k+1; ?>">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
 <?PHP $GLI_end_date2 = explode('-',$GLI_data[$k]->GLI_end_date);  ?>
  <input readonly="readonly" name="GLI_end_date[]" id="GLI_end_date<?PHP echo $k+1; ?>" type="text" class="t_field" size="10" value="<?PHP echo $GLI_end_date2[1].'-'.$GLI_end_date2[2].'-'.$GLI_end_date2[0]; ?>" /><?php if($GLI_data[$k]->GLI_end_date < date('Y-m-d') || $GLI_data[$k]->GLI_end_date == '00-00-0000') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
  </div>
  <div class="in-pan1">
          <label>Med. Expenses:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_med[]" id="GLI_med<?PHP echo $k+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_med,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan">
          <label>Each Occurrence:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_policy_occurence[]" id="GLI_policy_occurence<?PHP echo $k+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_policy_occurence,2); }?>" onClick="if(this.value == '0.00') this.value='';"/><?php if(!$GLI_data[$k]->GLI_policy_occurence || $GLI_data[$k]->GLI_policy_occurence == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="in-pan1">
          <label>Personal & Adv Injury:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_injury[]" id="GLI_injury<?PHP echo $k+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_injury,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  
	   <div class="comm">
        <div class="in-pan">
          <label>General Aggregate:</label>
         <input type="text" readonly="readonly" name="GLI_policy_aggregate[]" id="GLI_policy_aggregate<?PHP echo $k+1; ?>" class="t_field" size="20" style="color: green; text-align: left;" value="<?PHP echo number_format($GLI_data[$k]->GLI_policy_aggregate,2); ?>" onClick="if(this.value == '0.00') this.value='';"/><?php if(!$GLI_data[$k]->GLI_policy_aggregate || $GLI_data[$k]->GLI_policy_aggregate == '0.00') { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
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
         <input type="text" readonly="readonly" class="t_field" name="GLI_products[]" id="GLI_products<?PHP echo $k+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($GLI_data) { echo number_format($GLI_data[$k]->GLI_products,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
        </div>
        <div class="clear"></div>
      </div>
	  
	  
      <div class="comm">
        <div class="in-pan">
          <label>Damage to Rented Premises:</label>
         <input type="text" readonly="readonly" class="t_field" name="GLI_damage[]" id="GLI_damage<?PHP echo $k+1; ?>" size="20"  style="color: green; text-align: left;" value="<?PHP if($GLI_data) {echo number_format($GLI_data[$k]->GLI_damage,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
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
		<label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		
		 <?php if($GLI_data[$k]->GLI_certholder == 'yes') {
		  $glioccur = 'YES';
		  $gli_chekcedf = "checked='checked'";
		  $color = '#8FD800';
		  }
		  else {
		  $glioccur = 'NO';
		  $gli_chekceds = "checked='checked'";
		  $color = 'red';
		  }
		  ?>
		  
          <p id="GLI_cert<?PHP echo $k+1; ?>" style="display:none;"><input type="radio" <?php echo $gli_chekcedf; ?> value="yes" name="GLI_certholder<?php echo $k; ?>"  style="margin-left:0px;" />&nbsp;YES &nbsp;<input type="radio" <?php echo $gli_chekceds; ?> value="no" name="GLI_certholder<?php echo $k; ?>"  style="margin-left:0px;" />&nbsp;No</p>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="GLI_certhide<?PHP echo $k+1; ?>"><?php echo $glioccur; ?></span>
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
		 <span class="companyadditional" id="GLI_addhide<?PHP echo $k+1; ?>"><?php echo $add_company; ?></span>
		 
        </div>
        <div class="clear"></div>
      </div>
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:15px;">Last Verified By MyVendorCenter On:</label>
     <input name="GLI_date_verified[]" id="GLI_date_verified1" type="text" size="20" readonly="readonly" value="<?PHP if($GLI_data[$k]->GLI_status == '-1') echo 'Rejected'; else echo $GLI_data[$k]->GLI_date_verified;  ?>"/>
	 </div>
	 <div class="comm" style="display:none;">
	 <div class="in-pan">
          <label style="color:red;">Last Saved:</label>
         <input style="color:red;" readonly="" value="<?php echo $GLI_data[$k]->saveddate ; ?> " />
		 </div>
        </div>
      </div>
    </div>
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
    ?>

<div class="lic-pan">
    <h2><?php if(!$AIP_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($AIP_data[0]->aip_end_date < date('Y-m-d') || $AIP_data[0]->aip_upld_cert=='' || $AIP_data[0]->aip_status == '-1' ) { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> COMMERCIAL VEHICLE POLICY - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
       <?php if($AIP_data[0]->aip_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $AIP_data[0]->aip_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayaip1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=aip_<?PHP echo $AIP_data[0]->aip_folder_id; ?>&filename=<?PHP echo $AIP_data[0]->aip_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayaip1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert1"  value="<?PHP echo $AIP_data[0]->aip_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right" id="aip1">
      <div class="comm">
	   <div class="in-pan">
        <label>Exp. Date:</label>
            <?PHP $aip_date = explode('-',$AIP_data[0]->aip_end_date); ?>
        <input type="text" readonly="readonly" size="10" name="aip_end_date[]" id="aip_end_date1" value="<?PHP if($AIP_data[0]->aip_end_date){ echo $aip_date[1].'-'.$aip_date[2].'-'.$aip_date[0]; }  ?>" />
		<?php if($AIP_data[0]->aip_end_date < date('Y-m-d') || $AIP_data[0]->aip_end_date == '00-00-0000'  ) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
		
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Person:</label>
		 <input type="text" readonly="readonly" class="t_field" name="aip_bodily[]" id="aip_bodily1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_bodily,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <input type="text" readonly="readonly" class="t_field" name="aip_combined[]" id="aip_combined1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_combined,2); }?>" onClick="if(this.value == '0.00') this.value='';"/><?php if(!$AIP_data[0]->aip_combined) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <input type="text" readonly="readonly" class="t_field" name="aip_body_injury[]" id="aip_body_injury1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_body_injury,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <input type="text" readonly="readonly" class="t_field" name="aip_property[]" id="aip_property1" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[0]->aip_property,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
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
	  <div class="comm" style="width:386px;">
	  <div class="in-pan" style="width:386px; margin-top:-8px;">
          <label style="padding-top:5px;">MyVC listed as Cert Holder?</label>
		  <?php if($AIP_data[0]->aip_cert == 'yes')  {
		  $aipoccur = 'YES';
		  $aip_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $aipoccur = 'NO';
		  $aip_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
        <span style="color:<?php echo  $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="aip_certhide1"><?php echo $aipoccur; ?></span>
		 <p style="height: 10px;"></p>
		 <label>Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$AIP_data[0]->aip_addition." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <span class="companyadditional" id="aip_addhide1"><?php echo $add_company; ?></span>
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
        <p style="float:right">
		<table cellpadding="0" cellspacing="0"><tr><td><label style="padding:0px; margin:0px;">Applies to:&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="any" <?php echo $aip_any; ?>  name="aip_applies_any0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Any&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="owned" <?php echo $aip_owned; ?> name="aip_applies_owned0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="nonowned" <?php echo $aip_nonowned; ?> name="aip_applies_nonowned0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">No-Owned&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="hired" <?php echo $aip_hired; ?> name="aip_applies_hired0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Hired&nbsp;&nbsp;</label></td>
		<td><input type="checkbox" disabled="disabled" value="sch" <?php echo $aip_sch; ?> name="aip_applies_scheduled0" style="margin-left:0px;" /></td><td><label style="padding:0px; margin:0px;">Scheduled&nbsp;&nbsp;</label></td></tr></table></p>
        </div>
		</div>
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Last Verified By MyVendorCenter On:</label>
        <input class="bak" size="10" name="aip_date_verified[]" id="aip_date_verified"  readonly="readonly"  type="text" value="<?PHP if($AIP_data[0]->aip_status == '-1' ){ echo 'Rejected'; } else { echo $AIP_data[0]->aip_date_verified; } ?>"/>
		</div>
      </div>
	  <div class="comm" style="display:none;">
	   <div class="in-pan">
        <label style="color:red;">Last Saved:</label>
        <input value="<?PHP echo $AIP_data[0]->saveddate ; ?>" readonly="" style="color:red;"/>
		</div>
      </div>
	  <div class="clr"></div>
    </div>
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
    
   ?>
        <h2><?php if($AIP_data[$mj]->aip_end_date < date('Y-m-d') || $AIP_data[$mj]->aip_upld_cert=='' || $AIP_data[$mj]->aip_status == '-1') { ?>
            <img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />

        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> COMMERCIAL VEHICLE POLICY - <?PHP echo $mj+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
       <?php if($AIP_data[$mj]->aip_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $AIP_data[$mj]->aip_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayaip<?PHP echo $mj+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=aip_<?PHP echo $AIP_data[$mj]->aip_folder_id; ?>&filename=<?PHP echo $AIP_data[$mj]->aip_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayaip<?PHP echo $mj+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
       <input type="hidden" class="file_input_textbox" name="aip_upld_cert[]" id="aip_upld_cert<?PHP echo $mj+1; ?>"  value="<?PHP echo $AIP_data[$mj]->aip_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right" id="aip<?PHP echo $mj+1; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
    <?PHP $aip_date1 = explode('-',$AIP_data[$mj]->aip_end_date); ?>
        <input type="text" readonly="readonly" size="10" name="aip_end_date[]" id="aip_end_date<?PHP echo $mj+1; ?>" value="<?PHP echo $aip_date1[1].'-'.$aip_date1[2].'-'.$aip_date1[0]; ?>" />
		<?php if($AIP_data[$mj]->aip_end_date < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
      </div>
	  <div class="in-pan1">
		 <label>Bodily Injury - Per Person:</label>
		 <input type="text" readonly="readonly" class="t_field" name="aip_bodily[]" id="aip_bodily<?PHP echo $mj+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_bodily,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
		 </div>
		 
		 <div class="comm">
	   <div class="in-pan">
        <label>Combined Single Limit:</label>
        <input type="text" readonly="readonly" class="t_field" name="aip_combined[]" id="aip_combined<?PHP echo $mj+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_combined,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
		 <div class="in-pan1">
		 <label>Bodily Injury - Per Accident:</label>
		 <input type="text" readonly="readonly" class="t_field" name="aip_body_injury[]" id="aip_body_injury<?PHP echo $mj+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_body_injury,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
		 </div>
      </div>
	  
	  
	  <div class="comm">
	   <div class="in-pan">
        <label>Property Damage - Per Accident:</label>
        <input type="text" readonly="readonly" class="t_field" name="aip_property[]" id="aip_property<?PHP echo $mj+1; ?>" size="16"  style="color:green; text-align: left;" value="<?PHP  if($AIP_data) { echo number_format($AIP_data[$mj]->aip_property,2); }?>" onClick="if(this.value == '0.00') this.value='';"/>
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
	   <div class="comm" style="width:386px;">
	  <div class="in-pan" style="width:386px; margin-top:-8px;">
          <label style="padding-top:8px;">MyVC listed as Cert Holder?</label>
		  <?php if($AIP_data[$mj]->aip_cert == 'yes')  {
		  $aipoccur = 'YES';
		  $aip_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $aipoccur = 'NO';
		  $aip_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="aip_certhide<?PHP echo $mj+1; ?>"><?php echo $aipoccur; ?></span>
		 <p style="height:10px;"></p>
		 <label>Additional Insured:</label>
		 <?php 
		 $db =& JFactory::getDBO();
		 $cname = "SELECT comp_name  FROM #__cam_customer_companyinfo where cust_id=".$AIP_data[$mj]->aip_addition." ";
		 $db->Setquery($cname);
		 $add_company = $db->loadResult();
		 ?>
		 <span class="companyadditional" id="aip_addhide<?PHP echo $mj+1; ?>"><?php echo $add_company; ?></span>
		 <p style="height:30px;"></p>
		 
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
      <div class="comm">
	   <div class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
   <input class="bak" size="10" name="aip_date_verified[]" id="aip_date_verified"  readonly="readonly"  type="text" value="<?PHP if($AIP_data[$mj]->aip_status == '-1' ){ echo 'Rejected'; } else { echo $AIP_data[$mj]->aip_date_verified; }?>"/>
      </div>
	  </div>
	  <div class="comm" style="display:none;">
	  <div class="in-pan">
        <label style="color:red;">Last Saved:</label>
        <input style="color:red;" value="<?PHP echo $AIP_data[$mj]->saveddate ; ?>" readonly=""/>
		</div>
      </div>
    </div>
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
	
//echo '<pre>'; print_r($WC_data[0]);
  /* if($main != '0000-00-00'){

	$date = strtotime($main);

	$date = date('m-d-Y', $date);

	}
	else{
	$date = 'PENDING';
	}
*/
	//if($WCI_data[0]->WCI_policy != '' || $WCI_data[0]->WCI_upld_cert != '')
	 //{
	 /* if((isset($WCI_data[0]->WCI_end_date) && $WCI_data[0]->WCI_end_date != '0000-00-00' && $WCI_data[0]->WCI_end_date < date('Y-m-d')) )
	 { $dv = 'Expired'; } // $disable = "disabled='disabled'"; }
	  elseif($WCI_data[0]->WCI_status == '-1')
	 { $dv = 'Rejected'; }// $disable = "disabled='disabled'"; }
	  elseif($WCI_data[0]->WCI_status == '1')
	  { $dv = $date;  $disable = "disabled='disabled'"; }
	   else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }*/
	  //}
	 // else
	 // {
	//  $dv = '';
	// $disable = '';
	 // }

//echo $dv;
   ?>
<?php //echo '<pre>'; print_r($WC_data[0]); ?>
<div class="lic-pan">
    <h2><?php if(!$WCI_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($WCI_data[0]->WCI_end_date < date('Y-m-d') || $WCI_data[0]->WCI_upld_cert=='' || $WCI_data[0]->WCI_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> WORKERS COMPENSATION POLICY - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
    <?php if($WCI_data[0]->WCI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WCI_data[0]->WCI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayWCI1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WCI_<?PHP echo $WCI_data[0]->WCI_folder_id; ?>&filename=<?PHP echo $WCI_data[0]->WCI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayWCI1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>

     <input type="hidden" class="file_input_textbox" name="WCI_upld_cert1" id="WCI_upld_cert1"  value="<?PHP echo $WCI_data[0]->WCI_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right" id="WCI1">
	<div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
          <?PHP $WCI_end_date = explode('-',$WCI_data[0]->WCI_end_date);  ?>
    <input name="WCI_end_date[]" readonly="readonly" id="WCI_end_date1" type="text" class="t_field" size="20" value="<?PHP echo $WCI_end_date[1].'-'.$WCI_end_date[2].'-'.$WCI_end_date[0]; ?>" />
	<?php if($WCI_data[0]->WCI_end_date < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
	</div>
	<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
	<input type="text" readonly="readonly" class="t_field" name="WCI_disease_policy[]" id="WCI_disease_policy1" size="20"  style="color: green; text-align: left;" value="<?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_disease_policy,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
	
	</div>
      </div>
	  
      <div class="comm">
	  <div class="in-pan">
        <label>Each Accident:</label>
    <input type="text" readonly="readonly" class="t_field" name="WCI_each_accident[]" id="WCI_each_accident1" style="color: green; text-align: left;" value="<?PHP if($WCI_data) {echo number_format($WCI_data[0]->WCI_each_accident,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
    
	</div>
	<div class="in-pan1">
	<label>Disease - Each Employee:</label>
	<input type="text" readonly="readonly" class="t_field" name="WCI_disease[]" id="WCI_disease1" style="color: green; text-align: left;" value="<?PHP if($GLI_data) {echo number_format($WCI_data[0]->WCI_disease,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
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
          <label>MyVC listed as Cert Holder?</label>
		  <?php if($WCI_data[0]->WCI_cert == 'yes')  {
		  $wcioccur = 'YES';
		  $wci_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $wcioccur = 'NO';
		  $wci_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="WCI_certhide1"><?php echo $wcioccur; ?></span>
        </div>
        
        <div class="clear"></div>
      </div>
	  
      <div class="comm">
	  <div style="margin-top: -18px;" class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
     <input name="WCI_date_verified[]" id="WCI_date_verified1" type="text" readonly="readonly" size="10" value="<?PHP if($WCI_data[0]->WCI_status == '-1'){ echo 'Rejected'; } else { echo $WCI_data[0]->WCI_date_verified; }  ?>"/>
	 </div>
      </div>
	  <div class="comm" style="display:none;">
        <label style="color:red;">Last Saved:</label>
     <input style="color:red;" readonly="" value="<?PHP echo $WCI_data[0]->saveddate;  ?>"/>
      </div>
    </div>
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
	
   //echo $main;

   /*	if($main != '0000-00-00'){

	$date9 = strtotime($main);

	$date9 = date('m-d-Y', $date9);

	}

	else {

	$date9 = 'PENDING';

	}

*/

	/* if((isset($WCI_data[$m]->WCI_end_date) && $WCI_data[$m]->WCI_end_date != '0000-00-00' && $WCI_data[$m]->WCI_end_date < date('Y-m-d')) )
	 { $dv = 'Expired'; } // $disable = "disabled='disabled'"; }
	  elseif($WCI_data[$m]->WCI_status == '-1')
	 { $dv = 'Rejected'; } //  $disable = "disabled='disabled'"; }
	  elseif($WCI_data[$m]->WCI_status == '1')
	 { $dv = $date9;   $disable = "disabled='disabled'"; }
	  else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
*/

?>

   <h2><?php if($WCI_data[$m]->WCI_end_date < date('Y-m-d') || $WCI_data[$m]->WCI_upld_cert=='' || $WCI_data[$m]->WCI_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> WORKERS COMPENSATION POLICY - <?PHP echo $m+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
     <?php if($WCI_data[$m]->WCI_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WCI_data[$m]->WCI_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayWCI<?PHP echo $m+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WCI_<?PHP echo $WCI_data[$m]->WCI_folder_id; ?>&filename=<?PHP echo $WCI_data[$m]->WCI_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayWCI<?PHP echo $m+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      <input type="hidden" class="file_input_textbox" name="WCI_upld_cert[]" id="WCI_upld_cert<?PHP echo $m+1; ?>"  value="<?PHP echo $WCI_data[$m]->WCI_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right" id="WCI<?PHP echo $m+1; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
         <?PHP $WCI_end_date2 = explode('-',$WCI_data[$m]->WCI_end_date);  ?>
    <input name="WCI_end_date[]" readonly="readonly" id="WCI_end_date<?PHP echo $m+1; ?>" type="text" class="t_field" size="20" value="<?PHP echo $WCI_end_date2[1].'-'.$WCI_end_date2[2].'-'.$WCI_end_date2[0]; ?>"  />
	<?php if($WCI_data[$m]->WCI_end_date < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
	</div>
	<div class="in-pan1">
	<label>Disease - Policy Limit:</label>
    <input type="text" readonly="readonly" class="t_field" name="WCI_disease_policy[]" id="WCI_disease_policy<?PHP echo $m+1; ?>" size="20"  style="color: green; text-align: left;" value="<?PHP if($WCI_data) {echo number_format($WCI_data[$m]->WCI_disease_policy,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
	<p style="height:10px;"></p>
	<label>Disease - Each Employee:</label>
	<input type="text" readonly="readonly" class="t_field" name="WCI_disease[]" id="WCI_disease<?PHP echo $m+1; ?>" size="20"  style="color: green; text-align: left;" value="<?PHP if($GLI_data) {echo number_format($WCI_data[$m]->WCI_disease,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
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
	  <div class="in-pan" style="margin-top:-74px;">
        <label>Each Accident:</label>
    <input type="text" class="t_field" name="WCI_each_accident[]" id="WCI_each_accident<?PHP echo $m+1; ?>" onKeyup="if(isNaN(parseInt(this.value)) && this.value!='' && event.keycode!='13' && event.keycode!='9') { alert('Please enter valid number'); this.value=''; }" onChange="javascript: add_commas('WCI_each_accident',this.value,<?PHP echo $m+1; ?>);" size="20"  style="color: green; text-align: left;" value="<?PHP if($WCI_data) {echo number_format($WCI_data[$m]->WCI_each_accident,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
	</div>
      </div>
	  
	  <div class="comm">
        <div class="in-pan" style="margin-top:-18px;">
          <label>MyVC listed as Cert Holder?&nbsp;</label>
		  <?php if($WCI_data[$m]->WCI_cert == 'yes')  {
		  $wcioccurp = 'YES';
		  $wci_classfp = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $wcioccurp = 'NO';
		  $wci_classsp = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="WCI_certhide<?PHP echo $m+1; ?>"><?php echo $wcioccurp; ?></span>
        </div>
        <div class="clear"></div>
      </div>
      <div class="comm">
	   <div class="in-pan">
        <label>Last Verified By MyVendorCenter On:</label>
        <input name="WCI_date_verified[]" id="WCI_date_verified<?PHP echo $m+1; ?>" type="text" readonly="readonly" size="10" value="<?PHP if($WCI_data[$m]->WCI_status == '-1'){ echo 'Rejected'; } else { echo $WCI_data[$m]->WCI_date_verified; } ?>"/>
		</div>
      </div>
	  <div class="comm" style="display:none;">
        <label style="color:red;">Last Saved:</label>
     <input style="color:red;" readonly="" value="<?PHP echo $WCI_data[$m]->saveddate;  ?>"/>
      </div>
	  	  
    </div>
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
	if($UMB_data[0]-UMB_date_verified=='0000-00-00' || !$UMB_data[0]->UMB_date_verified){
	$UMB_data[0]->UMB_date_verified = '00-00-0000';
	} else {
	$UMB_data[0]->UMB_date_verified = date('m-d-Y', $UMB_date_verified);
	}
  
	
   ?><input type="hidden" name="type" id="type"  value="" />
   <input type="hidden" name="type_id" id="type_id"  value="" />

<?php //echo '<pre>'; print_r($OLN_data[0]); ?>
<!--<script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>-->
  <div  id="line_task_UMB<?PHP echo 1; ?>"><div class="lic-pan">
    <h2><?php if(!$UMB_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($UMB_data[0]->UMB_expdate < date('Y-m-d') || !$UMB_data[0]->UMB_upld_cert || $UMB_data[0]->UMB_status == '-1' || !$UMB_data[0]->UMB_aggregate || !$UMB_data[0]->UMB_occur) { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> UMBRELLA LIABILITY POLICY - 1 </h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
        <?php if($UMB_data[0]->UMB_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $UMB_data[0]->UMB_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayUMB1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=UMB_<?PHP echo $UMB_data[0]->UMB_folder_id; ?>&filename=<?PHP echo $UMB_data[0]->UMB_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="NO Image" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayUMB1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
       </div>
    <div class="lic-pan-right" id="UMB1">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
           <?PHP $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
        <input type="text" readonly="readonly" size="10" name="UMB_expdate[]" id="UMB_expdate1" value="<?PHP echo $UMB_date[1].'-'.$UMB_date[2].'-'.$UMB_date[0]; ?>" />
        <?php if($UMB_data[0]->UMB_expdate < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
		</div>
		<div class="in-pan1">
		<label>Aggregate:</label>
	<input type="text" readonly="readonly" class="t_field" name="UMB_aggregate[]" id="UMB_aggregate1" style="color: green; text-align: left;" value="<?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_aggregate,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
           <?PHP $UMB_date = explode('-',$UMB_data[0]->UMB_expdate); ?>
        <input type="text" readonly="readonly" class="t_field" name="UMB_occur[]" id="UMB_occur1" size="20"  style="color: green; text-align: left;" value="<?PHP if($UMB_data) {echo number_format($UMB_data[0]->UMB_occur,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert Holder?</label>
		  <?php if($UMB_data[0]->UMB_certholder == 'yes')  {
		  $umboccur = 'YES';
		  $umb_classf = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $umboccur = 'NO';
		  $umb_classs = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="UMB_certhide1"><?php echo $umboccur; ?></span>
        </div>
		</div>
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Last Verified By MyVendorCenter On:</label>
        <input type="text" class="bak" size="10" name="UMB_date_verified[]" id="UMB_date_verified"  readonly="readonly"  type="text" value="<?PHP if($UMB_data[0]->UMB_status == '-1' ){ echo 'Rejected'; } else { echo $UMB_data[0]->UMB_date_verified; } ?>"/>
		</div>
      </div>
    </div>
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
   ?> 
<div id="line_task_UMB<?PHP echo $i+1; ?>">
<div class="lic-pan">
    <h2><?php if($UMB_data[$i]->UMB_expdate < date('Y-m-d') || !$UMB_data[$i]->UMB_upld_cert || $UMB_data[$i]->UMB_status == '-1'  || !$UMB_data[$i]->UMB_aggregate || !$UMB_data[$i]->UMB_occur) { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> UMBRELLA LIABILITY POLICY - <?PHP echo $i+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
        <?php if($UMB_data[$i]->UMB_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $UMB_data[$i]->UMB_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayUMB<?PHP echo $i+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=UMB_<?PHP echo $UMB_data[$i]->UMB_folder_id; ?>&filename=<?PHP echo $UMB_data[$i]->UMB_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayUMB<?PHP echo $i+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      <?php //echo '<pre>'; print_r($OLN_data[$i]); ?>
	  </div>
    <div class="lic-pan-right" id="UMB<?PHP echo $i+1; ?>">
      <div class="comm">
	  <div class="in-pan">
        <label>Exp. Date:</label>
           <?PHP $UMB_date2 = explode('-',$UMB_data[$i]->UMB_expdate); ?>
      <input  name="UMB_expdate[]" readonly="readonly" type="text" id="UMB_expdate<?PHP echo $i+1; ?>" size="10" class="t_field" value="<?PHP echo $UMB_date2[1].'-'.$UMB_date2[2].'-'.$UMB_date2[0]; ?>">
	  <?php if($UMB_data[$i]->UMB_expdate < date('Y-m-d')){ ?><span style="color:red; font-size: 20px;">*</span> <?php } ?>
	  </div>
	  <div class="in-pan1">
		<label>Aggregate:</label>
	<input type="text" readonly="readonly" class="t_field" name="UMB_aggregate[]" id="UMB_aggregate<?PHP echo $i+1; ?>" size="20"  style="color: green; text-align: left;" value="<?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_aggregate,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
      </div>
	  
	  <div class="comm">
	  <div class="in-pan">
        <label>Each Occurrence</label>
        <input type="text" readonly="readonly" class="t_field" name="UMB_occur[]" id="UMB_occur<?PHP echo $i+1; ?>" size="20"  style="color: green; text-align: left;" value="<?PHP if($UMB_data) {echo number_format($UMB_data[$i]->UMB_occur,2); } ?>" onClick="if(this.value == '0.00') this.value='';"/>
		</div>
		</div>
		
		<div class="comm">
		<div class="in-pan">
          <label style="padding-top:10px;">MyVC listed as Cert Holder?</label>
		  <?php if($UMB_data[$i]->UMB_certholder == 'yes')  {
		  $umboccurs = 'YES';
		  $umb_classfs = "checked='checked'" ;
		  $color = '#8FD800';
		   }
		  else {
		  $umboccurs = 'NO';
		  $umb_classss = "checked='checked'" ;
		  $color = 'red';
		  }
		  ?>
         <span style="color:<?php echo $color; ?>; font-weight:bold;  margin-left:160px; margin-top:-18px; display:block;" id="UMB_certhide<?PHP echo $i+1; ?>"><?php echo $umboccurs; ?></span>
        </div>
		</div>
      <div class="comm">
	  <div class="in-pan">
        <label style="padding-top:5px;">Last Verified By MyVendorCenter On:</label>
        <input  type="text" class="bak" size="10" name="UMB_date_verified[]" id="UMB_date_verified"  readonly="readonly"  type="text" value="<?PHP if($UMB_data[$i]->UMB_status == '-1' ){ echo 'Rejected'; } else { echo $UMB_data[$i]->UMB_date_verified; } ?>"/>
		</div>
      </div>
	  <div class="comm" style="display:none;">
	  <div class="in-pan">
        <label style="color:red;">Last Saved:</label>
        <input style="color:red;" value="<?PHP echo $UMB_data[$i]->saveddate; ?>" readonly=""/>
		</div>
      </div>
    </div>
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
  /* if($main != '0000-00-00'){

	$date = strtotime($main);

	$date = date('m-d-Y', $date);

	}
	else{
	$date = 'PENDING';
	}
*/
	/* if($OLN_data[0]->OLN_expdate != '' || $OLN_data[0]->OLN_upld_cert != '')
	 {
	 if((isset($OLN_data[0]->OLN_expdate) && $OLN_data[0]->OLN_expdate != '0000-00-00' && $OLN_data[0]->OLN_expdate < date('Y-m-d')) )
	 { $dv = 'Expired'; } //$disable = "disabled='disabled'"; }
	 elseif($OLN_data[0]->OLN_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'"; }
	  elseif($OLN_data[0]->OLN_status == '1')
	 { $dv = $date; $disable = "disabled='disabled'";  }
	  else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
	  */
//echo $disable;
   ?><input type="hidden" name="type" id="type"  value="" />
   <input type="hidden" name="type_id" id="type_id"  value="" />

<?php //echo '<pre>'; print_r($OLN_data[0]); ?>
<!--<script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>-->
  <div  id="line_task_OLN<?PHP echo 1; ?>"><div class="lic-pan">
    <h2><?php if(!$OLN_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($OLN_data[0]->OLN_expdate < date('Y-m-d') || !$OLN_data[0]->OLN_upld_cert || $OLN_data[0]->OLN_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> Bus. Tax Receipt / Occupational License - 1 </h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
        <?php if($OLN_data[0]->OLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OLN_data[0]->OLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOLN1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OLN_<?PHP echo $OLN_data[0]->OLN_folder_id; ?>&filename=<?PHP echo $OLN_data[0]->OLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="NO Image" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOLN1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      
       </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
           <?PHP $OLN_date = explode('-',$OLN_data[0]->OLN_expdate); ?>
        <input type="text" size="10" readonly="readonly" value="<?PHP echo $OLN_date[1].'-'.$OLN_date[2].'-'.$OLN_date[0]; ?>" />
            <?php if($OLN_data[0]->OLN_expdate < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?>
        <script type="text/javascript">G('#OLN_expdate1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
        <input type="text" class="bak" size="10" name="OLN_date_verified[]" id="OLN_date_verified"  readonly="readonly"  type="text" value="<?PHP if($OLN_data[0]->OLN_status == '-1' ){ echo 'Rejected'; } else { echo $OLN_data[0]->OLN_date_verified; } ?>"/>
      </div>
    </div>
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
 /* if($main != '0000-00-00'){

	$date8 = strtotime($main);

	$date8 = date('m-d-Y', $date8);

	} else{

	$date8='PENDING';

	}
*/
	/* if($OLN_data[$i]->OLN_expdate != '' || $OLN_data[$i]->OLN_upld_cert != '')
	 {
	 if((isset($OLN_data[$i]->OLN_expdate) && $OLN_data[$i]->OLN_expdate != '0000-00-00' && $OLN_data[$i]->OLN_expdate < date('Y-m-d')) )
	 { $dv = 'Expired'; }// $disable = "disabled='disabled'"; }
	  elseif($OLN_data[$i]->OLN_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'"; }
	  elseif($OLN_data[$i]->OLN_status == '1')
	 { $dv = $date8;  $disable = "disabled='disabled'"; }
	  else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
*/
   ?> <input type="hidden" name="del_line_task_OLN_ids[]" id="del_line_task_OLN_ids_<?PHP echo $i+1; ?>" value="" />
<input type="hidden" name="OLN_status[]" value="<?PHP echo $OLN_data[$i]->OLN_status; ?>" />
<input type="hidden" name="dOLN<?PHP echo $i+1; ?>" id="dOLN<?PHP echo $i+1; ?>" value="" />
  <input type="hidden" name="old_line_task_OLN_ids[]" id="old_line_task_OLN_ids_<?PHP echo $i+1; ?>" value="<?PHP echo $OLN_data[$i]->id; ?>" />
  <input type="hidden" name="current_line_task_OLN_ids[]" id="current_line_task_OLN_ids<?PHP echo $i+1; ?>" value="<?PHP echo $i+1; ?>" />

   <input type="hidden" name="OLN_id<?PHP echo $i+1; ?>" id="OLN_id<?PHP echo $i+1; ?>" value="<?PHP echo $OLN_data[$i]->id; ?>" />
<!--//(isset($OLN_data[$i]->OLN_expdate) && $OLN_data[$i]->OLN_expdate != '0000-00-00' && $OLN_data[$i]->OLN_expdate < date('Y-m-d'))-->
<div id="line_task_OLN<?PHP echo $i+1; ?>">
<div class="lic-pan">
    <h2><?php if($OLN_data[$i]->OLN_expdate < date('Y-m-d') || !$OLN_data[$i]->OLN_upld_cert || $OLN_data[$i]->OLN_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> Bus. Tax Receipt / Occupational License - <?PHP echo $i+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
        <?php if($OLN_data[$i]->OLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $OLN_data[$i]->OLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayOLN<?PHP echo $i+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=OLN_<?PHP echo $OLN_data[$i]->OLN_folder_id; ?>&filename=<?PHP echo $OLN_data[$i]->OLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayOLN<?PHP echo $i+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      <?php //echo '<pre>'; print_r($OLN_data[$i]); ?>
      </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
           <?PHP $OLN_date2 = explode('-',$OLN_data[$i]->OLN_expdate); ?>
      <input type="text" size="10" readonly="readonly" value="<?PHP echo $OLN_date2[1].'-'.$OLN_date2[2].'-'.$OLN_date2[0]; ?>"> <?php if($OLN_data[$i]->OLN_expdate < date('Y-m-d')){ ?><span style="color:red; font-size: 20px;">*</span> <?php } ?><script type="text/javascript">G('#OLN_expdate<?PHP echo $i+1; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
        <input type="text" class="bak" size="10"  readonly="readonly"  type="text" value="<?PHP if($OLN_data[$i]->OLN_status == '-1' ){ echo 'Rejected'; } else { echo $OLN_data[$i]->OLN_date_verified; } ?>"/>
      </div>
    </div>
    <div class="clear"></div>
  </div></div>

<?PHP } ?>

<div id="addcompliance_OLN"></div>

<div id="addcompliance_OLN_loading"></div>

<!-- table row end -->
<!--// || (isset($PLN_data[0]->PLN_expdate) && $PLN_data[0]->PLN_expdate != '0000-00-00' && $PLN_data[0]->PLN_expdate < date('Y-m-d'))-->
<div id="line_task_PLN1">
<div class="lic-pan">
    <h2><?php if(!$PLN_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($PLN_data[0]->PLN_expdate < date('Y-m-d') || !$PLN_data[0]->PLN_upld_cert || !$PLN_data[0]->PLN_type || !$PLN_data[0]->PLN_state || $PLN_data[0]->PLN_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?>PROFESSIONAL LICENSE - 1</h2>
    <div class="clear"></div>
    <?php 
    $PLN_date_verified = strtotime($PLN_data[0]->PLN_date_verified);
	if($PLN_data[0]->PLN_date_verified=='0000-00-00' || !$PLN_data[0]->PLN_date_verified){
	$PLN_data[0]->PLN_date_verified = '00-00-0000';
	} else {
	$PLN_data[0]->PLN_date_verified = date('m-d-Y', $PLN_date_verified);
	}
    //$main = $PLN_data[0]->PLN_date_verified;
		//$disable = '';
		//$dv = '';
  /*if($main != '0000-00-00'){

	$date = strtotime($main);

	$date1 = date('m-d-Y', $date);

	} else{

	$date1 = 'PENDING';

	}
*/
	/* if($PLN_data[0]->PLN_expdate != '' || $PLN_data[0]->PLN_upld_cert != '')
	 {
	 if((isset($PLN_data[0]->PLN_expdate) && $PLN_data[0]->PLN_expdate != '0000-00-00' && $PLN_data[0]->PLN_expdate < date('Y-m-d')) )
	 { $dv = 'Expired';  } // $disable = "disabled='disabled'";}
	  elseif($PLN_data[0]->PLN_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'";}
	  elseif($PLN_data[0]->PLN_status == '1')
	 { $dv = $date1;   $disable = "disabled='disabled'";}
	   else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
*/
   ?>


<input type="hidden" name="PLN_id[]" id="PLN_id<?PHP echo $j+1; ?>" value="<?PHP echo $PLN_data[0]->id; ?>"/>

   <input type="hidden" name="old_line_task_PLN_ids[]" id="old_line_task_PLN_ids_1" value="<?PHP echo $PLN_data[0]->id; ?>"/>
    <input type="hidden" name="dPLN1" id="dPLN1" value="" />
<input type="hidden" name="PLN_status[]" value="<?PHP echo $PLN_data[0]->PLN_status; ?>" />
   <input type="hidden" name="current_line_task_PLN_ids[]" id="current_line_task_PLN_ids<?PHP echo $PLN_data[0]->id; ?>" value="1" />

<?php //echo '<pre>'; print_r($PLN_data[0]);?>

    <div class="lic-pan-left">
      <?php if($PLN_data[0]->PLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $PLN_data[0]->PLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayPLN1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=PLN_<?PHP echo $PLN_data[0]->PLN_folder_id; ?>&filename=<?PHP echo $PLN_data[0]->PLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayPLN1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
     <input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert1"  value="<?PHP echo $PLN_data[0]->PLN_upld_cert; ?>" />
        </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
        <?PHP $PLN_date = explode('-',$PLN_data[0]->PLN_expdate);  ?>

  <input type="text" readonly="readonly" size="10" value="<?PHP echo $PLN_date[1].'-'.$PLN_date[2].'-'.$PLN_date[0]; ?>"><?php if($PLN_data[0]->PLN_expdate < date('Y-m-d')) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?><script type="text/javascript">G('#PLN_expdate1').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <div class="in-pan">
          <label>Jurisdiction (state/country/city/association):</label>
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
           <input  readonly="readonly"size="25" value="<?php echo $PLN_data[0]->PLN_state; ?>"><?php if(!$PLN_data[0]->PLN_state) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
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
        <input  readonly="readonly" size="15" value="<?php echo $PLN_data[0]->PLN_type; ?>" ><?php if(!$PLN_data[0]->PLN_type) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="clear"></div>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
    <input name="PLN_date_verified[]" type="text" size="10" readonly="readonly" value="<?PHP if($PLN_data[0]->PLN_status == '-1' ){ echo 'Rejected'; } else { echo $PLN_data[0]->PLN_date_verified; } ?>"/>
      </div>
    </div>
    <div class="clear"></div>
  </div>
      <div class="clear"></div>
</div>

<?PHP for($j=1; $j<count($PLN_data); $j++) {?>

<div id="line_task_PLN<?PHP echo $j+1; ?>" >
<div class="lic-pan">
    <h2><?php if($PLN_data[$j]->PLN_expdate < date('Y-m-d') || !$PLN_data[$j]->PLN_upld_cert || !$PLN_data[$j]->PLN_state || !$PLN_data[$j]->PLN_type || $PLN_data[$j]->PLN_status == '-1') { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?>PROFESSIONAL LICENSE - <?PHP echo $j+1; ?></h2>
    <div class="clear"></div>
    <?php
    $PLN_date_verified1 = strtotime($PLN_data[$j]->PLN_date_verified);
	if($PLN_data[$j]->PLN_date_verified=='0000-00-00' || !$PLN_data[$j]->PLN_date_verified){
	$PLN_data[$j]->PLN_date_verified = '00-00-0000';
	} else {
	$PLN_data[$j]->PLN_date_verified = date('m-d-Y', $PLN_date_verified1);
	}
    //$main = $PLN_data[$j]->PLN_date_verified;
		//$disable = '';
		//$dv = '';
  /* if($main != '0000-00-00'){

	$date = strtotime($main);

	$date1 = date('m-d-Y', $date);

	} else{

	$date1 = 'PENDING';

	}
*/
	/* if($PLN_data[$j]->PLN_expdate != '' || $PLN_data[$j]->PLN_upld_cert != '')
	 {
	 if((isset($PLN_data[$j]->PLN_expdate) && $PLN_data[$j]->PLN_expdate != '0000-00-00' && $PLN_data[$j]->PLN_expdate < date('Y-m-d')) )
	 { $dv = 'Expired';  } // $disable = "disabled='disabled'";}
	  elseif($PLN_data[$j]->PLN_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'";}
	  elseif($PLN_data[$j]->PLN_status == '1')
	 { $dv = $date1;   $disable = "disabled='disabled'";}
	   else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
*/
   ?>


    <div class="lic-pan-left">
      <?php if($PLN_data[$j]->PLN_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $PLN_data[$j]->PLN_upld_cert)); ?>
      <div class="imag-display" id="imagdisplayPLN<?PHP echo $j+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=PLN_<?PHP echo $PLN_data[$j]->PLN_folder_id; ?>&filename=<?PHP echo $PLN_data[$j]->PLN_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplayPLN<?PHP echo $j+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
     <input type="hidden" class="file_input_textbox" name="PLN_upld_cert[]" id="PLN_upld_cert<?PHP echo $j+1; ?>"  value="<?PHP echo $PLN_data[$j]->PLN_upld_cert; ?>" /><br/>
      </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
        <?PHP $PLN_date = explode('-',$PLN_data[$j]->PLN_expdate);  ?>

  <input type="text" readonly="readonly" size="10" value="<?PHP echo $PLN_date[1].'-'.$PLN_date[2].'-'.$PLN_date[0]; ?>"> <?php if($PLN_data[$j]->PLN_expdate < date('Y-m-d')) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?><script type="text/javascript">G('#PLN_expdate<?PHP echo $j+1; ?>').datepicker({dateFormat: 'mm-dd-yy',changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <div class="in-pan">
          <label>Jurisdiction (state/country/city/association):</label>
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
           <input name="PLN_state[]" readonly="readonly" id="PLN_state<?PHP echo $j+1; ?>" class="t_field" size="25" value="<?php echo $PLN_data[$j]->PLN_state; ?>"><?php if(!$PLN_data[$j]->PLN_state) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
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
        <input name="PLN_type[]" id="PLN_type<?PHP echo $j+1; ?>" readonly="readonly" class="t_field" size="15" value="<?php echo $PLN_data[$j]->PLN_type; ?>"><?php if(!$PLN_data[$j]->PLN_type) { ?> <span style="color:red; font-size: 20px;">*</span><?php } ?>
        </div>
        <div class="clear"></div>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
    <input name="PLN_date_verified[]" type="text" size="10" readonly="readonly" value="<?PHP if($PLN_data[$j]->PLN_status == '-1' ){ echo 'Rejected'; } else { echo $PLN_data[$j]->PLN_date_verified; } ?>"/>
      </div>
    </div>
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
 //$main = $WC_data[0]->wc_date_verified;
 //echo '<pre>'; print_r($WC_data[0]);
 /* if($main != '0000-00-00'){

	$date = strtotime($main);

	$date = date('m-d-Y', $date);

	}
	else{
	$date = 'PENDING';
	}
	*/
//echo $date;
	/* if($WC_data[0]->wc_end_date != '' || $WC_data[0]->wc_upld_cert != '')
	 {
	 if((isset($WC_data[0]->wc_end_date) && $WC_data[0]->wc_end_date != '0000-00-00' && $WC_data[0]->wc_end_date < date('Y-m-d')) )
	 { $dv = 'Expired'; } //$disable = "disabled='disabled'"; }
	 elseif($WC_data[0]->wc_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'"; }
	  elseif($WC_data[0]->wc_status == '1')
	 { $dv = $date; $disable = "disabled='disabled'";  }
	  else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
	  */
//echo $dv;
   ?>

<div class="lic-pan">
    <h2><?php if(!$WC_data[0]->id){  ?>
        <img src="components/com_camassistant/assets/images/empty-icon.gif" alt="" />
      <?php  } else if($WC_data[0]->wc_end_date < date('Y-m-d') || $WC_data[0]->wc_upld_cert=='' || $WC_data[0]->wc_status == '-1' ) { ?><img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />
        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> WORKERS COMP EXEMPTION FORM - 1</h2>
    <div class="clear"></div>
    <div class="lic-pan-left">
       <?php if($WC_data[0]->wc_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WC_data[0]->wc_upld_cert)); ?>
      <div class="imag-display" id="imagdisplaywc1"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WC_<?PHP echo $WC_data[0]->wc_folder_id; ?>&filename=<?PHP echo $WC_data[0]->wc_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplaywc1"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
      
   <input type="hidden" class="file_input_textbox" name="wc_upld_cert[]" id="wc_upld_cert1"  value="<?PHP echo $WC_data[0]->wc_upld_cert; ?>" />
       </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
            <?PHP $wc_date = explode('-',$WC_data[0]->wc_end_date); ?>
        <input type="text" size="10" readonly="readonly" value="<?PHP if($WC_data[0]->wc_end_date){ echo $wc_date[1].'-'.$wc_date[2].'-'.$wc_date[0]; }  ?>" /><?php if($WC_data[0]->wc_end_date < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?><script type="text/javascript">G('#wc_end_date1').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
        <input class="bak" size="10" name="wc_date_verified[]" id="wc_date_verified"  readonly="readonly"  type="text" value="<?PHP if($WC_data[0]->wc_status == '-1' ){ echo 'Rejected'; } else { echo $WC_data[0]->wc_date_verified; } ?>"/>
      </div>
    </div>
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
    //$main = $WC_data[$mj]->wc_date_verified;
//echo '<pre>'; print_r($OLN_data[0]);
  /* if($main != '0000-00-00'){

	$date = strtotime($main);

	$date = date('m-d-Y', $date);

	}
	else{
	$date = 'PENDING';
	}
*/
	/* if($WC_data[$mj]->wc_end_date != '' || $WC_data[$mj]->wc_upld_cert != '')
	 {
	 if((isset($WC_data[$mj]->wc_end_date) && $WC_data[$mj]->wc_end_date != '0000-00-00' && $WC_data[$mj]->wc_end_date < date('Y-m-d')) )
	 { $dv = 'Expired'; } //$disable = "disabled='disabled'"; }
	 elseif($WC_data[$mj]->wc_status == '-1')
	 { $dv = 'Rejected'; } //$disable = "disabled='disabled'"; }
	  elseif($WC_data[$mj]->wc_status == '1')
	 { $dv = $date; $disable = "disabled='disabled'";  }
	  else
	  {
	  $dv ='PENDING';
	  $disable = '';
	  }
	  }
	  else
	  {
	  $dv = '';
	  $disable = '';
	  }
	  */
//echo $disable;
   ?>
        <h2><?php if($WC_data[$mj]->wc_end_date < date('Y-m-d') || $WC_data[$mj]->wc_upld_cert=='' || $WC_data[$mj]->wc_status == '-1') { ?>
            <img src="components/com_camassistant/assets/images/wrong.jpg" alt="" />

        <?php } else {  ?>
            <img src="components/com_camassistant/assets/images/right-icon.gif" alt="" />
      <?php  } ?> WORKERS COMP EXEMPTION FORM - <?PHP echo $mj+1; ?></h2>
    <div class="clear"></div>
    <div class="lic-pan-left">

       <?php if($WC_data[$mj]->wc_upld_cert!='') { ?>
        <?php $ext = end(explode('.', $WC_data[$mj]->wc_upld_cert)); ?>
      <div class="imag-display" id="imagdisplaywc<?PHP echo $mj+1; ?>"><a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=openview_upld_cert_vendorprofile&doc=WC_<?PHP echo $WC_data[$mj]->wc_folder_id; ?>&filename=<?PHP echo $WC_data[$mj]->wc_upld_cert; ?>&id=<?PHP echo $id; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" alt="" /></a></div>
      <?php } else { ?>
          <div class="imag-display" id="imagdisplaywc<?PHP echo $mj+1; ?>"><img src="templates/camassistant_inner/images/doc_images/no-file-uploaded.png" alt="" /></div>
      <?php } ?>
       <input type="hidden" class="file_input_textbox" name="wc_upld_cert[]" id="wc_upld_cert<?PHP echo $mj+1; ?>"  value="<?PHP echo $WC_data[$mj]->wc_upld_cert; ?>" /><br/>
    </div>
    <div class="lic-pan-right">
      <div class="comm">
        <label>Expiration Date:</label>
    <?PHP $wc_date1 = explode('-',$WC_data[$mj]->wc_end_date); ?>
        <input type="text" size="10" readonly="readonly" value="<?PHP echo $wc_date1[1].'-'.$wc_date1[2].'-'.$wc_date1[0]; ?>" /><?php if($WC_data[$mj]->wc_end_date < date('Y-m-d')) { ?><span style="color:red; font-size: 20px;">*</span><?php } ?><script type="text/javascript">G('#wc_end_date<?PHP echo $mj+1; ?>').datepicker({dateFormat: 'mm-dd-yy', changeYear: true,maxDate: "+2y",changeMonth:true});</script>
      </div>
      <div class="comm">
        <label>Last Verified By MyVendorCenter On:</label>
   <input size="10"  readonly="readonly"  type="text" value="<?PHP if($WC_data[$mj]->wc_status == '-1' ){ echo 'Rejected'; } else { echo $WC_data[$mj]->wc_date_verified; }?>"/>
      </div>
    </div>
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


<!-- table row end -->

<!--<p style=" padding-top:20px;"></p>-->

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

<!-- eof right -->


<table width="99%" cellspacing="0" cellpadding="0" style="margin:0px 4px">
  			  <tbody>
			
			<tr class="table_blue_rowdots_submitted" id="table_blue_rowdotsmarket">
			<td valign="middle" align="left" width="15" style="font-size:15px; font-weight:bold;">
			<a id="market" class="proposal_opener" href="#" style="float:left;"></a>&nbsp;&nbsp;&nbsp;MARKETING DOCUMENTS
			</td>
			</tr>
</tbody></table>

<div id="marketdocs">
</div>


<div class="clear"></div>

</div>

<!-- eof container -->
</div>
<br />





<!-- eof wrapper -->


<?php

exit; ?>