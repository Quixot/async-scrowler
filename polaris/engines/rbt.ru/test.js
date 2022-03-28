var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,
        loadPlugins: false
    },
    verbose: true,
    logLevel: "debug"
});
casper.options.waitTimeout = 20000;

var fs = require('fs');
var x = require('casper').selectXPath;
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('193.43.147.167','24531','manual','veffxs','yuzx0AxY');
casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0');

var cookiesPath = '/var/www/polaris/engines/rbt.ru/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}

casper.start('https://ekat.rbt.ru/search/~/page/2/?q=polaris', function() {
	this.waitForSelector('.header', function () {
		
	  var url = this.evaluate(function() {
	  	//return __utils__.getElementByXPath("//a[./text()='CSV']")["href"];
	    return __utils__.getElementByXPath("//span[@class='item-catalogue-list__title-amount']").innerHTML.trim();
	  });

	  this.echo("GETTING " + url);

		this.capture("/var/www/polaris/engines/rbt.ru/screen.png");

	});
});
casper.run();
