var casper = require('casper').create({
	  verbose: true,
    logLevel: "debug",
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
});
casper.defaultWaitForTimeout = 20000;
var url = 'https://hotline.ua/bt-elektrochajniki/clatronic-wk-3445/prices/';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('194.87.185.145','3000','manual','lVPvEt','oi86il785');
//casper.userAgent(casper.cli.get(1));



casper.start(url);

//casper.waitForSelector('.shop-box', function() {
	casper.wait(15000, function() {
//casper.waitForResource("https://www.dns-shop.ru/ajax-state/min-price/?cityId=10", function() {
    casper.capture("/var/www/polaris/engines/dns-shop.ru/dns-shop.ru.png");
});
	
//});



casper.run();




