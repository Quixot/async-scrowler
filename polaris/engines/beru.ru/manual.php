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
    $regionName = 'Ростов-на-Дону';
    break;
  case 'novosibirsk':
    $region = '';
    $regionName = 'Новосибирск';
    break;
  case 'vladivostok':
    $region = 'Владивосток';
    $regionName = 'Владивосток';
    break;
  case 'samara':
    $region = 'Самара';
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
 		//die("Unknown region\n"); 
}

//$itemsArray = array();

$regP = '~"found":{"filter-discount-only_0":(.+),~isU';

$regexpPrices1 = "~<div.*data-zone-name=\"snippet(.+)</button></div></div></div></div></div>~isU";
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*<span data-tid.*>(.+)</span>~isU";

$regRegion = '~"entity":"region","name":"(.+)"~isU';

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
  global $regionName;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {
  	preg_match($regRegion, $response, $mReg);
  	@AngryCurl::add_debug_msg('Регион - '.trim($mReg[1]));

  	if (1==1/*trim(@$mReg[1]) == $regionName*/) {

	  	preg_match("~window.mdaSettings = (.+)MIN_SPEED~isU", $response, $matches);
	  	//print_r($matches[1]);

	  	
	  	
	  	preg_match_all('~"marketSku":"(.+)".*"raw":"(.+)".*"slug":"(.+)".*supplierId":(.+),.*"currentPrice":{"value":(.+),.*availableCount":(.+),.*~isU', $matches[1], $mcode, PREG_SET_ORDER);
	  	//file_put_contents('/var/www/polaris/engines/beru.ru/json.txt', print_r($mcode, 1)); //"availableCount":  "marketSku":"(.+)".*

	  	

			foreach ($mcode as $key => $value) {
						
/*id:
431782 - Беру
431782 - Polaris
615118 - Торговый дом БК
596441 - Миксмаркет
610615 - Ноу-Хау - магазин мобильной электроники
*/

				if ($value[6] && $value[1] && $value[2] && $value[3] && $value[5]) {
					if (stripos(trim($value[4]), '572917') !== false || stripos(trim($value[4]), '465852') !== false) { // Только если Polaris
	
						$address = 'https://beru.ru/product/'.trim($value[3]).'/'.trim($value[1]);
						$name = trim($value[2]);
						$price = trim($value[5]);

						price_change_detect(
							$address, $name, $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE
						);
						$itemsArray[$address] = array(
							$name,  $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual'
						);			
						AngryCurl::add_debug_msg($address.' | '.$name.' | '.$price);
					}
				}
			}

		return 1;
		}
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
