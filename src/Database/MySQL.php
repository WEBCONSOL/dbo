<?php

namespace Database;

class MySQL implements Driver
{
    private $pdo = null;

    public function __construct(string $dsn, string $username, string $passwd, array $options)
    {
        $this->pdo = new \PDO($dsn, $username, $passwd, $options);
    }

    public function executeStatement($statement){}

    public function loadResult($statement){}

    public function loadResults($statement){}

    public function getLastInsertId(){}
}