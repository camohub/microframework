<?php


class LoginController extends BaseController
{

	public static $sessKey = self::class;

	/** @var LoginService */
	protected $loginService;

	/** @var LoginValidator */
	protected $loginValidator;

	/** @var SessionService */
	protected $sessionService;


	public function __construct()
	{
		parent::__construct();
		$this->loginValidator = $this->di->getService('LoginValidator');
		$this->loginService = $this->di->getService('LoginService');
		$this->sessionService = $this->di->getService('SessionService');
	}


	public function index()
	{
		$this->setView('login/index.php', ['validator' => $this->loginValidator]);
	}


	public function submit()
	{
		if( ! $this->loginValidator->validate() )
		{
			$this->index();
			return;
		}

		$this->sessionService->set('login', TRUE);
		$this->sessionService->setFlash('Boli ste prihlásený');
		$this->redirect($this->di->getService('Config')->basePath);
	}
}