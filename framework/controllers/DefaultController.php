<?php

class DefaultController extends BaseController
{

	/** @var  ApiZonesService */
	protected $ApiZonesService;


	public function __construct()
	{
		parent::__construct();
		$this->apiAuthService = $this->di->getService('ApiZonesService');
	}


	public function index()
	{
		$response = $this->apiAuthService->getAllZones();

		$this->setView('default/index.php', ['response' => $response]);
	}


}