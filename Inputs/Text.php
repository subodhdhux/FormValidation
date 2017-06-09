<?php

include_once('./validators/Validator.php');               
include_once('./Libs/ValidatorsFactory.php');

class Text extends Validator
{
	private $name, $attrs;
	public $rules, $error;
	
	function __construct($name, $attrs)
	{
		$this->name = $name;
		$this->attrs = $attrs;
		parent::__construct();
	}

	function render()
	{
		$name = $this->name;
		$html = sprintf("<input type='text' name='%s' ", $name);
		$attrs = $this->attrs;

		if(!empty($attrs))
		{
			foreach($attrs as $k => $v)
			{
				if(is_numeric($k))
				{
					$html.= sprintf(" %s ", $v);
				}
				else
				{
					$html.= sprintf(" %s=%s ", $k, $v);
				}
			}
		}

		$html.= '>';

		return $html;
	}

	function addValidator( $validator, $message = "")
	{
		if(is_array($validator))
		{
			if(!empty($validator))
			{
				$validators = (array) $this->rules;
				$this->rules = array_merge($validators, $validator);
			}
		}
		else
		{
			$rule = array($validator =>  $message);
			$validators = (array) $this->rules;
			$this->rules = array_merge($validators, $rule);
		}

		return $this;
	}

	function valid__old()
	{
		if(!empty($this->rules))
		{
			foreach($this->rules as $validator => $message)
			{

				$validatorObj = new ValidatorsFactory($validator);
				$obj = $validator.'-obj';
				$className = $validator.'Validator';
				$classFile = $validator.'Validator'.'.php';
				$path = './Validators/'.$classFile;

				if(file_exists($path))
				{
					include_once($path);
					$obj = new $className;

					if($obj->validate($_POST[$this->name]))
					{
						return true;
					}
					else
					{
						if(!empty($message))
						{
							$this->error = $message;
							$this->errors[$this->name] = $message;
						}
						else
						{
							$this->error = sprintf( $obj->getMessage(), $this->name);
							$this->errors[$this->name][] = sprintf($obj->getMessage(), $this->name);
						}
					}
				}
				
			}
		}
		else
		{
			return true;
		}
	}


	function valid()
	{
		if(!empty($this->rules))
		{
			foreach($this->rules as $validator => $message)
			{
				$validatorsFactory = new ValidatorsFactory($validator);
				$validator = $validatorsFactory->createObj();

				if($validator != null)
				{
					if($validator->validate($_POST[$this->name]))
					{
						return true;
					}
					else
					{
						if(!empty($message))
						{
							$this->error = $message;
							$this::$errors[$this->name] = $message;
						}
						else
						{
							$this->error = sprintf( $validator->getMessage(), $this->name);
							$this::$errors[$this->name] = sprintf($validator->getMessage(), $this->name);
						}
					}
				}
			}
		}
		else
		{
			return true;
		}
	}


	function validationError()
	{
		return $this->error;
	}
}