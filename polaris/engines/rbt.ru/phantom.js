var webpage = require('webpage').create();

webpage.open('https://rbt.ru/', function() {

webpage.render('phantom.pdf');

phantom.exit();

});