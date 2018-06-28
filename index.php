<?php
// Reads the variables sent via POST from our gateway

require_once('AfricasTalkingGateway.php');
require_once('config.php');

//$echo $_SERVER['POST'];

var_dump($_POST);


$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$status      = $_POST["status"];
$sessionID   = $_POST["sessionId"];



//$url = 'http://3effc41f.ngrok.io/lengostreamx/ussds';

//$data = array('sessionId' => $serviceCode, 'serviceCode' => $serviceCode, 'phoneNo' => $phoneNumber, 'text' => $text);

// use key 'http' even if you send the request to https://...
/*$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context); */

if ( $text == "" ) {
     // This is the first request. Note how we start the response with CON
     $response  = "CON What would you want to check \n";
     $response .= "1. My Account \n";
     $response .= "2. My phone number";
}
else if ( $text == "1" ) {
  // Business logic for first level response
  $response = "CON Choose account information you want to view \n";
  $response .= "1. Account number \n";
  $response .= "2. Account balance";
  
 }
 else if($text == "2") {
  // Business logic for first level response
  // This is a terminal request. Note how we start the response with END
  $response = "END Your phone number is $phoneNumber";
 }
 else if($text == "1*1") {
  // This is a second level response where the user selected 1 in the first instance
  $accountNumber  = "ACC1001";
  // This is a terminal request. Note how we start the response with END
  $response = "END Your account number is $accountNumber";
 }
    
 else if ( $text == "1*2" ) {
  
     // This is a second level response where the user selected 1 in the first instance
     $balance  = "KES 10,000";
     // This is a terminal request. Note how we start the response with END
     $response = "END Your balance is $balance";
}
// Print the response onto the page so that our gateway can read it
header('Content-type: text/plain');


$url = 'http://3effc41f.ngrok.io/lengostreamx/ussds';

$data = array('sessionId' => $serviceCode, 
              'serviceCode' => $serviceCode, 
              'phoneNo' => $phoneNumber, 
              'text' => $text,
              'response' => $response,
              'sessionID' => $sessionId,
              'status' => $status
              
              );

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo $response;
// DONE!!!

?>
