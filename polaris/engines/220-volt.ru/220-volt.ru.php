<?php
/**
 * 220-volt.ru
 */
switch (EXTRA_PARAM) {
  case 'moscow': $region = '7700000000000'; $domain = 'www.'; break;
  case 'spb': $region = '7800000000000'; $domain = 'www.'; break;    
  case 'rostov': $region = '6100000100000'; $domain = 'rostov.'; break;
  //case 'novocherkassk': $region = '6100000900000'; $domain = 'www.'; break; // rostov
  //case 'volgodonsk': $region = '6100000100000'; $domain = 'www.'; break; // rostov
  //case 'taganrog': $region = '6100001100000'; $domain = 'www.'; break; // rostov
  //case 'shahty': $region = '7500000100000'; $domain = 'www.'; break; // rostov
  case 'novosibirsk': $region = '5400000100000'; $domain = 'novosibirsk.'; break;
 	case 'yekaterinburg': $region = '6600000100000'; $domain = 'ekaterinburg.'; break;
 	case 'kazan': $region = '1600000100000'; $domain = 'kazan.'; break;
 	//case 'almetevsk': $region = '1600800100000'; $domain = 'www.'; break; // kazan
 	//case 'naberezhnye-chelny': $region = '1600000200000'; $domain = 'www.'; break; // kazan
 	//case 'nizhnekamsk': $region = '1603100100000'; $domain = 'www.'; break; // kazan
 	case 'novgorod': $region = '5200000100000'; $domain = 'nizhniy-novgorod.'; break;
 	//case 'arzamas': $region = '5200000400000'; $domain = 'www.'; break; // novgorod
 	//case 'pavlovo': $region = '5203200100000'; $domain = 'www.'; break;// novgorod
 	//case 'sarov': $region = '5200000300000'; $domain = 'www.'; break;// novgorod
 	case 'abakan': $region = '1900000100000'; $domain = 'www.'; break;
 	case 'krasnodar': $region = '2300000100000'; $domain = 'krasnodar.'; break;
 	//case 'anapa': $region = '2300300100000'; $domain = 'www.'; break; // krasnodar
 	//case 'armavir': $region = '2300000200000'; $domain = 'www.'; break; // krasnodar
 	//case 'kropotkin': $region = '2301200100000'; $domain = 'www.'; break;// krasnodar
 	//case 'novorossijsk': $region = '2300000600000'; $domain = 'www.'; break;// krasnodar
 	//case 'sochi': $region = '2300000700000'; $domain = 'www.'; break;// krasnodar
 	//case 'tuapse': $region = '2303600100000'; $domain = 'www.'; break;// krasnodar
 	case 'irkutsk': $region = '3800000300000'; $domain = 'irkutsk.'; break;
 	//case 'angarsk': $region = '3800000400000'; $domain = 'www.'; break; // irkutsk
 	//case 'bratsk': $region = '3800000400000'; $domain = 'www.'; break; // irkutsk
 	case 'murmansk': $region = '5100000100000'; $domain = 'murmansk.'; break;
 	//case 'apatity': $region = '5100000200000'; $domain = 'www.'; break; // murmansk
 	case 'arhangelsk': $region = '2900000100000'; $domain = 'arhangelsk.'; break;
 	//case 'severodvinsk': $region = '2900000400000'; $domain = 'www.'; break;//arhangelsk
 	case 'astrakhan': $region = '3000000100000'; $domain = 'astrakhan.'; break;
 	case 'krasnoyarsk': $region = '2400000100000'; $domain = 'krasnoyarsk.'; break;
 	//case 'achinsk': $region = '3000000100000'; $domain = 'www.'; break;//krasnoyarsk
 	case 'saratov': $region = '6400000100000'; $domain = 'saratov.'; break;
 	//case 'balakovo': $region = '6400000400000'; $domain = 'www.'; break;//saratov
 	//case 'ehngels': $region = '6400001300000'; $domain = 'www.'; break;//saratov
 	case 'barnaul': $region = '2200000100000'; $domain = 'barnaul.'; break;
 	//case 'biysk': $region = '2200000100000'; $domain = 'www.'; break; // barnaul
 	case 'belgorod': $region = '3100000100000'; $domain = 'belgorod.'; break;
 	//case 'gubkin': $region = '3100000400000'; $domain = 'www.'; break;//belgorod
 	//case 'staryj-oskol': $region = '3100000200000'; $domain = 'www.'; break;//belgorod
 	case 'berezniki': $region = '5900000200000'; $domain = 'perm.'; break;
 	case 'blagoveschensk': $region = '2800000100000'; $domain = 'blagoveshensk.'; break;
 	case 'voronezh': $region = '3600000100000'; $domain = 'voronezh.'; break;
 	//case 'borisoglebsk': $region = '3600500100000'; $domain = 'www.'; break; // voronezh
 	case 'bryansk': $region = '3200000100000'; $domain = 'bryansk.'; break;
	case 'velikijnovgorod': $region = '5300000100000'; $domain = 'velikiy-novgorod.'; break;
	case 'vladivostok': $region = '2500000100000'; $domain = 'vladivostok.'; break;
	case 'vladikavkaz': $region = '1500000100000'; $domain = 'vladikavkaz.'; break;
	case 'vladimir': $region = '3300000100000'; $domain = 'vladimir.'; break;
	case 'volgograd': $region = '3400000100000'; $domain = 'volgograd.'; break;
	//case 'volzhskij': $region = '3400000200000'; $domain = 'www.'; break; // volgograd
	//case 'kamyshin': $region = '3400000300000'; $domain = 'www.'; break;//volgograd
	case 'vologda': $region = '3500000100000'; $domain = 'vologda.'; break;
	//case 'cherepovec': $region = '3500000200000'; $domain = 'www.'; break;//vologda
	case 'mahachkala': $region = '0500000100000'; $domain = 'mahachkala.'; break;
	//case 'derbent': $region = '0500000600000'; $domain = 'www.'; break;//mahachkala
	case 'ulyanovsk': $region = '7300000100000'; $domain = 'ulyanovsk.'; break;
	//case 'dimitrovgrad': $region = '7300000200000'; $domain = 'www.'; break;//ulyanovsk
	case 'yekaterinburg': $region = '6600000100000'; $domain = 'ekaterinburg.'; break;
	//case 'krasnoturinsk': $region = '6600001000000'; $domain = 'www.'; break;//yekaterinburg
	//case 'nizhnij-tagil': $region = '6600002300000'; $domain = 'www.'; break;//yekaterinburg
	//case 'pervouralsk': $region = '6600001600000'; $domain = 'www.'; break;//yekaterinburg
	//case 'revda': $region = '6600001800000'; $domain = 'www.'; break;//yekaterinburg
	case 'stavropol': $region = '2600000100000'; $domain = 'stavropol.'; break;
	//case 'essentuki': $region = '2600000200000'; $domain = 'www.'; break;//stavropol
	//case 'kislovodsk': $region = '2600000400000'; $domain = 'www.'; break;//stavropol
	//case 'mineralnye-vody': $region = '2601700200000'; $domain = 'www.'; break;//stavropol
	//case 'nevinnomyssk': $region = '2600000600000'; $domain = 'www.'; break;//stavropol
	//case 'pyatigorsk': $region = '2600000700000'; $domain = 'www.'; break;//stavropol
	case 'kursk': $region = '4600000100000'; $domain = 'kursk.'; break;
	//case 'zheleznogorsk': $region = '4600000300000'; $domain = 'www.'; break;//kursk
	case 'ivanovo': $region = '3700000100000'; $domain = 'ivanovo.'; break;
	case 'izhevsk': $region = '1800000100000'; $domain = 'izhevsk.'; break;
	case 'joshkar-ola': $region = '1200000100000'; $domain = 'yoshkar-ola.'; break;
	case 'kaliningrad': $region = '3900000100000'; $domain = 'kaliningrad.'; break;
	case 'kaluga': $region = '4000000100000'; $domain = 'kaluga.'; break;
	//case 'obninsk': $region = '4000000200000'; $domain = 'www.'; break;//kaluga
	case 'ryazan': $region = '6200000100000'; $domain = 'ryazan.'; break;
	//case 'kasimov': $region = '6200000400000'; $domain = 'www.'; break;//ryazan
	case 'kemerovo': $region = '4200000900000'; $domain = 'kemerovo.'; break;
	//case 'novokuzneck': $region = '4200001200000'; $domain = 'www.'; break;//kemerovo
	case 'kirov': $region = '4300000100000'; $domain = 'kirov.'; break;
	case 'kostroma': $region = '4400100100000'; $domain = 'kostroma.'; break;
	case 'kurgan': $region = '4500000100000'; $domain = 'kurgan.'; break;
	case 'lipeck': $region = '4800000100000'; $domain = 'lipetsk.'; break;
	case 'hanty-mansijsk': $region = '8600000100000'; $domain = 'hanty-mansijsk.'; break;
	//case 'lyantor': $region = '8600900200000'; $domain = 'www.'; break;//hanty-mansijsk
	//case 'nefteyugansk': $region = '8600001400000'; $domain = 'www.'; break;//hanty-mansijsk
	//case 'nizhnevartovsk': $region = '8600001100000'; $domain = 'www.'; break;//hanty-mansijsk
	//case 'nyagan': $region = '8600000500000'; $domain = 'www.'; break;//hanty-mansijsk
	//case 'surgut': $region = '8600001000000'; $domain = 'www.'; break;//hanty-mansijsk
	//case 'yugorsk': $region = '8600001600000'; $domain = 'www.'; break;//hanty-mansijsk
	case 'chelyabinsk': $region = '7400000100000'; $domain = 'chelyabinsk.'; break;
	//case 'magnitogorsk': $region = '7400000900000'; $domain = 'www.'; break;//chelyabinsk
	//case 'miass': $region = '7400001000000'; $domain = 'www.'; break;//chelyabinsk
	case 'majkop': $region = '0100000100000'; $domain = 'majkop.'; break;
	case 'nadym': $region = '8900000500000'; $domain = 'salehard.'; break;
	case 'nalchik': $region = '0700000100000'; $domain = 'nalchik.'; break;
	case 'ufa': $region = '0200000100000'; $domain = 'ufa.'; break;
	//case 'neftekamsk': $region = '0200000300000'; $domain = 'www.'; break;//ufa
	//case 'oktyabrskij': $region = '0200000400000'; $domain = 'www.'; break;//ufa
	//case 'salavat': $region = '0200000500000'; $domain = 'www.'; break;//ufa
	//case 'sterlitamak': $region = '0200001400000'; $domain = 'www.'; break;//ufa
	case 'orenburg': $region = '5600000100000'; $domain = 'orenburg.'; break;
	//case 'novotroick': $region = '5600000300000'; $domain = 'www.'; break;//orenburg
	//case 'orsk': $region = '5600000400000'; $domain = 'www.'; break;//orenburg
	case 'novyj-urengoj': $region = '8900000600000'; $domain = 'salehard.'; break;
	case 'noyabrsk': $region = '8900000700000'; $domain = 'salehard.'; break;
	case 'omsk': $region = '5500000100000'; $domain = 'omsk.'; break;
	case 'penza': $region = '5800000100000'; $domain = 'penza.'; break;
	case 'perm': $region = '5900000100000'; $domain = 'perm.'; break;
	case 'petrozavodsk': $region = '1000000100000'; $domain = 'petrozavodsk.'; break;
	case 'pskov': $region = '6000000100000'; $domain = 'pskov.'; break;
	case 'yaroslavl': $region = '7600000100000'; $domain = 'yaroslavl.'; break;
	//case 'rybinsk': $region = '7601500100000'; $domain = 'www.'; break;//yaroslavl
	case 'samara': $region = '6300000100000'; $domain = 'samara.'; break;
	//case 'syzran': $region = '6300000800000'; $domain = 'www.'; break;//samara
	//case 'tolyatti': $region = '6300000700000'; $domain = 'www.'; break;//samara
	case 'saransk': $region = '1300000100000'; $domain = 'saransk.'; break;
	case 'sarov': $region = '5200000300000'; $domain = 'nizhniy-novgorod.'; break;
	case 'tomsk': $region = '7000000100000'; $domain = 'tomsk.'; break;
	//case 'seversk': $region = '7000000300000'; $domain = 'www.'; break;//tomsk
	case 'smolensk': $region = '6700000300000'; $domain = 'smolensk.'; break;
	//case 'sochi': $region = '2300000700000'; $domain = 'www.'; break;
	case 'syktyvkar': $region = '1100000100000'; $domain = 'syktyvkar.'; break;
	//case 'uhta': $region = '1100000800000'; $domain = 'www.'; break;//syktyvkar
	case 'tambov': $region = '6800000400000'; $domain = 'tambov.'; break;
	case 'tver': $region = '6900000100000'; $domain = 'tver.'; break;
	case 'tyumen': $region = '7200000100000'; $domain = 'tyumen.'; break;
	//case 'tobolsk': $region = '7200000200000'; $domain = 'www.'; break;//tyumen
	case 'tula': $region = '7100000100000'; $domain = 'tula.'; break;
	case 'ulan-udeh': $region = '0300000100000'; $domain = 'ulan-ude.'; break;
	case 'habarovsk': $region = '2700000100000'; $domain = 'habarovsk.'; break;
	case 'cheboksary': $region = '2100000100000'; $domain = 'cheboksary.'; break;
	case 'cherkessk': $region = '0900000100000'; $domain = 'cherkessk.'; break;
	case 'chita': $region = '7500000100000'; $domain = 'chita.'; break;
	case 'yakutsk': $region = '1400000100000'; $domain = 'yakutsk.'; break;
 	default: die("Unknown region\n");    	
}

$post_data = array('globalCity' => $region);
$urlStart 		= 'http://'.$domain.'220-volt.ru/producer/' . ENGINE_TYPE . '/';
$regexpCat1		= "~catalog-list\">(.+)</div~isU";
$regexpCat2   = "~<li><a.*href=\"(.+)\"~isU";
$regexpPagin1 = "~<div class=\"pager\">(.+)</div>~isU";
$regexpPagin2 = "~<li.*href.*>(.+)<~isU";
$regexpBlock1 = "~class=\"new-item-list-bulk\"(.+)</li>~isU";
$regexpBlock2 = "~class=\"new-item-list-name\".*<a.*href=\"(.+)\".*>(.+)<.*class=\"new-item-list-price-im\".*<ins>(.+)<~isU";
$regexpBlock3 = "~class=\"new-item-list-name\".*<a.*href=\"(.+)\".*>(.+)<~isU";
$regionName = "~v-middle mvlspace-5\">(.+)<~isU";


if (1 == 2) { // TASKS
	$AC->add_debug_msg('TASKS:');
	$AC->flush_requests();
	$AC->__set('callback', 'callback_three');
	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->request($key, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));    
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
} else {

/**
 * Callback_one
 */
	//echo "Callback one ----------------------------------------\n";
	$AC->request($urlStart, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
	$AC->request($urlStart, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180 || $catlinks) break;
	  if (!$catlinks) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $url => $attr) {
		    $AC->request($url, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));   
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
	  }
	}


/**
 * Callback_two
 */
	if ($catlinks) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');
		foreach ($catlinks as $key => $value) { 		// Перебираем страницы категорий
			$AC->request($key, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
			//echo $key . "\n";
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
			if (round(microtime(1) - $time_start, 0) >= 180) break;
		  $AC->flush_requests();
		  foreach ($bad_urls as $url => $attr) {
		    $AC->request($url, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));   
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}


	/**
	 * Callback_three
	 */
		//echo "Callback three ----------------------------------------\n";
		$AC->flush_requests();
		$AC->__set('callback','callback_three');
		
		foreach ($catlinks as $key => $value) { 		// Перебираем страницы категорий		
				if ($value < 1) { // Страницы с карточками товара, с учётом пагинации				
					//$AC->request($key, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
				} else {
					for ($q=0; $q<$value;$q++ ) {
						if ($q == 0) {
							$AC->request($key, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
						} else {
							$AC->request($key . '?p=' . $q*30, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
						}
					}
					$AC->execute(WINDOW_SIZE);
				}
		}
		

		while ($bad_urls) {
			if (round(microtime(1) - $time_start, 0) >= 180) break;
		  $AC->flush_requests();
		  foreach ($bad_urls as $url => $attr) {
		    $AC->request($key, "POST", $post_data, null, array(CURLOPT_COOKIEJAR 	=> __DIR__.'/cook/'.time().'.cook', CURLOPT_COOKIEFILE	=> __DIR__.'/cook/'.time().'.cook'));
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
	} // (if catlinks)
}

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpCat1;
  global $regexpCat2;
  global $bad_urls;
  global $catlinks;
  global $regionName;
  global $domain;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {
  	preg_match($regionName, $response, $mReg); // Region
  	echo EXTRA_PARAM.PHP_EOL;
  	echo iconv('windows-1251', 'utf-8', $mReg[1]).PHP_EOL;

  	preg_match($regexpCat1, $response, $matches); // Режем адреса в блоке
  	preg_match_all($regexpCat2, @$matches[1], $matchesLinks, PREG_SET_ORDER); // Режем адреса в блоке  	    
  	foreach ($matchesLinks as $key) {  		
			$catlinks['http://'.$domain.ENGINE_CURR.$key[1]] = 0;
			AngryCurl::add_debug_msg('http://www.'.ENGINE_CURR.$key[1]);
		}
  }
}

function callback_two($response, $info, $request) {
  global $regexpPagin1;
  global $regexpPagin2;
  global $regionName;
  global $catlinks;
  global $bad_urls;
	global $regexpBlock1;
	global $regexpBlock2;
	global $regexpBlock3;
	global $itemsArray;
	global $domain;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 && strripos($request->url, 'youtube') === false && strripos($request->url, 'facebook') === false) {            
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {
  	preg_match($regionName, $response, $mReg); // Region
  	echo EXTRA_PARAM.PHP_EOL;
  	echo iconv('windows-1251', 'utf-8', $mReg[1]).PHP_EOL;

		preg_match($regexpPagin1, $response, $matches);
		//print_r($matches);
		if ($matches) {
			preg_match_all($regexpPagin2, $matches[1], $matches2);
			//print_r($matches2);
			$temparrpage = array();
			foreach ($matches2[1] as $key => $value) {
				if (is_numeric($value)) {
					$temparrpage[] = $value;
				}
			}
			if (@max($temparrpage) > @$catlinks[$info['url']]) {
				$catlinks[$info['url']] = @max($temparrpage);		    	
			}
		}

  	preg_match_all($regexpBlock1, $response, $matches2, PREG_SET_ORDER);

  	if (!$matches2) {
  		$bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  	}

  	foreach ($matches2 as $key) {
			preg_match($regexpBlock2, $key[1], $matches);
			//print_r($matches);
			$matches[1] = 'http://'.$domain.ENGINE_CURR.$matches[1];
			if ($matches[3] && strripos($key[1], 'icon-cart') !== false) {
				$matches = clean_info($matches, array(1,2,3), 'windows-1251');
			} else {
				preg_match($regexpBlock3, $key[1], $matches);
				$matches[1] = 'http://'.$domain.ENGINE_CURR.$matches[1];
				$matches[3] = 0;
				$matches = clean_info($matches, array(1,2,3), 'windows-1251');
			}
			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		} 
  }
}

function callback_three($response, $info, $request) {
	global $regexpBlock1;
	global $regexpBlock2;
	global $regexpBlock3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $domain;
	global $regionName;

	AngryCurl::add_debug_msg($info['http_code']);

  if ($info['http_code'] !== 200 || strlen($response) < 1000 && strripos($request->url, 'youtube') === false && strripos($request->url, 'facebook') === false) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);    
  } else {	
  	preg_match($regionName, $response, $mReg); // Region
  	echo EXTRA_PARAM.PHP_EOL;
  	echo iconv('windows-1251', 'utf-8', $mReg[1]).PHP_EOL;

  	preg_match_all($regexpBlock1, $response, $matches2, PREG_SET_ORDER);
  	foreach ($matches2 as $key) {
			preg_match($regexpBlock2, $key[1], $matches);
			$matches[1] = 'http://'.$domain.ENGINE_CURR.$matches[1];
			if ($matches[3] && strripos($key[1], 'icon-cart') !== false) {
				$matches = clean_info($matches, array(1,2,3), 'windows-1251');
			} else {
				preg_match($regexpBlock3, $key[1], $matches);
				$matches[1] = 'http://'.$domain.ENGINE_CURR.$matches[1];
				$matches[3] = 0;
				$matches = clean_info($matches, array(1,2,3), 'windows-1251');
			}
			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		} 	
  }
}
