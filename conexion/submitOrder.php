<?php

include_once 'connection.php';

$connection = connection();

function registerOrder($connection) {
    header('Content-Type: application/json'); // Configurar la cabecera para JSON
    session_start(); // Iniciar la sesión para usar variables de $_SESSION

    $response = ["success" => false, "error" => ""]; // Inicializar la respuesta

    // Verificar que el método sea POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $customer = $_POST['customer'] ?? null;
        $product = $_POST['product'] ?? null;
        $quantity = $_POST['unitsQty'] ?? null;
        $date = $_POST['delivery'] ?? null;

        // Verifica que la sesión esté iniciada
        if (!isset($_SESSION['nombreUsuario'])) {
            $response["error"] = "There is no user logged in.";
            echo json_encode($response);
            exit;
        }

        $user = $_SESSION['nombreUsuario'];

        // Validar campos vacíos
        if (empty($customer) || empty($product) || empty($quantity) || empty($date)) {
            $response["error"] = "Please complete all fields.";
            echo json_encode($response);
            exit;
        }

        // Validar conexión
        if (!$connection) {
            $response["error"] = "Connection failed.";
            echo json_encode($response);
            exit;
        }

        // Preparar la consulta para obtener el número del empleado
        $stmt = $connection->prepare("SELECT e.numero FROM empleado AS e INNER JOIN usuario AS u ON e.usuario = u.numero WHERE u.nombreUsuario = ?");
        if (!$stmt) {
            $response["error"] = "Something went wrong in the preparation of the consultation";
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($data = $result->fetch_assoc()) {
            $employeeNumber = $data['numero'];

            // Preparar la consulta para insertar los datos en la tabla pedido
            $sql2 = "INSERT INTO pedido (fecha, fechaEntrega, cantProducto, producto, cliente, empleado) VALUES (CURRENT_DATE(), ?, ?, ?, ?, ?)";
            $stmt2 = $connection->prepare($sql2);
            if (!$stmt2) {
                $response["error"] = "Something went wrong in the insertion preparation";
                echo json_encode($response);
                exit;
            }

            // Vincular los parámetros
            $stmt2->bind_param("sssss", $date, $quantity, $product, $customer, $employeeNumber);

            if ($stmt2->execute()) {
                $response["success"] = true; // Si la inserción fue exitosa
            } else {
                $response["error"] = "Something went wrong when creating the order";
            }

        } else {
            $response["error"] = "Associated user not found.";
        }
    } else {
        $response["error"] = "Disallowed method.";
    }

    echo json_encode($response);
    exit;
}

registerOrder($connection);

?>