<?php
include_once 'connection.php';

$connection = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order = $_POST['Number']; // Obtener el número de orden

    // Primero, obtener el estado actual de la orden
    $sql = "SELECT descripcion, estado_orden FROM estado_orden as e 
            INNER JOIN orden as o ON e.codigo = o.estado_orden 
            WHERE o.numero = ?";
    $result = $connection->prepare($sql);
    $result->bind_param("s", $order);
    $result->execute();
    $resulta = $result->get_result();

    // Verificar si se encuentra el estado de la orden
    $currentStatus = '';
    if ($resulta->num_rows > 0) {
        $data = $resulta->fetch_assoc();
        $currentStatus = $data['estado_orden']; // Obtener el código del estado actual
        echo '<option value="' . $currentStatus . '" selected>' . $data['descripcion'] . '</option>';
    }

    // Ahora, obtener todos los estados disponibles, excluyendo el estado actual
    $sql = "SELECT codigo, descripcion FROM estado_orden WHERE codigo != ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $currentStatus); // Excluir el estado actual
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Mostrar los estados en el desplegable
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['codigo'] . '">' . $fila['descripcion'] . '</option>';
        }
    } else {
        echo '<option value="">No data found</option>';
    }
}
?>
