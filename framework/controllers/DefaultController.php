<?php

class DefaultController extends BaseController
{

	public function index()
	{
		$this->setView('default/index.php', []);
	}


}