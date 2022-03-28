<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?=$_GET['file']?> : PricingLogix</title> 
  </head>

  <body>
		<h2><?=ucfirst($_GET['project']).'&emsp;'.$_GET['file']?></h2>
		<table>
			<tr>
				<td>Вчерашняя сумма</td>
				<td><span id="bsum"></span></td>
			</tr>
			<tr>
				<td>Сегодняшняя сумма</td>
				<td><span id="csum"></span></td>
			</tr>
			<tr>
				<td>Расхождение в сумме</td>
				<td><span id="res"></span></td>
			</tr>	
			<tr>
				<td>Расхождение в количестве</td>
				<td><span id="resq"></span></td>
			</tr>	
		</table>

<?php
/**
 * Быстрый просмотр прайса
 */
$yesterday = date("d.m.y", time() - 60 * 60 * 24);
//$yesterday = '03.08.18';
$engine = substr($_GET['file'], 0, stripos($_GET['file'], '_'));
$infoY = unserialize(file_get_contents('/var/www/'.$_GET['project'].'/engines/'.$engine.'/data/'.$yesterday.'_'.$_GET['file'].'.data'));
$info  = unserialize(file_get_contents('/var/www/'.$_GET['project'].'/engines/'.$engine.'/data/'.date("d.m.y").'_'.$_GET['file'].'.data'));

$resSum = count($info) - count($infoY);

$resultArray = array();


foreach ($info as $key => $value) {
	if (isset($infoY[$key])) {
		$resultArray[$key] = array(
													'name'    	=> $value[0],
													'before'  	=> $infoY[$key][1],
													'current' 	=> $value[1],
													'date'			=> $value[2],
													'proxy'	  	=> $value[3],
													'useragent' => $value[4],
													'request'		=> $value[5],
													'merch'			=> $value[6],
			);
		unset($infoY[$key]);
	} else {
		$resultArray[$key] = array(
													'name'    	=> $value[0],
													'before'  	=> '-',													
													'current' 	=> $value[1],
													'date'			=> $value[2],
													'proxy'	  	=> $value[3],
													'useragent' => $value[4],
													'request'		=> $value[5],
													'merch'			=> $value[6],
			);		
	}
}
if ($infoY) {
	foreach ($infoY as $key => $value) {
		$resultArray[$key] = array(
														'name'    	=> $value[0],
														'before'  	=> $value[1],													
														'current' 	=> '-',
														'date'			=> $value[2],
														'proxy'	  	=> $value[3],
														'useragent' => $value[4],
														'request'		=> $value[5],
														'merch'			=> $value[6],
				);
	}
}


echo build_table($resultArray);

function build_table($array) {
	global $beforeSUM;
	global $currSUM;

	$beforeSUM = 0;
	$currSUM = 0;
	$html = '<table cellspacing="0" cellpadding="5">';
  foreach ($array as $key=>$value) {
		$html .= '<tr>';
		$first = 1;
		$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;"><a href="'.$key.'" target="_blank">' . $value['name'] . '</a></td>';
		$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;">' . $value['before'] . '</td>';
		if ($value['before'] == '-') {
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;"><span style="font-weight:bold">' . $value['current'] . ' &#9733;</span></td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;">' . $value['date'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['request'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['proxy'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['merch'] . '</td>';
		} elseif ($value['before'] > $value['current'] && $value['current'] && $value['current'] != '-') {
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;"><span style="font-weight:bold">' . $value['current'] . ' &#9660;</span></td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;">' . $value['date'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['request'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['proxy'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['merch'] . '</td>';	  
		} elseif ($value['before'] > $value['current'] && $value['current'] && $value['current'] == '-') {
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold">' . $value['current'] . '&emsp;!!!!!!</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold">' . $value['date'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['request'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['proxy'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['merch'] . '</td>';	 
		} elseif ($value['before'] && !$value['current']) {
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold">' . $value['current'] . '&emsp;!!!</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold">' . $value['date'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['request'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['proxy'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;color:red;font-weight:bold;font-size:8px">' . $value['merch'] . '</td>';
		} else {
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;">' . $value['current'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;">' . $value['date'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['request'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['proxy'] . '</td>';
			$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['merch'] . '</td>';
		}
		$html .= '<td valign="top" style="border-bottom: 1px solid #ddd;font-size:8px">' . $value['merch'] . '</td>';
		$html .= '</tr>';

		$beforeSUM = $beforeSUM + $value['before'];
		$currSUM = $currSUM + $value['current'];

  }
	$html .= '</table>';
	return $html;
}

?>
<script type="text/javascript">
var bsum = <?=$beforeSUM?>;
var csum = <?=$currSUM?>;
var res;
var resq = <?=$resSum?>;

document.getElementById('bsum').innerHTML = bsum;
document.getElementById('csum').innerHTML = csum;
document.getElementById('res').innerHTML = csum - bsum;
document.getElementById('resq').innerHTML = resq;

</script>
</body></html>
