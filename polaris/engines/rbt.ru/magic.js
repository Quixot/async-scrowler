var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,
        loadPlugins: false
    },
    verbose: true,
    logLevel: "debug"
});
casper.options.waitTimeout = 30000;

var fs = require('fs');
var x = require('casper').selectXPath;
var content = '';
var url = 'https://rbt.ru/';

//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0');

var cookiesPath = '/var/www/polaris/engines/rbt.ru/cookies/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}

casper.start(url, function() {
		this.waitForSelector('.footer', function () {
casper.echo(JSON.stringify(this.getHTML()));
	  });
});
casper.run();
