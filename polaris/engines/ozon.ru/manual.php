<?php
/**/
$agent_ozon = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/agent_ozon.txt'));
array_walk($agent_ozon, 'trim_value');
$agent_kontinent = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/agent_kontinent.txt'));
array_walk($agent_kontinent, 'trim_value');
//print_r($agent_ozon);
//print_r($agent_kontinent);

switch ($_GET['EP']) {
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

$reg1 = "~style=\"grid-column-start(.+)</div></div></div></div>~isU";
$reg2 = "~data-test-id=\"tile-price.*>(.+)<.*data-test-id=\"tile-name.*href=\"(.+)\".*>(.+)<~isU";

$reg3 = "~style=\"grid-column-start(.+)</div></div></div></div>~isU";
$reg4 = "~href=\"(.+)\".*data-test-id=\"tile-name\".*>(.+)<.*data-test-id=\"tile-price.*>(.+)<.*~isU";

$itemsArray = array();
$similaritems = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $reg1;
	global $reg2;

	global $reg3;
	global $reg4;

	global $agent_ozon;
	global $agent_kontinent;	

	global $similaritems;
	global $checkitems;

	global $itemsArray;
	global $city;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);	//die();

		if (strlen($response) > 500) {
			$response = htmlspecialchars_decode($response);
			$response = str_replace('\u002F', "/", $response);
			$response = str_replace('&quot;', '"', $response);

			//file_put_contents('/var/www/polaris/engines/ozon.ru/content.txt', $response);	//die();
			
			preg_match('~,"city":"(.+)"~isU', $response, $region);

			echo 'request  region: '.$city.PHP_EOL;
			echo 'response region: '.trim($region[1]).PHP_EOL;

			if (strripos(mb_strtolower(trim($region[1])), mb_strtolower($city)) === false) {
				echo 'Регион не совпадает!'.PHP_EOL;
				//sleep(5);
		  	//return 0;
			}

		  $count_all_items = 0;

			preg_match_all("~tile_builder.*isAdult.*\"link\":\"(.+)\?.*\"id\":(.+),.*\"title\":\"(.+)\".*availability\":(.+),\".*finalPrice\":(.+),.*marketplaceSellerId\":(.+),~isU", $response, $matches2, PREG_SET_ORDER);
			//print_r($matches2);
			foreach ($matches2 as $key => $matches) {

				$matches[6] = preg_replace('~[^\d.]+~', '' , $matches[6]);
				echo $matches[6].PHP_EOL;
				print_r($matches);

				if ($matches[4] == '1' && ($matches[6] == '0' || $matches[6] == '77899')) { // Товар в наличии && Выбираем товарную позицию, только если продавец ОЗОН (0) и ООО "Континент" (77899)
					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}
					$address = 'https://www.ozon.ru'.$matches[1];
							
					$name = strip_tags($matches[3]);
					$name = html_entity_decode(trim($name));
					$name = str_replace('",', '', $name);


					$price = 0;

					if ($matches[6] == '77899') {
						if (in_array(trim($matches[2]), $agent_kontinent)) {
							echo 'YES KONT'.PHP_EOL;
							//print_r($matches);
							$price = preg_replace('~[^\d.]+~', '' , $matches[5]);		
						} else {
							echo 'NO KONT'.PHP_EOL;
						}
					}

					if ($matches[6] == '0') {
						if (in_array(trim($matches[2]), $agent_ozon)) {
							echo 'YES OZON'.PHP_EOL;
							//print_r($matches);
							$price = preg_replace('~[^\d.]+~', '' , $matches[5]);		
						} else {
							echo 'NO OZON'.PHP_EOL;
						}
					}

					//$price = preg_replace('~[^\d.]+~', '' , $matches[5]);
					//$price = 0;		
							
					if (stripos($name, 'Кухонные весы Polaris PKS 0832DG Raspberry') === false && filter_var($address, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) && stripos($name, 'Уцененный товар') === false) { // Костыль, убирает завышенную цену
						if (@!$similaritems[$name] || @$similaritems[$name] > $price) {
							@price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
							@$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches[2], $request_url, $matches[6].' - '.$request_url);
							$similaritems[$name] = $price;
							$checkitems[$name][] = array($address, $price, $matches[6]);
							echo $address.' | '.$name.' | '.$price.PHP_EOL;
							$count_all_items++;
						}
					}
				} else { // Товар не в наличии
					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}
					$address = 'https://www.ozon.ru'.$matches[1];
							
					$name = strip_tags($matches[3]);
					$name = html_entity_decode(trim($name));
					$name = str_replace('",', '', $name);

					$price = 0;
					if (filter_var($address, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
						@price_change_detect($address, $name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
						@$itemsArray[$address] = array($name, $price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);
						@$checkitems[$name][] = array($address, $price, $matches[6]);
					}
				}
				
			}
			echo 'Позиций: '.$count_all_items.PHP_EOL;
			//file_put_contents('/var/www/polaris/engines/ozon.ru/checkarray.txt', print_r($checkitems, 1));
			//unlink($addr);
		

			return 1;
		}
}


