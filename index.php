<?php
/**
 * Отображение отчётов
 */
date_default_timezone_set( 'Europe/Kiev' );
clearstatcache();
exec("ps aux | grep ".$_GET['project'], $process_list);

$cur_date = date('d.m.y'); //echo 'Дата: '.$cur_date."\n";
$num_pos = 1;


$yesterday = date("d.m.y", time() - 60 * 60 * 24);

//echo $yesterday.' / ';
//echo $cur_date;
$data = '/var/www/'.$_GET['project'].'/engines/';

//$cur_date = '10.11.16';
//$yesterday = '11.09.17';

//$dir = '/var/www/'.$_GET['project'].'/reports';
$reportsArray = glob('/var/www/'.$_GET['project'].'/engines/*/data/*'.$cur_date.'*.data');
$pricechangestemp = glob('/var/www/'.$_GET['project'].'/log/'.$cur_date.'/*.data');
foreach ($pricechangestemp as $key) {
	$temp = str_replace('/var/www/'.$_GET['project'].'/log/'.$cur_date.'/', '', $key);
	$temp = substr($temp, stripos($temp, '_')+1);
	$pricechanges[] = str_replace('.data', '', $temp);
}


function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
?>
<html>
<head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>	
  <script>
    onload = function () {setTimeout ('location.reload (true)', 100000)}
  </script>
	<title><?=ucfirst($_GET['project'])?> - PricingLogix</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.ico">
	<style type="text/css">
.nav {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    margin-bottom: 50px;
}
.nav>li {
    float: left;
    position: relative;
    display: block;
    padding-right: 10px;
}
.new {
		background: green;
		color: white;
		font-weight: bold;
		padding: 5px;
		margin-right: 3px;
		margin-bottom: 3px;
		display: block;
		float: left;
}
.disup {
		background: red;
		color: white;
		font-weight: bold;
		padding: 5px;
		margin-right: 3px;
		margin-bottom: 3px;
		display: block;
		float: left;
}
th, td {
    padding-left: 7px;
    padding-right:  7px;
}
	</style>
</head>
<body>
<?php
	$loadavg = sys_getloadavg();
	//$loadavg = implode('&emsp;', $loadavg);
?>
<script type="text/javascript">
	google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() { // Функция вызывается событием onclick.

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Now', 80],
          ['5 min.', 55],
          ['15 min.', 68]
        ]);

        var options = {
          width: 400, height: 120,
          max: 40, min: 0,
          greenFrom: 0, greenTo: 3,
          yellowFrom: 4, yellowTo: 14,
          redFrom: 15, redTo: 40,
          minorTicks: 5,
          redColor: '#FF0000'
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);
 					data.setValue(0, 1, <?=$loadavg[0]?>); // Выбирается случайное значение для каждого датчика
          chart.draw(data, options);
          data.setValue(1, 1, <?=$loadavg[1]?>);
          chart.draw(data, options);
          data.setValue(2, 1, <?=$loadavg[2]?>);
          chart.draw(data, options);
	}
</script>

<script type="text/javascript">
	var myVar = setInterval(function() {
	  myTimer();
	}, 1000);

	function myTimer() {
	  var d = new Date();
	  document.getElementById("clock").innerHTML = d.toLocaleTimeString();
	}
</script>

<table>
<tr>
<td><div id="chart_div"></div></td>
<td>
<p id="clock"></p>
</td>
</tr>
</table>





<h1><?=ucfirst($_GET['project'])?></h1>

<ul class="nav">
	<li><a href="http://82.193.126.150/?project=philips"><b>Philips</b></a></li>
	<li><a href="http://176.36.102.174:4080/?project=philips"><b>Philips backup</b></a></li>
	<li><a href="http://82.193.126.150/rozetka.ua/reports/">Philips Rozetka</a></li>
	<li><a href="http://176.36.102.174:4080/?project=polaris"><b>Polaris</b></a></li>
	<li><a href="http://82.193.126.150/?project=polaris"><b>Polaris backup</b></a></li>
	<li>&emsp;</li>
	<li><a href="http://109.86.86.22/?project=hotline"><b>Hotline</b></a></li>
	<li>&emsp;</li>	
	<li><a href="http://82.193.126.150"><b>obolon</b></a></li>
	<li><a href="http://82.193.102.178:2080"><b>xeon</b></a></li>
	<li><a href="http://176.36.102.174:4080"><b>xeon2</b></a></li>
	<li><a href="http://176.36.102.141:5080">xeon3</a></li>
	<li><a href="http://109.86.86.22">serg</a></li>
	<li><a href="http://176.36.102.174:3080/?project=rondell"><b>pl1</b></a></li>
	<li><a href="http://82.193.126.150:6080/?project=rondell"><b>pl2</b></a></li>
</ul>
<div style="clear:both"></div>
<br>

<table>

<?php 
	$reports = glob('/var/www/reporter/reports/'.$cur_date.'/*.xlsx');
	//$report_big = glob('/var/www/reporter/reports/big/*.xlsx');
	//$res_rep = array_merge($reports, $report_big);
	foreach ($reports as $rep_url) {
		echo '<tr>';
		echo '<td><a href="'.str_replace('/var/www', '', $rep_url).'">'.str_replace('/var/www/reporter/reports/'.$cur_date.'/', '', $rep_url).'</a></td>';
		echo '<td>'.human_filesize(filesize($rep_url), 1).'</td>';
		echo '</tr>';
	}

	$reports = glob('/var/www/reporter/reports/*search.xlsx');
	//print_r($reports);
	if ($reports) {
		foreach ($reports as $rep_url) {
			echo '<tr>';
			echo '<td><a href="'.str_replace('/var/www/', '', $rep_url).'">'.str_replace('/var/www/reporter/reports/', '', $rep_url).'</a></td>';
			echo '<td>'.human_filesize(filesize($rep_url), 1).'</td>';
			echo '<td></td>';
			echo '</tr>';				
		}
	}

			echo '<tr>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td><strong><a style="color:red" target="_blank" href="http://176.36.102.174:4080/reporter/startreportht.php">Запустить внеплановый отчёт</a></strong></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td></a></td>';
			echo '<td></td>';
			echo '<td><strong><a style="color:red" target="_blank" href="http://176.36.102.174:4080/reporter/startreportht1.php">Запустить ещё один отчёт №1</a></strong></td>';
			echo '</tr>';	
			echo '<tr>';
			echo '<td></a></td>';
			echo '<td></td>';
			echo '<td><strong><a style="color:red" target="_blank" href="http://176.36.102.174:4080/reporter/startreportht2.php">Запустить ещё один отчёт №2</a></strong></td>';
			echo '</tr>';	


	echo '<tr>';
	echo '<td></td>';
	echo '<td></td>';
	echo '</tr>';
	

	$reports = glob('/var/www/reporter/reports/polaris_big/*'.str_replace('.', '', $cur_date).'*.xlsx');
	//print_r($reports);
	if ($reports) {
		echo '<tr><td><h3>BIG reports:</h3></td><td></td></tr>';
		//echo '<tr>';
		//echo '<td><a href="http://176.36.102.174:4080/polaris/big_base.xlsx">big_base.xlsx</a>';
		//echo '</tr>';
		echo '<tr>';
		echo '<td><a href="http://176.36.102.141:5080/reporter/reports/polaris_big/Monitoring_Polaris_'.date("dmy").'_1.xlsx">Monitoring_Polaris_'.date("dmy").'_1.xlsx</a></td>';
		echo '<tr>';

		echo '<tr>';
		echo '<td>backup:</td>';
		echo '</tr>';
		foreach ($reports as $rep_url) {
			echo '<tr>';
			echo '<td><a href="'.str_replace('/var/www/', '', $rep_url).'">'.str_replace('/var/www/reporter/reports/polaris_big/', '', $rep_url).'</a></td>';
			echo '<td>'.human_filesize(filesize($rep_url), 1).'</td>';
			echo '</tr>';
		}
	}

?>

</table>


<?php
if (!$_GET['project']) {
	exec("ps aux | grep /var/www/", $output);
	foreach ($output as $key) {
		if (strripos($key, 'grep /var/www/') === false) {
			echo '<small>'.$key.PHP_EOL.'</small><br />';
		}
	}
}
 
$data = '/var/www/'.$_GET['project'].'/engines/';

$enginesArray = scandir($data); // Список движков
echo '<div>';
for ($i=2; $i < count($enginesArray) ; $i++) {
	$tempCurr = glob($data.$enginesArray[$i].'/data/'.$cur_date.'*');
	$tempYes  = glob($data.$enginesArray[$i].'/data/'.$yesterday   .'*');

	if (count($tempCurr) > count($tempYes)) { // Новые файлы
		$researchArrayBg = $tempCurr;
		$researchArraySm = $tempYes;
		$flag = 1;
	} else { // Выпали файлы
		$researchArrayBg = $tempYes;
		$researchArraySm = $tempCurr;
		$flag = 0;
	}
	
	
	
	for ($q=0; $q<count($researchArrayBg); $q++) {
		if ($flag == 1) { // Новый файл
			if (!in_array(str_replace($cur_date, $yesterday, $researchArrayBg[$q]), $researchArraySm)) {
				echo '<span class="new">'.substr($researchArrayBg[$q], strripos($researchArrayBg[$q], '/')+10).'</span>';			
			}
		} else {
			if (!in_array(str_replace($yesterday, $cur_date, $researchArrayBg[$q]), $researchArraySm)) {
				
/**
	* NEW - Шестерёнка на красных позициях
	*/	
				preg_match("~data/.*_(.+).data~isU", $researchArrayBg[$q], $matches);

				$pcttt = $matches[1];
				$city = substr($pcttt, strripos($pcttt, '_')+1);
				preg_match("~data/.*_(.+)_~isU", $researchArrayBg[$q], $matches2);

				$tempEngineTemp = $matches2[1];
				echo '<span class="disup">'.substr($researchArrayBg[$q], strripos($researchArrayBg[$q], '/')+10).
				'&nbsp;<a target="_blank" href="appht.php?EC='.$tempEngineTemp.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480949283_settings-24.png"></a>&nbsp;<a target="_blank" href="upload.php?EC='.$tempEngineTemp.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480950303_new-24.png"></a></span>';
/**
 * NEW
 */
			}
		}
	}
	
	
}
//print_r($todayFiles);
echo '</div><div style="clear:both"></div>';
?>
<br>
<a target="_blank" href="zip.php?target=philips">Download ZIP</a>
<br>
<div style="float:left;display: inline-block">
<table>
	<thead>
		<tr>
			<td>#</td>
				<td></td>
						<td></td>
						
			<td><strong>Файл</strong></td>
			<td>$-$$</td>
			<td><strong>Дата</strong></td>
			
			<td><strong>Размер</strong></td>
			<td></td>
			<td><strong>Вч.<br>шт.</strong></td>
			
			<td><strong>Сег.,<br>шт.</strong></td>
			
			<td><strong></strong></td>
			
			<td><strong>δ</strong></td>
			<td></td>
			<td></td>
		
		</tr>
	</thead>

<?php $i = 1; ?>
<?php $quontSites = ceil(count($reportsArray)/2); ?>
<?php foreach ($reportsArray as $key) : ?>
<?php
	preg_match("~data/.*_(.+).data~isU", $key, $matches);
	$pcfile = $matches[1];
	$city = substr($pcfile, strripos($pcfile, '_')+1);
	preg_match("~data/.*_(.+)_~isU", $key, $matches2);
	$tempEngine = $matches2[1];

	//$tempEngine = substr($key, 0, stripos($key, '_'));
	//$tempEngine = substr($tempEngine, strripos($tempEngine, '/')+1);

	$tempFile = substr($key, strripos($key, $tempEngine));
	//$tempFile = str_replace('.xlsx', '.data', $tempFile);

	$tempToday 	= '/var/www/'.$_GET['project'].'/engines/'.$tempEngine.'/data/'.$cur_date .'_'.$pcfile.'.data';
	$tempYes    = '/var/www/'.$_GET['project'].'/engines/'.$tempEngine.'/data/'.$yesterday.'_'.$pcfile.'.data';

	if (file_exists($tempToday)) {
		$sizeToday = count(unserialize(file_get_contents($tempToday)));
	} else {
		$sizeToday = 0;
	}
	if (file_exists($tempYes)) {
		$sizeYes   = count(unserialize(file_get_contents($tempYes)));
	} else {
		$sizeYes = 0;
	}
	

	
	//print_r(unserialize(file_get_contents($tempYes)));
	//$cPriceToday = 
	//$cPriceYes 	 = 
	
	/**
	 * Определяем время и размер:
	 */
				$isShowPos = 0;
      	$tempDate = filemtime($key);
      	if (time() - $tempDate > 14400) {
      		$echoDate = '<strong><span style="color:red">';      		
      		$echoDate .= date("d.m.y H:i:s", $tempDate);
      		$echoDate .= '</span></strong>';
      		$isShowPos = 1;
      	} else {
      		$echoDate = date("d.m.y H:i:s", $tempDate);
      	}	

        if (filesize($key) <= 0) {   
          $echoSize = '<strong><span style="color:red">'; 
          $echoSize .= human_filesize(filesize($key), 1);
          $echoSize .= '</span></strong>';
          $isShowPos = 1;
        } else {
          $echoSize = human_filesize(filesize($key), 1);
        }

				if ((1-$sizeToday/$sizeYes) > 0.1 && ($sizeToday-$sizeYes) <= 0) {
					$echoSizeDiff = '<span style="color:red;font-weight:bold">'.($sizeToday-$sizeYes).'</span>';
					$isShowPos = 1;
				} elseif ($sizeToday>$sizeYes) {
					$echoSizeDiff = '<span style="color:green;font-weight:bold">+'.($sizeToday-$sizeYes).'</span>';		
					//$echoSizeDiff = '<span style="color:green;font-weight:bold">+'.$tempEngine.'-'.$pcfile.'</span>';		
				}	else {
					$echoSizeDiff = '';
				}

				if ($sizeToday == 0) {
					$isShowPos = 1;
				}

  /**
   * Выводим позицию, только если она "красная"
   */
  			//if ($isShowPos > 0) {
  			
  			
?>
	<tr>
		<td><?php echo $num_pos; $num_pos++ ?></td>
		<td>
			<a href="<?='viewprice.php?file='.$pcfile.'&project='.$_GET['project']?>" target="_blank"><img src="lib/1471553451_eye-24.png"></a>&emsp;
		</td>
		<td>
			<a href="<?='/'.$_GET['project'].'/reports/'.$pcfile.'.xlsx'?>" target="_blank"><img src="lib/1487274097_Excel_D.png"></a>&emsp;
		</td>	
		<td>
			<a href="<?php echo str_replace("/var/www/", '', $key); ?>"><?php echo $pcfile?></a>
		</td>
		<td>
<?php 
		//$pcfile = str_replace('/var/www/'.$_GET['project'].'/reports/', '', $key);
		//$pcfile = str_replace('.xlsx', '', $pcfile);
		
		
		$qOfItems  = file_get_contents('/var/www/'.$_GET['project'].'/items/'.$pcfile.'.txt');
		if (in_array($pcfile, $pricechanges)) :
?>
			<a href="pricechanges.php?site=<?=$pcfile?>&project=<?=$_GET['project']?>" title="ПЕРЕОЦЕНКА!!!" name="<?=$pcfile?>"><img src="/lib/1471546620_common-tag-general-price-glyph.png"></a>
<?php 
		endif 
?>
		</td>		
		<td>
      <?php 
      	echo $echoDate;
      ?>
    </td>
    
    <td>
      <?php
      	echo $echoSize;
      ?>
    </td>
    <td>			<?php // Процесс в работе 
				foreach ($process_list as $process_key) {
					if (strrpos($process_key, $_GET['project']) != false && strrpos($process_key, $city) !== false && strrpos($process_key, $tempEngine) !== false)  {
						echo '<i class="fas fa-spinner fa-pulse"></i>'; //style="color:Tomato"
						break;
					}
				}
			?></td>

    <td><?=$sizeYes?></td>
    
    <td><?=$sizeToday?></td>
    
    <td>
<?php 
	if ($sizeToday == $qOfItems) {
		echo $qOfItems;
	} else {
		echo '<span style="color:red;font-weight:bold">'.$qOfItems.'</span>';
	}
	
?>
    </td>
    
    <td>
<?php 
	echo $echoSizeDiff;

?>
    </td>
    
    <td>
    	<?php if($_GET['project']) :?>
    	<?='<a target="_blank" href="appht.php?EC='.$tempEngine.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480949283_settings-24.png"></a>'?>
    	<?php endif;?>
    </td>
    
    <td>
    	<?='<a target="_blank" href="upload.php?EC='.$tempEngine.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480950303_new-24.png"></a>'?>
    </td>
	</tr>

<?php //} //$isShowPos = 1; ?>

<?php 
	if ($i == $quontSites && $quontSites > 44) {
		echo '</table></div><div style="float:right;display:inline:block;"><table>';
		echo '	<thead>
		<tr>
			<td>#</td>
				<td></td>
						<td></td>
						
			<td><strong>Файл</strong></td>
			<td>$-$$</td>
			<td><strong>Дата</strong></td>
			
			<td><strong>Размер</strong></td>
			<td></td>
			<td><strong>Вч.<br>шт.</strong></td>
			
			<td><strong>Сег.,<br>шт.</strong></td>
			
			<td><strong></strong></td>
			
			<td><strong>δ</strong></td>
			<td></td>
			<td></td>	
		</tr>
	</thead>';
	}
?>
<?php $i++; ?>
<?php endforeach; ?>

</table>
</div>



</body>
</html>

<?php  ?>