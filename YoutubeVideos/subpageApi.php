<?php
 
 function test($data){
       $curlSession = curl_init();
	curl_setopt($curlSession, CURLOPT_URL, 'http://Movieverse-youtube.herokuapp.com/apisub/' .$data);
	curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

	$jsonData2 = json_decode(curl_exec($curlSession), true);
	curl_close($curlSession);
	return json_encode($jsonData2);
 }

if (isset($_POST['callFunc1'])) {
	print_r(test($_POST['callFunc1']));
}