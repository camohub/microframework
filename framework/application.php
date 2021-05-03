<?php


require_once(__DIR__ . '/router.php');


class Application
{
	protected $path;

	protected $router;

	protected $controller;


	public function __construct()
	{
		$this->setEnv();
	}


	public function run()
	{
		$data = $this->getControllerData();
		var_dump($data);
	}



	protected function setEnv()
	{
		$this->router = new Router();
		$this->path = $this->getPath();
	}


	protected function getControllerData()
	{
		if( empty($this->path) )
		{
			require_once(__DIR__ . '/controllers/DefaultController.php');
			return new DefaultController();
		}
		elseif ( !array_key_exists($this->path, $this->router->paths) )
		{
			throw new Exception('Action not found!', 404);
		}
		else
		{
			$controller = $this->router->getControllerName($this->path);
			$action = $this->router->getActionName($this->path);

			require_once(__DIR__ . '/controllers/' . $controller . '.php');

			return (new $controller())->$action();
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