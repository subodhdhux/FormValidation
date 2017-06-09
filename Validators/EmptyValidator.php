<?php
//include_once('Validator.php');

class EmptyValidator
{
	private $message = "This %s is required";
	
	public function validate($value)
	{
		if(empty($value))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}

}