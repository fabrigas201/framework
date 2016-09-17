<?php namespace System;


use System\Request;
use System\Hash;
use DB;


class Auth {
    
    
    private $attributes = [];
    
    
    public function create(array $attributes){
        $db = new DB;
        
        $this -> attributes = $attributes;
        
        
        if(!isset($attributes['created_at'])){
            $attributes['created_at'] = date('Y-m-d H:i:s');
        }
        
        if(!isset($attributes['updated_at'])){
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }
        
        
       $this -> attributes = array_merge($this -> attributes, $attributes);
        
       dump($this -> attributes);
        
        
       return $db -> insert('users', $this -> attributes);
        
        
    }
}

