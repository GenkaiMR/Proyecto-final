<?php
include_once 'connection.php';

$connection = connection();

// Consulta para obtener los puestos
$sql = "SELECT clave, nombre FROM puesto";
$resultado = $connection->query($sql);

    echo '<option value="" > Choose a position  </option>';
    if ($resultado->num_rows > 0) {
        // Recorrer las filas para mostrar las opciones de los puestos
        while ($fila = $resultado->fetch_assoc()) {
            $selected = (isset($_POST['position']) && $_POST['position'] == $fila['clave']) ? 'selected' : ''; // Compara el valor con el valor del formulario
            echo '<option value="' . $fila['clave'] . '" ' . $selected . '>' . $fila['nombre'] . '</option>';
        }
    } else {
        echo '<option value="">Data not found</option>';
    }

?>
