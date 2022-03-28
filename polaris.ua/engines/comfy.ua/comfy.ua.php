<?php
/**
 * comfy.ua
 */
$regexpPagin	 = "~<section class=\"brand\">(.+)</section~isU"; 			// К-во найденых товаров
$regexpPaginLinks = "~href=\"(.+)\".*class=\"brand-item__name-qty\".*\((.+)\)~isU";
$regexpPrices1 = "~data-product-url=(.+)product-options__more~isU";
$regexpPrices2 = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*class=\"price-value.*>(.+)<~isU";
$regexpPrices3 = "~product-item__name.*href=\"(.+)\".*>(.+)</a~isU";
$regexpPricesSpecial = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*price-box__content_special.*class=\"price-value.*>(.+)<~isU";

if (ENGINE_LOOP == 13) {
	$regions = array('kiev');

	foreach ($regions as $region) {

		$content_file_path = '/var/www/polaris.ua/engines/comfy.ua/content/'.$region.'.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 3600) {

			$itemsArray = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			callback_three($response, $region);

			if (!$itemsArray) {
				die();
			}
			
	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

		} else {
			echo 'Старый файл: '.$content_file_path.PHP_EOL;
		}
	}
	


}



	//unlink($cookfilepath);

/** 
 *              Callback Functions           
 */
function callback_three($response, $region) {
	global $itemsArray;
	global $bad_urls;
	global $region;
	global $city;
	global $regexpRegion;
	global $time_start;
	global $content_file_path;

	$regexpPrices1 = "~data-product-url=(.+)product-options__more~isU";
	$regexpPrices2 = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*class=\"price-value.*>(.+)<~isU";
	$regexpPrices3 = "~product-item__name.*href=\"(.+)\".*>(.+)</a~isU";
	$regexpPricesSpecial = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*price-box__content_special.*class=\"price-value.*>(.+)<~isU";

	if ($response) {
		//echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris/engines/dns-shop.ru/content.txt', $response);
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$region.PHP_EOL;

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
	  //print_r($matches);

		foreach ($matches as $key) {
			if (stripos($key[0], 'data-add-to-cart-url=') !== false) {
				if (stripos($key[0], 'price-box__content_special') !== false) {
					preg_match($regexpPricesSpecial, $key[1], $matches2);
					//print_r($matches2);
					$matches2[1] = str_replace('/ua/', '/', $matches2[1]);

					$matches2 = parser_clean($matches2, 2, 3);
					
					price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual');			
					AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$matches2[3]);					
				} else {
					preg_match($regexpPrices2, $key[1], $matches2);
					$matches2[1] = str_replace('/ua/', '/', $matches2[1]);
					//print_r($matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					
					price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual');
					AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$matches2[3]);
				}
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				$matches2[1] = str_replace('/ua/', '/', $matches2[1]);
				//print_r($matches2);
				price_change_detect($matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				
				$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual');			
				
				AngryCurl::add_debug_msg($matches2[1].' | '.trim($matches2[2]).' | 0');	
			}
		}
		//file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '.ua_' . $region . '.data', serialize($itemsArray));
		unlink($content_file_path);
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}


function regular_one() {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPricesSpecial;
	global $cookfilepath;
	global $itemsArray;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath) || time() - filemtime($cookfilepath) > 3600) {
		die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
	}

	/**
	 * Блок выбора прокси
	 */
	$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
		  
	$proxy_auth = file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt');	  
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}
	/**
	 * Блок выбора прокси
	 */
	$glob = glob('/var/www/polaris.ua/engines/comfy.ua/content/*.txt');

	$baselinks = array(
		'https://comfy.ua/catalogsearch/result?q=polaris+polaris', 
		'https://comfy.ua/catalogsearch/result/index/?p=2&q=polaris+polaris', 
		'https://comfy.ua/ua/blender/brand__polaris/',
		'https://comfy.ua/ua/meat-grinder/brand__polaris/',
		'https://comfy.ua/ua/mixer/brand__polaris/',
		'https://comfy.ua/ua/electric-tea-pot/brand__polaris/',
		'https://comfy.ua/ua/barbekyu/brand__polaris/',
		'https://comfy.ua/ua/multicooking/brand__polaris/',
		'https://comfy.ua/ua/toaster/brand__polaris/',
		'https://comfy.ua/ua/juice-extractor/brand__polaris/',
		'https://comfy.ua/ua/espresso-coffee/brand__polaris/',
		'https://comfy.ua/ua/coffee-pot-tiny/brand__polaris/',
		'https://comfy.ua/ua/kofemolka/brand__polaris/',
		'https://comfy.ua/ua/dryer-for-fruit/brand__polaris/',
		'https://comfy.ua/ua/water-heater/brand__polaris/',
		'https://comfy.ua/ua/vacuum-cleaner/brand__polaris/',
		'https://comfy.ua/ua/hand-vacuum-cleaners/brand__polaris/',
		'https://comfy.ua/ua/vacuum-cleaning-robots/brand__polaris/',
		'https://comfy.ua/ua/iron/brand__polaris/',
		'https://comfy.ua/ua/vertical-steamers/brand__polaris/',
		'https://comfy.ua/ua/steam-generators/brand__polaris/',
		'https://comfy.ua/ua/fan/brand__polaris/',
		'https://comfy.ua/ua/humidifiers/brand__polaris/',
		'https://comfy.ua/ua/air-purifiers/brand__polaris/',
		'https://comfy.ua/ua/hair-dryer/brand__polaris/',
		'https://comfy.ua/ua/rectifier-of-hair/brand__polaris/',
		'https://comfy.ua/ua/hair-stylers/brand__polaris/',
		'https://comfy.ua/ua/trim/brand__polaris/',
		'https://comfy.ua/ua/trimmers/brand__polaris/',
		'https://comfy.ua/ua/razor/brand__polaris/',
		'https://comfy.ua/ua/manicure/brand__polaris/',
		'https://comfy.ua/ua/scales-floor/brand__polaris/',
		'https://comfy.ua/ua/n-are-of-body-and-person/brand__polaris/',
		/*'https://comfy.ua/ua/skovorodki/brand__polaris/',
		'https://comfy.ua/ua/kastruli/brand__polaris/',
		'https://comfy.ua/ua/kovshy/brand__polaris/',
		'https://comfy.ua/ua/kruski-posydu/brand__polaris/',
		'https://comfy.ua/ua/knife/brand__polaris/',
		'https://comfy.ua/ua/forma-vupechki/brand__polaris/',
		'https://comfy.ua/ua/cook-sets/brand__polaris/',
		'https://comfy.ua/ua/for-meat/brand__polaris/',
		'https://comfy.ua/ua/geyser-coffee-turks/brand__polaris/',
		'https://comfy.ua/ua/chajniki/brand__polaris/',
		'https://comfy.ua/ua/french-press/brand__polaris/',
		'https://comfy.ua/ua/thermos/brand__polaris/',*/
		);

	$baselinksID = array();
	foreach ($baselinks as $bsurl) {
		$baselinksID[] = preg_replace('/[^a-zA-Z0-9]/', '', $bsurl);;
	}

	for ($i=0; $i < count($baselinks); $i++) { 
		//echo '/var/www/polaris.ua/engines/comfy.ua/content/'.$i.'.txt'.PHP_EOL;
		if (!in_array('/var/www/polaris.ua/engines/comfy.ua/content/'.$baselinksID[$i].'.txt', $glob)) {
			$links .= $baselinks[$i].',';
			//$linksid .= $baselinksID[$i].',';
			echo '/var/www/polaris.ua/engines/comfy.ua/content/'.$baselinksID[$i].'.txt'.PHP_EOL;
		}
	}
	$links = substr($links, 0, -1);

	$cmd = 'timeout -k 800s 801s casperjs /var/www/polaris.ua/engines/comfy.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.EXTRA_PARAM;
	//https://comfy.ua/catalogsearch/result/index/?cat=152%7C128%7C403%7C91%7C129%7C134%7C164%7C489%7C153%7C133%7C410%7C156%7C257%7C94%7C157%7C158%7C572%7C396%7C780%7C567%7C613%7C140%7C623%7C568%7C9543%7C9533%7C97%7C1523%7C624%7C881%7C168%7C591%7C569%7C108%7C143%7C135%7C413%7C582%7C2383%7C99%7C161%7C924%7C570%7C126%7C136&p='.$i.'&price=&q=philips+philips&search_provider=anyquery&strategy=simple%2Czero_queries'
	if ($links) {
		echo $cmd.PHP_EOL;

		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}

	$glob = glob('/var/www/polaris.ua/engines/comfy.ua/content/*.txt');
	if ($glob) {
		$count_all_items = 0;
		foreach ($glob as $addr) {
			preg_match('~'.EXTRA_PARAM.'(.+).txt~isU', $addr, $mReqUrl);
			$request_url = $mReqUrl[1];
			
			$response = file_get_contents($addr);

			preg_match("~Interactions-open-visitorCityList.*>(.+)<~isU", $response, $region);
			AngryCurl::add_debug_msg('request  region: '.$city);
			AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

			//file_put_contents('/var/www/polaris.ua/engines/comfy.ua/content.txt', $response);

		  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
		  //print_r($matches);
		  //file_put_contents('/var/www/polaris.ua/engines/comfy.ua/content.txt', print_r($matches,1));
			foreach ($matches as $key) {
				if (stripos($key[1], 'data-add-to-cart-url=') !== false) {
					if (stripos($key[0], 'price-box__content_special') !== false) {
						preg_match($regexpPricesSpecial, $key[1], $matches2);
						
						$matches2 = parser_clean($matches2, 2, 3);
						
						price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);			
						AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
						$count_all_items++;
					} else {
						preg_match($regexpPrices2, $key[1], $matches2);

						$matches2 = parser_clean($matches2, 2, 3);
						price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);			
						AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
						$count_all_items++;				
					}
				}	else {
					preg_match($regexpPrices3, $key[1], $matches2);
					price_change_detect($matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
					
					$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);			
					
					AngryCurl::add_debug_msg(trim($matches2[2]).' | 0');
					$count_all_items++;			
				}
			}
		}
		echo 'Позиций: '.$count_all_items.PHP_EOL;
		return 1;
	} else {
		return 0;
	}
	
}



function regular_oneold($url) {
  global $regexpPagin;
  global $regexpPaginLinks;
  global $mainLinks;
  global $bad_urls;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/*.proxy', '/var/www/lib/useragents_short.txt');
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);

	//file_put_contents('/var/www/philips/engines/comfy.ua/content.txt', $response);
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;
		echo substr($response, 0, 500);

    preg_match($regexpPagin, $response, $matches); // Сколько страниц цен   
		//print_r($matches);
		preg_match_all($regexpPaginLinks, $matches[1], $matchesLinks, PREG_SET_ORDER);
		//print_r($matchesLinks);
		if (count($matchesLinks) > count($mainLinks)) {
			$mainLinks = $matchesLinks;
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}

function regular_two($url) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/*.proxy', '/var/www/lib/useragents_short.txt');
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);

	$cmd = 'timeout -k 50s 51s casperjs /var/www/philips/engines/comfy.ua/comfy.ua.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.EXTRA_PARAM;

	echo $cmd.PHP_EOL;
	die();
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);

	//file_put_contents('/var/www/philips/engines/comfy.ua/content/'.time().'.txt', $response);
	//die();
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;
		//echo substr($response, 0, 500);

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
	  //print_r($matches);

		foreach ($matches as $key) {
			if (stripos($key[1], 'data-add-to-cart-url=') !== false) {
				preg_match($regexpPrices2, $key[1], $matches2);
				
				$matches2[1] = 'https://stylus.ua/'.trim($matches2[1]);
				$matches2[2] = str_replace('&quot;', ' ', trim($matches2[2]));
				$matches2[2] = str_replace('&amp;', ' ', $matches2[2]);
				$matches2[2] = str_replace('&apos;', ' ', $matches2[2]);
				$matches2[3] = preg_replace('~[\D]+~', '' , $matches2[3]);

				price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);			
				AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				price_change_detect($matches2[1], $matches2[2], '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
				
				$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);			
				AngryCurl::add_debug_msg(trim($matches2[2]).' | 0');	
			}
		}
		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}













function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $regexpPaginLinks;
  global $mainLinks;
  global $bad_urls;
  //global $matchesLinks;

  echo $info['http_code']."\n";
  echo $request->url."\n";
  echo $info['url']."\n";

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    $bad_urls[] = $request->url;
    //}
  } else {
  	//file_put_contents('/var/www/philips/engines/comfy.ua/content.txt', $response);
  	//die();
  	//file_put_contents('/var/www/philips/engines/comfy.ua/'.time(), $response);
    preg_match($regexpPagin, $response, $matches); // Сколько страниц цен   
		//print_r($matches);
		preg_match_all($regexpPaginLinks, $matches[1], $matchesLinks, PREG_SET_ORDER);
		print_r($matchesLinks);
		if (count($matchesLinks) > count($mainLinks)) {
			$mainLinks = $matchesLinks;
		}
	}
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	//global $regexpRegion;
	//global $regionRu;

  if ($info['http_code'] !== 200) {
    if ($info['http_code'] !== 404) {
      $bad_urls[] = $request->url;
    }  
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }       
  } else {
  	//preg_match('~id="headerCity">(.+)<~isU', $response, $regionmatch);
  	//echo trim($regionmatch[1]) . "\n";
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
	  //print_r($matches);die();
		foreach ($matches as $key) {
			if (stripos($key[1], 'data-add-to-cart-url=') !== false) {
				preg_match($regexpPrices2, $key[1], $matches2);
				$matches2 = parser_clean($matches2, 2, 3);
/*
				$start_pos = strripos($matches2[1], '/');
				$end_pos = strripos($matches2[1], '.html');
				
				$matches2[2] = $matches2[1];
				$matches2[2] = substr($matches2[2], $start_pos+1, $end_pos - $start_pos - 1);

				//$pos = strripos($matches2[1], '-');
				//$temp = $matches2[1];
				//$temp{$pos} = '/';
				//$matches2[1] = $temp;
				//$matches2[1] = str_replace('-', ' ', $matches2[1]);

				$pos = strripos($matches2[2], 'philips');
				if ($pos !== false) {
					$matches2[2] = substr($matches2[2], $pos+8);
				}
				if (!$matches2[2]) {
					$matches2[2] = $matches2[1];
				}
				echo 'Получилось: '.$matches2[2].PHP_EOL;
*/
				price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
				AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
/*
				$start_pos = strripos($matches2[1], '/');
				$end_pos = strripos($matches2[1], '.html');
				
				$matches2[2] = $matches2[1];
				$matches2[2] = substr($matches2[2], $start_pos+1, $end_pos - $start_pos - 1);

				//$pos = strripos($matches2[1], '-');
				//$temp = $matches2[1];
				//$temp{$pos} = '/';
				//$matches2[1] = $temp;
				//$matches2[1] = str_replace('-', ' ', $matches2[1]);

				$pos = strripos($matches2[2], 'philips');
				if ($pos !== false) {
					$matches2[2] = substr($matches2[2], $pos+8);
				}
				if (!$matches2[2]) {
					$matches2[2] = $matches2[1];
				}
				echo 'Получилось: '.$matches2[2].PHP_EOL;
				*/
				price_change_detect($matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
				AngryCurl::add_debug_msg(trim($matches2[2]).' | 0');	
									
			}
		} 		
		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray)); 	
  }
}

function regular_three($url) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	$response = file_get_contents('/var/www/philips/engines/comfy.ua/content.txt');
	$response = stripcslashes($response);
	preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
	foreach ($matches as $key) {
		if (stripos($key[1], 'data-add-to-cart-url=') !== false) {
				preg_match($regexpPrices2, $key[1], $matches2);
				$matches2 = parser_clean($matches2, 2, 3);
				price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', $url);			
				AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
		}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				price_change_detect($matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', $url);			
				AngryCurl::add_debug_msg(trim($matches2[2]).' | 0');	
		}
	}	
	return 1;
}
