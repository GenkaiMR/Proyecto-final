<?php
include_once 'connection.php';
$connect = connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taxname = $_POST['taxname'];
    
    // Verificar si el correo existe en la tabla de empleado
    $query = "SELECT COUNT(*) as count FROM cliente WHERE nombreFiscal = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $taxname);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Si el correo existe en la tabla empleado, retornamos 'exists' como true
        echo json_encode(['exists' => true]);
    } else {
        // Si el usuario no existe, retornamos 'exists' como false
        echo json_encode(['exists' => false]);
    }
}
?>