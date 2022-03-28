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
var url 	= casper.cli.get(0);
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	casper.wait(5000);
	if (casper.getHTML()) {
		this.thenClick('.city-name', function () {
	    this.sendKeys('.input', casper.cli.get(6), {keepFocus: true});
/*
			casper.wait(5000, function () {
				casper.then(function() {
			    this.mouse.move(".eAutocomplete_list"); 
				});
			});
*/
			casper.wait(5000, function () {
				casper.then(function() {
				  this.sendKeys('.b-select', this.page.event.key.Enter, {keepFocus: false});
				});
			});

			casper.wait(7000, function () {				
				casper.wait(7000, function () {
				  casper.capture("/var/www/polaris/engines/ozon.ru/ozon.png");
				  //fs.write('ozon.json', this.getPageContent(), 'w');
				  var js = casper.evaluate(function() {
						return document.querySelector("body").innerHTML;
					});
					casper.echo(JSON.stringify(js));
				});
			});
		});
	};
});  
casper.run();
