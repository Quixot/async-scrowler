<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title><?=$_GET['file']?> : PricingLogix</title> 
  </head>

  <body>
<h2><a href="<?='/?project='.$_GET['project'].'#'.$_GET['site']?>"><< Назад</a></h2>
<?php
/**
 * Переоценка!!!
 */
$reportsArray = glob('/var/www/'.$_GET['project'].'/log/'.date("d.m.y").'/*'.$_GET['site'].'*');
$message .= '<table cellspacing="0" cellpadding="5">';
foreach ($reportsArray as $pckey) {

	$pckeyarr = unserialize(file_get_contents($pckey));
	$tempDate = date("H:i:s d.m.y", filemtime($pckey));
	//print_r($pckeyarr);
	$message.="<tr><td colspan=8><h2>{$_GET['site']}&emsp;-&emsp;$tempDate</h2></td><tr>";
	foreach ($pckeyarr as $key => $value) {
		if (strripos($value[0], $_GET['project']) !== false) {
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
	//$message .= "<img src='".$name_of_shut."' alt='' />";
}
$message.="</table>";
echo $message;

?>
</body></html>
