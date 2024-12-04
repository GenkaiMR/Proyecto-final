<?php


function get_trade_name(){
include_once 'connection.php';

$connection = connection();

// Consulta para obtener los clientes
$sql = "SELECT numero, nombreFiscal FROM cliente";
$resultado = $connection->query($sql);

    echo '<option value="" > Choose a Customber </option>';
if ($resultado->num_rows > 0) {
    // Agregar una opción por cada cliente
    while ($fila = $resultado->fetch_assoc()) {
        echo '<option value="' . $fila['numero'] . '">' . $fila['nombreFiscal'] . '</option>';
    }
} else {
    echo '<option value="">Data not found</option>';
}
$connection->close();
}

function get_product_name(){
    include_once 'connection.php';
    
    $connect = connection();
    
    // Consulta para obtener los productos
    $sql = "SELECT codigo, nombre FROM producto";
    $result = $connect->query($sql);
    
        echo '<option value="" > Choose a Product </option>';
    if ($result->num_rows > 0) {
        // Agregar una opción por cada producto
        while ($fila = $result->fetch_assoc()) {
            echo '<option value="' . $fila['codigo'] . '">' . $fila['nombre'] . '</option>';
        }
    } else {
        echo '<option value="">Data not found</option>';
    }
    $connect->close();
}
















?>