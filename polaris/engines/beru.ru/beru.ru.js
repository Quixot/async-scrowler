var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: true,//The script is much faster when this field is set to false
        loadPlugins: true
        //userAgent: casper.cli.get(1)
        //userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
    //clientScripts:  [
    //    '/var/www/polaris/engines/beru.ru/jquery-1.9.1.js'
    //]
});

phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
casper.echo('Cookies enabled?: ' + phantom.cookiesEnabled);



casper.options.waitTimeout = 60000;

var fs = require('fs');
var url 	= casper.cli.get(0);
var url = 'https://beru.ru/';

var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('5.101.5.82','3000','manual','lVPvEt','oi86il785');

casper.userAgent(agent);


casper.start(url, function() {

	
	this.mouse.move('.link__inner');
	this.wait(2000);
	//this.waitForSelector(".region-form-opener_js_inited", function() {
  /*
  this.evaluate(function() {
    $('.unique-selling-proposition-line__list').remove();
    $('.layout_type_maya header2__main-content').remove();
    $('#SearchTitle').remove();
    $('.header2__left').remove();
    $('.header2__navigation').remove();
    $('.header2__search').remove();
  });
	*/
		this.thenClick('.link__inner', function() {
			this.wait(2000);
			//this.waitForSelector(".region-form-opener_js_inited", function() {
			  this.capture("/var/www/polaris/engines/beru.ru/1.png");
			  fs.write('/var/www/polaris/engines/beru.ru/content.txt', this.getHTML(), 'w');
			//});
		});
	//});
});

casper.run();
