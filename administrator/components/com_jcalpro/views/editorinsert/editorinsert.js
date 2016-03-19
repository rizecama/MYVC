/*
 **********************************************
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************
 $Id: editorinsert.js 712 2011-03-08 17:45:00Z jeffchannell $
 */


/**
 * Performs insertion of an event data into
 * Joomla text editor
 */
function jclEditorDoInsert(type) {

	// check how many boxes checked
	if (!jclEditorInsertCheckChecked()) {
		return false;
	}

	// find which events was checked for insertion
	var eventId = jclEditorInsertGetCheckedItem();

	if (eventId) {
		
		// get data stored in the title
		var item = document.getElementById('eventData_' + eventId);
		
		// need to enclose in parenthesis to prevent javascript to see json as labels
		var eventData = eval('(' + item.rel + ')');

		// Insert text
		window.parent.jInsertEditorText( jclEditorInsertPrepareText(type, eventData, eventId),
				jclEditorInsertEName);

		// Close iFrame as we succeeded
		window.parent.document.getElementById('sbox-window').close();
	} else {
		alert('Internal error : insert link not found');
	}

}

/**
 * Prepare the text to be inserted in the editor, either
 * a link or the Title+description 
 * @param type
 * @param eventData
 * @param eventId
 * @return
 */
function jclEditorInsertPrepareText(type, eventData, eventId) {

	var text = '';
	
	if (type == 'link') {  // prepare a link to the event
		
		// calculate Itemid to use
		var Itemid = jclEditorInsertDefaultItemid;
		
		// did user input another one ?
		var userItemid = parseInt(document.getElementById('jcl_insert_options_link_itemid').value);
		if(userItemid && !isNaN(userItemid)) {
			Itemid = userItemid;
		}

		// now build link wit Itemid
		text = ' <a href="' + jclEditorInsertBaseUrl
				+ (Itemid > 0 ? '&Itemid='+Itemid : '')
				+ '&extmode=view&extid=' + eventId + '"';
		text = text + ' title="' + eventData.title + '" >' + eventData.title + '</a> ';
	} else {  // insert directly the event content
		var insertTitle = document.getElementById('jcl_insert_options_event_title1');
		if(insertTitle) {
			insertTitle = insertTitle.checked ? eventData.title : '';
		}
		var insertStartDate = document.getElementById('jcl_insert_options_event_start_date1');
		if(insertStartDate) {
			insertStartDate = insertStartDate.checked ? eventData.startDate : '';
		}
		var insertEndDate = document.getElementById('jcl_insert_options_event_end_date1');
		if(insertEndDate) {
			insertEndDate = insertEndDate.checked ? eventData.endDate : '';
		}
		var insertDesc = document.getElementById('jcl_insert_options_event_description1');
		if(insertDesc) {
			insertDesc = insertDesc.checked ? eventData.description : '';
		}
		text = insertTitle ? ' ' + insertTitle : '';
		text = text + (insertStartDate ? '<br />' + insertStartDate : '');
		text = text + (insertEndDate ? '<br />' + insertEndDate : '');
		text = text + (insertDesc ? '<br />' + insertDesc : '');
	}	
	
	return text;
}

function jclEditorInsertGetCheckedItem() {
	var f = document.adminForm;
	for (i = 0; true; i++) {
		// are we passed the last checkbox ?
		cbx = eval('f.cb' + i);
		if (!cbx)
			break;
		// if we have a checkbox, is it checked ?
		if (cbx.checked) {
			// found what we want (we know only one is checked)
			return cbx.value;
		}
	}
	return false;
}

function jclEditorInsertCheckChecked() {

	// read how many boxes checked
	if (document.adminForm.boxchecked.value != 1) {
		alert('Please choose one and only one event to insert!');
		return false;
	}
	// exactly one box checked
	return true;
}

function jclGetElement(psID) {
	if (document.all) {
		return document.all[psID];
	}

	else if (document.getElementById) {
		return document.getElementById(psID);
	}

	else {
		for (iLayer = 1; iLayer < document.layers.length; iLayer++) {
			if (document.layers[iLayer].id == psID)
				return document.layers[iLayer];
		}
	}

	return Null;
}

// make linked titles insert link
window.addEvent('domready', function() {
	var links = $$('.eventLinkInsertLink');
	if (!links) return;
	links.each(function(el) {
		el.addEvent('click', function(ev) {
			new Event(ev).stop();
			// this should work, but in case it doesn't for some reason...
			try {
				$$('.check input[type=checkbox]').each(function(ch) {
					ch.checked = false;
				});
				el.getParent().getParent().getChildren()[1].getChildren()[0].checked = 'checked';
				document.adminForm.boxchecked.value = 1;
				jclEditorDoInsert('link');
			} catch (err) {
				alert(err);
				return false;
			}
			return false;
		});
	});
});