<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;

class Home extends Controller{
    
    
    public function index($a){
        echo 'Привет мир';
    }
    
    public function action(){
        
		$data = [
			'title' => 'Привет мир',
			'content' => 'Тут будет контент'
		];

		$this -> view -> make('admin/test', $data) -> render();

		
    }
    
    
    
    public function hello(){
    }
}
