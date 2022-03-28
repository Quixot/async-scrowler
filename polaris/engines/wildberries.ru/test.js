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

phantom.setProxy('31.184.192.70','47473','manual','ohsothio','7Z1Yn1os');
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.options.waitTimeout = 30000;
casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.4100.0 Iron Safari/537.36');

var cookiesPath = '/var/www/polaris/engines/wildberries.ru/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}

casper.start('https://hotline.ua/mobile-mobilnye-telefony-i-smartfony/huawei-p-smart-2021-4128gb-crush-green-51096abx/', function() {
	//this.thenClick('.user-menu-login', function () {
		//this.waitForSelector('#body-layout', function () {
			//this.sendKeys('#Item_Login', 'aschsss@yandex.ru');
			//this.sendKeys('#Item_Password', 'FF9qjZKXxQRCPPg');
			//this.thenClick('#signIn', function () {
			this.wait(500, function () {	
				var js = this.evaluate(function() {
					//return document.querySelector('body'); 
					return document.querySelector("html").innerHTML;
				});
				this.capture("/var/www/polaris/engines/wildberries.ru/1.png");
				fs.write('/var/www/polaris/engines/wildberries.ru/1.txt', js, 'w');
			});
			//});
	  //});
	//});
});
casper.run();
