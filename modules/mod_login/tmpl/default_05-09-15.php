<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
 ?>
<link rel="stylesheet" media="all" type="text/css" href="components/com_camassistant/skin1/css/jquery1.css" />		

<?php if( ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'closedrfp' && $_REQUEST['type'] == 'end') || 
		  ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'awardrfp')	||
		  ($_REQUEST['controller'] == 'rfpcenter' && $_REQUEST['task'] == 'awardrfp' && $_REQUEST['rated'] == 'yes')
 ){ ?>

<?php } else { ?>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<?php } ?>

<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>

<script>
K = jQuery.noConflict();

K(document).ready(function() {	

	//select all the a tag with name equal to modal
	var uname,pwd;
	K('#logibtn').click(function(e) {
	 uname = document.login.username.value;
	 pwd = document.login.passwd.value;
	if(document.login.terms.checked==false)
	{
				//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
				
		//Get the screen height and width
		var maskHeight = K(document).height();
		var maskWidth = K(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		K('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		K('#mask').fadeIn(100);	
		K('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		
		var winH = K(window).height();
		var winW = K(window).width();
		
		
              
		//Set the popup window to center
		K("#submit").css('top',  winH/2-K("#submit").height()/2);
		K("#submit").css('left', winW/2-K("#submit").width()/2);

		//transition effect
		K("#submit").fadeIn(2000);
		 //alert( e.preventDefault);
	}
	
	});
	
	//if close button is clicked
	K('.window #close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		K('#mask').hide();
		K('.window').hide();
	});	
	
	//if done button is clicked
	K('.window #done').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		K('#mask').hide();
		K('.window').hide();
		document.logins.username.value=uname;
		document.logins.passwd.value=pwd;
		document.logins.submit();

	});		
	
			
	
});


M = jQuery.noConflict();
M(document).ready(function() {	
M('#signout').click(function(e) {
	     e.preventDefault();

		var maskHeight = M(document).height();
		var maskWidth = M(window).width();
		M('#mask5').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		M('#mask5').fadeIn(100);	
		M('#mask5').fadeTo("slow",0.8);	
	
		//Get the window height and width
		
		var winH = M(window).height();
		var winW = M(window).width();
	
		//Set the popup window to center
		M("#submit5").css('top',  winH/2-M("#submit5").height()/2);
		M("#submit5").css('left', winW/2-M("#submit5").width()/2);

		//transition effect
		M("#submit5").fadeIn(2000);
		 
		 //alert( e.preventDefault);
		
	});
		
	M('.window5 #close5').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		M('#mask5').hide();
		M('.window5').hide();
	});	
	//if done button is clicked
	M('.window5 #done5').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		M('#mask5').hide();
		M('.window5').hide();
		document.signoutform.submit();
	});		
	
	
});

N = jQuery.noConflict();
N(document).ready(function() {	
N('#signout1').click(function(e) {
	     e.preventDefault();

		var maskHeight = N(document).height();
		var maskWidth = N(window).width();
		N('#mask6').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		N('#mask6').fadeIn(100);	
		N('#mask6').fadeTo("slow",0.8);	
	
		//Get the window height and width
		
		var winH = N(window).height();
		var winW = N(window).width();
	
		//Set the popup window to center
		N("#submit6").css('top',  winH/2-N("#submit6").height()/2);
		N("#submit6").css('left', winW/2-N("#submit6").width()/2);

		//transition effect
		N("#submit6").fadeIn(2000);
		 
		 //alert( e.preventDefault);
		
	});
		
	N('.window6 #close6').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		N('#mask6').hide();
		N('.window6').hide();
	});	
	//if done button is clicked
	N('.window6 #done6').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		N('#mask6').hide();
		N('.window6').hide();
		document.signoutform.submit();
	});		
	
	
});
PQ = jQuery.noConflict();
PQ(document).ready(function() {	
PQ('#signout2').click(function(e) {
if( document.getElementById('changes').value == 'yes' ){
	     e.preventDefault();
		var maskHeight = PQ(document).height();
		var maskWidth = PQ(window).width();
		PQ('#mask7').css({'width':maskWidth,'height':maskHeight});
		//transition effect		
		PQ('#mask7').fadeIn(100);	
		PQ('#mask7').fadeTo("slow",0.8);	
		//Get the window height and width
		var winH = PQ(window).height();
		var winW = PQ(window).width();
		//Set the popup window to center
		PQ("#submit7").css('top',  winH/2-N("#submit6").height()/2);
		PQ("#submit7").css('left', winW/2-N("#submit6").width()/2);
		//transition effect
		PQ("#submit7").fadeIn(2000);
		}
		else{
		document.signoutform.submit();
		}
		 //alert( e.preventDefault);
	});
	PQ('.window7 #close7').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		PQ('#mask7').hide();
		PQ('.window7').hide();
	});	
	//if done button is clicked
	PQ('.window7 #done7').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		PQ('#mask7').hide();
		PQ('.window7').hide();
		document.signoutform.submit();
	});		
	
	
});

</script>
<style>
#mask5 {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes5 .window5 {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxes5 #submit5 {
   width:300px; 
  height:130px;
  padding:10px;
  background-color:#ffffff;
}
#done5 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#close5 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}

#mask7 {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes7 .window7 {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxes7 #submit7 {
   width:300px; 
  height:130px;
  padding:10px;
  background-color:#ffffff;
}
#done7 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#close7 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}

#mask6 {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes6 .window6 {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxes6 #submit6 {
   width:368px; 
  height:161px;
  padding:10px;
  background-color:#ffffff;
}
#done6 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#close6 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes .window {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxes #submit {
   width:300px; 
  height:150px;
  padding:10px;
  background-color:#ffffff;
}
#done {
border:0 none;
cursor:pointer;
height:50px;
margin:0;
padding:0;
}
#close {
border:0 none;
cursor:pointer;
height:50px;
margin:0;
padding:0;
}
</style>
<?php if($type == 'logout') : ?>
<form action="index.php" method="post" name="signoutform" id="form-login" >
      <div id="welocme">
<?php if ($params->get('greeting')) : ?>
	
	<?php if ($params->get('name')) : {
		echo JText::sprintf( 'HINAME', $user->get('name') );
	} else : {
echo  'Hi '.$user->get('name').' '.$user->get('lastname').'!'; //		
//echo JText::sprintf( 'HINAME', $user->get('name').'&nbsp;'.$user->get('lastname') );
	} endif; ?>
	
	
<?php endif; ?>
<?php //print_r($_REQUEST); ?>
	<img align="absbottom" src="templates/camassistant_inner/images/blue-small.gif" alt="arrow_image">
		<!--<input type="submit" name="Submit"  value="<?php echo JText::_( 'Sign Out'); ?>" />
-->	
<?php if(($_REQUEST['task']=='rfpform')||($_REQUEST['task']=='editrfp'))	{ ?>
	<a href="#"  style="border:0;" id="signout" >Sign Out</a>
	<?php } else if ($_REQUEST['task']=='vendor_proposal_preview'){ ?>
	<a href="#"  style="border:0;" id="signout1" >Sign Out</a>
	<?php } else if ($_REQUEST['task']=='vendor_compliance_docs'){ ?>
	<a href="#"  style="border:0;" id="signout2" >Sign Out</a>
	<?php } else { ?>
	<a href="#" onclick="document.signoutform.submit();"  style="border:0;">Sign Out</a>
	<?php } ?>
</div>


	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<div id="boxes5">		
<div id="submit5" class="window5" style="border:4px solid #8FD800; position:fixed;">		
<form name="edit" id="edit" method="post">
<div style="padding-top:10px; text-align:center"><font color="gray">Are you SURE you want to leave the RFP and<br /> lose your current work?</font>
</div>

<div style="padding-top:20px; text-align:center; "><table style="padding-left:27px;"><tr><td>
<div id="close5" name="close5" value="Cancel" style="font-weight:bold;"><img src="templates/camassistant/images/NOshort.gif" /></div></td><td style="padding-left:4px;">
<div id="done5" name="done5" value="Ok" style="font-weight:bold;"><img src="templates/camassistant/images/YESshort.gif" /></div><div class="clear"></div></td></tr></table></div>
<?php /*?><div style="padding-top:20px; text-align:center;">
<div id="done5" name="done5" value="Ok"><img src="templates/camassistant/images/yes.gif" /></div>
<div id="close5" name="close5" value="Cancel"><img src="templates/camassistant/images/No.gif" /></div></div><?php */?>
</form>
</div>
  <div id="mask5"></div>
</div>
<div id="boxes7">		
<div id="submit7" class="window7" style="border:4px solid #8FD800; position:fixed;">		
<form name="edit" id="edit" method="post">
<div style="padding-top:10px; text-align:center"><font color="gray">Are you sure you want to leave Compliance Documents and lose any changes you just made?</font>
</div>

<div style="padding-top:20px; text-align:center; "><table style="padding-left:27px;"><tr><td>
<div id="close7" name="close7" value="Cancel" style="font-weight:bold;"><img src="templates/camassistant/images/NOshort.gif" /></div></td><td style="padding-left:4px;">
<div id="done7" name="done7" value="Ok" style="font-weight:bold;"><img src="templates/camassistant/images/YESshort.gif" /></div><div class="clear"></div></td></tr></table></div>
<?php /*?><div style="padding-top:20px; text-align:center;">
<div id="done5" name="done5" value="Ok"><img src="templates/camassistant/images/yes.gif" /></div>
<div id="close5" name="close5" value="Cancel"><img src="templates/camassistant/images/No.gif" /></div></div><?php */?>
</form>
</div>
  <div id="mask7"></div>
</div>

<div id="boxes6">		
<div id="submit6" class="window6" style="border:4px solid #8FD800; position:fixed; color:gray;">		
<form name="edit" id="edit" method="post">
<div style="padding-top:10px; text-align:center">You have not completed your submission of this proposal. You must click "Submit Proposal" at the bottom of this page to verify that you have reviewed and would like to submit your proposal. Are you sure you want to leave this page?
</div>
<div style="padding-top:20px; text-align:center;"><table style="padding-left:43px;"><tr><td style="padding-left:20px;">
<div id="close6" name="close6" value="Cancel" style="font-weight:bold;"><img src="templates/camassistant/images/No.gif" /></div><div class="clear"></div></td>
<td>
<div id="done6" name="done6" value="Ok" style="font-weight:bold;"><img src="templates/camassistant/images/yes.gif" /></div></td>
</tr></table></div>
</form>
</div>
  <div id="mask6"></div>
</div>

<?php else : ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID ' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var modlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif; ?>
<div class="left-pan login-pan">
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login">
	<?php echo $params->get('pretext'); ?>
	
	
		  <input id="modlgn_username" type="text" name="username" alt="username"  tabindex="1" placeholder="E-Mail" onclick="if(this.placeholder == 'E-Mail') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='E-Mail';" />
		  	<input id="modlgn_passwd" type="password" name="passwd" alt="password"  tabindex="2" placeholder="Password" onclick="if(this.placeholder == 'Password') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='Password';" onfocus="this.placeholder=''"/>
       <?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
	   <div><input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" /><label>Remember Me</label>
	   <?php endif; ?>
	    &nbsp;&nbsp;&nbsp;  <a id="forgot" href="index.php?option=com_user&view=reset&Itemid=137">Forgot your password?</a></div>
		
 <div class="clear"></div>
<div class="login"> <button type="submit" id="logibtn" name="submit" tabindex="4"><img src="templates/camassistant/images/login-button.png" /></button></div>
<div class="or-bg"></div>
    <?php
	if($_GET['return']){
	$_SESSION['return'] = $_GET['return'];
	}
	?>
    <input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
	<?php echo $params->get('posttext'); ?>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />


	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div class="or-bg"></div>
<div class="get-started">Get started as a <a href="index.php?option=com_camassistant&controller=propertymanager&view=propertymanager&Itemid=57">new manager</a> or <a href="index.php?option=com_camassistant&controller=vendorsignup&task=vendorsignup_p1&Itemid=66">new vendor!</a></div>
</div>
<div id="boxes">		
<div id="submit" class="window">
<form name="logins" id="logins" method="post" action="">
<div style="padding-top:40px; text-align:center"><font color="#21314D">Do you Agree to the&nbsp;</font><a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113" target="_blank"><font color="#7AB800">Terms & Conditions</font><font color="#7ab800">?</font></a></div>
<div style="padding-top:20px; text-align:center;">
<button id="close" name="close" value="Cancel"><img src="templates/camassistant/images/No.gif" /></button>
<button id="done" name="done" value="Ok"><img src="templates/camassistant/images/yes.gif" /></button></div>


<input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
<input type="hidden" name="username" value="" />
<input style="display:none;" type="password" name="passwd" value="" />
<input type="hidden" name="option" value="com_user" />
<input type="hidden" name="task" value="login" />

<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
  <div id="mask"></div>

</div>
 
<?php endif; ?>