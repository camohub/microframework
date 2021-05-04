<?php


class BaseValidator
{
	protected $diContainer;

	protected $post;

	protected $rawPost;


	public function __construct(DIContainer $diContainer)
	{
		$this->diContainer = $diContainer;
		$this->rawPost = $_POST;

		foreach ($_POST as $k => $v) $_POST[$k] = trim($v);
	}
}