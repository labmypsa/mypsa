<?php

Session::logged();

/**
* 
*/
class ErrorController
{
	
	public function __construct()
	{
		$this->name="error";
		$this->title="Error";
		$this->subtitle="Bitácora";		
		$this->model = [];    
	}
	public function error_403(){
		include view($this->name.'.403');
	}

	public function error_404(){
		include view($this->name.'.404');
	}

	public function error_412(){
		include view($this->name.'.412');
	}	

}