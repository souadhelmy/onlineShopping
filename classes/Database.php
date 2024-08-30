<?php 

namespace OnlineShoping\Databases;
use PDO;
use PDOException;

class Database{
    private $dsn;
    private $dbname = 'online_shop';
    private $host = 'localhost';
    private $user = 'root';
    private $charset = 'utf8mb4';
    private $pass = '';
    private $pdo;
    private $options;
    private $error;

    public function __construct()
    {
        $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{
            $this->pdo = new PDO($this->dsn , $this->user , $this->pass , $this->options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo "connection error".$this->error;
        }
    }

    public function getConnection(){
        return $this->pdo;
    }

}

?>