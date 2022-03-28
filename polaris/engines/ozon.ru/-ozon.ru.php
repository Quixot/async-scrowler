<?php
/**
 * ozon.ru
 */
setlocale(LC_ALL, 'ru_RU.UTF-8');
unset($AC);
$bad_urls = array();
switch (EXTRA_PARAM) {
	case 'abakan': $city = 'Абакан'; break;
	case 'almetevsk': $city = 'Альметьевск'; break;
	case 'anapa': $city = 'Анапа'; break;
	case 'angarsk': $city = 'Ангарск'; break;
	case 'apatity': $city = 'Апатиты'; break;
	case 'arzamas': $city = 'Арзамас'; break;
	case 'armavir': $city = 'Армавир'; break;
	case 'arhangelsk': $city = 'Архангельск'; break;
	case 'astrakhan': $city = 'Астрахань'; break;
	case 'achinsk': $city = 'Ачинск'; break;
	case 'balakovo': $city = 'Балаково'; break;
	case 'barnaul': $city = 'Барнаул'; break;
	case 'belgorod': $city = 'Белгород'; break;
	case 'berezniki': $city = 'Березники'; break;
	case 'biysk': $city = 'Бийск'; break;
	case 'blagoveschensk': $city = 'Благовещенск'; break;
	case 'borisoglebsk': $city = 'Борисоглебск'; break;
	case 'bratsk': $city = 'Братск'; break;
	case 'bryansk': $city = 'Брянск'; break;
	case 'velikijnovgorod': $city = 'Великий Новгород'; break;
	case 'vladivostok': $city = 'Владивосток'; break;
	case 'vladikavkaz': $city = 'Владикавказ'; break;
	case 'vladimir': $city = 'Владимир'; break;
	case 'volgograd': $city = 'Волгоград'; break;
	case 'volgodonsk': $city = 'Волгодонск'; break;
	case 'volzhskij': $city = 'Волжский'; break;
	case 'vologda': $city = 'Вологда'; break;
	case 'voronezh': $city = 'Воронеж'; break;
	case 'gubkin': $city = 'Губкин'; break;
	case 'derbent': $city = 'Дербент'; break;
	case 'dimitrovgrad': $city = 'Димитровград'; break;
	case 'yekaterinburg': $city = 'Екатеринбург'; break;
	case 'essentuki': $city = 'Ессентуки'; break;
	case 'zheleznogorsk': $city = 'Железногорск'; break;
	case 'ivanovo': $city = 'Иваново'; break;
	case 'izhevsk': $city = 'Ижевск'; break;
	case 'irkutsk': $city = 'Иркутск'; break;
	case 'joshkar-ola': $city = 'Йошкар-Ола'; break;
	case 'kazan': $city = 'Казань'; break;
	case 'kaliningrad': $city = 'Калининград'; break;
	case 'kaluga': $city = 'Калуга'; break;
	case 'kamyshin': $city = 'Камышин'; break;
	case 'kasimov': $city = 'Касимов'; break;
	case 'kemerovo': $city = 'Кемерово'; break;
	case 'kirov': $city = 'Киров'; break;
	case 'kislovodsk': $city = 'Кисловодск'; break;
	case 'kostroma': $city = 'Кострома'; break;
	case 'krasnodar': $city = 'Краснодар'; break;
	case 'krasnoturinsk': $city = 'Краснотурьинск'; break;
	case 'krasnoyarsk': $city = 'Красноярск'; break;
	case 'kropotkin': $city = 'Кропоткин'; break;
	case 'kurgan': $city = 'Курган'; break;
	case 'kursk': $city = 'Курск'; break;
	case 'lipeck': $city = 'Липецк'; break;
	case 'lyantor': $city = 'Лянтор'; break;
	case 'magnitogorsk': $city = 'Магнитогорск'; break;
	case 'majkop': $city = 'Майкоп'; break;
	case 'mahachkala': $city = 'Махачкала'; break;
	case 'miass': $city = 'Миасс'; break;
	case 'mineralnye-vody': $city = 'Минеральные Воды'; break;
	case 'moscow': $city = 'Москва'; break;
	case 'murmansk': $city = 'Мурманск'; break;
	case 'naberezhnye-chelny': $city = 'Набережные Челны'; break;
	case 'nadym': $city = 'Надым'; break;
	case 'nalchik': $city = 'Нальчик'; break;
	case 'nevinnomyssk': $city = 'Невинномысск'; break;
	case 'neftekamsk': $city = 'Нефтекамск'; break;
	case 'nefteyugansk': $city = 'Нефтеюганск'; break;
	case 'nizhnevartovsk': $city = 'Нижневартовск'; break;
	case 'nizhnekamsk': $city = 'Нижнекамск'; break;
	case 'novgorod': $city = 'Нижний Новгород'; break;
	case 'nizhnij-tagil': $city = 'Нижний Тагил'; break;
	case 'novokuzneck': $city = 'Новокузнецк'; break;
	case 'novorossijsk': $city = 'Новороссийск'; break;
	case 'novosibirsk': $city = 'Новосибирск'; break;
	case 'novotroick': $city = 'Новотроицк'; break;
	case 'novocherkassk': $city = 'Новочеркасск'; break;
	case 'novyj-urengoj': $city = 'Новый Уренгой'; break;
	case 'noyabrsk': $city = 'Ноябрьск'; break;
	case 'nyagan': $city = 'Нягань'; break;
	case 'obninsk': $city = 'Обнинск'; break;
	case 'oktyabrskij': $city = 'Октябрьский'; break;
	case 'omsk': $city = 'Омск'; break;
	case 'orel': $city = 'Орел'; break;
	case 'orenburg': $city = 'Оренбург'; break;
	case 'orsk': $city = 'Орск'; break;
	case 'pavlovo': $city = 'Павлово'; break;
	case 'penza': $city = 'Пенза'; break;
	case 'pervouralsk': $city = 'Первоуральск'; break;
	case 'perm': $city = 'Пермь'; break;
	case 'petrozavodsk': $city = 'Петрозаводск'; break;
	case 'pskov': $city = 'Псков'; break;
	case 'pyatigorsk': $city = 'Пятигорск'; break;
	case 'revda': $city = 'Ревда'; break;
	case 'rostov': $city = 'Ростов-на-Дону'; break;
	case 'rybinsk': $city = 'Рыбинск'; break;
	case 'ryazan': $city = 'Рязань'; break;
	case 'salavat': $city = 'Салават'; break;
	case 'samara': $city = 'Самара'; break;
	case 'spb': $city = 'Санкт-Петербург'; break;
	case 'saransk': $city = 'Саранск'; break;
	case 'saratov': $city = 'Саратов'; break;
	case 'sarov': $city = 'Саров'; break;
	case 'severodvinsk': $city = 'Северодвинск'; break;
	case 'seversk': $city = 'Северск'; break;
	case 'smolensk': $city = 'Смоленск'; break;
	case 'solnechnogorsk': $city = 'Солнечногорск'; break;
	case 'sochi': $city = 'Сочи'; break;
	case 'stavropol': $city = 'Ставрополь'; break;
	case 'staryj-oskol': $city = 'Старый Оскол'; break;
	case 'sterlitamak': $city = 'Стерлитамак'; break;
	case 'stupino': $city = 'Ступино'; break;
	case 'surgut': $city = 'Сургут'; break;
	case 'syzran': $city = 'Сызрань'; break;
	case 'syktyvkar': $city = 'Сыктывкар'; break;
	case 'taganrog': $city = 'Таганрог'; break;
	case 'tambov': $city = 'Тамбов'; break;
	case 'tver': $city = 'Тверь'; break;
	case 'tobolsk': $city = 'Тобольск'; break;
	case 'tolyatti': $city = 'Тольятти'; break;
	case 'tomsk': $city = 'Томск'; break;
	case 'tuapse': $city = 'Туапсе'; break;
	case 'tula': $city = 'Тула'; break;
	case 'tyumen': $city = 'Тюмень'; break;
	case 'ulan-udeh': $city = 'Улан-Удэ'; break;
	case 'ulyanovsk': $city = 'Ульяновск'; break;
	case 'usolie-sibirskoe': $city = 'Усолье-Сибирское'; break;
	case 'ufa': $city = 'Уфа'; break;
	case 'uhta': $city = 'Ухта'; break;
	case 'habarovsk': $city = 'Хабаровск'; break;
	case 'hanty-mansijsk': $city = 'Ханты-Мансийск'; break;
	case 'cheboksary': $city = 'Чебоксары'; break;
	case 'chelyabinsk': $city = 'Челябинск'; break;
	case 'cherepovec': $city = 'Череповец'; break;
	case 'cherkessk': $city = 'Черкесск'; break;
	case 'chita': $city = 'Чита'; break;
	case 'shahty': $city = 'Шахты'; break;
	case 'ehngels': $city = 'Энгельс'; break;
	case 'yugorsk': $city = 'Югорск'; break;
	case 'yakutsk': $city = 'Якутск'; break;
	case 'yaroslavl': $city = 'Ярославль'; break;
 	default:
 		die("Unknown region\n"); 		
}

$reg3 = "~class=\"item-view(.+)class=\"full-cover-link~isU";
$reg4 = "~class=\"main\">(.+)<.*href=\"(.+)\".*name-link\">(.+)<~isU";

$reg1 = "~class=\"bOneTile(.+)class=\"eIconButtonText\"~isU";
$reg2 = "~class=\"eOzonPrice_main\".*>(.+)<.*href=\"(.+)\".*ItemName\">(.+)<~isU";

$url = 'https://www.ozon.ru/brand/17476997/?page=';

for ($p=5; $p <= 5; $p++) { 
	$i = 1;
	while ( regular_one($url.$p)<1 && $i<5 ) {
		$i++;
	}
}


file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

function regular_one($url) {
	global $reg1;
	global $reg2;

	global $reg3;
	global $reg4;

	global $itemsArray;
	global $city;

	if (ENGINE_LOOP == 2) {
		$response = file_get_contents( '/var/www/polaris/engines/ozon.ru/source/'.EXTRA_PARAM.'.txt' );

		if ($response) {
			echo 'response ok'.PHP_EOL;

			preg_match("~class=\"city-name\".*>(.+)<~isU", $response, $region);
			echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
			echo 'response region: '.$region[1].PHP_EOL;

		  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
		  if (!$matches2) {
		  	preg_match_all($reg3, $response, $matches2, PREG_SET_ORDER);
		  }
		  //print_r($matches2);
		  foreach ($matches2 as $key => $value) {
				preg_match($reg2, $value[0], $matches);
				if (!$matches) {
					preg_match($reg4, $value[0], $matches);
				}
				//print_r($matches);
				if (@$matches[1] && $matches[2]) {
					$matches2[2] = trim($matches[2]);
					$matches2[2] = substr($matches2[2], 0, stripos($matches2[2], '?'));
					$address = 'http://www.ozon.ru'.$matches2[2];
					$name = strip_tags($matches[3]);
					$name = html_entity_decode(trim($name));
					$price = preg_replace('~[^\d.]+~', '' , $matches[1]);
					price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
					echo $name.' | '.$price.PHP_EOL;
				}
			}
			return 1;
		} else {
			echo 'bad response'.PHP_EOL;
			return 0;
		}

	} else {
		$proxy_array = glob('/var/www/lib/proxies/*.proxy');
		$alive_proxy_list = '';
		foreach ($proxy_array as $key) {
			$alive_proxy_list .= file_get_contents($key);
			$alive_proxy_list .= "\n";
		}
		$alive_proxy_list = trim($alive_proxy_list);
		$proxy_list 		= explode("\n", $alive_proxy_list);
		$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
		array_walk($proxy_list, 'trim_value');
		array_walk($useragent_list, 'trim_value');

		/**
		 * Блок выбора прокси
		 */
			$useragent_index = mt_rand(0, count($useragent_list)-1);
			$useragent = $useragent_list[$useragent_index];
		  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
		  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
		  if (!$matches_proxy) {
		   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
		  }
		/**
		 * Блок выбора прокси
		 */
		/*
		$url = 'http://www.ozon.ru/?context=search&text='.ENGINE_TYPE.'&store=1,0';
		$url = 'http://www.ozon.ru/?context=search&text='.ENGINE_TYPE.'&brand=17476997&store=1%2c0';
		$url = 'https://www.ozon.ru/brand/17476997/';
		*/
		$cmd = 'timeout -k 100s 101s casperjs /var/www/polaris/engines/ozon.ru/ozon.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '."'".$city."'";
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = stripcslashes($response);

		

		if ($response) {
			echo 'response ok'.PHP_EOL;


			preg_match("~eCityCompleteSelector_button.*>(.+)<~isU", $response, $region);
			echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
			echo 'response region: '.$region[1].PHP_EOL;



		  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
		  if (!$matches2) {
		  	preg_match_all($reg3, $response, $matches2, PREG_SET_ORDER);
		  	if (!$matches2) {
		  		return 0;
		  	}		  	
		  }

		  //print_r($matches2);
		  foreach ($matches2 as $key => $value) {
				preg_match($reg2, $value[0], $matches);
				//print_r($matches);
				if (!$matches) {
					preg_match($reg4, $value[0], $matches);
				}				
				if (@$matches[1] && $matches[2]) {
					$matches2[2] = trim($matches[2]);
					$matches2[2] = substr($matches2[2], 0, stripos($matches2[2], '?'));
					$address = 'http://www.ozon.ru'.$matches2[2];
					$name = strip_tags($matches[3]);
					$name = html_entity_decode(trim($name));
					$price = preg_replace('~[^\d.]+~', '' , $matches[1]);
					price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $url);
					echo $name.' | '.$price.PHP_EOL;
				}
			}
			echo 'Общее к-во: '.count($matches2).PHP_EOL;
			//file_put_contents('/var/www/polaris/engines/ozon.ru/content.txt', $response);die();
			return 1;
		} else {
			echo 'bad response'.PHP_EOL;
			return 0;
		}
	}
}
