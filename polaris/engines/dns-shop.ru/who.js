var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    }
});
casper.options.waitTimeout = 100000;
var url = 'http://www.frau-technica.ru/';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';
//phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
phantom.setProxy('194.87.185.145','3000','manual','lVPvEt','oi86il785');
//casper.userAgent(agent);



casper.start(url);

casper.waitForSelector('.ui-corner-all', function() {
  this.capture("/var/www/engines/dns-shop.ru/frau.png");
});


casper.run();




