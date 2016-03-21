$(function(){
//================================================//
// GGS Scroll In Effect
// Author: Xandernator
// 9/1/14
//
// Init this module w/ app.scrollinInit(['footer'], 200);
// or app.scrollinInit();
//
// Next step: write handlers for upward scrolling 
// to re-init effect
//================================================//




// Accepts array of element strings or 
// defaults to .scrollin class as a list 
// of elements to apply effect to
app.scrollinInit = function(elems,offsetDefault){

	var checkForVisible;
	var scrollGo 	= true;
	var elements 	= [];
	var scrollOnce 	= true;

	//Offset is how far from viewport 
	//bottom to begin animation
	var offset 	= 30;




	//Check if any arguments were provided
	if(arguments.length == 0){
		elements.push('.scrollin');

	}else{

		//Check if an offset was provided
		if(offsetDefault !== undefined){
			offset = offsetDefault;
		}

		//Check if any elements were added to function options
		if(elems !== undefined){
			for(var i=0;i<elems.length;i++){
				elements.push(elems[i]);
			}

			elements.push('.scrollin');
		}else{
			//default to scrollin class
			elements.push('.scrollin');
		}
		
	}

	//init plugin
	$('body').addClass('scrollin-init');

	//init invisible
	for(var i=0;i<elements.length;i++){
		jQuery(elements[i]).each(function(){$(this).addClass("scrollin-notVisible");});
	}

	//Run default
	checkVisibilityDefault();

	//Attach to scroll
	jQuery(window).scroll( function() { 
		scrollTimer(); 

		//Detect first scroll to remove init
		if(scrollOnce){
			$('body').removeClass('scrollin-init');
			scrollOnce = false;
		}
	});


	



	//Run handlers
	function checkVisibilityDefault() {

		//loop through elements and attach handler
		for(var i=0;i<elements.length;i++){
			jQuery(elements[i]).each(function() {isVisibleOnce(this);});
		}
	}





	function scrollMgr() {
		
		if(!scrollGo)
		{
			checkVisibilityDefault();
			scrollGo = true;
		}
	}





	function scrollTimer() {
		if(scrollGo)
		{
			scrollGo = false;
		}
	}





	function checkElemsVisibility(elem){
		if(isElemScrolledIntoView(jQuery(elem))) {
	        jQuery(elem).removeClass("scrollin-notVisible");
	    } else
	    {
	      jQuery(elem).addClass("scrollin-notVisible");
	    }
	}





	function isVisible(elem){
				
		if(isElemScrolledIntoView(jQuery(elem))) {
		    jQuery(elem).removeClass("scrollin-notVisible");
			jQuery(elem).addClass("scrollin-visible");
		} else
		{
		  jQuery(elem).addClass("scrollin-notVisible");
		  jQuery(elem).removeClass("scrollin-visible");
		}
	}





	function isVisibleOnce(elem)
	{
		
		if(isElemScrolledIntoView(jQuery(elem), offset)) {
		    jQuery(elem).removeClass("scrollin-notVisible");
			jQuery(elem).addClass("scrollin-visible");
		} 
	}





	function isElemScrolledIntoView(elem) {
		
	    var docViewTop = jQuery(window).scrollTop();
	    var docViewBottom = docViewTop + jQuery(window).height() - offset;
	    var elemTop = jQuery(elem).offset().top;
	    var elemBottom = elemTop + jQuery(elem).height();
	    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
	}





	   setInterval(scrollMgr, 33);
	   
	   jQuery(window).resize( function() { scrollTimer(); });
	   //jQuery(window).load( function() { scrollTimer(); });

};//scrollin.init


});