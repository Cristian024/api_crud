<?php

$ordersFieldsAllowed = [
    'orderDate',
    'cancelDate',
    'totalPrice',
    'subTotal',
    'shippingPrice',
    'direction',
    'latitude',
    'longitude',
    'cancelReason',
    'city',
    'paymentMethod',
    'state',
    'user'
];

function routeOrders($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultOrders($connection, $queryId);
            break;
        case "POST":
            insertOrder($connection);
            break;
        case "PUT":
            updateOrder($connection);
            break;
        case "DELETE":
            deleteOrder($connection);
            break;
    }
}

function consultOrders($connection, $queryId){
    $sql = "SELECT 
    o.id AS 'id',
    o.orderDate AS 'orderDate',
    o.cancelDate AS 'cancelDate',
    co.name AS 'cancelReason',
    o.totalPrice AS 'totalPrice',
    o.subTotal AS 'subTotal',
    o.shippingPrice AS 'shippingPrice',
    o.direction AS 'direction',
    o.latitude AS 'latitude',
    o.longitude AS 'longitude',
    ci.id AS 'city',
    ci.name AS 'cityName',
    p.name AS 'paymenthMethod',
    os.name AS 'state',
    u.id AS 'user',
    u.name AS 'userName',
    COUNT(od.id) AS 'quantityOrder',
    (SELECT GROUP_CONCAT(od.id) FROM orders_detail AS od WHERE o.id = od.orderid) AS 'ordersDetails'
    FROM orders AS o
    LEFT JOIN cancel_order_reason AS co ON o.cancelReason = co.id
    LEFT JOIN cities AS ci ON o.city = ci.id
    LEFT JOIN payment_methods AS p ON o.paymentMethod = p.id
    LEFT JOIN orders_states AS os ON o.state = os.id
    LEFT JOIN users AS u ON o.user = u.id
    LEFT JOIN orders_detail AS od ON o.id = od.orderid
    ";

    if($queryId !== null) $sql .= " WHERE o.id = $queryId";
    

    $sql .= " GROUP BY o.id";

    executeConsult($connection, $sql);
}

function insertOrder($connection){
    global $ordersFieldsAllowed;

    $sql = "INSERT INTO orders (";
    executeInsert($connection, $ordersFieldsAllowed, $sql);
}

function updateOrder($connection){
    global $ordersFieldsAllowed;

    $sql = "UPDATE orders SET ";
    executeUpdate($connection, $ordersFieldsAllowed, $sql);
}

function deleteOrder($connection){
    $sql = "DELETE FROM orders ";
    executeDelete($connection, $sql);
}