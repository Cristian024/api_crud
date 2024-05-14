<?php

$nequiFieldsAllowed = [
    'cellphone',
    'document',
    'email',
    'user'
];

function routeNequi($method, $connection, $field)
{
    global $queryId;

    switch ($method) {
        case 'GET':
            consultNequi($connection, $queryId, $field);
            break;
        case 'POST':
            insertNequi($connection);
            break;
        case 'PUT':
            updateNequi($connection);
            break;
        case 'DELETE':
            break;
    }
}

function consultNequi($connection, $queryId, $field){
    $sql = "SELECT
    *
    FROM nequi_accounts
    ";

    if($queryId !== null) $sql.=" WHERE $field = $queryId";

    executeConsult($connection, $sql);
}

function insertNequi($connection){
    global $nequiFieldsAllowed;

    $sql = "INSERT INTO nequi_accounts (";
    executeInsert($connection, $nequiFieldsAllowed, $sql);
}

function updateNequi($connection){
    global $nequiFieldsAllowed;

    $sql = "UPDATE nequi_accounts SET ";
    executeUpdate($connection, $nequiFieldsAllowed, $sql);
}