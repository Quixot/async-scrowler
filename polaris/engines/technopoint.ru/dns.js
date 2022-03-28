var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    }
});
casper.options.waitTimeout = 20000;
//var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
casper.echo('Cookies enabled?: ' + casper.cli.get(6));
phantom.addCookie({
		'domain': '.technopoint.ru',
    'name': 'current_path',
    'value': casper.cli.get(6)
});
casper.userAgent(agent);

casper.start(url, function() {
	//casper.waitForSelector('.product-price__current', function() { 
	//this.scrollToBottom();
	//this.mouse.move('.sentence-period');
	this.wait(60000, function () {
		//this.scrollToBottom();
					this.scrollPosition = {
  top: 100,
  left: 0
};

  //casper.capture("ozon.png");
	//fs.write('/var/www/polaris/engines/rbt.ru/casper.js', content, 'w');
	/*
			  var js = casper.evaluate(function() {
					return document.querySelector(".wrapper1000").innerHTML;
				});
				casper.echo(JSON.stringify(js));
				*/

		this.capture("/var/www/polaris/engines/technopoint.ru/dns.png");
		this.echo(JSON.stringify(this.getHTML()));
		
	});

	  //});
});
casper.run();
