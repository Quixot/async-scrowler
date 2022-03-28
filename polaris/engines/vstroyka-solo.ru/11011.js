var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: false, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 20000;
//casper.options.waitTimeout = 120000;
var fs = require('fs');
var url 	= casper.cli.get(0);
var x = require('casper').selectXPath;
var context = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
//var cookiesPath = '/var/www/polaris/engines/imperiatechno.ru/cookies/cook.txt';

// Проверка существуют ли cookies
//if (fs.exists(cookiesPath)) 
//	phantom.cookies = JSON.parse(fs.read(cookiesPath));

phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
//casper.echo('Cookies enabled?: ' + casper.cli.get(6));

casper.userAgent(agent);
//listView
casper.start('https://vstroyka-solo.ru/', function() {
	this.sendKeys('input#srchFld', casper.cli.get(6), {keepFocus: true});
	this.sendKeys('input#srchFld', casper.page.event.key.Enter, {keepFocus: true});	
	this.then(function() {
		this.waitForSelector('#listView', function () {
			context = this.getHTML('#listView'); // 1
			this.echo('TRYING TO SAVE PAGE: # 1 !!!');
			//this.echo(JSON.stringify(this.getHTML('#listView')));
			//this.echo('TRYING TO SAVE PAGE: # 1 !!!');
			fs.write('/var/www/polaris/engines/vstroyka-solo.ru/content/11011_1.txt', this.getHTML(), 'w');
			this.wait(2000);
			this.click(x('//*[@div.class="pagination">li and text()="9"]'));
			this.waitForSelector('#listView', function () {
				this.wait(5000);
				context = context+this.getHTML('#listView');
				this.echo('TRYING TO SAVE PAGE: # 10 !!!');
				//this.echo(JSON.stringify(this.getHTML('#listView')));
				fs.write('/var/www/polaris/engines/vstroyka-solo.ru/content/11011_2.txt', this.getHTML(), 'w');
				this.wait(2000);
				this.click(x('//*[@div.class="pagination">li and text()="11"]'));
				this.waitForSelector('#listView', function () {
					context = context+this.getHTML('#listView');  // 3
					this.echo('TRYING TO SAVE PAGE: # 11 !!!');
					//this.echo(JSON.stringify(this.getHTML('#listView')));
					//this.wait(20000);
					//fs.write('/var/www/polaris/engines/vstroyka-solo.ru/content/11011.txt', context, 'w');									
					//this.capture("/var/www/polaris/engines/vstroyka-solo.ru/ozon.png");
					//fs.write('/var/www/polaris/engines/vstroyka-solo.ru/content.txt', this.getHTML(), 'w');
					//this.echo(JSON.stringify(this.getHTML('#listView')));  
					this.echo(context);	
					fs.write('/var/www/polaris/engines/vstroyka-solo.ru/content/11011_3.txt', this.getHTML(), 'w');			
				});
			});
  	});
	});
});

casper.run();
