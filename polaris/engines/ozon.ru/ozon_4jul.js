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
var url = 'http://www.ozon.ru/';
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	casper.wait(200);
	if (casper.getHTML()) {
		
		this.thenClick('span[class="a3o1"]', function () {
	    this.sendKeys('input.ui-c5', casper.cli.get(6), {keepFocus: true});
	    this.sendKeys('input.ui-c5', casper.page.event.key.Enter, {keepFocus: true});
/*
			casper.wait(200, function () {
				casper.then(function() {
			    this.mouse.move('input[class="ui-d5 ui-d7"]'); 
				});
			});

			casper.wait(200, function () {
				casper.then(function() {
				  this.sendKeys('input[class="ui-d5 ui-d7"]', this.page.event.key.Enter, {keepFocus: false});
				});
			});			
*/
			casper.wait(200, function () {			

				//fs.write('/var/www/polaris/engines/ozon.ru/content.txt', casper.getPageContent(), 'w');
				//casper.capture("/var/www/polaris/engines/ozon.ru/ozon.png");

						casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true', function() {
							
							casper.wait(500, function () { 
								context = context + this.getHTML();
								this.echo(this.getPageContent());
								casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=2', function() { 
									context = context + this.getHTML();
									this.echo(this.getPageContent());

									casper.wait(500, function () { 
										casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=3', function() {
											context = context + this.getHTML();
											this.echo(this.getPageContent());
											
											casper.wait(500, function () {
												casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=4', function() {
													context = context + this.getHTML();
													this.echo(this.getPageContent());

													casper.wait(500, function () {
														casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=5', function() { //
															context = context + this.getHTML();
															this.echo(this.getPageContent());

															casper.wait(500, function () {
																casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=6', function() {
																	context = context + this.getHTML();
																	this.echo(this.getPageContent());

																casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=7', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=8', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=9', function() {
																		context = context + this.getHTML();
																		this.echo(this.getPageContent());
casper.wait(500, function () {
																	casper.thenOpen('https://www.ozon.ru/search/?brand=17476997&text=polaris&from_global=true&page=10', function() {
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



			});
		
	};
});  
casper.run();
