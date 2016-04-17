<?php namespace System;

abstract class Singleton{
    
    public static $instance = [];

    
    public static function getInstance() {
        
        $ClassName = get_called_class();
        if( class_exists($ClassName) ){
            
            if(!isset( self::$instance[$ClassName] )){
                self::$instance[$ClassName] = new $ClassName();
            }
            
            return self::$instance[$ClassName];
        }
        return false;
    }

    
    final private function __clone(){}
    private function __construct(){}
}