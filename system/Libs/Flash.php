<?php namespace System\Libs;

use System\Exception\BaseException;

class Flash {
    const SESSION_KEY = 'remaller_flash';

	
	private static $template = '<div class="box-body"><div class="%s">%s</div></div>';
	
    private static $_flashdata = array();
	
	public static function error($message){
		self::set('error', $message);
	}
	public static function warning($message){
		self::set('warning', $message);
	}
	public static function success($message){
		self::set('success', $message);
	}
	public static function info($message){
		self::set('info', $message);
	}

	
	public static function display($type){
		if(self::get($type)){
			if(in_array($type, ['error', 'warning', 'success', 'info'])){
				$block = sprintf(self::$template, 'alert alert-'.$type.' alert-dismissible', self::get($type));
			}else{
				$block = self::get($type);
			}
			return $block;
		}
		return;
	}
	
	

    public static function get($var) {
        return isset(self::$_flashdata[$var]) ? self::$_flashdata[$var] : null;
    }

    public static function set($var, $value) {
        $_SESSION[self::SESSION_KEY][$var] = $value;
    }

    public static function setNow($var, $value) {
        self::$_flashdata[$var] = $value;
    }

    public static function clear() {
        $_SESSION[self::SESSION_KEY] = array();
    }

    public static function init() {
       
		if (!empty($_SESSION[self::SESSION_KEY]) && is_array($_SESSION[self::SESSION_KEY])) {
            self::$_flashdata = $_SESSION[self::SESSION_KEY];
        }
        $_SESSION[self::SESSION_KEY] = [];
    }
}