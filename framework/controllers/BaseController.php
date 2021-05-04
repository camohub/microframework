<?php


class BaseController
{

	public $di;


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
	}


	/**
	 * Make variables available in template then include temlate file
	 */
	protected function setView($path, $data = [])
	{
		foreach ($data as $k => $v) $$k = $v;

		$di = $this->di;
		$sessionService = $this->di->getService('SessionService');
		$basePath = $this->di->getService('Config')->basePath;

		require_once(__DIR__ . '/../views/' . $path);
	}


	protected function redirect($location, $code = 0)
	{
		header('Location: ' . $location, $code);
	}

}