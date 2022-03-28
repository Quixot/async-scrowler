var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
});
casper.options.waitTimeout = 25000;
var url = 'http://www.dns-shop.ru/';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('194.87.185.145','3000','manual','lVPvEt','oi86il785');
//casper.userAgent(agent);
phantom.cookiesEnabled = true;
phantom.javascriptEnabled = true;



casper.start();
casper.thenOpen(url);

casper.wait(15000, function then() {
    var js = this.evaluate(function() {
		//return document.querySelector('body'); 
		return document.querySelector("body").innerHTML;
	});	
    this.echo(JSON.stringify(js));
    this.capture("/var/www/engines/frau-technica.ru/dns-shop.ru.png");
});

casper.run();
