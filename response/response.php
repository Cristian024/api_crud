<?php

$SQL_ERROR_CODE = 500;
$BAD_REQUEST_CODE = 400;
$SUCCESSFLY_CODE = 200;

#LOGIN AND REGISTER CODES#

$USER_EXITS = 201;
$USER_NOT_EXIST = 202;
$INCORRECT_PASSWORD = 203;
$USER_LOGIN = 204;
$ADMIN_LOGIN = 205;
$USER_UNABLE = 206;

function returnResponse($code, $message)
{
    global $insertDataId;
    global $userId;

    if ($code >= 200 and $code <= 300) {
        $message = 'Succesfull response: ' . $message . '';
    }
    if ($code >= 400 and $code < 500) {
        $message = 'Bad request: ' . $message . '';
    } 
    else if ($code >= 500 and $code < 600) {
        $message = 'Server error: ' . $message . '';
    }

    $responseData = new stdClass();

    $responseData->status = $code;
    $responseData->message = $message;
    if($insertDataId !== null){
        $responseData->insertId = $insertDataId;
    }
    if($userId !== null){
        $responseData->userId = $userId;
    }

    echo (json_encode($responseData));
}

