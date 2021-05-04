<?php


class BaseController
{

	public $di;


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
	}


	protected function setView($path, $data = [])
	{
		$basePath = $GLOBALS['application']->config->basePath;
		require_once(__DIR__ . '/../views/' . $path);
	}

}