<?php
set_time_limit(0);
function cookie2id($hash) {
	$re = "/Duplicate entry '(.+?)-10632414' for key 'toid'/";
	$url = 'https://h.nimingban.com/Home/Forum/addFeed/tid/10632414.html';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, 'userhash='.$hash);
	$string = curl_exec($ch);
	$result = array();
	if (preg_match($re, $string, $result)===0) {
		if ($GLOBALS['times']===1) {
			$GLOBALS['times']++;
			return cookie2id($hash);
		} else {
			return false;
		}
	}
	return $result[1];
}
function handle($file) {
	if (file_exists('cookie/'.$file)) {
		$lines = file('cookie/'.$file);
		foreach ($lines as $k => $v) {
			$GLOBALS['times'] = 1;
			$id = cookie2id(trim($v));
			if ($id!==false) {
				$lines[$k] = $id.'----'.$v;
			}
		}
		$content = implode('', $lines);
		file_put_contents('cookie/good/'.$file, $content);
		unlink('cookie/'.$file);
	}
}
$files = scandir('cookie');
$filter = array('.', '..', 'good', 'this.txt');//filter files
foreach ($files as $k => $v) {
	if (array_search($v, $filter)===false) {
		handle($v);
	}
}