<?php namespace System;

class Alias
{
    public function __construct()
    {
        $classes = $this->classes();
        foreach ($classes as $key => $value) {
            class_alias($value, $key);
        }
    }

    private function classes()
    {
        return [
             'Route' => '\System\Route',
             'View' => '\System\View',
             'Request' => '\System\Request',
             //'Application' => '\System\Application',
        ];
    }
}
