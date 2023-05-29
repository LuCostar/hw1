<?php

header('Content-Type: application/json');

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://videogames-news2.p.rapidapi.com/videogames_news/recent",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: videogames-news2.p.rapidapi.com",
		"X-RapidAPI-Key: af29e088e8msh9b377e4600b8bc8p1f6517jsn8009b404465b"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}