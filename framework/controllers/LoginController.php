<?php


class LoginController extends BaseController
{

	protected $loginService;


	public function __construct()
	{
		parent::__construct();
		$this->loginService = $this->di->getService('LoginService');
	}


	public function index()
	{
		$this->setView('login/index.php', []);
	}


	public function submit()
	{

		$this->loginService->login();
	}
}