var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 40000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
//phantom.setProxy('185.127.165.200','443','manual','WpSsZQwpb','xvAjhczlf');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(7)+'.json';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
	

var global_page_links = [
'https://www.ozon.ru/brand/polaris-17476997/?page=6',
];

var i=1;

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		//casper.waitForSelector('.header_main', function() {
		this.wait(50, function() {
			//this.echo(i);
			this.echo(this.getTitle() +' page: '+i);
			fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'6.txt', this.getHTML(), 'w');
			//this.capture('/var/www/polaris/engines/ozon.ru/screen/'+casper.cli.get(7)+i+'.png');
		//}).then(function () {
			i++;
    	
    });
	})
});

casper.run();
