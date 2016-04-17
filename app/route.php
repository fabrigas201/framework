<?php
$route = new Route();


$route -> middleware('auth', function(){
    return 'Привет мир из middleware <br>';
});



/*

$route -> group(['group' => 'admin'], function(){
    echo 'Hello, world 1';
});

*/




$route -> group(['middleware' => ['auth']], function($route){
    $route -> get('home/:num', 'Home@action');
    
});


$route -> get('hello', 'Home@hello');


$route -> get('index', function(){
    echo 'index';
});


$route -> get('', function(){
    echo 'Главная страница';
});

$route -> dispatch();