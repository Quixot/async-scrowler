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



var fs = require('fs');


casper.options.waitTimeout = 40000;


var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

phantom.addCookie({
		'domain': 'shop-polaris.ru',
    'name': 'PHPSESSID',
    'value': casper.cli.get(6)
})

casper.userAgent(agent);
casper.start(url, function() {
	casper.waitForSelector('.product__item', function() {
		var js = this.evaluate(function() {
			return document.querySelector("body").innerHTML;
		});	
		this.echo(this.getHTML());
	});
	//fs.write('/var/www/polaris/engines/shop-polaris.ru/content.txt', this.getHTML(), 'w');
}); 
casper.run();
