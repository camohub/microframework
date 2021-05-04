<?php


class LoginController extends BaseController
{

	public static $sessKey = self::class;

	/** @var LoginValidator */
	protected $loginValidator;

	/** @var SessionService */
	protected $sessionService;


	public function __construct()
	{
		parent::__construct();
		$this->loginValidator = $this->di->getService('LoginValidator');
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


	public function logout()
	{
		$this->sessionService->forget('login');
		$this->sessionService->setFlash('Boli ste odhlásený.');
		$this->redirect($this->di->getService('Config')->basePath);
	}
}