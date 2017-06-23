<?php

function validate($data, $rules) {
    $errors['error'] = true;
    //$errors = ['error' => true];

    foreach ($rules as $key => $value) {
        if (!isset($data[$key])) {
            array_push($errors, [
                'rule' => $singleValue[0],
                'field' => $key,
                'value' => '',
                'msg' => 'El campo ' . $key . ' no fue definido'
            ]);
        } else {
            $values = explode('|', $value);

            foreach ($values as $value) {
                $singleValue = explode(":", $value);
                switch ($singleValue[0]) {
                    case 'except':
                        $tabla = $singleValue[1];
                        $columna = $key;
                        $valor = $data[$key];
                        $idKey = $singleValue[2];
                        $conn = new mysqli(APP_SERVER, APP_USER, APP_PASS, APP_DB);
                        $conn->set_charset("utf8");
                        $query = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . "= '" . $valor . "'";
                        $result = $conn->query($query);
                        $rows = $result->num_rows;
                        if ($rows > 0) {
                            $query = "SELECT " . $columna . " value FROM " . $tabla . " WHERE " . $idKey . "= '" . $data[$idKey] . "'";
                            $result = $conn->query($query);
                            $row = $result->fetch_assoc();
                            $result->close();
                            if (strtolower($row['value']) != $valor) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $data[$key] . ' ya se encuentra registrado en la base de datos'
                                ]);
                            }
                        } break;
                    case 'unique':
                        $tabla = $singleValue[1];
                        $columna = $key;
                        $valor = $data[$key];
                        $query = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . "= '" . $valor . "'";
                        $conn = new mysqli(APP_SERVER, APP_USER, APP_PASS, APP_DB);
                        $conn->set_charset("utf8");
                        $result = $conn->query($query);
                        if (($rows = $result->num_rows) > 0) {
                            array_push($errors, [
                                'rule' => $singleValue[0],
                                'field' => $key,
                                'value' => $data[$key],
                                'msg' => 'El campo ' . $data[$key] . ' ya se encuentra registrado en la base de datos'
                            ]);
                        }
                        $result->close();
                        break;
                    case 'exists':
                        $tabla = $singleValue[1];
                        $columna = $key;
                        $valor = $data[$key];
                        $conn = new mysqli(APP_SERVER, APP_USER, APP_PASS, APP_DB);
                        $conn->set_charset("utf8");
                        if (!isset($singleValue[2])) {
                            $query = "SELECT " . $columna . " FROM " . $tabla . " WHERE " . $columna . "= '" . $valor . "'";
                            $result = $conn->query($query);
                            if (($rows = $result->num_rows) == 0) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' no se existe en la base de datos'
                                ]);
                            }
                            $result->close();
                            break;
                        } else {
                            $query = "SELECT " . $singleValue[2] . " FROM " . $tabla . " WHERE " . $singleValue[2] . "= '" . $valor . "'";
                            $result = $conn->query($query);
                            if (($rows = $result->num_rows) == 0) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' no se existe en la base de datos'
                                ]);
                            }
                            $result->close();
                            break;
                        }

                    case 'required':
                        if ($data[$key] == '') {
                            array_push($errors, [
                                'rule' => $singleValue[0],
                                'field' => $key,
                                'value' => $data[$key],
                                'msg' => 'El campo ' . $key . ' es obligstorio'
                            ]);
                        } break;
                    case 'number':
                        if (!is_numeric($data[$key])) {
                            array_push($errors, [
                                'rule' => $singleValue[0],
                                'field' => $key,
                                'value' => $data[$key],
                                'msg' => 'El campo ' . $key . ' debe de contener solo numeros'
                            ]);
                        } break;
                    case 'email':
                        if (!filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, [
                                'rule' => $singleValue[0],
                                'field' => $key,
                                'value' => $data[$key],
                                'msg' => 'El campo ' . $key . ' debe de ser un correo electronico valido'
                            ]);
                        }break;
                    case 'toInt':
                        $data[$key] = intval($data[$key]);
                        break;
                    case 'trim':
                        $data[$key] = trim($data[$key]);
                        break;
                    case 'strtolower':
                        $data[$key] = strtolower($data[$key]);
                        break;
                    case 'trimlower':
                        $data[$key] = strtolower(trim($data[$key]));
                        break;
                    case 'min':
                        if (is_numeric($data[$key])) {
                            if ($data[$key] < $singleValue[1]) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' debe de tener un minimo de ' . $singleValue[1] . ' caracteres'
                                ]);
                            }
                        } else {
                            if (strlen($data[$key]) < $singleValue[1]) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' debe de tener un minimo de ' . $singleValue[1] . ' caracteres'
                                ]);
                            }
                        } break;
                    case 'max':
                        if (is_numeric($data[$key])) {
                            if ($data[$key] > $singleValue[1]) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' debe de tener un maximo de ' . $singleValue[1] . ' caracteres'
                                ]);
                            }
                        } else {
                            if (strlen($data[$key]) > $singleValue[1]) {
                                array_push($errors, [
                                    'rule' => $singleValue[0],
                                    'field' => $key,
                                    'value' => $data[$key],
                                    'msg' => 'El campo ' . $key . ' debe de tener un maximo de ' . $singleValue[1] . ' caracteres'
                                ]);
                            }
                        } break;
                }
            }
        }
    }
    if (count($errors) == 1) {
        return $data;
    } else {
        array_shift($errors);
        $_SESSION["error"] = ["data" => $errors, "id" => "001", "title" => "Alerta!", "msg" => "Ha ocurrido un problema con la validación de los datos, favor de verificar nuevamente la información. Los datos no se guardaron"];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
        return $errors;
    }
}
