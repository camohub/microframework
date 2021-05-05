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

		$response = $this->apiDnsService->createRecord($domain, $data);

		if( isset($response->errors) && get_object_vars($response->errors) )  // Has to be cast to array for empty test.
		{
			$errors = [];
			foreach ($response->errors as $key => $msg) $errors[$key] = join('<br>', $msg);

			$this->sessionService->set(DnsRecordValidator::SESS_ERRORS_KEY, $errors);
			$this->sessionService->set(DnsRecordValidator::SESS_POST_KEY, $data);

			$basePath = $this->config->basePath;
			$this->redirect("$basePath/default/create-record?domain=$domain");
		}

		if( $response->code < 300 ) $this->sessionService->setFlash('Záznam bol uložený.');
		else $this->sessionService->setFlash('Pri ukladaní záznamu došlo k chybe.', 'danger');

		$basePath = $this->config->basePath;
		$this->redirect("$basePath/default/show-records?domain=$domain");
	}


	public function updateRecord()
	{
		$this->validateRequest();

		$domain = $this->domainValidator->get['domain'];
		$id = $this->domainValidator->get['id'];

		$response = $this->apiDnsService->getOneRecord($id, $domain);

		$this->setView('/default/updateRecord.php', [
			'domain' => $domain,
			'id' => $response->id,
			'type' => $response->type,
			'recordData' => $response,
		]);
	}


	public function updateRecordSubmit()
	{
		$this->validateRequest();
		$this->validateRecord(TRUE);

		$id = $this->domainValidator->get['id'];
		$domain = $this->domainValidator->get['domain'];
		$data = $this->dnsRecordValidator->post;

		$response = $this->apiDnsService->updateRecord($id, $domain, $data);

		if( isset($response->errors) && get_object_vars($response->errors) )  // Has to be cast to array for empty test.
		{
			$errors = [];
			foreach ($response->errors as $key => $msg) $errors[$key] = join('<br>', $msg);

			$this->sessionService->set(DnsRecordValidator::SESS_ERRORS_KEY, $errors);
			$this->sessionService->set(DnsRecordValidator::SESS_POST_KEY, $data);

			$basePath = $this->config->basePath;
			$this->redirect("$basePath/default/update-record?domain=$domain&amp;id=$id");
		}

		if( $response->code < 300 ) $this->sessionService->setFlash('Záznam bol uložený.');
		else $this->sessionService->setFlash('Pri ukladaní záznamu došlo k chybe.', 'danger');

		$this->sessionService->set('a', $response);

		$basePath = $this->config->basePath;
		$this->redirect("$basePath/default/show-records?domain=$domain");


	}


	public function deleteRecord()
	{
		$this->validateRequest();

		$domain = $this->domainValidator->get['domain'];
		$id = $this->domainValidator->get['id'];

		$response = $this->apiDnsService->deleteRecord($id, $domain);

		if( isset($response->status) && $response->status == 'success' ) $this->sessionService->setFlash('Záznam bol zmazaný.');
		else $this->sessionService->setFlash('Pri mazaní záznamu došlo k chybe.', 'danger');

		$this->redirect("{$this->config->basePath}/default/show-records?domain=$domain");
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

	protected function validateRecord($update = FALSE)
	{
		if( !$this->dnsRecordValidator->validate() )
		{
			// Session for redirect
			$this->sessionService->set(DnsRecordValidator::SESS_ERRORS_KEY, $this->dnsRecordValidator->errors);
			$this->sessionService->set(DnsRecordValidator::SESS_POST_KEY, $this->dnsRecordValidator->post);

			$basePath = $this->config->basePath;
			$id = $this->domainValidator->get['id'] ?? NULL;
			$domain = $this->domainValidator->get['domain'];
			$url = $update
				? "$basePath/default/update-record?domain=$domain&id=$id"
				: "$basePath/default/create-record?domain=$domain";
			$this->redirect($url);
		}
	}
}