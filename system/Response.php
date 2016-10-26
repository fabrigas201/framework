<?php namespace System;


class Response{
    
	public $output;
	public $status = 200;
	public $headers = [];
    
    public function __construct($output, $status = 200, $headers = []) {
		$this->status = $status;
		$this->output = $output;
		

		foreach($headers as $name => $value) {
			$this->headers[strtolower($name)] = $value;
		}
	}
    

}