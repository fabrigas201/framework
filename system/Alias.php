<?php namespace System;

class Alias
{
    public function __construct()
    {
        foreach ($this->classes() as $key => $value) {
            class_alias($value, $key);
        }
    }

    private function classes()
    {
        return [
			'Route' => '\System\Routing\Route',
			'View' => '\System\View',
			'Request' => '\System\Request',
			'Response' => '\System\Response',
			'Config' => '\System\Config',
			'DB' => '\System\Database',
			'Init' => '\System\Init',
        ];
    }
}
