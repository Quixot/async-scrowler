<?php
$regexp = "~HREF=\"(.+)\".*>(.+)<~isU";

$subj = file_get_contents('content.txt');
preg_match_all($regexp, $subj, $matches, PREG_SET_ORDER);
$text = '';
foreach ($matches as $key => $value) {
	$text .= $value[1].PHP_EOL;
}
file_put_contents('links.txt', $text);
