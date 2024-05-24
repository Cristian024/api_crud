<?php 

$visitsFieldsAllowed = [
    "date",
    "quantity"
];

function routeVisits($method, $connection, $field){
    global $queryId;

    switch ($method) {
        case "GET":
            consultVisits($connection, $queryId, $field);
            break;
        case "POST":
            insertVisits($connection);
            break;
        case "PUT":
            updateVisits($connection);
            break;
    }
}

function consultVisits($connection, $queryId, $field){
    $sql = "SELECT
    *
    FROM visits";

    if($queryId !== null) $sql.=" WHERE $field = '$queryId'";

    executeConsult($connection, $sql);
}

function insertVisits($connection){
    global $visitsFieldsAllowed;

    $sql = "INSERT INTO visits (";

    executeInsert($connection, $visitsFieldsAllowed, $sql);
}

function updateVisits($connection){
    global $visitsFieldsAllowed;

    $sql = "UPDATE visits SET ";

    executeUpdate($connection, $visitsFieldsAllowed, $sql);
}