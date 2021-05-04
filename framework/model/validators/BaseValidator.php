<?php


class BaseValidator
{
	protected $di;

	protected $post;

	protected $rawPost;

	public $errors = [];


	public function __construct()
	{
		$this->di = DIContainer::getContainer();
		$this->rawPost = $_POST;

		foreach ($_POST as $k => $v) $this->post[$k] = trim($v);
	}
}