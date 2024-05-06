<?php

$citiesFieldsAllowed = [
    "name",
    "points"
];

function routeCities($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultCities($connection, $queryId);
            break;
        case "POST":
            insertCity($connection);
            break;
        case "PUT":
            updateCity($connection);
            break;
        case "DELETE":
            deleteCity($connection);
            break;
    }
}


function consultCities($connection, $queryId){
    $sql = "SELECT
    *
    FROM cities
    ";

    if($queryId !== null) $sql.=" WHERE id = $queryId";

    executeConsult($connection, $sql);
}

function insertCity($connection){
    global $citiesFieldsAllowed;

    $sql = "INSERT INTO cities (";
    executeInsert($connection, $citiesFieldsAllowed, $sql);
}

function updateCity($connection){
    global $citiesFieldsAllowed;

    $sql = "UPDATE cities SET ";
    executeUpdate($connection, $citiesFieldsAllowed, $sql);
}

function deleteCity($connection){
    $sql = "DELETE FROM cities ";
    executeDelete($connection, $sql);
}