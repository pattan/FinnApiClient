<?php

namespace Finn\RestClient;

class CurlClient implements ClientInterface
{
	private $settings = array(
	   "header" => array(),
	   "httpMethod" => "GET",
	   "userAgent" => ""
	);
	private $ch;
	private $curlOpts = array();
	private $allowed = array('GET');
	
	public function __construct($settings)
	{	
		if(isset($settings["userAgent"])) {
		  $this->settings["userAgent"] = $settings["userAgent"];
        }
		if(isset($settings["httpMethod"])) {
		  if(!in_array($settings["httpMethod"], $this->allowed)) {
            die('HTTP METHOD NOT ALLOWED');
          }
		  $this->settings["httpMethod"] = $settings["httpMethod"];
        }
		if(isset($settings["header"])) {
		  $this->settings["header"] = $settings["header"];
        }
	}
	
	private function setOpts($data = null)
	{
		$opts = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_USERAGENT => $this->settings["userAgent"],
			CURLOPT_FRESH_CONNECT => 1,
		);
		switch($this->settings['httpMethod']) {
			case "PUT":
				$this->curlOpts = array_merge($opts, array(CURLOPT_CUSTOMREQUEST => "PUT"));
				break;
			case "DELETE":
				$this->curlOpts = array_merge($opts, array(CURLOPT_CUSTOMREQUEST => "DELETE"));
				break;
			case "POST":
				
				if(!is_array($data) || empty($data)) {
					throw new Exception("Data missing");
				}
				foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string, '&');
				
				$this->curlOpts = array_merge($opts, array(
					 CURLOPT_POST => count($data),
					 CURLOPT_POSTFIELDS => $fields_string
				));
				break;
			case "GET": 
				$this->curlOpts = $opts;
				break;
		}
	}
	
	private function close()
	{
		curl_close($this->ch);
	}
	
	public function setMethod($httpVerb)
	{
		if(!in_array($httpVerb, $this->allowed)) {
		  die('HTTP METHOD NOT ALLOWED');
        }
		$this->settings['httpMethod'] = $httpVerb;
	}
	
	public function setHeaders($headers)
	{
		$this->settings["header"] = array_merge($this->settings["header"], $headers);
	}
	
	public function send($url, $data = null)
	{	
		$this->ch = curl_init();	
		$this->setOpts($data);
        
		/*$opts = array(
			CURLOPT_URL => utf8_decode($url),
			CURLOPT_HTTPHEADER => $this->settings["header"],
			CURLOPT_SSL_VERIFYHOST => '0',
            CURLOPT_SSL_VERIFYPEER => '0'
		);*/
		//$curlOpts = array_merge($this->curlOpts, $opts);
				
		curl_setopt_array($this->ch, $this->curlOpts);
		
		curl_setopt($this->ch, CURLOPT_URL, utf8_decode($url));
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->settings["header"]);
		
		$rawData = curl_exec($this->ch);
		
		if (curl_error($this->ch)) {
			print_r(curl_error($this->ch));
			die("Fetch problem");
		}		
		return $rawData;
	}
	
}

?>