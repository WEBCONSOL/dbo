<?php

namespace Database;

class DbConfig
{
    const DRIVER = "driver";
    const HOST = "host";
    const PORT = "port";
    const DBNAME = "dbname";
    const USER = "user";
    const PASSWORD = "password";
    const CHARSET = "charset";
    const OPTIONS = "options";
    private $data = array();

    function __construct($val) {$this->reset($val);}

    public function getDSN(): string {return $this->getDriver().':host='.$this->getHost().';dbname='.$this->getDbName().';charset='.$this->getCharset();}

    public function getDriver(): string {return strtolower(str_replace('pdo_', '', $this->get(self::DRIVER)));}
    public function getHost(): string {return strtolower($this->get(self::HOST));}
    public function getPort(): string {return strtolower($this->get(self::PORT));}
    public function getDbName(): string {return strtolower($this->get(self::DBNAME));}
    public function getUser(): string {return strtolower($this->get(self::USER));}
    public function getPassword(): string {return strtolower($this->get(self::PASSWORD));}
    public function getCharset(): string {return strtolower($this->get(self::CHARSET, 'UTF-8'));}
    public function getOptions(): array {return $this->has(self::OPTIONS) && is_array($this->data[self::OPTIONS]) ? $this->data[self::OPTIONS] : array();}
    public function getAsArray(): array {return $this->data;}

    private function reset($v=null) {
        if (is_array($v)) {
            $this->data = $v;
        }
        else if (is_object($v)) {
            $this->data = json_decode(json_encode($v), true);
        }
        else if (file_exists($v) && pathinfo($v, PATHINFO_EXTENSION)) {
            $this->data = json_decode(file_get_contents($v), true);
        }
    }
    private function get(string $k, $defult=""): string {return $this->has($k) ? $this->data[$k] : $defult;}
    private function has(string $k): bool {return isset($this->data[$k]);}
    private function is(string $k, string $v): bool {return $this->has($k) && $this->data[$k] === $v;}
}