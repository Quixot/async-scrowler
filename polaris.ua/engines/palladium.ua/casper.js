var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0'
    },
    verbose: true,
    logLevel: "debug"
});

var fs = require('fs');
var url 	= casper.cli.get(0);
//var agent = casper.cli.get(1);
//var content = '';

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.options.waitTimeout = 60000;
//casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	this.waitForSelector(".content", function then() {
		fs.write('/var/www/polaris.ua/engines/palladium.ua/content.txt', this.getHTML(), 'w');
    this.echo(this.getHTML());
  });
});
casper.run();
