var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
});
casper.options.waitTimeout = 25000;
casper.defaultWaitForTimeout = 20000;
var url = 'http://www.frau-technica.ru/';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('194.87.185.145','3000','manual','lVPvEt','oi86il785');
//casper.userAgent(casper.cli.get(1));



casper.start(url);

casper.waitForSelector('.logo-container', function() {
	this.thenClick('.city-select', function () {
		casper.waitForSelector('#search-city', function() {
			casper.wait(25000, function () {
				casper.then(function() {
			    this.mouse.click("#search-city"); 
				});

				casper.sendKeys('#search-city', casper.cli.get(6), {keepFocus: true});

				casper.wait(2000, function () {
					casper.then(function() {
					  this.sendKeys("#search-city", this.page.event.key.Enter, {keepFocus: false});
					});
				});

				casper.wait(2000);

			});


		}); // wait #search-city
	});
		//#search-city
  //this.capture("/var/www/engines/frau-technica.ru/frau-technica.ru.png");
});

casper.thenOpen('http://www.frau-technica.ru/search/?q='+casper.cli.get(0), function() {
    //this.capture("/var/www/engines/frau-technica.ru/frau-technica.ru.png");
    //casper.echo(JSON.stringify(this.getHTML()));
    var js = casper.evaluate(function() {
					return document.querySelector("#search-results").innerHTML;
				});
				casper.echo(JSON.stringify(js));
 		});

casper.run();




