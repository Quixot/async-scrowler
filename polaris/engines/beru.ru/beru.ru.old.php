<?php
/**
 * shop-polaris.ru
 */
$type = 1;
switch (EXTRA_PARAM) {
  case 'moscow':
    $region = '';
    $regionName = 'Москва';
    break;
  case 'spb':
    $region = 'spb.';
    $regionName = 'Санкт-Петербург';
    break;
  case 'rostov':
    $region = 'rostov.';
    $regionName = 'Ростов-на-Дону';
    break;
  case 'novosibirsk':
    $region = 'nsk.';
    $regionName = 'Новосибирск';
    break;
  case 'vladivostok':
    $region = 'vladivostok.';
    $regionName = 'Владивосток';
    break;
  case 'samara':
    $region = 'samara.';
    $regionName = 'Самара';
    break;
  case 'yekaterinburg':
    $region = 'ekb.';
    $regionName = 'Екатеринбург';
    break;
  case 'volgograd':
    $region = 'volgograd.';
    $regionName = 'Волгоград';
    break;
  case 'chelyabinsk':
    $region = 'chelyabinsk.';
    $regionName = 'Челябинск';
    break;
  case 'krasnodar':
    $region = 'krasnodar.';
    $regionName = 'Краснодар';
    break; 
  case 'omsk':
    $region = 'omsk.';
    $regionName = 'Омск';
    break; 

  case 'novgorod':
  	$type = 2;
    $region = '';
    $regionName = 'Нижний Новгород';  
    break;
  case 'ufa':
  	$type = 2;
    $region = '';
    $regionName = 'Уфа';
    break;
  case 'krasnoyarsk':
  	$type = 2;
    $region = '';
    $regionName = 'Красноярск';
    break;
  case 'kazan':
  	$type = 2;
    $region = '';
    $regionName = 'Казань';
    break;
  case 'habarovsk':
  	$type = 2;
    $region = '';
    $regionName = 'Хабаровск';
    break;

 	default:
 		die("Unknown region\n");  	 		
}
$urlStart = 'https://beru.ru/?ncrnd=8989&pcr=213';

$options = array(
				CURLOPT_COOKIE => 'regionChangeMethod=manual',
        CURLOPT_COOKIEJAR       => '/xxx/x.txt',
        //CURLOPT_COOKIEFILE      => '/xxx/x.txt',
        //CURLOPT_REFERER         => 'http://www.komus.ru/search?text=polaris',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true
    );

$regexpPrices1 = "~<div class=\"grid-snippet(.+)/span></div></div></div></div></div></div>~isU";
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*<span><span>(.+)</span>~isU";

$regRegion = "~class=\"link__inner\">(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
	//$response = file_get_contents('/var/www/polaris/engines/beru.ru/content.txt');
	//callback_two($response, null, null);

	//foreach ($urlArray as $urlkey) {
		$AC->get($urlStart, null, $options);
	//}
	$AC->execute(WINDOW_SIZE);

/*
	foreach ($urlArray as $urlkey) {
		$AC->get($urlkey, null, $options);
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		$AC->flush_requests();
		foreach ($bad_urls as $urls) {
		  $AC->get($urls, NULL, $options);
		}
		unset($urls);
		$bad_urls = array();
		$AC->execute(WINDOW_SIZE);
	}
	unset($urls);
*/


	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;

  //file_put_contents('/var/www/polaris/engines/shop-polaris.ru/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {   
    $bad_urls[] = $request->url;
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 600) { $bad_urls = array(); }  	         
  } else {
  	echo substr($response, 0, 500);
  	file_put_contents('/var/www/polaris/engines/beru.ru/content.txt', $response);
  	die();
  	preg_match($regRegion, $response, $mReg);
  	AngryCurl::add_debug_msg('Регион - '.trim($mReg[1]));

  	if (trim($mReg[1]) == $regionName) {
		  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		  //print_r($matches);
			foreach ($matches as $key) {
				//if (strripos($key[1], $avail) === false) {
					if (strripos($key[1], 'class="new"') === false) { // Если обычная цена
						preg_match($regexpPrices2, $key[1], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
								trim($matches2[2]), 
								preg_replace('~[^\d]+~', '', $matches2[3]),
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
						}	
					} else { // Если перечеркнутая цена
						preg_match($regexpPrices3, $key[1], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
								trim($matches2[2]), 
								preg_replace('~[^\d]+~', '', $matches2[3]),
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
						}						
					}
				//}
			}
		} else {
			AngryCurl::add_debug_msg('не совпадает регион - '.trim($mReg[1]).' : '.$regionName);
		}
  }
}


function callback_two($response, $info, $request) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;

  //file_put_contents('/var/www/polaris/engines/shop-polaris.ru/content.txt', $response);

	//AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	//AngryCurl::add_debug_msg($info['http_code']);
	//AngryCurl::add_debug_msg($request->options[10004]);  

/*
  if ($info['http_code'] !== 200) {   
    $bad_urls[] = $request->url;	
		if (round(microtime(1) - $time_start, 0) >= 600) { $bad_urls = array(); }  	         
  } else {
  	*/
  	preg_match($regRegion, $response, $mReg);
  	//AngryCurl::add_debug_msg('Регион - '.trim($mReg[1]));

  	//if (trim($mReg[1]) == $regionName) {
		  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		  //print_r($matches);
			foreach ($matches as $key) {
				//if (strripos($key[1], $avail) === false) {
				preg_match($regexpPrices2, $key[1], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							price_change_detect('https://beru.ru'.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://beru.ru'.$matches2[1]] = array(
								trim($matches2[2]), 
								preg_replace('~[^\d]+~', '', $matches2[3]),
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
						}
				//}
			}
		//} else {
		//	AngryCurl::add_debug_msg('не совпадает регион - '.trim($mReg[1]).' : '.$regionName);
		//}
  //}
}


function regular_one() {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regionName;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;

	if (ENGINE_LOOP == 2) {
		$response = file_get_contents( '/var/www/polaris/engines/ozon.ru/source/'.EXTRA_PARAM.'.txt' );

		if ($response) {
			echo 'response ok'.PHP_EOL;

			preg_match("~eCityCompleteSelector_button.*>(.+)<~isU", $response, $mregion);
			echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
			echo 'response region: '.$mregion[1].PHP_EOL;

		  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
		  //print_r($matches2);
		  foreach ($matches2 as $key => $value) {
				preg_match($reg2, $value[0], $matches);
				//print_r($matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = 'http://www.ozon.ru'.trim($matches[1]);
					//$matches[3] = iconv('windows-1251', 'utf-8', $matches[3]);
					$matches[3] = strip_tags($matches[3]);
					$matches[3] = html_entity_decode(trim($matches[3]));
					$matches[2] = preg_replace('~[^\d.]+~', '' , $matches[2]);
					price_change_detect($matches[1], $matches[3], $matches[2], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[3], $matches[2], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
					echo $matches[3].' | '.$matches[2].PHP_EOL;
				}
			}
			return 1;
		} else {
			echo 'bad response'.PHP_EOL;
			return 0;
		}

	} else {
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

		/**
		 * Блок выбора прокси
		 */
			$useragent_index = mt_rand(0, count($useragent_list)-1);
			$useragent = $useragent_list[$useragent_index];
		  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
		  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
		  if (!$matches_proxy) {
		   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
		  }
		/**
		 * Блок выбора прокси
		 */
		$url = 'https://shop-polaris.ru/';
		$cmd = 'timeout -k 30s 31s casperjs /var/www/polaris/engines/shop-polaris.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '."'".$regionName."'";
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = stripcslashes($response);

		file_put_contents('/var/www/polaris/engines/shop-polaris.ru/content.txt', $response);

		if ($response) {
			echo 'response ok'.PHP_EOL;

			preg_match($regRegion, $response, $mregion);
			echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
			echo 'response region: '.$mregion[1].PHP_EOL;

		  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		  //print_r($matches);
			foreach ($matches as $key) {
				//if (strripos($key[1], $avail) === false) {
					if (strripos($key[1], 'class="new"') === false) { // Если обычная цена
						preg_match($regexpPrices2, $key[1], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
								trim($matches2[2]), 
								preg_replace('~[^\d]+~', '', $matches2[3]),
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
						}	
					} else { // Если перечеркнутая цена
						preg_match($regexpPrices3, $key[1], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
								trim($matches2[2]), 
								preg_replace('~[^\d]+~', '', $matches2[3]),
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
						}						
					}
				//}
			}
			echo 'Общее к-во: '.count($matches2).PHP_EOL;
			return 1;
		} else {
			echo 'bad response'.PHP_EOL;
			return 0;
		}
	}
}

