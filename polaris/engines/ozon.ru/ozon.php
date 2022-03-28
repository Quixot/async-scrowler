<?php
/**
 * Парсер Ozon
 * http://static.ozone.ru/multimedia/yml/facet/div_tech.xml
 */

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

function parse_ozon_xml($file) {
/**
 * The Core Function
 */  
    global $handle;   
    global $argv; 

    $fp = fopen($file, "r"); // XML file
    $data = '';
    
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
        if (strripos($matches[0], $argv[1]) !== false) 
        {            
        // Replase 'strange' simbols
        //$data = str_replace ("&nbsp;", " ", $data);
        //$data = str_replace ("&amp;", "&", $data);
        //$data = str_replace ("&apos;", "'", $data);
        //$data = str_replace (";", ",", $data);
        $tempString = "";

        // Cut all tags we need, clean them and save to csv
        //1. URL
        preg_match("/<url>(.+)<\/url>/isU", $data, $matches_name);        
        $tempString = $tempString . $matches_name[1];
        echo $matches_name[1] . "\n";
        //6. Name
        /*
        preg_match("/<name>(.+)<\/name>/isU", $data, $matches_name);
        $tempString = $tempString . $matches_name[1] . ";"; 
        echo $matches_name[1] . "\n";       
        //2. Price
        preg_match("/<price>(.+)<\/price>/isU", $data, $matches_name);
        $tempString = $tempString . $matches_name[1] . ";";
        echo $matches_name[1] . "\n";
        */
        // Writing New String
        fputs($handle, $tempString);
        fputs($handle, "\n");
        }
        // Clear data
        $data = '';
        unset($simbol, $tempString, $matches, $matches_name, $matches_names, $matches_isbn, $matches_sound, $register, $categories, $count, $i);
    }
    fclose($fp);
    fclose($handle);
}

/* Script time executing
------------------------------------------------------- -------------------------------------- */
$start_time = microtime(true);

/* Check is script already running
--------------------------------------------------------------------------------------------- */
$thread = new Thread();
if ($thread->CheckPIDExistance('/var/www/vitek/'.PID_FILE)) {
  die("ERROR: Only one copy of the script could be executed at the same time\n");
}
if (!$thread->RegisterPID('/var/www/vitek/'.PID_FILE)) {
  die("ERROR: Cannot register script's PID\n");
}

/* Create CSV file
--------------------------------------------------------------------------------------------- */
//header("Content-Type: text/html;charset=windows-1251");
$filename = '/var/www/engines/ozon.ru/'.$argv[1].'.txt';
$handle   = fopen($filename, 'w'); // CSV file

/* CORE FUNCTION
--------------------------------------------------------------------------------------------- */
parse_ozon_xml('http://static.ozone.ru/multimedia/yml/facet/div_appliance.xml');

echo $exec_time = microtime(true) - $start_time; // Script time executing
