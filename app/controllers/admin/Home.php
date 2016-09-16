<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use System\View;

class Home extends Controller{
    
    
	public $view;
	
	
    public function __construct(){
        parent::__construct();
		
		$this -> view = new View();
		
    }
    
    public function index($a){
        echo 'Привет мир';
    }
    
    public function action(){
        
		$data = [
			'title' => 'Привет мир'
		];

		echo $this -> view -> make('admin/main', $data) -> render();

		
    }
    
    
    
    public function hello(){
    }
}

