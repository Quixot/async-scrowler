var casper = require('casper').create();

//casper.options.waitTimeout = 40000;
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

//casper.options.waitTimeout = 20000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	casper.wait(3000, function () {
    	var js = this.evaluate(function() {
			//return document.querySelector('body'); 
			return document.querySelector("body").innerHTML;
		});	
    this.echo(JSON.stringify(js)); 
  });
});
casper.run();
