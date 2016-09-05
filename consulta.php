<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
require_once ('lib/mercadopago.php');

$mp = new MP ("YOUR PUBLIC ID", "YOUR ACCESS TOKEN");

$params = ["access_token" => $mp->get_access_token()];

//$mp->sandbox_mode(TRUE); //This must be set if you're willing to check on sandbox environment

$filters = array (
	"status" => "rejected" //Fill here with the transaction status desired, more details on https://www.mercadopago.com.br/developers/pt/api-docs/account/payments/older-integrations/
);

$search_result = $mp->search_payment ($filters, 0, 10);

print_r ($search_result);
?>
