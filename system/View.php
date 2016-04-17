<?php namespace System;

class View {

	public $path;

	public $data = [];
    
    private $ext = '.html';
    

    public function make($view, $data = []){
		$this -> path = APP . 'views/' . $view . $this -> ext;
		$this -> data = array_merge($this->data, $data);
        return $this;
    }
    
    
	public function render() {
		ob_start();

		extract($this->data);

		require $this->path;

		return ob_get_clean();
	}

}