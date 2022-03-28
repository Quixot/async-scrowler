var casper = require('casper').create();
var fs = require('fs');
var content = '';
//var url 	= casper.cli.get(0);
var url = 'http://poiskhome.ru/Home/SearchResult?SearchText=rondell';
//var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

phantom.setProxy('213.219.244.148','7951','manual','rp3070434','ptDxV1XxC3');
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

// @TODO: Move this array down just before each block


casper.start(url, function() {
	this.thenClick('.store_location-link', function () {

		casper.wait(1000, function () {
			casper.then(function() {
		    casper.click('.select-city-item[data-cityid="3"]');
			});
		});
		content = content + casper.getHTML();	
	});
	});

// @TODO: Add here preg_match pagination. links array as a result
var links = [
    'http://poiskhome.ru/Home/SearchResult?SearchText=rondell&CurrentPage=2'
    //'http://poiskhome.ru/Home/SearchResult?SearchText=rondell&CurrentPage=3'
];

	casper.each(links, function(self, link) {
    self.thenOpen(link, function() {
        content = content + this.getHTML();
    });
});

			casper.wait(1000, function () {
			  //casper.capture("ozon.png");
			  fs.write('/var/www/engines/poiskhome.ru/content.json', content, 'w');
			  /*
			  var js = casper.evaluate(function() {
					return document.querySelector(".wrapper1000").innerHTML;
				});
				casper.echo(JSON.stringify(js));
				*/
			});

casper.run();
