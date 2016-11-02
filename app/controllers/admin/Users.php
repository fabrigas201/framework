<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;
use DB;
use Config;
use System\Auth;
use System\Libs\Flash;
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
				'rules' => ['required', 'email'],
			],
			'lastname' => [
				'name' => 'Фамилия',
				'rules' => ['alpha', 'required', 'min:2']
				
			]
		];
		
		$validator = new Validator($rules);
		
	   
	   
		if($validator -> validated()){
			Flash::success('Пользователь добавлен');
			redirect('/admin/users/create');
		}else{
			Flash::error('Ошибка добаления пользователя');
			redirect('/admin/users/create');
		}
	   
	   
	}
   
}

