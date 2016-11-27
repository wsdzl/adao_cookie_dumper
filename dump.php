<?php
set_time_limit(0);
function getCookie() {
	$url = 'https://h.nimingban.com/Api/getCookie';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$string = curl_exec($ch);
	preg_match_all('/Set-Cookie: userhash=(.*?);/', $string, $results);
	return isset($results[1][1])?$results[1][1]:false;
}
function write() {
	$cookies = '';
	for ($i=0; $i < 50; $i++) { 
		$cookies .= getCookie()."\r\n";
	}
	file_put_contents('cookie/cookie_'.mt_rand().'.txt', $cookies);
}
while(1){
	write();
}