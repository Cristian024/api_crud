<?php

require "responseClass.php";

$SQL_ERROR_CODE = 500;
$BAD_REQUEST_CODE = 400;
$SUCCESSFLY_CODE = 200;

#LOGIN AND REGISTER CODES#

$USER_EXITS = 201;
$USER_NOT_EXIST = 202;
$INCORRECT_PASSWORD = 203;
$USER_LOGIN = 204;
$ADMIN_LOGIN = 205;

function returnResponse($code, $message)
{
    if ($code >= 200 and $code <= 300) {
        $message = 'Succesfull response: ' . $message . '';
    }
    if ($code >= 400 and $code < 500) {
        $message = 'Bad request: ' . $message . '';
    } 
    else if ($code >= 500 and $code < 600) {
        $message = 'Server error: ' . $message . '';
    }

    $response = new ResponseClass($code, $message);

    echo (json_encode($response));
}

