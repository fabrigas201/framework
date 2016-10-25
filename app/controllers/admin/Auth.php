<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;

class Auth extends Controller{
    
    
   public function login(){
	   
		$data = [
		
		];
	   
		$this -> view -> make('default/login', $data);
   }
}

