<?php
include 'connection.php'; // Incluye el archivo de conexión

session_start();

// Establecer la conexión
$connection = connection(); // Llama a la función de conexión

if (!empty($_POST["login"])) {
    // Verificar si los campos están vacíos
    if (empty($_POST["user"]) || empty($_POST["password"])) {
        echo "<div>Please fill all the fields.</div>";
    } else {
        $user = $_POST["user"];
        $password = $_POST["password"];

        // Asegúrate de que $connection esté definida y sea válida
        if ($connection) {
            // Preparamos la consulta para obtener el usuario y su contraseña hasheada
            $stmt = $connection->prepare("SELECT * FROM usuario WHERE nombreUsuario = ?");
            if (!$stmt) {
                echo "Something went wrong with the preparation of the consultation: " . $connection->error;
                exit();
            }
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontró un usuario
            if ($data = $result->fetch_object()) {
                // Usar password_verify para comparar la contraseña proporcionada con el hash almacenado
                if (password_verify($password, $data->contrasenia)) {
                    // La contraseña es correcta, creamos la sesión
                    $_SESSION['nombreUsuario'] = $data->nombreUsuario;
                    
                    // Verificar el rol del usuario y redirigir a la página correspondiente
                    if ($data->rol == 'ADMIN' || $data->rol == 'admin') {
                        header("Location: Administrador/home.php");
                    } elseif ($data->rol == 'BASIC' || $data->rol == 'basic') {
                        header("Location: Basico/inicioBasic.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Role not found</div>';
                    }
                } else {
                    // La contraseña no es correcta
                    echo '<div class="alert alert-danger" role="alert">User or password are incorrect</div>';
                }
            } else {
                // El usuario no existe
                echo '<div class="alert alert-danger" role="alert">User not found</div>';
            }
        } else {
            echo "<div> Something went wrong with the database connection</div>";
        }
    }
}
?>
