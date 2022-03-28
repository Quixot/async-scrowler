var casper = require("casper").create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    verbose: true,
    logLevel: 'debug'
});
//casper.options.waitTimeout = 220000;
//var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
casper.echo('Cookies enableds?: ' + phantom.cookiesEnabled);
/*
phantom.addCookie({
		'domain': '.rbt.ru',
    'name': 'region',
    'value': casper.cli.get(6)
});
phantom.addCookie({
		'domain': casper.cli.get(9)+'rbt.ru',
    'name': 'ItemsOnPage',
    'value': '44'
});
*/
casper.userAgent(agent);

casper.start(url, function() {
	casper.waitForSelector(".footer", function then() {	
		//casper.waitForUrl(/^https:\/\/rbt.ru/, function() {
	    content = casper.getHTML();
	    casper.echo(content);
	    //console.log(content);
	  //});
	});
	//this.wait(15000);
	//content = this.getHTML();
});

// @TODO: Here pagination regexp. As a result array links
/*
var links = [];
if (casper.cli.get(7) > 1) {
	for (var i = 2; i <= casper.cli.get(7); i++) {
		//links.push(url+'&CurrentPage='+i);
		links.push('https://'+casper.cli.get(9)+'rbt.ru/search/~/page/'+i+'/?q='+casper.cli.get(8));
		//
	}
};

casper.each(links, function(self, link) {
  self.thenOpen(link, function() {
    content = content + this.getHTML();
    //casper.echo(content);
    casper.wait(2000);

  });
});
*/
//casper.wait(1000, function () {
  //casper.capture("ozon.png");
	//fs.write('/var/www/polaris/engines/rbt.ru/casper.js', content, 'w');
	/*
			  var js = casper.evaluate(function() {
					return document.querySelector(".wrapper1000").innerHTML;
				});
				casper.echo(JSON.stringify(js));
				*/
						
				//casper.echo(JSON.stringify(content));
				//casper.echo(content);
//});
casper.run();