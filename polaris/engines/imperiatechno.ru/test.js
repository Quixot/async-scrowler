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
casper.options.waitTimeout = 60000;

var fs = require('fs');

phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('94.154.131.199','24531','manual','veffxs','yuzx0AxY');
casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0');

casper.echo('Cookies enabled?: ' + casper.cli.get(6));

var cookiesPath = '/var/www/polaris/engines/imperiatechno.ru/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}


casper.start('https://www.imperiatechno.ru/', function() {
	//this.thenClick('.user-menu-login', function () {
		this.waitForSelector('#site', function () {
			//this.sendKeys('#Item_Login', 'aschsss@yandex.ru');
			//this.sendKeys('#Item_Password', 'FF9qjZKXxQRCPPg');
			//this.thenClick('#signIn', function () {
			//this.wait(500, function () {			
				this.capture("/var/www/polaris/engines/imperiatechno.ru/screen.png");
			//});
			//});
	  //});
	});
});
casper.run();
