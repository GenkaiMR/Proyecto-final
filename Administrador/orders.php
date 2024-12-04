<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <script src="../Js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="../css/ordersAdmin.css">
    <title>Production Orders</title>
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

    $connection = connection();
    $sql = "CALL SP_show_Ordenes()";
            $result = $connection->query($sql);
    ?>

<div class="title exo-2-uniquifier">
    <h1>PRODUCTION ORDERS</h1>
</div>


</section>

<section class="main-section">

<div class="contenido">
<!-- <div class="registrar-btn">
            <a href="generateOrder.php">Register</a>
    </div> -->
    <div class="con">
<div class="table-container">
<table>
                <thead>
                    <tr>
                        <th>ORDER NUMBER</th>
                        <th>COMMERCIAL NAME</th>
                        <th>GENERIC NAME</th>
                        <th>GENERATION DATE</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <th>TYPE OF PRODUCT</th>
                        <th>QUANTITY UNITS</th>
                        <th>STATUS</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Revisar si hay resultados
                        if ($result->num_rows > 0) {
                        // Salida de datos de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo '<td data-id="order'.$row['Number'].'">' . $row["Number"] .  '</td>';
                            echo '<td class="product-name">' . $row["CommercialName"] . '</td>';
                            echo "<td>" . $row["GenericName"] . "</td>";
                            echo "<td>" . $row["OrderDate"] . "</td>";
                            echo "<td>" . $row["StartDate"] . "</td>";
                            echo "<td>" . $row["EndDate"] . "</td>";
                            echo '<td class="type-product">' . $row["TypeOfProduct"] . '</td>';
                            echo "<td>" . $row["UnitsQuantity"] . "</td>";
                            echo "<td>" . $row["Status"] . "</td>";
                            echo '<td><div class="buttons-action"><button type="submit" class="view" data-id="' . $row["Number"] . '">View</button>';
                            echo '<div class="btn-stat">
                                        <a type="submit" href="#" data-id="'.$row["Number"] .'" data-bs-toggle="modal" data-bs-target="#modalStatus">Status</a>
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
        
</section>

    <div class="footer-container">
    <?php include '../footer-nav/footer.php'; ?>   
    </div>

    <div class="modal fade" id="modalStatus" tabindex="-1" aria-labelledby="statusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="width: 50%; margin-left: 25%;">
      <div class="modal-header " style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="statusLabel">Change Status</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12"> 
              <form action="changeStatus.php" method="post" id="statusForm">
                <!-- Campo oculto para el número de orden -->
                <input type="hidden" name="Numero" id="orderNumber">

                <div class="cont-search" style="display: flex; flex-direction: row;">
                  <div class="buscar-input">
                    <label for="status" style="font-weight: bold;">Status:</label>
                    <select name="status" style="margin-left: 10px;" required>
                      <?php include "../conexion/getStatus.php" ?>
                    </select>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveStatus">Save changes</button>
      </div>
    </div>
  </div>
</div>



    
<script src="../Js/jquery-3.6.0.min.js"></script>

<script  src="../Js/viewOrder.js"></script>
<script src="../Js/jsGral.js"></script> 

</body>
</html>