<?php
$partner = (isset($_GET["partner"]) ? $_GET["partner"] : "mvc");
$image = "";
$partner_name = "";
$preferred_only = false;
$referral_code = "";
$account_type = "Basic Membership + Compliance Status";


if($partner == "mvc") {
	header('Location: '."/index.php?option=com_camassistant&controller=vendorsignup&task=vendorsignup_p1&Itemid=66");
}


if($partner == "BellAnderson")
{
	$image = "bellanderson.png";
	$partner_name = "Bell Anderson";
	$account_type = "Basic Membership + Compliance Status";
}
elseif($partner == "amg")
{
	$image = "amg.jpg";
	$partner_name = "AMG";
	$account_type = "Basic Membership + Compliance Status";
}
elseif($partner == "grs")
{
	$image = "grs.jpg";
	$partner_name = "GRS";
	$account_type = "Basic Membership + Compliance Status";
}
elseif($partner == "apm")
{
	$image = "APMLogo.jpg";
	$partner_name = "APM";
	$account_type = "Basic Membership + Compliance Status";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index, follow" />
		<meta name="keywords" content="vendor compliance, screening, management, project bids, RFP, HOA, condo, vendor list, contractor, service provider, bid, compare contractors, preferred vendors, project management" />
		<meta name="description" content="Vendor compliance, management and project bidding software for property managers, community associations, HOAs, and condo managers. Online contractor insurance verification, preferred vendor management and project management." />
		<meta name="generator" content="" />
		<title>MyVendorCenter.com | Vendor compliance, management and bidding suite. Vendor screening and project management in one place. Bid jobs &amp; build your prescreened vendor list.</title>
		<link href="/index.php?format=feed&amp;type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
		<link href="/index.php?format=feed&amp;type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
		<link href="/templates/camassistant/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<link rel="stylesheet" href="/plugins/system/rokbox/themes/light/rokbox-style.css" type="text/css" />
		<link rel="stylesheet" href="/media/system/css/modal.css" type="text/css" />
		<script type="text/javascript" src="/media/system/js/mootools.js"></script>
		<script type="text/javascript" src="/media/system/js/caption.js"></script>
		<script type="text/javascript" src="/plugins/system/rokbox/rokbox.js"></script>
		<script type="text/javascript" src="/plugins/system/rokbox/themes/light/rokbox-config.js"></script>
		<script type="text/javascript" src="/media/system/js/modal.js"></script>
		<script type="text/javascript" src="/templates/camassistant/js/jquery-latest.js"></script>
		<script type="text/javascript" src="/templates/camassistant/js/jquery.js"></script>
		<script type="text/javascript">
		var rokboxPath = '/plugins/system/rokbox/';

				window.addEvent('domready', function() {

					SqueezeBox.initialize({});

					$$('a.modal').each(function(el) {
						el.addEvent('click', function(e) {
							new Event(e).stop();
							SqueezeBox.fromElement(el);
						});
					});
				});
		  </script>
		<link rel="stylesheet" href="/templates/camassistant/css/menu.css" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/css/stylesheet.css" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/css/style.css" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/js/uispinner.js" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/js/jquery-latest.js" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/js/jquery.js" type="text/css" />
		<link rel="stylesheet" href="/templates/camassistant/js/core.js" type="text/css" />
		<link rel="stylesheet" href="/media/system/css/modal.css" type="text/css" />
		<link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
		<script type="text/javascript" src="/media/system/js/modal.js"></script>
		<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
		$.src='//v2.zopim.com/?1RqQOqVdj61nnN81694Osoej0wUVYcKZ';z.t=+new Date;$.
		type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
		</script>
		<!-- SSL Script Below -->
		<script language="javascript" type="text/javascript">
		//<![CDATA[
		var tl_loc0=(window.location.protocol == "https:")? "https://secure.comodo.net/trustlogo/javascript/trustlogo.js" :
		"http://www.trustlogo.com/trustlogo/javascript/trustlogo.js";
		document.writeln('<scr' + 'ipt language="JavaScript" src="'+tl_loc0+'" type="text\/javascript">' + '<\/scr' + 'ipt>');
		//]]>
		</script>
		<script type='text/javascript' src="/templates/camassistant/js/main.js"></script>
		<script type='text/javascript' src="/assets/js/app.js"></script>
		<script type='text/javascript' src="/assets/js/main.js"></script>
		<script type='text/javascript'>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-44486501-1']);
		  _gaq.push(['_setCustomVar', 1, 'Page creation time and ram', '5', 3]);
		  _gaq.push(['_setCustomVar', 2, 'Logged-in user', 'anonymous', 3]);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head>
	<body>
		<div class="frosted-bg" id="signup-landing">
		<div class="signup-login-panel wrapper">
			<div class="panel white-arrow half">
				<p style="text-align:center;"><img src="/assets/images/<?php echo $image; ?>" /></p>
				<p>We use <b>MyVendorCenter</b> as our Vendor and Project Management system. To maintain compliance and become available to all of our managers, register with the following account type: <b><?php echo $account_type; ?></b></p>
				<a class="button block" target="_blank" href="/index.php?option=com_camassistant&controller=vendorsignup&task=vendorsignup_p1&Itemid=66">Get Started</a>
				<img class="side-arrow" src="/assets/images/white-arrow.png" />
			</div>
			<div class="panel half login-pan">
				<h4>Already Signed Up?</h4>
				<form action="/index.php" method="post" name="login" id="form-login">	
					<input id="modlgn_username" type="text" name="username" alt="username" tabindex="1" placeholder="E-Mail" onclick="if(this.placeholder == 'E-Mail') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='E-Mail';">
					<input id="modlgn_passwd" type="password" name="passwd" alt="password" tabindex="2" placeholder="Password" onclick="if(this.placeholder == 'Password') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='Password';" onfocus="this.placeholder=''">
					<div><input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me"><label>Remember Me</label>
					<a id="forgot" href="/index.php?option=com_user&amp;view=reset&amp;Itemid=137">Forgot your password?</a></div>
					<div class="clear"></div>
					<div class="login"> <button type="submit" name="submit" tabindex="4" class="button block">Log in</button></div>
					<input type="hidden" name="return" value="">
					<input type="hidden" name="option" value="com_user">
					<input type="hidden" name="task" value="login">
					<input type="hidden" name="09c9edd5490ea7b793066e3af9cd7d8a" value="1">
				</form>
			</div>
		</div>
		</div>
		<div id="wrapper">
				<div id="footer" class="no-nav">


				    <a href="/" class="footer-logo"><img src="https://myvendorcenter.com/live/templates/camassistant/images/myvendorcenter.gif" width="213" height="58" /></a>
				 <div id="coright" style="text-align: center; padding-left: 0px;" dir="ltr">
				<div style="float: left;"><img src="/images/stories/tl_white.gif" alt=""></div>
				<a href="http://www.caionline.org/" target="_blank"><img style="float: right;" src="/images/stories/cai_small_color_on_white.gif" alt="CAI-Community_Associations_Institute-Multi-chapter_Member" width="125" height="65"></a><a class="modal" style="text-decoration: none;" title="Click here" href="/index2.php?option=com_content&amp;view=article&amp;id=52&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 655, y: 530}}">Privacy Policy</a> <span>|</span> <a class="modal" style="text-decoration: none;" title="Click here" href="/index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}">Terms of Service and User Agreement </a><br>Powered by HOA Assistant's patent pending processes and tools.<br>© 2010-2015 HOA Assistant, LLC<br>Offices in Wellington and Tampa, FL&nbsp; |&nbsp; Tel: 1.800.985.9243<br><a href="http://www.greengroupstudio.com/" target="_blank">Web Development by Green Group Studio.<br></a></div>

				 </div>
			 </div>
	</body>
</html>