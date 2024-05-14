<?php

$bancolombiaFieldsAllowed = [
    'accountNumber',
    'document',
    'accountTitularName',
    'user'
];

function routeBancolombia($method, $connection, $field)
{
    global $queryId;

    switch ($method) {
        case 'GET':
            consultBancolombia($connection, $queryId, $field);
            break;
        case 'POST':
            insertBancolombia($connection);
            break;
        case 'PUT':
            updateBancolombia($connection);
            break;
        case 'DELETE':
            break;
    }
}

function consultBancolombia($connection, $queryId, $field){
    $sql = "SELECT
    *
    FROM bancolombia_accounts
    ";

    if($queryId !== null) $sql.=" WHERE $field = $queryId";

    executeConsult($connection, $sql);
}

function insertBancolombia($connection){
    global $bancolombiaFieldsAllowed;

    $sql = "INSERT INTO bancolombia_accounts (";
    executeInsert($connection, $bancolombiaFieldsAllowed, $sql);
}

function updateBancolombia($connection){
    global $bancolombiaFieldsAllowed;

    $sql = "UPDATE bancolombia_accounts SET ";
    executeUpdate($connection, $bancolombiaFieldsAllowed, $sql);
}