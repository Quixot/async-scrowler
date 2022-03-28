<?php
//f.ua
	$reg_1 = "~class=\"credit_block_credit\">.*</a>(.+)".iconv('utf-8', 'windows-1251', 'грн')."~isU";
	$reg_2 = "~class=\"product_code\".*<h1.*>(.+)<~isU";
	$reg_3 = "~itemprop=\"price\" content=\"(.+)\"~isU";

	$regexpSecrepKeyAll = "~</header>.*<style>(.+)</style>~isU";
	$regexpSecrepKeyByOne = "~\.(.+){~isU";
	$regexpSecrepKey  = "~<div class=\"price\">(.+)<div class=\"clr\"></div>~isU";
	$regexpSecrepKey2 = "~<div class=\"(.+)\"~isU";

	$regexpPrices = "~<div class=\"catalog_item(.+)<div class=\"opacity_bg\">~isU";
	$regexpPrices2_1 = "~<div class=\"price ";
	$regexpPrices2_2 = "\".*class=\"main product_price_main.*content=\"(.+)\"~isU";
	$regexpPrices3_2 = "\".*class=\"action product_price_action.*content=\"(.+)\"~isU";
	$regexpName = "~<h1 itemprop=\"name\">(.+)</h1>~isU";
	$itemsArray = array();

	regular_one();

	if ($itemsArray) {
		file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
		$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';
	}


	if (file_exists($cookfilepath)) {
		echo unlink($cookfilepath);
	}
	




function regular_one() {
	global $reg_1;
	global $reg_2;
	global $reg_3;
	global $regexpSecrepKeyAll;
	global $regexpSecrepKeyByOne;
	global $regexpSecrepKey;
	global $regexpSecrepKey2;	
	global $regexpPrices;
	global $regexpPrices2_1;
	global $regexpPrices2_2;
	global $regexpPrices3_2;
	global $regexpName;

	global $itemsArray;
	global $city;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';

	if (!file_exists($cookfilepath) || time() - filemtime($cookfilepath) > 3600) {
		//die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
	} else {
		copy($cookfilepath, '/var/www/polaris.ua/engines/f.ua/cookies2/kiev.txt');
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
	$glob = glob('/var/www/polaris.ua/engines/f.ua/content/*.txt');

	$baselinks = array('https://f.ua/shop/pylesosy/polaris/','https://f.ua/shop/paroochistiteli/polaris/','https://f.ua/shop/utyugi/polaris/','https://f.ua/shop/roboty-pylesosy/polaris/','https://f.ua/shop/elektrogrili/polaris/','https://f.ua/shop/nabory-dlya-strizhki/polaris/','https://f.ua/shop/miksery/polaris/','https://f.ua/shop/kofevarki-i-kofemashiny/polaris/','https://f.ua/shop/blendery/polaris/','https://f.ua/shop/stajlery-dlya-volos/polaris/','https://f.ua/shop/multivarki-skorovarki-risovarki/polaris/','https://f.ua/shop/kofemolki/polaris/','https://f.ua/shop/myasorubki/polaris/','https://f.ua/shop/elektropechi/polaris/','https://f.ua/shop/buterbrodnicy-i-vafelnicy/polaris/','https://f.ua/shop/elektrochajniki/polaris/','https://f.ua/shop/elektrochajniki/polaris/2/','https://f.ua/shop/feny/polaris/','https://f.ua/shop/sokovyzhimalki/polaris/','https://f.ua/shop/tostery/polaris/','https://f.ua/shop/vesy-napolnye/polaris/','https://f.ua/shop/sushki-dlya-ovoschej/polaris/','https://f.ua/shop/vesy-kuhonnye/polaris/','https://f.ua/shop/aksessuary-k-hlebopechkam-i-multivarkam/polaris/','https://f.ua/shop/jogurtnicy/?brands=clatronic;polaris/','https://f.ua/shop/parovarki/polaris/','https://f.ua/shop/manikyurnye-nabory/polaris/','https://f.ua/shop/frityurnicy/?brands=hilton;polaris','https://f.ua/shop/aksessuary-k-myasorubkam/polaris/','https://f.ua/shop/vozduhoochistiteli-mojki-vozduha/polaris/','https://f.ua/shop/uvlazhniteli-vozduha/polaris/','https://f.ua/shop/elektricheskie-konvektory/polaris/','https://f.ua/shop/teploventilyatory/?brands=gorenje;polaris','https://f.ua/shop/infrakrasnye-obogrevateli/?brands=polaris;ufo','https://f.ua/shop/mikatermicheskie-obogrevateli/polaris/','https://f.ua/shop/massazhery/polaris/','https://f.ua/shop/skovorodki-i-sotejniki/polaris/','https://f.ua/shop/kastryuli/polaris/','https://f.ua/shop/nabory-kastryul-i-skovorodok/?brands=gorenje;polaris','https://f.ua/shop/protivni-i-formy-dlya-vypechki/polaris/','https://f.ua/shop/kuhonnye-nozhi/?brands=polaris;tefal','https://f.ua/shop/kryshki-dlya-posudy/polaris/','https://f.ua/shop/french-press/polaris/');

	$baselinksID = array();
	foreach ($baselinks as $bsurl) {
		$baselinksID[] = preg_replace('/[^a-zA-Z0-9&]/', '', $bsurl);
	}

	for ($i=0; $i < count($baselinks); $i++) { 
		//echo '/var/www/polaris.ua/engines/f.ua/content/'.$i.'.txt'.PHP_EOL;
		if (!in_array('/var/www/polaris.ua/engines/f.ua/content/'.$baselinksID[$i].'.txt', $glob)) {
			$links .= $baselinks[$i].',';
			//$linksid .= $baselinksID[$i].',';
		}
	}
	$links = substr($links, 0, -1);
	//$linksid = substr($linksid, 0, -1);

	//$url = 'http://www.ozon.ru/?context=search&text='.ENGINE_TYPE.'&store=1,0';//$url = 'https://www.ozon.ru/search/?brand=17476997&page=3&text=polaris';
	$cmd = 'timeout -k 1000s 1001s casperjs /var/www/polaris.ua/engines/f.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	//die();
	if ($links && file_exists($cookfilepath)) {
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}

	

	//http://schema.org/Product
	//$glob = glob('/var/www/polaris.ua/engines/f.ua/content/*.txt'); //https://www.ozon.ru/brand/polaris-17476997/?page=
	$glob = glob('/var/www/polaris.ua/engines/f.ua/content/*.txt');
	if ($glob) {
		$count_all_items = 0;
		foreach ($glob as $addr) {
			preg_match('~content/(.+).txt~isU', $addr, $mReqUrl);
			//print_r($mReqUrl);
			$request_url = $mReqUrl[1];
			
			$response = file_get_contents($addr);
			
		  
			preg_match($regexpSecrepKeyAll, $response, $matches_keyAll);
			//print_r($matches_keyAll);
			preg_match_all($regexpSecrepKeyByOne, $matches_keyAll[1], $matches_secret_one);
			//print_r($matches_secret_one);

			preg_match($regexpSecrepKey, $response, $matches_key);
			//print_r($matches_key);

			preg_match_all($regexpSecrepKey2, $matches_key[1], $matches_secret);
			//print_r($matches_secret);

			$result = array_diff($matches_secret[1], $matches_secret_one[1]);
			$result = array_values($result);
			//print_r($result);

			$tempclass = trim($result[0]);
			
			//die();

			if ($tempclass) {
				AngryCurl::add_debug_msg('The secret key is: '.$tempclass);
				preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
				//print_r($matches2);
				foreach ($matches2 as $key) {
					preg_match("~<div class=\"".$tempclass."\".*span.*>(.+)</.*class=\"title.*href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
					//print_r($matches);
					if (@$matches[1] && filter_var(trim($matches[2]), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
						$matches[2] = trim($matches[2]);
						$matches[3] = trim(strip_tags($matches[3]));
						$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);

						price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[2]] = array($matches[3], $matches[1], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);		
						AngryCurl::add_debug_msg($matches[2]." | ".$matches[3]." | ".$matches[1]);
					} else {
						preg_match("~class=\"title.*href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						price_change_detect($matches[1], $matches[2], $matches[1], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);		
						AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | 0");
					}
				}	
			} else {
				AngryCurl::add_debug_msg('Direct Price');
				preg_match_all("~class=\"catalog_item(.+)class=\"td_info\"~isU", $response, $matches2, PREG_SET_ORDER);
				//print_r($matches2);
				foreach ($matches2 as $key) {
					preg_match("~href=\"(.+)\".*>(.+)<.*class=\"price\">.*span.*>(.+)<~isU", $key[0], $matches);
					//print_r($matches);
					if (filter_var(trim($matches[1]), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) && $matches[2]) {
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);		
						AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | ".$matches[3]);
						$count_all_items++;
					} else {
						preg_match("~href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
						if (filter_var(trim($matches[1]), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) && $matches[2]) {
							$matches[1] = trim($matches[1]);
							$matches[2] = trim(strip_tags($matches[2]));
							$matches[3] = '0';
							price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
							$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
							AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | 0");
							$count_all_items++;
						}
					}
				}	
			}
			//unlink($addr);
		}
		echo 'Позиций: '.$count_all_items.PHP_EOL;
		return 1;
	} else {
		return 0;
	}
	
}