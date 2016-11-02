<?php



$route -> middleware('auth', function(){
    
});




$route -> group(['prefix'=> 'admin', 'middleware' => ['auth'], 'namespace' => 'App\\Controllers\\Admin'], function($route){
    $route -> get('users', 'Users@index');
	$route -> get('users/create', 'Users@create');
	$route -> post('users/create', 'Users@store');
	$route -> get('groups', 'Groups@index');
	$route -> get('groups/create', 'Groups@create');
	$route -> post('groups/create', 'Groups@store');
	//$route -> get('groups/delete/:num', 'Groups@delete');
	$route -> get('permissions/edit/:num', 'Permissions@index');
	$route -> post('permissions/edit/:num', 'Permissions@update');
	
});



$route -> group(['namespace' => 'App\\Controllers\\Web'], function($route){
    $route -> get('login', 'Auth@login');
});


