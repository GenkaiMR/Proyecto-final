<?php

include_once 'connection.php';
$connect = connection();

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los datos del formulario
    $tradeName = $_POST['taxname'];
    $contactName = $_POST['contactname'];
    $lastname1 = $_POST['surname'];
    $lastname2 = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['numTel'];

    // Validar que los nombres no contengan números o caracteres no permitidos
    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s\-]+$/", $contactName)) {
        echo json_encode(['error' => 'The contact name cannot contain numbers or invalid characters.']);
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s\-]+$/", $lastname1)) {
        echo json_encode(['error' => 'The middle name cannot contain numbers or invalid characters.']);
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s\-]+$/", $lastname2)) {
        echo json_encode(['error' => 'The last name cannot contain numbers or invalid characters.']);
    }


    // Validar si el correo electrónico ya existe
    $emailCheckQuery = "SELECT * FROM cliente WHERE email = ?";
    $stmt = $connect->prepare($emailCheckQuery);
    $stmt->bind_param('s', $email);  // 's' para string (correo electrónico)
    $stmt->execute();
    $emailResult = $stmt->get_result();

    // Validar si el teléfono ya existe
    $phoneCheckQuery = "SELECT * FROM cliente WHERE numTel = ?";
    $stmt = $connect->prepare($phoneCheckQuery);
    $stmt->bind_param('s', $phone);  // 's' para string (número de teléfono)
    $stmt->execute();
    $phoneResult = $stmt->get_result();

    // Si el correo ya está registrado
    if ($emailResult->num_rows > 0) {
        echo json_encode(['error' => 'The email is already registered.']);
    }

    // Si el teléfono ya está registrado
    if ($phoneResult->num_rows > 0) {
        echo json_encode(['error' => 'The phone number is already registered.']);
    }

    // Si no hay duplicados, insertar el nuevo cliente
    $insertQuery = "INSERT INTO cliente (nombreFiscal, nombreCont, primApellido, segApellido, email, numTel) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertQuery);
    $stmt->bind_param('ssssss', $tradeName, $contactName, $lastname1, $lastname2, $email, $phone);

    if ($stmt->execute()) {
        // Si la inserción fue exitosa
        echo json_encode(['success' => true]);
    } else {
        // Si hubo un error en la inserción
        echo json_encode(['success' => false, 'error' => 'Something went wrong while inserting the customer data.']);
    }
}
?>

