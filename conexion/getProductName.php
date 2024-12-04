<?php
include_once 'connection.php';

$connection = connection();

// Consulta para obtener los puestos
$sql = "SELECT codigo, nombre FROM producto";
$resultado = $connection->query($sql);

    echo '<option value="" > Choose a Product </option>';
if ($resultado->num_rows > 0) {
    // Agregar una opción por cada puesto
    while ($fila = $resultado->fetch_assoc()) {
        $selected = (isset($_POST['prodName']) && $_POST['prodName'] == $fila['codigo'])? 'selected': '';
        echo '<option value="' . $fila['codigo'] . '" ' . $selected . '>' . $fila['nombre'] . '</option>';
    }
} else {
    echo '<option value="">Data not  found</option>';
}

?>
