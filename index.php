<?php

namespace Application;

require('finnapiclient/vendor/autoload.php');
use Finn\RestClient\CurlClient;
use Finn\FinnClient\FinnClient;

$curlClient = new CurlClient(array(
	"userAgent" => "testuser",
	"httpMethod" => "GET"
));

//$curlClient->setMethod("GET");
//Alternativ måte å sette headere på dersom flere
$apiKey = "GgqrudwV58aI3kex";
$curlClient->setHeaders(array(
	"x-finn-apikey: $apiKey"
));

$client = new FinnClient($curlClient);

$result = $client->search('realestate-homes', array(
	'orgId' => '1602109739',
	'page' => '',
	'rows' => '',
	'q' => 'sagene' //etc
));

//$result = $client->getObject('realestate-homes', 48305632);



//print_r($result->results);
header('Content-Type: application/json');
echo json_encode($result);

/*
foreach($result->results as $prop) {
    
    echo $prop->address.'<br>';
}
*/

?>




