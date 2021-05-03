<?php


class Router
{

	public $paths = [
		'' => 'DefaultController@index',
		'aaa/bbb' => 'AController@bbb',
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
