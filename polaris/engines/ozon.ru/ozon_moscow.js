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
casper.options.waitTimeout = 40000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var url = 'http://www.ozon.ru/';
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	//casper.wait(200);
	if (casper.getHTML('div.block-vertical')) {
		
		this.wait(200, function () {

			casper.wait(5000, function () {			



						casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/', function() {
							
							//casper.wait(200, function () { 
								context = context + this.getHTML('div.block-vertical');
								this.echo(this.getPageContent());
								casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=2', function() { 
									context = context + this.getHTML('div.block-vertical');
									this.echo(this.getPageContent());

									//casper.wait(200, function () { 
										casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=3', function() {
											context = context + this.getHTML('div.block-vertical');
											this.echo(this.getPageContent());
											
											//casper.wait(200, function () {
												casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=4', function() {
													context = context + this.getHTML('div.block-vertical');
													this.echo(this.getPageContent());

													//casper.wait(200, function () {
														casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=5', function() { //
															context = context + this.getHTML('div.block-vertical');
															this.echo(this.getPageContent());

															//casper.wait(200, function () {
																casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=6', function() {
																	context = context + this.getHTML('div.block-vertical');
																	this.echo(this.getPageContent());

																//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=7', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=8', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=9', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=10', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=11', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=12', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=13', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=14', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
//casper.wait(200, function () {
																	casper.thenOpen('https://www.ozon.ru/category/shchiptsy-dlya-zavivki-10745/polaris-17476997/', function() {
																		context = context + this.getHTML('div.block-vertical');
																		this.echo(this.getPageContent());
																																																																																																																																															

																	//casper.wait(200, function () {
																		casper.thenOpen('https://www.ozon.ru/brand/17476997/category/10647/', function() {
																			context = context + this.getHTML('div.block-vertical');
																			this.echo(this.getPageContent());
																			this.echo(context);
																			//fs.write('/var/www/polaris/engines/ozon.ru/ozon_'+casper.cli.get(6)+'.json', casper.getPageContent(), 'w');
																			this.exit();
																		});
																	//});
																
/*});});});});});});});});});});});});});});*/});});});});

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
