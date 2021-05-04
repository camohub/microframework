<?php


class ApiAuthService
{

	/** @var  SessionService */
	protected $sessionService;

	/** @var  Config */
	protected $config;


	public function __construct()
	{
		$di = DIContainer::getContainer();
		$this->sessionService = $di->getService('SessionService');
		$this->config = $di->getService('Config');
	}


	public function authenticate()
	{
		$time = time();
		$method = 'GET';
		$path = '/v1/user';
		$api = 'https://rest.websupport.sk';
		$query = ''; // query part is optional and may be empty
		$apiKey = $this->config->apiKey;
		$secret = $this->config->apiSecret;
		$canonicalRequest = sprintf('%s %s %s', $method, $path, $time);
		$signature = hash_hmac('sha1', $canonicalRequest, $secret);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s%s', $api, $path, $query));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $apiKey.':'.$signature);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Date: ' . gmdate('Ymd\THis\Z', $time),
		]);

		$response = curl_exec($ch);
		var_dump($response);
		curl_close($ch);
	}
}