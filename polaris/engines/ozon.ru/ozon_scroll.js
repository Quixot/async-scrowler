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
		this.thenClick('.city-name', function () {
	    this.sendKeys('input[placeholder="Поиск по городу, индексу"]', casper.cli.get(6), {keepFocus: true});

			casper.wait(200, function () {
				casper.then(function() {
			    this.mouse.move('input[placeholder="Поиск по городу, индексу"]'); 
				});
			});

			casper.wait(200, function () {
				casper.then(function() {
				  this.sendKeys('input[placeholder="Поиск по городу, индексу"]', this.page.event.key.Enter, {keepFocus: false});
				});
			});			

			casper.wait(200, function () {			
				casper.thenOpen('https://www.ozon.ru/brand/17476997/', function() {

    			//casper.wait(500, function () {	
	    			//this.echo(this.getPageContent());
        		//context = this.getHTML();
	    			//fs.write('/var/www/polaris/engines/ozon.ru/ozon.json', casper.getPageContent(), 'w');
	    			//casper.capture("/var/www/polaris/engines/ozon.ru/ozon.png");

						for (i = 0; i < 5; i++) { 
							casper.wait(2000, function () {
								casper.echo('scroll attempt '+i);
						    casper.scrollToBottom();
						    casper.sendEvent('keypress', page.event.key.PageUp, null, null, 0x04000000 | 0x02000000);
						    casper.sendEvent('keypress', page.event.key.PageUp, null, null, 0x04000000 | 0x02000000);
						    casper.sendEvent('keypress', page.event.key.PageUp, null, null, 0x04000000 | 0x02000000);
							});
							//context = context + this.getHTML();	
						}
						
						//this.echo(context);
											fs.write('/var/www/polaris/engines/ozon.ru/ozon.json', casper.getHTML(), 'w');
											this.echo(this.getHTML());
											this.exit();

						

	    		//});
				});
			});
		});
	};
});  
casper.run();
