//
//      App JS
//

//Initialized
APP.pumpHunk("/assets/js/libs/fpo.hunk");
var vendorList = localStorage.lists;


// Popup Functions
function vendorPopup(event) {
    var tmpVendorTel = $(this).find("span.tel").text();
    var tmpVendorID = $(this)[0]["dataset"]["vendorid"];
    var tmpVendorEmail = $(this)[0]["dataset"]["vendoremail"];

    $(".overlay .popup.vendor-action a.call").attr("href", "tel:" + tmpVendorTel);
    $(".overlay .popup.vendor-action a.call").text("Call " + tmpVendorTel);
    $(".overlay .popup.vendor-action a.email").attr("href", "mailto:" + tmpVendorEmail);
    $(".overlay .popup.vendor-action a.link").attr("href", "item.php#vendor/" + tmpVendorID);

    $(".overlay .popup.vendor-action").addClass("visible");
    $(".overlay").addClass("visible");
    event.preventDefault();
    return false;
}

function vendorListHelpPopup(event) {
    $(".overlay .popup.vendor-list-help").addClass("visible");
    $(".overlay").addClass("visible");
    event.preventDefault();
    return false;
}

function saveVendorPopup(event) {
    $(".overlay .popup.save-vendor").addClass("visible");
    $(".overlay").addClass("visible");
    event.preventDefault();
    return false;
}

function tempDotsPopup(event) {
    $(".overlay .popup.temp-dots").addClass("visible");
    $(".overlay").addClass("visible");
    event.preventDefault();
    return false;
}

function addPopupBind(popup_button, popup_elem) {
    $(popup_button).click(function (e) {
        openPopup(popup_elem)
    });
}

function openPopup(popup_elem) {
    $(popup_elem).addClass("visible");
    $(".overlay").addClass("visible");
    event.preventDefault();
    return false;
}

$(".close-overlay").click(closeOverlay);

function closeOverlay(event) {
    $(".overlay").removeClass("visible");
    $(".overlay .popup").removeClass("visible");
}



// Tab behavior

$("nav .tab").click(scrollToActiveTab);

function scrollToActiveTab() {
    setTimeout(function () {
        var leftPos = $(".tab.ggs-slider-active").offset().left;
        $(".tabs").animate({
            scrollLeft: leftPos
        }, '300', 'linear');
    }, 16);
}


// Set up page tabber

var pageSlider = null;

//pageSlider.initSlideIndicators('#banner #block-views-slideshow-block .view-content', '> div');





// Browse Vendors Functions
function getCounties() {
    var state = $("#stateid").val();
    $.post("index2.php?option=com_camassistant&controller=addproperty&task=ajaxcounty", {
    //$.post("index2.php?option=com_camassistant&controller=addproperty&task=ajaxcounty", {
        State: "" + state + ""
    }, function (data) {
        if (data.length > 0) {
            $("#divcounty").html(data);
        }
});
}

$("#browse-vendors").submit(verifyBrowseVendors);
function verifyBrowseVendors(event) {
    var abort = false;
    $("#browse-vendors select").each(function(){
        if($(this).val() == "")
            abort = true;
    });
    if(abort) {
        event.preventDefault();
        openPopup(".overlay .popup.browse-incomplete-fields");
        return false;
    }
}


$(window).bind('beforeunload', function(){
  $("html").addClass("loading");
});




// LocalStorage functions
function shouldUpdateLocalVendorDB(url) {
    var date = new Date();
    var timestamp = date.getTime();
    
    if(timestamp - 1000 > localStorage["lastUpdate"] || typeof localStorage["lists"] === 'undefined') {
        updateLocalVendorDB(url);   
    }
}

function updateLocalVendorDB(url) {
    var date = new Date();
    var timestamp = date.getTime();
    localStorage["lastUpdate"] = timestamp;
    $.getJSON(url+"?"+timestamp, setLocalVendorJSON);
}


// Create dynamic markup
function getVendorPageHTML(listNum) {
    var html = '<div class="page"><div class="no-wrapper"><div class="panel"><div class="vendor-lists">';
    var indexItems;
    for (indexItems = 0; indexItems < vendorList[listNum].vendors.length; ++indexItems) {
        html += getVendorListHTML(vendorList[listNum].vendors[indexItems]);
    }
    html += '</div></div></div></div>';
    return html;
}

function getVendorListPageHTML() {
    getVendorList();
    
    var html = '';
    var index;
    for (index = 0; index < vendorList.length; ++index) {
        html += getVendorPageHTML(index);
    }
    html += '';
    
    return html;
}

function setLocalVendorJSON(json) {
    localStorage.lists = JSON.stringify(json);
    return getVendorList();
}

function getVendorList() {
    if(typeof localStorage.lists === "undefined") {
        return null;
    }
    var theList = JSON.parse(localStorage.lists);
    vendorList = theList;
    return theList;
}


// Individual vendor list item
function getVendorListHTML(data) {
    var complianceval = "compliant";
    if(data.compliance == "Noncompliant")
        complianceval = "noncompliant";
    else if(data.compliance == "Compliant & Noncompliant")
        complianceval = "partial";
    else if(data.compliance == "Not Available")
        complianceval = "no-compliance";
    var html = '<a class="item" data-vendorID="'+data.id+'" data-vendorEmail="'+data.email+'"><img class="compliance" src="/assets/images/status-'+complianceval+'.png"><div class="right"><p class="title">'+data.companyName+'</p><p class="details">'+data.contactPerson+' | <span class="tel">'+data.companyPhone+'</span> | '+data.city+', '+data.state+' <span class="status '+data.verified.replace(/\s+/g, '-').toLowerCase()+' block">'+data.verified+'</span></p></div></a>';
    return html;
}

// All vendor list items
function setUpVendorListPage() {
    $(".pages")[0].innerHTML = getVendorListPageHTML();
    pageSlider = new APP.ggsSlider("body", " #app .pages > .page", "#app-nav .tabs .tab");
    if (window.location.hash.indexOf("#tab/") == 0) {
        var tabIndex = window.location.hash.substr(5) - 1;
        pageSlider.goToSlide(tabIndex);
        var leftPos = $(".tab.ggs-slider-active").offset().left;
        $(".tabs").scrollLeft(leftPos);
    }   
}


function findVendorByID(vendorID) {
    var index1 = 0; // Lists
    for (index1 = 0; index1 < vendorList.length; ++index1) {
        var index2; // Vendors
        for (index2 = 0; index2 < vendorList[index1].vendors.length; ++index2) {
            if(vendorList[index1].vendors[index2].id == vendorID)
                return vendorList[index1].vendors[index2];
        }
    }
    return false;
}

function setUpVendorInfoPage() {
    if (window.location.hash.indexOf("#vendor/") == 0) {
        var vendorID = window.location.hash.substr(8);
        console.log(vendorID);
        $(".vendor-lists")[0].innerHTML = getVendorInfoHTML(findVendorByID(vendorID));
    }   
    
}

function getVendorInfoHTML(data) {
    var html = "";
    
    var complianceval = "compliant";
    if(data.compliance == "Noncompliant")
        complianceval = "noncompliant";
    else if(data.compliance == "Compliant & Noncompliant")
        complianceval = "partial";
    else if(data.compliance == "Not Available")
        complianceval = "no-compliance";
    
    html += '<h2 class="no-arrow">'+data.companyName+'</h2><div class="item"><p class="bottom-line"><img class="logo" src="http://www.greengroupstudio.com/web-design-company.png"></p>	<p>'+data.address+'<br>'+data.city+', '+data.state+' '+data.zip+'</p><p><b>Contact person:</b> '+data.contactPerson+'</p><p><b>Company Phone:</b> <a href="tel:'+data.companyPhone+'">'+data.companyPhone+'</a><br><b>Alternate Phone:</b> <a href="tel:'+data.alternatePhone+'">'+data.alternatePhone+'</a><br><b>Cell Phone: </b><a href="tel:'+data.cellPhone+'">'+data.cellPhone+'</a></p><p><b>Email:</b> <a href="mailto:'+data.email+'">'+data.email+'</a></p><p><b>Website:</b> <a href="'+data.website+'" target="_blank">'+data.website+'</a></p><p class="bottom-line"><span class="status '+data.verified.replace(/\s+/g, '-').toLowerCase()+'">'+data.verified+'</span> / <span class="status '+complianceval+'">'+data.compliance+'</span></p><h1>Industries Served</h1><ul class="bottom-line">';
    
    
    
    var index;
    for (index = 0; index < data.industriesServed.length; ++index) {
        html += '<li>'+data.industriesServed[index].industry+'</li>';
    }
        
    html += '</ul><h1>Vendor Rating</h1><p><img src="https://myvendorcenter.com/components/com_camassistant/assets/images/rating/vendorrating/'+(data.rating + "").replace('.', '')+'.png"></p><p>'+data.rating+' out of 5</p></div>';
    
    return html;
}

function getListOfVendorsHTML() {
    var html = '';
    var index;
    for (index = 0; index < vendorList.length; ++index) {
        html += '<a href="list.php#tab/'+(index+1)+'" class="item">'+ vendorList[index].listName+' <span>'+vendorList[index].vendors.length+'</span></a>';
    }
    html += '';
    return html;
}

function setUpHomePage() {
    $(".vendor-lists")[0].innerHTML = getListOfVendorsHTML();
}


function loadPage() {
    $("html").addClass("loading");   
    updatePage();
    $("html").removeClass("loading");
}

function updatePage() {
    

    shouldUpdateLocalVendorDB("lists.json");
    if ((typeof localStorage.lists === "undefined") == false) {
        getVendorList();

        if($("html").hasClass("view-vendors")) {
            setUpVendorListPage();
        }

        if($("html").hasClass("view-vendor")) {
            setUpVendorInfoPage();
        }

        if($("html").hasClass("view-home")) {
            setUpHomePage();
        }
    }
    
    // Popups
    closeOverlay();
    $(".overlay-click").click(closeOverlay);
    $(".view-vendors .vendor-lists .item").click(vendorPopup);
    $(".view-vendors nav .vendor-list-help").click(vendorListHelpPopup);
    $(".view-vendor nav .vendor-list-help").click(vendorListHelpPopup);
    $(".view-vendor nav .save-vendor").click(saveVendorPopup);
    $(".view-home nav .temp-dots").click(tempDotsPopup);
    addPopupBind("a.login-no-account", ".overlay .popup.login-no-account");
    addPopupBind("a.action-sign-out", ".overlay .popup.action-sign-out");
}

loadPage();