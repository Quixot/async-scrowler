<?php
/**
 * dns-shop.ru
 */
$bad_urls = array();
switch (EXTRA_PARAM) { 	
	case	'abakan': $region = 'Абакан'; break;
	case	'almetevsk': $region = 'Альметьевск'; break;
	case	'anapa': $region = 'Анапа'; break;
	case	'angarsk': $region = 'Ангарск'; break;
	case	'apatity': $region = 'Апатиты'; break;
	case	'arzamas': $region = 'Арзамас'; break;
	case	'armavir': $region = 'Армавир'; break;
	case	'arhangelsk': $region = 'Архангельск'; break;
	case	'astrakhan': $region = 'Астрахань'; break;
	case	'achinsk': $region = 'Ачинск'; break;
	case	'balakovo': $region = 'Балаково'; break;
	case	'barnaul': $region = 'Барнаул'; break;
	case	'belgorod': $region = 'Белгород'; break;
	case	'berezniki': $region = 'Березники'; break;
	case	'biysk': $region = 'Бийск'; break;
	case	'blagoveschensk': $region = 'Благовещенск'; break;
	case	'borisoglebsk': $region = 'Борисоглебск'; break;
	case	'bratsk': $region = 'Братск'; break;
	case	'bryansk': $region = 'Брянск'; break;
	case	'velikijnovgorod': $region = 'Великий Новгород'; break;
	case	'vladivostok': $region = 'Владивосток'; break;
	case	'vladikavkaz': $region = 'Владикавказ'; break;
	case	'vladimir': $region = 'Владимир'; break;
	case	'volgograd': $region = 'Волгоград'; break;
	case	'volgodonsk': $region = 'Волгодонск'; break;
	case	'volzhskij': $region = 'Волжский'; break;
	case	'vologda': $region = 'Вологда'; break;
	case	'voronezh': $region = 'Воронеж'; break;
	case	'gubkin': $region = 'Губкин'; break;
	case	'dimitrovgrad': $region = 'Димитровград'; break;
	case	'yekaterinburg': $region = 'Екатеринбург'; break;
	case	'essentuki': $region = 'Ессентуки'; break;
	case	'zheleznogorsk': $region = 'Железногорск'; break;
	case	'ivanovo': $region = 'Иваново'; break;
	case	'izhevsk': $region = 'Ижевск'; break;
	case	'irkutsk': $region = 'Иркутск'; break;
	case	'joshkar-ola': $region = 'Йошкар-Ола'; break;
	case	'kazan': $region = 'Казань'; break;
	case	'kaliningrad': $region = 'Калининград'; break;
	case	'kaluga': $region = 'Калуга'; break;
	case	'kamyshin': $region = 'Камышин'; break;
	case	'kasimov': $region = 'Касимов'; break;
	case	'kemerovo': $region = 'Кемерово'; break;
	case	'kirov': $region = 'Киров'; break;
	case	'kislovodsk': $region = 'Кисловодск'; break;
	case	'kostroma': $region = 'Кострома'; break;
	case	'krasnodar': $region = 'Краснодар'; break;
	case	'krasnoturinsk': $region = 'Краснотурьинск'; break;
	case	'krasnoyarsk': $region = 'Красноярск'; break;
	case	'kropotkin': $region = 'Кропоткин'; break;
	case	'kurgan': $region = 'Курган'; break;
	case	'kursk': $region = 'Курск'; break;
	case	'lipeck': $region = 'Липецк'; break;
	case	'lyantor': $region = 'Лянтор'; break;
	case	'magnitogorsk': $region = 'Магнитогорск'; break;
	case	'majkop': $region = 'Майкоп'; break;
	case	'miass': $region = 'Миасс'; break;
	case	'mineralnye-vody': $region = 'Минеральные Воды'; break;
	case	'moscow': $region = 'Москва'; break;
	case	'murmansk': $region = 'Мурманск'; break;
	case	'naberezhnye-chelny': $region = 'Набережные Челны'; break;
	case	'nadym': $region = 'Надым'; break;
	case	'nalchik': $region = 'Нальчик'; break;
	case	'nevinnomyssk': $region = 'Невинномысск'; break;
	case	'neftekamsk': $region = 'Нефтекамск'; break;
	case	'nefteyugansk': $region = 'Нефтеюганск'; break;
	case	'nizhnevartovsk': $region = 'Нижневартовск'; break;
	case	'nizhnekamsk': $region = 'Нижнекамск'; break;
	case	'novgorod': $region = 'Нижний Новгород'; break;
	case	'nizhnij-tagil': $region = 'Нижний Тагил'; break;
	case	'novokuzneck': $region = 'Новокузнецк'; break;
	case	'novorossijsk': $region = 'Новороссийск'; break;
	case	'novosibirsk': $region = 'Новосибирск'; break;
	case	'novotroick': $region = 'Новотроицк'; break;
	case	'novocherkassk': $region = 'Новочеркасск'; break;
	case	'novyj-urengoj': $region = 'Новый Уренгой'; break;
	case	'noyabrsk': $region = 'Ноябрьск'; break;
	case	'nyagan': $region = 'Нягань'; break;
	case	'obninsk': $region = 'Обнинск'; break;
	case	'oktyabrskij': $region = 'Октябрьский'; break;
	case	'omsk': $region = 'Омск'; break;
	case	'orel': $region = 'Орел'; break;
	case	'orenburg': $region = 'Оренбург'; break;
	case	'pavlovo': $region = 'Павлово'; break;
	case	'penza': $region = 'Пенза'; break;
	case	'pervouralsk': $region = 'Первоуральск'; break;
	case	'perm': $region = 'Пермь'; break;
	case	'petrozavodsk': $region = 'Петрозаводск'; break;
	case	'pskov': $region = 'Псков'; break;
	case	'pyatigorsk': $region = 'Пятигорск'; break;
	case	'revda': $region = 'Ревда'; break;
	case	'rostov': $region = 'Ростов-на-Дону'; break;
	case	'rybinsk': $region = 'Рыбинск'; break;
	case	'ryazan': $region = 'Рязань'; break;
	case	'salavat': $region = 'Салават'; break;
	case	'samara': $region = 'Самара'; break;
	case	'spb': $region = 'Санкт-Петербург'; break;
	case	'saransk': $region = 'Саранск'; break;
	case	'saratov': $region = 'Саратов'; break;
	case	'sarov': $region = 'Саров'; break;
	case	'severodvinsk': $region = 'Северодвинск'; break;
	case	'seversk': $region = 'Северск'; break;
	case	'smolensk': $region = 'Смоленск'; break;
	case	'sochi': $region = 'Сочи'; break;
	case	'stavropol': $region = 'Ставрополь'; break;
	case	'staryj-oskol': $region = 'Старый Оскол'; break;
	case	'sterlitamak': $region = 'Стерлитамак'; break;
	case	'surgut': $region = 'Сургут'; break;
	case	'syzran': $region = 'Сызрань'; break;
	case	'syktyvkar': $region = 'Сыктывкар'; break;
	case	'taganrog': $region = 'Таганрог'; break;
	case	'tambov': $region = 'Тамбов'; break;
	case	'tver': $region = 'Тверь'; break;
	case	'tobolsk': $region = 'Тобольск'; break;
	case	'tolyatti': $region = 'Тольятти'; break;
	case	'tomsk': $region = 'Томск'; break;
	case	'tuapse': $region = 'Туапсе'; break;
	case	'tula': $region = 'Тула'; break;
	case	'tyumen': $region = 'Тюмень'; break;
	case	'ulan-udeh': $region = 'Улан-Удэ'; break;
	case	'ulyanovsk': $region = 'Ульяновск'; break;
	case	'ufa': $region = 'Уфа'; break;
	case	'uhta': $region = 'Ухта'; break;
	case	'usolie-sibirskoe': $region = 'Усолье-Сибирское'; break;
	case	'habarovsk': $region = 'Хабаровск'; break;
	case	'hanty-mansijsk': $region = 'Ханты-Мансийск'; break;
	case	'cheboksary': $region = 'Чебоксары'; break;
	case	'chelyabinsk': $region = 'Челябинск'; break;
	case	'cherepovec': $region = 'Череповец'; break;
	case	'cherkessk': $region = 'Черкесск'; break;
	case	'chita': $region = 'Чита'; break;
	case	'shahty': $region = 'Шахты'; break;
	case	'ehngels': $region = 'Энгельс'; break;
	case	'yugorsk': $region = 'Югорск'; break;
	case	'yakutsk': $region = 'Якутск'; break;
	case	'yaroslavl': $region = 'Ярославль'; break;
 	default:
 		die("Unknown region\n");   	
}

$regexpPrices  = "~class=\"product\" data-id=(.+)btn btn-compare~isU";
$regexpPrices2 = "~data-product-param=\"name\".*href=\"(.+)\".*>(.+)<.*data-product-param=\"price\".*>(.+)<~isU";
$regexpRegion  = "~city-select w-choose-city-widget.*</i>(.+)<~isU"; // Регион

$i = 1;
while ( regular_one()<1 && $i<5 ) {
	$i++;
}


/** 
 *              Callback Functions           
 */
function regular_one() {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpRegion;
	global $region;
	global $itemsArray;
	global $bad_urls;

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
	$cmd = 'timeout -k 115s 120s casperjs /var/www/engines/dns-shop.ru/casper.js '.escapeshellarg(ENGINE_TYPE).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.escapeshellarg($region);
	echo 'request: '.$cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);

	//file_put_contents('/var/www/engines/dns-shop.ru/content.txt', $response);

	if ($response) {
		echo 'response ok'.PHP_EOL;

  	preg_match($regexpRegion, $response, $mregion);
  	echo $mregion[1].PHP_EOL;		

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  //print_r($matches2);
		foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			//print_r($matches);
			if (strripos($key[1], 'class="mail"') !== false) {
				$matches[3] = 0;
			}

			$matches[1] = 'http://'.ENGINE_CURR.trim($matches[1]);
			$matches = clean_info($matches, array(1,2,3));
			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
