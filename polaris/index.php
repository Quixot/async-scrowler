<?php
/**
 * Отображение отчётов
 */
date_default_timezone_set( 'Europe/Kiev' );
clearstatcache();

$cur_date = date('d.m.y'); //echo 'Дата: '.$cur_date."\n";
$num_pos = 1;

$yesterday = date("d.m.y", time() - 60 * 60 * 24);
//$yesterday = "06.01.17";
//echo $yesterday.' / ';
//echo $cur_date;
$data = '/var/www/'.$_GET['project'].'/engines/';

//$cur_date = '10.11.16';
$yesterday = '20.01.17';

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
  <script>
    onload = function () {setTimeout ('location.reload (true)', 300000)}
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
	</style>
</head>
<body>
<?php
	$loadavg = sys_getloadavg();
	$loadavg = implode('&emsp;', $loadavg);
?>
<h3>LOAD Average:&emsp;<?=$loadavg?></h2>


<h1><?=ucfirst($_GET['project'])?></h1>

<ul class="nav">

	<li><a href="/?project=vitek">Vitek</a></li>
	<li><a href="/?project=maxwell">Maxwell</a></li>


</ul>
<div style="clear:both"></div>
<br>

<?php 
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
				echo '<span class="disup">'.substr($researchArrayBg[$q], strripos($researchArrayBg[$q], '/')+10).'</span>';
			}
		}
	}
	
	
}
//print_r($todayFiles);
echo '</div><div style="clear:both"></div>';
?>
<br>
<div style="float:left;display: inline-block">
<table>
	<thead>
		<tr>
			<td>#</td>
			<td></td>			
			<td><strong>Файл</strong></td>
			<td></td>
			<td><strong>Дата создания</strong></td>
			<td></td>
			<td><strong>Размер</strong></td>
			<td></td>
			<td><strong>Вч.<br>шт.</strong></td>
			<td></td>
			<td><strong>Сег.,<br>шт.</strong></td>
			<td></td>
			<td><strong></strong></td>
			<td></td>
			<td><strong>δ <br>шт.</strong></td>
			<td></td>
			<td></td>
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

				//if ($sizeToday < $sizeYes) {
				if ((1-$sizeToday/$sizeYes) > 0.1 && strlen(abs($sizeYes-$sizeToday)) > 1) {
					$echoSizeDiff = '<span style="color:red;font-weight:bold">-'.($sizeYes-$sizeToday).'</span>';
					$isShowPos = 1;
				} elseif ($sizeToday > $sizeYes) {
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
    <td>&emsp;</td>
    <td>
      <?php
      	echo $echoSize;
      ?>
    </td>
    <td>&emsp;</td>
    <td><?=$sizeYes?></td>
    <td>&emsp;</td>
    <td><?=$sizeToday?></td>
    <td>&emsp;</td>
    <td>
<?php 
	if ($sizeToday == $qOfItems) {
		echo $qOfItems;
	} else {
		echo '<span style="color:red;font-weight:bold">'.$qOfItems.'</span>';
	}
	
?>
    </td>
    <td>&emsp;</td>
    <td>
<?php 
	echo $echoSizeDiff;

?>
    </td>
    <td>&emsp;</td>
    <td>
    	<?='<a target="_blank" href="appol.php?EC='.$tempEngine.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480949283_settings-24.png"></a>'?>
    </td>
    <td>&emsp;</td>
    <td><?='<a target="_blank" href="tasks.php?EC='.$tempEngine.'&ET='.$_GET['project'].'&EP='.$city.'"><img src="lib/1480950303_new-24.png"></a>'?></td>
	</tr>

<?php //} //$isShowPos = 1; ?>

<?php 
	if ($i == $quontSites && $quontSites > 44) {
		echo '</table></div><div style="float:right;display:inline:block;"><table>';
		echo '	<thead>
		<tr>
			<td>#</td>
			<td></td>			
			<td><strong>Файл</strong></td>
			<td></td>
			<td><strong>Дата создания</strong></td>
			<td></td>
			<td><strong>Размер</strong></td>
			<td></td>
			<td><strong>Вч.<br>шт.</strong></td>
			<td></td>
			<td><strong>Сег.,<br>шт.</strong></td>
			<td></td>
			<td><strong></strong></td>
			<td></td>
			<td><strong>δ <br>шт.</strong></td>
			<td></td>
			<td></td>
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