<?php


class SessionService
{

	public function set($key, $val)
	{
		$_SESSION[$key] = $val;
	}


	public function get($key)
	{
		return $_SESSION[$key];
	}


	public function forget($key)
	{
		unset($_SESSION[$key]);
	}


	public function setFlash($val, $type = 'success')
	{
		if (empty($_SESSION['flashes']) ) $_SESSION['flashes'] = [];

		$_SESSION['flashes'][] = [$val, $type];
	}


	public function getFlashes()
	{
		$flashes = $_SESSION['flashes'] ?? [];
		unset($_SESSION['flashes']);
		return $flashes;
	}
}