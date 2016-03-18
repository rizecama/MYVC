<style>
#maskvrecdonee {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrecdonee .windowvrecdonee {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrecdonee #submitvrecdonee {  width:388px;  height:158px;  padding:10px;  background-color:#ffffff;}
#boxesvrecdonee #submitvrecdonee a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrecdonee {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }

#maskvrecdoneee {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrecdoneee .windowvrecdoneee {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrecdoneee #submitvrecdoneee {  width:318px;  height:130px;  padding:10px;  background-color:#ffffff;}
#boxesvrecdoneee #submitvrecdoneee a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrecdoneee {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
</style>
<?php
$user =& JFactory::getUser();
$open_job = JRequest::getVar('open','');
$personal_job = JRequest::getVar('personal','');
if( $open_job == 'open' && $personal_job == 'personal' )
	$rfp_type = 'both';
else if( $open_job == 'open' && $personal_job != 'personal' )
	$rfp_type = 'open';
else if( $personal_job == 'personal' )
	$rfp_type = 'personal';

else
	$rfp_type = '';		
$selected_vendors = JRequest::getVar('selected_vendors','');
?>
<style type="text/css">
#maskreq {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesreq .windowreq {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
/*#boxesreq #submitreq {  width:789px;  height:640px;  padding:10px;  background-color:#ffffff;}*/
#boxesreq #submitreq {  width:789px;  height:610px;;  padding:10px;  background-color:#ffffff;}
#donereq {border:0 none; cursor:pointer; height:30px; margin-top:-31px; float:right; width:228px; }
#closereq { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:200px;}
</style>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
L = jQuery.noConflict();
L(document).ready(function(){
L('#donereq').click(function (e) {
			//Validation part
			if( L('#property_id').val() == '' || L('#property_id').val() == '0' ){
				alert("Please select a Property from the list.");
				return false;
			}
			/*else if( L('#property_id').val()){
			property_id = L('#property_id').val();
			
		L.post("index2.php?option=com_camassistant&controller=rfp&task=rfpapprovalcheck", {property_id: ""+property_id+""}, function(data){
		if(data == 1){
		alert('Require property owner premission');
		return false;
		}
		else
		{*/
			else if( L('#industry_id').val() == '' || L('#industry_id').val() == '0' ){
				alert("Please select a Industry from the list.");
				return false;
			}
			
			else if( L('#projectName').val() == '' ){
				alert("Please enter Reference name.");
				return false;
			}
			else if( L('#proposalDueDate').val() == '' ){
				alert("Please enter Requested Due Date.");
				return false;
			}
			else if( L('#scopeofwork').val() == '' ){
				alert("Please enter Scope of work.");
				return false;
			}
			else{
			//alert("can");
			L(document).ready(function (){
			L("#loading-div-background").show();
			});
			L('#basicrequest').submit();
			}
		e.preventDefault();
		L('#maskreq').hide();
		L('.windowreq').hide();
	/*	}
 });
				
			}*/
		
		});
	L('#property_id').change(function(){
		if( L(this).val() != '0' )
		L( this ).prev().addClass( 'active' );
		else
		L( this ).prev().removeClass( 'active' );
	});
	
	L('#industry_id').change(function(){
		if( L(this).val() != '0' )
		L( this ).prev().addClass( 'active' );
		else
		L( this ).prev().removeClass( 'active' );
	});
	
	L('#projectName').keyup(function(){
		if( L(this).val() == '' )
		L( this ).prev().removeClass( 'active' );
		else
		L( this ).prev().addClass( 'active' );
	});
	L('#proposalDueDate').keyup(function(){
		if( L(this).val() == '' )
		L( this ).prev().removeClass( 'active' );
		else
		L( this ).prev().addClass( 'active' );
	});
	
	L('#scopeofwork').keyup(function(){
		if( L(this).val() == '' )
		L( this ).prev().removeClass( 'active' );
		else
		L( this ).prev().addClass( 'active' );
	});
	
	});	
	

function getcancelpopup(){
 H = jQuery.noConflict();
	H('body,html').animate({
	scrollTop: 250
	},800);
	var maskHeight = H(document).height();
	var maskWidth = H(window).width();
	H('#maskvrecdoneee').css({'width':maskWidth,'height':maskHeight});
	H('#maskvrecdoneee').fadeIn(100);
	H('#maskvrecdoneee').fadeTo("slow",0.8);
	var winH = H(window).height();
	var winW = H(window).width();
	H("#submitvrecdoneee").css('top',  winH/2-H("#submitvrecdoneee").height()/2);
	H("#submitvrecdoneee").css('left', winW/2-H("#submitvrecdoneee").width()/2);
	
	H("#submitvrecdoneee").fadeIn(2000);
	H('.windowvrecdoneee #closevrecdoneee').click(function (e) {
		window.location.assign("index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125")
		H('#maskvrecdoneee').hide();
		H('.windowvrecdoneee').hide();
	});
}
function addEventa2(id2)
	{
			L = jQuery.noConflict();
			var arrlicen2=new Array();
			var ni2 = document.getElementById('newdiva2'+id2);
			var numi2 = document.getElementById('theValue');
			var num2 = (document.getElementById("theValue").value -1)+ 2;
			numi2.value = num2;
			var divIdName2 = "newSelector"+num2;
			minheight = L( '.windowreq' ).height() ;
            newitem2='<table><tr><input type="hidden" name="old_docids[]" /><td><span id="delimg'+id2+''+num2+'" style="display:none" title="Remove From RFP"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer;" onclick="javascript:deletelineupload('+id2+''+num2+','+num2+');"/></span></td><td><span id="uploadfile'+id2+''+num2+'" style="float:left;width:auto;padding-right:5px; font-size:14px; color:#8FD800;"></span></td><input type="hidden" value=" " name="linetask_uploads_2'+id2+'[]" id="lineuploads'+id2+''+num2+'"  ></tr></table>';
			var newdiva2 = document.createElement('div');
			newdiva2.setAttribute("id",divIdName2);
			newdiva2.innerHTML = newitem2;
			ni2.appendChild(newdiva2);
			/*nextheight = parseInt(minheight + 20) ;
			L('.windowreq').css('height',nextheight+'px');*/
			linetaskupload(id2+''+num2);
	}
	function linetaskupload(id){
		L = jQuery.noConflict();
		property_id = L('#property_id').val();
		if( L('#property_id').val() == '' || L('#property_id').val() == '0' )
			{
				geterrorpopup();
			}
		else
			{
				el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=upload_select&taskid='+id+'&pid='+property_id+'&mid='+<?php echo $user->id; ?>;
				var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 700, y:330}}"))
				SqueezeBox.fromElement(el,options);
			}
	}
	function deletelineupload(taskid,num){
		var res = confirm("Are you sure you want to remove this file from the RFP?");
			if(res==true){
				window.parent.document.getElementById('lineuploads'+taskid).value ='';
				window.parent.document.getElementById('delimg'+taskid).style.display ='none';
				window.parent.document.getElementById('uploadfile'+taskid).style.display ='none';
				window.parent.document.getElementById('newSelector'+num).style.display ='none';
			}
	}
	function geterrorpopup(){
	H('body,html').animate({
	scrollTop: 250
	},800);
	var maskHeight = H(document).height();
	var maskWidth = H(window).width();
	H('#maskvrecdonee').css({'width':maskWidth,'height':maskHeight});
	H('#maskvrecdonee').fadeIn(100);
	H('#maskvrecdonee').fadeTo("slow",0.8);
	var winH = H(window).height();
	var winW = H(window).width();
	H("#submitvrecdonee").css('top',  winH/2-H("#submitvrecdonee").height()/2);
	H("#submitvrecdonee").css('left', winW/2-H("#submitvrecdonee").width()/2);
	
	H("#submitvrecdonee").fadeIn(2000);
	H('.windowvrecdonee #closevrecdonee').click(function (e) {
		e.preventDefault();
		H('#maskvrecdonee').hide();
		H('.windowvrecdonee').hide();
	});
}	
</script>

<div style="padding:10px 10px 12px; text-align:center;">
<form name="basicrequest" id="basicrequest" method="post">
<div class="light_box">
<div class="rollingimage_div"><img class="rollingimage" src="templates/camassistant_left/images/sec_step_basic.png"></div>
<div id="topborder_row_basic"></div>
<div class="list_box">
<ul>
<li>
<label class="selecte_property">Select Property</label>
<?php 
$properties = $this->properties ;
 ?>
	<select id="property_id" name="property_id" style="width:101%; height:32px; padding:5px;">
	<option value="0">Please select property</option>
	<?php
		for( $p=0; $p<count($properties); $p++ ){ ?>
		<option value="<?php echo $properties[$p]->id; ?>"><?php echo str_replace('_',' ',$properties[$p]->property_name); ?></option>
		<?php }
	?>
	</select>
</li>
<?php if( $rfp_type != 'personal' ){ ?>
<li>
<label class="selecte_property">Select Industry<span> (because you selected 'open invitation')</span></label>
<?php 
$industries = $this->industries ;
 ?>
	<select id="industry_id" name="industry_id" style="width:101%; height:32px; padding:5px;">
	<option value="0">Please select industry</option>
	<?php
		for( $in=0; $in<count($industries); $in++ ){ ?>
		<option value="<?php echo $industries[$in]->id; ?>"><?php echo str_replace('_',' ',$industries[$in]->industry_name); ?></option>
		<?php }
	?>
	</select>
</li>
<?php } ?>
<li>
<label class="selecte_property">Reference Name for this Request</label>
<input type="text" name="projectName" id="projectName"  />
</li>
<li>
<label class="selecte_property">Requested Due Date</label>
<input type="text" name="proposalDueDate" readonly="readonly" id="proposalDueDate" />
</li>
<script type="text/javascript">
H = jQuery.noConflict();
H('#proposalDueDate').datetimepicker({
			dateFormat: 'mm-dd-yy',
			//minDate: '10D',
			minDate: '0D',
			//minDate: 'new',
			 timeFormat: 'hh:00',
			 hour: 12,
			 minute: 00,
			changeYear: true,changeMonth:true,
});

H("#proposalDueDate").click(function () {
			H( this ).prev().addClass( 'active' );
			var someDate = new Date();
			var numberOfDaysToAdd = 7;
			someDate.setDate(someDate.getDate() + numberOfDaysToAdd); 
			var dd = someDate.getDate();
			var mm = someDate.getMonth() + 1;
			var y = someDate.getFullYear();
			var newdate = mm + '-'+ dd + '-'+ y + '12:00';
			 H('#proposalDueDate').datetimepicker('setDate', newdate);
                  });

</script>
<li class="text_areabox">
<label class="selecte_property">Scope of Work (SOW)</label>
<textarea name="jobnotes" id="scopeofwork"></textarea>
<span id='upload_file10' style="float:left;width:auto;padding-right:5px; margin-top:5px; padding-left:2px;"><a class="upload_new_files_rfp" href="javascript:addEventa2('10');">
<p style="height:10px;"></p></a></span>
<span id="delimg10" style="display:none" title="Remove From RFP"><img src="templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer; margin-top:13px;" onclick="javascript:deletelineupload_line(10);"  /></span>
<div class="clear"></div>
<div id="newdiva210" style="margin-top:10px;"></div>
<input name="hidden" type="hidden" id="theValue" value="0">
<input name="hidden" type="hidden" id="idval" value="0">

</li>
<div id="topborder_row"></div>
<li> 
<div id="closereq" name="closereq" value="Cancel"><a class="cancel_basicrequest" onclick="getcancelpopup()" href="javascript:void(0);"></a></div>
<div id="donereq"  name="donereq" value="Ok"><a class="save_basicrequest" href="javascript:void(0);"></a></div>
</li>
</ul>
</div>
</div>
</div>
<div id="boxesvrecdonee" class="boxesvrecdonee">
<div id="submitvrecdonee" class="windowvrecdonee" style="top:300px; left:582px; border:6px solid red; position:fixed;">
<br/>
<p align="center" style="color:gray; font-size:14px;">Please select a Property before attaching any files.  This allows your account to automatically open and save documents to the document folder specific to your property.</p>
<div class="recoommend_alert">
<div id="closevrecdonee" name="closeprecdonee" value="Cancel" class="ok_newone_recom_gray"></div>
</div>
</div>
<div id="maskvrecdonee"></div>
</div>
<div id="boxesvrecdoneee" class="boxesvrecdoneee">
<div id="submitvrecdoneee" class="windowvrecdoneee" style="top:300px; left:582px; border:6px solid red; position:fixed;">
<br/>
<p align="center" style="color:gray; font-size:14px;">Are you sure you want to leave the RFP and lose your current work?</p>
<div class="recoommend_alert">
<div id="closevrecdoneee" name="closeprecdoneee" value="Cancel" class="ok_newone_recom_gray"></div>
</div>
</div>
<div id="maskvrecdoneee"></div>
</div>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="submit_rfp" />
<input type="hidden" name="rfp_type" value="rfp" />
<input type="hidden" name="basicrequest" value="basicrequest" />
<input type="hidden" name="selected_vendors" id="selected_vendors" value="<?php echo $selected_vendors; ?>" />
<input type="hidden" name="rfptype" id="" value="<?php echo $rfp_type; ?>" />

</form>
