<?php
/**
 * sibvez.ru
 */
$itemsArray['http://www.sibvez.ru/novosibirsk/catalog/pylesosy_1/pylesos_vitek_vt_1886_b_chernyy_2000vt/?sphrase_id=205126'] = array('Пылесос Vitek VT-1886 B черный 2000Вт', '8289', date("d.m.y-H:i:s"));
file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
