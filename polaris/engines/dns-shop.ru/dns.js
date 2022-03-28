var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: true,
        loadPlugins: true
    },
    verbose: true,
    logLevel: "debug"
});
casper.options.waitTimeout = 166000;
var fs = require('fs');
var url 	= casper.cli.get(0);
var content = '';
var url = 'https://www.dns-shop.ru/catalog/17a8cd3716404e77/pylesosy/';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
//casper.echo('Cookies enabled?: ' + casper.cli.get(6));
phantom.addCookie({
		'domain': '.dns-shop.ru',
    'name': 'current_path',
    'value': casper.cli.get(6)
});
casper.userAgent(agent);

casper.start(url, function() {
		//casper.waitForUrl('https://www.dns-shop.ru/ajax-state/price/', function() {
		this.wait(5000, function() {
			this.mouse.move('dive[class="product-info"]');
			this.scrollToBottom();
		//
			this.waitForSelector('.product-price__current', function then() {		     

					this.echo(this.getHTML());
	    		this.capture('/var/www/polaris/engines/dns-shop.ru/content.png');
	    		fs.write('/var/www/polaris/engines/dns-shop.ru/content.txt', this.getHTML(), 'w');


			});

	    
	 	});
});
casper.run();
