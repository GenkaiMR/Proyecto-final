<?php
include_once 'connection.php';

$connection = connection();

function showFormula($connection) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = $_POST['code'];  // Código del producto enviado por AJAX

        $response = [
            'ingredients' => []  // Solo devolvemos los ingredientes (vacío si no hay)
        ];

        // Consulta para obtener todos los ingredientes activos asociados al producto
        $sql_ingre = "SELECT fa.ingr_activo,
                        ia.nomIngrediente,
                        fa.cantidadAct
                     FROM form_act AS fa
                     INNER JOIN ingr_activo AS ia ON fa.ingr_activo = ia.codigo
                     WHERE fa.producto = ?";
        $res1 = $connection->prepare($sql_ingre);
        $res1->bind_param("s", $code);
        $res1->execute();
        $resultado1 = $res1->get_result();

        // Si se encuentran ingredientes, agregarlos a la respuesta
        if ($resultado1->num_rows > 0) {
            while ($data = $resultado1->fetch_assoc()) {
                $currentIngredient = $data['ingr_activo'];
                $ingredientDescription = $data['nomIngrediente'];

                // Excluimos este ingrediente de la lista de opciones
                $sql_ingre2 = "SELECT codigo,
                                      nomIngrediente
                               FROM ingr_activo
                               WHERE codigo != ?";
                $res2 = $connection->prepare($sql_ingre2);
                $res2->bind_param("s", $currentIngredient);
                $res2->execute();
                $resultado2 = $res2->get_result();

                $ingredientOptions = [];
                while ($fila = $resultado2->fetch_assoc()) {
                    $ingredientOptions[] = [
                        'value' => $fila['codigo'],
                        'label' => $fila['nomIngrediente']
                    ];
                }

                $response['ingredients'][] = [
                    'currentActive' => [
                        'value' => $currentIngredient,
                        'label' => $ingredientDescription,
                        'quantity' => $data['cantidadAct']
                    ],
                    'options' => $ingredientOptions
                ];
            }
        }

        // Devolvemos solo los ingredientes (vacío si no hay)
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

showFormula($connection);
?>
