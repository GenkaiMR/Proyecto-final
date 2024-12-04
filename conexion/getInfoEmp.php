<?php
include_once 'connection.php';

$connection = connection();


function getEmpInfo($connection) {
    if ($connection) {
        // Verificar si el número está vacío
        if (empty($_POST["number"])) {
            echo json_encode(["error" => "Please enter an employee number"]);
        } else {
            $number = $_POST["number"];
            
            // Preparamos la consulta SQL para obtener los datos
            $stmt = $connection->prepare("CALL SP_getEmpInfo(?)");
            
            if (!$stmt) {
                echo json_encode(["error" => "Something went wrong"]);
                exit();
            }
            $stmt->execute([$number]);
            $result = $stmt->get_result();
    
            // Verificar si se encontró un usuario
            if ($data = $result->fetch_object()) {
                // Retornar los datos como JSON
                echo json_encode([
                    "name" => $data->nombre, // Verifica que el nombre de las columnas coincida
                    "surname" => $data->surname,
                    "lastname" => $data->lastname,
                    "email" => $data->email,
                    "position" => $data->Puesto,
                    "username" => $data->Usuario,
                    "role" => $data->Rol
                ]);
            } else {
                echo json_encode(["error" => "Data no found"]);
            }
        }
    } else {
        echo json_encode(["error" => "Connection failed"]);
    }
}

// Llamada a la función
getEmpInfo($connection);

?>