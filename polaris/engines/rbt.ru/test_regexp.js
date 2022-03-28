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
casper.options.waitTimeout = 20000;

var fs = require('fs');
var x = require('casper').selectXPath;

//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('193.43.147.167','24531','manual','veffxs','yuzx0AxY');
casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0');

var cookiesPath = '/var/www/polaris/engines/rbt.ru/cook.txt';
var response = '/var/www/polaris/engines/rbt.ru/content.txt';
var content;

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
	response = fs.read(response);
} else {
	casper.exit();
}

casper.start();
var classVal = x("//a[@class='item-catalogue-list__title-amount']");
	//src = content.match(/item-catalogue-list__title-amount">(.*?)<\/span>/)[1];
	casper.echo(classVal);

casper.run();
