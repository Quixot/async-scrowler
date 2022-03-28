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
var cookiesPath = '/var/www/polaris.ua/engines/f.ua/cookies/kiev.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
	fs.remove(cookiesPath);
} else {
	casper.exit('no cookies');
}

var global_page_links = casper.cli.get(0).split(",");

/*
for (var i = 0; i < global_page_links.length; i++) {
  casper.echo(i+': '+global_page_links[i].replace(/[^0-9a-zA-Z]/g, ''));
  //ещё какие-то выражения
}
casper.exit();
*/

casper.start().each(global_page_links, function(self, link) {
	self.thenOpen(link, function() {
		casper.waitForSelector('.header_main', function() {
			this.echo(this.getTitle());
			fs.write('/var/www/polaris.ua/engines/f.ua/content/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
			fs.write('/var/www/polaris.ua/engines/f.ua/content2/'+link.replace(/[^0-9a-zA-Z]/g, '')+'.txt', this.getHTML(), 'w');
		}).then(function () {
    	this.wait(15000);
    });
	})
});


/*
casper.start(global_page_links[0], function() {
	casper.waitForSelector('.catalog_product_list', function() {
		//this.capture("/var/www/polaris.ua/engines/f.ua/f.png");
		fs.write('/var/www/polaris.ua/engines/f.ua/content/'+global_page_links_id[0]+'.txt', this.getHTML(), 'w');

	  for (var i = 1; i < global_page_links.length; i++) {
	    this.thenOpen(global_page_links[i], function() {
				console.log("OPENED: "+global_page_links[i]);
				casper.waitForSelector('.catalog_product_list', function() {
				// do here what you need, evaluate() etc.
				//content = content + this.getHTML();
					fs.write('/var/www/polaris.ua/engines/f.ua/content/'+global_page_links_id[i]+'.txt', this.getHTML(), 'w');
					
					this.wait(10000);
				});
	    });
	  }
  });
});
*/
casper.run();

