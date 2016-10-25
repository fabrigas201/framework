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
    
    public function insert($table, array $attributes){
        $config = new Config();
        $prefix = $config -> get('database.prefix');
        

        
        $fields = '(';
        $values = '(';
        foreach ($attributes as $k => $v)
        {
            if ($k != 'id')
            {
              $fields .= $k . ', ';
              $values .= ':' . $k . ', ';
            }
        }
        $fields = substr($fields, 0, -2) . ')';
        $values = substr($values, 0, -2) . ')';


        $sql = "INSERT INTO `".$prefix.$table."` ".$fields. " VALUES ". $values;
        
        $this -> pdo -> beginTransaction();
        
        try{
             $query = $this -> pdo -> prepare($sql);

            foreach ($attributes as $k => $v)
            {
              if ($k != 'id')
              {
                if (is_bool($v))
                  $query->bindValue(':' . $k, $v, \PDO::PARAM_BOOL);
                else
                  $query->bindValue(':' . $k, $v);
              }
            }
            $query->execute();
        }catch(Exception $e){
            echo $e -> getMessage();
            $this -> pdo -> rollback();
        }
        $this -> pdo -> commit();
    }

}

