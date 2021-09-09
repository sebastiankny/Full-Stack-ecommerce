<?php

$cURL = curl_init();
$setopt_array = array(
    CURLOPT_URL => "https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products",    
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_USERNAME => "", // REMOVED TO PUBLISH ON GITHUB
    CURLOPT_PASSWORD => "", // REMOVED TO PUBLISH ON GITHUB
    CURLOPT_RETURNTRANSFER => true, 
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
    )
); 
curl_setopt_array($cURL, $setopt_array);

$json_response_data = curl_exec($cURL);
if(!$json_response_data){die("Connection Failure");}

$response = json_decode($json_response_data);
echo ($json_response_data);
curl_close($cURL);
?>