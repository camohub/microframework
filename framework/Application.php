<?php

require_once(__DIR__ . '/DI/DIContainer.php');


class Application
{
	protected $path;

	/** @var  Config */
	public $config;

	/** @var  DIContainer */
	public $di;

	/** @var  Router */
	protected $router;

	/** @var  SessionService */
	protected $sessionService;

	protected $controller;


	public function run()
	{
		$this->setEnv();
		$this->callControllerAction($this->path);
	}



	protected function setEnv()
	{
		$this->di = DIContainer::getContainer();
		$this->config = $this->di->getService('Config');
		$this->router = $this->di->getService('Router');
		$this->sessionService = $this->di->getService('SessionService');
		$this->path = $this->getPath();
	}


	protected function callControllerAction($path)
	{
		if( !array_key_exists($path, $this->router->paths) ) throw new Exception('Action not found!', 404);

		$controller = $this->router->getControllerName($path);
		$action = $this->router->getActionName($path);

		if( !$this->sessionService->get('login') && $controller != 'LoginController')  // Check name because LoginController::submit has not session set yet.
		{
			return $this->di->getService('LoginController')->index();
		}
		elseif( empty($path) )
		{
			return $this->di->getService('DefaultController')->index();
		}

		return $this->di->getService($controller)->$action();

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