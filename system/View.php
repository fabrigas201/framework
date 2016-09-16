<?php namespace System;

class View {

	public $path;

	public $data = [];
    
    private $ext = '.php';
    

    public function make($main, $data = []){
		
		$main = '/'.trim($main, '/');

		$this -> path = APP . 'views' . $main . $this -> ext;
        $this -> data = array_merge($this->data, $data);
        return $this;
    }
    
    
    public function content($name, $path, $data = []){
        $this -> data[$name] = $this -> make($path, $data) -> render();
		return $this;
    }
    
    
	public function render() {
		ob_start();

		extract($this->data);

		require $this->path;

		return ob_get_clean();
	}

}