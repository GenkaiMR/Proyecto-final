<?php
include_once 'connection.php';

$connection = connection();





function getUserInfo($connection) {
    if ($connection) {
        // Verificar si el número está vacío
        if (empty($_POST["getUsername"])) {
            echo json_encode(["error" => "please enter an employee number"]);
        } else {
            $user = $_POST["getUsername"];
            
            // Preparamos la consulta SQL para obtener los datos
            $stmt = $connection->prepare("call SP_getUserInfo(?)");
            
            if (!$stmt) {
                echo json_encode(["error" => "Something went wrong"]);
                exit();
            }
            $stmt->execute([$user]);
            $result = $stmt->get_result();
    
            // Verificar si se encontró un usuario
            if ($data = $result->fetch_object()) {
                // Retornar los datos como JSON
                echo json_encode([
                    "name" => $data->nombre, // Verifica que el nombre de las columnas coincida
                    "surname" => $data->surname,
                    "lastname" => $data->lastname,
                    "username" => $data->Usuario
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
getUserInfo($connection);

?>