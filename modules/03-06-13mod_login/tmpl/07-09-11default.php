<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
 ?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin1/css/jquery1.css" />		
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
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
  height:150px;
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
height:30px;
margin:0;
padding:0;
}
#close {
border:0 none;
cursor:pointer;
height:30px;
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
	<?php } else { ?>
	<a href="#" onclick="document.signoutform.submit();"  style="border:0;">Sign Out</a>
	<?php } ?>
</div>


	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<div id="boxes5">		
<div id="submit5" class="window5">		
<form name="edit" id="edit" method="post">
<div style="padding-top:10px; text-align:center"><font color="#0000ce">Are you SURE you want to leave the RFP and lose your current work?</font>
</div>

<div style="padding-top:20px; text-align:center;"><table><tr><td>
<div id="done5" name="done5" value="Ok" style="font-weight:bold;">YES, I want to leave</div></td><td>
<div id="close5" name="close5" value="Cancel" style="font-weight:bold;">NO, I want to continue with my RFP</div><div class="clear"></div></td></tr></table></div>
<?php /*?><div style="padding-top:20px; text-align:center;">
<div id="done5" name="done5" value="Ok"><img src="templates/camassistant/images/yes.gif" /></div>
<div id="close5" name="close5" value="Cancel"><img src="templates/camassistant/images/No.gif" /></div></div><?php */?>
</form>
</div>
  <div id="mask5"></div>
</div>
<?php else : ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var modlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif; ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login">
	<?php echo $params->get('pretext'); ?>
	
	<div id="signin_button"> 
        <div class="clear"></div>
      </div><div id="signin"><div id="signin_user">
          <label></label>
		  <input id="modlgn_username" type="text" style="width:161px;" name="username" alt="username"  tabindex="1" value="Username" onclick="if(this.value == 'Username') this.value='';" onblur="if(this.value == '') this.value ='Username';" />
         
        </div>
		<div id="signin_password">
          <label></label>
		  	<input id="modlgn_passwd" type="password" name="passwd" style="width:111px"  alt="password"  tabindex="2" value="Password" onclick="if(this.value == 'Password') this.value='';" onblur="if(this.value == '') this.value ='Password';" onfocus="this.value=''"/>
        </div>
		<span>
		 <!--	<input type="submit" name="submit" id="logibtn" src="templates/camassistant/images/go.gif"/>-->
		 <button type="submit" id="logibtn" name="submit" tabindex="4"><img src="templates/camassistant/images/go.gif" /></button>
		 
			<!--<a href="javascript: submitform()"><img src="templates/camassistant/images/go.gif" alt="go" border="0" /></a>-->
</span>
        <div class="clear"></div>
        
        <div id="forgot"><input type="checkbox" name="terms" id="terms" style="padding:0px; margin:0px; width:auto; margin-right:5px;" tabindex="3" />Agree to <a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113">Terms & Conditions</a>
        &nbsp;&nbsp;&nbsp;Forgot your password? <a href="index.php?option=com_user&view=reset&Itemid=137">Click here.</a></div>
	<?php /*?><fieldset class="input">
	<p id="form-login-username">
		<label for="modlgn_username"><?php echo JText::_('Username') ?></label><br />
		<input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" />
		<label for="modlgn_passwd"><?php echo JText::_('Password') ?></label><br />
		<input id="modlgn_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" />
	</p>
	<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
	<p id="form-login-remember">
		<label for="modlgn_remember"><?php echo JText::_('Remember me') ?></label>
		<input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" />
	</p>
	<?php endif; ?>
	<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
	</fieldset>
	<ul>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<?php
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=register' ); ?>">
				<?php echo JText::_('REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul><?php */?>
    <?php
	if($_GET['return']){
	$_SESSION['return'] = $_GET['return'];
	}
	?>
    <input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
	<?php echo $params->get('posttext'); ?>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />


	</div>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div id="boxes">		
<div id="submit" class="window">
<form name="logins" id="logins" method="post" action="">
<div style="padding-top:40px; text-align:center"><font color="#0000ce">Do you Agree to the</font><a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113" target="_blank"><font color="#00b050">Terms & Conditions</font><font color="#0000ce">?</font></a></div>
<div style="padding-top:20px; text-align:center;">
<button id="done" name="done" value="Ok"><img src="templates/camassistant/images/yes.gif" /></button>
<button id="close" name="close" value="Cancel"><img src="templates/camassistant/images/No.gif" /></button></div>


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