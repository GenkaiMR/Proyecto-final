<?php
include_once 'connection.php';

$connection = connection();

function showFormula($connection) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = $_POST['code'];  // Código del producto enviado por AJAX

        $response = [
            'ingredients' => [],
            'error' => ''
        ];

        // Consulta para obtener todos los ingredientes regulares asociados al producto
        $sql_ingre = "SELECT f.ingredientes, i.descripcion, f.cantidadIng
                      FROM formula AS f
                      INNER JOIN ingredientes AS i ON f.ingredientes = i.codigo
                      WHERE f.producto = ?";
        $res1 = $connection->prepare($sql_ingre);
        $res1->bind_param("s", $code);
        $res1->execute();
        $resultado1 = $res1->get_result();

        // Si se encuentran ingredientes, agregarlos a la respuesta
        if ($resultado1->num_rows > 0) {
            while ($data = $resultado1->fetch_assoc()) {
                $currentIngredient = $data['ingredientes'];
                $ingredientDescription = $data['descripcion'];

                // Excluimos este ingrediente de la lista de opciones
                $sql_ingre2 = "SELECT codigo,
                                    descripcion
                                    from ingredientes
                                    where codigo != ?";
                $res2 = $connection->prepare($sql_ingre2);
                $res2->bind_param("s", $currentIngredient);
                $res2->execute();
                $resultado2 = $res2->get_result();

                $ingredientOptions = [];
                while ($fila = $resultado2->fetch_assoc()) {
                    $ingredientOptions[] = [
                        'value' => $fila['codigo'],
                        'label' => $fila['descripcion']
                    ];
                }

                $response['ingredients'][] = [
                    'current' => [
                        'value' => $currentIngredient,
                        'label' => $ingredientDescription,
                        'quantity' => $data['cantidadIng']
                    ],
                    'options' => $ingredientOptions
                ];
            }
        } else {
            $response['error'] = 'No ingredients found.';
        }

        // Devolvemos la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

showFormula($connection);
?>
