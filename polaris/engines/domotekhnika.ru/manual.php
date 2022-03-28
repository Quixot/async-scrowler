<?php
switch (EXTRA_PARAM) {
	case 'blagoveschensk': $region = 'blagoveshhensk.'; break;
	case 'vladivostok': $region = 'vladivostok.'; $city = 'Владивосток'; break;
	case 'ulan-udeh': $region = 'ulan-ude.'; break;
	case 'habarovsk': $region = 'habarovsk.'; $city = 'Хабаровск'; break;
	case 'cheboksary': $region = 'cheboksary.'; $city = 'Чебоксары'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$regexp1 = "~ProductCard(.+)<!----></span></div></div> <!----></div></div></div>~isU";
$regexp1_null = "~ProductCard(.+)class=\"lh-1\"~isU";
$regexp2  = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price\".*>(.+)<~isU";
$regexp3  = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);


function callback_two($response) {
	global $regexp1;
	global $regexp1_null;
	global $regexp2;
	global $regexp3;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;
	global $city;

	if ($response) {
		echo 'response ok'.PHP_EOL;

   	preg_match("~pin-city-usage.*svg>(.+)<~isU", $response, $matchesRegion);
  	$matchesRegion[1] = trim($matchesRegion[1]);
  	AngryCurl::add_debug_msg($matchesRegion[1].' | '.$city);

  	if ($matchesRegion[1] == $city) {
	  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);
	  	if (!$matches2) {
	  		preg_match_all($regexp1_null, $response, $matches2, PREG_SET_ORDER);
	  		//print_r($matches2);
	  	}
	  	
		  foreach ($matches2 as $key) {  		
				preg_match($regexp2, $key[1], $matches);
				//print_r($matches);
				if (@$matches[1]) {
						$matches[1] = 'https://domotekhnika.ru'.strtok($matches[1], '?');
						$matches[2] = trim($matches[2]);
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						//$matches = clean_info($matches, array(1,2,3));
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							$request->url
						);			
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
				} else {
					preg_match($regexp3, $key[1], $matches);
					//print_r($matches);
						$matches[1] = 'https://domotekhnika.ru'.strtok($matches[1], '?');
						$matches[2] = trim($matches[2]);
						$matches[3] = '0';
						//$matches = clean_info($matches, array(1,2,3));
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							$request->url
						);			
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
				}
			}
		} else {
	    $bad_urls[] = $request->url;   
	    if (round(microtime(1) - $time_start, 0) >= 800) $bad_urls=array();  
			AngryCurl::add_debug_msg('Регион не совпадает');
		}	
   

	}

}	