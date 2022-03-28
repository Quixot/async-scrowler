var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 60000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
//phantom.setProxy('185.112.12.2','2831','manual','rspbttech','iT8CGYbD');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);


var cookiesPath = '/var/www/polaris.ua/engines/protovar.com.ua/cookies/kiev.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
/**/

var global_page_links = [
'https://protovar.com.ua/search_layer/24/7334',
'https://protovar.com.ua/search_layer/85/7334',
];

var i=1;

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		//casper.waitForSelector('#header', function() {
		this.wait(20000, function() {
			//this.echo(i);
			this.echo(this.getHTML());
			fs.write('/var/www/polaris.ua/engines/protovar.com.ua/content/'+i+'.txt', this.getHTML(), 'w');
			//this.capture('/var/www/polaris/engines/ozon.ru/screen/'+casper.cli.get(7)+i+'.png');
		//}).then(function () {
			i++;
    	
    });
	})
});

casper.run();
