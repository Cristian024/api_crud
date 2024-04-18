<?php

$usersStatesFieldsAllowed = [
    'name'
];

function routeUsersStates($method, $connection)
{
    global $queryId;

    switch ($method) {
        case "GET":
            consultUserState($connection, $queryId);
            break;
    }
}

function consultUserState($connection, $queryId)
{
    global $SQL_ERROR_CODE;

    $sql = 
    "SELECT
        u.id AS 'id',
        u.name AS 'name'
    FROM
        users_states u";

    if ($queryId !== null) $sql .= " WHERE u.id = $queryId";
    
    executeConsult($connection, $sql);
}