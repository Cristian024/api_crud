<?php

$productsFieldsAllowed = [
    "name",
    "description",
    "price"
];

function routeProducts($method, $connection)
{
    global $queryId;

    switch ($method) {
        case "GET":
            consultProduct($connection, $queryId);
            break;
        case "POST":
            insertProduct($connection);
            break;
        case "PUT":
            updateProduct($connection);
            break;
        case "DELETE":
            deleteProduct($connection);
            break;
    }
}

function consultProduct($connection, $queryId)
{
    global $SQL_ERROR_CODE;

    $sql = "SELECT 
    p.id AS 'id',
    p.name AS 'name',
    p.description AS 'description',
    p.price AS 'price',
    (SELECT GROUP_CONCAT(l.id) FROM lot AS l WHERE p.id = l.product) AS 'lots',
    (SELECT SUM(l.quantityStock) FROM lot AS l WHERE p.id = l.product) AS 'quantityStock',
    (SELECT COUNT(i.url) FROM products_images AS i WHERE p.id = i.product) AS 'quantityImages',
    (SELECT GROUP_CONCAT(i.id) FROM products_images AS i WHERE p.id = i.product) AS 'images',
    (SELECT GROUP_CONCAT(i.url) FROM products_images AS i WHERE p.id = i.product) AS 'imagesURL',
    (SELECT COUNT(c.id) FROM comments AS c WHERE p.id = c.product) AS 'quantityComments',
    (SELECT AVG(c.rate) FROM comments AS c WHERE p.id = c.product) AS 'rate'
    FROM products p
    LEFT JOIN lot AS l ON p.id = l.product
    LEFT JOIN products_images AS i ON p.id = i.product
    ";

    if ($queryId !== null)
        $sql .= " WHERE p.id = $queryId";

    $sql .= " GROUP BY p.id, p.name, p.description, p.price";
    executeConsult($connection, $sql);
}

function insertProduct($connection)
{
    global $productsFieldsAllowed;

    $sql = "INSERT INTO products(";
    executeInsert($connection, $productsFieldsAllowed, $sql);
}

function updateProduct($connection)
{
    global $productsFieldsAllowed;

    $sql = "UPDATE products SET ";
    executeUpdate($connection, $productsFieldsAllowed, $sql);
}

function deleteProduct($connection)
{
    $sql = "DELETE FROM products ";

    executeDelete($connection, $sql);
}