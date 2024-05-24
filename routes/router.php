<?php

include "./routes/dependencies.php";

function router($route)
{
    global $method;
    global $connection;
    global $BAD_REQUEST_CODE;

    switch ($route) {
        case 'users':
            routeUsers($method, $connection, null);
            break;
        case 'user_register':
            routeUsers($method, $connection, 'register');
            break;
        case 'user_login':
            routeUsers($method, $connection, 'login');
            break;
        case 'users_states':
            routeUsersStates($method, $connection);
            break;
        case 'users_roles':
            routeUsersRoles($method, $connection);
            break;
        case 'nequi_accounts':
            routeNequi($method, $connection, 'id');
            break;
        case 'nequi_accounts_by_user':
            routeNequi($method, $connection, 'user');
            break;
        case 'bancolombia_accounts':
            routeBancolombia($method, $connection, 'id');
            break;
        case 'bancolombia_accounts_by_user':
            routeBancolombia($method, $connection, 'user');
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
            routeDepot($method, $connection, 'id');
            break;
        case 'depot_by_product': 
            routeDepot($method, $connection, 'city');
            break;
        case 'lot':
            routeLot($method, $connection);
            break;
        case 'orders':
            routeOrders($method, $connection);
            break;
        case 'orders_detail':
            routeOrdersDetail($method, $connection, 'id');
            break;
        case 'orders_detail_by_order':
            routeOrdersDetail($method, $connection, 'orderid');
            break;
        case 'orders_states':
            routeOrderStates($method, $connection);
            break;
        case 'comments':
            routeComments($method, $connection);
            break;
        case 'shipments':
            routeShipments($method, $connection);
            break;
        case 'companies':
            routeCompanies($method, $connection, 'id');
            break;
        case 'companies_by_city':
            routeCompanies($method, $connection, 'city');
            break;
        case 'earnings':
            routeEarnings($method, $connection);
            break;
        case 'visits':
            routeVisits($method, $connection, 'id');
            break;
        case 'visits_by_date':
            routeVisits($method, $connection, 'date');
            break;
        case 'custom':
            routeCustom($method, $connection, '');
            break;
        case 'recent_orders':
            routeCustom($method, $connection, 'recent_orders');
            break;
        case 'recent_clients':
            routeCustom($method, $connection, 'recent_clients');
            break;
        default:
            returnResponse($BAD_REQUEST_CODE, "The route '$route' does not exist");
            break;
    }
}
