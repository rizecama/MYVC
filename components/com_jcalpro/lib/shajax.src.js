/*
 * @version $Id: shajax.src.js 599 2010-03-19 17:35:30Z shumisha $
 * @package sh404SEF
 * @copyright Copyright (C) 2008-2010 Yannick Gaultier. All rights reserved.
 * @license GNU/GPL, see LICENSE.php Joomla! is free software. This version may
 *          have been modified pursuant to the GNU General Public License, and
 *          as distributed it includes or is derivative of works licensed under
 *          the GNU General Public License or other free or open source software
 *          licenses. See COPYRIGHT.php for copyright notices and details.
 *
 * Based on Simple ajax by DeGraeve.com and others
 *
 * For joomla usage:
 * 1 - start with a basic working link : <a href="http://whatever.com/mypage"></a>
 * 2 - Pick a name for this element, for instance : nextMonth
 * 3 - Add to the link a rel attribute, as follow :
 *   <a href="http://whatever.com/mypage" rel="shajaxLinkNextMonth target_element"></a>
 *      target_element is the name of html elemnt that needs to be replaced by the ajax call output
 * 4 - find a loading gif somewhere and put it where you want (this one's great http://www.ajaxload.info/)
 * 5 - set the shajaxProgressImage to the full <img> tag of your loader image
 *  shajax.shajaxProgressImage = '<img src="http://whatever.com/images/ajax-loader.gif" border="0" style="vertical-align: middle" hspace="5"/>';
 * 6 - Somewhere on the page, create a span element to display the ajax loader image You have 2
 * options there : you can show a loader image for individual links, or a global
 * one: If an element with an id="shajaxProgressNextMonth" is found, then it
 * will be used If not found, the default one will used. The id of the default
 * element can be set using the shajax.defaultProgressElement global object property
 * 7 - Prefetching : if the rel attribute of a link has an added "prefetch" part as follow :
 *   rel="shajaxLinkNextMonth target_element prefetch"
 * shajax will start fetching that link content as soon as the page has loaded
 * and store the html returned by the server in  a cache
 * When the user click on the link and thus request the content, shajax will retrieve the
 * content from the cache instead of having to do an ajax request. Display will therefore
 * be (almost) instantaneous
 * 8 - URL mapping : sometimes you'll want the ajax call to request a different url
 * from that of the actual link. In such a case, you have to add the following code
 * to your html output :
 * <script>
 * var shajax.shajaxUrlMapRebuildFn = function rebuildUrlMapAUNIQUEID() {
 * shajax.shajaxUrlMap['shajaxLinkNextMonth']= "http://whatever.com/anotherpage";
 * }
 *shajax.shajaxUrlMapRebuildFnAUNIQUEID();
 * </script>
 * Note that the map should normally be part of the page that is obtained through the ajax
 * call, as a new page content would have new links, and therefore need a new map.
 * shajax will look for the map in the newly obtained page html, and will execute it
 * 9 - Supporting php class : see shajax.php for a class supporting use of shajax.js in PHP, specifically for Joomla
 */

if (typeof (shajax) == "undefined") {
	var shajax = new Object();
}
shajax.enabled = true;
shajax.useCache = true;
shajax.useCompression = false;
shajax.enableDebug = false;
shajax.enablePrefetch = true;
shajax.maxCacheSize = 400000;

shajax.shajaxLiveSiteUrl = ''; // live site base url, to fix links that rely on
// the base tag
shajax.shajaxProgressImage = ''; // must be initialized by user script
shajax.defaultProgressElement = 'shajaxProgress'; // can be overriden by user
// script
shajax.shajaxUrlMap = new Array(); // array holding mapping between non-ajax
// and ajax urls to call
shajax.toPrefetch = new Array(); // stores list of urls to prefetch
shajax.delayToPrefetch = 400; // delay when pre-fetching to ease things up for
								// web servers

/*
 * ajaxify links upon loading the DOM
 */

/*
 * Really technical stuff, better leave it to people who know what they are
 * doing ...
 * 
 * 
 * (c)2006 Jesse Skinner/Dean Edwards/Matthias Miller/John Resig Special thanks
 * to Dan Webb's domready.js Prototype extension and Simon Willison's
 * addLoadEvent
 * 
 * For more info, see: http://www.thefutureoftheweb.com/blog/adddomloadevent
 * http://dean.edwards.name/weblog/2006/06/again/
 * http://www.vivabit.com/bollocks/2006/06/21/a-dom-ready-extension-for-prototype
 * http://simon.incutio.com/archive/2004/05/26/addLoadEvent
 * 
 * 
 * To use: call addDOMLoadEvent one or more times with functions, ie:
 * 
 * function something() { // do something } addDOMLoadEvent(something);
 * 
 * addDOMLoadEvent(function() { // do other stuff });
 * 
 */

shajax.addDOMLoadEvent = ( function() {
	// create event function stack
	var load_events = [], load_timer, script, done, exec, old_onload, init = function() {
		done = true;

		// kill the timer
		clearInterval(load_timer);

		// execute each function in the stack in the order they were added
		while (exec = load_events.shift())
			exec();

		if (script)
			script.onreadystatechange = '';
	};

	return function(func) {
		// if the init function was already ran, just run this function now and
		// stop
		if (done)
			return func();

		if (!load_events[0]) {
			// for Mozilla/Opera9
			if (document.addEventListener)
				document.addEventListener("DOMContentLoaded", init, false);

			// for Internet Explorer
			/* @cc_on @ */
			/*
			 * @if (@_win32) document.write("<script id=__ie_onload defer
			 * src=//0><\/scr"+"ipt>"); script =
			 * document.getElementById("__ie_onload"); script.onreadystatechange =
			 * function() { if (this.readyState == "complete") init(); // call
			 * the onload handler }; /*@end @
			 * 
			 */

			// for Safari
			if (/WebKit/i.test(navigator.userAgent)) { // sniff
				load_timer = setInterval( function() {
					if (/loaded|complete/.test(document.readyState))
						init(); // call the onload handler
				}, 10);
			}

			// for other browsers set the window.onload, but also execute the
			// old window.onload
			old_onload = window.onload;
			window.onload = function() {
				init();
				if (old_onload)
					old_onload();
			};
		}

		load_events.push(func);
	}
})();

/**
 * Make ajax links degrades
 */
shajax.shAjaxifyLinks = function(elementId) {
	// reset list
	shajax.toPrefetch = new Array();

	// setup
	var container = elementId ? document.getElementById(elementId) : document;
	shajax.compressor.enabled = shajax.useCompression;

	// extract link from document or element
	var links = container.getElementsByTagName('a');

	// if we found some links
	if (links) {
		// search for links with class=shajaxLinkXXXXX
		// var aClass = '';
		var aRel, aPreFetch, toPrefetchCount = 0, reg = new RegExp(" ", "g"), relBits = new Array(), uniqueId = '', targetElement = '', prefetchLink;
		for ( var i = 0; i < links.length; i++) {
			aPreFetch = false;
			aRel = links[i].rel;
			if (aRel) {
				if (aRel.substr(0, 10) == 'shajaxLink') {
					// this is one of our links, see if need to prefetch it
					relBits = aRel.split(reg); // rel="uniqueId targetDiv
					// prefetch"
					if (relBits.length == 2 || relBits.length == 3) {
						uniqueId = relBits[0];
						targetElement = relBits[1];
						if (relBits.length == 3) {
							aPreFetch = relBits[2] == "prefetch";
						}
					}
					if (shajax.enablePrefetch && aPreFetch) {
						// store link to later prefetch it
						// find about the link : does it map to something else
						prefetchLink = links[i].href;
						if (typeof (shajax.shajaxUrlMap) != 'undefined') {
							if (shajax.shajaxUrlMap[uniqueId]) {
								prefetchLink = shajax.shajaxUrlMap[uniqueId];
							}
						}
						shajax.toPrefetch[toPrefetchCount] = Array(
								prefetchLink, targetElement, false);
						toPrefetchCount++;
					}
					// insert an onclick handler
					links[i].onclick = shajax.onClickHandler;
				}
			}
		}
		// done adding onClick handlers, now start prefetching page content
		if (shajax.enablePrefetch && toPrefetchCount) {
			var prefetchTime = 0;
			for ( var j = 0; j < toPrefetchCount; j++) {
				// check if already in cache
				var cached = shajax.getFromCache(shajax.toPrefetch[j][0]);
				if (!cached) {
					// if not in cache, get it and store in cache
					if (!shajax.delayToPrefetch) {
						shajax.shajax(shajax.toPrefetch[j][0],
								shajax.toPrefetch[j][1],
								'format=raw&tmpl=component&shajax=1', '',
								'cache');
					} else {
						prefetchTime += shajax.delayToPrefetch;
						// shajax.debug( 'prefetch dealay ' + prefetchTime);
						window.setTimeout('shajax.delayedPrefetch(' + j + ')',
								prefetchTime);
					}
				} else {
					// increase hit counter
					shajax.cacheIncreaseHits(shajax.toPrefetch[j][0]);
					// mark as prefetched
					shajax.toPrefetch[j][2] = true;
				}
			}
		}
	}
};

shajax.debug = function(s) {
	if (!shajax.enableDebug) {
		return;
	}
	var el = document.getElementById('pathway');
	el.innerHTML += s + '<br />';
};

/*
 * Do a prefetch, called from a setTimeout
 */
shajax.delayedPrefetch = function(prefetchId) {
	var toPrefetchCount = shajax.toPrefetch.length;
	if (toPrefetchCount) {
		// if not already fetched
		if (!shajax.toPrefetch[prefetchId][2]) {
			shajax
					.debug('Fetching delayed ' + shajax.toPrefetch[prefetchId][0]);
			shajax.toPrefetch[prefetchId][2] = true;
			shajax.shajax(shajax.toPrefetch[prefetchId][0],
					shajax.toPrefetch[prefetchId][1],
					'format=raw&tmpl=component&shajax=1', '', 'cache');
		}
	}
};

/*
 * Global scope onClick handling function, to avoid accidental closure
 */
shajax.onClickHandler = function() {
	// find about the link : does it map to something else
	var aLink = this.href, aRel = this.rel, aPreFetch, reg = new RegExp(" ",
			"g"), relBits = new Array(), uniqueId = '', targetElement = '';
	if (aRel) {
		if (aRel.substr(0, 10) == 'shajaxLink') {
			// this is one of our links, see if need to prefetch it
			aPreFetch = false;
			relBits = aRel.split(reg); // rel="uniqueId targetDiv prefetch"
			if (relBits.length == 2 || relBits.length == 3) {
				uniqueId = relBits[0];
				targetElement = relBits[1];
				if (relBits.length == 3) {
					aPreFetch = relBits[2] == "prefetch";
				}
			}
		}
		if (typeof (shajax.shajaxUrlMap) != 'undefined') {
			if (shajax.shajaxUrlMap[uniqueId]) {
				aLink = shajax.shajaxUrlMap[uniqueId];
			}
		}
		// make sure we have an absolute link
		if (shajax.shajaxLiveSiteUrl && aLink.substr(0, 7) != 'http://'
				&& aLink.substr(0, 9) == 'index.php') {
			// prepend live site url
			aLink = shajax.shajaxLiveSiteUrl + aLink;
		}
		// clean up rel if needed
		if (aPreFetch) {
			// before making the ajax call, check if this content is already in
			// cache
			var cached = shajax.getFromCache(aLink);
			if (cached) {
				shajax.cacheIncreaseHits(aLink);
				var target = document.getElementById(targetElement);
				if (target) {
					target.innerHTML = cached;
				}
				// need to redo the links
				shajax.redoLinks(targetElement);

				// then perform post display actions that were set
				shajax.postDisplayAction(targetElement);
				// invalidate the actual link
				return false;
			}
		}
		shajax.shajax(aLink, targetElement,
				'format=raw&tmpl=component&shajax=1',
				'shajaxProgress' + uniqueId.substr(10), 'page');
	}
	// return false, otherwise don't work when base tag is wrong
	return false;
};

function GetXmlHttp() {
	var xmlhttp = false;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest()
	} else if (window.ActiveXObject)// code for IE
	{
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP")
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
			} catch (E) {
				xmlhttp = false
			}
		}
	}
	return xmlhttp;
}

/*
 * Performs ajax call to targetUrl, Either updates a document element
 * (elementId) or stores response html in the cache Manages a visible indicator
 * of the ongoing ajax call (only if actually updating document, not for cache
 * storage)
 */
shajax.shajax = function(targetUrl, elementId, params, progress, dest) {
	var xmlHttp = new GetXmlHttp();

	// identify the progress image element
	if (progress && !document.getElementById(progress)) {
		progress = shajax.defaultProgressElement;
	}
	if (xmlHttp) {
		if (dest == 'page') {
			shajax.showProgress(progress, true);
		}
		var connector = targetUrl.indexOf('?') == -1 ? '?' : '&';
		params = params ? connector + params : params;
		xmlHttp.open('GET', targetUrl + params, true);
		if (typeof (xmlHttp.setRequestHeader) != "undefined") {
			xmlHttp.setRequestHeader('Content-type',
					'application/x-www-form-urlencoded');
		}
		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState == 4) {
				if (dest == 'page') {
					shajax.showProgress(progress, false);
				}
				if (xmlHttp.status == 200) {
					// always try to store in cache
					shajax.putInCache(targetUrl, xmlHttp.responseText);
					// set page element if requested
					if (dest == 'page') {
						var target = document.getElementById(elementId);
						if (target) {
							target.innerHTML = xmlHttp.responseText;
						}
						shajax.redoLinks(elementId);
						// then perform post display actions that were set
						shajax.postDisplayAction(elementId);
					}
				}
			}
		}
		xmlHttp.send(null);
	}
};

/*
 * Ajaxify links contained in incoming server response to ajax request
 */
shajax.redoLinks = function(elementId) {
	// need to redo the links
	// but first must update the url map
	var shMap = document.getElementById('shajaxRebuildUrlMap' + elementId);
	var html;
	if (shMap) {
		html = shMap.innerHTML;
	}
	// remove script tags in returned html (must be case
	// insensitive for IE)
	if (html) {
		html = html.replace(new RegExp('<script type="text/javascript">', 'i'),
				'');
		html = html.replace(new RegExp("</script>", 'i'), '');
		// eval that code : it will reset to urlmap to new
		// values, as we have changed links
		eval(html);
	}

	if (html) {
		html = html.replace(/<script type="text\/javascript">/i, '');
		// for ie8
		html = html.replace(/<SCRIPT type=text\/javascript>/i, '');

		html = html.replace(/<\/script>/i, '');
		html = html.replace('<!--/*--><!\[CDATA\[//><!--', '');
		html = html.replace(/\/\/--><!]]>/, '');
		// eval that code : it will reset to urlmap to new
		// values, as we have changed links
		eval(html);
	}

	// now we can redo the links
	shajax.shAjaxifyLinks(elementId);
};

/**
 * Performs some actions after some html has been displayed after being
 * retrieved using ajax, whether directly or when obtained from cache
 */
shajax.postDisplayAction = function(elementId) {
	var shAction = document
			.getElementById('shajaxPostDisplayAction' + elementId);
	var html;
	if (shAction) {
		html = shAction.innerHTML;
	}
	// remove script tags in returned html (must be case
	// insensitive for IE)
	if (html) {
		html = html.replace(/<script type="text\/javascript">/i, '');
		// for ie8
		html = html.replace(/<SCRIPT type=text\/javascript>/i, '');

		html = html.replace(/<\/script>/i, '');
		html = html.replace('<!--/*--><!\[CDATA\[//><!--', '');
		html = html.replace(/\/\/--><!]]>/, '');
		// eval that code : it will reset to urlmap to new
		// values, as we have changed links
		eval(html);
	}
	// reset modal popups from mootols
	shajax.resetPopups('a.jcal_modal');
};

/**
 * Will re-run initialization of Joomla/mmotools popups so that modal popups
 * work in ajax-loaded html, when displayed
 */
shajax.resetPopups = function(selector) {
	// from Joomla behavior.php code
	if (typeof ($$) != 'undefined') {
		$$(selector).each( function(el) {
			el.addEvent('click', function(e) {
				new Event(e).stop();
				SqueezeBox.fromElement(el);
			});
		});
	}
};

/*
 * Stores a piece of html in the DOM, so that we can retrieve it later, when the
 * user click on a link Data is stored in value property, so probably only
 * suited to store Html
 */
shajax.putInCache = function(reference, data) {

	if (!shajax.useCache) {
		return;
	}
	// is this item already in the cache ? if yes, need to replace
	var current = document.getElementById(reference);
	// create element for this data
	var dataNode = document.createTextNode(shajax.compressor.compress(data));
	// get time
	var ts = new Date();
	var tsDataNode = document.createTextNode(ts.getTime());

	if (!current) {
		var cache = document.getElementById('shajaxCache');
		if (!cache) {
			// need to create cache
			cache = shajax.createCache();
		} else {
			if (!shajax.cacheCheckSize(cache, dataNode.length)) {
				// we could not make enough room in the cache, don't store data
				return;
			}
		}

		// does not exists, must create and add
		var item = document.createElement('div');
		item.setAttribute('id', reference);
		item.style.display = "none"; // syntax for IE
		item.appendChild(dataNode);
		item.appendChild(tsDataNode);
		// insert hit counter
		var hitCounterNode = document.createTextNode("1");
		item.appendChild(hitCounterNode);
		cache.appendChild(item);
	} else {
		// updating, directly replace the data
		var currentDataNode = current.childNodes[0];
		if (currentDataNode) {
			var currentTS = current.childNodes[1];
			var currentHitCounter = current.childNodes[2];
			current.replaceChild(dataNode, currentDataNode);
			current.replaceChild(tsDataNode, currentTS)
			// reset counter ? is it best ?
			currentHitCounter.data = "1";
		}
	}
};

/*
 * Increase the hit counter of a given cache entry Needed for erasing items when
 * max cache size is reached A hit is when a cache entry is used, not when the
 * link is clicked
 */
shajax.cacheIncreaseHits = function(reference) {
	if (reference) {
		var item = document.getElementById(reference);
		if (item) {
			var currentHitCounter = item.childNodes[2];
			currentHitCounter.data = String(Number(currentHitCounter.data) + 1);
		}
	}
};

/*
 * Computes approximate global cache size Remove oldest items if above threshold
 */
shajax.cacheCheckSize = function(cache, needed) {

	// each div in the cache is an item
	var count = cache.childNodes.length;
	var total = 0, c = new Array();
	// iterate over items
	for ( var i = 0; i < count; i++) {
		c[i] = {
			"size" : cache.childNodes[i].childNodes[0].length,
			"tStamp" : cache.childNodes[i].childNodes[1].data,
			"hits" : cache.childNodes[i].childNodes[2].data,
			"id" : i
		};
		total = total + Number(c[i].size);
	}
	// compute available cache size, and compare to needed
	var available = shajax.maxCacheSize - total;
	if (available < needed) {
		// if not enough memory left
		/*
		 * Sort the cache descriptor array as follow : 1 - hits count, ascending
		 * (less hits first) 2 - timestamp, ascending (oldest first) 3 - size,
		 * descending (bigger first) then iterate over the array : i = 0 do :
		 * available = available-c[i].size
		 * cache.removeChild(cache.childNodes[c[i].id); i++ until (available >
		 * needed) or (i == c.length)
		 */

		// function to sort the array
		function compareCacheItems(c1, c2) {
			// compare hits count
			if (c1.hits < c2.hits) {
				return -1
			}
			if (c1.hits > c2.hits) {
				return 1
			}
			// same hits count, compare age
			if (c1.tStamp < c2.tStamp) {
				return -1
			}
			if (c1.tStamp > c2.tStamp) {
				return 1
			}
			// same hits count and same age, compare size
			if (c1.size < c2.size) {
				return 1
			}
			if (c1.size > c2.size) {
				return -1
			}
			// equals in hits, age and size
			return 0
		}

		// perform the sort
		c.sort(compareCacheItems);
		// now remove as many items as needed
		var i = 0;
		do {
			available = available + Number(c[i].size);
			cache.removeChild(cache.childNodes[c[i].id]);
			i++;
		} while ((available < needed) && (i < c.length))
	}

	// return true if enough space available
	return (available > needed);
};

/*
 * Retrieves some data previously stored in the store Data is stored in value
 * property, so probably only suited to store Html
 */
shajax.getFromCache = function(reference) {

	if (!shajax.useCache || !reference) {
		return '';
	}
	// try find the reference
	var item = document.getElementById(reference);
	if (item) {
		return shajax.compressor.decompress(item.firstChild.data);
	}
	return '';
};

/*
 * Clear all data cache content
 */
shajax.resetCache = function() {

	var cache = document.getElementById('shajaxCache');
	if (!cache) {
		return '';
	}
	if (cache.hasChildNodes()) {
		while (cache.childNodes.length >= 1) {
			cache.removeChild(cache.firstChild);
		}
	}
};

/*
 * Creates an empty cache in the document
 */
shajax.createCache = function() {

	var cacheRoot = document.createElement("div");
	cacheRoot.setAttribute('id', 'shajaxCache');
	cacheRoot.style.display = "none";
	// insert the cache storage area at end of document
	document.body.appendChild(cacheRoot);

	return cacheRoot;
};

/**
 * Progress div may be simply surrounding an existing element of the page This
 * element will be replaced by the progress gif, and then restored afterward
 * state = true : visible, state = false : invisible
 */
shajax.showProgress = function(progress, state) {

	if (typeof this.save == 'undefined') {
		this.save = '';
	}
	if (state) {
		this.save = document.getElementById(progress).innerHTML;
		document.getElementById(progress).innerHTML = shajax.shajaxProgressImage;
	} else {
		document.getElementById(progress).innerHTML = this.save;
	}
};

shajax.compressor = {
	enabled : true,
	// LZW-compress a string
	// from jsolait library
	// (c) Jan-Klaas Kollhof - 2006
	compress : function(s) {
		if (!shajax.compressor.enabled || s=="")
			return s;
		var dict = {};
		var data = (s + "").split("");
		var out = [];
		var currChar;
		var phrase = data[0];
		var code = 256;
		for ( var i = 1; i < data.length; i++) {
			currChar = data[i];
			if (dict[phrase + currChar] != null) {
				phrase += currChar;
			} else {
				out.push(phrase.length > 1 ? dict[phrase] : phrase
						.charCodeAt(0));
				dict[phrase + currChar] = code;
				code++;
				phrase = currChar;
			}
		}
		out.push(phrase.length > 1 ? dict[phrase] : phrase.charCodeAt(0));
		for ( var i = 0; i < out.length; i++) {
			out[i] = String.fromCharCode(out[i]);
		}
		return out.join("");
	},

	// Decompress an LZW-encoded string
	decompress : function(s) {
		if (!shajax.compressor.enabled)
			return s;
		var dict = {};
		var data = (s + "").split("");
		var currChar = data[0];
		var oldPhrase = currChar;
		var out = [ currChar ];
		var code = 256;
		var phrase;
		for ( var i = 1; i < data.length; i++) {
			var currCode = data[i].charCodeAt(0);
			if (currCode < 256) {
				phrase = data[i];
			} else {
				phrase = dict[currCode] ? dict[currCode]
						: (oldPhrase + currChar);
			}
			out.push(phrase);
			currChar = phrase.charAt(0);
			dict[code] = oldPhrase + currChar;
			code++;
			oldPhrase = phrase;
		}
		return out.join("");
	}

};

/* Ignition... */
if (shajax.enabled) {
	shajax.addDOMLoadEvent(shajax.shAjaxifyLinks);
}

/**
 * Function : dump() Arguments: The data - array,hash(associative array),object
 * The level - OPTIONAL Returns : The textual representation of the array. This
 * function was inspired by the print_r function of PHP. This will accept some
 * data as the argument and return a text that will be a more readable version
 * of the array/hash/object that is given.
 */
function dump(arr, level) {
	var dumped_text = "";
	if (!level)
		level = 0;

	// The padding given at the beginning of the line.
	var level_padding = "";
	for ( var j = 0; j < level + 1; j++)
		level_padding += "    ";

	if (typeof (arr) == 'object') { // Array/Hashes/Objects
		for ( var item in arr) {
			var value = arr[item];

			if (typeof (value) == 'object') { // If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value, level + 1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value
						+ "\"\n";
			}
		}
	} else { // Stings/Chars/Numbers etc.
		dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
	}
	return dumped_text;
};
