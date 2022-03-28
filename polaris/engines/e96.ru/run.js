var system = require('system');
var page 	 = require('webpage').create();
var url 	 = system.args[1]; 
page.settings.resourceTimeout = 35000;
page.settings.userAgent = system.args[2];
page.settings.loadImages = false;
page.settings.webSecurityEnabled = false;
page.settings.XSSAuditingEnabled = true;

page.onResourceTimeout = function(e) {
  console.log(e.errorCode);   // it'll probably be 408 
  //console.log(e.errorString); // it'll probably be 'Network timeout on resource'
  //console.log(e.url);         // the url whose request timed out
  phantom.exit(1);
};

page.open(url, function (status) {
  if (status === 'success') {
  // CODE


		var html = page.evaluate(function () {
	    var root = document.getElementsByTagName("html")[0];
	    var html = root ? root.outerHTML : document.body.innerHTML;
	    return html;
		});
		//var now = new Date();
		//page.render('/var/www/js/engines/rozetka.com.ua/screenshots/'+now+'.png');

    console.log(JSON.stringify(html));
    phantom.exit();


  // CODE
  }
});