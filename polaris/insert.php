<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$timer = microtime(1);
ini_set( 'display_errors', 1 );										// Display Errors
ini_set( 'error_reporting',2047 );								// Display All Errors
$mysqli = new mysqli('localhost', 'root', 'eldorado', 'storage'); // Trying to connect to the DB
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");

$brand = 'polaris';
$reportsArray = glob('/var/www/polaris/engines/*/data/*.data');
$data = '/var/www/polaris/engines/';

foreach ($reportsArray as $filepath) {
	if (/*strripos($filepath, '.17_') != false*/1==1) {
		preg_match_all("~data/(.+)_(.+)_(.+)_(.+).data~isU", $filepath, $matches, PREG_SET_ORDER);

		$date = $matches[0][1];
		$site = $matches[0][2];
		$brand = $matches[0][3];
		$city = $matches[0][4];

		//echo $filepath.'; ';
		$items = unserialize(file_get_contents($filepath));
		if ($items) {
			$sql = "INSERT INTO `heap` (`code`, `country`, `city`, `site`, `brand`, `url`, `name`, `price`, `time`, `proxy`, `session_id`, `session_time`) VALUES ";
			foreach ($items as $url => $info) {
				$info[0] = $mysqli->real_escape_string($info[0]);
				if (strlen($info[0]) < 500) {
					
					$info[1] = preg_replace('~[^\d]+~', '' ,$info[1]);
					if (!isset($info[1]) || $info[1] == '') {
						$info[1] = 0;
					}

					$timefile = filemtime($filepath);
					if (!isset($info[2])) {
						$info[2] = date("d.m.y-H:i:s", $timefile);
						//echo 'FILEDATE: '.$info[2].PHP_EOL;
					}
					if (!isset($info[3])) {
						$info[3] = '';
					}

					$sql .= " (";
					$sql .= "200, 'RU', '$city', '$site', '$brand', '$url', '$info[0]', $info[1], STR_TO_DATE('$info[2]', '%d.%m.%y-%H:%i:%s'), '$info[3]', 'obolon_".$site."_".$brand."_".$city."_".$timefile."_".rand(0, 100)."', FROM_UNIXTIME($timefile)";
					$sql .= "),";
				} else {
					echo 'Too large name'.PHP_EOL;
				}
			}
			$sql = substr($sql, 0, -1);
			//echo $filepath.PHP_EOL;
			//echo $sql.PHP_EOL;
			$ans = $mysqli->query($sql);
			//var_dump($ans);die();
			if (!$ans) {
				echo $filepath.PHP_EOL;
				//echo $sql.PHP_EOL;
				//print_r($info);
				file_put_contents('temp'.substr($filepath, strripos($filepath, '/')), $sql);
			}
		}
	}
}
/*
foreach ($items as $key => $value) {
	$one = $mysqli->real_escape_string($value[0]);
	$two = $mysqli->real_escape_string($value[1]);
	$three = $mysqli->real_escape_string($value[2]);
	$four = $mysqli->real_escape_string($value[3]);
	$data .= "('$key','$one','$two','$three','$four'),";
}
*/
//$maxp = $mysqli->query( 'SELECT @@global.max_allowed_packet' )->fetch_array();
//$maxp = $mysqli->query( 'SELECT @@global.max_allowed_packet' )->fetch_array();
//$mysqli->query( 'SET @@global.bulk_insert_buffer_size=512*1024*1024' );
//$mysqli->query( 'SET @@global.max_allowed_packet=512*1024*1024' );
//echo $maxp[ 0 ]."\n";
echo microtime(1)-$timer."\n";
