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
var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(2)+'.'+casper.cli.get(3)+'.txt';

// Проверка существуют ли cookies
//if (fs.exists(cookiesPath))
 // phantom.cookies = JSON.parse(fs.read(cookiesPath));


casper.options.waitTimeout = 10000;
var page = require('webpage').create();
//var fs = require('fs');
//var x = require('casper').selectXPath;
//var url 	= casper.cli.get(0);
//var url = 'https://www.ozon.ru/info/map/';
var url = 'https://www.ozon.ru/geo/arhangelsk/';
//var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	//this.wait(60000, function () {
		this.capture("/var/www/polaris/engines/ozon.ru/1ozon_1.png");
	//this.waitForSelector('.m-link', function then() {
		//this.wait(60000, function () {
		
		//this.thenClick('button[class="o1"]', function () {
			//this.waitForSelector('input.input', function then() {
			//casper.wait(100, function () {
				/*
				this.then(function() {
					
					casper.wait(200, function () {
						casper.then(function() {
					    this.mouse.move('.ui-b5'); 
					    this.sendKeys('.ui-b5', casper.cli.get(6), {keepFocus: true});
					    this.capture("/var/www/polaris/engines/ozon.ru/1ozon_1.png");
						});
					});

					//casper.wait(200, function () {
					//	casper.then(function() {
					//	  this.sendKeys('.ui-b5', this.page.event.key.Enter, {keepFocus: false});
					//	});
					//});	

	    		//this.sendKeys('input.input', 'Омск', {keepFocus: true});
	    		//this.wait(200, function () {
	    			//this.capture("/var/www/polaris/engines/ozon.ru/1ozon_1.png");
					//});
					//fs.write('/var/www/philips/engines/fotos.ua/content.txt', content, 'w');
					
					//if (phantom.cookies) {
					//	this.echo(phantom.cookies);
					//	fs.write(cookiesPath, JSON.stringify(phantom.cookies), 644);
					//}

	    	});
			//});
/*
			casper.wait(200, function () {
				casper.then(function() {
			    this.mouse.move('input.input'); 
				});
			});

			casper.wait(200, function () {
				casper.then(function() {
				  this.sendKeys('input.input', this.page.event.key.Enter, {keepFocus: false});
				});
			});	
			*/						
		//});
/**/
//});
//	});

	
});  
casper.run();
