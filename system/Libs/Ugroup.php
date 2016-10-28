<?php namespace System\Libs;

use Config;
use System\Exception\BaseException;

class Ugroup {


	public function load(){
		
		$config = new Config();
		
		$uGroup = $config -> get('ugroup');
		
		if(!isset($uGroup[1])){
			$uGroup[1] = [
				'alias' => 'administrator',
				'name' => 'Администратор'
			];
			$uGroup[2] = [
				'alias' => 'client',
				'name' => 'Покупатель'
			];
			$uGroup[3] = [
				'alias' => 'editor',
				'name' => 'Редакторы'
			];
			$uGroup[4] = [
				'alias' => 'test',
				'name' => 'test'
			];
		}
		
		return $uGroup;
		

	// Initialize name according to current selected language
	//foreach ($UGROUP as $id => $v) {
		//$UGROUP[$id]['name'] = (isset($UGROUP[$id]['langName'][$config['default_lang']]))?$UGROUP[$id]['langName'][$config['default_lang']]:$UGROUP[$id]['identity'];
	//}
		
		
	}
	
	
	public function createOrEdit($data = []){
		
		
		if(!is_array($data)){
			$data = [];
		}
		
		
		
		
		$fcData = "<?php\n".'return '.var_export($save_con, true)."\n;?>";
		
		
		
	}
	
	
	

}