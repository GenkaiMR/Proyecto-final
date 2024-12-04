<?php
include_once 'connection.php';

$connection = connection();



function editEmployee($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $number = $_POST['number'];
        $taxname = $_POST['taxname'];
        $contactname = $_POST['contactname'];
        $surname = $_POST['surname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $numTel = $_POST['numTel'];

                // Actualiza el cliente
                $sql = "UPDATE cliente SET nombreFiscal = ?, nombreCont = ?, primApellido = ?, segApellido = ?, email = ?, numTel = ? WHERE numero = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("sssssss", $taxname, $contactname ,$surname, $lastname, $email, $numTel, $number);
                
                if ($stmt->execute()) {
                    echo json_encode(["success" => true]);
                } else {
                    echo json_encode(["error" => "Something went wrong while updating employee data"]);
                }
            } else {
                echo json_encode(["error" => "Something went wrong while updating user data"]);
            }
}
editEmployee($connection);

?>