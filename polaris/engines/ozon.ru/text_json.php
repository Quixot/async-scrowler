<?php 
$response = file_get_contents('/var/www/polaris/engines/ozon.ru/test_json.txt');
$agent_ozon = explode("\n", file_get_contents('/var/www/polaris/engines/ozon.ru/agent_ozon.txt'));
array_walk($agent_ozon, 'trim_value');
$agent_kontinent = explode("\n", file_get_contents('/var/www/polaris/engines/ozon.ru/agent_kontinent.txt'));
array_walk($agent_kontinent, 'trim_value');
print_r($agent_ozon);
print_r($agent_kontinent);


preg_match_all("~isAdult.*\"link\":\"(.+)?_bctx.*.*\"id\":(.+),.*\"title\":\"(.+)\".*availability\":(.+),\".*finalPrice\":(.+),.*marketplaceSellerId\":(.+),~isU", $response, $matches2, PREG_SET_ORDER);
print_r($matches2);
