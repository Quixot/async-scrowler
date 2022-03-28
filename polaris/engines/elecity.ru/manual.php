<?php
switch (EXTRA_PARAM) {
 	case 'moscow': 
 		$city = 'Москва';
		$region = '';
 		break;
 	case 'spb': 
 		$city = 'Санкт-Петербург';
		$region = 'spb.';
 		break;
	case 'novgorod': 
		$city = 'Нижний Новгород';
		$region = 'nn.';
		break;
 	default:
 		die("Unknown region\n");  	 		
}

	//$itemsArray = array();

$itemsArray = unserialize(file_get_contents('/var/www/polaris/engines/elecity.ru/data/'.date("d.m.y") . '_elecity.ru_polaris_' . EXTRA_PARAM . '.data'));

	$regexpPrices = "~class=\"catalog_index_block_item(.+)class=\"catalog_item_button.*</div>~isU";
	$regexpPricesS2 = "~href=\".*href=\"(.+)\".*>(.+)<.*class=\"catalog_item_price\">(.+)<~isU";
	$regexpPricesS3 = "~href=\".*href=\"(.+)\".*>(.+)<~isU";

	$reg_region = "~data-target=\"#change_cur_region\">.*<span>(.+)<~isU";

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

function callback_two($response) {
  global $regexpPrices;
  global $regexpPricesS2;
  global $regexpPricesS3;

  global $qOfPaginationPages;
  global $city;
  global $itemsArray;
  global $region;
  global $bad_urls;
  global $time_start;
  global $reg_region;
  global $regionName;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
	//die();
	if ($response) {
		preg_match($reg_region, $response, $region_name);
		$region_name[1] = trim($region_name[1]);
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.$region_name[1].PHP_EOL;	

		if (stripos($region_name[1], $city) !== false) {

				preg_match($regexpP1, $response, $matches);
				//print_r($matches);
				preg_match_all($regexpP2, $matches[1], $matches2);
				//print_r($matches2);
				$temparrpage = array();
				foreach ($matches2[1] as $key => $value) {
					//echo "key: " . $key . "\n";
					echo "value:" . $value . "\n";
					if (is_numeric($value)) {
						$temparrpage[] = $value;
					}
				}

				if (@max($temparrpage) > $qOfPaginationPages) {
					$qOfPaginationPages = @max($temparrpage);	    	
				}

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[0], 'Купить') !== false) {
					preg_match($regexpPricesS2, $key[0], $matches);
					//print_r($matches);
					$matches[1] = 'https://'.$region.'elecity.ru'.trim($matches[1]);
		      $matches[2] = trim($matches[2]);
		      $matches[3] = str_replace('&#8381;', '', $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							$request->url
						);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]));
					}
	  		} else {
					preg_match($regexpPricesS3, $key[0], $matches);
					$matches[1] = 'https://'.$region.'elecity.ru'.trim($matches[1]);
		      $matches[2] = trim($matches[2]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							'0',
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							$request->url
						);		
						AngryCurl::add_debug_msg($matches[2].' | 0');
					}
	  		}
			}
	
			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
