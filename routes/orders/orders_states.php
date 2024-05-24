<?php

$citiesFieldsAllowed = [
    "name",
    "points"
];

function routeOrderStates($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultOrderStates($connection, $queryId);
            break;
    }
}

function consultOrderStates($connection, $queryId){
    $sql = "SELECT
    *
    FROM orders_states
    ";

    if($queryId !== null) $sql.=" WHERE id = $queryId";

    executeConsult($connection, $sql);
}