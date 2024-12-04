<?php
include_once 'connection.php';

$connection = connection();

function changePass($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $username = $_POST['showusername'];
        $password = $_POST['password'];

        // Hashear la contraseña antes de almacenarla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hasheamos la nueva contraseña

        // Actualizar usuario con la nueva contraseña hasheada
        $sql = "UPDATE usuario SET contrasenia = ? WHERE nombreUsuario = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param("ss", $hashedPassword, $username);
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["error" => "Something went wrong while updating user data"]);
            }
        } else {
            echo json_encode(["error" => "Something went wrong in the preparation of the consultation"]);
        }
    }
}

changePass($connection);

?>
