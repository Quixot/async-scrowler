var system = require('system');
var page 	 = require('webpage').create();
var url 	 = 'http://www.frau-technica.ru/'; 
page.settings.resourceTimeout = 35000;
page.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
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


		//var html = page.evaluate(function () {
	  //  var root = document.getElementsByTagName("html")[0];
	  //  var html = root ? root.outerHTML : document.body.innerHTML;
	  //  return html;
		//});
		var now = new Date();
		page.render('/var/www/engines/frau-technica.ru/'+now+'.png');

    //console.log(JSON.stringify(html));
    phantom.exit();


  // CODE
  }
});