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

var fs = require('fs');
var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

//casper.options.waitTimeout = 31000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start('https://eldorado.ua/kettles/c1039051/producer=polaris/')
    .then(function () {
    	fs.write('/var/www/polaris.ua/engines/eldorado.ua/content.txt', this.getPageContent(), 'w');
      //this.mouse.move('.react-autosuggest__input'); // Trigger :hover state
    })
    .then(function () {
    	//this.sendKeys('.react-autosuggest__input', casper.cli.get(6), {keepFocus: true});
	    //this.sendKeys('.react-autosuggest__input', casper.page.event.key.Enter, {keepFocus: true});
      //  this.mouse.down('.react-autosuggest__input'); // Trigger :active state
        //this.wait(3000);
      this.capture("/var/www/polaris.ua/engines/eldorado.ua/screen.png");
    });


casper.run();
