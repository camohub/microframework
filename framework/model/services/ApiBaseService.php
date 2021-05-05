<?php


class ApiBaseService
{

	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';

	const RECORD_TYPES = [
		'A', 'AAAA', 'MX', 'ANAME', 'CNAME', 'NS', 'TXT', 'SRV'
	];

	const API_URL = 'https://rest.websupport.sk';


	/** @var DIContainer */
	protected $di;

	/** @var  SessionService */
	protected $sessionService;

	/** @var  Config */
	protected $config;


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
		$this->sessionService = $this->di->getService('SessionService');
		$this->config = $this->di->getService('Config');
	}


	protected function setBaseOptions( &$ch, $path, $method = self::GET, $headers = [] )
	{
		$time = time();
		$apiKey = $this->config->apiKey;
		$secret = $this->config->apiSecret;
		$canonicalRequest = sprintf('%s %s %s', $method, $path, $time);
		$signature = hash_hmac('sha1', $canonicalRequest, $secret);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $apiKey.':'.$signature);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$headers[] = 'Date: ' . gmdate('Ymd\THis\Z', $time);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// localhost ssl check off
		if( !$this->config->production ) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}


	/**
	 * json_decode + curl_getinfo
	 */
	protected function createResponse($response, $ch, $addInfo = FALSE)
	{
		$response = json_decode($response);
		$info = curl_getinfo($ch);
		curl_close($ch);

		$response->code = $info['http_code'];
		if( $addInfo ) $response->curl_info = $info;  // Debug info

		return $response;
	}


	public function getAllTypes()
	{
		return self::RECORD_TYPES;
	}



}