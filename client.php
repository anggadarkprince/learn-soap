<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Zend\Soap\Client('http://localhost/soap/server.php?wsdl');

echo '<pre>';
print_r($client->getFunctions());
echo '</pre>';

$result = $client->sayHello(['firstName' => 'World']);
echo $result->sayHelloResult;
echo '<br>';
var_dump($client->getLastRequest());

$result = $client->sayGoodbye(['name' => 'Angga']);
var_dump($result->sayGoodbyeResult);
echo '<pre>';
print_r(json_decode(json_encode($result->sayGoodbyeResult), true));
echo '</pre>';


$result = $client->memberList();
echo '<pre>';
print_r($result->memberListResult);
echo '</pre>';
var_dump($client->getLastResponse());