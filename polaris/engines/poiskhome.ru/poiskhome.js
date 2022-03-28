var casper = require('casper').create();
casper.options.viewportSize = { width: 1920, height: 1080 };
var fs = require('fs');
var content = '';
//var url 	= casper.cli.get(0);
//var url = 'http://poiskhome.ru/Home/SearchResult?SearchText='+casper.cli.get(0);
var url = 'https://'+casper.cli.get(6)+'poiskhome.ru/Home/SearchResult?SearchText='+casper.cli.get(0);
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('213.248.62.4','7951','manual','rp3070434','ptDxV1XxC3');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

casper.start(url, function() {
	this.wait(6000);
	//this.thenClick('.store_location-link', function () {
	//	casper.wait(6000, function () {
	//		casper.then(function() {
				//casper.capture('/var/www/engines/poiskhome.ru/screen.jpg');
	//	    casper.click('.select-city-item[data-cityid="'+casper.cli.get(6)+'"]');
	//	    casper.wait(5000);
		    //casper.capture('/var/www/engines/poiskhome.ru/screen2.jpg');
	//		});
	//	});	
	//});
});

// @TODO: Here pagination regexp. As a result array links
var links = [];//'http://poiskhome.ru/Home/SearchResult?SearchText=rondell&CurrentPage=3'

for (var i = 1; i <= casper.cli.get(7); i++) {
	links.push(url+'&CurrentPage='+i);
}

casper.each(links, function(self, link) {
  self.thenOpen(link, function() {
    content = content + this.getHTML();
  });
});

casper.wait(1000, function () {
  //casper.capture("ozon.png");
	//fs.write('/var/www/engines/poiskhome.ru/content.json', content, 'w');
	/*
			  var js = casper.evaluate(function() {
					return document.querySelector(".wrapper1000").innerHTML;
				});
				casper.echo(JSON.stringify(js));
				*/
				casper.echo(JSON.stringify(content));
});
casper.run();
