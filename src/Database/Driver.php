<?php

namespace Database;

interface Driver
{
    function executeStatement($statement): bool;

    function loadResult($statement): array;

    function loadResults($statement): array;

    function tableColumns(string $name): array;

    function tables(): array;

    function quote($str): string;

    function getLastInsertId();
}