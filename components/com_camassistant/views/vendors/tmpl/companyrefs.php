<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
function removedocs(id,filename){
	var conf = confirm("Are you sure you want to delete the document?");
	if(conf == true){
	
		H.post("index2.php?option=com_camassistant&controller=vendors&task=deletcrefs&id="+id+"", {filename: ""+filename+""}, function(data){
		if(data == 'success') {
		alert("Document has been deleted successfully.");
		location.reload(); 
		}
		else{
		alert("Please try again.");
		}
		});
		
	}
	else{
	
	}
}
</script>
<p style="height: 19px;"></p>
<div id="i_bar_gray">

    
<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">COMPANY REFERENCES</font></span>
</div></div>

</div>
<p style="margin-top: 5px; font-size:13px">This page is where you can store your company references for easy review, or downloading, by your clients. All documents will appear on your Profile Page. To remove a document that you upload, you may click the RED X.</p>


<div id="maindivmarket">
<div class="dashbutton"><a href="index2.php?option=com_camassistant&controller=vendors&task=uploadcompanyrefs" rel="{handler: 'iframe', size: {x: 500, y: 350}}" class="modal"><img src="templates/camassistant_left/images/upload-a-document.png" class="createnewrequest" /></a>
<div class="clear"></div>
</div>
</div>
<p style="height:80px;"></p>
 <?php 
 for($i=0; $i<count($this->companyrefs); $i++){ ?>
<?php 
if($i == '4' || $i == '8' || $i == '12' || $i == '16' || $i == '20' || $i == '24' || $i == '28' || $i == '32') {?>
<div class="clear"></div>
<div class="sepdashbutton"></div>
<br /><br />
<?php } ?>
<div class="nvnv">
<h6><?php 
$strlen = strlen($this->companyrefs[$i]->filename) ;

if($strlen > 18){
$result = substr($this->companyrefs[$i]->filename, 0, 18);
echo $result.'...' ;
}
else{
echo str_replace('_',' ',$this->companyrefs[$i]->filename) ;
}
?></h6>
<div class="dal-tie">
<div class="close">
<a href="#" onclick="removedocs('<?php echo $this->companyrefs[$i]->id; ?>','<?php echo $this->companyrefs[$i]->filename; ?>');"><img src="templates/camassistant_left/images/close-icon.png" /></a>
</div>
<?php $ext = end(explode('.', $this->companyrefs[$i]->filename)); ?>
<a target="_blank" href="index.php?option=com_camassistant&controller=vendors&task=viewcrefdocs&filename=<?php echo $this->companyrefs[$i]->filename; ?>"><img src="templates/camassistant_inner/images/doc_images/images_<?php echo $ext; ?>.png" /></a>
</div>
</div>

<?php 
} ?>
