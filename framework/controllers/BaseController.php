<?php


class BaseController
{

	protected function setView($path, $data = [])
	{
		$basePath = $GLOBALS['application']->config->basePath;
		require_once(__DIR__ . '/../views/' . $path);
	}

}