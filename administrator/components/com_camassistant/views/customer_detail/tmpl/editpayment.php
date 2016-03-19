<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/camassistant_left/css/style.css" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="../components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
G = jQuery.noConflict();
	function savepaymentpage(){
			 checkid = G('#checkid').val();
			 amount = G('#amount').val();
			 balance = G('#balance_amounts').val();
			 
			 checkamt = amount.split('.');
			 checkamount = checkamt[0];
			 checkamount = checkamount.replace(',','');
			
			 checkbalance = balance.split('.');
			 checkbal = checkbalance[0];
			 checkbal = checkbal.replace(',','');
			 
			if(!amount){
				alert("Please enter amount.");
				G( "#amount" ).focus();
				return false;
			} 
			else if(!checkid){
				alert("Please enter check ID.");
				G( "#checkid" ).focus();
				return false;
			}
			else if( parseInt(checkbal) < parseInt(checkamount) ){
				alert("Insufficient Balance amount.");
				G( "#amount" ).focus();
				return false;
			}
			else{
				format_val(amount);	
				//alert("can");
				G('#paymentform').submit();
			}
	}
	function format_val(fieldvalue){
	var i=0;
	var ValidData="0123456789.,";
	var Data=fieldvalue;
	if(fieldvalue != "")
		for(i=0;i<Data.length;i++)
		{
			if(ValidData.indexOf(Data.charAt(i))==-1)
			{
				if( i == 0 ){
				alert ("Please enter numerals and decimal point only.");
				G( "#amount" ).val('');
				G( "#amount" ).focus();
				return false;
				}
				
			}
			else{
				G.post("index2.php?option=com_camassistant&controller=customer_detail&task=vendor_proposal_edit_format_val", {fieldvalue:""+fieldvalue+""}, function(data){
				if(data.length >0) {
				G("#amount").val(data);
				}
				});
			}
		}
	
	
	}
		
</script>
<body>
<?php 
$codeid = JRequest::getVar("codeid",'');
$payid = JRequest::getVar("payid",'');
$amount = JRequest::getVar("amount",'');
$checkid = JRequest::getVar("checkid",'');
$masterid = JRequest::getVar("masterid",'');
$bal = JRequest::getVar("bal",'');
?>
<div id="i_bar_terms" style="margin-bottom:0px; margin-left:19px; margin-top:15px; width:608px; text-align:center;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold;"><?php echo "EDIT PAYMENT"; ?></font></span>
</div></div>
<form method="post" name="paymentform" id="paymentform">
<table cellpadding="0" cellspacing="0" align="center" width="100%" style="text-align:center;">
<tr height="20"></tr>
<tr><td width="50%">Amount:&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="amount" id="amount" onblur="javascript: format_val(this.value);" value="<?php echo $amount; ?>" /></td></tr>
<tr height="20"></tr>
<tr><td width="50%">Check ID:&nbsp;<input type="text" name="checkid" id="checkid" value="<?php echo $checkid; ?>" /></td></tr>
<tr height="20"></tr>
<tr><td><input type="button" value="UPDATE" onclick="javascript:savepaymentpage();" /></td></tr></table>
<input type="hidden" value="<?php echo $codeid; ?>" name="codeid" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="customer_detail" />
<input type="hidden" name="task" value="savepaymentinfo" />
<input type="hidden" value="<?php echo $payid; ?>" name="id" />
<input type="hidden" value="<?php echo $bal.'.00'; ?>" name="bal" id="balance_amounts" />
<input type="hidden" value="update" name="action" />
</form>
<?php exit; ?>
</body>
</html>
