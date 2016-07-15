
    var page = require('webpage').create();
    page.viewportSize = { width: 1024, height: 768 };
    
    page.open('http://192.168.1.69/live/index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_report_companywebpage', function () {
        page.render('192.168.1.691321922040_1024_768.jpg');
        phantom.exit();
    });
    