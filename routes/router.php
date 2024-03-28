<?php

include "./routes/dependencies.php";

function router($route)
{
    global $method;
    global $connection;
    global $BAD_REQUEST_CODE;

    switch ($route) {
        case 'users':
            routeUsers($method, $connection);
            break;
        case 'products':
            routeProducts($method, $connection);
            break;
        case 'products_images':
            routeProductsImages($method, $connection);
            break;
        case 'cities':
            routeCities($method, $connection);
            break;
        case 'depot':
            routeDepot($method, $connection);
            break;
        case 'lot':
            routeLot($method, $connection);
            break;
        case 'orders':
            routeOrders($method, $connection);
            break;
        case 'orders_detail':
            routeOrdersDetail($method, $connection);
            break;
        case 'comments':
            routeComments($method, $connection);
            break;
        case 'shipments':
            routeShipments($method, $connection);
            break;
        case 'companies':
            routeCompanies($method, $connection);
            break;
        case 'earnings':
            routeEarnings($method, $connection);
            break;
        case 'custom':
            routeCustom($method, $connection);
            break;
        default:
            returnResponse($BAD_REQUEST_CODE, "The route '$route' does not exist");
            break;
    }
}
