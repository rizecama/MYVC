
    var page = require('webpage').create();
    page.viewportSize = { width: 1024, height: 768 };
    
    page.open('http://192.168.1.69/live/index.php?option=com_camassistant&controller=documents&Itemid=76', function () {
        page.render('192.168.1.69-1329445722_1024_768.jpg');
        phantom.exit();
    });
    