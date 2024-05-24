<?php

$isCustom;
function routeCustom($method, $connection, $fun)
{
    global $isCustom;
    global $queryId;
    $isCustom = true;

    switch ($method) {
        case "POST":
            switch ($fun) {
                case "recent_orders":
                    consultRecentOrders($connection);
                    break;
                case "recent_clients":
                    consultRecentClients($connection);
                    break;
                default:
                    consultCustom($connection, $queryId);
                    break;
            }
            break;
    }
}

function consultRecentOrders($connection)
{
    $data = json_decode(file_get_contents("php://input"));
    $date = $data->date;

    $sql = "SELECT
    u.name AS 'userName',
    o.totalPrice as 'price',
    p.name AS 'paymenthMethod',
    os.name AS 'state'
    FROM orders AS o
    LEFT JOIN payment_methods AS p ON o.paymentMethod = p.id
    LEFT JOIN orders_states AS os ON o.state = os.id
    LEFT JOIN users AS u ON o.user = u.id
    WHERE o.orderDate >= '$date'";

    executeConsult($connection, $sql);
}

function consultRecentClients($connection)
{
    $data = json_decode(file_get_contents("php://input"));
    $date = $data->date;

    $sql = "SELECT
    u.name AS 'userName',
    u.registerDate AS 'registerDate'
    FROM users as u
    WHERE u.registerDate > '$date' AND
    u.role = '2'
    ";

    executeConsult($connection, $sql);
}

function consultCustom($connection, $queryId)
{
    $data = json_decode(file_get_contents("php://input"));

    $sql = $data->consult;

    executeConsult($connection, $sql);
}