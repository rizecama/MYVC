/**
 * jeFAQ Pro package
 * @version 1.1
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

function elementvalidate(id)
{
	if(document.getElementById(id).value != '') {
		document.getElementById(id+'-error').innerHTML = '';
	} else {
		document.getElementById(id+'-error').style.color = 'red';
	}

}

function submitbutton(pressbutton)
{
	var condition  = pressbutton;

	// Operation for save & apply...
	if (condition == 'save' || condition == 'apply') {

		var tables       = document.getElementsByTagName('input');
		var toggletables = [];
		for (i in tables) {
			if (tables[i].id) {
				var requ  = tables[i].className;
				var value = document.getElementById(tables[i].id).value;

				// Required Field...
				if(requ == 'required') {
					if (value == '') {
						var inputerror 				= document.getElementById(tables[i].id+'-error');
						inputerror.style.color 		= 'red';
						inputerror.style.fontWeight = 'bold';
						inputerror.innerHTML 		= 'Please Enter The Value';

						return false;
					}
				}
			}
		}

		if ( document.getElementById('controller').value == 'faq' ) {
			// Getting the contents or values from the editor(any editor)..
			var editor = editorContent();
			var text   = editor;

			if (text == '') {
				var txtareaerror 				= document.getElementById('answers-error');
				txtareaerror.style.color 		= 'red';
				txtareaerror.style.fontWeight = 'bold';
				txtareaerror.innerHTML 		= 'Please Enter the Answer(s)';

				return false;
			} else {
				document.getElementById('answers-error').innerHTML = '';
			}
		}

		submitform(pressbutton);
		return true;
	}

	// Operations for except save and apply...
	if(condition != 'save' && condition != 'apply') {
		 submitform(pressbutton);
	}
}


// function for avatar width and height
function avatarDet(value,id)
{
	if(id == 'image_height') {
		if ( document.getElementById('image_height').value == '' && value == '0' ) {
			document.getElementById('image_height').value = 'Height';
		} else {
			if (document.getElementById('image_height').value != '')
				document.getElementById('image_height').value = document.getElementById('avaheight').value;
			else
				document.getElementById('image_height').value = value;
		}
	}

	 if(id == 'image_width') {
		if (document.getElementById('image_width').value == '' && value == '0') {
			document.getElementById('image_width').value = 'Width';
		} else {
			if (document.getElementById('image_width').value != '')
				document.getElementById('image_width').value = document.getElementById('image_width').value;
			else
				document.getElementById('image_width').value = value;
		}
	}
}


// Function for check whether resize images.
function imageResize()
{
	if( document.getElementById('resize1').value == '1' && document.getElementById('resize1').checked == true ) {
		var span = document.getElementById('imgdimensions');
		span.style.display = 'block';
	} else {
		var span = document.getElementById('imgdimensions');
		span.style.display = 'none';
	}
}

// Function for theme Preview
function selectTheme( id )
{

	var path 	 = document.getElementById('theme_path').value;
	var theme_id = id;
		var ajaxRequest;  // The variable that makes Ajax possible!
		try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){
					// Something went wrong
					alert("Your browser broke!");
					return false;
				}
			}
		}

		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				var ajaxDisplay = document.getElementById('je-themepreview');
				ajaxDisplay.innerHTML = ajaxRequest.responseText;
			}
		}

	var timeNow = Math.floor(Math.random()*11);
	var url=path+'index.php?option=com_jefaqpro&controller=globalsettings&task=themes&theme='+theme_id+'&timeNow'+timeNow;
	ajaxRequest.open("GET", url, true);
	ajaxRequest.send(null);
}