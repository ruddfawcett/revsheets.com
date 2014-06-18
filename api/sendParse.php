<?php
        if(array_key_exists('channel', $_REQUEST)) {
             $channel = $_REQUEST['channel'];
        }
        else {
             $channel = "";
        }
	$APPLICATION_ID = $_REQUEST['appID'];
	$REST_API_KEY = $_REQUEST['restID'];
	$alert = $_REQUEST['message'];
	$url = 'https://api.parse.com/1/push';
	$data = array(
   	 'channel' => $channel,
	 'type' => 'ios',
 	 'data' => array(
 	 'alert' => $alert,
     'sound' => 'push.caf',
    	),
		);
		$_data = json_encode($data);
		$headers = array(
 		'X-Parse-Application-Id: ' . $APPLICATION_ID,
 		'X-Parse-REST-API-Key: ' . $REST_API_KEY,
 		'Content-Type: application/json',
  		'Content-Length: ' . strlen($_data),
		);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_exec($curl);
?>