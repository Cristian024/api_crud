<?php

function executeConsult($connection, $sql){
    global $SQL_ERROR_CODE;

    try {
        $result = $connection->query($sql);

        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            $response = new stdClass();
            $response->status = 200;
            $response->data = $data;
            echo json_encode($response);
        }
    } catch (Exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}

$insertDataId;
function executeInsert($connection, $fieldsAllowed, $sql){
    global $BAD_REQUEST_CODE;
    global $SQL_ERROR_CODE;
    global $SUCCESSFLY_CODE;
    global $specifiedData;
    global $insertDataId;

    $fields = [];

    try {
        if($specifiedData != null){
            $data = $specifiedData;
        }else{
            $data = json_decode(file_get_contents("php://input"), true);
        }
        $count = 0;
        foreach ($data as $key => $value) {
            if (in_array($key, $fieldsAllowed)) {
                $field = [$key, $value];
                $fields[] = $field;
                $count++;
            } else {
                returnResponse($BAD_REQUEST_CODE, "The '$key' field is not accepted");
                die();
            }
        }

        if (count($fieldsAllowed) != $count) {
            returnResponse($BAD_REQUEST_CODE, "Missing params");
            die();
        }

        foreach ($fields as $field => $value) {
            if ($field == ((count($fields)) - 1)) {
                $sql .= '' . $value[0] . ')';
            } else {
                $sql .= '' . $value[0] . ',';
            }
        }

        $sql .= ' VALUES (';

        foreach ($fields as $field => $value) {
            $camp = $value[1];
            if ($field == ((count($fields)) - 1)) {
                $sql .= "'$camp')";
            } else {
                $sql .= "'$camp',";
            }
        }

        $result = $connection->query($sql);

        if ($result) {
            $insertDataId = $connection->insert_id;
            returnResponse($SUCCESSFLY_CODE, 'Entity successfully added');
        } else {
            returnResponse($SQL_ERROR_CODE, 'Entity could not be inserted');
        }
    } catch (Exception $e) {
        returnResponse($BAD_REQUEST_CODE, $e->getMessage());
    } catch (mysqli_sql_exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}

function executeUpdate($connection, $fieldsAllowed, $sql){
    global $BAD_REQUEST_CODE;
    global $SQL_ERROR_CODE;
    global $SUCCESSFLY_CODE;
    global $queryId;

    try {
        if ($queryId === null) {
            returnResponse($BAD_REQUEST_CODE, 'ID is required');
        } else {
            $data = json_decode(file_get_contents("php://input"), true);
            $count = 0;
            foreach ($data as $key => $value) {
                if (in_array($key, $fieldsAllowed)) {
                    if ($count == (count($data) - 1)) {
                        $sql .= "$key = '$value'";
                    } else {
                        $sql .= "$key = '$value', ";
                    }
                    $count++;
                } else {
                    returnResponse($BAD_REQUEST_CODE, "The '$key' field is not accepted");
                    die();
                }
            }

            $sql .= " WHERE id = $queryId";
            $result = $connection->query($sql);

            if ($result) {
                returnResponse($SUCCESSFLY_CODE, 'Entity successfully updated');
            } else {
                returnResponse($SQL_ERROR_CODE, 'Entity could not be updated');
            }
        }
    } catch (Exception $e) {
        returnResponse($BAD_REQUEST_CODE, $e->getMessage());
    } catch (mysqli_sql_exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}

function executeDelete($connection, $sql){
    global $BAD_REQUEST_CODE;
    global $SQL_ERROR_CODE;
    global $SUCCESSFLY_CODE;
    global $queryId;

    try {
        if ($queryId === null) {
            returnResponse($BAD_REQUEST_CODE, 'ID is required');
        } else {
            $sql .= "WHERE id = $queryId";
            $result = $connection->query($sql);

            if ($result) {
                returnResponse($SUCCESSFLY_CODE, 'Entity successfully deleted');
            } else {
                returnResponse($SQL_ERROR_CODE, 'Entity could not be deleted');
            }
        }
    } catch (Exception $e) {
        returnResponse($BAD_REQUEST_CODE, $e->getMessage());
    } catch (mysqli_sql_exception $e) {
        returnResponse($SQL_ERROR_CODE, $e->getMessage());
    }
}