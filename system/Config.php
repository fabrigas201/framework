<?php namespace System;


class Config
{

    private static $config = [];


    public static function get($key = null, $default = null)
    {
		$keys = explode('.', $key);

		if( ! array_key_exists($file = current($keys), self::$config)) {
			if(is_readable($path = APP . 'config' . DS .  $file . EXT)) {
				self::$config[$file] = require $path;
			}
		}

		return self::parse($key);
    }
    
    
    
    protected static function parse($key)
    {
        $values = self::$config;
        $parts = explode(".", $key);
        foreach ($parts as $part){
            if ($part === "") {
                return $values;
            }
            if (!is_array($values) || !array_key_exists($part, $values)) {
                return ;
            }
            $values = $values[$part];
        }
        return $values;
    }
}


