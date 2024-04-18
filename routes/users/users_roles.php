<?php

$usersRolesFieldsAllowed = [
    "name"
];

function routeUsersRoles($method, $connection){
    global $queryId;

    switch($method){
        case "GET":
            consultUserRols($connection, $queryId);
            break;
    }
}

function consultUserRols($connection, $queryId){
    global $SQL_ERROR_CODE;

    $sql = 
    "SELECT
        u.id AS 'id',
        u.name AS 'name'
    FROM
        users_roles u";

    if ($queryId !== null) $sql .= " WHERE u.id = $queryId";
    
    executeConsult($connection, $sql);
}