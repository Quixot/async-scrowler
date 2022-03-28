<?php
/**
 * eldorado.com.ua
 */
	$urls = [
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=0&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=20&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=40&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=60&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=80&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=100&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=120&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=140&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=160&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=180&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=200&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=220&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=240&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=260&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=280&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=300&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=320&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=340&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=360&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=380&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=400&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=420&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=440&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=460&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=480&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=500&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=520&showSimilarQueries&lang=ru',
	'https://api.eldorado.ua/v1/new_search?q=polaris&limit=20&offset=540&showSimilarQueries&lang=ru',
	];

	$already_scanned = array();
	$already_scanned = scanned_links($itemsArray);
	//$already_scanned = array();
	print_r($already_scanned);

	//regular_two('https://eldorado.ua/search?q=polaris');
	//die();

	foreach ($urls as $url) {
		if (!in_array($url, $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.$url);
			$i = 1;
			while (regular_one($url)<1 && $i<3) {
				$i++;
			}
		} else {
			AngryCurl::add_debug_msg('уже сканировал: '.$url);
		}
	}

	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';


/** 
 *              Callback Functions           
 */
function regular_one($url) {
  global $regexpPagin;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;	  
  global $qOfPaginationPages;
	global $itemsArray;  
  global $bad_urls;

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



		$useragent_index = mt_rand(0, count($useragent_list)-1);
		$useragent = $useragent_list[$useragent_index];
	  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
	  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  if (!$matches_proxy) {
	   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  }
		$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
		$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 

		echo "\n\n";
		echo "/*--------------------------------------*/\n";
		echo $proxy."\n";
		echo $url."\n";
		echo $auth."\n";

		echo $useragent."\n";
		$proxyArr = explode(':', $proxy);
		$authArr = explode(':', $auth);  

		$cmd = 'timeout -k 45s 50s casperjs /var/www/polaris.ua/engines/eldorado.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1];
		echo $cmd.PHP_EOL;

		$phantomjs = exec("$cmd 2>&1", $out, $err);
		// Режем данные, сохраняем в массив
		$response = stripcslashes($phantomjs);
		//file_put_contents('/var/www/polaris.ua/engines/eldorado.ua/content/'.time().'.txt', $response);
		//die();
		//echo $response;
		echo 'К-во символов: '.strlen($response);
		if (strlen($response) > 500) {
			$response = substr($response, stripos($response, "\">")+2);
			$response = substr($response, 0, stripos($response, "</pre>\""));
	  	$arr = json_decode($response);
	  	//print_r($arr);
	  	foreach ($arr->data->collection as $value) {
	  		if ($value->sell_status) {

		  		if (strripos($value->price, '.') !== false) {
		  			$pricecl = preg_replace('~[\D]+~', '' , substr($value->price, 0, strripos($value->price, '.')));
		  		} else {
		  			$pricecl = preg_replace('~[\D]+~', '' , $value->price);
		  		}


					price_change_detect('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/', trim($value->title), $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'] = array(trim($value->title), $pricecl, date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $useragent, $url);			
					AngryCurl::add_debug_msg('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'.' | '.trim($value->title).' | '.$pricecl);
	  		} else {
					price_change_detect('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/', trim($value->title), '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $request->options[10006], $useragent, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'] = array(trim($value->title), '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $useragent, $url);			
					AngryCurl::add_debug_msg('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'.' | '.trim($value->title).' | 0');
	  		}
	  	}
			return 1;		
		} else {
	  	//mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  	echo 'bad response'.PHP_EOL;
	  	return 0;	
		}
}

function regular_two($url) {
  global $regexpPagin;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;	  
  global $qOfPaginationPages;
	global $itemsArray;  
  global $bad_urls;

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



		$useragent_index = mt_rand(0, count($useragent_list)-1);
		$useragent = $useragent_list[$useragent_index];
	  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
	  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  if (!$matches_proxy) {
	   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  }
		$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
		$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 

		echo "\n\n";
		echo "/*--------------------------------------*/\n";
		echo $proxy."\n";
		echo $url."\n";
		echo $auth."\n";

		echo $useragent."\n";
		$proxyArr = explode(':', $proxy);
		$authArr = explode(':', $auth);  

		$cmd = 'timeout -k 45s 50s casperjs /var/www/polaris.ua/engines/eldorado.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1];
		echo $cmd.PHP_EOL;

		$phantomjs = exec("$cmd 2>&1", $out, $err);
		// Режем данные, сохраняем в массив
		$response = stripcslashes($phantomjs);
		//file_put_contents('/var/www/polaris.ua/engines/eldorado.ua/content.txt', $response);
		echo $response;
		die();

		echo 'К-во символов: '.strlen($response);
		if (strlen($response) > 500) {
			$response = substr($response, stripos($response, "\">")+2);
			$response = substr($response, 0, stripos($response, "</pre>\""));
	  	$arr = json_decode($response);
	  	//print_r($arr);
	  	foreach ($arr->data->collection as $value) {
	  		if ($value->sell_status) {

		  		if (strripos($value->price, '.') !== false) {
		  			$pricecl = preg_replace('~[\D]+~', '' , substr($value->price, 0, strripos($value->price, '.')));
		  		} else {
		  			$pricecl = preg_replace('~[\D]+~', '' , $value->price);
		  		}


					price_change_detect('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/', trim($value->title), $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'] = array(trim($value->title), $pricecl, date("d.m.y-H:i:s"), $request->options[10004]);			
					AngryCurl::add_debug_msg('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'.' | '.trim($value->title).' | '.$pricecl);
	  		} else {
					price_change_detect('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/', trim($value->title), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'] = array(trim($value->title), '0', date("d.m.y-H:i:s"), $request->options[10004]);			
					AngryCurl::add_debug_msg('https://eldorado.ua/'.$value->name.'/p'.$value->offer_id.'/'.' | '.trim($value->title).' | 0');
	  		}
	  	}
			return 1;		
		} else {
	  	//mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  	echo 'bad response'.PHP_EOL;
	  	return 0;	
		}
}
