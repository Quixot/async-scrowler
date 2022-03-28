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
var url = 'https://www.ozon.ru/context/map/?areaId=26575';
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	casper.wait(200);
	//fs.write('/var/www/polaris/engines/ozon.ru/ozon.json', casper.getPageContent(), 'w');
	if (casper.getHTML()) {
		this.thenClick('.jsButton', function () {
			
	    this.sendKeys('.jsInputField', casper.cli.get(6), {keepFocus: true});

			casper.wait(5000, function () {
				casper.then(function() {
			    this.mouse.move(".eAutocomplete_list"); 
				});
			});

			casper.wait(5000, function () {
				casper.then(function() {
				  this.sendKeys('.jsInputField', this.page.event.key.Enter, {keepFocus: false});
				});
			});		

			casper.wait(200, function () {			
				casper.thenOpen('https://www.ozon.ru/brand/17476997/', function() {

    			casper.wait(500, function () {	
	    			this.echo(this.getPageContent());
        		context = this.getHTML();
	    			//fs.write('/var/www/polaris/engines/ozon.ru/ozon.json', casper.getPageContent(), 'w');
	    			//casper.capture("/var/www/polaris/engines/ozon.ru/ozon.png");
	    			/*
						for (i = 0; i < 2; i++) { 
							casper.wait(200, function () {
						    this.scrollToBottom();
							});
							context = context + this.getHTML();	
						}
						*/
						casper.thenOpen('https://www.ozon.ru/category/10525/?brand=17476997', function() {
							
							casper.wait(500, function () { 
								context = context + this.getHTML();
								this.echo(this.getPageContent());
								casper.thenOpen('https://www.ozon.ru/category/10737/?brand=17476997', function() { 
									context = context + this.getHTML();
									this.echo(this.getPageContent());

									casper.wait(500, function () { 
										casper.thenOpen('https://www.ozon.ru/brand/17476997/category/10500/?sorting=price', function() {
											context = context + this.getHTML();
											this.echo(this.getPageContent());
											
											casper.wait(500, function () {
												casper.thenOpen('https://www.ozon.ru/brand/17476997/category/14500/', function() {
													context = context + this.getHTML();
													this.echo(this.getPageContent());

													casper.wait(500, function () {
														casper.thenOpen('https://www.ozon.ru/brand/17476997/category/10500/?sorting=price_desc', function() { //
															context = context + this.getHTML();
															this.echo(this.getPageContent());

															casper.wait(500, function () {
																casper.thenOpen('https://www.ozon.ru/brand/17476997/category/10711/', function() {
																	context = context + this.getHTML();
																	this.echo(this.getPageContent());

																casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/mashinki-dlya-strizhki-10756/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/elektrogrili-10549/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/myasorubki-10594/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/multivarki-10563/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/pogruzhnoy-blender-31638/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/miksery-10582/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/kapelnye-kofevarki-31663/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/kuhonnye-vesy-10621/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/category/shchiptsy-dlya-zavivki-10745/polaris-17476997/', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
																																																																																																																																															

																	casper.wait(500, function () {
																		casper.thenOpen('https://www.ozon.ru/brand/17476997/category/10647/', function() {
																			context = context + this.getHTML();
																			this.echo(this.getPageContent());
																			this.echo(context);
																			fs.write('/var/www/polaris/engines/ozon.ru/ozon_'+casper.cli.get(6)+'.json', casper.getPageContent(), 'w');
																			this.exit();
																		});
																	});
																
});});});});});});});});});});});});});});});});});});

																});
															
															});
														});
													});
												});
											});
										});
									});
								});
							}); // casper.thenOpen('https://www.ozon.ru/category/10737/?brand=17476997', function() {
						}); // casper.wait(500, function () {
	    		}); // casper.thenOpen('https://www.ozon.ru/category/10525/?brand=17476997', function() {
				}); // casper.wait(500, function () {
			}); // casper.wait(200, function () {
		}); // this.thenClick('.jsButton', function () {
	}; // if
});  
casper.run();
