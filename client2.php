<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Zend\Soap\Client('http://123.231.237.12:12055/Koja-Lini2_Services/Lini2Services?wsdl', [
    'soap_version' => SOAP_1_1
]);

echo '<pre>';
print_r($client->getFunctions());
echo '</pre>';

$result = $client->gatedata_inquiry([
    'username' => 'test',
    'password' => 'test123',
    'fstream' => '{"CNTR_ID":"TEST1234567","VESSEL_ID":"NWBHUM","VOYAGE_CODE":"312S","TID":"0001"}'
]);
echo '<pre>';
print_r(json_decode($result->return, true));
echo '</pre>';