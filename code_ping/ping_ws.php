<?php
require_once 'Rest.class.php';

header('Access-Control-Allow-Origin: *');

// Maak een request object aan
$data = RestUtils::processRequest();  
$method = $data->getMethod();
$http = $data->getHttpAccept();
$getpost =  $data->getQueryString();

function ping($url) {
    $i = parse_url($url); 
    $host = $i['host'];
    $port = 80; 
    $waitTimeoutInSeconds = 2; 
    try {
        $fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds);
        
        if(is_resource($fp) && ($errCode === 0)) {
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }
    catch(Exception $e) {
        return false;
    }
}

// Afhankelijk van http methode data verwerken
switch($method)  
{
    case 'get':

        // In PHP: header('Content-type: application/json');
        if($http == 'jsonp')
        {
            $jsondata = '{"exists":"'.json_encode(ping($getpost['url'])).'"}';
            RestUtils::sendResponse(200, $data->getCallback().$jsondata, 'application/json');
        } else {
            RestUtils::sendResponse(405,'');
        }
        break;
	default:
		RestUtils::sendResponse(405,'');
} 
?>