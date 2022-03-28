var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        //userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    },
    verbose: true,
    logLevel: "debug"   
});

var x = require('casper').selectXPath;

var fs = require('fs');


casper.options.waitTimeout = 30000;


var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

var url = 'https://shop-polaris.ru/';
var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
//phantom.setProxy('109.237.104.56','24531','manual','veffxs','yuzx0AxY');

//

casper.userAgent(agent);
casper.start(url, function() {
	fs.write('/var/www/polaris/engines/shop-polaris.ru/content.txt', this.getPageContent(), 'w');
	
	var js = casper.evaluate(function() {
		casper.click(x('//span[text()="Санкт-Петербург"]/..', function() {
			casper.capture('/var/www/polaris/engines/shop-polaris.ru/screen.png');
		}));
		return document.querySelector("body").innerHTML;
	});
	casper.echo(JSON.stringify(js));

			
}); 
casper.run();
