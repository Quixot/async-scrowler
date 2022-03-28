<?php
/**
 * domo.ru
 */
switch (EXTRA_PARAM) {
	case 'kazan': $region = ''; break;
  case 'ufa': $region = 'ufa.'; break;
	case 'almetevsk': $region = 'almetyevsk.'; break;
	case 'dimitrovgrad': $region = 'dimitrovgrad.'; break;
	case 'naberezhnye-chelny': $region = 'chelny.'; break;
	case 'nizhnekamsk': $region = 'nizhnekamsk.'; break;
	case 'saransk': $region = 'saransk.'; break;
	case 'sterlitamak': $region = 'sterlitamak.'; break;
	case 'syzran': $region = 'syzran.'; break;
	case 'tolyatti': $region = 'tolyatti.'; break;
	case 'ulyanovsk': $region = 'ulyanovsk.'; break;
	case 'cheboksary': $region = 'cheboksary.'; break;
 	default:
 		die("Unknown region\n");  	 		
}
$regexpPrices = "~id=\"product_name_.*>(.+)<.*class=\"price\".*>(.+)<~isU";
$regexpPricesB = "~class=\"product\">(.+)class=\"clear_float\">~isU";
$regexpPrices2 = "~href=\"(.+)\".*>(.+)<.*itemprop=\"price\">(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*>(.+)<~isU";
$avail = 'class="buy"';

	$AC->flush_requests();
	$AC->__set('callback','callback_two');
	$url1 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTerm='.ENGINE_TYPE.'&categoryId=&storeId=11651&catalogId=10001&langId=-20&pageSize=100&beginIndex=0&sType=SimpleSearch&resultCatEntryType=2&showResultsPage=true&searchSource=Q&pageView=';
	$url2 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10033&storeId=11651';
	$url3 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10007&storeId=11651';
	$url4 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=11008&storeId=11651';
	$url5 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10004&storeId=11651';
	$url6 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=11005&storeId=11651';
	$url7 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10112&storeId=11651';
	$url8 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10006&storeId=11651';
	$url9 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10064&storeId=11651';
	$url10 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=11004&storeId=11651';
	$url11 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10061&storeId=11651';
	$url12 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10209&storeId=11651';
	$url13 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10279&storeId=11651';
	$url14 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=11505&storeId=11651';
	$url15 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10058&storeId=11651';
	$url16 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10176&storeId=11651';
	$url17 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10060&storeId=11651';
	$url18 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10199&storeId=11651';
	$url19 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10268&storeId=11651';
	$url20 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10262&storeId=11651';
	$url21 = 'http://'.$region.'domo.ru/catalog/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&maxPrice=&top_category=&showResultsPage=true&langId=-20&beginIndex=0&advancedSearch=&sType=SimpleSearch&metaData=&pageSize=100&manufacturer=&resultCatEntryType=2&catalogId=10001&pageView=grid&searchTerm='.ENGINE_TYPE.'&minPrice=&urlLangId=-20&categoryId=10013&storeId=11651';

	for ($i=1; $i <=21 ; $i++) { 
		$AC->get(${"url".$i}, null, $options);
		$AC->add_debug_msg(${"url".$i});
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->get($urls, NULL, $options);
	    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
	  }
	  unset($urls);

	  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}
	
	unset($urls);



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $region;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }	
		if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }       
  } else {
	  preg_match_all($regexpPricesB, $response, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $key) {
			if (strripos($key[1], $avail) !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				$matches[3] = 0;
			}

			$matches = clean_info($matches, array(1,2,3));

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);			
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPricesB;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $region;
	global $avail;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);       
  } else {
	  preg_match_all($regexpPricesB, $response, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $key) {
			if (strripos($key[1], $avail) !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				$matches[3] = 0;
			}

			$matches = clean_info($matches, array(1,2,3));

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);			
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
  }
}

