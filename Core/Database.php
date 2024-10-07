<?php

namespace Core;
use PDO;
class Database
{
    public $connection;
    public $stm;
    public function __construct($config, $user = 'root', $password = 'root')
    {
        //        $dsn = "mysql:host=localhost;port=3306;password=root;user=root;dbname=demo;charset=utf8mb4";
        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $this->connection = new \PDO($dsn, $password, $user, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
    }
    public function query($query, $params = [])
    {
        $this->stm = $this->connection->prepare($query);
        $this->stm->execute($params);
        return $this;
    }

    public function get()
    {
        return $this->stm->fetchAll();
    }

    public function find()
    {
        return $this->stm->fetch();
    }
    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort();
        }
        return $result;
    }

    public function getPdo()
    {
        return $this->connection;
    }
}
