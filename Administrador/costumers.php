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
    <link rel="stylesheet" href="../css/costumers.css">
    <title>Customer</title>
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

    $sql = "CALL SP_show_Clientes()";
    $result = $connect->query($sql);
    ?>

<div class="btn">
    <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
  </div>

  <div class="btn">
    <a href="#" data-bs-toggle="modal" data-bs-target="#editCModal">Edit</a>
  </div>


  <div class="title exo-2-uniquifier">
    <h1>CUSTOMERS</h1>
    </div>
    
    </section>

<section class="main-section">

<div class="contenido">
<!-- <div class="registrar-btn">
            <a href="registrarOrden.php">Register</a>
    </div> -->

            <div class="con">
            <div class="table-container">
            <table id="orderTable">
                <thead>
                    <tr>
                        <th>CUSTOMER NUMBER</th>
                        <th>TRADE NAME</th>
                        <th>CONTACT NAME</th>
                        <th>PHONE</th>
                        <th>EMAIL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Revisar si hay resultados
                        if ($result->num_rows > 0) {
                        // Salida de datos de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["NUMBER"] .  "</td>";
                            echo "<td>" . $row["TRADE"] . "</td>";
                            echo "<td>" . $row["CONTACT"] . "</td>";
                            echo "<td>" . $row["PHONE"] . "</td>";
                            echo "<td>" . $row["EMAIL"] . "</td>";
                            echo "</tr>";
                        }
                        } else {
                            echo "<tr><td colspan='5'>No data available</td></tr>";
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



   <!--MODAL PARA REGISTRAR NUEVO CLIENTE-->
    
   <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h5 class="modal-title registerProd" id="registerModalLabel">Register New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario de Registro de Cliente -->
        <form action="" method="post" id="registerForm">
          <div class="mb-3">
            <label for="taxname" class="form-label" style="font-weight: bold;">Trade Name</label>
            <input type="text" class="form-control" id="taxname" name="taxname" placeholder="Company Name" required>
          </div>
          <div class="mb-3">
            <label for="contactname" class="form-label" style="font-weight: bold;">Contact Name</label>
            <input type="text" class="form-control" id="contactname" name="contactname" placeholder="Fullname" required>
          </div>
          <div class="mb-3">
            <label for="surname" class="form-label" style="font-weight: bold;">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" required>
          </div>
          <div class="mb-3">
            <label for="lastname" class="form-label" style="font-weight: bold;">Lastname</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label" style="font-weight: bold;">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Example@gmail.com" required>
          </div>
          <div class="mb-3">
            <label for="numTel" class="form-label" style="font-weight: bold;">Phone
              <span style="font-size: 0.9em; color: gray;">(10 numbers, without spaces)</span>
            </label>
          <input type="text" class="form-control" id="numTel" name="numTel" placeholder="5555555555" maxlength="10" pattern="^[0-9]{10}$" title="The number must contain exactly 10 numbers." required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!--MODAL PARA EDITAR INFORMACIÓN DEL CLIENTE-->

<div class="modal fade" id="editCModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h5 class="modal-title registerProd" id="editCModalLabel">Edit Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12"> 
        <form action="" method="post" id="editarCForm">
          <div class="cont-search" style="display: flex; flex-direction: row;">
            <div class="buscar-input">
              <label for="number" style="font-weight: bold;">Customer Number:</label>
              <input type="text" class="form-control" id="number" name="number" placeholder="customer number">
            </div>
            <div class="buscar-btn">
              <button id="searchC" type="submit">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
<form action="" id="editCInfo">


    <!-- Aquí están los inputs para mostrar los datos -->
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <label for="showTaxname" style="font-weight: bold;">Tax Name:</label>
        <input type="text" id="showTaxname" class="form-control" name="showTaxname" >
        
        <label for="showContactname" style="font-weight: bold;">Contact Name:</label>
        <input type="text" id="showContactname" class="form-control" name="showContactname" >

        <label for="conSurname" style="font-weight: bold;">Surname:</label>
        <input type="text" id="conSurname" class="form-control" name="conSurname" >
        
        <label for="conLastname" style="font-weight: bold;">Lastname:</label>
        <input type="text" id="conLastname" class="form-control" name="conLastname" >
        
        <label for="conEmail" style="font-weight: bold;">Email:</label>
        <input type="email" id="conEmail" class="form-control" name="emconEmailail" >
        
        <label for="conNumTel" class="form-label" style="font-weight: bold;">Phone <span style="font-size: 0.9em; color: gray;">(10 numbers, without space)</span>:</label>
              <input type="text" class="form-control" id="conNumTel" name="conNumTel" maxlength="10" pattern="^[0-9]{10}$" title="The number must contain exactly 10 numbers.">
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



<script src="../Js/jquery-3.5.1.min.js"></script>

<script src="../Js/jquery-3.6.0.min.js"></script>

<script src="../Js/jsGral.js"></script>

</body>
</html>