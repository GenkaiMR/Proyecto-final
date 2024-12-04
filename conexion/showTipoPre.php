<?php
include_once 'connection.php';

$connection = connection();

function sowTipoPre($connection) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = $_POST['code'];

        // Consulta para obtener el tipo de presentación correspondiente al código
        $sql_present = "SELECT p.tipo_presentacion, concat(tp.presentacion, ' ', tp.nombre) as tipo_nombre 
                        FROM producto as p 
                        INNER JOIN tipo_presentacion as tp 
                        ON p.tipo_presentacion = tp.codigo
                        WHERE p.codigo = ?";
        $res = $connection->prepare($sql_present);
        $res->bind_param("s", $code);
        $res->execute();
        $resultado = $res->get_result();

        $currentType = '';
        if ($resultado->num_rows > 0) {
            $data = $resultado->fetch_assoc();
            $currentType = $data['tipo_presentacion'];
            echo '<option value="'.$currentType.'" selected>'.$data['tipo_nombre'].'</option>';
        }

        // Consulta para obtener todas las opciones disponibles para el select
        $sql_present2 = "SELECT tp.codigo as tipo_presentacion, concat(tp.presentacion, ' ', tp.nombre) as tipo_nombre 
                         FROM tipo_presentacion as tp
                         WHERE tp.codigo != ?";
        $res2 = $connection->prepare($sql_present2);
        $res2->bind_param("s", $currentType);
        $res2->execute();
        $resultado2 = $res2->get_result();

        if ($resultado2->num_rows > 0) {
            while ($fila = $resultado2->fetch_assoc()) {
                echo '<option value="' . $fila['tipo_presentacion'] . '">' . $fila['tipo_nombre'] . '</option>';
            }
        } else {
            echo '<option value="">No data found</option>';
        }
    }
}

sowTipoPre($connection);
?>
