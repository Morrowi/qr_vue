<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit(0);
}

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

//var_dump($data['url']);

if($data['url'] == 'subscription-data'){

  echo exec('curl -X POST "https://stage.wapiserv.qrm.ooo/billing/subscription-data/" -H  "accept: application/json" -H  "X-Api-Key: ViVuB0oA.Fs0pQYpduk99zxZoeZR6gVhFx8itg4yP" -H  "Content-Type: application/json" -H  "X-CSRFToken: Lfyj6g6EYPe9uXfACfEpOE2StPJtzkbwzhxKKBxMWvNB8ExiMo45L3NRoUWWscru" -d "{  \"email\": \"dev@qrm.ooo\",  \"pin\": \"11111\"}"');

}elseif($data['url'] == 'qr_code'){

  $parsed_prices = '';
//$prices = $data['summ'];
  $prices = 1;
  $prices = preg_replace('/\(.*\)| \(.*\)/', '', $prices);
  $delimetr = substr($prices,-3,1);
  $price = preg_replace('/[^\d]/', '', $prices);
  $parsed_prices = ($delimetr == ',' || $delimetr == '.') ? $price : $price.'00';

  echo exec('curl -X POST "https://wapiserv.qrm.ooo/operations/qr-code/" -H "accept: application/json" -H "X-Api-Key: J8LUjbGJ.UBZksq5n9O443l3Nw93rbqSdDjIb0ZpZ" -H "Content-Type: application/json" -H "X-CSRFToken: XeBqlIvv91UiIZYHZWJrKBEYEpLSs8BmwZBlRQAgSUJcBVKWduFHuN55JFVUfftS" -d "{ \"sum\": '.intval($parsed_prices).', \"qr_size\": 305}"');
}