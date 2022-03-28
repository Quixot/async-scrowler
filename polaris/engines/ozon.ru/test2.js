var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: true,
        loadPlugins: true,
    },
    verbose: true,
    logLevel: "debug"
});

var fs = require('fs');
//var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(2)+'.'+casper.cli.get(3)+'.txt';

// Проверка существуют ли cookies
//if (fs.exists(cookiesPath))
//  phantom.cookies = JSON.parse(fs.read(cookiesPath));


casper.options.waitTimeout = 60000;
var page = require('webpage').create();
//var fs = require('fs');
//var x = require('casper').selectXPath;
//var url 	= casper.cli.get(0);
//var url = 'https://www.ozon.ru/info/map/';
var url = 'https://www.ozon.ru/';
//var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	if (casper.getHTML()) {	
		this.thenClick('.block-vertical button', function () {
			this.waitForSelector('div.modal-content', function then() {
				this.thenClick('div.modal-content input', function () {
					//this.click('div.modal-content input');
					
					this.wait(5000, function () {	
						
						this.clickLabel('Ваш город ...', 'p');
					//this.thenClick('div.modal-content input', function () {	
						//this.wait(7000, function () {
							this.sendKeys('div.modal-content input', casper.cli.get(6), {keepFocus: true});
							this.capture("/var/www/polaris/engines/ozon.ru/ozon_1.png");
							//this.sendKeys('div.modal-content input', this.page.event.key.Enter, {keepFocus: false});
					    //this.click('.city-name-inner');
					    this.wait(2000, function () {
					    	this.capture("/var/www/polaris/engines/ozon.ru/ozon_2.png");
						   	
						   	fs.write('/var/www/polaris/engines/ozon.ru/content.txt', this.getPageContent(), 'w');
						    
					    });
					    

							//if (phantom.cookies) {
							//	this.echo(phantom.cookies);
							//	fs.write(cookiesPath, JSON.stringify(phantom.cookies), 644);
							//}
							//this.wait(12000, function () {

								//this.capture("/var/www/polaris/engines/ozon.ru/ozon_1.png");
					    //});
						//});
					});
				});	
	    });					
		});
	};
});  
casper.run();
