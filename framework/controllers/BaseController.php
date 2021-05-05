<?php


class BaseController
{

	/** @var DIContainer  */
	public $di;

	/** @var Config  */
	protected $config;

	/** @var SessionService  */
	protected $sessionService;


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
		$this->config = $this->di->getService('Config');
		$this->sessionService = $this->di->getService('SessionService');
	}


	/**
	 * Make variables available in template then include template file
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
		$url = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$url .= $_SERVER['HTTP_HOST'] . $location;
		header("Location: $url", $code);
		exit();
	}

}