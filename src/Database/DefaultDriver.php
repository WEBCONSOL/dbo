<?php

namespace Database;

class DefaultDriver implements Driver
{
    public function executeStatement($statement){}

    public function loadResult($statement){}

    public function loadResults($statement){}

    public function getLastInsertId(){}
}