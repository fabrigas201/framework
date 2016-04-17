<?php namespace App\Controllers;

use System\Controller;
use System\Request;


class Home extends Controller{
    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index($a){
        echo 'Привет мир';
    }
    
    public function action(){
        $request = new Request();
        
        $result = $this -> view -> make('default/aboutus', []) ;
        echo $result -> render();
    }
    
    
    
    public function hello(){
        $request = new Request();
        
        $result = $this -> view -> make('default/aboutus', []) ;
        echo $result -> render();
    }
}

