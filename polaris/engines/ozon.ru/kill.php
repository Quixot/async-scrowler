<?php 
$response = file_get_contents('/var/www/engines/ozon.ru/content.txt');
$reg1 = "~bOneTile inline(.+)eOneTile_saleBlock~isU";
$reg2 = "~href=\"(.+)\".*eOzonPrice_main.*>(.+)<.*eOneTile_ItemName.*>(.+)</div>~isU";
		preg_match("~eCityCompleteSelector_button.*>(.+)<~isU", $response, $region);
		echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		echo 'response region: '.$region[1].PHP_EOL;

	  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key => $value) {
			preg_match($reg2, $value[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2]) {
				$matches[1] = 'http://www.ozon.ru'.trim($matches[1]);
				//$matches[3] = iconv('windows-1251', 'utf-8', $matches[3]);
				$matches[3] = strip_tags($matches[3]);
				$matches[3] = html_entity_decode(trim($matches[3]));
				$matches[2] = preg_replace('~[^\d.]+~', '' , $matches[2]);
				price_change_detect($matches[1], $matches[3], $matches[2], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[3], $matches[2], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
				echo $matches[3].' | '.$matches[2].PHP_EOL;
			}
		}
		var_dump($i);

 ?>