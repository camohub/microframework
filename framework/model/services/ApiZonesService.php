<?php


class ApiZonesService extends ApiBaseService
{


	public function getAllZones()
	{
		$path = '/v1/user/self/zone';
		$query = '';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s%s', self::API_URL, $path, $query));

		$this->setBaseOptions($ch, $path, self::GET);

		$response = curl_exec($ch);

		return $this->createResponse($response, $ch);
	}

}