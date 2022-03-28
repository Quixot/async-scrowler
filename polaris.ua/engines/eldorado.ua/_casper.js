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
    logLevel: "info"
});


var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

//casper.options.waitTimeout = 31000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	//this.waitForSelector(".goods", function then() {
    this.echo(this.getPageContent());
    //this.capture("/var/www/polaris.ua/engines/eldorado.ua/screen.png");
  //});
});
casper.run();
