<?php
include_once 'connection.php';

$connection = connection();

function displayUserInfo($connection) {
    if (isset($_SESSION['nombreUsuario'])) {
        $user = $_SESSION['nombreUsuario'];

        if ($connection) {
            $stmt = $connection->prepare("
                SELECT 
                    CONCAT(IFNULL(CONCAT(e.nombre, ' '), ''),
                           IFNULL(CONCAT(e.primApellido, ' '), ''),
                           IFNULL(CONCAT(e.segApellido, ' '), '')) AS Nombre,
                    p.nombre AS Puesto,
                    r.nombre AS Rol
                FROM empleado AS e 
                INNER JOIN usuario AS u ON e.usuario = u.numero
                INNER JOIN puesto AS p ON e.puesto = p.clave 
                INNER JOIN rol AS r ON u.rol = r.codigo
                WHERE u.nombreUsuario = ?");
            
            if (!$stmt) {
                echo "Something went wrong in the preparation of the consultation: ";
                exit();
            }
            
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontró un usuario
            if ($data = $result->fetch_object()) {
                // Mostrar los datos del usuario
                echo "<p>Name: " . $data->Nombre . "</p>";
                echo "<p>Position: " . $data->Puesto . "</p>";
                echo "<p>Access type: " . $data->Rol . "</p>";
            } else {
                echo "Data not found: ";
            }
        } else {
            echo "<div>Connection failed</div>";
        }
    } else {
        echo "User not logged in";
    }
}

// Llama a la función para mostrar la información del usuario
displayUserInfo($connection);
?>
