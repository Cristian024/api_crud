<?php

$lotFieldsAllowed = [
    'quantityStock',
    'quantityStored',
    'depot',
    'product'
];

function routeLot($method, $connection)
{
    global $queryId;

    switch ($method) {
        case "GET":
            consultLot($connection, $queryId);
            break;
        case "POST":
            insertLot($connection);
            break;
        case "PUT":
            updateLot($connection);
            break;
        case "DELETE":
            deleteLot($connection);
            break;
    }
}

function consultLot($connection, $queryId)
{
    $sql = "SELECT
        l.id AS 'id',
        l.quantityStock AS 'quantityStock',
        l.quantityStored AS 'quantityStored',
        l.depot AS 'depot',
        d.name AS 'depotName',
        c.id AS 'depotCityId',
        c.name AS 'depotCity',
        l.product AS 'product',
        p.name AS 'productName'
        FROM lot AS l
        LEFT JOIN depot AS d ON l.depot = d.id
        LEFT JOIN products AS p ON l.product = p.id
        LEFT JOIN cities AS c ON d.city = c.id
    ";

    if ($queryId !== null)
        $sql .= " WHERE l.id = $queryId";

    executeConsult($connection, $sql);
}

function insertLot($connection)
{
    global $lotFieldsAllowed;

    $sql = "INSERT INTO lot (";
    executeInsert($connection, $lotFieldsAllowed, $sql);
}

function updateLot($connection)
{
    global $lotFieldsAllowed;

    $sql = "UPDATE lot SET ";
    executeUpdate($connection, $lotFieldsAllowed, $sql);
}

function deleteLot($connection)
{
    $sql = "DELETE FROM lot ";
    executeDelete($connection, $sql);
}