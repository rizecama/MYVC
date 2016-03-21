//==========================================//
//
//      **** APP object init ****
//
//==========================================//
(function($){

window.APP = {

	getloc : function(){
		var script = document.createElement('script');
		script.setAttribute('src','http://www.geoplugin.net/javascript.gp');
		script.setAttribute('language','Javascript');
		script.setAttribute('type','text/javascript');
		document.head.appendChild(script);


		setTimeout(function(){
			$.ajax({
				url : 'http://jsonip.com',
				type : 'GET',
				datType : 'json',
				success : function(data){

					APP.location = {
						City: geoplugin_city(),
						State: geoplugin_regionName(),
						Area_Code: geoplugin_areaCode(),
						Country_Code: geoplugin_countryCode(),
						Country: geoplugin_countryName(),
						Latitude: geoplugin_latitude(),
						Longitude: geoplugin_longitude(),
						Request_IP: geoplugin_request()
						// Currency: geoplugin_currencyCode(),
						// Currency_Symbol_UTF8: geoplugin_currencySymbol_UTF8(),
					}//location

					//Returns same results as geoplugin.net API. Only comment in if 
					//willing to ask user for their location - it will prompt
				    // navigator.geolocation.getCurrentPosition(function(position){
				    // 	 APP.location.browserLocation = position; 
					   // 	console.log(position, "position");
				    // });
				
					//Fetch further info from Google
					$.ajax({
						url : 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + APP.location.Latitude + ',' + APP.location.Longitude + '&sensor=true',
						type : 'GET',
						datType : 'json',
						success : function(googleJSON){
							APP.location.Address = googleJSON.results[0].formatted_address;
							APP.location.County  = googleJSON.results[2].address_components[0].long_name;
						}
					});//ajax

					APP.location.ip = data.ip;
					APP.location.googleMapLink = 'https://www.google.com.au/maps/preview/@' + APP.location.Latitude + ',' + APP.location.Longitude + ',12z';

				}//success
			});//ajax
		},1000);
	},//getloc




	valid : function(field){
		//=================================//
		// Usage: 
		// APP.valid('#myfield');
		// Dependencies: jquery
		//=================================//
		var field 	= $(field);
		var pattern = '';
		var response = false;

		if(field.attr('type') === 'text'){
			pattern = /^([a-zA-Z]+\s)*[a-zA-Z]+$/;
			response = pattern.test(field.val());
		}else if(field.attr('type') === 'email'){
			pattern = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
			response = pattern.test(field.val());
		}else if(field.attr('type') === 'number'){
			pattern = /^[0-9]$/;
			response = pattern.test(field.val());
		}else if(field.is('textarea')){
			pattern = /^([a-zA-Z]+\s)*[a-zA-Z]+$/;
			response = pattern.test(field.val());
		}

		if(field.is('[required]') && $.trim(field.val()).length === 0){
			response = false;
		}

		return response;
	},//validateField



	iosVH : function(selector,height){
		//=============================//
		// Usage
 		// APP.iosVH('.page',600);
		//
		// Dependencies: jquery
		//
		// Defaults to window height if no height specified
		//=============================//
		var iOS = navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false;
		if(iOS){
		  var h = height ? height : $(window).height();
		  $(selector).css({
		  	"min-height": h + "px"
		  });
		}
	},//iosVH




	ggsSlider : function(baseElem, slideElems, bubbleElems){
		//================================================//
		// GGS Slider
		// Author: Xandernator
		// 9/1/14
		//
		// Init this module w/ APP.ggsSlider();
		// var  ggsSlider1 = new APP.ggsSlider(".view-slideshow .view-content", "> div");
		// ggsSlider1.initSlideIndicators('#banner #block-views-slideshow-block .view-content', '> div');
		//
		// baseElem : ('container selector'))
		// slideElems : ('selector of images/slides')
		// bubbleElems : ('selector for bubble element classes')
		//================================================//

		this.slider = jQuery(baseElem);
		this.slides = jQuery(baseElem + " " + slideElems).toArray();	
		if(bubbleElems)
		this.bubbles = jQuery(baseElem).find(bubbleElems);
		else
		this.bubbles = null;
		
		var thisSlider = this;
		
		this.currentSlide = 0;
		
		this.autoAdvance = null;

		this.doAutoAdvance = false;
		
		this.advanceInterval = 8000;

		this.wrap = false;

		this.extendedLR = true;



		thisSlider.resetTimer = function(){
			if(this.doAutoAdvance) {
				clearInterval(thisSlider.autoAdvance);
				thisSlider.autoAdvance = setInterval(function(e){thisSlider.nextSlide();}, thisSlider.advanceInterval);
			}
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
				else if(index == slide - 1 || (index == Slides.length - 1 && slide == 0 && thisSlider.wrap == true) || (thisSlider.extendedLR && index < slide))
					jQuery(this).addClass("ggs-slider-left"); 
				else if(index == slide + 1 || (index == 0 && slide == Slides.length - 1 && thisSlider.wrap == true) || (thisSlider.extendedLR && index > slide))
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
				var baseElem = APP.ggsSlider.slider;
				var slideElems = APP.ggsSlider.slides;
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
		};//APP.initSlideIndicators



		//Initialize Slider
		this.init();
		this.goToSlide(0);
		this.initSlideIndicators();
		
		//thisSlider.resetTimer();
	},//APP.ggsSlider


	drupalAlerts : function(){

		//=========================================//
		// Alertify standard usage
		// http://www.jqueryrain.com/?BWQoTDhi
		//=========================================//
		// alertify.set({ delay: 1000 });

		//Run with this on page loads: APP.drupalAlerts();
		
		// standard notification
		// setting the wait property to 0 will
		// keep the log message until it's clicked
		//alertify.log("Notification");

		// success notification
		// shorthand for alertify.log("Notification", "success");
		//alertify.success("Success notification");

		// error notification
		// shorthand for alertify.log("Notification", "error");
		//alertify.error("Error notification");

		$(document).find('.messages').each(function(){
			alertify.set({ delay: 3000 });

			if($(this).hasClass('warning')){
				alertify.log($(this).text().split('message')[1]);
			}else if($(this).hasClass('error')){
				alertify.error($(this).text().split('message')[1]);
			}else{
				//is status
				alertify.success($(this).text().split('message')[1]);
			}
		});
	},//drupalAlerts





	pumpHunk : function(url, immediate){
		//=========================================//
		// Hunkify
		//
		// This is an essential method for all web projects ever
		//
		// Usage: APP.pumpHunk("/sites/all/themes/welliotheme/js/libs/fpo.hunk");
		//=========================================//
		var hunkSummoned = false;
		var hunksAddress = url;
		var detectedHunkKeys = [];
		var count = 0;

		if(immediate == true) {
			summonTheHunk();
		}

		function summonTheHunk() {
			if(hunkSummoned == true)
				return false;
			hunkSummoned = true;
			var hunkyCall;
			if (window.XMLHttpRequest) {
				hunkyCall = new XMLHttpRequest();
			}
				
			hunkyCall.onreadystatechange = function() {
				if (hunkyCall.readyState == 4 && hunkyCall.status == 200) {
					var hunkObject = document.createElement("div");
					hunkObject.innerHTML = hunkyCall.responseText;
					document.body.appendChild(hunkObject);
					console.log("You've been HUNK'd!");
				}
			}
			hunkyCall.open("GET",hunksAddress,true);
			hunkyCall.send();
		}
		window.moreHunks = function(){
			var hunkHerd = document.getElementById("hunks");
			var extraHunk = document.createElement("div");
			extraHunk.style.top = (Math.random() * 100) + "%";
			extraHunk.style.left = (Math.random() * 100) + "%";
			hunkHerd.appendChild(extraHunk);

			count ++;

			if(count === 4){
				if($(window).width() < 500)
					window.open("https://www.youtube.com/watch?v=kfVsfOSbJY0", '_blank');
				else
					window.location.href="/assets/static/thatday.htm";
			}
		}
		function hunkDetector() {
			$(document.body).keydown(function (evt) {
				detectedHunkKeys[evt.keyCode] = true;
			});
			$(document.body).keyup(function (evt) {
				if(detectedHunkKeys[16] && detectedHunkKeys[70] && detectedHunkKeys[79] && detectedHunkKeys[80])
					summonTheHunk();
				detectedHunkKeys[evt.keyCode] = false;
			});
		}
		$(function(){hunkDetector();});
	},//pump hunk
	




//This one needs work
// 	rangeSlider : function(th, tr, displayElem){
// 		console.log(th, tr, displayElem);
// 		//=============================//
// 		// Usage
// 		// APP.rangeSlider('#js-range-thumb', '#js-range-track', '#js-percentage');
// 		//
// 		// Dependencies: jquery Mobile
// 		//=============================//
// 		var thumb = $(document).find(th);
// 		var track = $(document).find(tr);

// 		var dragging = true;
// 		$(document).on('vmousedown', th, function(){
			
// 			$('#js-drag-info').fadeOut(1500);

// 			//Set the slider thumb x position
// 			$(document).on('vmousemove', th, function(e){
// 				var range = {
// 					thWidth : thumb.width(),
// 					trLeft 	: track.offset().left,
// 					trWidth : track.width()
// 				};

// 				range.thumb 	= thumb;
// 				range.track 	= track;
// 				range.trRight 	= range.trLeft + range.trWidth;
// 				range.mouseX 	= e.pageX ? e.pageX : e.touches[0].pageX;
// 				range.thLeft	= thumb.offset().left;
// 				range.thRight 	= range.thLeft + range.thWidth;
// 				range.thX		= range.thLeft + (range.thWidth / 2);
// 				var stop = false;

// 				//Normal movement on X
// 				if(stop === false){
// 					range.thumb.offset({'left': range.mouseX - 100});
// 				}

// 				//Perimeter
// 				if(range.mouseX < range.trLeft){
// 					range.thumb.offset({'left': range.trLeft - 100});
// 					stop = true;
// 				}else if(range.mouseX > range.trRight){
// 					range.thumb.offset({'left': range.trRight+27 - (range.thWidth / 2)});
// 					stop = true;	
// 				}

			

// 				APP.guide.Percentage_Powered = (100 - Math.floor(((range.trRight - range.trLeft) - (range.thX - range.trLeft)) / (range.trRight - range.trLeft) * 100));
// 				$(displayElem).text(APP.guide.Percentage_Powered + '%');

// 			});//mousemove

// 		}).bind('vmouseup', function(e){
// console.log(th, tr, displayElem);
// 			$(document).off('vmousemove', thumb);
// 			$('#js-drag-info').fadeIn(1500);

// 		});
// 	},//rangeSlider



	spinner : function(numbersElem, spinnerID){
		//=============================//
		// Usage
		// APP.spinner('#js-acs li', 'acs');
		//=============================//

		//Attach click handler to li items
		$(numbersElem).off('vclick');
		$(document).on('vclick', numbersElem ,function(){

			$(numbersElem).removeClass('highlight');
			$(this).addClass('highlight');

			APP.guide[spinnerID] = $(this).text()*1;
			// console.log(APP, "spinner clicked");
		});

	},//spinner


	mailto : function(url,method,data,cb){
		//Essentially an ajax shorthand
		$.ajax({
			url : url,
			data : data,
			method : method,
			dataType : 'json',
			success : function(response){
				cb(response);
				// console.log(response, "mailer response");
			},
			error : function(data, err, status){
				cb(status);
				// console.log(err, status,"mailer fail response");
			}
		});
	},//mailto





	drupalSearch : function(formSelector, queryInputID){
		//=========================================//
		// Drupal Search Bar Handler
		// Add any form anywhere to trigger a Drupal search
		// On nodes
		//
		// Usage : APP.drupalSearch('#js-header-search', '#search-query');
		//=========================================//

		$(document).on('submit', formSelector, function(e){
			e.preventDefault();

			var query = $(queryInputID).val();
			var url = '/search/node/' + query;

			window.location.href = url;
		});
	}, //drupalSearch



};

//Call method
APP.getloc();


})(jQuery);// function