var casper = require("casper").create({
    // other options here
    viewportSize: {
        width: 1920,
        height: 1080
    }
});
var x = require("casper").selectXPath;
var fs = require('fs');
var content = '';
var src = '';
var qtt = 0;

var url 	= casper.cli.get(0);
//var url = 'https://sankt-peterburg.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q=vitek%20maxwell%20rondell';
//var agent = casper.cli.get(1);
var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('213.248.62.4','7951','manual','rp3070434','ptDxV1XxC3');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));
casper.userAgent(agent);

casper.start(url, function() {
	casper.wait(3000, function () {	
		//casper.capture("mediamarkt.png");
		content = this.getHTML();
		src = content.match(/Товары <span class=\"search__num\">(.*?)<\/span>/)[1];
		//casper.echo(content.match(/Товары <span class=\"num\">(.*?)<\/span>/)[1]);
		qtt = Math.ceil(src/72)*1;
		//fs.write('/var/www/content.json', content, 'w');
	});
});

var global_page_links = [];

casper.then(function(){
    for(var i=2; i<=qtt; i++){    
        // you just add all your links to array, and use it in casper.each()
        global_page_links.push(url+'&page='+i);
    }

    this.each(global_page_links, function(self, link) {
        if (link){
            self.thenOpen(link, function() {
                //console.log("OPENED: "+this.getCurrentUrl());
                // do here what you need, evaluate() etc.
                content = content + this.getHTML();
            });
            casper.wait(7000);
        }
    });
});

casper.wait(1000, function () {
  //casper.capture("ozon.png");
	//fs.write('/var/www/engines/poiskhome.ru/content.json', content, 'w');
	/*
			  var js = casper.evaluate(function() {
					return document.querySelector(".wrapper1000").innerHTML;
				});
				casper.echo(JSON.stringify(js));
				*/
				casper.echo(JSON.stringify(content));
});

casper.run();
