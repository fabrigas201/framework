<?php namespace System;


class Hash {
    
    
    
    public function make($value)
    {

        $hash = password_hash($value, PASSWORD_BCRYPT);

        if ($hash === false) {
            throw new Exception('Bcrypt hashing not supported.');
        }

        return $hash;
    }
    

}