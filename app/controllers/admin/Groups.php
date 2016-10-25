<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\Hash;
use DB;
use Config;
use System\Auth;
class Groups extends Controller{
    
    
	public function index(){
		
		$data = [
			'title' => 'Группы пользователей'
		];
		
		$this -> view -> make('admin/groups/index', $data) -> render();
	}
	
	public function create(){
		
		$data = [
			'title' => 'Добавить группу'
		];
		
		$this -> view -> make('admin/groups/create', $data) -> render();
	}
	
	public function store(){
		return 'Method POST';
	}
}

