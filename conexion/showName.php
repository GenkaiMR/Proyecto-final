<?php
include_once 'connection.php';

$connection = connection();

// Verificar si la variable de sesión que contiene el nombre de usuario está establecida
if (isset($_SESSION['nombreUsuario'])) {
    $user = $_SESSION['nombreUsuario'];

    if ($connection) {
        $stmt = $connection->prepare("SELECT 
                                        nombre
                                        FROM empleado AS e 
                                        INNER JOIN usuario AS u ON e.usuario = u.numero
                                        WHERE nombreUsuario = ?");
        
        if (!$stmt) {
            echo "Something went wrong in the preparation of the consultation: ";
            exit();
        }
        
        // Solo necesitas un parámetro, que es el username
        $stmt->bind_param("s", $user); // Solo un string

        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró un usuario
        if ($data = $result->fetch_object()) {
            // Mostrar los datos del usuario
            echo "Welcome " . $data->nombre;
        } else {
            echo "Data not found". $connection->error;
        }
    } else {
        echo "<div>Connection failed</div>";
    }
} else {
    echo "User not logged in";
}
?>
