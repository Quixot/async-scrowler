<?php 
$options 			 = array(CURLOPT_COOKIE => 'iRegionSectionId=' . $region); // Подставляем coockie региона
$urlStart 		 = 'http://www.eldorado.ru/search/catalog.php?PAGEN_SEARCH=';  // Первая часть адреса
$urlEnd				 = '&list_num=20&q=' . ENGINE_TYPE;														 // Вторая часть адреа и поисковая строка
$regexpPagin	 = "~<div class=\"quantity\">(.+)<~isU"; 											 // К-во найденых товаров
$regexpPrices1 = "~<div class=\"itemInfo\">(.+)<a data-position~isU";  				 // Все карточки на странице
$regexpPrices2 = "~<div class=\"itemDescription\".*<a href=\"(.+)\".*>(.+)</a>.*itemPrice\">(.+)<span~isU"; // Карточки товара
$regexpRegion = "~<a class=\"headerRegionName\".*>.*>(.+)<~isU";
