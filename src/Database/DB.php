<?php

namespace Database;

class DB
{
    private static $driver = array();
    private $key;

    public function __construct(DbConfig $config) {
        $this->key = md5($config->getHost().$config->getPort().$config->getDbName().$config->getUser().$config->getPassword());
    }

    public function getDriver(): Driver {
        if (!isset(self::$driver[$this->key])) {
            $this->mysql($config);
        }
        if (self::$driver[$this->key] instanceof Driver) {
            return self::$driver[$key];
        }
        return new DefaultDriver();
    }

    private function mysql(DbConfig $config): Driver {
        self::$driver[$this->key] = new MySQL($config->getDSN(), $config->getUser(), $config->getPassword(), $config->getOptions());
    }
}