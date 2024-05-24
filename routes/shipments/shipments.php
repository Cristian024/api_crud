<?php

$shipmentsFieldsAllowed = [
    'actualUbication',
    'originUbication',
    'shipmentUbication',
    'shipmentDate',
    'deliveryDate',
    'state',
    'company',
    'orderid',
    'delivery'
];

function routeShipments($method, $connection){
    global $queryId;

    switch ($method) {
        case 'GET':
            consultShipments($connection, $queryId);
            break;
        case 'POST':
            insertShipment($connection);
            break;
        case 'PUT':
            updateShipment($connection);
            break;
        case 'DELETE':
            deleteShipment($connection);
            break;
    }
}

function consultShipments($connection, $queryId){
    $sql = "SELECT
    s.id AS 'id',
    s.actualUbication AS 'actualUbication',
    s.originUbication AS 'originUbication',
    s.shipmentUbication AS 'shipmentUbication',
    s.shipmentDate AS 'shipmentDate',
    s.deliveryDate AS 'deliveryDate',
    st.name AS 'stateName',
    s.company AS 'company',
    c.name AS 'companyName',
    ci.name AS 'companyCity',
    s.orderid AS 'order'
    FROM shipments AS s
    LEFT JOIN shipments_states AS st ON s.state = st.id
    LEFT JOIN companies AS c ON s.company = c.id
    LEFT JOIN cities AS ci ON c.city = ci.id
    LEFT JOIN users AS u ON s.delivery = u.id
    ";

    if($queryId !== null) $sql .= " WHERE s.id = $queryId";

    $sql .= " GROUP BY s.id";

    executeConsult($connection, $sql);
}   

function insertShipment($connection){
    global $shipmentsFieldsAllowed;

    $sql = "INSERT INTO shipments (";
    executeInsert($connection, $shipmentsFieldsAllowed ,$sql);
}

function updateShipment($connection){
    global $shipmentsFieldsAllowed;

    $sql = "UPDATE shipments SET ";
    executeUpdate($connection, $shipmentsFieldsAllowed ,$sql);
}

function deleteShipment($connection){
    $sql = "DELETE FROM shipments ";
    executeDelete($connection, $sql);
}