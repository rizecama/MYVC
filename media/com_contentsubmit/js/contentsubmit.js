	/**
	 * 
	 * @param {Object} order
	 * @param {Object} dir
	 * @param {Object} task
	 */
	function gridOrdering( order, dir ) 
	{
		var form = document.adminForm;
	     
		form.filter_order.value     = order;
		form.filter_direction.value	= dir;
	
		form.submit();
	}
	
	/**
	 * 
	 * @param id
	 * @param change
	 * @return
	 */
	function gridOrder(id, change) 
	{
		var form = document.adminForm;
		
		form.id.value= id;
		form.order_change.value	= change;
		form.task.value = 'order';
		
		form.submit();
	}
	
	/**
	 * 
	 * @param {Object} divname
	 * @param {Object} spanname
	 * @param {Object} showtext
	 * @param {Object} hidetext
	 */
	function displayDiv (divname, spanname, showtext, hidetext) 
	{ 
		var div = document.getElementById(divname);
		var span = document.getElementById(spanname);
	
		if (div.style.display == "none")
		{
			div.style.display = "";
			span.innerHTML = hidetext;
		} 
			else 
		{
			div.style.display = "none";
			span.innerHTML = showtext;
		}
	}
	
	/**
	 * 
	 * @param {Object} prefix
	 * @param {Object} newSuffix
	 */
	function switchDisplayDiv( prefix, newSuffix )
	{
		var newName = prefix + newSuffix;
		var currentSuffixDiv = document.getElementById('currentSuffix');
		var currentSuffix = currentSuffixDiv.innerHTML;	
		var oldName = prefix + currentSuffix;
		var newDiv = document.getElementById(newName);
		var oldDiv = document.getElementById(oldName);
	
		currentSuffixDiv.innerHTML = newSuffix;
		newDiv.style.display = "";
		oldDiv.style.display = "none";
	}

	/**
	 * Sends form values to server for validation and outputs message returned.
	 * Submits form if error flag is not set in response
	 * 
	 * @param {String} url for performing validation
	 * @param {String} form element name
	 * @param {String} task being performed
	 */
	function formValidation( url, container, task, form ) 
	{
		if (task == 'save' || task == 'apply' || task == 'savenew') 
		{
			// loop through form elements and prepare an array of objects for passing to server
			var str = new Array();
			for(i=0; i<form.elements.length; i++)
			{
				postvar = {
					name : form.elements[i].name,
					value : form.elements[i].value,
					id : form.elements[i].id
				}
				str[i] = postvar;
			}
			
			// execute Ajax request to server
            var a=new Ajax(url,{
                method:"post",
				data:{"elements":Json.toString(str)},
                onComplete: function(response){
                    var resp=Json.evaluate(response);
                    $(container).setHTML(resp.msg);
        			if (resp.error != '1') 
        			{
        				form.task.value = task;
        				form.submit();
        			}
                }
            }).request();
		}
			else 
		{
			form.task.value = task;
			form.submit();
		}
	}
	
	/**
	 * Overriding core submitbutton task to perform our onsubmit function
	 * without submitting form afterwards
	 * 
	 * @param task
	 * @return
	 */
	function submitbutton(task) 
	{
		if (task) 
		{
			document.adminForm.task.value = task;
		}

		if (typeof document.adminForm.onsubmit == "function") 
		{
			document.adminForm.onsubmit();
		}
			else
		{
			submitform(task);
		}
	}
	
	/**
	 * 
	 * @param {String} url to query
	 * @param {String} document element to update after execution
	 * @param {String} form name (optional)
	 */
	function doTask( url, container, form ) 
	{
		// if url is present, do validation
		if (url && form) 
		{	
			// loop through form elements and prepare an array of objects for passing to server
			var str = new Array();
			for(i=0; i<form.elements.length; i++)
			{
				postvar = {
					name : form.elements[i].name,
					value : form.elements[i].value,
					id : form.elements[i].id
				}
				str[i] = postvar;
			}
			// execute Ajax request to server
            var a=new Ajax(url,{
                method:"post",
				data:{"elements":Json.toString(str)},
                onComplete: function(response){
                    var resp=Json.evaluate(response);
                    $(container).setHTML(resp.msg);
                }
            }).request();
		}
			else if (url && !form) 
		{
			// execute Ajax request to server
            var a=new Ajax(url,{
                method:"post",
                onComplete: function(response){
                    var resp=Json.evaluate(response);
                    $(container).setHTML(resp.msg);
                }
            }).request();			
		}
	}
	
	/**
	 * @author
	 * Name: Sigrid & Radek Suski, Sigsiu.NET
	 * Email: sobi@sigsiu.net
	 * Url: http://www.sigsiu.net
	 * 
	 * @param id
	 * @return
	 */
	function appendTo( id, target )
	{
		if ( id && target ) 
		{
			$(target).value = $(target).value + $(id).innerHTML.replace(/\\\'/g, '\'');
		}
	}
