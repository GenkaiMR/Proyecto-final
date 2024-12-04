<?php
include_once 'connection.php';  

$connection = connection();  

function insert_Product($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtener los datos del formulario (Ajustando los nombres de las variables)
        $code = $_POST['code'];  // Este es el código del producto
        $productName = $_POST['productName'];  // Nombre del producto
        $chemName = $_POST['chemName'];  // Nombre químico
        $presentation = $_POST['presentation'];  // Presentación del producto
        $measure = $_POST['measure'];  // Unidad de medida
        $prodType = $_POST['prodType'];  // Tipo de producto (FARMA o SUPLE)

        if ($connection) {
            
            // Realizar el UPDATE principal del producto
            $sql_product = "UPDATE producto SET nombre = ?, nombreGenerico = ?, tipo_producto = ?, tipo_presentacion = ? WHERE codigo = ?";
            $stmt_prod = $connection->prepare($sql_product);
            $stmt_prod->bind_param("sssss", $productName, $chemName, $prodType, $presentation, $code); 
            if ($stmt_prod->execute()) {

                // Verificar si el tipo de producto es 'FARMA' o 'SUPLE'
                if ($prodType === 'FARMA') { // Verificación original para 'FARMA'
                    // Ingredientes
                    $curIngre = $_POST['currentIngredient'];  // Ingredientes actuales
                    $ingredients = $_POST['ingredient'];  // Ingredientes
                    $quantities = $_POST['quantity'];  // Cantidades de los ingredientes

                    // Ingredientes activos
                    $curActive = $_POST['currentActive'];  // Ingredientes activos actuales
                    $activIng = $_POST['actIngredient'];  // Ingredientes activos
                    $quantitesAct = $_POST['quantityAct'];  // Cantidades de ingredientes activos

                    // Materiales de empaque
                    $curMat = $_POST['curMaterial'];  // Materiales actuales
                    $material = $_POST['material'];  // Materiales
                    $quantitiesMat = $_POST['quantityMat'];  // Cantidades de materiales

                    // Procesar ingredientes
                    if (!empty($ingredients)) {
                        $sql_ingredient = "UPDATE formula SET ingredientes = ?, cantidadIng = ?, uniMed = ? WHERE producto = ? AND ingredientes = ?";
                        $stmt_ingred = $connection->prepare($sql_ingredient);

                        for ($i = 0; $i < count($ingredients); $i++) {
                            if (!empty($ingredients[$i])) {
                                $ingredient = $ingredients[$i];
                                $quantity = $quantities[$i];
                                $curreIngre = $curIngre[$i];

                                $stmt_ingred->bind_param("sssss", $ingredient, $quantity, $measure, $code, $curreIngre);
                                if (!$stmt_ingred->execute()) {
                                    echo json_encode(['success' => false, 'error' => 'Something went wrong while updating the ingredients.']);
                                    exit;
                                }
                            }
                        }
                    }

                    // Insertar ingredientes activos
                    $sql_actIngre = "UPDATE form_act SET ingr_activo = ?, cantidadAct = ?, uniMed = ? WHERE producto = ? AND ingr_activo = ?";
                    $stmt_actIng = $connection->prepare($sql_actIngre);

                    for ($i = 0; $i < count($activIng); $i++) {
                        $ingre = $activIng[$i];
                        $quant = $quantitesAct[$i];
                        $curreAct = $curActive[$i];

                        $stmt_actIng->bind_param("sssss", $ingre, $quant, $measure, $code, $curreAct);
                        if (!$stmt_actIng->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting the active ingredients.']);
                            exit;
                        }
                    }

                    // Insertar materiales de empaque
                    $sql_mat = "UPDATE emp_producto SET mat_empaque = ?, cantMatxProd = ? WHERE producto = ? AND mat_empaque = ?";
                    $stmt_mate = $connection->prepare($sql_mat);

                    for ($i = 0; $i < count($material); $i++) {
                        $mat = $material[$i];
                        $quantityMat = $quantitiesMat[$i];
                        $curreMat = $curMat[$i];

                        $stmt_mate->bind_param("ssss", $mat, $quantityMat, $code, $curreMat);
                        if (!$stmt_mate->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting the packaging materials.']);
                            exit;
                        }
                    }
                } else if ($prodType === 'SUPLE') { // Verificación para 'SUPLE'
                    // Ingredientes
                    $curIngreSup = $_POST['currentIngredient'];  // Ingredientes actuales
                    $ingredientSup = $_POST['ingredientSuple'];  // Ingredientes
                    $quantitiesSup = $_POST['quantitySup'];  // Cantidades de los ingredientes

                    // Materiales de empaque
                    $curMatSup = $_POST['curMaterial'];  // Materiales actuales
                    $materialSup = $_POST['materialSuple'];  // Materiales
                    $quantitiesMatSup = $_POST['quantityMatSup'];  // Cantidades de materiales

                    // Procesar ingredientes para tipo SUPLE
                    if (!empty($ingredientSup)) {
                        $sql_ingredient = "UPDATE formula SET ingredientes = ?, cantidadIng = ?, uniMed = ? WHERE producto = ? AND ingredientes = ?";
                        $stmt_ingred = $connection->prepare($sql_ingredient);

                        for ($i = 0; $i < count($ingredientSup); $i++) {
                            if (!empty($ingredientSup[$i])) {
                                $ingredient = $ingredientSup[$i];
                                $quantitySup = $quantitiesSup[$i];
                                $curreIngreSup = $curIngreSup[$i];

                                $stmt_ingred->bind_param("sssss", $ingredient, $quantitySup, $measure, $code, $curreIngreSup);
                                if (!$stmt_ingred->execute()) {
                                    echo json_encode(['success' => false, 'error' => 'Something went wrong while updating the ingredients.']);
                                    exit;
                                }
                            }
                        }
                    }

                    // Insertar materiales de empaque
                    $sql_mat = "UPDATE emp_producto SET mat_empaque = ?, cantMatxProd = ? WHERE producto = ? AND mat_empaque = ?";
                    $stmt_mate = $connection->prepare($sql_mat);

                    for ($i = 0; $i < count($materialSup); $i++) {
                        $mat = $materialSup[$i];
                        $quantitySup = $quantitiesMatSup[$i];

                        $stmt_mate->bind_param("ssss", $mat, $quantitySup, $code, $curMatSup[$i]);
                        if (!$stmt_mate->execute()) {
                            echo json_encode(['success' => false, 'error' => 'Something went wrong when inserting the packaging materials.']);
                            exit;
                        }
                    }
                }

                // Si todo fue exitoso
                echo json_encode(['success' => true, 'message' => 'Successfully updated product.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Something went wrong while updating the product.']);
            }
        }
    }
}

insert_Product($connection);
?>
