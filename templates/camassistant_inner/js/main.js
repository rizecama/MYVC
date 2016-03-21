//====================================================//
//                    Added 10/9/14
// 					  Edited 10/29/14
//   				  Written by Adam
//
// Include this script:
// <script type='text/javascript' src="<?php echo $this->baseurl ?>/templates/camassistant_left/js/main.js"></script>
// in the <head> HERE: templates/camassistant_left/index.php
//
//====================================================//
if(typeof(jQuery) !== 'undefined'){

	jQuery(function(){
	
		var details = jQuery(document).find(".prop_detailsclosed, .awardprop_details, .prop_details");
	
		details.each(function(){
			//.addednumclosed li:eq(2)
			jQuery(this).on('click', 'li .downloadproposals', function(e){
																	   
				console.log(jQuery(this), "link");
				
				var modal = '<div id="js-modal" class="ag-modal">'
							+'<div class="ag-modal-inner">'
								+'<p id="js-message">Please wait while your download is built.</p>'
								+'<p id="js-message" class="ag-sub-message">This could take up to a minute to begin. Please don\'t refresh your browser until the download has finished.</p>'
								+'<img src="templates/camassistant_left/images/16-04-11final_loading_big.gif" alt="Loading gif"/>'	
							+'</div><!-- /.modal-inner-->'
						+'<style>'
						+'.ag-modal{'
							+'position: fixed;'
							//+'background: rgba(0,0,0,0.5);'
							+'top: 0;'
							+'right: 0;'
							+'bottom: 0;'
							+'left: 0;'
							//+'display: none;'
						+'}'
						+'.ag-modal-inner{'
							+'width: 400px;'
							+'margin-left: auto;'
							+'margin-right: auto;'
							+'margin-top: 15%;'
							+'background: #fff;'
							+'border: 6px solid #609e00;'
							+'height: 200px;'
							+'position: relative;'
							+'padding: 5%;'
							+'-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.75);'
							+'-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.75);'
							+'box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.75);'
						+'}'
						+'.ag-modal-inner h1{'
							+'font-size: 3.4em;'
							+'text-align: center;'
							+'line-height: 2.5;'
							+'font-weight: 100;'
						+'}'
				
						+'.ag-modal-inner p{'
							+'color: #6C636C;'
							+'text-align: center;'
							+'font-size: 21px;'
							+'font-weight: 100;'
						+'}'
						+'.ag-modal-inner p.ag-sub-message{'
							+'color: #6C636C;'
							+'font-size: 14px;'
							+'margin-top: 15px;'
						+'}'
						+'.ag-modal-inner img{'
							+'text-align: center;'
							+'width: 138px;'
							+'margin: 15% auto;'
							+'display: block;'
						+'}'
						+'</style>'
						+'</div><!-- /.modal -->';
						
				//Only run on the Download links	
				if(jQuery(this).find('a').text('DOWNLOAD PROPOSALS')){
					jQuery('body').append(modal);
				
					setTimeout(function(){
						var element = document.getElementById("js-modal");
								element.parentNode.removeChild(element);
					},18000);
				}	
				
			
			});//click	
		});//details each
	
	});//jQuery
}//if