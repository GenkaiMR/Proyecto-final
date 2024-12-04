<?php
include_once 'connection.php';  

$connection = connection();  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $code = $_POST['codePres'];
        $name = $_POST['namePres'];
        $amount = $_POST['amountPres'];

        if($connection){
            $sql = "INSERT INTO tipo_presentacion (codigo, nombre, presentacion) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sss", $code, $name, $amount);
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