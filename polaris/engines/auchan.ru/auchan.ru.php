<?php
/**
 * auchan.ru
 */
	switch (EXTRA_PARAM) {
		case 'moscow': $region = 'user_shop_name=%25D0%259C%25D0%25BE%25D1%2581%25D0%25BA%25D0%25B2%25D0%25B0;user_shop_id_render=1;user_shop_id=1;insdrSV=12'; $city = 'Москва'; break;
		case 'spb': $region = 'user_shop_name=%25D0%25A1%25D0%25B0%25D0%25BD%25D0%25BA%25D1%2582-%25D0%259F%25D0%25B5%25D1%2582%25D0%25B5%25D1%2580%25D0%25B1%25D1%2583%25D1%2580%25D0%25B3;user_shop_id_render=201;user_shop_id=201;insdrSV=13'; $city = 'Санкт-Петербург'; break;
		case 'arhangelsk': $region = 'user_shop_name=%25D0%2590%25D1%2580%25D1%2585%25D0%25B0%25D0%25BD%25D0%25B3%25D0%25B5%25D0%25BB%25D1%258C%25D1%2581%25D0%25BA;user_shop_id_render=436;user_shop_id=436;insdrSV=21'; $city = 'Архангельск (Архангельская обл.)'; break;
		case 'chelyabinsk': $region = 'user_shop_name=%25D0%25A7%25D0%25B5%25D0%25BB%25D1%258F%25D0%25B1%25D0%25B8%25D0%25BD%25D1%2581%25D0%25BA;user_shop_id_render=229;user_shop_id=229;insdrSV=17'; $city = 'Челябинск'; break;
		case 'habarovsk': $region = 'user_shop_name=%25D0%25A5%25D0%25B0%25D0%25B1%25D0%25B0%25D1%2580%25D0%25BE%25D0%25B2%25D1%2581%25D0%25BA;user_shop_id_render=3986;user_shop_id=3986;insdrSV=22'; $city = 'Хабаровск'; break;
		case 'kazan': $region = 'user_shop_name=%25D0%259A%25D0%25B0%25D0%25B7%25D0%25B0%25D0%25BD%25D1%258C;user_shop_id_render=156;user_shop_id=156;insdrSV=16'; $city = 'Казань'; break;
		case 'krasnodar': $region = 'user_shop_name=%25D0%259A%25D1%2580%25D0%25B0%25D1%2581%25D0%25BD%25D0%25BE%25D0%25B4%25D0%25B0%25D1%2580;user_shop_id_render=165;user_shop_id=165;insdrSV=18'; $city = 'Краснодар'; break;
		case 'krasnoyarsk': $region = 'user_shop_name=%25D0%259A%25D1%2580%25D0%25B0%25D1%2581%25D0%25BD%25D0%25BE%25D1%258F%25D1%2580%25D1%2581%25D0%25BA;user_shop_id_render=1945;user_shop_id=1945;insdrSV=23'; $city = 'Красноярск'; break;
		case 'novgorod': $region = 'user_shop_name=%25D0%259D%25D0%25B8%25D0%25B6%25D0%25BD%25D0%25B8%25D0%25B9%2520%25D0%259D%25D0%25BE%25D0%25B2%25D0%25B3%25D0%25BE%25D1%2580%25D0%25BE%25D0%25B4;user_shop_id_render=237;user_shop_id=237;insdrSV=20'; $city = 'Нижний Новгород'; break;
		case 'novosibirsk': $region = 'user_shop_name=%25D0%259D%25D0%25BE%25D0%25B2%25D0%25BE%25D1%2581%25D0%25B8%25D0%25B1%25D0%25B8%25D1%2580%25D1%2581%25D0%25BA;user_shop_id_render=3;user_shop_id=3;insdrSV=11'; $city = 'Новосибирск'; break;
		case 'omsk': $region = 'user_shop_name=%25D0%259E%25D0%25BC%25D1%2581%25D0%25BA;user_shop_id_render=186;user_shop_id=186;insdrSV=24'; $city = 'Омск'; break;
		case 'perm': $region = 'user_shop_name=%25D0%259F%25D0%25B5%25D1%2580%25D0%25BC%25D1%258C;user_shop_id_render=192;user_shop_id=192;insdrSV=25'; $city = 'Пермь'; break;
		case 'petrozavodsk': $region = 'user_shop_name=%25D0%259F%25D0%25B5%25D1%2582%25D1%2580%25D0%25BE%25D0%25B7%25D0%25B0%25D0%25B2%25D0%25BE%25D0%25B4%25D1%2581%25D0%25BA;user_shop_id_render=2952;user_shop_id=2952;insdrSV=26'; $city = 'Петрозаводск'; break;
		case 'pyatigorsk': $city = 'Пятигорск'; $region = 'user_shop_name=%25D0%259F%25D1%258F%25D1%2582%25D0%25B8%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA;user_shop_id_render=3166;user_shop_id=3166;insdrSV=27'; break;
		case 'rostov': $region = 'user_shop_name=%25D0%25A0%25D0%25BE%25D1%2581%25D1%2582%25D0%25BE%25D0%25B2-%25D0%25BD%25D0%25B0-%25D0%2594%25D0%25BE%25D0%25BD%25D1%2583;user_shop_id_render=197;user_shop_id_render=197;insdrSV=28'; $city = 'Ростов-на-Дону'; break;
		case 'samara': $region = 'user_shop_name=%25D0%25A1%25D0%25B0%25D0%25BC%25D0%25B0%25D1%2580%25D0%25B0;user_shop_id_render=200;user_shop_id=200;insdrSV=29'; $city = 'Самара'; break;
		case 'ufa': $region = 'user_shop_name=%25D0%25A3%25D1%2584%25D0%25B0;user_shop_id_render=224;user_shop_id=224;insdrSV=30'; $city = 'Уфа'; break;
		case 'vladivostok': $region = 'user_shop_name=%25D0%2592%25D0%25BB%25D0%25B0%25D0%25B4%25D0%25B8%25D0%25B2%25D0%25BE%25D1%2581%25D1%2582%25D0%25BE%25D0%25BA;user_shop_id_render=875;user_shop_id=875;insdrSV=30'; $city = 'Владивосток';  break;
		case 'volgograd': $region = 'user_shop_name=%25D0%2592%25D0%25BE%25D0%25BB%25D0%25B3%25D0%25BE%25D0%25B3%25D1%2580%25D0%25B0%25D0%25B4;user_shop_id_render=143;user_shop_id=143;insdrSV=14'; $city = 'Волгоград'; break;
		case 'voronezh': $region = 'user_shop_name=%25D0%2592%25D0%25BE%25D1%2580%25D0%25BE%25D0%25BD%25D0%25B5%25D0%25B6;user_shop_id_render=147;user_shop_id=147;insdrSV=15'; $city = 'Воронеж'; break;
		case 'yekaterinburg': $region = 'user_shop_name=%25D0%2595%25D0%25BA%25D0%25B0%25D1%2582%25D0%25B5%25D1%2580%25D0%25B8%25D0%25BD%25D0%25B1%25D1%2583%25D1%2580%25D0%25B3;user_shop_id_render=152;user_shop_id=152;insdrSV=19'; $city = 'Екатеринбург'; break;		
	 	default:
 		die("Unknown region\n");  	 		
	}	

	$urlStart 		 = 'https://www.auchan.ru/pokupki/bytovaja-tehnika/tehnika-dlja-doma/f/brand=polaris.html';
	$regexpPagin	 = "~По вашему запросу было найдено <strong>(.+)<~isU";
	$regexpPrices  = "~<article(.+)</article~isU";
	$regexpPrices2 = "~class=\"products__item-link\" href=\"(.+)\".*>(.+)<.*current-price\">.*class=\"price-val\">(.+)<~isU";

	$regjson = "~</path></svg>(.+)</span><button type=\"button\" id=\"checkAddressHeader\"~isU";

	$name = "~<h1.*>(.+)<~isU";
	$price = "~data-bind=\"text:formatedPrice\">(.+)<~isU";
	$regexpRegion = "~data-bind=\"text:cityName\">(.+)<~isU";

	$isInstock = "~itemprop=\"availability\" href=\"(.+)\"~isU";

	$options 			 = array(
								CURLOPT_COOKIE => $region,
								//CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/auchan.ru/cook.txt',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 240,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/polaris.txt'));
array_walk($directLinks, 'trim_value');

// Загрузка отсканированных ссылок:
foreach ($itemsArray as $key => $value) {
	$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
	//echo (time() - $date->format('U')).PHP_EOL; 
	if (time() - $date->format('U') <= 1800) {
		$already_scanned[] = $value[5];
	}
	
}
if ($already_scanned) {
	$already_scanned = array_unique($already_scanned);
	$already_scanned = array_values($already_scanned);
	//print_r($already_scanned); 
} else {
	$already_scanned = array();
}
//$already_scanned = array();


	//$i = 1;
	//while ( regular_one($url)<1 && $i<6 ) {
	//	$i++;
	//}


//regular_one('https://www.auchan.ru/search/?query=polaris');

$AC->get('https://www.auchan.ru/search/?query=polaris', null, $options);
$AC->execute(WINDOW_SIZE);

/*
$is_add = 0;
foreach ($directLinks as $url) {
	if (!in_array($url, $already_scanned)) {
		echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
		$AC->get($url, null, $options);
		$is_add = 1;
	} else {
		echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
	}
}
if ($is_add) {
	$AC->execute(WINDOW_SIZE);
}


	$AC->flush_requests();
	$AC->__set('callback','callback_three');


$is_add = 0;
foreach ($directLinks as $url) {
	if (!in_array($url, $already_scanned)) {
		echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
		$AC->get($url, null, $options);
		$is_add = 1;
	} else {
		echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
	}
}
if ($is_add) {
	$AC->execute(WINDOW_SIZE);
}

while ($bad_urls) {
	if (round(microtime(1) - $time_start, 0) >= 180) break;
	$AC->flush_requests();
	foreach ($bad_urls as $url) {
	  $AC->get($url, null, $options);     
	}
	$bad_urls = array();
	$AC->execute(WINDOW_SIZE);
}

/*
	$qOfPagesArray = array();
	$AC->get($urlStart, null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
	  foreach ($bad_urls as $url) {
	    $AC->get($url, null, $options);     
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}

	echo 'К-во страниц:'.$qOfPaginationPages.PHP_EOL;
	sleep(1);

	if ($qOfPaginationPages > 1) {
		$AC->flush_requests();
		$AC->__set('callback', 'callback_two');
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
		  if ($i == 1) {
			  $AC->get($urlStart, null, $options);
		  } else {
			  $AC->get($urlStart.'&page='.$i, null, $options);
		  }   
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
			if (round(microtime(1) - $time_start, 0) >= 180) break;
		  $AC->flush_requests();
		  foreach ($bad_urls as $url => $attr) {
		    $AC->get($url, null, $options);     
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
	}
*/
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function regular_one($url) {
	global $itemsArray;
	global $region;

	$proxy_array = glob('/var/www/lib/proxies/*.proxy');

	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
	$proxy_list 		= explode("\n", $alive_proxy_list);
	$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
	array_walk($proxy_list, 'trim_value');
	array_walk($useragent_list, 'trim_value');

	//$regPagin1 = "~pageline opensans(.+)</ul~isU";
	//$regPagin2 = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~class=\"cell opensans(.+)class=\"availablelist\"~isU";
	$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price.*<li.*>(.+)<~isU";	// Все товары на странице
	$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";	// Все товары на странице

	$regexpPricesNoA = "~class=\"cell opensans noavailable(.+)</ul~isU";

		$useragent_index = mt_rand(0, count($useragent_list)-1);
		$useragent = $useragent_list[$useragent_index];
	  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
	  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  if (!$matches_proxy) {
	   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  }
		$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
		$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 
		//$proxy = '92.63.99.89:443';
		//$auth  = 'WpSsZQwpb:xvAjhczlf';
	
		sleep(1);
		
		$cookie = '/var/www/js/engines/shop.v-lazer.com/cookies/'.$useragent_index.'_'.str_replace(':', '_', $proxy).'.cook'; // cookies

		//echo $cookie."\n";
		
		$useragent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0';
		echo $useragent."\n";
		$proxyArr = explode(':', $proxy);
		$authArr = explode(':', $auth);
		$cmd = 'timeout -k 25s 26s casperjs /var/www/polaris/engines/auchan.ru/script.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1].' --cookies-file='.$cookie;
		echo $cmd;
	/*
			$proxyArr = explode(':', $proxy);
			$authArr = explode(':', $auth);    
			$cmd = 'timeout -k 45s 50s casperjs /var/www/js/engines/shop.v-lazer.com/html.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1].' --cookies-file='.$cookie;
	*/

		$phantomjs = exec("$cmd 2>&1", $out, $err);
		// Режем данные, сохраняем в массив
		$response = stripcslashes($phantomjs);
		file_put_contents('/var/www/polaris/engines/auchan.ru/content.txt', $response);
		//echo $response;
		if ($response) {
			preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
			foreach ($matches2 as $key) {		
				preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
				//print_r($matches);
				if ($matches[3]) {
		 			$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2],  preg_replace('~[^\d.]+~', '' , $matches[3]), $proxy, $useragent, $url);
					echo trim($matches[2]).' | '.preg_replace('~[^\d.]+~', '' , $matches[3]).PHP_EOL;
				} else {
					preg_match($regexpPrices3, $key[1], $matches);
					if ($matches[1]) {					
						$matches[2] = str_replace(';', ' ', $matches[2]);
						$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2], '0', $proxy, $useragent, $url);
						echo trim($matches[2]).' | 0'.PHP_EOL;						
					}
				}
			} 

			preg_match_all($regexpPricesNoA, $response, $matches2, PREG_SET_ORDER);
			foreach ($matches2 as $key) {		
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {					
					$matches[2] = str_replace(';', ' ', $matches[2]);
					$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2], '0', $proxy, $useragent, $url);
					echo trim($matches[2]).' | 0'.PHP_EOL;						
				}
			}			

			return 1;		
		} else {
	  	//mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  	echo 'bad response'.PHP_EOL;
	  	return 0;	
		}
}


function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regjson;

	global $time_start;
	global $itemsArray;

	//proxy_statistics($response, $info, $request);
	//file_put_contents('/var/www/polaris/engines/auchan.ru/content.txt', $response);
	//die();
	//file_put_contents('/var/www/polaris/engines/auchan.ru/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {
    preg_match($regexpPagin, $response, $matches);
    

    preg_match($regjson, $response, $matches);
    print_r($matches);
    $json = $matches[1];

  	preg_match_all("~gimaId.*name\":\"(.+)\".*code\":\"(.+)\".*\"price\":{\"value\":(.+)\"~isU", $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);


  	foreach ($matches_items as $key => $value) {

  		$name = trim($value[1]);
  		$url = 'https://www.auchan.ru/product/'.trim($value[2]).'/';
  		if (stripos($value[3], '.') !== false) {
  			$price = substr($value[3], 0, stripos($value[3], '.'));
  		} else {
  			$price = $value[3];
  		}
  		
  		$price = preg_replace('~[^\d]+~', '' , $price);

			price_change_detect($url, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
			$itemsArray[$url] = array($name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
			AngryCurl::add_debug_msg($url.' | '.$name.' | '.$price);	
  		
		}
  }
}

function callback_one_old($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regjson;

	global $time_start;
	global $itemsArray;

	//proxy_statistics($response, $info, $request);
	//file_put_contents('/var/www/polaris/engines/auchan.ru/content.txt', $response);
	//die();
	file_put_contents('/var/www/polaris/engines/auchan.ru/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {
    preg_match($regexpPagin, $response, $matches);
    

    $temp = ceil(preg_replace('~[^\d]+~', '' , $matches[1]) / 96);
    if ($temp > $qOfPaginationPages) {      
	    $qOfPaginationPages = $temp;
    }

    preg_match($regjson, $response, $matches);
    print_r($matches);
    $json = $matches[1];


  	preg_match_all("~\"in_stock\":(.+),~isU", $json, $matches_avail, PREG_SET_ORDER);
    //print_r($matches_avail);




  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);

		//file_put_contents('/var/www/polaris/engines/auchan.ru/print.txt', print_r($matches_items, 1));

		$i = 0;
  	foreach ($matches_items as $key) {

	  	if (trim($matches_avail[$i][1]) == 'true') {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			} else {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = '0';
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}					
			}
			$i++;
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {	
  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'old_price')) {
				preg_match($regexpPrices2, $key[1], $matches);
			} else {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@!$matches[1]) {
					preg_match($regexpPrices4, $key[1], $matches);
				}
			}
			$matches = clean_info($matches, array(1,2,3), 'utf-8');
	  	if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
  }
}


function callback_three($response, $info, $request) {
  global $bad_urls;
	global $name;
	global $price;
	global $regexpRegion;
	global $time_start;
	global $itemsArray;
	global $isInstock;



	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {            
    if ($info['http_code'] !== 404) {
	    $bad_urls[] = $request->url;
	    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();    	
    }
  } else {
    //file_put_contents(AC_DIR.'/items/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.txt', preg_replace('~[^\d]+~', '' , $matches[1]));
/*
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$city.PHP_EOL;

  	// Проверка региона
  	if ($mregion[1] != $city) {
  		echo 'Регионы не совпадают'.PHP_EOL;
  		return 0;
  	}
*/

  	preg_match($name, $response, $matches_name);
  	preg_match($price, $response, $matches_price);

  	preg_match($isInstock, $response, $matches_stock);
  	
  	//print_r($matches_name);
  	//print_r($matches_price);
  	
	  if (strripos($matches_stock[1], 'https://schema.org/InStock') !== false) {
	  	if ($matches_name && $matches_price) {
		  	$matches_name[1] = trim($matches_name[1]);
		  	$matches_price[1] = preg_replace('~[^\d]+~', '' , $matches_price[1]);
				price_change_detect($request->url, $matches_name[1], $matches_price[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$request->url] = array($matches_name[1], $matches_price[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($matches_name[1].' | '.$matches_price[1]);	
	  	}			
		} else {
	  	if ($matches_name) {
		  	$matches_name[1] = trim($matches_name[1]);
		  	$matches_price[1] = '0';
				price_change_detect($request->url, $matches_name[1], $matches_price[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$request->url] = array($matches_name[1], $matches_price[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($matches_name[1].' | '.$matches_price[1]);	
	  	}				
		}
		
  }
}
