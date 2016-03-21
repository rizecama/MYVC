$(function(){
//================================================//
// GGS Slider
// Author: Xandernator
// 9/1/14
//
// Init this module w/ app.ggsSlider();
// 
// baseElem : ('container selector'))
// slideElems : ('selector of images/slides')
// bubbleElems : ('selector for bubble element classes')
// applyHidden : Boolean
//================================================//

app.ggsSlider = function(baseElem, slideElems, bubbleElems){
	this.slider = jQuery(baseElem);
	this.slides = jQuery(baseElem + " " + slideElems).toArray();	
	if(bubbleElems)
	this.bubbles = jQuery(baseElem).find(bubbleElems);
	else
	this.bubbles = null;
	
	var thisSlider = this;
	
	this.currentSlide = 0;
	
	this.autoAdvance = null;
	
	this.advanceInterval = 8000;



	thisSlider.resetTimer = function(){
		clearInterval(thisSlider.autoAdvance);
		thisSlider.autoAdvance = setInterval(function(e){thisSlider.nextSlide();}, thisSlider.advanceInterval);
	}
	
	
	this.init = _init;
	function _init()
	{
		if(this.bubbles)
		jQuery(this.bubbles).click(
            function(e){
			thisSlider.goToSlide( jQuery(thisSlider.bubbles).index(this) )
			}
		);
	}
	
	this.test = _test;
	function _test()
	{
		return this.slides;	
	}
	
	this.goToSlide = _goToSlide;
	function _goToSlide(slide)
	{
		var Slides = this.slides;
		thisSlider.resetTimer();
		

		if(slide >= Slides.length)
			slide = 0;
			if(slide < 0)
				slide = Slides.length - 1;
			this.currentSlide = slide;
		
		jQuery(Slides).each(function(index, element) {
			//Add index number to slides
			jQuery(this).attr('data-index', index+1);

			jQuery(this).removeClass("ggs-slider-active").removeClass("ggs-slider-left").removeClass("ggs-slider-right").removeClass("ggs-slider-hidden");
			if(index == slide)
				jQuery(this).addClass("ggs-slider-active");
			else if(index == slide - 1 || (index == Slides.length - 1 && slide == 0))
				jQuery(this).addClass("left"); 
			else if(index == slide + 1 || (index == 0 && slide == Slides.length - 1))
				jQuery(this).addClass("ggs-slider-right"); 
			else
				jQuery(this).addClass("ggs-slider-hidden");
		});
		if(this.bubbles)
		jQuery(this.bubbles).each(function(index, element) {
        	jQuery(this).removeClass("ggs-slider-active");
			if(index == slide)
				jQuery(this).addClass("ggs-slider-active");
		
    });
	}
	
	
	this.nextSlide = _nextSlide;
	function _nextSlide()
	{
		this.goToSlide(this.currentSlide + 1);
	}
	
	
	this.previousSlide = _previousSlide;
	function _previousSlide()
	{
		this.goToSlide(this.currentSlide - 1);
	}
	
	




	//Slide page indicators
	//Can be initialized separately
	this.initSlideIndicators = function (baseElem, slideElems){

		//Check for separate initialization
		if(baseElem === undefined && slideElems === undefined){
			var baseElem = app.ggsSlider.slider;
			var slideElems = app.ggsSlider.slides;
		}

		var container = $(document).find(baseElem);
		var slides  = container.find(slideElems);
		var total 	= slides.length;

		//Add element to contain indicators
		container.append('<div class="pager-container"></div>');

		//Create indicators
		for(var i=0;i<total;i++){
			var pager = '<a data-slide="' + (i+1) + '" class="pager-inactive js-page-indicator" href="#"></a>'
			$('.pager-container').append(pager);
		}



		//Detect current slide & set active
		setInterval(function(){
			var num = container.find('.ggs-slider-active').attr('data-index');

			//Reset to inactive
			$('.pager-container').find('.pager-active').each(function(){
				$(this).addClass('pager-inactive').removeClass('pager-active');
			});

			//Set current to active
			$('.pager-container').find('.pager-inactive[data-slide=' + num + ']').addClass('pager-active').removeClass('pager-inactive');
		}, 500);
			


		//Add handlers to skip to slide on indicator click
		//This could use a call to slider library to pause slides or reset timer
		$('.js-page-indicator').each(function(){
			$(this).click(function(e){
				e.preventDefault();

				//Get slidenumber form click
				var slideNum = $(this).attr('data-slide');
					slides.removeClass('ggs-slider-active');
					container.find("> div[data-index='" + slideNum + "']").addClass('ggs-slider-active');
			});
		});
	};//app.initSlideIndicators



	//Initialize Slider
	this.init();
	this.goToSlide(0);
	this.initSlideIndicators();
	
	//thisSlider.resetTimer();
}//app.ggsSlider






});