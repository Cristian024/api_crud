<?php

$userFieldsAllowed = [
    'name',
    'email',
    'password',
    'direction',
    'documentType',
    'document',
    'cellphone',
    'registerDate',
    'lastBuyDate',
    'lastVisitDate',
    'latitude',
    'longitude',
    'role',
    'state',
    'city',
    'bancolombia',
    'nequi'
];

function routeUsers($method, $connection)
{
    global $queryId;

    switch ($method) {
        case "GET":
            consultUser($connection, $queryId);
            break;
        case "POST":
            insertUser($connection);
            break;
        case "PUT":
            updateUser($connection);
            break;
        case "DELETE":
            deleteUser($connection);
            break;
    }
}

#****************METHODS****************#

function consultUser($connection, $queryId)
{
    global $SQL_ERROR_CODE;

    $sql = 
    "SELECT
        u.id AS 'id',
        u.name AS 'name',
        u.email AS 'email',
        u.password AS 'password',
        u.direction AS 'direction',
        u.documentType AS 'documentType',
        u.document AS 'document',
        u.cellphone AS 'cellphone',
        u.registerDate AS 'registerDate',
        u.lastBuyDate AS 'lastBuyDate',
        u.lastVisitDate AS 'lastVisitDate',
        u.latitude AS 'latitude',
        u.longitude AS 'longitude',
        u.role AS 'roleId',
        r.name AS 'role',
        u.state AS 'idState',
        s.name AS 'state',
        u.bancolombia AS 'bancolombia',
        u.nequi AS 'nequi'
    FROM
        users u
    INNER JOIN users_roles r ON
        u.role = r.id
    INNER JOIN users_states s ON 
	    u.state = s.id";

    if ($queryId !== null) $sql .= " WHERE u.id = $queryId";
    
    executeConsult($connection, $sql);
}

function insertUser($connection)
{
    global $userFieldsAllowed;

    $sql = "INSERT INTO users(";
    executeInsert($connection, $userFieldsAllowed, $sql);
}

function updateUser($connection)
{
    global $userFieldsAllowed;

    $sql = "UPDATE users SET ";
    executeUpdate($connection, $userFieldsAllowed, $sql);
}

function deleteUser($connection)
{
    $sql = "DELETE FROM users ";

    executeDelete($connection, $sql);
}