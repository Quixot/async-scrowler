var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: false, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 20000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';
phantom.setProxy('185.139.214.153','24531','manual','veffxs','yuzx0AxY');
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

var cookiesPath = '/var/www/polaris/engines/ozon.ru/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
	


casper.start('https://www.ozon.ru/')
    .then(function () {
    this.wait(10000); // Trigger :hover state
    })
    .then(function () {
      this.thenClick('span[class="a9u"]', function () {
				//casper.waitForSelector('.modal-container',
				 this.then(
				    function success() {
				      this.echo("table found");
				      this.capture("/var/www/polaris/engines/ozon.ru/ozon1.png");
				      fs.write('/var/www/polaris/engines/ozon.ru/content.txt', this.getPageContent(), 'w');
				    },
				    function fail() {
				    	this.capture("/var/www/polaris/engines/ozon.ru/ozon1.png");
				      console.log("oops");
				    },10000
				);
      });
    });


casper.run();

