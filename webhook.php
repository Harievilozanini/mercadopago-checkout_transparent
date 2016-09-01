<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

//Include Mercadopago library
require_once "lib/mercadopago.php";

$mp = new MP(" YOUR ACCESS_TOKEN ");

$json_event = file_get_contents('php://input', true);
$event = json_decode($json_event);

// Check mandatory parameters
if (!isset($event->type, $event->data) || !ctype_digit($event->data->id)) {
	http_response_code(400);
	return;
}

// Get the payment reported by the IPN. Glossary of attributes response in https://developers.mercadopago.com
if ($event->type == 'payment'){
    $payment_info = $mp->get('/v1/payments/'.$event->data->id);

    if ($payment_info["status"] == 200) {
      print_r($payment_info["response"]);
        
// Rawfully store information received
      $myfile = fopen("sales.txt", "w") or die("failed to generate file!");
		  $txt = "Payment:\n";
		  fwrite($myfile, $txt);
		  $txt = serialize($payment_info);
		  fwrite($myfile, $txt);
		  fclose($myfile);
    }
}
?>
