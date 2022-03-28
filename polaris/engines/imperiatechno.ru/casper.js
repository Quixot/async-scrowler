var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: false, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 10000;
//casper.options.waitTimeout = 120000;
var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
var cookiesPath = '/var/www/polaris/engines/imperiatechno.ru/cookies/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	casper.echo('Cookies loading');
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
}
	

phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('185.139.214.12','24531','manual','veffxs','yuzx0AxY');
casper.echo('Cookies enabled?: ' + casper.cli.get(6));

casper.userAgent(agent);

casper.start('https://www.imperiatechno.ru/', function() {
		//this.waitForSelector('div#body', function then(){
	    content = this.getHTML();
	    casper.echo(JSON.stringify(content));
	    fs.write('/var/www/polaris/engines/imperiatechno.ru/content.txt', this.getHTML(), 'w');
	  //});
});

casper.run();
