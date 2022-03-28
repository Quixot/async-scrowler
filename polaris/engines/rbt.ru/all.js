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
phantom.setProxy('193.151.170.64','24531','manual','veffxs','yuzx0AxY');
casper.options.waitTimeout = 30000;

var fs = require('fs');
var cookiesPath = '/var/www/polaris/engines/rbt.ru/cookies/cook.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit('no cookies');
}

//var regions = ['','kazan','kras','msk','naberezhnye-chelny','novosib','omsk','ufa','vladivostok','ekat'];
var regions = [''];
//var global_page_links = casper.cli.get(0).split(",");

regions.forEach(function(item, i, arr) {
  //casper.echo( item );
	casper.start('https://'+item+'rbt.ru/search/~/page/2/?q=polaris', function() { //https://ekat.rbt.ru/search/~/page/2/?q=polaris
		this.waitForSelector('.header', function () {	
			var url = this.evaluate(function() {
		    return __utils__.getElementByXPath("//span[@class='item-catalogue-list__title-amount']").innerHTML.trim();//return __utils__.getElementByXPath("//a[./text()='CSV']")["href"];
		  });

		  this.echo("GETTING " + url);

			//this.capture("/var/www/polaris/engines/rbt.ru/screen.png");

		});
	});
});
casper.run();
