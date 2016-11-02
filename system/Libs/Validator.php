<?php namespace System\Libs;

use Config;
use System\Exception\BaseException;

class Validator {

	private $rules;
	private $errors = [];
	
	
	
	public function __construct($rules){
		$this -> setRules($rules);
	}

	public function setRules($rules){
		if(!is_array($rules)){
			$rules = [];
		}
		$this -> rules = $rules;
	}
	
	public function getRules(){
		return $this -> rules;
	}
	
	
	protected function validRequired($value, $params = null)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        }
        return true;
    }
	
	
	protected function validAlpha($value, $params = null)
    {
        if(!empty($value) && !preg_match('/^[а-яА-ЯёЁa-zA-Z]+$/ui', $value)){
			return false;
		}
		return true;
    }
	
	
	protected function validNumeric($value, $params = null)
    {
        return is_numeric($value);
    }
	
	protected function validInteger($value)
    {
        return filter_var($value, \FILTER_VALIDATE_INT) !== false;
    }
	
	
	protected function validEmail($value, $params = null){
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	protected function validMin($value, $params)
    {
        return $params <= $this -> stringLength($value);
    }
	
	
	
	
	protected function stringLength($value)
    {
        if (!is_string($value)) {
            return false;
        } elseif (function_exists('mb_strlen')) {
            return mb_strlen($value);
        }
        return strlen($value);
    }
	
	
	
	public function check(){
		if(is_array($this -> rules)){
			
			$message = $this -> message();
			
			foreach($this -> rules as $field => $rules){
				
				$input = trim($_POST[$field]);
				
				if(!is_array($rules['rules'])){
					$rules['rules'] = [];
				}
				
				if(!isset($rules['name'])){
					$rules['name'] = '';
				}
				
				
				foreach($rules['rules'] as $rule){
					
					if (strripos($rule, ':') !== false) {
						$ruleAndParams = explode(':', $rule);
						$rule = $ruleAndParams[0];
						$param = $ruleAndParams[1];
						$callbackParams = [$input, $param];
					}else {
						$callbackParams = [$input];
						$param = '';
					}
					
					$method = 'valid'.ucfirst($rule);
					
					if (!method_exists($this, $method)) {
						throw new BaseException("Method {$method} not found");
					}

					$response = call_user_func_array([$this, $method], $callbackParams);

					if($response === false){
						if(!isset($message[$rule])){
							$this -> errors[$field][] = 'Проверьте правильно ли заполнено поле '.$rules['name'];
						}else{
							$this -> errors[$field][] = sprintf($message[$rule], $rules['name'], $param);
						}
					}
				}
			}
		}
		
		return count($this -> errors()) ? false : true;
	}
	
	
	protected function message(){
		return [
			'required' => 'Поле %s обязательно для заполнения',
			'email' => 'В поле %s введен не валидный Email',
			'alpha' => 'В поле %s введены запрещенные символы, разрешено [а-яА-ЯёЁa-zA-Z]',
			'min' => 'Значение %s поля должно быть больше %s'
		];
	}
	
	
	public function validated(){
		return $this -> check();
	}
	
	
	public function errors($field = null)
    {
        if ($field !== null) {
            return isset($this->errors[$field]) ? $this->errors[$field] : false;
        }
        return $this->errors;
    }
	
	
	
	
	
	
}