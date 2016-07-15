
    var page = require('webpage').create();
    page.viewportSize = { width: 1024, height: 768 };
    
    page.open('http://vps61048.vps.ovh.ca/', function () {
        page.render('vps61048.vps.ovh.ca1904449155_1024_768.jpg');
        phantom.exit();
    });
    