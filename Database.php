<?php

class Database
{
    public $connection;
    public function __construct($config, $password = 'root', $user='root')
    {
//        $dsn = "mysql:host=localhost;port=3306;password=root;user=root;dbname=demo;charset=utf8mb4";
        $dsn = 'mysql:'.http_build_query($config, '',';');
        $this->connection = NEW PDO($dsn, $password, $user,[
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    }
    public function query($query, $params =[])
    {
        $stm =$this->connection->prepare($query);
        $stm->execute($params);
        return $stm;
    }
}