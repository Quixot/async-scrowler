var casper = require("casper").create({
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
casper.options.waitTimeout = 120000;
//var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
phantom.addCookie({
		'domain': 'www.eldorado.ru',
    'name': 'iRegionSectionId',
    'value': casper.cli.get(6)
});

casper.userAgent(agent);

casper.start(url, function() {
		/*
		casper.waitForSelector('.sku-card-small', function() {
	    content = this.getHTML();
	  });
		*/
  //casper.capture("ozon.png");
	//fs.write('/var/www/polaris/engines/rbt.ru/casper.js', content, 'w');
	casper.waitForSelector('.item', function() {
			  //this.echo('HIIIIIIII');
			  //this.capture("/var/www/polaris/engines/eldorado.ru/eldorado.png");
			  var js = this.evaluate(function() {
					return document.querySelector("html").innerHTML;
				});
				this.echo(js);
	});			
});
casper.run();
