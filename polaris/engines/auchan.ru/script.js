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
//casper.options.waitTimeout = 120000;
//var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
/*
casper.echo('Cookies enabled?: ' + casper.cli.get(6));
phantom.addCookie({
		'domain': '.auchan.ru',
    'name': 'user_shop_name',
    'value': casper.cli.get(6)
});
phantom.addCookie({
		'domain': '.auchan.ru',
    'name': 'user_shop_id_render',
    'value': casper.cli.get(7)
});
phantom.addCookie({
		'domain': '.auchan.ru',
    'name': 'user_shop_id',
    'value': casper.cli.get(8)
});
phantom.addCookie({
		'domain': '.auchan.ru',
    'name': 'insdrSV',
    'value': casper.cli.get(9)
});
*/
casper.userAgent(agent);

casper.start(url, function() {
	this.waitForSelector('#root', function () {
		this.echo(this.getPageContent());
		this.capture("/var/www/polaris/engines/auchan.ru/screen.png");
		this.exit();
	});
});

casper.run();
