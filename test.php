<?php
$re = '|^.*bog.*$|i';//在此处修改正则
function id_match($re, $file) {
	$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$result = array();
	foreach ($lines as $k => $v) {
		$tmp = explode('----', $v, 2);
		if (preg_match($re, $tmp[0])!==0){
			$result[] = $v;
		}
	}
	return $result;
}

$files = scandir('./cookie/good');
foreach ($files as $k => $v) {
	if (strpos($v, 'cookie_')===false) {
		unset($files[$k]);
	}
}
$all = array();
foreach ($files as $v) {
	$all = array_merge($all, id_match($re, './cookie/good/'.$v));
}
foreach ($all as $v) {
	echo $v,"\n";
}