var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 60000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
phantom.setProxy('2.59.217.121','24531','manual','veffxs','yuzx0AxY');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);


var cookiesPath = '/var/www/polaris.ua/engines/tehnomaster.com/cookies/cook.json';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
/**/

var global_page_links = [
'https://tehnomaster.com/view/search.html?view=search&text_filter=polaris&id%24text_filter=',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=1',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=2',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=3',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=4',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=5',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=6',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=7',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=8',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=9',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=10',
'https://tehnomaster.com/view/search.html?text_filter=polaris&page=11'
];

var i=1;

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		casper.waitForSelector('#container', function() {
		//this.wait(20000, function() {
			//this.echo(i);
			this.echo(this.getHTML());
			fs.write('/var/www/polaris.ua/engines/tehnomaster.com/content/'+i+'.txt', this.getHTML(), 'w');
			this.wait(2000);
			//this.capture('/var/www/polaris/engines/ozon.ru/screen/'+casper.cli.get(7)+i+'.png');
		//}).then(function () {
			i++;
    	
    });
	})
});

casper.run();
