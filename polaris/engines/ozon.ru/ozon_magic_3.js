var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: false, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 20000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';
//phantom.setProxy('185.127.165.200','443','manual','WpSsZQwpb','xvAjhczlf');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(7)+'.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
	

casper.start('https://www.ozon.ru/brand/polaris-17476997/', function() {
  this.echo(this.getTitle());
  fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'1.txt', this.getHTML(), 'w');

var links = [];
for (var i = 2; i <= 3; i++) {
	links.push('https://www.ozon.ru/brand/polaris-17476997/?page='+i);
	casper.echo('https://www.ozon.ru/brand/polaris-17476997/?page='+i);
};


casper.each(links, function(self, link) {
  self.thenOpen(link, function() {
    this.echo(this.getTitle());
    fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+i+'.txt', this.getHTML(), 'w');
  });
});


});
