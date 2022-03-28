<?php
$res = file_get_contents('/var/www/polaris/engines/mvideo.ru/sourcehtml.txt');

preg_match_all("~product-title__text.*href=\"(.+)\"~isU", $res, $matches2, PREG_SET_ORDER);
print_r($matches2);

foreach ($matches2 as $key => $value) {
	$links[] = $value[1];
}

echo count($links).PHP_EOL;
$links = array_unique($links);
echo count($links).PHP_EOL;

foreach ($matches2 as $key => $value) {
	if (stripos($value[1], 'https://www.mvideo.ru') !== false) {
		$linkstext = $linkstext.$value[1].PHP_EOL;
	}
}

file_put_contents('/var/www/polaris/engines/mvideo.ru/links.txt', $linkstext);

