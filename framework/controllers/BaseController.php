<?php


class BaseController
{

	protected function setView($path, $data)
	{
		require_once(__DIR__ . '/../views/' . $path);
	}

}