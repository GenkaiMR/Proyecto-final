<?php
include_once 'connection.php';  

$connection = connection();  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $code = $_POST['code'];
        $name = $_POST['name'];

        if($connection){
            $sql = "INSERT INTO ingredientes (codigo, descripcion) VALUES (?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ss", $code, $name);
            if ($stmt->execute()) {
                // Si la inserción fue exitosa
                echo json_encode(['success' => true]);
            } else {
                // Si hubo un error en la inserción
                echo json_encode(['success' => false, 'error' => 'Something went wrong inserting the customer data.']);
            }
        }

    }
?>
