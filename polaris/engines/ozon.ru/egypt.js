var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,
        loadPlugins: false,
    },
    verbose: true,
    logLevel: "debug"
});
var fs = require('fs');
var url 	= casper.cli.get(0);
var url = 'https://www.ozon.ru/highlight/premium/';
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';

var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(2)+'.'+casper.cli.get(3)+'.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath))
	phantom.cookies = JSON.parse(fs.read(cookiesPath));

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	this.wait(15000, function () {

		this.thenClick('span[class="icon-img a3o7"]', function () {
			//this.wait(5000, function () {

					if (phantom.cookies) {
						this.echo(phantom.cookies);
						fs.write(cookiesPath, JSON.stringify(phantom.cookies), 644);
					}

				this.capture("/var/www/polaris/engines/ozon.ru/ozon1.png");
				fs.write('/var/www/polaris/engines/ozon.ru/content.txt', this.getPageContent(), 'w');
				this.sendKeys('input.ui-c5', 'Казань', {keepFocus: true});
			//});
	/*
		  this.wait(2000);
		    
		  this.sendKeys('input.ui-c5', this.page.event.key.Enter, {keepFocus: true});
			this.wait(200, function () {			
				fs.write('/var/www/polaris/engines/ozon.ru/content.txt', this.getPageContent(), 'w');
				this.capture("/var/www/polaris/engines/ozon.ru/ozon2.png");
			});
	*/
		});
	});

});  
casper.run();
