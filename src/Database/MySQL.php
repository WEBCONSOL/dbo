<?php

namespace Database;

final class MySQL implements Driver
{
    private $pdo = null;

    public function __construct(string $dsn, string $username, string $passwd, array $options) {
        $this->pdo = new \PDO($dsn, $username, $passwd, $options);
    }

    public function executeStatement($statement): bool {
        $stm = $this->pdo->query($statement);
        return $stm ? true : false;
    }

    public function loadResult($statement): array{
        $stm = $this->pdo->prepare($statement);
        $stm->execute();
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : array();
    }

    public function loadResults($statement): array {
        $stm = $this->pdo->prepare($statement);
        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : array();
    }

    public function tableColumns(string $name): array {
        $stm = $this->pdo->prepare('DESCRIBE '. $name);
        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_COLUMN);
        return $result ? $result : array();
    }

    public function tables(): array {
        $stm = $this->pdo->prepare('SHOW TABLES');
        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_COLUMN);
        return $result ? $result : array();
    }

    public function quote($str): string{return $this->pdo->quote($str);}

    public function getLastInsertId(){return $this->pdo->lastInsertId();}
}