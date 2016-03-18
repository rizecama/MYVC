<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
H(document).ready( function(){
H('#cancellink').click(function(){
window.parent.document.getElementById( 'sbox-window' ).close();		
});
		
		});
		
</script>
	


<div id="i_bar_terms" style="margin:20px; background:red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">INVITATION DECLINED</font></span>
</div></div>

<div class="declinedbody">
<p><?php echo $this->v_name; ?> declined your invitation for the following reason(s):</p>
<br /><br />
<ul>
<?php 
$declines = $this->declines ;
if( $declines->big == 'on' )
	echo "<li> - Project too big </li>";
if( $declines->small == 'on' )
	echo "<li> - Project too small </li>";
if( $declines->busy == 'on' )
	echo "<li> - Too busy/Needed staff unavailable </li>";
if( $declines->indus == 'on' )
	echo "<li> - This is an industry we do not serve </li>";
if( $declines->loc == 'on' )
	echo "<li> - This is a location we do not serve </li>";
if( $declines->other_reason )
	echo "<li> - " . $declines->other_reason . "</li>";

?>
</div>
<?php 
exit; ?>