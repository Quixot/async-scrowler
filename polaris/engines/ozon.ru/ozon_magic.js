var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: false, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 40000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
//phantom.setProxy('185.127.165.200','443','manual','WpSsZQwpb','xvAjhczlf');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

var cookiesPath = '/var/www/polaris/engines/ozon.ru/cookies/'+casper.cli.get(7)+'.json';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}
	
var tstamp = Date.now();

casper.start('https://www.ozon.ru/brand/polaris-17476997/?page=14', function() {
	

			casper.wait(3000, function () {			
						context = this.getHTML();
						fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'1.txt', this.getHTML(), 'w');
						casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'1._'+tstamp+'jpg');

						casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=2', function() {
							
							casper.wait(3000, function () { 
								context = context + this.getHTML();
								fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'2.txt', this.getHTML(), 'w');
								casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'2._'+tstamp+'jpg');
								this.echo(this.getPageContent());
								casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=3', function() { 
									context = context + this.getHTML();
									fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'3.txt', this.getHTML(), 'w');
									casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'3._'+tstamp+'jpg');
									//this.echo(this.getPageContent());

									casper.wait(3000, function () { 
										casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=4', function() {
											context = context + this.getHTML();
											fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'4.txt', this.getHTML(), 'w');
											casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'4._'+tstamp+'jpg');
											//this.echo(this.getPageContent());
											
											casper.wait(3000, function () {
												casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=5', function() {
													context = context + this.getHTML();
													fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'5.txt', this.getHTML(), 'w');
													casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'5._'+tstamp+'jpg');
													//this.echo(this.getPageContent());

													casper.wait(3000, function () {
														casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=6', function() { //
															context = context + this.getHTML();
															fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'6.txt', this.getHTML(), 'w');
															casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'6._'+tstamp+'jpg');
															//this.echo(this.getPageContent());

															casper.wait(3000, function () {
																casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=7', function() {
																	context = context + this.getHTML();
																	fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'7.txt', this.getHTML(), 'w');
																	casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'7._'+tstamp+'jpg');
																	//this.echo(this.getPageContent());

																casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=8', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'8.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'8._'+tstamp+'jpg');
																		//this.echo(this.getPageContent());
casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=9', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'9.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'9._'+tstamp+'jpg');
																		//this.echo(this.getPageContent());
casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=10', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'10.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'10_'+tstamp+'.jpg');
																		//this.echo(this.getPageContent());
casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=11', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'11.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'11_'+tstamp+'.jpg');
																		//this.echo(this.getPageContent());
casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=12', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'12.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'12_'+tstamp+'.jpg');
																		//this.echo(this.getPageContent());
casper.wait(3000, function () {
																	casper.thenOpen('https://www.ozon.ru/brand/polaris-17476997/?page=13', function() {
																		context = context + this.getHTML();
																		fs.write('/var/www/polaris/engines/ozon.ru/content/'+casper.cli.get(7)+'13.txt', this.getHTML(), 'w');
																		casper.capture('/var/www/polaris/engines/ozon.ru/screenshots/'+casper.cli.get(7)+'13_'+tstamp+'.jpg');
																		//this.echo(this.getPageContent());
																		//var cookies = JSON.stringify(phantom.cookies);
																		//fs.write(cookiesPath, cookies, 777);
																		

																		this.echo(context);
																		this.exit();

});});});});});});});});});});});});

																});
															
															});
														});
													});
												});
											});
										});
									});
								});
							});
						});
	    		});




});  
casper.run();
