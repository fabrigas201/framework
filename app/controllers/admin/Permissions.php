<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use DB;
use Config;
use System\Libs\Ugroup;
use System\Exception\NotFoundException;
class Permissions extends Controller{
    
    
	public function index(){
		
		$rules = [];
		$gropus = [];
		$request = new Request();
		$id = $request -> segment(3);
		
		
		$uGroup = new Ugroup;
		
		$uGroups = $uGroup -> load();
		
		if(!isset($uGroups[$id])){
			throw new NotFoundException;
		}
		
		
		if(!file_exists(APP.'config/permissions.php')){
			$permissions = config('permissions-copy');
		}else{
			$permissions = config('permissions');
		}
		

		
		if(is_array($permissions)){
			if(!isset($uGroups[$id])){
				echo 'Error';
				die();
			}
			
			if(!isset($permissions[$id])){
				$permissions[$id]['cms'] = config('permissions-default');
			}
			
			
			
			
			$table = '<table class="table table-borddered">';
			
			foreach($permissions[$id]['cms'] as $for => $rules){

				$table .= '<tr style="background:#eee">';
				$table .= '<th class="text-left">#</th>';
				$table .= '<th class="text-left"><b>'.$rules['title'].'</b> </th>';
				$table .= '<th class="text-right">Доступ</th>';
				$table .= '</tr>';
				
				
				if(is_array($rules['rules'])){
					foreach($rules['rules'] as $type => $rule){
						
						if($rule['rule'] == true){
							$rule['rule'] = '1';
							$input = '<input checked="checked" id="permissions['.$for.']['.$type.'][rule]" type="checkbox" value="'.$rule['rule'].'" name="permissions['.$for.'][rules]['.$type.'][rule]"/>';
						}else{
							$rule['rule'] = '2';
							$input = '<input id="permissions['.$for.']['.$type.'][rule]" type="checkbox" value="'.$rule['rule'].'" name="permissions['.$for.'][rules]['.$type.'][rule]"/>';
						}
						
						$table .= '<tr>';
						$table .= '<td class="text-left"><small>'.$type.'</small></td>';
						$table .= '<td class="text-left"><label style="font-weight:normal;" for="permissions['.$for.'][rules]['.$type.'][rule]"><small>'.$rule['title'].'</small></label></td>';
						$table .= '<td class="text-right">'.$input.'</td>';
						$table .= '</tr>';
					}
				}
			}
			
			$table .= '</table>';
			
		}
		
		
		$data = [
			'title' => 'Редактирование прав пользователей',
			'action' => get_url('admin/permissions/edit/'.$id),
			'table' => $table,
			'groupName' => $uGroups[$id]['name'],
			'groupAlias' => $uGroups[$id]['alias']
		];
		
		$this -> view -> make('admin/permissions/index', $data) -> render();
		
	}
	
	public function update(){
		$config = new Config();
		$request = new Request();
		$id = $request -> segment(3);
		
		
		if(!file_exists(APP.'config/permissions.php')){
			$permissions = config('permissions-copy');
		}else{
			$permissions = config('permissions');
		}

		$uGroup = new Ugroup;
		$uGroups = $uGroup -> load();
		
		if(!isset($uGroups[$id])){
			throw new NotFoundException;
		}
		
		
		if(!isset($permissions[$id])){
			$permissions[$id]['cms'] = config('permissions-default');
		}
	
		if(array_key_exists('permissions',$_POST)){
			foreach($permissions[$id]['cms'] as $type => $rules){
				if(is_array($rules['rules'])){
					foreach($rules['rules'] as $method => $rule){
						
						if(isset($_POST['permissions'][$type]['rules'][$method]['rule'] )){
							$_POST['permissions'][$type]['rules'][$method]['rule'] = true;
						}else{
							$_POST['permissions'][$type]['rules'][$method]['rule']  = false;
						}
						$permissions[$id]['cms'][$type]['rules'][$method]['rule'] = (bool)$_POST['permissions'][$type]['rules'][$method]['rule'] ;
					}
				}
			}
		}else{
			foreach($permissions[$id]['cms'] as $type => $rules){
				if(is_array($rules['rules'])){
					foreach($rules['rules'] as $method => $rule){
						$permissions[$id]['cms'][$type]['rules'][$method]['rule'] = false ;
					}
				}
			}
		}
		
		
		// Группы
		
		$uGroups[$id] = [
			'name' => e($_POST['groupName']),
			'alias' => e($_POST['groupAlias'])
		];
		
		$data = "<?php\n".'return '.var_export($uGroups, true)."\n;";
		
		$fileOpen = fopen(APP.'config/ugroup.php', 'w');
		if ($fileOpen) {
			fwrite($fileOpen, $data);
			fclose($fileOpen);
		}
		
		
		// Права
		//arsort($permissions);
		$data = "<?php\n".'return '.var_export($permissions, true)."\n;";

		$fileOpen = fopen(APP.'config/permissions.php', 'w');
		if ($fileOpen) {
			fwrite($fileOpen, $data);
			fclose($fileOpen);
		}

		return redirect('admin/permissions/edit/'.$id);
	}
}

