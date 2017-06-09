<?php

class Validator
{
	static $errors;

	public function __construct()
	{

	}

	function validationErrors()
	{
		return self::$errors;
	}

	
}