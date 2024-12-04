<?php
include_once 'connection.php';

$connection = connection();

function showMatEmp($connection) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['code'])) {
            echo json_encode(['error' => 'Code parameter missing']);
            exit;
        }
        
        $code = $_POST['code'];  // Asegúrate de recibir el 'code'
        $response = ['materials' => []];

        $sql_mat = "SELECT ep.mat_empaque as matEmp, 
                        me.nombre as nomEmp, 
                        ep.cantMatxProd as cant 
                    from emp_producto as ep 
                    inner join mat_empaque as me on ep.mat_empaque = me.codigo
                    where ep.producto = ?";
        
        $res1 = $connection->prepare($sql_mat);
        $res1->bind_param("s", $code);
        $res1->execute();
        $resultado1 = $res1->get_result();

        if ($resultado1->num_rows > 0) {
            while ($data = $resultado1->fetch_assoc()) {
                $currentMaterial = $data['matEmp'];
                $nameMaterial = $data['nomEmp'];

                $sql_ingre2 = "SELECT codigo, nombre from mat_empaque 
                               where codigo != ?";
                $res2 = $connection->prepare($sql_ingre2);
                $res2->bind_param("s", $currentMaterial);
                $res2->execute();
                $resultado2 = $res2->get_result();

                $materialOptions = [];
                while ($fila = $resultado2->fetch_assoc()) {
                    $materialOptions[] = [
                        'value' => $fila['codigo'],
                        'label' => $fila['nombre']
                    ];
                }

                $response['materials'][] = [
                    'currentActive' => [
                        'value' => $currentMaterial,
                        'label' => $nameMaterial,
                        'quantity' => $data['cant']
                    ],
                    'options' => $materialOptions
                ];
            }
        }

        echo json_encode($response);  // Asegúrate de que la respuesta sea en formato JSON
    }
}

showMatEmp($connection);
?>
