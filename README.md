# INSTALL

If you are using composer in your project, follow the first step. If not, carry on to "Without composer"

### With composer:

Add this to your projects composer.json file
```javascript
"repositories": [
	{
		"type": "vcs",
		"url": "https://github.com/luhmor/FinnApiClient"
	}
],
"require": {
	"reeltime/finnapiclient":"1.*"
}
```

Then run:
`composer update`

### Whithout composer

Download the zip-file and this in your php:
```php
require('FinnApiClient-master/vendor/autoload.php');
use Finn\RestClient\CurlClient;
use Finn\FinnClient\FinnClient;

```


### Full sample use

```php

require('vendor/autoload.php');
use Finn\RestClient\CurlClient;
use Finn\FinnClient\FinnClient;

//Set up the CurlClient to be used in FinnClient
$curlClient = new CurlClient(array(
	"userAgent" => "testuser",
	"httpMethod" => "GET"
));
//Set your apikey as a header
$apiKey = "<Your api key>";
$curlClient->setHeaders(array(
	"x-finn-apikey: $apiKey"
));

//Inject the curlClient into FinnClient
$client = new FinnClient($curlClient);
/*
	Then you can do a search with any query parameters for the 'realestate-homes'-resource
	Any of the property resources may be used here.
*/
$result = $client->search('realestate-homes', array(
	'orgId' => '',
	'page' => '',
	'rows' => '',
	'q' => 'bergen'
));

/*
	Or if you already know the id of the ad you want
	you can use the client this way to get just the ONE object
*/
$result = $client->getObject('realestate-homes', 48305632);

```



