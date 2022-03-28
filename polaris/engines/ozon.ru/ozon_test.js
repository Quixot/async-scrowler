var casper = require('casper').create();
//var fs = require('fs');
var url 	= casper.cli.get(0);
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

casper.start(url, function() {
	//this.thenClick('.jsButton', function () {
	

			  var js = casper.evaluate(function() {
					return document.querySelector("body").innerHTML;
				});
				casper.echo(JSON.stringify(js));

});  
casper.run();
