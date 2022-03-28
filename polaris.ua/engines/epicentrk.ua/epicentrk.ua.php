<?php
/**
 * epicentrk.ua
 */
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = '4'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '13'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = 'def5020062140f6083cb9c303265a14ce8ea925c81b85b56db5b5cbe8fdb9c42aabed1ccf7bbb3ffebf818c64e2499d850ae5ccb276b5ef489ec6f0558f67851e9bac582210fd2357d504c88b0cf753c300d115b05f776ba0cefecf2004cf9f3902a0f6bb63f9a3929d187b7f23d70b23f38c900e3e2144eff8baf5b4202b7d5f5467a190df844094940c1496ccc4f781120e235c004b6456366180d906a9369d0c4f17519bcb4570126f9cfe8024bdba144af3dc43bf4cec417505d75cb08c8acddb9c73d47849d14d2cb922b5fd55dff6498823ee7bba02d765472064947af9c9be6a5389e52c2951220036e57107eba17584e04b3eaf7bdd1809f3f67ce4b6ccc4892d0d8c9b74f7d358f9cd94aef8d17dc188c3fe2b70f03c6e6812df3fded54fd9b514f4dc251a29c37dbf569fa6291cfdc26b6351977d97105f100ffa4a5e10d1e924fc7d4ab53df30421a1fa6a3c58d5ce03d46bb9de361fe8251730168c130db3401cf8e7a82c5029e5844253e87a7c775ef14688de5379ae1ed6ceaa42eb098e588ea8a48632207bbcb12482efa540809eff30f85f2569fc731ba7bc875a7857b6139fd113dd84793c6b74b11390b04231c57d774c73314ac3973436ccaf0fc5c974f3a29c5b4d9dc1d7bf638895d8ebfd77a65c2b49b36d501c8c0ba2d0b12058ba62748fa12d27efca196c43ff4aa7ab27fdfd120f0cab1687de8e0fd3d7e5bcdc5f9b146fc03313e744cb3c9c9052cc4d60441b6e3685e2bdad14bdfe6bdd6823f69543e0579cabf99368176a1b57d61ddb56c396f1ffb2814bdf9d5a7cb0df521e162cf30c4b7ba4fd6ccd08cdcc9223c9230a46b12339ba248d0157219d3a88fc465af6eea49f43c1c638f12b97bc5fcc8c92a441f6b5b47bccc1b17167835d74ffb2d0bcf465c2f2d0caa31f89dad55a654031e77dcbbe421f9d65478524c8c00febb22f7f418d6d1071ae0eaa8fcdc9b5a61b1021c22406c98b38fb0eacab1d3fbd550d85572d3b560feee112cb8b106833af87da0710f32b1fe0f986b3f68cb0798a26f35d37c1c78158f1f3f6b8041f5f8697e13fa6aeeb3704cb0e6b9835957712bd456584c1a0f0499d52214f5e72ce5918250d0045215dd445b050f5edd7d4d75f9c3fef3a22e09ba32c638122cd9988dd1e49e4f375fe05dc3e31c1293de697ea29a8a047f172d8275d4e84d1ca9f74bef33a73a3b2ebc4e74af4b2461418444bfa53462865dedeef600b91c158f3af2cdebacdc0abdc799e64292a204327f36d5643fa30bccc915b20499cb52'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '10'; break;
	case 'lvov': 		$city = 'Львов'; 		$region = '8'; 	break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 	 = "~id=\"paged(.+)</nav>~isU";
$regexpP2  = "~<a.*>(.+)</a>~isU";

$regexpPrices = "~columns product-Wrap(.+)</button>~isU";
$regexpPrice = "~class=\"card__name.*href=\"(.+)\".*>(.+)</a>.*class=\"card__price-sum.*>(.+)<~isU";
$regexpPrice2 = "~class=\"card__name.*href=\"(.+)\".*>(.+)<~isU";

$avail = "Немає в наявності";

$options 			 = array(
								//CURLOPT_COOKIE 					=> 'BITRIX_SM_LOCATION='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT 	=> 20,
                CURLOPT_TIMEOUT        	=> 20,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
	);

$directLinks = explode("\n", file_get_contents('/var/www/polaris.ua/engines/'.ENGINE_CURR.'/links.txt'));
array_walk($directLinks, 'trim_value');

foreach ($directLinks as $cururl) {

		$qOfPaginationPages = 0;


		$AC->get($cururl);
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $url) {
		    $AC->get($url, NULL, $options);
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}


		if ($qOfPaginationPages > 9990) {
			echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

			for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			  $AC->get($cururl.'?PAGEN_1='.$i);
			}
			$AC->execute(WINDOW_SIZE);

			while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
			  $AC->flush_requests(); // Чистим массив запросов
			  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
			    $AC->get($urls);
			    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
			  }
			  unset($urls);

			  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
			  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
			}	
			unset($urls);
		}

}

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrice;
	global $regexpPrice2;
	global $avail;
	global $itemsArray;
  global $qOfPaginationPages;
  global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {            
		$bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 200) { $bad_urls = array(); }  
  } else {
		preg_match("~class=\"header__locations-city.*>(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 


		//file_put_contents('/var/www/philips/engines/epicentrk.ua/content.txt', $response);
		preg_match($regexpP, $response, $matches);
		//print_r($matches);
		@preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}
		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);		    	
		}

	  preg_match_all($regexpPrices, $response, $matches, PREG_SET_ORDER);
		//print_r($matches);
	  foreach ($matches as $key) {
	  	preg_match($regexpPrice, $key[1], $matches2);

	  	$matches2[1] = 'https://epicentrk.ua'.trim($matches2[1]);
	  	$matches2[2] = trim(strip_tags($matches2[2]));

	  	if (@strripos($matches2[3], '.') !== false) {
	  		$pricecl = preg_replace('~[\D]+~', '' , substr($matches2[3], 0, strripos($matches2[3], '.')));
	  	} else {
	  		$pricecl = preg_replace('~[\D]+~', '' , $matches2[3]);
	  	}
	
	  	if ($matches2[1] && $matches2[2]) {	
		  	price_change_detect($matches2[1], $matches2[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
		  	$itemsArray[$matches2[1]] = array($matches2[2], $pricecl, date("d.m.y-H:i:s"),$request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$pricecl);	
	  	}	else {
	  		preg_match($regexpPrice2, $key[1], $matches2);
		  	$matches2[1] = 'https://epicentrk.ua'.trim($matches2[1]);
		  	$matches2[2] = trim(strip_tags($matches2[2]));
		  	$pricecl = 0;
	  		if ($matches2[1] && $matches2[2]) {	
			  	price_change_detect($matches2[1], $matches2[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
			  	$itemsArray[$matches2[1]] = array($matches2[2], $pricecl, date("d.m.y-H:i:s"),$request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$pricecl);	
	  		}
	  	}	
		}
  }
}
