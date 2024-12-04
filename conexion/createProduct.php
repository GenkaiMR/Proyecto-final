<?php
include_once 'connection.php';  

$connection = connection();  

function insert_Product($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['usuario'];
    
        // Obtener los datos del formulario
        $productName = $_POST['productName'];
        $chemName = $_POST['chemName'];
        $presentation = $_POST['presentation'];
        $measure = $_POST['measure'];
        $prodType = $_POST['prodType'];

        if ($connection) {
            // Obtener el ID del usuario
            $sql_userId = $connection->prepare("SELECT e.numero FROM usuario as u INNER JOIN empleado as e ON e.usuario = u.numero WHERE nombreUsuario = ?");
            $sql_userId->bind_param("s", $user);
            $sql_userId->execute();
            $result = $sql_userId->get_result();
            $userId = $result->fetch_assoc()['numero'];  // Extraer el campo 'numero' del resultado

            // Realizar el INSERT principal del producto
            $sql_product = "INSERT INTO producto (nombre, nombreGenerico, empleado, tipo_producto, tipo_presentacion) VALUES (?, ?, ?, ?, ?)";
            $stmt_prod = $connection->prepare($sql_product);
            $stmt_prod->bind_param("sssss", $productName, $chemName, $userId, $prodType, $presentation); 
            if ($stmt_prod->execute()) {    
                $product_id = $connection->insert_id;  // Obtener el ID del producto insertado

                if ($prodType === 'FARMA') {
                    $ingredients = $_POST['ingredient'];  
                    $quantities = $_POST['quantity'];

                    $activIng = $_POST['activeIng'];  
                    $quantitesAct = $_POST['quantityAct'];    

                    $material = $_POST['material'];  
                    $quantitiesMat = $_POST['quantityMat']; 

                    if (!empty($ingredients)) {
                        $sql_ingredient = "INSERT INTO formula (producto, ingredientes, cantidadIng, uniMed) VALUES (?, ?, ?, ?)";
                        $stmt_ingred = $connection->prepare($sql_ingredient);

                        for ($i = 0; $i < count($ingredients); $i++) {
                            if (!empty($ingredients[$i])) {
                                $ingredient = $ingredients[$i];
                                $quantity = $quantities[$i];
                                $stmt_ingred->bind_param("ssss", $product_id, $ingredient, $quantity, $measure);
                                if (!$stmt_ingred->execute()) {
                                    echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting ingredients.']);
                                }
                            } else {
                                echo json_encode(['success' => false, 'error' => 'The ingredient in the index ' . $i . ' is empty.']);
                            }
                        }
                    } else {
                        echo json_encode(['success' => false, 'error' => 'No ingredients provided.']);
                    }

                    // Insertar ingredientes activos y cantidades
                    $sql_actIngre = "INSERT INTO form_act (ingr_activo, producto, cantidadAct, uniMed) VALUES (?, ?, ?, ?)";
                    $stmt_actIng = $connection->prepare($sql_actIngre);

                    for ($i = 0; $i < count($activIng); $i++) {
                        $ingre = $activIng[$i];
                        $quant = $quantitesAct[$i];

                        $stmt_actIng->bind_param("ssss", $ingre, $product_id, $quant, $measure);
                        if (!$stmt_actIng->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting active ingredients.']);
                        }
                    }

                    // Insertar materiales de empaque y cantidades
                    $sql_mat = "INSERT INTO emp_producto (producto, mat_empaque, cantMatxProd) VALUES (?, ?, ?)";
                    $stmt_mate = $connection->prepare($sql_mat);

                    for ($i = 0; $i < count($material); $i++) {
                        $mat = $material[$i];
                        $quantityMat = $quantitiesMat[$i];

                        $stmt_mate->bind_param("sss", $product_id, $mat, $quantityMat);
                        if (!$stmt_mate->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting packaging materials.']);
                        }
                    }
                } else if ($prodType === 'SUPLE') {
                    $ingredientSup = $_POST['ingredientSuple'];
                    $quantitiesSup = $_POST['quantitySup'];

                    $materialSup = $_POST['materialSuple'];
                    $quantitiesMatSup = $_POST['quantityMatSup'];

                    // Insertar ingredientes para tipo SUPLE
                    $sql_ingredient = "INSERT INTO formula (producto, ingredientes, cantidadIng, uniMed) VALUES (?, ?, ?, ?)";
                    $stmt_ingred = $connection->prepare($sql_ingredient);

                    for ($i = 0; $i < count($ingredientSup); $i++) {
                        $ingredient = $ingredientSup[$i];
                        $quantitySup = $quantitiesSup[$i];
                        $stmt_ingred->bind_param("ssss", $product_id, $ingredient, $quantitySup, $measure);
                        if (!$stmt_ingred->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting ingredients.']);
                        }
                    }

                    // Insertar materiales de empaque
                    $sql_mat = "INSERT INTO emp_producto (producto, mat_empaque, cantMatxProd) VALUES (?, ?, ?)";
                    $stmt_mate = $connection->prepare($sql_mat);

                    for ($i = 0; $i < count($materialSup); $i++) {
                        $mat = $materialSup[$i];
                        $quantitySup = $quantitiesMatSup[$i];

                        $stmt_mate->bind_param("sss", $product_id, $mat, $quantitySup);
                        if (!$stmt_mate->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting packaging materials.']);
                        }
                    }
                }

                // Si todo fue exitoso
                echo json_encode(['success' => true, 'message' => 'Product and ingredients successfully created!']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting the product.']);
            }
        } 
    }
}

insert_Product($connection);
?>
