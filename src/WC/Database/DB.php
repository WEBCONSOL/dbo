<?php

namespace WC\Database;

class DB
{
    private static $driver = array();
    private $key = "";
    private $config = null;

    public function __construct(DbConfig $config) {
        $this->config = $config;
        $this->key = md5($config->getHost().$config->getPort().$config->getDbName().$config->getUser().$config->getPassword());
    }

    public function getDriver(): Driver {
        if (!isset(self::$driver[$this->key])) {
            $this->mysql();
        }
        if (self::$driver[$this->key] instanceof Driver) {
            return self::$driver[$this->key];
        }
        return new DefaultDriver();
    }

    private function mysql() {
        self::$driver[$this->key] = new MySQL($this->config->getDSN(), $this->config->getUser(), $this->config->getPassword(), $this->config->getOptions());
    }
}