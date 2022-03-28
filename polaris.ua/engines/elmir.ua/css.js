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
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('171.22.180.223','24531','manual','veffxs','yuzx0AxY');
//casper.options.waitTimeout = 120000;
var fs = require('fs');
var cookiesPath = '/var/www/polaris.ua/engines/elmir.ua/cookies/kiev.txt';
var url = casper.cli.get(0);

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit('no cookies');
}

var global_page_links = casper.cli.get(0).split(",");

casper.start(url, function() {
	this.waitForSelector('#content-container', function() {
		this.echo(this.getHTML());
		//fs.write('/var/www/polaris.ua/engines/elmir.ua/content/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
	});
});
casper.run();

