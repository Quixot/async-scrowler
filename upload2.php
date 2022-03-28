<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set("upload_max_filesize","20M");

	define('AC_DIR', '/var/www/'.$_GET['ET']);
	define('ENGINE_CURR', $_GET['EC']);
	define('ENGINE_TYPE', $_GET['ET']);
	define('EXTRA_PARAM', $_GET['EP']);
	$currTime = date('H');

	//include('/var/www/html/header.php');
	require( '/var/www/lib/PHPExcel.php');
	require( '/var/www/lib/PHPExcel/Writer/Excel2007.php');
	require( '/var/www/lib/RollingCurl.class.php');
	require( '/var/www/lib/AngryCurl.class.php');
	require( '/var/www/lib/functions.php');

?>
<body>
	<div class="container">
		<div class="row">
			<div class="col-12"><h1><?php echo ENGINE_CURR.' | '.EXTRA_PARAM ?></h1></div>
		</div>
		<div class="row">
			<form action="" method="POST" enctype="multipart/form-data" class="col-12">
				<div class="row">
				<div class="form-group col-6">
					<input type="file" multiple="multiple" class="form-control-file" id="loadfile" name="filename[]"><br>
					<button type="submit" class="btn btn-primary">Загрузить и обработать</button>
			  </div>

			<?php if (file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/') && AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt') : ?>
				<div class="form-group col-3">
					<textarea id="someid" name="textcook" rows="20" cols="50"></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
							  	
			<?php 
				if (file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt')) {
					$proxies = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt'));
					array_walk($proxies, 'trim_value');
											
					if (count($proxies) > 1) {
						echo '<div class="form-group ">';
						echo '<select name="select" id="select123">';
						for ($ipk=0; $ipk < count($proxies); $ipk++) { 
							echo '<option value="'.$proxies[$ipk].'">'.$proxies[$ipk].'</option>';
						}
						echo '</select>';
						echo '</div>';
					} else {
						echo $proxies[0];
						$cookiename = $proxies[0];
					}
				}
				//echo '<a target="_blank" href="appht.php?EC='.ENGINE_CURR.'&ET='.ENGINE_TYPE.'&EP='.EXTRA_PARAM.'"><img src="lib/1480949283_settings-24.png"></a>';
			?>
				
			<?php endif; ?>
					
			</form>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
<?php
	$itemsArray = unserialize(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data'));
	

//var_dump($_FILES['filename']);die();
if ($_POST) {
	# code...
//print_r($_POST);die();
	//$cookiename = $_POST['textcook']['select'];
	$response = '';
	if (isset($_FILES['filename']["name"])) {
		foreach ($_FILES['filename']["name"] as $filename_code => $filename_file) {
			//echo $filename_code.'<br>';
			echo $filename_file.'<br>';
			$errors = array();
			$file_name = $filename_file;
			$file_size = $_FILES['filename']['size'][$filename_code];
			$file_tmp = $_FILES['filename']['tmp_name'][$filename_code];
			$file_type = $_FILES['filename']['type'][$filename_code];  
			$file_ext =  explode('.', $filename_file);
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
				$response .= file_get_contents($file_for_use);
				//echo "Success";
			}
		} 
	}

	if (isset($_POST)){
   	if (isset($_POST['textcook'])) {
      //Save File
      file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt', $_POST["textcook"]);
    }
	}

	if (@$response) {
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
			//echo '<pre class="prettyprint" id="quine" style="height:500px">';
			require_once('/var/www/'.$_GET['ET'].'/engines/'.$_GET['EC'].'/manual.php');
			
			//print_r($itemsArray);die();
			if ($itemsArray) {
				file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', serialize($itemsArray));
			}
			
			unlink($file_for_use);
			unset($AC);
			//echo '</pre>';
			echo '</div>';
			echo '</div>';
	}
}
?>
			</div>
		</div>


		<div class="row">
			<div class="col-12">
				<center><h2><a style="color:red" target="_blank" href="http://176.36.102.174:4080/polaris/startdemon.php?city=<?=EXTRA_PARAM?>&engine=<?=ENGINE_CURR?>">Запустить сбор на сервере</a></h2></center>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<center><h2><a style="color:red" target="_blank" href="http://176.36.102.174:4080/polaris/startdemonclean.php?city=<?=EXTRA_PARAM?>&engine=<?=ENGINE_CURR?>">Запустить сбор на сервере и обнулить прежние цены</a></h2></center>
			</div>
		</div>	
	</div>
</body>
</html>
