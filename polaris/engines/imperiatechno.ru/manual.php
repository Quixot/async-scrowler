<?php
/**/
switch ($_GET['EP']) {
	case 'moscow': 	$city = 'Москва'; 				 break;
	case 'spb': 		$city = 'Санкт-Петербург'; break;
 	default:
 		die("Unknown region\n"); 		
}

$reg_region = "~name=\"cityId\".*selected=\"selected\">(.+)<~isU";

$regexpPrices = "~class=\"tmb-wrap\">(.+)</li>~isU";
$regexpPricesS2 = "~class=\"name.*href=\"(.+)\".*>(.+)</a.*class=\"cur\">(.+)<~isU";
$regexpPricesS4 = "~class=\"name.*href=\"(.+)\".*>(.+)</a.*class=\"new\">(.+)<~isU";
$regexpPricesS3 = "~class=\"name.*href=\"(.+)\".*>(.+)</a~isU";

$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
  global $regexpPrices;
  global $regexpPricesS2;
  global $regexpPricesS3;
  global $regexpPricesS4;

  global $reg_region;

	global $itemsArray;
	global $city;

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;
			preg_match($reg_region, $response, $region_name);
			echo 'request  region: '.$city.PHP_EOL;
			echo 'response region: '.$region_name[1].PHP_EOL;	

			if (stripos(trim($region_name[1]), $city) === false) {
				//die('Неправильный регион!<br>');
			}

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], 'Есть в наличии') !== false) {
					preg_match($regexpPricesS2, $key[1], $matches);
					if (!$matches) {
						preg_match($regexpPricesS4, $key[1], $matches);
					}
					//print_r($matches);
					$matches[1] = 'https://www.imperiatechno.ru'.trim($matches[1]);
		      $matches[2] = trim($matches[2]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]));
					}
	  		} else {
					preg_match($regexpPricesS3, $key[1], $matches);
					$matches[1] = 'https://www.imperiatechno.ru'.trim($matches[1]);
		      $matches[2] = trim($matches[2]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							'0',
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);		
						AngryCurl::add_debug_msg($matches[2].' | 0');
					}
	  		}
			}

			return 1;
		}
}