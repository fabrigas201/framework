<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;
use DB;
use Config;
use System\Auth;
use System\Libs\Ugroup;
use System\Libs\Validator;
class Users extends Controller{
    
    
	public function index(){
		
		$data = [
			'title' => 'Пользователи'
		];
		
		$this -> view -> make('admin/users/index', $data) -> render();
	}
	
	 
	public function create(){
       
		$uGroup = new Ugroup;
		$uGroups = $uGroup -> load();
		
		$data = [
            'title' => 'Добавление пользователя',
			'action' => get_url('admin/users/create'),
			'ugroups' => $uGroups
		];

       $this -> view -> make('admin/users/create', $data) -> render();
	}
   
   
	public function store(){
		
		$rules = [
			'email' => [
				'name' => 'Email',
				'rules' => ['required', 'email', 'alpha'],
			],
			'lastname' => [
				'name' => 'Фамилия',
				'rules' => ['alpha', 'required']
				
			]
		];
		
		$validator = new Validator($rules);
		
	   
	   
		if($validator -> validated()){
			echo 'Success';
		}else{
			dump($validator -> errors());
		}
	   
	   
	}
   
}

