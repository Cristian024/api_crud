<?php

$depotFieldsAllowed = [
    'name',
    'direction',
    'latitude',
    'longitude',
    'city'
];

function routeDepot($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultDepot($connection, $queryId);
            break;
        case "POST":
            insertDepot($connection);
            break;
        case "PUT":
            updateDepot($connection);
            break;
        case "DELETE":
            deleteDepot($connection);
            break;
    }
}

function consultDepot($connection, $queryId){
    $sql = "SELECT 
    d.id AS 'id',
    d.name AS 'name',
    d.direction AS 'direction',
    d.latitude AS 'latitude',
    d.longitude AS 'longitude',
    d.city AS 'city',
    c.name AS 'cityName',
    (SELECT COUNT(l.id) FROM lot AS l WHERE d.id = l.depot) AS 'quantityLots',
    (SELECT GROUP_CONCAT(l.id) FROM lot AS l WHERE d.id = l.depot) as 'lots'
    FROM depot AS d
    LEFT JOIN cities AS c ON d.city = c.id    
    ";

    if($queryId !==null) $sql .= " WHERE d.id = $queryId";

    executeConsult($connection, $sql);
}

function insertDepot($connection){
    global $depotFieldsAllowed;
    
    $sql = "INSERT INTO depot (";
    executeInsert($connection, $depotFieldsAllowed, $sql);
}

function updateDepot($connection){
    global $depotFieldsAllowed;

    $sql = "UPDATE depot SET ";
    executeUpdate($connection, $depotFieldsAllowed, $sql);
}

function deleteDepot($connection){
    $sql = "DELETE FROM depot ";
    executeDelete($connection, $sql);
}