<?php


class Router
{

	public $paths = [
		'' => 'DefaultController@index',
		'login' => 'LoginController@index',
		'login/submit' => 'LoginController@submit',
	];


	public function getControllerName($key)
	{
		return explode('@', $this->paths[$key])[0];
	}

	public function getActionName($key)
	{
		return explode('@', $this->paths[$key])[1];
	}

}
