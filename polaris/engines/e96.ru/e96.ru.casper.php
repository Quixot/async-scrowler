<?php
/**
 * e96.ru
 */
switch (EXTRA_PARAM) {
  case 'chelyabinsk': $region = 'Челябинск'; $domain = 'chelyabinsk.'; break;
  //case 'novgorod': $region = 'Нижний Новгород'; $domain = 'nn.'; break;
  case 'novosibirsk': $region = 'Новосибирск'; $domain = 'novosibirsk.'; break;
  case 'perm': $region = 'Пермь'; $domain = 'perm.'; break;
  case 'yekaterinburg': $region = 'Екатеринбург'; $domain = ''; break;
  case 'berezniki': $region = 'Березники'; $domain = 'berezniki.'; break;
  //case 'krasnoturinsk': $region = 'Краснотурьинск'; $domain = 'serov.'; break;
  case 'kurgan': $region = 'Курган'; $domain = 'kurgan.'; break;
  case 'magnitogorsk': $region = 'Магнитогорск'; $domain = 'magnitogorsk.'; break;
  case 'miass': $region = 'Миасс'; $domain = 'miass.'; break;
  case 'nadym': $region = 'Надым'; $domain = 'nadym.'; break;
  case 'nizhnevartovsk': $region = 'Нижневартовск'; $domain = 'nizhnevartovsk.'; break;
  case 'omsk': $region = 'Омск'; $domain = 'omsk.'; break;
  //case 'orenburg': $region = 'Оренбург'; $domain = 'orenburg.'; break;
  case 'samara': $region = 'Самара'; $domain = 'samara.'; break;
	//case 'tobolsk': $region = 'Тобольск'; $domain = 'tobolsk.'; break;
	//case 'tolyatti': $region = 'Тольятти'; $domain = 'toljatti.'; break;
	case 'tyumen': $region = 'Тюмень'; $domain = 'tyumen.'; break;
	case 'habarovsk': $region = 'Хабаровск'; $domain = 'habarovsk.'; break;
	//case 'cheboksary': $region = 'Чебоксары'; $domain = 'cheboksary.'; break;
	case 'yugorsk': $region = 'Югорск'; $domain = 'yugorsk.'; break;
  default:
    die("Unknown region\n");    
}

$url1 = 'http://'.$domain.'e96.ru/brands/' . ENGINE_TYPE;
$url2 = 'http://'.$domain.'e96.ru';
//'http://e96.ru/kitchen_appliance/crockery/kuhonnye_noji/rondell?page=2'
$regexpCatalog1	= "~<ul class=\"categories-min\">(.+)<div class=\"social-box\">~isU";
$regexpCatalog2 = "~<li><a href=\"(.+)\".*</a>(.+)<~isU";
$regexpPrices1 	= "~<li class=\"catalog-product\".*data-productid=\"(.+)</li>~isU";
$regexpPrices2 	= "~<a class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price price_big\">(.+)<~isU";
$regexpPrices3 	= "~<a class=\"name\".*href=\"(.+)\".*>(.+)<~isU";
$regexpRegion = "~cityselect link_js_orange.*>(.+)<~isU";

$AC->flush_requests();
$AC->__set('callback','callback_one');	

$qOfPagesArray = array();
$id[0] = $url1;
$AC->request('127.0.0.1', 'GET', null, null, null, $id);
$AC->execute(1);

while ($bad_urls) {
	if (round(microtime(1) - $time_start, 0) >= 300) break;
  $AC->flush_requests();
  foreach ($bad_urls as $urls) {
  	$id = array();
  	$id[0] = $urls;
    $AC->request('127.0.0.1', 'GET', null, null, null, $id);
  }
  unset($urls);
  $bad_urls = array();    
  $AC->execute(WINDOW_SIZE);
}	
unset($urls);

if ($qOfPagesArray) {
	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	foreach ($qOfPagesArray as $key => $value) {
		for ($i = 1; $i <= ceil($value / 20); $i++) {
			$id = array();
			if ($i == 1) { // Страницы с карточками товара, с учётом пагинации
				$id[0] = $key;
				if (strripos($id[0], 'http://')!== false) {
					$AC->request('127.0.0.1', 'GET', null, null, null, $id);
				}
			} else {
				$id[0] = $key.'?page='.$i;
				if (strripos($id[0], 'http://')!== false) {
					$AC->request('127.0.0.1', 'GET', null, null, null, $id);
				}
			}			
		}
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 1200) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	  	$id = array();
	  	$id[0] = $urls;
	    $AC->request('127.0.0.1', 'GET', null, null, null, $id);
	  }
	  unset($urls);
	  $bad_urls = array();    
	  $AC->execute(WINDOW_SIZE);
	}	
	unset($urls);
}


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpCatalog1;
  global $regexpCatalog2;
  global $regexpRegion;
  global $region;
  global $domain;
  global $bad_urls;
  global $qOfPagesArray;

	AngryCurl::add_debug_msg($request->id[0]);
	AngryCurl::add_debug_msg($request->id[1]);
	AngryCurl::add_debug_msg($request->id[2]);
	AngryCurl::add_debug_msg($request->options[10018]);

	$cmd = 'timeout -k 15s 20s /var/www/lib/phantomjs/bin/phantomjs --ignore-ssl-errors=true --cookies-file=/var/www/engines/e96.ru/cookies/'.$domain.'_'.$request->id[1].'.txt --proxy='.$request->id[1].' --proxy-auth='.$request->id[2].' /var/www/engines/e96.ru/run.js '.escapeshellarg($request->id[0]).' '.escapeshellarg($request->options[10018]);
	$phantomjs = exec("$cmd", $out, $err);  
	//print_r($err);   
	$response = stripcslashes($phantomjs);
	//echo $response;
	//file_put_contents('/var/www/engines/e96.ru/content.txt', $response);
	preg_match($regexpRegion, $response, $matches_region);
	AngryCurl::add_debug_msg('Регион - '.$matches_region[1]);
	if ($response === '408' || strlen($response) < 1000 || trim($matches_region[1]) != $region) {
		if (strripos($request->id[0], 'http://') !== false) {
			$bad_urls[] = $request->id[0];
			AngryCurl::add_debug_msg('bad url: '.$request->id[0]);
		}
	} else {
	  preg_match($regexpCatalog1, $response, $matchesLinks);
	  //print_r($matchesLinks);
	  preg_match_all($regexpCatalog2, $matchesLinks[1], $matches, PREG_SET_ORDER);
	  //print_r($matches);
	  if ($matches) {
		  foreach ($matches as $key) {
				if (@$qOfPagesArray['http://'.$domain.'e96.ru'.trim($key[1])] < preg_replace('~[^\d]+~', '' , $key[2])) {
					$qOfPagesArray['http://'.$domain.'e96.ru'.trim($key[1])] = preg_replace('~[^\d]+~', '' , $key[2]);	
					AngryCurl::add_debug_msg('http://'.$domain.'e96.ru'.trim($key[1]).' - '.preg_replace('~[^\d]+~', '' , $key[2]));
				}
		  }
	  }
	}
	unlink('/var/www/engines/e96.ru/cookies/'.$domain.'_'.$request->id[1].'.txt');
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;
	global $region;
	global $domain;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg($request->id[0]);
	AngryCurl::add_debug_msg($request->id[1]);
	AngryCurl::add_debug_msg($request->id[2]);
	AngryCurl::add_debug_msg($request->options[10018]);

	$cmd = 'timeout -k 15s 20s /var/www/lib/phantomjs/bin/phantomjs --ignore-ssl-errors=true --cookies-file=/var/www/engines/e96.ru/cookies/'.$domain.'_'.$request->id[1].'.txt --proxy='.$request->id[1].' --proxy-auth='.$request->id[2].' /var/www/engines/e96.ru/run.js '.escapeshellarg($request->id[0]).' '.escapeshellarg($request->options[10018]);
	$phantomjs = exec("$cmd", $out, $err);  
	print_r($err);   
	$response = stripcslashes($phantomjs);
	//echo $response;
	//file_put_contents('/var/www/engines/e96.ru/content.txt', $response);
	preg_match($regexpRegion, $response, $matches_region);
	AngryCurl::add_debug_msg('Регион - '.$matches_region[1]);
	if ($response === '408' || strlen($response) < 1000 || trim($matches_region[1]) != $region) {
		if (strripos($request->id[0], 'http://') !== false) {
			$bad_urls[] = $request->id[0];
			AngryCurl::add_debug_msg('bad url: '.$request->id[0]);
		}
	} else {
		preg_match_all($regexpPrices1, $response, $matches2, PREG_SET_ORDER);
		print_r($matches2);
		foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			print_r($matches);
			if (@$matches[1] && @$matches[2]) {
				price_change_detect('http://'.$domain.'e96.ru'.trim($matches[1]), trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->id[1], $request->id[2], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://'.$domain.'e96.ru'.trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->id[1]);
			} else {					
				preg_match($regexpPrices3, $key[1], $matches);
				if (@$matches[1] && @$matches[2]) {
					price_change_detect('http://'.$domain.'e96.ru'.trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->id[1], $request->id[2], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://'.$domain.'e96.ru'.trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->id[1]);
				} 
			}	
	  }
	}
  unlink('/var/www/engines/e96.ru/cookies/'.$domain.'_'.$request->id[1].'.txt');
}
