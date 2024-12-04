<?php
include_once 'connection.php';

$connection = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $order = $_POST['Numero'];   // Número de la orden
    $status = $_POST['status'];  // Nombre del nuevo estado

                // Paso 2: Actualizar el estado de la orden con el ID del estado
                $updateSql = "UPDATE orden SET estado_orden = ? WHERE numero = ?";
                if ($updateStmt = $connection->prepare($updateSql)) {
                    $updateStmt->bind_param("ss", $status, $order);  // Vincula los parámetros correctamente
                    if ($updateStmt->execute()) {
                        echo json_encode(["success" => true]);  // Respuesta si la actualización es exitosa
                    } else {
                        echo json_encode(["error" => "Something went wrong while updating the order status"]);
                    }
                } else {
                    echo json_encode(["error" => "Something went wrong preparing the update query"]);
                }
            }
?>
