<?php

$commentsFieldsAllowed = [
    "comment",
    "rate",
    "user",
    "product"
];

function routeComments($method, $connection){
    global $queryId;

    switch ($method) {
        case "GET":
            consultComments($connection, $queryId);
            break;
        case "POST":
            insertComment($connection);
            break;
        case "PUT":
            updateComment($connection);
            break;
        case "DELETE":
            deleteComment($connection);
            break;
    }
}

function consultComments($connection, $queryId){
    $sql = "SELECT
    c.id AS 'id',
    c.comment AS 'comment',
    c.rate AS 'rate',
    u.id AS 'user',
    u.name AS 'userName',
    p.id AS 'product',
    p.name AS 'productName'
    FROM comments AS c
    INNER JOIN users AS u ON c.user = u.id
    INNER JOIN products AS p ON c.product = p.id
    ";

    if($queryId !== null)$sql .= " WHERE c.id = $queryId";

    executeConsult($connection, $sql);
}

function insertComment($connection){
    global $commentsFieldsAllowed;

    $sql = "INSERT INTO comments (";
    executeInsert($connection, $commentsFieldsAllowed, $sql);
}

function updateComment($connection){
    global $commentsFieldsAllowed;

    $sql = "UPDATE comments SET ";
    executeUpdate($connection, $commentsFieldsAllowed, $sql);
}

function deleteComment($connection){
    $sql = "DELETE FROM comments ";
    executeDelete( $connection, $sql);
}
