<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	define('AC_DIR', '/var/www/'.$_GET['ET']);
	define('ENGINE_CURR', $_GET['EC']);
	define('ENGINE_TYPE', $_GET['ET']);
	define('EXTRA_PARAM', $_GET['EP']);
	$currTime = date('H');

	require( '/var/www/lib/PHPExcel.php');
	require( '/var/www/lib/PHPExcel/Writer/Excel2007.php');
	require( '/var/www/lib/RollingCurl.class.php');
	require( '/var/www/lib/AngryCurl.class.php');
	require( '/var/www/lib/functions.php');

   	if (isset($_POST['proxyname'])) {
      //Save Proxy
      file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt', $_POST["proxyname"]);
    }

?>


<body>
	<div class="container">
		<div class="row">
			<div class="col-3">
				<table class="table table-sm" style="width:100%">
					<tr>
						<th>Выберите файл с html</th>
					</tr>
					<tr>
						<td>
							<br><br>
							<center>
							<form action="" method="POST" enctype="multipart/form-data">
							  <div class="form-group ">
							    <input type="file" class="form-control-file" id="loadfile" name="filename"><br>
							    <button type="submit" class="btn btn-primary">Загрузить и обработать</button>
							  </div>

							<?php if (file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/') && AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt') : ?>
							  <div class="form-group ">
							  	<br><br>
							  	<?php  @$c_text = trim(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt')); ?>
							  	<textarea id="someid" name="textcook" rows="20" cols="50"><?php //echo $c_text; ?></textarea>
							  </div>

							  <div>
							  	<br>
							  	<?php 
							  		if (file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt')) {
							  			$proxyaddr = trim(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt'));
							  			echo '<input type="text"  id="loadproxy" name="proxyname" value="'.$proxyaddr.'" style="width:400px;text-align:center">';
							  		}

							  	 ?>
							  	 <br><br>
							  	 <?php
							  	  if (ENGINE_CURR == 'f.ua') {
							  	  	$proxy_for_fotos = file_get_contents('/var/www/lib/proxies/16.proxy');
							  	  	echo str_replace(PHP_EOL, '<br>', $proxy_for_fotos);
							  	  }
							  	 ?>
							  </div>	
							<?php endif; ?>

							</form>
							</center>
						</td>
					</tr>
				</table>
			</div>


			<div class="col-9">
<?php
  $itemsArray = unserialize(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data'));

//	require_once('/var/www/'.$_GET['ET'].'/engines/'.$_GET['EC'].'/callback.php');
/*
	foreach ($itemsArray as $key => $value) {	// Найдём уникальные ссылки, которые нужно снять:
		if ($value[5] && $value[5] != 'manual') {
			$links[] = $value[5];
		}
	}
	$links = array_unique($links);
	asort($links);

	if ($currTime == '12') {
		$itemsArray = array();	// Костыль - обнуляет массив с предыдущими ценами
	}
	*/
?>

<table class="table table-sm">
	<tr>
		<!--th scope="col">Загрузите контент в файл испозьлуя эти ссылки:</th-->
	</tr>
<?php
/*
	foreach ($links as $value) { // Ссылки для загрузки
		echo '<tr><td><a href="'.$value.'" target="_blank">'.$value.'</a></td><tr>';
	}
	echo '</tr></table>';
	echo '</div></div>';
*/
	ini_set("upload_max_filesize","20M");

	if (isset($_FILES['filename'])) {
		$errors = array();
		$file_name = $_FILES['filename']['name'];
		$file_size = $_FILES['filename']['size'];
		$file_tmp = $_FILES['filename']['tmp_name'];
		$file_type = $_FILES['filename']['type'];  
		$file_ext =  explode('.', $_FILES['filename']['name']);
		$file_ext = strtolower(end($file_ext));
		
		$expensions = array("txt"); 		
		if (in_array($file_ext,$expensions) === false){
			$errors[] = "extension not allowed, please choose a txt file.";
		}
		//if ($file_size > 20971520){
		//$errors[] = 'File size must be excately 2 MB';
		//}
		if (empty($errors) == true){
			$file_for_use = '/var/www/temp/'.$_GET['EC'].'.'.$_GET['EP'].'.'.rand(0, 9).'.'.time();

			move_uploaded_file($file_tmp,$file_for_use);
			//sleep(15);

			$response = file_get_contents($file_for_use);

			$info['http_code'] = 200;
			$options = array(
					'url' => 'manual',
					'options' => array(
							'10004' => 'manual',
							'10006' => 'manual',
							'10018' => 'manual',
						)
				);
			$request = (object)$options;

			//$settings = json_decode(file_get_contents('/var/www/'.$_GET['ET'].'/engines/'.$_GET['EC'].'/settings.json'));
			
			echo '<div class="row">';
			echo '<div class="col-12">';
			echo '<p><strong>Лог сеанса</strong></p>';
			echo '<pre class="prettyprint" id="quine" style="height:500px">';
			require_once('/var/www/'.$_GET['ET'].'/engines/'.$_GET['EC'].'/manual.php');
			
			//print_r($itemsArray);die();
			if ($itemsArray) {
				file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', serialize($itemsArray));
			}
			
			unlink($file_for_use);
			unset($AC);
			echo '</pre>';
			echo '</div>';
			echo '</div>';
			
			//echo "Success";
		} else {
			//print_r($errors);
		}
	}

	if (isset($_POST)){
   	if (isset($_POST['textcook'])) {
      //Save File
      if (ENGINE_CURR == 'ozon.ru') { // КОСТЫЛЬ
      	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.json', $_POST["textcook"]);
      } else {
      	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt', $_POST["textcook"]);
      }
    }


    
	}

?>



	</div>
<br><br><br><br><br><br>
	<div style="padding:0 15%">
		<H1>Отсканированные url:</H1>
<?php 
	$itemsArray = unserialize(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y"). '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));

	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 15000) {
			$already_scanned[] = $value[5];
		}
	}
	$already_scanned = array_unique($already_scanned);
	asort($already_scanned);

	foreach ($already_scanned as $scannes_url) {
		echo $scannes_url.PHP_EOL."<br>";
	}
?>
	</div>
	<div>
		<center><h2><a style="color:red" target="_blank" href="http://176.36.102.174:4080/polaris/startdemon.php?city=<?=EXTRA_PARAM?>&engine=<?=ENGINE_CURR?>">Запустить сбор на сервере</a></h2></center>
	</div>
<br><br>
	<div>
		<center><h2><a style="color:red" target="_blank" href="http://176.36.102.174:4080/polaris/startdemonclean.php?city=<?=EXTRA_PARAM?>&engine=<?=ENGINE_CURR?>">Запустить сбор на сервере и обнулить прежние цены</a></h2></center>
	</div>	

</body>
</html>
