<?php


$itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
$regexpPrices  = "~<article(.+)</article>~isU";
$regexpPrices2 = "~href=.*href=\"(.+)\".*>.*>(.+)<.*class=\"current-price h1\">(.+)</span~isU";
$regexpPrices3 = "~href=.*href=\"(.+)\".*>.*>(.+)<~isU";


//$itemsArray = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;

		  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);
	  	foreach ($matches2 as $key) {
	  		if ($key[1]) {
					preg_match($regexpPrices2, $key[1], $matches);
					//print_r($matches);
					$matches[2] = str_replace('&quot;', '', $matches[2]);
					if (@trim($matches[1]) AND @strripos($key[1], 'Купить') !== false) {
						price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual');
						echo trim($matches[1]).' | '.trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3])."\n";
					}	else {
						preg_match($regexpPrices3, $key[1], $matches);
						price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual');
						echo trim($matches[1]) . "\n";
					}
	  		} 							
			}
			return 1;
		}
}

include('/var/www/'.ENGINE_TYPE.'/footer.php');