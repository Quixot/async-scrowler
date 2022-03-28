<?php
/**/
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

$regexpP1 = "~class=\"pageToInsert\"(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1  = "~class=\"dtList(.+)block-dop-info~isU";
$regexp2  = "~href=\"(.+)\".*alt=\"(.+)\".*class=\"price\">.*class=.*>(.+)</~isU";
$regexpName = "~class=\"pp\">Модель:<span>(.+)<~isU";
$regexpName2 = "~class=\"article j-article\">(.+)<~isU";
$regexpRegion = "~class=\"set-city-ip\".*>(.+)<~isU";

$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $regexp1;
	global $regexp2;

	global $regexpName;
	global $regexpName2;

	global $itemsArray;
	global $city;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;
			/*
			preg_match('~"areaId":.*"name":"(.+)"~isU', $response, $region);
			preg_match('~button type="button" class.*</path>.*<span.*>(.+)<~isU', $response, $region);
			//print_r($region);

			
			echo 'request  region: '.$city.PHP_EOL;
			echo 'response region: '.trim($region[1]).PHP_EOL;

			if ($city == 'Владивосток') {
				//$city = 'Владивосток, Приморский Край';
			}
			if (stripos(trim($region[1]), $city) === false) {
				die('Неправильный регион!<br>');
			}
*/
	  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
	  	//print_r($matches2);
	  	foreach ($matches2 as $key) {  		
				preg_match($regexp2, $key[1], $matches);
				//print_r($matches);
				$matches[1] = trim($matches[1]);

				if (stripos($matches[1], 'http') === false) {
					$matches[1] = 'https://www.wildberries.ru'.trim($matches[1]);
				} else {
					$matches[1] = trim($matches[1]);
				}

				if (stripos($matches[1], '?') !== false) {
					$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
				}

				$matches[3] = html_entity_decode($matches[3]);
				$matches = clean_info($matches, array(1,2,3));

				preg_match("/[\d]+/", $matches[2], $matchd);
				if (@$matchd[0] <= 0) {
					$pos_without_name[$matches[1]] = 1;
				}

				if ($matches != false) {
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual');
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				} 							  		
			}
		  //file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		  file_put_contents('/var/www/polaris/engines/wildberries.ru/data_profile/'.date("d.m.y").'_wildberries.ru.profile_polaris_moscow.data', serialize($itemsArray));

			die();
			return 1;
		}
}