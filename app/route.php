<?php
$route = new Route();


$route -> middleware('auth', function(){
    
});




$route -> group(['prefix'=> 'admin', 'middleware' => ['auth'], 'namespace' => 'App\\Controllers\\Admin'], function($route){
    $route -> get('home/:num', 'Home@action');
    $route -> get('login', 'Auth@login');
    $route -> get('users/create', 'Users@create');
    
});


$route -> get('hello', 'Home@hello');


$route -> get('index', function(){
    echo 'index';
});


$route -> get('', function(){
    echo 'Главная страница';
});

$route -> dispatch();