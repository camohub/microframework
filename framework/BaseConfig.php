<?php


class BaseConfig
{

	protected $values = [];


	public function __get( $key )
	{
		if( !array_key_exists($key, $this->values) ) throw new Exception('Config error. key ' . $key , ' is missing.', 500);
		return $this->values[$key];
	}

}
