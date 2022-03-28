var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        //userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    },
    verbose: true,
    logLevel: "debug"
});
//var fs = require('fs');
var fs = require('fs');
var cookiesPath = '/var/www/philips/engines/elmir.ua/cookies/'+casper.cli.get(2)+'.'+casper.cli.get(3)+'.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath))
  phantom.cookies = JSON.parse(fs.read(cookiesPath));

var url 	= casper.cli.get(0);
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var context = '';
var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url
	//this.waitForSelector('.header', function () {
	.then(function () {	
	  var url = this.evaluate(function() {
	  	//return __utils__.getElementByXPath("//a[./text()='CSV']")["href"];
	    return __utils__.getElementByXPath("//span[@class='item-catalogue-list__title-amount']").innerHTML.trim();
	  });

	  this.echo("GETTING " + url);

		this.capture("/var/www/polaris/engines/rbt.ru/screen.png");
	})
	.thenOpen(url

	//});
});
casper.run();


casper.start(url, function() {
	//casper.waitForSelector('#container', function() {
	casper.wait(10000, function() {
	    this.echo(this.getPageContent());
			
			if (phantom.cookies) {
				this.echo(phantom.cookies);
				fs.write(cookiesPath, JSON.stringify(phantom.cookies), 644);
			}

	});
	
});  
casper.run();
