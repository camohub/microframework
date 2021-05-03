<?php


require_once(__DIR__ . '/router.php');
require_once(__DIR__ . '/controllers/BaseController.php');


class Application
{
	protected $path;

	protected $router;

	protected $controller;


	public function run()
	{
		$this->setEnv();
		$this->callControllerAction($this->path);
	}



	protected function setEnv()
	{
		$this->router = new Router();
		$this->path = $this->getPath();
	}


	protected function callControllerAction($path)
	{
		if( empty($path) )
		{
			require_once(__DIR__ . '/controllers/DefaultController.php');
			return (new DefaultController())->index();
		}
		elseif ( array_key_exists($path, $this->router->paths) )
		{
			$controller = $this->router->getControllerName($path);
			$action = $this->router->getActionName($path);

			require_once(__DIR__ . '/controllers/' . $controller . '.php');

			return (new $controller())->$action();
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