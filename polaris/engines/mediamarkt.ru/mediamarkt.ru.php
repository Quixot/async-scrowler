<?php
/**
 * mediamarkt.ru
 */
switch (EXTRA_PARAM) {
	case 'moscow': $region_rus = 'Москва'; $url = 'https://www.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&location=shop_R002&q='; break;
  case 'arhangelsk': $region_rus = 'Архангельск';
  $url = 'https://arkhangelsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
  case 'astrakhan': $region_rus = 'Астрахань';
  $url = 'https://astrakhan.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
  case 'barnaul': $region_rus = 'Барнаул';
  $url = 'https://barnaul.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
  case 'belgorod': $region_rus = 'Белгород';
  $url = 'https://belgorod.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'bryansk': $region_rus = 'Брянск'; $url = 'https://bryansk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'cheboksary': $region_rus = 'Чебоксары'; $url = 'https://cheboksary.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'chelyabinsk': $region_rus = 'Челябинск'; $url = 'https://chelyabinsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'hanty-mansijsk': $region_rus = 'Ханты-Мансийск'; $url = 'https://khanty-mansijsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'ivanovo': $region_rus = 'Иваново'; $url = 'https://ivanovo.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'izhevsk': $region_rus = 'Ижевск'; $url = 'https://izhevsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'joshkar-ola': $region_rus = 'Йошкар-Ола'; $url = 'https://yoshkar-ola.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kaluga': $region_rus = 'Калуга'; $url = 'https://kaluga.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kazan': $region_rus = 'Казань'; $url = 'https://kazan.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kemerovo': $region_rus = 'Кемерово'; $url = 'https://kemerovo.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kirov': $region_rus = 'Киров'; $url = 'https://kirov.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kostroma': $region_rus = 'Кострома'; $url = 'https://kostroma.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'krasnodar': $region_rus = 'Краснодар'; $url = 'https://krasnodar.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'krasnoyarsk': $region_rus = 'Красноярск'; $url = 'https://krasnoyarsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'kursk': $region_rus = 'Курск'; $url = 'https://kursk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'lipeck': $region_rus = 'Липецк'; $url = 'https://lipetsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'mahachkala': $region_rus = 'Махачкала'; $url = 'https://makhachkala.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'murmansk': $region_rus = 'Мурманск'; $url = 'https://murmansk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'naberezhnye-chelny': $region_rus = 'Набережные Челны'; $url = 'https://naberezhnye-chelny.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'nalchik': $region_rus = 'Нальчик'; $url = 'https://nalchik.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'nefteyugansk': $region_rus = 'Нефтеюганск'; $url = 'https://nefteyugansk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;		
	case 'nizhnevartovsk': $region_rus = 'Нижневартовск'; $url = 'https://nizhnevartovsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'nizhnij-tagil': $region_rus = 'Нижний Тагил'; $url = 'https://nizhnij-tagil.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'novgorod': $region_rus = 'Нижний Новгород'; $url = 'https://nizhniy-novgorod.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'novokuzneck': $region_rus = 'Новокузнецк'; $url = 'https://novokuznetsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'novosibirsk': $region_rus = 'Новосибирск'; $url = 'https://novosibirsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'omsk': $region_rus = 'Омск'; $url = 'https://omsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'orel': $region_rus = 'Орёл'; $url = 'https://orel.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'orenburg': $region_rus = 'Оренбург'; $url = 'https://orenburg.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'penza': $region_rus = 'Пенза'; $url = 'https://penza.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'perm': $region_rus = 'Пермь'; $url = 'https://perm.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'petrozavodsk': $region_rus = 'Петрозаводск'; $url = 'https://petrozavodsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'pskov': $region_rus = 'Псков'; $url = 'https://pskov.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'pyatigorsk': $region_rus = 'Пятигорск'; $url = 'https://pyatigorsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'rostov': $region_rus = 'Ростов-на-Дону'; $url = 'https://rostov-na-donu.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'ryazan': $region_rus = 'Рязань'; $url = 'https://ryazan.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'samara': $region_rus = 'Самара'; $url = 'https://samara.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'saransk': $region_rus = 'Саранск'; $url = 'https://saransk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'saratov': $region_rus = 'Саратов'; $url = 'https://saratov.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'smolensk': $region_rus = 'Смоленск'; $url = 'https://smolensk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'sochi': $region_rus = 'Сочи'; $url = 'https://sochi.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'spb': $region_rus = 'Санкт-Петербург'; $url = 'https://sankt-peterburg.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'stavropol': $region_rus = 'Ставрополь'; $url = 'https://stavropol.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'surgut': $region_rus = 'Сургут'; $url = 'https://surgut.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'taganrog': $region_rus = 'Таганрог'; $url = 'https://taganrog.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tambov': $region_rus = 'Тамбов'; $url = 'https://tambov.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tolyatti': $region_rus = 'Тольятти'; $url = 'https://tolyatti.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tomsk': $region_rus = 'Томск'; $url = 'https://tomsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tula': $region_rus = 'Тула'; $url = 'https://tula.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tver': $region_rus = 'Тверь'; $url = 'https://tver.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'tyumen': $region_rus = 'Тюмень'; $url = 'https://tyumen.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'ufa': $region_rus = 'Уфа'; $url = 'https://ufa.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'ulyanovsk': $region_rus = 'Ульяновск'; $url = 'https://ulyanovsk.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'velikijnovgorod': $region_rus = 'Великий Новгород'; $url = 'https://novgorod.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'vladimir': $region_rus = 'Владимир'; $url = 'https://vladimir.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'volgograd': $region_rus = 'Волгоград'; $url = 'https://volgograd.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'vologda': $region_rus = 'Вологда'; $url = 'https://vologda.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'voronezh': $region_rus = 'Воронеж'; $url = 'https://voronezh.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'yaroslavl': $region_rus = 'Ярославль'; $url = 'https://yaroslavl.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
	case 'yekaterinburg': $region_rus = 'Екатеринбург'; $url = 'https://ekaterinburg.mediamarkt.ru/search?filters%5B%5D=s_instock&per_page=72&sort_order=desc&q='; break;
  default:
	die("Unknown region\n"); 		
}

$bad_urls = array();
$content = '';

$region = "~geolocation__city.*>(.+)<~isU";

$i = 1;
while ( regular_one($url.ENGINE_TYPE)<1 && $i<6 ) {
	$i++;
}

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


function regular_one($url) {
	global $content;
	global $argv;
	global $region_rus;
	global $region;
	global $region_id;
	global $itemsArray;
	global $kostil;

	$regexp3 = "~<li class=\"product__item(.+)class=\"compare__label~isU";
	$regexp4 = "~class=\"product__title.*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price.*span>(.+)</span~isU";
	$regexp5 = "~class=\"product__title.*<a.*href=\"(.+)\".*>.*>(.+)<~isU";	

	$proxy_array = glob('/var/www/lib/proxies/*.proxy');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);

	if (date('H') == '03' || date('H') == '05') { // Костыль, подставляем бесплатные прокси, чтобы обойти капчу
		$alive_proxy_list = file_get_contents('http://system.pricinglogix.com/reports/proxylist.txt');
	}

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

	// Если есть файл, собранный в ручном режиме, подставляем его
	if (file_exists('/home/xeon2/mediamarkt.ru/mediamarkt.ru_'.EXTRA_PARAM.'.txt') && time() - filemtime('/home/xeon2/mediamarkt.ru/mediamarkt.ru_'.EXTRA_PARAM.'.txt') < 18000) {
		$response = file_get_contents('/home/xeon2/mediamarkt.ru/mediamarkt.ru_'.EXTRA_PARAM.'.txt');
	} else {
		$cmd = 'timeout -k 55s 60s casperjs /var/www/polaris/engines/mediamarkt.ru/mediamarkt.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
		AngryCurl::add_debug_msg('request: '.$cmd);

		$response = exec($cmd, $out, $err);
		$response = stripcslashes($response);	
	}

	//file_put_contents('/var/www/engines/mediamarkt.ru/content.txt', $response);
	

	if ($response) {
		preg_match($region, $response, $m_region);
		AngryCurl::add_debug_msg('response ok');
		AngryCurl::add_debug_msg('request url: '.$region_rus);
		AngryCurl::add_debug_msg('response url: '.$m_region[1]);

		preg_match_all($regexp3, $response, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $key) {
			preg_match($regexp4, $key[1], $matches);
			if (@$matches[1] && strripos($matches[2], ENGINE_TYPE) !== false) {	
				price_change_detect('https://www.mediamarkt.ru' . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y H:i:s"), null, null, null, 'mediamarkt.ru', ENGINE_TYPE);
				$itemsArray['https://www.mediamarkt.ru' . trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y H:i:s"), ($matches_proxy[1].':'.$matches_proxy[2]), $useragent, $url);		
				AngryCurl::add_debug_msg(trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3]));
			} else {
				preg_match($regexp5, $key[1], $matches);
				if (@$matches[1] && strripos($matches[2], ENGINE_TYPE) !== false) {
					price_change_detect('https://www.mediamarkt.ru' . trim($matches[1]), trim($matches[2]), '0', date("d.m.y H:i:s"), null, null, null, 'mediamarkt.ru', ENGINE_TYPE);
					$itemsArray['https://www.mediamarkt.ru' . trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y H:i:s"), ($matches_proxy[1].':'.$matches_proxy[2]), $useragent, $url);		
					AngryCurl::add_debug_msg(trim($matches[2]).' | 0');
				}
			}
		}		
 
		return 1;		
	} else {
	  //mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  AngryCurl::add_debug_msg('bad response');
	  return 0;	
	}
}