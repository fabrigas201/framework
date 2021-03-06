<?php namespace App\Controllers\Admin;

use System\Controller;
use System\Request;
use DB;
use Config;
use System\Auth;
use System\Libs\Ugroup;
use System\Exception\NotFoundException;
class Groups extends Controller{
    
    
	public function index(){
		
		$uGroup = new Ugroup;
		$uGroups = $uGroup -> load();
		
		$data = [
			'title' => 'Группы пользователей',
			'ugroups' => $uGroups
		];
		
		$this -> view -> make('admin/groups/index', $data) -> render();
	}
	
	public function create(){

		$data = [
			'title' => 'Добавить группу'
		];
		
		$this -> view -> make('admin/groups/create', $data) -> render();
	}

	public function store(){
		$newGroup = [];
		
		$config = new Config();
		$uGroup = new Ugroup;
		$uGroups = $uGroup -> load();
		
		$count = sizeof($uGroups);
		
		$newGroup[$count+1] = [
			'name' => $_POST['groupName'],
			'alias' => $_POST['groupAlias']
		];
		
		$uGroups += $newGroup;
		
		$data = "<?php\n".'return '.var_export($uGroups, true)."\n;";

		$fileOpen = fopen(APP.'config/ugroup.php', 'w');
		if ($fileOpen) {
			fwrite($fileOpen, $data);
			fclose($fileOpen);
		}
		
		return redirect('admin/groups/create');
	}
}

