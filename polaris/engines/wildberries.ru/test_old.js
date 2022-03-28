var casper = require('casper').create({
    viewportSize: {
        width: 1920,
        height: 1080
    },
    pageSettings: {
        loadImages: false,
        loadPlugins: false
    },
    verbose: true,
    logLevel: "debug"
});


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko');

casper.start('https://security.wildberries.ru/login?returnUrl=https%3A%2F%2Fwww.wildberries.ru%2F', function() {
	this.thenClick('.j-s-show-pass-login', function () {
		this.waitForSelector('#Item_Login', function () {
			this.sendKeys('#Item_Login', 'aschsss@yandex.ru');
			this.sendKeys('#Item_Password', 'FF9qjZKXxQRCPPg');
			this.thenClick('#signIn', function () {
			this.wait(10000, function () {			
				this.capture("/var/www/polaris/engines/wildberries.ru/screen.png");
			});
			});
	  });
	});
});
casper.run();
