<?php

require_once(__DIR__ . '/DI/DIContainer.php');


class Application
{
	protected $path;

	public $config;

	public $diContainer;

	protected $router;

	protected $controller;


	public function run()
	{
		$this->setEnv();
		$this->callControllerAction($this->path);
	}



	protected function setEnv()
	{
		$this->diContainer = DIContainer::getContainer();
		$this->config = $this->diContainer->getService('Config');
		$this->router = $this->diContainer->getService('Router');
		$this->path = $this->getPath();
	}


	protected function callControllerAction($path)
	{
		if( empty($path) )
		{
			return $this->diContainer->getService('DefaultController')->index();
		}
		elseif ( array_key_exists($path, $this->router->paths) )
		{
			$controller = $this->router->getControllerName($path);
			$action = $this->router->getActionName($path);

			return $this->diContainer->getService($controller)->$action();
		}
		else
		{
			throw new Exception('Action not found!', 404);
		}
	}


	protected function getPath()
	{
		$path = $_SERVER['REQUEST_URI'];
		$path = explode('?', $path)[0];  // Dont waste time with query string
		$path = trim($path, '/');
		$path = explode('/', $path);
		array_shift($path);  //  Remove directory name from path
		$path = join('/', $path);

		return $path;
	}

}