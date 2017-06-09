<?php
class ValidatorsFactory{

	private $className;
	private $classFile;
	private $filePath;

	public function __construct($validator)
	{
		$this->className = $validator.'Validator';
		$this->classFile = $validator.'Validator'.'.php';
		$this->filePath = './Validators/'.$this->classFile;

	}

	public function createObj()
	{
		if(file_exists($this->filePath))
		{
			include_once($this->filePath);
			return new $this->className;
		}
		else
		{
			return null;
		}
	}

}