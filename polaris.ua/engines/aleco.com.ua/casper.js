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
var cookiesPath = '/var/www/polaris.ua/engines/aleco.com.ua/cookies/kiev.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('176.125.241.122','24531','manual','veffxs','yuzx0AxY');

casper.options.waitTimeout = 60000;
//casper.userAgent(agent);
var global_page_links = ['https://aleco.com.ua/katalog-produkcii/?brand=polaris','https://aleco.com.ua/katalog-produkcii/2/?brand=polaris','https://aleco.com.ua/katalog-produkcii/3/?brand=polaris','https://aleco.com.ua/katalog-produkcii/4/?brand=polaris'];

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		casper.waitForSelector('.content', function() {
			this.echo(this.getHTML());
			fs.write('/var/www/polaris.ua/engines/aleco.com.ua/content/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
		}).then(function () {
    	this.wait(3000);
    });
	})
});

casper.run();
