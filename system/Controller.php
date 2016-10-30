<?php namespace System;

use System\Libs\Permission;

abstract class Controller {
	

    public $view;
	
	public function __construct() {
		$this -> view = new View();
	}
}
