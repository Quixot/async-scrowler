var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: true,//The script is much faster when this field is set to false
        loadPlugins: true,
        //userAgent: casper.cli.get(1)
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
});

casper.options.waitTimeout = 20000;
casper.defaultWaitForTimeout = 20000;
var url = 'http://www.frau-technica.ru/';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('213.155.11.100','7384','manual','ua70342','5nh5j4UjYC');
//casper.userAgent(casper.cli.get(1));



casper.start();
console.log("Loaded: " + url);

casper.thenOpen(url);

//casper.waitForSelector("#scroll-top-button", function then() {
    var js = casper.evaluate(function() {
		//return document.querySelector('body'); 
		return document.querySelector("body").innerHTML;
	});	
    casper.echo(JSON.stringify(js));
    console.log("content: " + JSON.stringify(js));
//});

casper.run();
