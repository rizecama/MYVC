
    var page = require('webpage').create();
    page.viewportSize = { width: 1024, height: 768 };
    
    page.open('http://192.168.1.69/live/', function () {
        page.render('192.168.1.69-805766499_1024_768.jpg');
        phantom.exit();
    });
    