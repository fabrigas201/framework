<?php namespace App\Controllers\Web;

use System\Controller;
use System\Request;
use System\Hash;

class Auth extends Controller{
    
    
   public function login(){
		$data = [
			'title' => 'Remaller Network'
		];
	   
		$this -> view -> make('web/login', $data) -> render();
   }
}

