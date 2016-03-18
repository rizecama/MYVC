<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Untitled Document</title>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/camassistant_left/css/style.css" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function okopentext(){
	window.parent.document.getElementById( 'sbox-window' ).close();
}
</script>
</head>

<body>
<div id="i_bar_terms" style="margin-bottom:0px; margin-left:16px; margin-top:13px; width:523px; text-align:center;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">PERSONAL INVITATION</font></span>
</div></div>
<?php $text = $this->personaltext;?>
<div class="vendor_newcodes_text">
<?php echo $text;?>
</div>
<div align="center">
<a href="javascript:void(0);" onclick="javascript:okopentext();" class="text_vendor_preferred"></a>
</div>
<?php exit; ?>
</body>
</html>