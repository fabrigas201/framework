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
	
	protected function validInteger($field, $value)
    {
        return filter_var($value, \FILTER_VALIDATE_INT) !== false;
    }
	
	
	protected function validEmail($value, $params = null){
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
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
					$method = 'valid'.ucfirst($rule);
					
					
					if (!method_exists($this, $method)) {
						throw new BaseException("Method {$rule} not found");
					}
					
					$response = call_user_func_array([$this, $method], [$input]);

					if($response === false){
						if(!isset($message[$rule])){
							$this -> errors[$field][] = 'Проверьте правильно ли заполнено поле '.$rules['name'];
						}else{
							$this -> errors[$field][] = sprintf($message[$rule], $rules['name']);
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
			//'alpha' => 'dd'
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