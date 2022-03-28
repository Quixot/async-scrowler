<?php
/**
 * ozon.ru
 */
//$filename = '/var/www/engines/ozon.ru/'.ENGINE_TYPE.'.txt';
//$handle   = fopen($filename, 'w'); // CSV file

switch (ENGINE_TYPE) {
	case 'vitek':
		$links = array(
			'http://static.ozone.ru/multimedia/yml/facet/div_appliance.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_beauty.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_tech.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_home.xml',
			);
		break;
	case 'maxwell':
		$links = array(
			'http://static.ozone.ru/multimedia/yml/facet/div_appliance.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_beauty.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_tech.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_home.xml',
			);
		break;
	case 'rondell':
		$links = array(
			'http://static.ozone.ru/multimedia/yml/facet/div_appliance.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_home.xml',
			'http://static.ozone.ru/multimedia/yml/facet/div_tech.xml',
			);
		break;
	default:
		break;
}

$directlinksarray = parse_ozon_xml($links);
echo count($directlinksarray).PHP_EOL;

$regName 	= "~\"prodName\":\"(.+)\",\"~isU";
$regPrice = "~class=\"bSale_BasePriceCover\">(.+)<~isU";
$regAvail = "~\"itemAvailability\":\"(.+)\"~isU";

$directlinks = file_get_contents('/var/www/engines/'.ENGINE_CURR.'/'.ENGINE_TYPE.'.txt');
echo $directlinks;
$directlinks = explode("\n", $directlinks);
//print_r($directlinks);die();
$directlinksarray = array_merge($directlinks, $directlinksarray);
$directlinksarray = array_unique($directlinksarray);
echo count($directlinksarray).PHP_EOL;

	foreach ($directlinksarray as $key => $value) {
	  $AC->get($value);
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->get($urls);       
	  }
	  unset($urls);

	  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}	
	unset($urls);



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regName;
	global $regPrice;
	global $regAvail;
	global $regexpPrices;
  global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    if (strripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 600) { $bad_urls = array(); }      
  } else {	  
	  if (strripos($info['url'], '?from=prt_xml_facet') === false) {
	  	$info['url'] = $info['url'] . '?from=prt_xml_facet';
	  }
		preg_match($regAvail, $response, $mAvail);
		preg_match($regName, $response, $mName);
		preg_match($regPrice, $response, $mPrice);
		//echo $mAvail[1] . "\n";
		////echo $mName[1]  . "\n";
		////echo $mPrice[1] . "\n";
    
    if ($mPrice[1] && $mName[1]) {
	    if ($mAvail[1] == 'OnStock') {
	    	if (strripos($mPrice[1], ',') !== false) {
	    	  $mPrice[1] = substr($mPrice[1], 0, strripos($mPrice[1], ','));
	    	}
	    	price_change_detect($info['url'], trim(iconv('windows-1251', 'utf-8', $mName[1])), preg_replace('~[\D]+~', '' , $mPrice[1]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$info['url']] = array(trim(iconv('windows-1251', 'utf-8', $mName[1])), preg_replace('~[\D]+~', '' , $mPrice[1]), date("d.m.y-H:i:s"), $request->options[10004]);
	      AngryCurl::add_debug_msg(iconv('windows-1251', 'utf-8', trim($mName[1])).' | '.$mPrice[1]);
	    } else {
	    	price_change_detect($info['url'], trim(iconv('windows-1251', 'utf-8', $mName[1])), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$info['url']] = array(trim(iconv('windows-1251', 'utf-8', $mName[1])), '0', date("d.m.y-H:i:s"), $request->options[10004]);
	      AngryCurl::add_debug_msg(iconv('windows-1251', 'utf-8', trim($mName[1])).' | 0');
	    }
    }
  }
}

  /**
   * This class create an object
   * which show is this script already running
   */
  class Thread {
    function RegisterPID($pidFile) {
      if ($fp = fopen($pidFile, 'w')) {
        fwrite($fp, getmypid());
        fclose($fp);
        @chmod($pidFile, 0777); // In case multiusers situation in future
        return true;
      }
      return false;
    }

    function CheckPIDExistance($pidFile) {
      if ($PID = @file_get_contents($pidFile)) {
        if (posix_kill($PID, 0))
          return true;
      }
      return false;
    }

    function KillPid($pidFile) {
      if ($PID = @file_get_contents($PIDFile))
        if (posix_kill($PID, 0))
          exec("kill -9 {$PID}");
    }
  }

function parse_ozon_xml($files) {
/**
 * The Core Function
 */  
    //global $handle;
    $items = array();
    
    $data = '';
    
    foreach ($files as $file) {
	    $fp = fopen($file, "r"); // XML file
	    //setlocale(LC_ALL, "ru_RU.CP1251");
	    $iCounter = 0;
	    while (!feof ($fp) and $fp) {
	        $simbol = fgetc($fp);        
	        $data .= $simbol;                

	        if ( $simbol != '>'            )  { continue; } // if it's the end of the tag, next step
	        if ( !strpos($data,"offer id") )  { continue; } // if it's offer tag continuing assembling simbols
	        if ( !strpos($data,"/offer>")  )  { continue; } // Do, till close offer tag        
	        // Cut offer part, but only if current book is available
	        preg_match("/<offer.*>(.*)<\/offer>/isU", $data, $matches);  
	        preg_match("/<name>(.*)<\/name>/isU", $data, $matchesName);      
	        // CORE LOOP                
	        if (strripos($matches[0], ENGINE_TYPE) !== false) 
	        {            
	        $tempString = "";

	        preg_match("/<url>(.+)<\/url>/isU", $data, $matches_name);        
	        $tempString = $tempString . $matches_name[1];
	        echo $matches_name[1] . "\n";

	        // Writing New String
	        $items[] = $tempString;
	        //fputs($handle, $tempString);
	        //fputs($handle, "\n");
	        }
	        // Clear data
	        $data = '';
	        unset($simbol, $tempString, $matches, $matches_name, $matches_names, $matches_isbn, $matches_sound, $register, $categories, $count, $i);
	    }
	    //fclose($fp);
    }
    fclose($handle);

    return $items;
}
