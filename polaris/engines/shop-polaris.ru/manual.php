<?php
switch ($_GET['EP']) {
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
    $regionName = '';
    break;
  case 'novosibirsk':
    $region = 'nsk.';
    $regionName = '';
    break;
  case 'vladivostok':
    $region = 'vladivostok.';
    $regionName = '';
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
    $region = '';
    $regionName = 'Нижний Новгород';  
    break;
  case 'ufa':
    $region = '';
    $regionName = 'Уфа';
    break;
  case 'krasnoyarsk':
    $region = '';
    $regionName = 'Красноярск';
    break;
  case 'kazan':
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

$regexpPrices1 = "~class=\"product__item(.+)class=\"deliver~isU";
$regexpPrices2 = "~class=\"h4\">.*href=\"(.+)\".*>(.+)<.*class=\"item__price w380\"><span>(.+)<~isU";
$regexpPrices3 = "~class=\"h4\">.*href=\"(.+)\".*>(.+)<.*class=\"new\">(.+)<~isU";
$regRegion = "~class=\"prog-cityName\">(.+)<~isU";

$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

function callback_two($response) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {
		echo 'response ok'.PHP_EOL;
  	preg_match($regRegion, $response, $mReg);
  	AngryCurl::add_debug_msg('Регион - '.trim($mReg[1]));

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			//if (strripos($key[1], $avail) === false) {
				if (strripos($key[1], 'class="new"') === false) { // Если обычная цена
					preg_match($regexpPrices2, $key[1], $matches2);
					//print_r($matches2);
					if ($matches2[1] && $matches2[2]) {
						price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
							trim($matches2[2]), 
							preg_replace('~[^\d]+~', '', $matches2[3]),
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);			
						AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
					}	
				} else { // Если перечеркнутая цена
					preg_match($regexpPrices3, $key[1], $matches2);
					//print_r($matches2);
					if ($matches2[1] && $matches2[2]) {
						price_change_detect('https://'.$region.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d]+~', '', $matches2[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https://'.$region.ENGINE_CURR.$matches2[1]] = array(
							trim($matches2[2]), 
							preg_replace('~[^\d]+~', '', $matches2[3]),
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);			
						AngryCurl::add_debug_msg(trim($matches2[2]).' | '.preg_replace('~[^\d]+~', '', $matches2[3]));
					}						
				}
			//}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
