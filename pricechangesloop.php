<?php
/**
 * Собирает переоценки в общий файл и отсылает службе поддержки
 */
$cur_date = date('d.m.y');
$reportsArray = glob('/var/www/'.$argv[1].'/engines/*/data/*'.$cur_date.'*.data');
$pricechangestemp = glob('/var/www/'.$argv[1].'/log/'.$cur_date.'/*.data');

foreach ($pricechangestemp as $key) { 
	$temp = str_replace('/var/www/'.$argv[1].'/log/'.$cur_date.'/', '', $key);
	$temp = substr($temp, stripos($temp, '_')+1);
	$pricechanges[] = str_replace('.data', '', $temp);
}
$message = '<table>';
foreach ($reportsArray as $pckey) {
	$pckeyarr = unserialize(file_get_contents($pckey));
	$tempDate = date("H:i:s d.m.y", filemtime($pckey));
	print_r($pckeyarr);
	$message.="<tr><td colspan=8><h2>{$_GET['site']}&emsp;-&emsp;$tempDate</h2></td><tr>";
	foreach ($pckeyarr as $key => $value) {
		if (strripos($value[0], $argv[1]) !== false) {
			if ($value[5] == '-') {
				$color = 'color:red';
			} else {
				$color = '';
			}
			
			$message .= '<tr>
				<td style="border: 1px solid #ddd;'.$color.'"><a href="'.$key.'" target="_blank">'.$value[0].'</a></td>
				<td style="border: 1px solid #ddd;'.$color.'"><b>'.$value[1].'</b></td>
				<td style="border: 1px solid #ddd;'.$color.'"><small>'.$value[2].'</small></td>
				<td style="border: 1px solid #ddd;'.$color.'"><b>'.$value[3].'</b></td>
				<td style="border: 1px solid #ddd;'.$color.'"><small>'.$value[4].'</small></td>
				<td style="border: 1px solid #ddd;'.$color.'">'.$value[5].'</td>
				<td style="font-size:6px;border: 1px solid #ddd;'.$color.'">'.$value[6].'</td>
				<td style="font-size:6px;border: 1px solid #ddd;'.$color.'">'.$value[7].'</td>
				</tr>';
		}
	}
}
$message.='</table>';
file_put_contents('/var/www/temp/message.txt', $message);
