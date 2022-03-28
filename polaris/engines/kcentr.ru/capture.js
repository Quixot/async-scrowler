var casper = require("casper").create({
    viewportSize: {
        width: 800,
        height: 600
    },
    pageSettings: {
        loadImages: true,//The script is much faster when this field is set to false
        loadPlugins: false
    },
    verbose: true,
    logLevel: "debug"
});

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

var hour = today.getHours();
var minutes = today.getMinutes();
var sec = today.getSeconds();

if(dd<10) {
    dd = '0'+dd
}
if(mm<10) {
    mm = '0'+mm
} 
time = dd+'.'+mm+'.'+yyyy+'_'+hour+'.'+minutes+'.'+sec;

//casper.options.waitTimeout = 120000;
//var fs = require('fs');
var url 	= casper.cli.get(0);
//var content = '';
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';


phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
//phantom.setProxy('188.165.146.195','7951','manual','gp3070938','dkeyFRoiIs');
casper.echo('Cookies enabled?: ' + casper.cli.get(6));

//'store[city]=Архангельск;store[city_id]=5317;store[kladr]=29000001000;store[manual_select]=1;store[region]=06814fb6-0dc3-4bec-ba20-11f894a0faf5';
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
	//this.waitForSelector('.cardRight', function() {
	
		//this.wait(5000, function () {
			//this.thenClick('button[data-view="list"]', function () {
				//this.wait(5000, function () {
	  			this.capture("/var/www/polaris/engines/kcentr.ru/screenshots/"+time+'_'+casper.cli.get(8)+'_'+casper.cli.get(7)+".png");
	  		//});
	  	//});
	  //});
	//});
});
casper.run();
