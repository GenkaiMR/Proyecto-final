<?php

include_once 'connection.php';

$connection = connection();

function registerEmployee($connection) {
    header('Content-Type: application/json'); // Configurar la cabecera para JSON
    $response = ["success" => false]; // Inicializar respuesta predeterminada

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Obtener los datos del formulario
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $position = $_POST['position'];
            $user = $_POST['username'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];
            $accessType = $_POST['role'];


            // Hashear la contraseña antes de almacenarla
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUser = "INSERT INTO usuario (nombreUsuario, contrasenia, rol) VALUES (?, ?, ?)";
            $stmtUser = $connection->prepare($sqlUser);
            $stmtUser->bind_param("sss", $user, $hashedPassword, $accessType);
            if (!$stmtUser->execute()) {
                throw new Exception("Something went wrong while inserting user data");
            }
            $userId = $connection->insert_id;

            // Insertar en la tabla empleado
            $sqlEmployee = "INSERT INTO empleado (nombre, primApellido, segApellido, email, usuario, puesto) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtEmployee = $connection->prepare($sqlEmployee);
            $stmtEmployee->bind_param("ssssss", $name, $surname, $lastname, $email, $userId, $position);
            if (!$stmtEmployee->execute()) {
                throw new Exception("Something went wrong while inserting user data");
            }

            // Si todo fue exitoso
            $response["success"] = true;

        } catch (Exception $e) {
            $response["error"] = $e->getMessage(); // Capturar errores
        }
    } else {
        $response["error"] = "Disallowed method";
    }

    echo json_encode($response); // Devolver respuesta como JSON
}

registerEmployee($connection);

?>
