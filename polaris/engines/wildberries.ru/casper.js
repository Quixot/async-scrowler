var casper = require('casper').create();
casper.options.viewportSize = { width: 1920, height: 1080 };
var fs = require('fs'); // for saving files

var url 	= casper.cli.get(0);
var agent = casper.cli.get(1);
var content = '';

// cityId=5978&regionId=74&city=%d0%a7%d0%b5%d0%bb%d1%8f%d0%b1%d0%b8%d0%bd%d1%81%d0%ba&phone=83512020413&latitude=55,160283&longitude=61,400856
casper.echo('Cookies enabled?: ' + phantom.cookiesEnabled);
/*
phantom.addCookie({
		'domain': '.rbt.ru',
    'name': 'region',
    'value': casper.cli.get(6)
});

phantom.addCookie({
		'domain': '.wildberries.ru',
    'name': '__wbl',
    'value': 'cityId=2008&regionId=2&c...2732&longitude=55,95406'
});

phantom.addCookie({
		'domain': '.wildberries.ru',
    'name': '__store',
    'value': '1733_507_1699'
});

phantom.addCookie({
		'domain': '.wildberries.ru',
    'name': '__region',
    'value': '1_22_38_4_31_33_24_30_39_40'
});

*/




/*
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10) {
		    dd = '0'+dd
		}
		if(mm<10) {
		    mm = '0'+mm
		} */
		//todays = dd + '.' + mm + '.' + yyyy;

//phantom.setProxy('213.219.244.175','7951','manual','rp3061047','JVUpRPrKpj');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.options.waitTimeout = 30000;
casper.userAgent(agent);

//url = 'http://bonus-ua.com';

casper.start(url, function() {
	//this.capture('/var/www/polaris/engines/wildberries.ru/screens/'+time()+'.png');
	casper.wait(5000);
	casper.waitForSelector(".add-discount-catalog-text-price", function then() {
    casper.wait(10000);
    var js = this.evaluate(function() {
			//return document.querySelector('body'); 
			return document.querySelector("html").innerHTML;
		});	
    //fs.write('/var/www/js/engines/rozetka.com.ua/content/'+today.getTime()+'.txt', js, 'w');
    //fs.write('/var/www/polaris/engines/wildberries.ru/screens/1.txt', js, 'w');
    this.echo(JSON.stringify(js)); 
  });
});
casper.run();

