<?php
class RestUtils  
{  
	public static function processRequest()  
	{  
	    // Welke method (REST: GET, PUT of DELETE) LET OP: PUT EN DELETE WERKEN ALLEEN BINNEN HETZELFDE DOMEIN!!!  
	    $request_method = strtolower($_SERVER['REQUEST_METHOD']);  
	    $return_obj     = new RestRequest();  
	    $data = array();  

	    switch ($request_method)  
	    {  
	        case 'get':  
	            $data = $_GET;  
	            break;  
	        case 'post':  
	            $data = $_POST;  
	            break;  
	        case 'put' || 'delete':  
	        	// Decode de body van het http request waarin json data staat en maak er een array van
	            $data = file_get_contents('php://input');
	            $data = json_decode($data,true); 
	            break;  
	    }  
	    // Bewaar de request method
	    $return_obj->setMethod($request_method);  
	  
	    //Bewaar de hele get of post
	    $return_obj->setQueryString($data); 
	    
	    // Bewaar de inhoud van het data veld
	    if(isset($data['data']))  
	    {  
	        $return_obj->setData($data['data']);  
	    } 
	    // Geef het request object terug
	    return $return_obj;  
	}  
  
    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')  
	{  
	    $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);  
	    header($status_header); // Zet de status  
	    header('Content-type: ' . $content_type); // Zet het content type   
	  
	    if($body != '')  
	    {  
	        // De body van de response  
	        echo $body;  
	        exit;  
	    }  
	    
	    // Er is geen body, maak er een  
	    else  
	    {  
	        // Messages  
	        $message = '';  
	        switch($status)  
	        {  
	            case 401:  
	                $message = 'You must be authorized to view this page.';  
	                break;  
	            case 404:  
	                $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';  
	                break;  
	            case 500:  
	                $message = 'The server encountered an error processing your request.';  
	                break;  
	            case 501:  
	                $message = 'The requested method is not implemented.';  
	                break;  
	        }  
	  
	        // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")  
	        $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];  
	  
	        // Template
	        $body = '<!DOCTYPE html> 
						<html lang="en">
							<head>
								<meta charset="utf-8" />
								<title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>  
	                        </head>  
	                        <body>  
	                            <h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>  
	                            <p>' . $message . '</p>  
	                            <hr />  
	                            <address>' . $signature . '</address>  
	                        </body>  
	                    </html>';  
	  
	        echo $body;  
	        exit;  
	    }  
	}    
  
    public static function getStatusCodeMessage($status)  
    {  
        $codes = Array(  
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',  
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported'  
        );  
  
        return (isset($codes[$status])) ? $codes[$status] : '';  
    }  
}  
  
class RestRequest  
{  
    private $data;  
    private $http_accept;  
    private $method;  
    private $callback;
    private $querystring;
  
    public function __construct()  
    {  
        $this->data = '';  
        $this->http_accept = "jsonp";  
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);  
        $this->callback = (isset($_GET["callback"])) ? $_GET["callback"] : '';
    }  
  
    public function setQueryString($data)  
    {  
        $this->querystring = $data;  
    }  
  
    public function getQueryString()  
    {  
        return $this->querystring;  
    }  
    
    public function setData($data)  
    {  
        $this->data = $data;  
    }  
  
    public function setMethod($method)  
    {  
        $this->method = $method;  
    }  
  
    public function getData()  
    {  
        return $this->data;  
    }  
  
    public function getMethod()  
    {  
        return $this->method;  
    }  
  
    public function getCallback()  
    {  
        return $this->callback;  
    }  
  
    public function getHttpAccept()  
    {  
        return $this->http_accept;  
    }  
      
}
?>