<?php 
$country = '';
$IP = $_SERVER['REMOTE_ADDR'];
if (!empty($IP)) {
   $country = trim(file_get_contents("http://ipinfo.io/{$IP}/country"));
}
$allowed = array(
'CA',
'US',
'IN',
);
if(!in_array($country,$allowed)) { echo "<div class='noentry_country'><img src='templates/camassistant/images/myvendorcenter.gif'><br /><span>MyVendorCenter is currently available in the United States and Canada only. <br />Please email <a href='mailto:support@myvendorcenter.com'>support@myvendorcenter.com</a> <br />if you're interested in finding out when our program will be available in your country.</span></div>"; die();}

/**



 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.



 * @license		GNU/GPL, see LICENSE.php



 * Joomla! is free software. This version may have been modified pursuant



 * to the GNU General Public License, and as distributed it includes or



 * is derivative of works licensed under the GNU General Public License or



 * other free or open source software licenses.



 * See COPYRIGHT.php for copyright notices and details.



 */



// no direct access



JHTML::_('behavior.modal');



defined( '_JEXEC' ) or die( 'Restricted access' );



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >



<head>

<style>
.noentry_country {
  margin: 0 auto;
  position: absolute;
  text-align: center;
  top: 100px;
  width: 100%;
  font-family:Arial, Helvetica, sans-serif;
}
.noentry_country span {
  display: block;
  margin-top: 20px;
  font-family:Arial;
}
.noentry_country span a {
  text-decoration: none;
  font-family:Arial;
}
.noentry_country span a:hover {
  text-decoration: underline;
  font-family:Arial;
}
</style>

<jdoc:include type="head" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/menu.css" type="text/css" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/stylesheet.css" type="text/css" />



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/camassistant/css/style.css" type="text/css" />


<link rel="stylesheet" href="<?php echo $this->baseurl ?>/assets/css/style.css" type="text/css" />


<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/camassistant/js/jquery-latest.js"></script>



<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/camassistant/js/jquery.js"></script>





<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/camassistant/js/core.js"></script>

<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/camassistant/js/uispinner.js"></script>

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/system/css/modal.css" type="text/css" />



  <script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/modal.js"></script>


<script type="text/javascript" src="<?php echo $this->baseurl ?>/assets/js/app.js"></script>

<script type="text/javascript" src="<?php echo $this->baseurl ?>/assets/js/main.js"></script>


 <script type="text/JavaScript">



<!--



function MM_preloadImages() { //v3.0



  if (document.images)



    {



      preload_image = new Image(25,25);



      preload_image.src="";



    }



}



//-->



</script>



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


</head>



<body onLoad="MM_preloadImages()">



<div id="cam_bg_index">



  <!--sof index Banner BG -->



  <div id="banner_bg_index">



    <table width="100%" cellspacing="0" cellpadding="0">



      <tbody>



        <tr>



          <td background="templates/camassistant/images/camsignup2_bg_articles.gif" style="height:38px;">&nbsp;</td>



          <td background="templates/camassistant/images/camsignup2_bg_articles.gif" style="height:38px;">&nbsp;</td>



        </tr>



      </tbody>



    </table>



    <div class="clear"></div>



  </div>



  <!--eof index Banner BG -->



  <div class="clear"></div>



</div>



<div id="wrapper">



<!-- sof header -->



  <div id="header">



  



<div id="logo">



		  		<?php







		$user =& JFactory::getUser();



		if($user->user_type == 13 && $_REQUEST['view'] == 'frontpage') {



		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';



		$redirection = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';



		}
		
		else if($user->user_type == 16 && $_REQUEST['view'] == 'frontpage') {



		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';



		$redirection = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';



		}







		else if($user->user_type == 11 && $_REQUEST['view'] == 'frontpage') {



		$link = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';



		$redirection = 'index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112';



		}







		else if($user->user_type == 12 && $_REQUEST['view'] == 'frontpage') {



		$link = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';



		$redirection = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=128';



		}



		else {



		$link = 'index.php';



		}



		?>



        <?php if($redirection)



		header( "Location: $redirection" ) ;







?>			<a href="<?php echo $link;?>">



				<img src="<?php echo $this->baseurl ?>/templates/camassistant/images/myvendorcenter.gif" alt="CAMassistant.com - we do your bidding" />



			</a>



		</div>



   <div id="supportcallnumber">Call 1-800-985-9243</div>



  </div>



  <div id="navbar">



    <div id="navigation">



<jdoc:include type="modules" name="menu" />



</div>



<div id="fontsize"><jdoc:include type="modules" name="size_main" /></div>



<div class="clear"></div>



  </div>



</div>



<div class="clear"></div>



<div id="bg-wrap" class="parallax">


<div class="fakeBG">
    <div class="slide-imgs2">
        <div class="slide active" style="background-image: url('templates/camassistant/images/front-bg_mini.jpg');"></div>
        <div class="slide" style="background-image: url('templates/camassistant/images/slide2_s.jpg');"></div>
        <div class="slide" style="background-image: url('templates/camassistant/images/slide3_s.jpg');"></div>
    </div>
    <script type="text/javascript">
        var hoverTimeout2 = false;
        function nextSlide2()
        {
            if(hoverTimeout2)
            {
                hoverTimeout2 = false;
                return;
            }
            jQuery(".slide-imgs2 .slide").removeClass("previous");
            jQuery(".slide-imgs2 .slide.active").addClass("previous");
            var idx2 = jQuery(".slide-imgs2 .slide").index(jQuery(".slide.active")) + 1;
            jQuery(".slide-imgs2 .slide").removeClass("active");
            if(idx2 >= jQuery(".slide-imgs2 .slide").length)
            {
                jQuery(".slide-imgs2 .slide").eq(0).addClass("active");
            }
            else
            {
                jQuery(".slide-imgs2 .slide").eq(idx2).addClass("active");
            }
        }
        setInterval(nextSlide2, 8000);
    </script>
</div>


<div id="wrapper">



<div id="container">



<div class="frosted parallax"></div>



    <div id="cont-top">



       <jdoc:include type="modules" name="login" />



         <a href="index.php?option=com_contact&view=demo&Itemid=250">
		 <div class="video right-pan"><img src="templates/camassistant/images/video_new.jpg" alt="" />
		 <span class="activedemourl">Request a Demo</span>
		 </div>
		 
		 </a>

		 

      <div class="clear"></div>



    </div>



	



	



	



    <div class="clear"></div>



     <jdoc:include type="modules" name="customslide" />











<script type="text/javascript">







var hoverTimeout = false;







jQuery(".spec li").hover(function(e) {



hoverTimeout = true;



jQuery(".spec li").removeClass("mark");



jQuery(this).addClass("mark");



var idx = jQuery(".spec li").index(this);



jQuery(".left-pan .slide-imgs img").removeClass("mark");



jQuery(".left-pan .slide-imgs img").eq(idx).addClass("mark");



});











function nextSlide()



{



if(hoverTimeout)



{



hoverTimeout = false;



return;



}



var idx = jQuery(".spec li").index(jQuery("li.mark")) + 1;



jQuery(".spec li").removeClass("mark");



jQuery(".left-pan .slide-imgs img").removeClass("mark");



if(idx >= jQuery(".spec li").length)



{



jQuery(".left-pan .slide-imgs img").eq(0).addClass("mark");



jQuery(".spec li").eq(0).addClass("mark");



}



else



{



jQuery(".left-pan .slide-imgs img").eq(idx).addClass("mark");



jQuery(".spec li").eq(idx).addClass("mark");



}



}











setInterval(nextSlide, 4000);







</script>



	  



    <div class="clear"></div>



  </div>



<div class="clear"></div>



<div>



<jdoc:include type="message" />





<jdoc:include type="component" />





</div>



  <div class="clear"></div>







</div>



</div>



</div>



<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-44486501-1', 'myvendorcenter.com');

  ga('send', 'pageview');



</script>

<script type='text/javascript' src="<?php echo $this->baseurl ?>/templates/camassistant_left/js/main.js"></script>

</body>



</html>