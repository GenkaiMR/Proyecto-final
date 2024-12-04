<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="../css/productForm.css">
    <title>Products & Formulation</title> 
    <link rel="icon" href="../imagenes/icono.png" type="imagen/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <?php 

session_start();
    include '../footer-nav/header.php';
    include '../footer-nav/navAdmin.php';
    include '../conexion/connection.php';
    $connect = connection();
    $sql = "CALL SP_show_ProductosyFormu()";
    $result = $connect->query($sql);
    ?>

    <div class="btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#createProduct">Register</a>
    </div> 
    <div class="btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editProd">Edit</a>
    </div> 

    <div class="btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#material">Material</a>
    </div> 

    <div class="title exo-2-uniquifier" >
<h1>PRODUCTS & FORMULATION</h1>

</div>

    </section>

<section class="main-section">

<div class="contenido">
    <div class="con">
    <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>NUMBER</th>
                        <th>PRODUCT NAME</th>
                        <th>GENERIC NAME</th>
                        <th>PRODUCT TYPE</th>
                        <th>PRESENTATION</th>
                        <th>FORMULATION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Revisar si hay resultados
                        if ($result->num_rows > 0) {
                        // Salida de datos de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["CODE"] .  "</td>";
                            echo "<td>" . $row["NAME"] . "</td>";
                            echo "<td>" . $row["GENERIC"] . "</td>";
                            echo "<td>" . $row["TYPE"] . "</td>";
                            echo "<td>" . $row["PRESENTATION"] . "</td>";
                            echo '<td><div class="btn-stat">
                                        <a type="submit" href="#" data-id="'.$row["CODE"] .'" data-bs-toggle="modal" data-bs-target="#viewProd">View</a>
                                        </div></div></td>';
                            echo "</tr>";
                        }
                        } else {
                            echo "<tr><td colspan='5'>No hay datos disponibles</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    </div>
</section>
    

    
    <div class="footer-container">
    <?php include '../footer-nav/footer.php'; ?>   
    </div>


<!-- EDIT PRODUCT MODAL -->
<div class="modal fade" id="editProd" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title   registerProd" id="editLabel">Edit Product</h1>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
      <div class="row">
          <div class="col-md-6">
            <div style="display: flex;">
              <div style="margin-bottom:10px;">
                <div style="display: flex; flex-direction: column; align-items: start;">
                  <div>
                <form action="" id="searchProd">
                <label for="" class="form-label" style="font-weight:bold;">Product:</label>
                  </div>
                  <div>

                <select class="form-control" name="prodName" id="prodName">
                  <?php include '../conexion/getProductName.php'?>
                </select>
                <input type="hidden" name="code" id="code" value="prodName">
                  </div>

                </div>

              </div>
              <div style="margin-left: 10px; margin-top:27px;">
                <div class="buscar-btn">
                  <button id="btnBuscar" type="submit">Search</button>
                </div>
              </div>
            

            </div>
          </div>
          </form>
        </div>
          <form action="" id="editProdu">
          <div class="row">
            <div class="col-md-2" style="margin-right: 10px;">
              <input type="hidden" name="idProd" id="idProd">
              <label for="editProdName" style="font-weight:bold">Trade Mark:</label>
              <input type="text"  name="editProdName" id="editProdName" class="form-control" style="width: 150px" required>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="editChemName" style="font-weight:bold; position:relative; left: 16px;">Chemical Name:</label>
              <input type="text" name="editChemName" id="editChemName"  class="form-control" style="width: 216px; margin-left:15px;" required>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="editPresentation" style="font-weight:bold; margin-left:98px;">Presentation:</label>
              <select  name="editPresentation" id="editPresentation" class="form-control" style=" margin-left:95px;">
              </select>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="editMeasure" style="font-weight:bold; position:relative; left: 75px;">Measure Unit:</label>
              <input name="editMeasure"  id="editMeasure" class="form-control" style="width: 84px;  margin-left:75px;" readonly>
            </div>
            <div class="col-md-2" style="margin-right: 40px;">
              <input type="hidden" name="idType" id="idType">
              <label for="editProdType" style="font-weight:bold; position:relative; left: 35px;">Product Type:</label>
              <input type="text" name="editProdType" id="editProdType" class="form-control" style="width: 170px; margin-left:30px;" readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" >
              <div class="row">
                <div class="col-md-6">
                  <div style="background-color: #0e6990; color:#dce7f1; border-radius:5px;">
                    <h4 style="margin-bottom:20px; margin-top: 30px; margin-left: 35%; padding-bottom:10px; padding-top:10px;" class="exo-2-uniquifier">Formulation</h4>
                  </div>
                    <div class="form-edit exo-2-uniquifier">
                      <div style="text-align:start;">
                      </div>
                      <div id="ingredientsContainer" style="display: flex; flex-wrap: wrap; gap:20px;">
                      </div> 
                      <div id="ingredientsActContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div style="background-color: #0e6990; color:#dce7f1; border-radius:5px;">
                  <h4 style="margin-bottom: 20px; margin-top: 30px; margin-left: 28%; padding-bottom:10px; padding-top:10px;" class="exo-2-uniquifier">Packing Materials</h4>
                  </div>
                  <div class="form-edit exo-2-uniquifier">
                    <div id="materialsContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
                    </div> 
                  </div>
                  
                
                </div>
              </div>
            </div>
          </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="editProduct">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- VIEW PRODUCT MODAL -->
<div class="modal fade" id="viewProd" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="viewLabel">Product Formula</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
          <div class="row" style="border-bottom: solid 1px #b6d3e0; padding-bottom:10px;">
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="viewProdName" style="font-weight:bold">Trade Mark:</label>
              <input type="text" class ="form-control" name="viewProdName" id="viewProdName" style="width: 150px" readonly>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="viewChemName" style="font-weight:bold; position:relative; left: 16px; ">Chemical Name:</label>
              <input type="text"  class ="form-control" name="viewChemName" id="viewChemName" style="width: 220px; margin-left:15px;" readonly>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="viewPresentation" style="font-weight:bold;margin-left:105px; ">Presentation:</label>
              <input name="viewPresentation" class ="form-control" id="viewPresentation" style=" margin-left:105px;" readonly>
            </div>
            <div class="col-md-2" style="margin-right: 10px; margin-left: 10px">
              <label for="viewMeasure" style="font-weight:bold; position:relative; left: 75px;">Measure Unit</label>
              <input name="viewMeasure" class ="form-control" id="viewMeasure" style="width: 84px;  margin-left:75px;" readonly>
            </div>
            <div class="col-md-2" style="margin-right: 40px;">
              <label for="viewProdType" style="font-weight:bold; position:relative; left: 35px;">Product Type:</label>
              <input type="text" name="viewProdType" class ="form-control"  id="viewProdType" style="width: 170px; margin-left:30px;" readonly>
            </div>
          </div> 
          <div class="row">
            <div class="col-md-12">
                        <div class="row">
            <div class="col-md-6">
            <div class="vw-form">
                <h3 class="exo-2-uniquifier">Formulation</h3>
                </div>
              <div class="form-square4 exo-2-uniquifier">
                 <div id="showIngreContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
                  </div>    
                       <div id="showActContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
                       </div>
              </div>
            </div>
                
                <div class="col-md-6">
                   <div class="vw-form">
                  <h3 class="exo-2-uniquifier">Packing Materials</h3>
                  </div>
                  <div class="form-square4 exo-2-uniquifier">
                 
                    <div id="showMatContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
                    </div> 
                   </div>       
                </div>

                </div>
                </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="editProduct">Save changes</button>
      </div>
    </div>
  </div>
</div>

  
<!-- INGREDIENTS MODAL -->
    <div class="modal fade" id="material" tabindex="-1" aria-labelledby="materialLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header " style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="materiallLabel">Register Materials</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4" style="margin-left: 40px; margin-top: 10px; background: #dce7f1; padding: 20px; border-radius: 15px 40px;">
                <div class="registerMate">
                <h3 style="margin-left: 25%; font-size: 20px;" class="registerProd">Ingredients</h3>
                </div>
              <div style="padding-top: 10px;">
              <form action="" method="post" id="ingreForm">
                <div class="contitems">
                  <label for="code" style="font-weight:bold">Code:</label>
                  <input type="text" id="code" name="code" class="form-control" placeholder="Enter 5 characters code" maxlength="5" title="The code must contain 5 characters." >
                  <label for="name" style="font-weight:bold">Name:</label>
                  <input type="text" id="name" name="name" class="form-control" placeholder="Enter Ingredient name" >
                </div>
                <button type="submit" class="btn btn-primary" id="saveIngredient">Save</button>
                </form>
              </div>  
                
              </div>
              <div class="col-md-2">

              </div>
              <div class="col-md-4" style="margin-top: 10px; background: #dce7f1; padding: 20px; border-radius: 15px 40px;">
                  <div class="registerMate">
                    <h3 style="margin-left: 12%; font-size: 20px;" class="registerProd">Active Ingredients</h3>
                  </div>
              <div style="padding-top: 10px;">
                <form action="" method="post" id="activeForm">
                  <div class="contitems">
                    <label for="codeAct" style="font-weight:bold" >Code:</label>
                    <input type="text" id="codeAct" name="codeAct" class="form-control" placeholder="Enter 5 characters code" maxlength="5" title="The code must contain 5 characters." >
                    <label for="nameAct" style="font-weight:bold">Name:</label>
                    <input type="text" id="nameAct" name="nameAct" class="form-control" placeholder="Enter active ingredient name" >
                  </div>
                    <button type="submit" class="btn btn-primary" id="saveActive">Save</button>
                </form>
              </div>
               
            </div>
          </div>
          <div class="row">
            <div class="col-md-4" style="margin-left: 40px; margin-top: 10px; background: #dce7f1; padding: 20px; border-radius: 15px 40px;">
              <div class="registerMate">
                <h3 style="margin-left:12%; font-size:20px;" class="registerProd">Packing Materials</h3>
              </div> 
            <div style="padding-top: 10px;">
            <form action="" method="post" id="packForm">
                <div class="contitems">
                  <label for="codeMat" style="font-weight:bold">Code:</label>
                  <input type="text" id="codeMat" name="codeMat" class="form-control" placeholder="Enter 5 characters code" maxlength="5" title="The code must contain 5 characters." >
                  <label for="nameMat" style="font-weight:bold">Name:</label>
                  <input type="text" id="nameMat" name="nameMat" class="form-control" placeholder="Enter packaging material name" >
                  </div>
                  <button type="submit" class="btn btn-primary" id="savePacking">Save</button>
                  </form>
            </div>
            
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-md-4" style="margin-top: 10px; background: #dce7f1; padding: 20px; border-radius: 15px 40px;">
            <div class="registerMate">
              <h3 style="margin-left: 22%; font-size: 20px;" class="registerProd">Presentation</h3>
            </div>
              <div style="padding-top: 10px;">
                  <form action="" method="post" id="presentForm">
                    <div class="contitems">
                      <label for="codePres" style="font-weight:bold ;">Code:</label>
                      <input type="text" id="codePres" name="codePres" class="form-control" placeholder="Enter 6 characters code" maxlength="6" title="The code must contain 6 characters." >
                      <label for="namePres" style="font-weight:bold" >Name:</label>
                      <input type="text" id="namePres" name="namePres" class="form-control" placeholder="Enter presentation name" >
                      <label for="amountPres" style="font-weight:bold">Amount</label>
                      <input type="text" id="amountPres" name="amountPres" class="form-control" placeholder="Enter a numerical amount" >
                    </div>
                      <button type="submit" class="btn btn-primary" id="savePres">Save</button>
                  </form>
              </div>   
            </div>
          </div>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- REGISTER PRODUCT MODAL -->

<div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="registerProductLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="registerProductLabel">Register Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Formulario para el producto -->
      <form id="productForm">
        <div class="modal-body">
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['nombreUsuario']; ?>">
          <div class="row">
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="prodName" style="font-weight:bold;">Trade Mark:</label>
              <input type="text" class ="form-control" name="productName" style="width: 130px;; margin-bottom: 10px;" required>
            </div>
            <div class="col-md-2" style="margin-right: 10px;">
              <label for="chemName" style="font-weight:bold;">Chemical Name:</label>
              <input type="text"  class ="form-control" name="chemName" style="width: 130px" required>
            </div>
            <div class="col-md-2" style="margin-right: 10px; width: 145px;">
              <label for="presentation" style="font-weight:bold;">Presentation:</label>
              <select name="presentation" id="presentation" class ="form-control">
                <?php include '../conexion/getPresentation.php'; ?>
              </select>
            </div>
            <div class="col-md-2" style="margin-right: 10px; width: 150px;">
              <label for="measure" style="font-weight:bold;">Measure Unit</label>
              <select name="measure" id="measure" required class ="form-control">
                <option value="">Choose an option</option>
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="gr">gr</option>
                <option value="L">L</option>
              </select>
            </div>
            <div class="col-md-2" style="margin-right: 40px; width: 150px;"">
              <label for="prodType" style="font-weight:bold;">Product Type:</label>
              <select name="prodType" id="prodType" onchange="mostrarDiv()" required class ="form-control">
                  <?php include '../conexion/getTypeProd.php'; ?>
              </select>
            </div>
          </div>
          <div class="row">
                  <div class="col-md-12">
                    <!-- Div para Producto Farmacéutico -->
                    <div id="farmaDiv" class="mt-3" style="display: none; text-align: center;">

                    <h2 style="margin-bottom:10px;" class="exo-2-uniquifier pharma">Pharmaceutical</h2>

                    <div class="row" styles="margin-button:10px;">
                    
                      <div class="col-md-6">
                      <div class="form-square" >

                        <h4 style="margin-bottom:5px;" class="exo-2-uniquifier">Formula</h4>
                        <div style="text-align: start;">
                        <label for="" style="font-weight:bold;">Ingredients</label>
                        </div>
                        <div id="product-ingredient-container" >
                        <div style="display: flex;">
                          <div class="product-ingredient-item">
                          
                          <div style="display: flex;" >
                                <select name="ingredient[]" id="ingredient"  class ="form-control" style="width:234px;">
                                    <?php include '../conexion/getIngredients.php' ?>
                                  </select>
                                  <div id="product-quantity-container">
                                     <input type="text" name="quantity[]" id="quantity" class ="form-control" placeholder="Amount" style="margin-left: 10px; width:60px; border: 1;">
                                  </div>
                          </div>
                          
                          </div>
                            <div class="contbt">
                              <button type="button" class="btn btn-primary btn-add-ingredient" style="padding: 2px; margin-top: 0px; margin-left: 10px;">+</button>
                            </div>

                             </div>
                          </div>

                          <div style="text-align: start; margin-top : 50px;">
                        <label for="" style="font-weight:bold;">Active Ingredients</label>
                        </div>
                        <div id="product-active-container">
                        <div style="display: flex;">
                          <div class="product-active-item">
                          
                          <div style="display: flex;">
                                  <select name="activeIng[]" id="activeIng" class ="form-control" style="width:234px;">
                                    <?php include '../conexion/getActiveIngre.php' ?>
                                  </select>

                                  <div id="product-quantity-container">
                                     <input type="text" name="quantityAct[]" id="quantity" class ="form-control" placeholder="Amount" style="margin-left: 10px; width: 60px; border: 1;">
                                  </div>
                          </div>
                          
                          </div>
                                      <div class="contbt">
                                      <button type="button" class="btn btn-primary btn-add-active" style="padding: 2px; margin-top: 0px; margin-left: 10px;">+</button>
                                      </div>

                             </div>
                          </div>
                          </div>
                      </div>

                    <div class="col-md-6">
                      <div class="form-square2" >
                        <h4 style="margin-bottom:5px;" class="exo-2-uniquifier">Packing Material</h4>


                        <div style="text-align: start;">
                        <label for="" style="font-weight:bold;">Material</label>
                        </div>
                        <div id="product-material-container">
                        <div style="display: flex;">
                          <div class="product-material-item">
                          
                          <div style="display: flex;">
                                  <select name="material[]" id="material" class ="form-control" style="width:234px;">
                                    <?php include '../conexion/getPackingMat.php' ?>
                                  </select>

                                  <div id="product-quantity-container">
                                     <input type="text" name="quantityMat[]" id="quantity" class ="form-control" placeholder="Amount" style="margin-left: 10px; width: 60px; border: 1;">
                                  </div>
                          </div>
                          </div>
                                      <div class="contbt">
                                      <button type="button" class="btn btn-primary btn-add-material" style="padding: 2px; margin-top: 0px; margin-left: 10px;">+</button>
                                      </div>
                             </div>
                          </div>
                    </div>
                      </div>
                      </div>
                    </div>

                 <!-- Div para Proteína -->
                 <div id="protDiv" class="mt-3" style="display: none; text-align: center;">
                 <h2 style="margin-bottom:10px;" class="exo-2-uniquifier suple">Suplements</h2>

                    <div class="row" >

                      <div class="col-md-6">
                      <div class="form-square3">
                        
                        <h4 style="margin-bottom:5px;" class="exo-2-uniquifier">Formula</h4>

                        <div style="text-align: start;">
                        <label for="" style="font-weight:bold;">Ingredients</label>
                        </div>
                        <div id="product-supleingredient-container">
                        <div style="display: flex;">
                          <div class="product-supleingredient-item">

                          <div style="display: flex;">
                                  <select name="ingredientSuple[]" id="ingredientSuple" class ="form-control">
                                    <?php include '../conexion/getIngreSuple.php' ?>
                                  </select>

                                  <div id="product-quantity-container">
                                     <input type="text" name="quantitySup[]" id="quantity" class ="form-control" placeholder="Amount"style="margin-left: 10px; width: 60px; border: 1;">
                                  </div>
                          </div>

                          </div>

                                      <div class="contbt">
                                      <button type="button" class="btn btn-primary btn-add-supleingredient" style="padding: 2px; margin-top: 0px; margin-left: 10px;">+</button>
                                      </div>

                             </div>
                          </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                      <div class="form-square2" >
                        <h4 style="margin-bottom:5px;" class="exo-2-uniquifier">Packing Material</h4>


                        <div style="text-align: start;">
                        <label for="" style="font-weight:bold;">Material</label>
                        </div>
                        <div id="product-suplematerial-container">
                        <div style="display: flex;">
                          <div class="product-suplematerial-item">

                          <div style="display: flex;">
                                  <select name="materialSuple[]" id="materialSuple" class ="form-control" style="width:234px;">
                                    <?php include '../conexion/getPackingMatSup.php' ?>
                                  </select>

                                  <div id="product-quantity-container">
                                     <input type="text" name="quantityMatSup[]" id="quantity" class ="form-control" placeholder="Amount" style="margin-left: 10px; width: 60px; border: 1;">
                                  </div>
                          </div>
                          </div>
                                      <div class="contbt">
                                      <button type="button" class="btn btn-primary btn-add-suplematerial" style="padding: 2px; margin-top: 0px; margin-left: 10px;">+</button>
                                      </div>
                             </div>
                          </div>
                    </div>
                    </div>
                </div>
              

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="saveProduct">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>





<script src="../Js/jquery-3.6.0.min.js"></script>
<script src="../Js/jsGral.js"></script> 
<script src="../Js/insertItems.js"></script> 
<script src="../Js/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>