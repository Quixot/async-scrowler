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
var content = '';
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('171.22.180.223','24531','manual','veffxs','yuzx0AxY');

casper.userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0');

var cookiesPath = '/var/www/polaris/engines/wildberries.ru/cookies/moscow.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}


var global_page_links = casper.cli.get(0).split(",");

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		casper.wait(2000, function() {
			this.echo(this.getHTML());
			//content += this.getHTML();
			fs.write('/var/www/polaris/engines/wildberries.ru/content/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
			this.capture("/var/www/polaris/engines/wildberries.ru/content/"+link.replace(/[^0-9a-zA-Z]/g, '')+".png");
		}).then(function () {
    	this.wait(10000);
    });
	});
});
casper.run();

/*
casper.start('https://www.wildberries.ru/brands/polaris/all', function() {
	casper.wait(3000, function () {	
		//casper.capture("mediamarkt.png");
		content = this.getHTML();
		this.capture("/var/www/polaris/engines/wildberries.ru/screen.png");
		fs.write('/var/www/polaris/engines/wildberries.ru/content.txt', content, 'w');
		//src = content.match(/class=\"total many\".*<span>.*?<\/span>/g)[1];
		//casper.echo(content.match(/Товары <span class=\"num\">(.*?)<\/span>/)[1]);
		//qtt = Math.ceil(src/100)*1;
		
		this.echo(qtt);
	});
});
*/
