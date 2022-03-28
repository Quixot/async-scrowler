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
    logLevel: 'debug'
});
casper.options.waitTimeout = 120000;

//var fs = require('fs');

var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

//casper.options.waitTimeout = 31000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	casper.waitForSelector("#content", function then() {
    
		//return document.querySelector('body'); 
		//var js = casper.evaluate(function() {
			//return this.getPageContent();
		//});
		casper.echo(this.getPageContent());
		//fs.write('/var/www/philips/engines/eldorado.com.ua/response_casper.txt', this.getPageContent(), 'w');
  });
});
casper.run();
