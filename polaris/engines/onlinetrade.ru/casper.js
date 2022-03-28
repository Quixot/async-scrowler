var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: true,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 60000;
//casper.options.waitTimeout = 120000;
var fs = require('fs');
var url 	= casper.cli.get(0);
var x = require('casper').selectXPath;
var context = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
//var cookiesPath = '/var/www/polaris/engines/imperiatechno.ru/cookies/cook.txt';

var cookiesPath = '/var/www/polaris/engines/onlinetrade.ru/cookies/'+casper.cli.get(6)+'.json';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	//phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	//casper.exit();
}

//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
//casper.echo('Cookies enabled?: ' + casper.cli.get(6));

casper.userAgent(agent);
//listView
casper.start(url, function() {
	this.waitForSelector('.content', function then() {
		this.echo(this.getHTML());

		if (phantom.cookies) { // write
			fs.write('/var/www/polaris/engines/onlinetrade.ru/cook.txt', JSON.stringify(phantom.cookies), 644);
		}

	});
});

casper.run();
