<?php

$earnignsFieldsAllowed = [
    'totalSale',
    'totalEarnings',
    'orderid',
    'company'
];

function routeEarnings($method, $connection){
    global $queryId;

    switch ($method) {
        case 'GET':
            consultEarnigns($connection, $queryId);
            break;
        case 'POST':
            insertEarning($connection);
            break;
        case 'PUT':
            updateEarning($connection);
            break;
        case 'DELETE':
            deleteEarning($connection);
            break;
    }
}

function consultEarnigns($connection, $queryId){
    $sql = "SELECT
    e.id AS 'id',
    e.totalSale AS 'totalSale',
    e.totalEarnings AS 'totalEarnings',
    c.shipingDiscount AS 'companyDiscount',
    c.city AS 'city',
    ci.name AS 'cityName',
    c.id AS 'company',
    c.name AS 'companyName',
    o.id AS 'order',
    o.orderDate AS 'orderDate'
    FROM earnings AS e
    INNER JOIN orders AS o ON e.orderid = o.id
    INNER JOIN companies AS c ON e.company = c.id
    INNER JOIN cities AS ci ON c.city = ci.id
    ";

    if($queryId !== null) $sql .= " WHERE e.id = $queryId";

    executeConsult($connection, $sql);
}

function insertEarning($connection){
    global $earnignsFieldsAllowed;

    $sql = "INSERT INTO earnings (";
    executeInsert($connection, $earnignsFieldsAllowed, $sql);
}

function updateEarning($connection){
    global $earnignsFieldsAllowed;

    $sql = "UPDATE earnings SET ";
    executeUpdate($connection, $earnignsFieldsAllowed, $sql);
}

function deleteEarning($connection){
    $sql = "DELETE FROM earnings";
    executeDelete($connection, $sql);
}