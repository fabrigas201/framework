<?php namespace System;

use PDO;

class Database {
    
    private $settings;
    private $pdo;
    private $statement;
    
    
    public function __construct()
    {
        $config = new Config();
        $this -> settings = $config -> get('database');
        
        $dsn = 'mysql:dbname=' . $this->settings["database"] . ';host=' . $this->settings["host"] . '';
        try {
            $this->pdo = new \PDO($dsn, $this->settings["username"], $this->settings["password"],[
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->settings["charset"]
            ]);
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        }
        catch (PDOException $e) {
            echo $this->Exception($e->getMessage());
            die();
        }
    }
    
    public function prepare($sql) {
		$this->statement = $this->pdo->prepare($sql);
	}


    
    public function query($sql, $params = array()) {

		//$db = new DB;
			
		//$db -> query('INSERT INTO #_users_group (`name`, `permissions`) VALUES ("'.$_POST['groupName'].'", "")');
		
	
		$config = new Config();
		$prefix = $config -> get('database.prefix');
		
		if(stristr($sql, '#_') !== false){
			$sql = str_replace('#_', $prefix, $sql);
		}
		
		
		$this->statement = $this->pdo->prepare($sql);
		$result = false;

		try {
			if ($this->statement && $this->statement->execute($params)) {
				$data = array();

				while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
			}
		} catch (\PDOException $e) {
			trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
			exit();
		}

		if ($result) {
			return $result;
		} else {
			
			return;
		}
	}
}

