<?php

namespace WC\Database;

use WC\Models\ListModel;

interface Driver
{
    function executeStatement($statement): bool;

    function loadResult($statement): array;

    function loadResults($statement): array;

    function tableColumns(string $name): array;

    function tables(): array;

    function select(ListModel $argc): array;

    function selectOne(ListModel $argc): array;

    function quote(string $str): string;

    function name(string $str): string;

    function getLastInsertId();
}