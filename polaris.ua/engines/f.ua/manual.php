<?php
/**
 * f.ua
 */
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
	//$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response);


	function callback_two($response) {
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
	global $catalog;

	if ($response) {
		echo 'response ok'.PHP_EOL;


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
		echo 'The secret key is: '.$tempclass.PHP_EOL.PHP_EOL;
		//die();


		if ($tempclass) {
			preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
			//print_r($matches2);
			foreach ($matches2 as $key) {
				preg_match("~<div class=\"".$tempclass."\".*span.*>(.+)</.*class=\"title.*href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
				//print_r($matches);
				if (@$matches[1] && filter_var(trim($matches[2]), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
					$matches[2] = trim($matches[2]);
					$matches[3] = trim(strip_tags($matches[3]));
					$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);

					price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[2]] = array($matches[3], $matches[1], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
					AngryCurl::add_debug_msg($matches[2]." | ".$matches[3]." | ".$matches[1]);
				} else {
					preg_match("~class=\"title.*href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags($matches[2]));
					price_change_detect($matches[1], $matches[2], $matches[1], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
					AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | 0");
				}
			}	
		} else {
			preg_match_all("~class=\"catalog_item(.+)class=\"td_info\"~isU", $response, $matches2, PREG_SET_ORDER);
			//print_r($matches2);
			foreach ($matches2 as $key) {
				preg_match("~href=\"(.+)\".*>(.+)<.*class=\"price\">.*span.*>(.+)<~isU", $key[0], $matches);
				//print_r($matches);
				if (filter_var(trim($matches[1]), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) && $matches[2]) {
					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags($matches[2]));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
					AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | ".$matches[3]);
				} else {
					preg_match("~href=\"(.+)\".*>(.+)<~isU", $key[0], $matches);
					if ($matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
						AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | 0");
					}
				}
			}	
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}