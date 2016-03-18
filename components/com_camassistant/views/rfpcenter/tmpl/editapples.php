<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<?php
  if($this->edata->apples){
  $exist_apple = $this->edata->apples ;
  }
  else{

  $db = & JFactory::getDBO();
  $rfpid = JRequest::getVar('rfpid','');
  $pre_apple = "SELECT apple FROM #__cam_rfpinfo WHERE id=".$rfpid."  ";
  $db->setQuery( $pre_apple);
  $exist_apple = $db->loadResult();
   }
  ?>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
  
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready( function(){
H('#chk a').click(function(){
	H('.radio-picture').removeClass('clickon');
	H('.radio-picture').removeClass('active');
	$radio_id=H(this).attr('rel');
	//If manager selects 1 or 2 apples
			if( $radio_id == '1' || $radio_id == '2' ){
				H(".unsatisfyrating").show();
				H(".commentsarea").hide();				
			}
			else{
				H(".commentsarea").show();
				H(".unsatisfyrating").hide();
			}
			if( $radio_id == '1' )
			H('#click_result').html('VERY UNSATISFIED');
			if( $radio_id == '2' )
			H('#click_result').html('UNSATISFIED');
			if( $radio_id == '3' )
			H('#click_result').html('NEUTRAL');
			if( $radio_id == '4' )
			H('#click_result').html('SATISFIED');
			if( $radio_id == '5' )
			H('#click_result').html('VERY SATISFIED');	
			
			//Completed
	H('#applerating').val($radio_id);
	H(this).addClass('active');
	H(this).addClass('clickon');
	H(this).prevAll('.radio-picture').addClass('active');
});

H('#chk a').mouseover(function(){
H(this).addClass('hover');
H(this).prevAll('.radio-picture').addClass('hover');
H(this).nextAll('.radio-picture').addClass('hove');
 hover_val = H(this).attr('rel') ;
			if( hover_val == '1' )
			H('#click_result').html('VERY UNSATISFIED');
			if( hover_val == '2' )
			H('#click_result').html('UNSATISFIED');
			if( hover_val == '3' )
			H('#click_result').html('NEUTRAL');
			if( hover_val == '4' )
			H('#click_result').html('SATISFIED');
			if( hover_val == '5' )
			H('#click_result').html('VERY SATISFIED');
});
H('#chk a').mouseout(function(){
H('.radio-picture').removeClass('hover');
H('.radio-picture').removeClass('hove');
click_val = H('.radio-picture.active.clickon').attr('rel') ;
		if( click_val == '1' )
			H('#click_result').html('VERY UNSATISFIED');
			if( click_val == '2' )
			H('#click_result').html('UNSATISFIED');
			if( click_val == '3' )
			H('#click_result').html('NEUTRAL');
			if( click_val == '4' )
			H('#click_result').html('SATISFIED');
			if( click_val == '5' )
			H('#click_result').html('VERY SATISFIED');
			if( !click_val )
			H('#click_result').html('');
});
});



H(document).ready( function(){
H("#submitapples").click(function(){
		var rating=H("#applerating").val();
		if(rating != ''){
		window.parent.document.getElementById( 'sbox-window' ).close();		
		H('#applebox').submit();
		
		//H('#proposaldetails_'+<?php echo $_REQUEST['rfpid']; ?>, window.parent.document).css('display','none');
		//H('#table_blue_rowdots'+<?php echo $_REQUEST['rfpid']; ?>, window.parent.document).css('display','none');
		//H('#awardproposaldetails_'+<?php echo $_REQUEST['rfpid']; ?>, window.parent.document).css('display','none');		
				
		}
		else{
		alert("Please select an apple");
		return false;
		}
		});
H('.confirmbutton').click(function(){
		H(".commentsarea").show();
		H(".unsatisfyrating").hide();
});	

H("#ctl00_CPHContent_txtComments").keyup(function(){
	send = parseInt( 250 - H(this).val().length) ;
	if(send >= 0){
	send = send+' characters remaining';
	H( "#charcount" ).html(send);
	}
	else{
	H( "#charcount" ).html('0 characters remaining');
	}
    if(H(this).val().length > '250'){
		alert("You've reached the Character Limit");
        H(this).val(H(this).val().substr(0, 250));
	}
	});

H('#cancellink').click(function(){
window.parent.document.getElementById( 'sbox-window' ).close();		
});
		
		
	H('.radio-picture').removeClass('clickon');
	H('.radio-picture').removeClass('active');
	$radio_id = <?php echo $exist_apple ; ?>;
	//alert($radio_id);
	//If manager selects 1 or 2 apples
			if( $radio_id == '1' || $radio_id == '2' ){
				H(".unsatisfyrating").show();
				H(".commentsarea").hide();				
			}
			else{
				H(".commentsarea").show();
				H(".unsatisfyrating").hide();
			}
			if( $radio_id == '1' )
			H('#click_result').html('VERY UNSATISFIED');
			if( $radio_id == '2' )
			H('#click_result').html('UNSATISFIED');
			if( $radio_id == '3' )
			H('#click_result').html('NEUTRAL');
			if( $radio_id == '4' )
			H('#click_result').html('SATISFIED');
			if( $radio_id == '5' )
			H('#click_result').html('VERY SATISFIED');	
			
			//Completed
	H('#applerating').val($radio_id);
	H('#chk a').each(function(){
		if( H(this).attr('rel') == $radio_id ){
			H(this).addClass('active');
			H(this).addClass('clickon');
			H(this).prevAll('.radio-picture').addClass('active');
		}
	});

	


		
		});
		
</script>
	

<?php //echo "<pre>"; print_r($this->edata); echo "</pre>"; ?>
<form action="" method="post" name="applebox" id="applebox">
<div id="apple">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">RATE VENDOR</font></span>
</div></div>

<p></p>
<div id="chk">
<?php
if($this->edata->apples == '1')
	$check1 = 'checked="checked"';
if($this->edata->apples == '2')
	$check2 = 'checked="checked"';
if($this->edata->apples == '3')
	$check3 = 'checked="checked"';
if($this->edata->apples == '4')
	$check4 = 'checked="checked"';
if($this->edata->apples == '5')
	$check5 = 'checked="checked"';
	

?>
<input type="radio" value="1" name="category" id="category_1" class="hidden_apple" <?php echo $check1; ?> />
<a id="one" href="javascript:void(0)" rel='1' class="radio-picture" >&nbsp;</a>
<input type="radio" value="2" name="category" id="category_2" class="hidden_apple" <?php echo $check2; ?> />
<a id="two" href="javascript:void(0)" rel='2' class="radio-picture" >&nbsp;</a>
<input type="radio" value="3" name="category" id="category_3" class="hidden_apple" <?php echo $check3; ?> />
<a id="three" href="javascript:void(0)" rel='3' class="radio-picture" >&nbsp;</a>
<input type="radio" value="4" name="category" id="category_4" class="hidden_apple" <?php echo $check4; ?> />
<a id="four" href="javascript:void(0)" rel='4' class="radio-picture" >&nbsp;</a>
<input type="radio" value="5" name="category" id="category_5" class="hidden_apple" <?php echo $check5; ?> />
<a id="five" href="javascript:void(0)" rel='5' class="radio-picture" >&nbsp;</a>

<input type="hidden" value="<?php echo $_REQUEST['rfpid']; ?>" name="rfpid" />
<input type="hidden" value="" name="applerating" id="applerating" class="applerating" />
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="saveapples" name="task">
<input type="hidden" value="<?php echo $this->edata->id; ?>" name="id" />
<input type="hidden" value="edit" name="type" />
</div>
<span id="click_result"></span>
<div class="clear"></div>
<div id="sumb">
</div>
</div>

<div class="unsatisfyrating" style="display:none;">
<span>NOTICE:</span>
<p>You are about to leave an unsatisfactory rating for this Vendor. We're sure the Vendor would like the opportunity to make you happy, so please make sure you've contacted them regarding any outstanding issues before leaving this rating.</p>
<ul>
<li><strong><?php echo $this->vdata->company_name; ?></strong></li>
<li><?php echo $this->vdata->name.' '.$this->vdata->lastname ; ?></li>
<li><?php echo $this->vdata->company_phone; 
if($this->vdata->phone_ext)
echo "&nbsp;(".$this->vdata->phone_ext.')';
?></li>
<li><a href="mailto:<?php echo $this->vdata->email; ?>"><?php echo $this->vdata->email; ?></a></li>
</ul>
<a href="javascript:void(0)" class="confirmbutton"></a>
<br/></div>



<div class="commentsarea" style="display:none;">
<span>Comments (optional)</span>
<textarea name="rating_comment" id="ctl00_CPHContent_txtComments" rows="5" cols="70"><?php echo str_replace('<br />','\n',$this->edata->comment); ?></textarea>
<span id="charcount"></span>
<table cellpadding="0" cellspacing="0">
<tr>
<td><img id="cancellink" class="closelink" src="templates/camassistant_left/images/cancel.jpg" style="cursor:pointer;" /></td>
<td><input type="button" value="" src="templates/camassistant_left/images/submit.jpg" id="submitapples" class="submitapples" /></td>
</tr>
</table>
</div>
</form>
<?php exit; ?>