<?php

$companiesFieldsAllowed = [
    'name',
    'cellphone',
    'email',
    'shipingDiscount',
    'city'
];

function routeCompanies($method, $connection){
    global $queryId;

    switch ($method) {
        case 'GET':
            consultCompanies($connection, $queryId);
            break;
        case 'POST':
            insertCompanie($connection);
            break;
        case 'PUT':
            updateCompanie($connection);
            break;
        case 'DELETE':
            deleteCompanie($connection);
            break;
    }
}

function consultCompanies($connection, $queryId){
    $sql = "SELECT
    c.id AS 'id',
    c.name AS 'name',
    c.cellphone AS 'cellphone',
    c.email AS 'email',
    c.shipingDiscount AS 'shipingDiscount',
    c.city AS 'city',
    ci.name AS 'cityName'
    FROM companies AS c
    INNER JOIN cities AS ci ON c.city = ci.id
    ";

    if($queryId !== null) $sql .= " WHERE c.id = $queryId";

    executeConsult($connection, $sql);
}

function insertCompanie($connection){
    global $companiesFieldsAllowed;

    $sql = "INSERT INTO companies (";
    executeInsert($connection, $companiesFieldsAllowed, $sql);
}

function updateCompanie($connection){
    global $companiesFieldsAllowed;

    $sql = "UPDATE companies SET";
    executeUpdate($connection, $companiesFieldsAllowed, $sql);
}

function deleteCompanie($connection){
    $sql = "DELETE FROM companies ";
    executeDelete($connection, $sql);
}