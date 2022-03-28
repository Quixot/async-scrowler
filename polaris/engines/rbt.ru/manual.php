<?php
switch ($_GET['EP']) {
	case 'moscow': $region = '1';					$domain = 'msk.'; 		break;	//	Москва
	case 'abakan': $region = '1'; 				$domain = 'www.'; 	break;	//	Абакан
	case 'achinsk': $region = '2'; 				$domain = 'www.'; 	break;	//	Ачинск
	case 'barnaul': $region = '67'; 			$domain = 'www.'; 	break;	//	Барнаул
	case 'biysk': $region = '108'; 				$domain = 'www.'; 	break;	//	Бийск
	case 'yekaterinburg': $region = '3'; 	$domain = 'www.'; 	break;	//	Екатеринбург
	case 'kemerovo': $region = '109';			$domain = 'www.'; 	break;	//	Кемерово
	case 'krasnoyarsk': $region = '6'; 		$domain = 'kras.'; 	break;	//	Красноярск
	case 'kurgan': $region = '39'; 				$domain = 'www.'; 	break;	//	Курган
	case 'magnitogorsk': $region = '7'; 	$domain = 'www.'; 	break;	//	Магнитогорск
	case 'miass': $region = '8'; 					$domain = 'www.'; 	break;	//	Миасс
	case 'neftekamsk': $region = '103'; 	$domain = 'www.'; 	break;	//	Нефтекамск
	case 'nefteyugansk': $region = '44'; 	$domain = 'www.'; 	break;	//	Нефтеюганск
	case 'nizhnevartovsk': $region = '51';$domain = 'www.'; 	break;	//	Нижневартовск
	case 'novokuzneck': $region = '9'; 		$domain = 'www.'; 	break;	//	Новокузнецк
	case 'novosibirsk': $region = '10'; 	$domain = 'www.'; 	break;	//	Новосибирск
	case 'noyabrsk': $region = '17'; 			$domain = 'www.'; 	break;	//	Ноябрьск
	case 'omsk': $region = '11'; 					$domain = 'www.'; 	break;	//	Омск
	case 'orenburg': $region = '12'; 			$domain = 'www.'; 	break;	//	Оренбург
	case 'orsk': $region = '179'; 				$domain = 'www.'; 	break;	//	Орск
	case 'sterlitamak': $region = '213'; 	$domain = 'www.'; 	break;	//	Стерлитамак
	case 'surgut': $region = '13'; 				$domain = 'www.'; 	break;	//	Сургут
	case 'tobolsk': $region = '60'; 			$domain = 'www.'; 	break;	//	Тобольск
	case 'tomsk': $region = '224'; 				$domain = 'www.'; 	break;	//	Томск
	case 'kazan': $region = '14'; 				$domain = 'kazan.'; 	break;	//	Тюмень
	case 'ufa': $region = '16'; 					$domain = 'ufa.'; 	break;	//	Уфа
	case 'chelyabinsk': $region = '15'; 	$domain = 'www.'; 	break;	//	Челябинск
	case 'yugorsk': $region = '46'; 			$domain = 'www.'; 	break;	//	Югорск
	case 'vladivostok': $region = '46'; 	$domain = 'vladivostok.'; 	break;	//	Югорск
	case 'naberezhnye-chelny': 	 $region = '46';			$domain = 'naberezhnye-chelny.'; 	break;	//	Челябинск
 	default:
 		die("Unknown region\n"); 		
}

$reg1 = "~schema.org/Product(.+)itemprop=\"priceCurrency~isU";
$reg2 = "~itemprop=\"name\".*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";

	$itemsArray = array();
	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $reg1;
	global $reg2;
	global $itemsArray;
	//global $region;
	//global $pagin;
	global $domain;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {
		echo 'response ok'.PHP_EOL;

		//preg_match("~/region/regionSelectHtml/.*>.*>(.+)<~isU", $response, $region);
		//echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		//echo 'response region: '.$region[1].PHP_EOL;

	  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key => $value) {
			preg_match($reg2, $value[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2]) {
				$matches[1] = 'https://'.$domain.'rbt.ru'.trim($matches[1]);
				//$matches[3] = iconv('windows-1251', 'utf-8', $matches[3]);
				$matches[2] = strip_tags($matches[2]);
				$matches[2] = html_entity_decode(trim($matches[2]));
				$matches[3] = preg_replace('~[^\d.]+~', '' , $matches[3]);
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', '');
				echo $matches[1].' | '.$matches[2].' | '.$matches[3].PHP_EOL;
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
