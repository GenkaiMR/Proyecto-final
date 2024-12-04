<?php
include_once 'connection.php';

$connection = connection();

function getEmpInfo($connection) {
    if ($connection) {
        // Verificar si el número está vacío
        if (empty($_POST["number"])) {
            echo json_encode(["error" => "Please enter a customer number"]);
        } else {
            $number = $_POST["number"];
            
            // Preparamos la consulta SQL para obtener los datos
            $stmt = $connection->prepare("CALL SP_getInfoCus(?)");
            
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
                    "taxname" => $data->taxname,
                    "contactname" => $data->contactname,
                    "surname" => $data->surname,
                    "lastname" => $data->lastname,
                    "email" => $data->email,
                    "numTel" => $data->numTel
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
