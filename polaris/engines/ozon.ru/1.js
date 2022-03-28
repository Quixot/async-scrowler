var casper = require('casper').create({
    viewportSize: {
        width: 1280,
        height: 720,
    },
    pageSettings: {
        loadImages: false,//The script is much faster when this field is set to false
        loadPlugins: false,
        //userAgent: casper.cli.get(1)
        //userAgent: 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
    },
    verbose: true,
    logLevel: "debug"
});
var fs = require('fs');
var url 	= casper.cli.get(0);
//var url = 'http://www.ozon.ru/?context=search&text=vitek&store=1,0';
var agent = casper.cli.get(1);
var context = '';
//var agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0';

//phantom.setProxy('185.127.165.26','443','manual','2vkxCV33D','hv4MzSQeE');
phantom.setProxy(casper.cli.get(2),casper.cli.get(3),'manual',casper.cli.get(4),casper.cli.get(5));

casper.userAgent(agent);

var links;

casper.start('https://www.ozon.ru/search/?text=polaris');

casper.then(function getLinks(){
     links = this.evaluate(function(){
        var links = document.getElementsByClassName('category-link');
        links = Array.prototype.map.call(links,function(link){
            return link.getAttribute('href');
        });
        return links;
    });
});
casper.echo(links);
casper.then(function(){
    this.each(links,function(self,link){
        self.thenOpen(link,function(a){
            this.echo(this.getCurrentUrl());
            this.echo(this.getPageContent())
        });
    });
});
casper.run(function(){
    this.exit();
});
