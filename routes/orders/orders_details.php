<?php

$ordersDetailFieldsAllowed = [
    'quantity',
    'totalPrice',
    'product',
    'orderId'
];

function routeOrdersDetail($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultOrdersDetail($connection, $queryId);
            break;
        case "POST":
            insertOrdersDetail($connection);
            break;
        case "PUT":
            updateOrdersDetail($connection);
            break;
        case "DELETE":
            deleteOrdersDetail($connection);
            break;
    }
}

function consultOrdersDetail($connection, $queryId){
    $sql = "SELECT 
    d.id AS 'id',
    d.quantity AS 'quantity',
    d.totalPrice AS 'totalPrice',
    p.id AS 'product',
    p.name AS 'productName',
    p.price AS 'productPrice',
    d.orderid AS 'order'
    FROM orders_detail AS d
    LEFT JOIN products AS p ON d.product = p.id
    ";

    if($queryId !== null) $sql .= " WHERE d.id = $queryId";

    executeConsult($connection, $sql);
}

function insertOrdersDetail($connection){
    global $ordersDetailFieldsAllowed;

    $sql = "INSERT INTO orders_detail (";
    executeInsert($connection, $ordersDetailFieldsAllowed, $sql);
}

function updateOrdersDetail($connection){
    global $ordersDetailFieldsAllowed;

    $sql = "UPDATE orders_detail SET ";
    executeUpdate($connection, $ordersDetailFieldsAllowed, $sql);
}

function deleteOrdersDetail($connection){
    $sql = "DELETE FROM orders_detail ";
    executeDelete($connection, $sql);
}