var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,
        loadPlugins: false,
    },
    verbose: true,
    logLevel: "info"
});
//casper.options.waitTimeout = 120000;
var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
var cookiesPath = '/var/www/polaris.ua/engines/foxtrot.com.ua/cookies/'+casper.cli.get(6)+'.txt';

// Проверка существуют ли cookies
if (fs.exists(cookiesPath)) {
	phantom.cookies = JSON.parse(fs.read(cookiesPath));
} else {
	casper.exit();
}


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('171.22.180.223', '24531', 'manual','veffxs','yuzx0AxY');
//casper.echo('Cookies enabled?: ' + casper.cli.get(6));
//phantom.addCookie({
//		'domain': '.www.mvideo.ru',
//    'name': 'MVID_CITY_ID',
//    'value': casper.cli.get(6)
//});
casper.userAgent(agent);

casper.start(url, function() {
		//casper.waitForUrl('.searchResults', function() {
	    this.echo(this.getHTML());
	  //});
});
casper.run();
