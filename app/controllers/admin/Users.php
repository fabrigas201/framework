<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;
use DB;
use Config;
use System\Auth;
class Users extends Controller{
    
    
    public function __construct(){
        parent::__construct();
    }
    
    
   public function create(){
       
       $data = [
            'title' => 'Добавление пользователя',
            'content' => $this -> view -> make('users/create')-> render(),
       ];

       
       $auth = new Auth;
       
       dump($auth -> create(['name' => 'Имя', 'lastname' => 'Фамилия']));

       echo $this -> view -> make('main', $data) -> render();
   }
}

