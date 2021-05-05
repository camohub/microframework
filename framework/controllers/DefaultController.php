<?php

class DefaultController extends BaseController
{

	/** @var  ApiDnsService */
	protected $apiDnsService;

	/** @var  DomainValidator */
	protected $domainValidator;


	public function __construct()
	{
		parent::__construct();
		$this->apiDnsService = $this->di->getService('ApiDnsService');
		$this->domainValidator = $this->di->getService('DomainValidator');
	}


	public function index()
	{
		$this->setView('default/index.php', [
			'domains' => $this->config->domains,
			'validator' => $this->domainValidator,
		]);
	}


	public function showRecords()
	{
		$this->validateRequest();

		$domain = $this->domainValidator->get['domain'];

		$response = $this->apiDnsService->getAllRecords($domain);

		$this->setView('/default/showRecords.php', [
			'domain' => $domain,
			'response' => $response
		]);
	}


	public function showOneRecord()
	{
		$this->validateRequest();

		$domain = $this->domainValidator->get['domain'];
		$id = $this->domainValidator->get['id'];

		$response = $this->apiDnsService->getOneRecord($id, $domain);

		$this->setView('/default/showOneRecord.php', [
			'domain' => $domain,
			'response' => $response
		]);
	}


	public function createRecord()
	{
		$this->validateRequest();

		$domain = $this->domainValidator->get['domain'];

		$this->setView('/default/createRecord.php', [
			'domain' => $domain,
		]);
	}


	public function createRecordSubmit()
	{
		$this->validateRequest();

	}


	public function deleteRecord()
	{
		$this->validateRequest();

		// TODO remove redirect
		$this->sessionService->setFlash(join('<br>', ['aaaaaaaaaaaa', 'bbbbbbbbbbbbb']), 'danger');
		$this->redirect($this->config->basePath);

		$domain = $this->domainValidator->get['domain'];
		$id = $this->domainValidator->get['id'];

		$response = $this->apiDnsService->deleteRecord($id, $domain);

		if( isset($response->status) && $response->status == 'success' ) $this->sessionService->setFlash('Záznam bol zmazaný.');
		else $this->sessionService->setFlash('Pri mazaní záznamu došlo k chybe.', 'danger');

		$this->redirect("{$this->config->basePath}/show-records?domain=$domain");
	}



	////////////////////////////////////////////////////////////////////////////////////////////
	/// PROTECTED /////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	protected function validateRequest()
	{
		if( !$this->domainValidator->validate() )
		{
			$this->sessionService->setFlash(join('<br>', $this->domainValidator->errors), 'danger');
			$this->redirect($this->config->basePath);
		}
	}
}