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
    <link rel="stylesheet" href="../css/request.css">
    <title>Order</title>
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
        $sql = "CALL SP_show_Pedidos()";
        $result = $connection->query($sql);
?>

<div class="btn">
        <a href="#"  data-bs-toggle="modal" data-bs-target="#registerOrderModal">Register</a>
    </div>

    <div class="title exo-2-uniquifier">
    <h1>ORDER</h1>

    </div>

</section>
<section class="main-section">

<div class="contenido">
    <div class="con">
    <div class="table-container">
            <table id="orderTable">
                <thead>
                    <tr>
                        <th>ORDER NUMBER</th>
                        <th>CUSTOMER INFORMATION</th>
                        <th>PRODUCT</th>
                        <th>UNITS QUANTITY</th>
                        <th>ORDER DATE</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        // Revisar si hay resultados
                        if ($result->num_rows > 0) {
                        // Salida de datos de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Number"] .  "</td>";
                            echo "<td>" . $row["Information"] . "</td>";
                            echo "<td>" . $row["Product"] . "</td>";
                            echo "<td>" . $row["UnitsQuantity"] . "</td>";
                            echo "<td>" . $row["OrderDate"] . "</td>";
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



<!-- MODAL PARA REGISTRAR UN PEDIDO -->
<div class="modal fade" id="registerOrderModal" tabindex="-1" aria-labelledby="registerOrderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="registerOrderLabel">Register Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" id="registerOrderInfo">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <label for="Customer" style="font-weight: bold;">Customer:</label>
                <select id="Customer" class="form-control" name="Customer" required>
                  <?php include_once "../conexion/getOrderData.php"; echo get_trade_name(); ?>
                </select>

                <label for="Product" style="font-weight: bold;">Product:</label>
                <select id="Product" class="form-control" name="Product" required>
                  <?php include_once "../conexion/getOrderData.php"; echo get_product_name(); ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="UnitsQty" style="font-weight: bold;">Units Quantity:</label>
                <input type="text" id="UnitsQty" class="form-control" name="UnitsQty" placeholder="Example: 1000" required>

                <label for="Delivery" style="font-weight: bold;">Delivery Date:</label>
                <input type="date" id="Delivery" class="form-control" name="Delivery" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitOrder">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

    

    
    <div class="footer-container">
    <?php include '../footer-nav/footer.php'; ?>   
    </div>


    <script src="../Js/jquery-3.5.1.min.js"></script>

    <script src="../Js/jsGral.js"></script> 

</body>
</html>