<?php

$productsImagesFieldsAllowed = [
    "url", 
    "product"
];

function routeProductsImages($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultProductsImages($connection, $queryId);
            break;
        case "POST":
            insertProductImage($connection);
            break;
        case "PUT":
            updateProductImage($connection);
            break;
        case "DELETE":
            deleteProductImage($connection);
            break;
    }
}

function consultProductsImages($connection, $queryId){
    $sql = "SELECT 
    i.id AS 'id',
    i.url AS 'url',
    i.product AS 'product',
    p.name AS 'productName'
    FROM products_images AS i
    INNER JOIN products AS p ON i.product = p.id
    ";

    if($queryId !== null) $sql .= " WHERE i.id = $queryId";
    
    executeConsult($connection, $sql);
}

function insertProductImage($connection){
    global $productsImagesFieldsAllowed;

    $sql = "INSERT INTO products_images (";
    executeInsert($connection, $productsImagesFieldsAllowed, $sql);
}

function updateProductImage($connection){
    global $productsImagesFieldsAllowed;

    $sql = "UPDATE products_images SET ";
    executeUpdate($connection, $productsImagesFieldsAllowed, $sql);
}

function deleteProductImage($connection){
    $sql = "DELETE FROM products_images ";

    executeDelete($connection, $sql);
}