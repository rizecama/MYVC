<!DOCTYPE html>
<html class="app view-login">
	
    <?php require_once ( 'head.php' ); ?>
    
    
	<body>
		<div class="frosted-bg" id="app">
<?php require_once ( 'loading.php' ); ?>
			<div class="signup-login-panel wrapper">
				<div class="panel transparent login-pan">
					<p><img src="/assets/images/transparent-logo-white-green.png" /><br><br></p>

					<form action="home.php" method="post" name="login" id="form-login">	
						<input id="modlgn_username" type="text" name="username" alt="username" tabindex="1" placeholder="E-Mail" onclick="if(this.placeholder == 'E-Mail') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='E-Mail';">
						<input id="modlgn_passwd" type="password" name="passwd" alt="password" tabindex="2" placeholder="Password" onclick="if(this.placeholder == 'Password') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='Password';" onfocus="this.placeholder=''">
						<div><input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me"><label>Remember Me</label>
						<a id="forgot" target="_blank" href="/index.php?option=com_user&amp;view=reset&amp;Itemid=137">Forgot your password?</a></div>
						<div class="clear"></div>
						<div class="login"> <button type="submit" name="submit" tabindex="4" class="button large block">Log in</button></div>
						<input type="hidden" name="return" value="">
						<input type="hidden" name="option" value="com_user">
						<input type="hidden" name="task" value="login">
						<input type="hidden" name="09c9edd5490ea7b793066e3af9cd7d8a" value="1">
					</form>
					<p><a class="center-text login-no-account" href="#">Don't have an account?</a></p>
				</div>
			</div>


			<div class="overlay">
				<div class="overlay-click"></div>
				<div class="popup panel save-vendor no-borders">
					<p class="item">Would you like to mark this vendor as a Preferred Vendor?</p>
					<div class="popup-buttons item"><a class="cancel close-overlay">Yes</a><a class="close-overlay">No</a></div>
				</div>
				<div class="popup panel login-no-account no-borders">
					<p class="item">If you don't already have an account, you can sign up at MyVendorCenter.com. Would you to email a link for quick access? </p>
					<div class="popup-buttons item"><a class="cancel close-overlay" href="mailto:?subject=Register at My Vendor Center&body=Sign up for your free account at: http://myvendorcenter.com/managersignup">Set up email</a><a class="close-overlay">Cancel</a></div>
				</div>
			</div>

		</div>
		<script type="text/javascript" src="/assets/js/app.js"></script>
		<script type="text/javascript" src="/assets/js/app/main.js"></script>
	</body>
</html>