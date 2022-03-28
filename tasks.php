<h1><?=$_GET['EC'].' - '.$_GET['EP']?></h1>
<h2><?=$_GET['ET']?></h2>
<?php
/**
 * TASKS ANALYZER
 */
//$cur_date = date('d.m.y');

if (!$_GET) {
	$reportsArray = glob('/var/www/tasks/*.task');
} else {
	$reportsArray = glob('/var/www/tasks/'.$_GET['EC'].'_'.$_GET['ET'].'_'.$_GET['EP'].'.task');
}

$tasksArray = unserialize(file_get_contents($reportsArray[0]));
foreach ($tasksArray as $key => $value) {
?>
	<a target="_blank" href="<?=$key?>"><?=$key?></a><br/>
<?php } ?>

