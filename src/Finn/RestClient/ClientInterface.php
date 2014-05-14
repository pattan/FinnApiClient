<?php

namespace Finn\RestClient;

interface ClientInterface {

	public function setMethod($httpVerb);
	public function setHeaders($headers);
	public function send($url, $data);

}





?>