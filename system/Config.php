<?php namespace System;


class Config
{

    private $config = [];


    public function get($key = null, $default = null)
    {
		$keys = explode('.', $key);

		if( ! array_key_exists($file = current($keys), $this -> config)) {
			if(is_readable($path = APP . 'config' . DS .  $file . EXT)) {
				$this -> config[$file] = require $path;
			}
		}

		return $this -> parse($key);
    }
    
    
    
    protected function parse($key)
    {
        $values = $this -> config;
        $parts = explode(".", $key);
        foreach ($parts as $part) {
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


