<?php
include_once 'connection.php';

$connection = connection();



function editEmployee($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $number = $_POST['number'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $position = $_POST['position'];  // Este es el puesto
        $user = $_POST['username'];
        $accessType = $_POST['role'];  // Este es el rol

        // Consultar ID del puesto
        $sqlPosition = "SELECT clave FROM puesto WHERE nombre = ?";
        $stmtPosition = $connection->prepare($sqlPosition);
        $stmtPosition->bind_param("s", $position);
        $stmtPosition->execute();
        $resultPosition = $stmtPosition->get_result();

        $positionId = null;
        if ($resultPosition->num_rows > 0) {
            $row = $resultPosition->fetch_assoc();
            $positionId = $row['clave']; // Deberías asegurar que el nombre de la columna sea correcto
        }

        // Consultar ID del rol
        $sqlRole = "SELECT codigo FROM rol WHERE nombre = ?";
        $stmtRole = $connection->prepare($sqlRole);
        $stmtRole->bind_param("s", $accessType);
        $stmtRole->execute();
        $resultRole = $stmtRole->get_result();
        
        $roleId = null;
        if ($resultRole->num_rows > 0) {
            $row = $resultRole->fetch_assoc();
            $roleId = $row['codigo'];
        }

        // Consultar ID del usuario
        $sqlUser = "SELECT usuario FROM empleado WHERE numero = ?";
        $stmtUser = $connection->prepare($sqlUser);
        $stmtUser->bind_param("s", $number);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        
        $userID = null;
        if ($resultUser->num_rows > 0) {
            $row = $resultUser->fetch_assoc();
            $userId = $row['usuario'];
        }

        // Actualizar usuario
        $sql = "UPDATE usuario SET nombreUsuario = ?, rol = ? WHERE numero = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param("sss", $user, $roleId, $userId);
            if ($stmt->execute()) {
                // Ahora actualizar empleado
                $sql2 = "UPDATE empleado SET nombre = ?, primApellido = ?, segApellido = ?, email = ?, puesto = ? WHERE numero = ?";
                $stmt2 = $connection->prepare($sql2);
                $stmt2->bind_param("ssssss", $name, $surname, $lastname, $email, $positionId, $number);
                
                if ($stmt2->execute()) {
                    echo json_encode(["success" => true]);
                } else {
                    echo json_encode(["error" => "Something went wrong while updating employee data"]);
                }
            } else {
                echo json_encode(["error" => "Something went wrong while updating employee data"]);
            }
        } else {
            echo json_encode(["error" => "Something went wrong in the preparation of the consultation"]);
        }
    }
}

editEmployee($connection);

?>
