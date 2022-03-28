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
casper.options.waitTimeout = 30000;

var fs = require('fs');
var cookiesPath = '/var/www/polaris.ua/engines/comfy.ua/cookies/'+casper.cli.get(6)+'.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit('no cookies');
}

var global_page_links = casper.cli.get(0).split(",");

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		casper.waitForSelector('.page-wrap', function() {
			this.echo(this.getTitle());
			fs.write('/var/www/polaris.ua/engines/comfy.ua/content/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
		}).then(function () {
    	this.wait(10000);
    });
	})
});

casper.run();
