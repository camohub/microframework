<?php


class BaseValidator
{
	protected $di;

	protected $get;

	protected $post;

	protected $rawGet;

	protected $rawPost;

	public $errors = [];


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
		$this->rawPost = $_POST;
		$this->rawGet = $_GET;

		foreach ($_POST as $k => $v) $this->post[$k] = trim($v);
		foreach ($_GET as $k => $v) $this->get[$k] = trim($v);
	}


	public function __get($key)
	{
		if( !isset($this->$key) ) throw new Exception('Parameter does not exist in BaseValidator.', 500);

		return $this->$key;
	}
}