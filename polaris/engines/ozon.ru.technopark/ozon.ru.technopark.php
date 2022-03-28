<?php
setlocale(LC_ALL, 'ru_RU.UTF-8');
unset($AC);

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
	case 'yekaterinburg': $city = 'Екатеринбург'; $preset_city = 'Екатеринбург, Свердловская область'; break;
	case 'essentuki': $city = 'Ессентуки'; break;
	case 'zheleznogorsk': $city = 'Железногорск'; break;
	case 'ivanovo': $city = 'Иваново'; break;
	case 'izhevsk': $city = 'Ижевск'; break;
	case 'irkutsk': $city = 'Иркутск'; break;
	case 'joshkar-ola': $city = 'Йошкар-Ола'; break;
	case 'kazan': $city = 'Казань'; $preset_city = 'Казань, Республика Татарстан'; break;
	case 'kaliningrad': $city = 'Калининград'; break;
	case 'kaluga': $city = 'Калуга'; break;
	case 'kamyshin': $city = 'Камышин'; break;
	case 'kasimov': $city = 'Касимов'; break;
	case 'kemerovo': $city = 'Кемерово'; break;
	case 'kirov': $city = 'Киров'; break;
	case 'kislovodsk': $city = 'Кисловодск'; break;
	case 'kostroma': $city = 'Кострома'; break;
	case 'krasnodar': $city = 'Краснодар'; $preset_city = 'Краснодар, Краснодарский Край'; break;
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
	case 'novgorod': $city = 'Нижний Новгород'; $preset_city = 'Нижний Новгород, Нижегородская область'; break;
	case 'nizhnij-tagil': $city = 'Нижний Тагил'; break;
	case 'novokuzneck': $city = 'Новокузнецк'; break;
	case 'novorossijsk': $city = 'Новороссийск'; break;
	case 'novosibirsk': $city = 'Новосибирск'; $preset_city = 'Новосибирск, Новосибирская область'; break;
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
	case 'perm': $city = 'Пермь'; $preset_city = 'Пермь, Пермский край'; break;
	case 'petrozavodsk': $city = 'Петрозаводск'; break;
	case 'pskov': $city = 'Псков'; break;
	case 'pyatigorsk': $city = 'Пятигорск'; break;
	case 'revda': $city = 'Ревда'; break;
	case 'rostov': $city = 'Ростов-на-Дону'; break;
	case 'rybinsk': $city = 'Рыбинск'; break;
	case 'ryazan': $city = 'Рязань'; break;
	case 'salavat': $city = 'Салават'; break;
	case 'samara': $city = 'Самара'; $preset_city = 'Самара, Самарская область'; break;
	case 'spb': $city = 'Санкт-Петербург'; $preset_city = 'Санкт-Петербург'; break;
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
	case 'chelyabinsk': $city = 'Челябинск'; $preset_city = 'Челябинск, Челябинская область'; break;
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

$reg1 = "~style=\"grid-column-start(.+)</div></div></div></div>~isU";
$reg2 = "~data-test-id=\"tile-price.*>(.+)<.*data-test-id=\"tile-name.*href=\"(.+)\".*>(.+)<~isU";

$reg3 = "~style=\"grid-column-start(.+)</div></div></div></div>~isU";
$reg4 = "~href=\"(.+)\".*data-test-id=\"tile-name\".*>(.+)<.*data-test-id=\"tile-price.*>(.+)<.*~isU";

//$agent_ozon = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/agent_ozon.txt'));
//array_walk($agent_ozon, 'trim_value');
//$agent_kontinent = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/agent_kontinent.txt'));
//array_walk($agent_kontinent, 'trim_value');
//print_r($agent_ozon);
//print_r($agent_kontinent);



if (ENGINE_LOOP == 13) {
	$regions = array('cheboksary', 'chelyabinsk', 'habarovsk', 'kazan', 'krasnodar', 'krasnoyarsk', 'moscow', 'naberezhnye-chelny', 'novgorod', 'novosibirsk', 'omsk', 'rostov', 'spb', 'samara', 'ufa', 'volgograd', 'vladivostok', 'yekaterinburg');

	foreach ($regions as $region) {
		$content_file_path = '/var/www/polaris/engines/ozon.ru/content/'.$region.'.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 3600) {

			$itemsArray = array();
			$similaritems = array();
			$checkitems = array();
			$bad_urls = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			$AC->add_debug_msg("Trying parse $content_file_path");

			callback_three($response, $region);

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
		} else {
			AngryCurl::add_debug_msg('Старый файл: '.$content_file_path);
		}
	}
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

} else {
	regular_windows();
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';	
	file_put_contents('/var/www/polaris/engines/ozon.ru/data_all/'.time().'_'.ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM.'.data', serialize($itemsArray));
	//echo unlink($cookfilepath);
}


function callback_three($response, $region) {
	global $reg1;
	global $reg2;

	global $agent_ozon;
	global $agent_kontinent;

	global $reg3;
	global $reg4;

	global $similaritems;
	global $checkitems;

	global $itemsArray;
	global $city;
	global $preset_city;
	global $cookfilepath;

	global $region;

	$regexpPrices  	 = "~data-id=\"product\" class=\"catalog-product(.+)ui-link_pseudolink~isU";
	$regexpPrices2 = "~href=\"(.+)\".*alt=\"(.+)\".*class=\"product-buy__price\">(.+)<~isU";	
	$regexpPrices3 = "~href=\"(.+)\".*alt=\"(.+)\".*product-buy__price_active\">(.+)<~isU";	

	if ($response) {
		/*
		preg_match('~,"city":"(.+)"~isU', $response, $what_region);
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.trim($what_region[1]).PHP_EOL;
 		*/
 		$response = htmlspecialchars_decode($response);
		$response = str_replace('\u002F', "/", $response);
		$response = str_replace('\\', "", $response);

		preg_match_all('~"product","id":(.+),.*"title":"(.+)".*"availability":(.+),.*"finalPrice":(.+),.*"marketplaceSellerId":(.+),.*"link":"(.+)\?_bctx=~isU', $response, $matches2, PREG_SET_ORDER);

		$i = 0;
		foreach ($matches2 as $key => $matches) {
			if ($matches[3] == '1' && $matches[5] == '77899') {
				$matches[6] = trim($matches[6]);
				if (stripos($matches[6], '?') !== false) {
					$matches[6] = substr($matches[6], 0, stripos($matches[6], '?'));
				}
				$address = 'https://www.ozon.ru'.$matches[6];
						
				$name = strip_tags($matches[2]);
				$name = html_entity_decode(trim($name));
				$name = str_replace('",', '', $name);


				$price = preg_replace('~[^\d.]+~', '' , $matches[4]);	

				
				//$price = preg_replace('~[^\d.]+~', '' , $matches[4]);
				//$price = 0;		
						
				if (stripos($name, 'Кухонные весы Polaris PKS 0832DG Raspberry') === false && filter_var($address, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) && stripos($name, 'Уцененный товар') === false) { // Костыль, убирает завышенную цену
					if (@!$similaritems[$name] || @$similaritems[$name] > $price) {
						price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches[1], 'manual', $matches[5].' - '.'manual');
						$similaritems[$name] = $price;
						$checkitems[$name][] = array($address, $price, $matches[5]);
						AngryCurl::add_debug_msg($name.' | '.$price.' | '.$matches[5]); //$address.' | '.
						$count_all_items++;
					}
				}
			} else { // Товар не в наличии
				/*
				$matches[6] = trim($matches[6]);
				if (stripos($matches[6], '?') !== false) {
					$matches[6] = substr($matches[6], 0, stripos($matches[6], '?'));
				}
				$address = 'https://www.ozon.ru'.$matches[6];
						
				$name = strip_tags($matches[2]);
				$name = html_entity_decode(trim($name));
				$name = str_replace('",', '', $name);

				$price = 0;
				if (filter_var($address, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
					@price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), 'manual', $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
					@$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', 'manual');
					$checkitems[$name][] = array($address, $price, $matches[5]);
				}
				*/
			}
		}

		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));

		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
