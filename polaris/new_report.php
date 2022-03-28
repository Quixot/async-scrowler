<?php
/**
 * Новый отчёт для Polaris
 */



foreach(glob('you_dir/*', GLOB_ONLYDIR) as $mydir) 
{
    if (preg_match('/20161110|20161111/i', $mydir)) {
    $array_dirs[] = $mydir;
    echo "<br> ";      
    echo $mydir;
}}

$arr = explode('.', '02.03.17');
//echo mktime(0, 0, 0, $month, $day, $year);
$time = mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
echo date('d.m.y', $time).PHP_EOL;

$data_array = glob('/var/www/polaris/engines/*/data/*.data');
$from_date = time() - 60 * 60 * 696;
$curr_date = time();

echo ($curr_date - $from_date).PHP_EOL;
die();

foreach ($data_array as $key) {
	preg_match('~.*data/(.+)_(.+)_(.+)_(.+).data~isU', $key, $matches);
	echo strtotime($matches[1]).PHP_EOL;
}

//$myarray = glob("*.*");
//usort($myarray, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

$items = glob('/var/www/polaris/engines/*/data/*.data', GLOB_NOSORT);
array_multisort(array_map('filemtime', $items), SORT_NUMERIC, SORT_DESC, $items);
print_r($items);
die();