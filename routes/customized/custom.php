<?php


function routeCustom($method, $connection){
    global $queryId;

    switch ($method) {
        case "POST":
            consultCustom($connection, $queryId);
            break;
    }
}

function consultCustom($connection, $queryId){
    global $SQL_ERROR_CODE;

    $data = json_decode(file_get_contents("php://input"));

    $sql = $data->consult;

    executeConsult($connection, $sql);
}