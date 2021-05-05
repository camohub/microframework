<?php


class Router
{

	public $paths = [
		'' => 'DefaultController@index',
		'default/show-records' => 'DefaultController@showRecords',
		'default/show-record' => 'DefaultController@showOneRecord',
		'default/create-record' => 'DefaultController@createRecord',
		'default/create-record-submit' => 'DefaultController@createRecordSubmit',
		'default/delete-record' => 'DefaultController@deleteRecord',
		'login' => 'LoginController@index',
		'login/submit' => 'LoginController@submit',
		'logout' => 'LoginController@logout',
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
