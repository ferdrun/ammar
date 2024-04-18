<?php
require 'environment.php';

global $config;
global $db;

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/ammar/");
	$config['dbname'] = 'novaloja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
} else {
	define("BASE_URL", "http://localhost/ammar/");
	$config['dbname'] = 'novaloja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

$config['default_lang'] = 'pt-br';
$config['cep_origin'] = '58400260';

$config['pagseguro_seller'] = 'seu@email.com';

// Informações do MercadoPago
$config['mp_appid'] = '1173267089584114';
$config['mp_key'] = 'yvnv1p6RfzfSFRH5XPhe5l0zMn6VUKnQ';

// Informações do PayPal
$config['paypal_clientid'] = 'AQ9fApNwXUdMQiUIGWsuE5-C5w_Xr2Xqetdxi3CrSh5ZAApxx5cywk0oRt6ZxOZZdcPTDsabC3e13gu4';
$config['paypal_secret'] = 'EMJrTFbSynPxRrycji6IC6Qis32pNIwfcwPCI0OuWLWmOONfHfKOFiNJ3blKVqtMZn3Yt0ut-Z2oPxKl';

// Informações do Gerencianet
$config['gerencianet_clientid'] = 'Client_Id_eef30619a8aefa58e3905e9eb96dd07c9d160860';
$config['gerencianet_clientsecret'] = 'Client_Secret_e4d51ede439aba679026d917469acd5a3f5b8c55';
$config['gerencianet_sandbox'] = true;

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
?>