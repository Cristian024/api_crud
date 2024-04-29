<?php

$userFieldsAllowed = [
    'name',
    'email',
    'password',
    'direction',
    'documentType',
    'document',
    'cellphone',
    'registerDate',
    'lastBuyDate',
    'lastVisitDate',
    'latitude',
    'longitude',
    'role',
    'state',
    'city'
];

function routeUsers($method, $connection, $submethod)
{
    global $queryId;

    switch ($method) {
        case "GET":
            consultUser($connection, $queryId);
            break;
        case "POST":
            if ($submethod !== null) {
                switch ($submethod) {
                    case 'register':
                        registerUser($connection);
                        break;
                    case 'login':
                        loginUser($connection);
                        break;
                }
            } else {
                insertUser($connection);
            }
            break;
        case "PUT":
            updateUser($connection);
            break;
        case "DELETE":
            deleteUser($connection);
            break;
    }
}

#****************METHODS****************#

function consultUser($connection, $queryId)
{
    global $SQL_ERROR_CODE;

    $sql =
        "SELECT
        u.id AS 'id',
        u.name AS 'name',
        u.email AS 'email',
        u.password AS 'password',
        u.direction AS 'direction',
        c.name AS 'city',
        u.documentType AS 'documentType',
        u.document AS 'document',
        u.cellphone AS 'cellphone',
        u.registerDate AS 'registerDate',
        u.lastBuyDate AS 'lastBuyDate',
        u.lastVisitDate AS 'lastVisitDate',
        u.latitude AS 'latitude',
        u.longitude AS 'longitude',
        u.role AS 'roleId',
        r.name AS 'role',
        u.state AS 'idState',
        s.name AS 'state'
    FROM
        users u
    INNER JOIN users_roles r ON
        u.role = r.id
    INNER JOIN users_states s ON 
	    u.state = s.id
    LEFT JOIN cities c ON
        u.city = c.id";


    if ($queryId !== null)
        $sql .= " WHERE u.id = $queryId";

    executeConsult($connection, $sql);
}

function insertUser($connection)
{
    global $userFieldsAllowed;

    $sql = "INSERT INTO users(";
    executeInsert($connection, $userFieldsAllowed, $sql);
}

function updateUser($connection)
{
    global $userFieldsAllowed;

    $sql = "UPDATE users SET ";
    executeUpdate($connection, $userFieldsAllowed, $sql);
}

function deleteUser($connection)
{
    $sql = "DELETE FROM users ";

    executeDelete($connection, $sql);
}

#*************SUBMETHODS*************#

$specifiedData = null;
function registerUser($connection)
{
    global $SQL_ERROR_CODE;
    global $USER_EXITS;
    global $specifiedData;
    global $userFieldsAllowed;

    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $consult_email = $data['email'];

        $sql = 'SELECT 
        COUNT(u.id) as count
        FROM users u
        WHERE u.email = "' . $consult_email . '"';

        $result = $connection->query($sql);

        if ($result) {
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                $count = $row['count'];
            }

            if ($count > 0) {
                returnResponse($USER_EXITS, 'User is registered');
            } else {
                $user = new stdClass();
                $user->name = $data['name'];
                $user->email = $consult_email;
                $user->password = md5($data['password']);
                $user->direction = "";
                $user->documentType = "";
                $user->document = "";
                $user->cellphone = "";
                $user->registerDate = date("Y/n/d");
                $user->lastBuyDate = null;
                $user->lastVisitDate = date("Y/n/d");
                $user->latitude = 0;
                $user->longitude = 0;
                $user->role = 2;
                $user->state = 1;
                $user->city = null;

                $specifiedData = $user;

                $sql = "INSERT INTO users(";
                executeInsert($connection, $userFieldsAllowed, $sql);
            }
        }
    } catch (Exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}

function loginUser($connection)
{
    global $SQL_ERROR_CODE;
    global $USER_NOT_EXIST;
    global $SUCCESSFLY_CODE;
    global $INCORRECT_PASSWORD;
    global $USER_LOGIN;
    global $ADMIN_LOGIN;

    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $consult_email = $data['email'];
        $consult_pass = md5($data['password']);

        $sql = 'SELECT 
        u.email as email,
        u.password as password,
        u.role as role
        FROM users u
        WHERE u.email = "' . $consult_email . '"';

        $result = $connection->query($sql);

        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            if (sizeof($data) < 1) {
                returnResponse($USER_NOT_EXIST, "User don't exist");
            } else {
                $passComparation = $data[0]['password'];
                if ($passComparation != $consult_pass) {
                    returnResponse($INCORRECT_PASSWORD, 'Incorrect password');
                } else {
                    $userRole = $data[0]['role'];
                    switch ($userRole) {
                        case '1':
                            returnResponse($ADMIN_LOGIN, 'Succefull Login');
                            break;
                        case '2':
                            returnResponse($USER_LOGIN, 'Succefull Login');
                            break;
                    }
                }
            }
        }
    } catch (Exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}