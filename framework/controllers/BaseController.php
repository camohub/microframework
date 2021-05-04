<?php


class BaseController
{

	/** @var DIContainer  */
	public $di;

	/** @var Config  */
	protected $config;

	/** @var SessionService  */
	protected $sessionService;

	/** @var ApiAuthService */
	protected $apiAuthService;


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
		$this->config = $this->di->getService('Config');
		$this->sessionService = $this->di->getService('SessionService');
		$this->apiAuthService = $this->di->getService('ApiAuthService');

		if( $this->sessionService->get('login') )
		{
			$this->apiAuthService->authenticate();
		}
	}


	/**
	 * Make variables available in template then include temlate file
	 */
	protected function setView($path, $data = [])
	{
		foreach ($data as $k => $v) $$k = $v;

		$di = $this->di;
		$sessionService = $this->sessionService;
		$basePath = $this->config->basePath;

		require_once(__DIR__ . '/../views/' . $path);
	}


	protected function redirect($location, $code = 0)
	{
		header('Location: ' . $location, $code);
	}

}