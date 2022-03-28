var page = require("webpage").create();
var homePage = "http://www.dns-shop.ru/search/?q=vitek";
page.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0'
page.settings.javascriptEnabled = false;
page.settings.loadImages = false;
page.open(homePage);
page.onLoadFinished = function(status) {
var url = page.url;

console.log("Status: " + status);
console.log("Loaded: " + url);
page.render("google.png");
phantom.exit();
};