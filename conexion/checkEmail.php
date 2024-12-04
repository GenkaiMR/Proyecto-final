<?php
include_once 'connection.php';
$connect = connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar si el correo existe en la tabla de empleado
    $query = "SELECT COUNT(*) as count FROM empleado WHERE email = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Si el correo existe en la tabla empleado, retornamos 'exists' como true
        echo json_encode(['exists' => true]);
        exit;  // Terminamos el script para no hacer la segunda consulta
    }

    // Verificar si el correo existe en la tabla de cliente
    $query = "SELECT COUNT(*) as count FROM cliente WHERE email = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Si el correo existe en la tabla cliente, retornamos 'exists' como true
        echo json_encode(['exists' => true]);
    } else {
        // Si el correo no existe en ninguna tabla, retornamos 'exists' como false
        echo json_encode(['exists' => false]);
    }
}
?>