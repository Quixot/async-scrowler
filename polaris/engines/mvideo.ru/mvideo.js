var casper = require('casper').create({viewportSize: {width: 1920, height: 1080}, pageSettings: {loadImages: true, loadPlugins: false,}, verbose: true, logLevel: "debug"});
casper.options.waitTimeout = 60000;
//casper.options.waitTimeout = 120000;
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
phantom.addCookie({
		'domain': '.www.mvideo.ru',
    'name': 'MVID_CITY_ID',
    'value': casper.cli.get(6)
});
casper.userAgent(agent);

casper.start(url, function() {
	//
	
	
	this.click(x('//*[contains(text(),"Каталог")]'));
	//this.sendKeys('input#header-search-input', 'polaris', {keepFocus: true});
	//this.thenClick('input#header-search-input');
	//this.sendKeys('input#header-search-input', casper.page.event.key.Enter, {keepFocus: true});
	//casper.waitForSelector('.app__page-content', function() {
	casper.wait(5000, function() {	
    //casper.echo(this.getHTML());
    fs.write('/var/www/polaris/engines/mvideo.ru/content.txt', this.getHTML(), 'w');
    this.capture('/var/www/polaris/engines/mvideo.ru/screen.png');
  });
	/**/
});
casper.run();
