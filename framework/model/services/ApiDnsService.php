<?php


class ApiDnsService extends ApiBaseService
{

	public function getAllRecords($domain)
	{
		$path = "/v1/user/self/zone/$domain/record";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s', self::API_URL, $path));

		$this->setBaseOptions($ch, $path, self::GET);

		$response = curl_exec($ch);

		return $this->createResponse($response, $ch);
	}


	public function getOneRecord($id, $domain)
	{
		$path = "/v1/user/self/zone/$domain/record/$id";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s', self::API_URL, $path));

		$this->setBaseOptions($ch, $path, self::GET);

		$response = curl_exec($ch);

		return $this->createResponse($response, $ch);
	}


	public function createRecord($domain, $data)
	{
		$path = "/v1/user/self/zone/$domain/record";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s', self::API_URL, $path));

		$this->setBaseOptions($ch, $path, self::POST);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($ch);

		return $this->createResponse($response, $ch);
	}


	public function deleteRecord($id, $domain)
	{
		$path = "/v1/user/self/zone/$domain/record/$id";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, sprintf('%s%s', self::API_URL, $path));

		$this->setBaseOptions($ch, $path, self::DELETE);

		$response = curl_exec($ch);

		return $this->createResponse($response, $ch);
	}

}