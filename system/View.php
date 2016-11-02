<?php namespace System;

use Config;
use Fenom;
use System\Exception\BaseException;
use System\Libs\Flash;
class View {

	public $path;
	public $data = [];
    private $ext = '.php';
    private $template;
	

	public function __construct(){
		
		$this -> config = new Config();
		
		if(!is_dir(THEME.'/'.$this -> config -> get('config.theme'))){
			throw new BaseException( sprintf('Директории %s не существует', str_replace('\\', '/', THEME.'/'.$this -> config -> get('config.theme'))));
			return;
		}

		$this -> template = new Fenom(new Fenom\Provider(str_replace('\\', '/', THEME.'/'.$this -> config -> get('config.theme'))));
		
	}
	

    public function make($main, $data = []){
		
		if(!is_dir(APP.'/'.$this -> config -> get('config.cache_theme'))){
			throw new \BaseException( sprintf('Директории %s не существует', str_replace('\\', '/', APP.'/'.$this -> config -> get('config.cache_theme'))));
			return;
		}
		
		
		$this -> template -> setCompileDir(str_replace('\\', '/', APP.'/'.$this -> config -> get('config.cache_theme')));
		
		if(defined('ENVIRONMENT') && ENVIRONMENT === 'DEVELOPER'){
			$this -> template -> setOptions([
				'auto_reload' => true,
				'force_compile' => true
			]);
		}else{
			$this -> template -> setOptions([
				'auto_reload' => false,
				'force_compile' => false
			]);
		}
		
		
		$main = '/'.trim($main, '/');

		$this -> path =  $main . $this -> ext;
        $this -> data = array_merge($this->data, $data);
		
		
        return $this;
    }
    
    
    public function content($name, $path, $data = []){
        $this -> data[$name] = $this -> make($path, $data) -> render();
		return $this;
    }
    
    
	public function render() {
		// ob_start();
		// extract($this->data);
		// require $this->path;
		// return ob_get_clean();
		
		return $this -> template -> display($this -> path, $this -> data);
	}

}