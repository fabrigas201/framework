<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;

class Auth extends Controller{
    
    
    public function __construct(){
        parent::__construct();
    }
    
   public function login(){
       $result = $this -> view -> make('login');
       echo $result -> render();
   }
}

