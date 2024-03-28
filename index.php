<?php

include "./sql/credentials.php";
include "./response/response.php";
include "./routes/router.php";

try {
    $connection = new mysqli($host, $user, $password, $database);
} catch (Exception $e) {
    returnResponse($SQL_ERROR_CODE, $e->getMessage());
    die();
}

header("Content-type: application/json");

parse_str($_SERVER['QUERY_STRING'], $params);

$method = $_SERVER['REQUEST_METHOD'];
$enabledMethods = ['GET', 'POST', 'DELETE', 'PUT'];

$path = isset ($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$idExplode = explode('/', $path);

$queryId = ($path !== '/') ? end($idExplode) : null;

if (!isset ($params['route'])) {
    returnResponse($BAD_REQUEST_CODE, 'Route not specified');
} else {
    $route = strtolower($params['route']);
    
    if (!in_array($method, $enabledMethods)) {
        returnResponse($BAD_REQUEST_CODE, '' . $method . ' method is disabled');
        die();
    }

    router($route);
}

