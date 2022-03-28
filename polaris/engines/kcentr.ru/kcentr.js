var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: false,}, verbose: true, logLevel: "debug"});
//casper.options.waitTimeout = 60000;
casper.options.waitTimeout = 150000;
var fs = require('fs');
var x = require('casper').selectXPath;
var url 	= casper.cli.get(0);
var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
casper.echo('Cookies enabled?: ' + casper.cli.get(6));
var cook = casper.cli.get(6).split(";");

phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'store[city]',
    'value': cook[0]
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'store[city_id]',
    'value': cook[1]
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'store[kladr]',
    'value': cook[2]
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'store[manual_select]',
    'value': '1'
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'store[region]',
    'value': cook[4]
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'sort[sortBy]',
    'value': 'price'
});
phantom.addCookie({
		'domain': '.kcentr.ru',
    'name': 'sort[sortDir]',
    'value': 'asc'
});

casper.userAgent(agent);

casper.start(url, function() {
	//
	
	
	//this.click(x('//*[contains(text(),"Каталог")]'));
	//this.sendKeys('input#header-search-input', 'polaris', {keepFocus: true});
	//this.thenClick('input#header-search-input');
	//this.sendKeys('input#header-search-input', casper.page.event.key.Enter, {keepFocus: true});
	//casper.waitForSelector('.product', function() {
	this.mouse.move(400, 300);
	casper.wait(15000, function() {	
    //casper.echo(this.getHTML());
    fs.write('/var/www/polaris/engines/kcentr.ru/content.txt', this.getHTML(), 'w');
    this.capture('/var/www/polaris/engines/kcentr.ru/screen.png');
  });
	/**/
});
casper.run();
