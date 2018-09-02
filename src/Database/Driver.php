<?php

namespace Database;

interface Driver
{
    function executeStatement($statement);

    function loadResult($statement);

    function loadResults($statement);

    function getLastInsertId();
}