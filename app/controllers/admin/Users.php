<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;
use DB;
use Config;
use System\Auth;
class Users extends Controller{
    
    
	public function index(){
		
		$data = [
			'title' => 'Пользователи'
		];
		
		$this -> view -> make('admin/users/index', $data) -> render();
	}
	
	public function groups(){
		
		$data = [
			'title' => 'Группы пользователей'
		];
		
		$this -> view -> make('admin/users/groups', $data) -> render();
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

