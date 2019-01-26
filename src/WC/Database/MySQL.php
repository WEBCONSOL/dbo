<?php

namespace WC\Database;

use WC\Models\ListModel;

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

    public function select(ListModel $argc): array {
        $statement = $this->prepareSelectStatement($argc);
        return $statement ? $this->loadResults($statement) : array();
    }

    public function selectOne(ListModel $argc): array {
        $statement = $this->prepareSelectStatement($argc);
        return $statement ? $this->loadResult($statement) : array();
    }

    public function quote(string $str): string{return $this->pdo->quote($str);}

    public function name(string $str): string{return '`'.$str.'`';}

    public function getLastInsertId(){return $this->pdo->lastInsertId();}

    private function prepareSelectStatement(ListModel $argc): string {
        $statement = '';
        if ($argc->has(SQL_TB)) {
            $fields = $argc->get(SQL_FIELDS, '*');
            $condition = $argc->get(SQL_CONDITIONS, '1');
            $orderby = $argc->has(SQL_ORDER_BY) ? ' ORDER BY ' . $argc->get(SQL_ORDER_BY) : '';
            $groupby = $argc->has(SQL_GROUP_BY) ? ' GROUP BY ' . $argc->get(SQL_GROUP_BY) : '';
            $limit = $argc->has(SQL_LIMIT_START) && $argc->has(SQL_LIMIT_END) ? ' LIMIT ' . $argc->get(SQL_LIMIT_START) . ', ' . $argc->get(SQL_LIMIT_END) : '';
            $statement = 'SELECT ' . $fields . ' FROM ' . $argc->get(SQL_TB) . ' WHERE ' . $condition . $groupby . $orderby . $limit;
        }
        return $statement;
    }
}