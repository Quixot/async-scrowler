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

casper.options.waitTimeout = 36000;

var fs = require('fs');
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

//var cookiesPath = '/var/www/polaris.ua/engines/stylus.ua/cookies/kiev.txt';

// Проверка существуют ли cookies
//if (fs.exists(cookiesPath)) {
//	phantom.cookies = JSON.parse(fs.read(cookiesPath));
//} else {
//	casper.exit();
//}

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

//casper.options.waitTimeout = 31000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	//casper.waitForSelector(".main-wrapper", function then() {
    this.echo(this.getHTML());
  //});
});
casper.run();
