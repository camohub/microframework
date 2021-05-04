<?php


class DIContainer
{

	public static $selfSingleton = NULL;

	/**
	 * __construct calls require_once for all $baseServices.
	 */
	protected $baseServices = [
		'/baseConfig.php',
		'/controllers/BaseController.php',
		'/model/validators/BaseValidator.php',
	];


	/**
	 * This is the place where you should find all instances of app services.
	 */
	protected $services = [
		// App
		'Router' => '/router.php',
		'Config' => '/../config.php',

		// Controllers
		'DefaultController' => '/controllers/DefaultController.php',
		'LoginController' => '/controllers/LoginController.php',

		// Model
		'SessionService' => '/model/services/SessionService.php',
		'LoginService' => '/model/services/LoginService.php',
		'LoginValidator' => '/model/validators/LoginValidator.php',
	];


	public static function getContainer()
	{
		if( ! self::$selfSingleton ) self::$selfSingleton = new self();
		return self::$selfSingleton;
	}


	public function __construct()
	{
		foreach ($this->baseServices as $bS) require_once(__DIR__ . '/../' . $bS);
	}


	public function getService($name)
	{
		if( !array_key_exists($name, $this->services) ) throw new Exception('DIContainer error. Service name ' . $name . ' is not registerd.', 500);

		if( is_object($this->services[$name]) ) return $this->services[$name];


		require_once(__DIR__ . '/../' . $this->services[$name]);

		$this->services[$name] = new $name();
		return $this->services[$name];
	}

}