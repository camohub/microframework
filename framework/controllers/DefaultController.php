<?php

class DefaultController extends BaseController
{

	/** @var  ApiDnsService */
	protected $apiDnsService;

	/** @var  DomainValidator */
	protected $domainValidator;

	/** @var  DnsRecordValidator */
	protected $dnsRecordValidator;


	public function __construct()
	{
		parent::__construct();
		$this->apiDnsService = $this->di->getService('ApiDnsService');
		$this->domainValidator = $this->di->getService('DomainValidator');
		$this->dnsRecordValidator = $this->di->getService('DnsRecordValidator');
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
		$this->validateRecord();

		$domain = $this->domainValidator->get['domain'];
		$data = $this->dnsRecordValidator->post;

		$this->apiDnsService->createRecord($domain, $data);

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

	protected function validateRecord()
	{
		if( !$this->dnsRecordValidator->validate() )
		{
			// Session for redirect
			$this->sessionService->set(DnsRecordValidator::SESS_ERRORS_KEY, $this->dnsRecordValidator->errors);
			$this->sessionService->set(DnsRecordValidator::SESS_POST_KEY, $this->dnsRecordValidator->post);

			$basePath = $this->config->basePath;
			$domain = $this->domainValidator->get['domain'];
			$this->redirect("$basePath/default/create-record?domain=$domain");
		}
	}
}