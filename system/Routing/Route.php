<?php namespace System\Routing;

use Request;
use Response;
use System\Exception\NotFoundException;
use System\Exception\MethodFoundException;

class Route{

    // Храним все маршруты
    protected $routes = [];
    
    // Паттерны
    public $patterns = array(
		':any' => '[^/]+',
		':num' => '[0-9]+',
		':all' => '.*'
	);
    
    
    protected $groupAttr;
    
    protected $middleware;
    
    public function __construct() {
	}
    

    public function get($uri, $action)
    {
        $this->setRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->setRoute('POST', $uri, $action);
    }


    public function put($uri, $action)
    {
        $this->setRoute('PUT', $uri, $action);

    }

    public function patch($uri, $action)
    {
        $this->setRoute('PATCH', $uri, $action);

    }


    public function delete($uri, $action)
    {
        $this->setRoute('DELETE', $uri, $action);

    }

    public function options($uri, $action)
    {
        $this->setRoute('OPTIONS', $uri, $action);

    }
    
    
    public function group(array $attr, \Closure $callback){
        
        $groupAttr = $this -> groupAttr;
        
        if(isset($attr['middleware']) && is_array($attr['middleware'])){
            foreach($attr['middleware'] as $before){
                call_user_func_array($this -> middleware[$before], []);
            }
            
        }
        
        $this -> groupAttr = $attr;
        
        call_user_func($callback, $this);
        
        $this -> groupAttr = $groupAttr;

    }
    
    
    public function middleware($middleware, \Closure $callback){
        $this -> middleware[$middleware] = $callback;
    }
     
     
    protected function parseAction($action)
    {
        return $action;
    }
    
    protected function setRoute($method, $uri, $action)
    {
		
        $action = $this->parseAction($action);

		if(!$action instanceOf Closure){
            $action = $this -> addNamespace($action);
        }

        if (isset($this->groupAttr)) {
            if (isset($this->groupAttr['prefix'])) {
                $uri = trim($this->groupAttr['prefix'], '/').'/'.trim($uri, '/');
            }
        }
        
        $uri = $uri === '/' ? $uri : '/'.trim($uri, '/');
		
        $this->routes[$method.$uri] = [ 'method' => $method, 'action' => $action];
    }
    
    
    public function dispatch(){
        
		$request = new Request();
		
        if(is_array($this->routes)){
            
           
            $searches = array_keys($this -> patterns);
		    $replaces = array_values($this -> patterns);

            foreach($this->routes as $uri => $routes){
			
				if($request -> getMethod() != $routes['method']){
					continue;
				}
			
                if($uri == $routes['method'].$this -> getPathInfo()){
                    return $this -> call($routes['action'], $routes['method']);
                }
                
                if(strpos($uri, ':') !== false) {
                    $uri = str_replace($searches, $replaces, $uri);
                }
                
                if(preg_match('#^' . $uri . '$#', $routes['method'].$this -> getPathInfo(), $matched)) {
                    return $this -> call($routes['action'], $routes['method']);
                }
            }
        }
		
    }
  
  
  
    protected function callController($className, $methodController, $params)
    {

        $controller = new $className();
        
        if (! in_array(strtolower($methodController), array_map('strtolower', get_class_methods($controller)))) {
            throw new MethodFoundException($methodController, $controller);
        }
        
        call_user_func_array([$controller, $methodController], $params);

        return true;
    }
    
    
    protected function call($callback,$method, $params = array())
    {
		
        if (is_object($callback)) {
            call_user_func_array($callback, $params);
            return true;
        }

        list($controller, $methodController) = explode('@', $callback);

        if (class_exists($controller)) {
            
            return new Response($this -> callController($controller, $methodController, $params));
        }

        echo '3333';
    }
    

	protected function addNamespace($action)
    {
        if (isset($this->groupAttr['namespace']) && isset($action)) {
            $action = $this->groupAttr['namespace'].'\\'.$action;
        }

        return $action;
    }
	
	
	
    public function getPathInfo()
    {
        $query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

        return '/'.trim(str_replace('?'.$query, '', $_SERVER['REQUEST_URI']), '/');
    }
    
    public function show_404(){
        echo 'Страница не найдена';
    }

}