<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <script src="../Js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/employees.css">
    <title>Employees & Users</title>
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
    $sql = "CALL SP_show_EmpleadosyUsuarios()";
    $result = $connect->query($sql);

    ?>

    
    <div class="btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
    </div>
    
    <div class="btn">
        <a href="#"  data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
    </div>

    <div class="btn">
        <a href="#"  data-bs-toggle="modal" data-bs-target="#changePassword">Password</a>
    </div>


    <div class="title exo-2-uniquifier">

    <h1>EMPLOYEE & USERS</h1>
    </div>
    
    </section>

<section class="main-section">
<div class="contenido">
    <div class="con">
    <div class="table-container">
            <table id="orderTable">
                <thead>
                    <tr>
                        <th>EMPLOYEE NUMBER</th>
                        <th>USER</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>TYPE OF ACCESS</th>
                        <th>POSITION</th>
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
                            echo "<td>" . $row["USER"] . "</td>";
                            echo "<td>" . $row["NAME"] . "</td>";
                            echo "<td>" . $row["EMAIL"] . "</td>";
                            echo "<td>" . $row["ACCESS"] . "</td>";
                            echo "<td>" . $row["POSITION"] . "</td>";
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

<!-- MODAL PARA REGISTRAR EMPLEADO -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title  registerProd" id="registerModalLabel">Register Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12"> 
        <form action="" method="post" id="registerForm">
          <div class="cont-search" style="display: flex; flex-direction: row;">
          </div>
        </form>
      </div>
    </div>
<form action="" id="registerInfo">


    <!-- Aquí están los inputs para mostrar los datos -->
    <div class="row">
      <div class="col-md-6 ms-auto">
        <label for="name" style="font-weight:bold;">Name:</label>
        <input type="text" id="namee" class="form-control" name="namee" placeholder="full name" required>
        
        <label for="surname" style="font-weight:bold;">Surname:</label>
        <input type="text" id="surnamee" class="form-control" name="surnamee" placeholder="surname" required>
        
        <label for="lastname" style="font-weight:bold;">Lastname:</label>
        <input type="text" id="lastnamee" class="form-control" name="lastnamee" placeholder="lastname" required>
        
        <label for="email" style="font-weight:bold;">Email:</label>
        <input type="email" id="emaill" class="form-control" name="emaill" placeholder="example@gmail.com" required>
        
        <label for="position" style="font-weight:bold;">Position:</label>
        <select id="positionn" name="positionn" class="form-control" required> <?php include "../conexion/get_pos.php" ?> </select>

      </div>
      <div class="col-md-6 ms-auto">
        <label for="username" style="font-weight:bold;">Username:</label>
        <input type="text" id="usernamee" class="form-control" name="usernamee" placeholder="username">

        <label for="password" style="font-weight:bold;">Password</label>
        <input type="password" name="passwordd" id="passwordd" class="form-control" placeholder="password" required>
        <span id="passwordError" class="text-danger"></span>

        <label for="confirm" style="font-weight:bold;">Confirm Password</label>
        <input type="password" name="confirmm" id="confirmm" class="form-control" placeholder="confirm password" required>
        <span id="passwordError" class="text-danger"></span>

        <label for="role" style="font-weight:bold;">Role</label>
        <select id="rolee" name="rolee" class="form-control" required><?php include "../conexion/get_access.php" ?></select>

      </div>
    </div>
  </div>
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Register</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!--MODAL PARA EDITAR INFORMACIÓN DEL EMPLEADO-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title  registerProd" id="editModalLabel">Edit Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12"> 
        <form action="" method="post" id="editForm">
          <div class="cont-search" style="display: flex; flex-direction: row;">
            <div class="buscar-input">
              <label for="number">Employee Number:</label>
              <input type="text" class="form-control" id="number" name="number" placeholder="employee number">
            </div>
            <div class="buscar-btn">
              <button id="btnBuscar" type="submit">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
<form action="" id="editInfo">


    <!-- Aquí están los inputs para mostrar los datos -->
    <div class="row">
      <div class="col-md-6 ms-auto">
        <label for="name" style="font-weight:bold;">Name:</label>
        <input type="text" id="name" class="form-control" name="name" >
        
        <label for="surname" style="font-weight:bold;">Surname:</label>
        <input type="text" id="surname" class="form-control" name="surname" >
        
        <label for="lastname" style="font-weight:bold;">Lastname:</label>
        <input type="text" id="lastname" class="form-control" name="lastname" >
        
        <label for="email" style="font-weight:bold;">Email:</label>
        <input type="email" id="email" class="form-control" name="email" >
        
        <label for="position" style="font-weight:bold;">Position:</label>
        <input type="text" id="position" class="form-control" name="position" placeholder="Operador/Supervisor/Gerente">
      </div>
      <div class="col-md-6 ms-auto">
        <label for="username" style="font-weight:bold;">Username:</label>
        <input type="text" id="username" class="form-control" name="username" >

        <label for="role" style="font-weight:bold;">Role:</label>
        <input type="text" id="role" class="form-control" name="role" placeholder="Basico / Administrador">
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



<!--MODAL PARA CAMBIAR LA CONTRASEÑA DE UN USUARIO-->
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePassLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header" style="background-color: #dce7f1;">
        <h1 class="modal-title registerProd" id="changePassLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12"> 
        <form action="" method="post" id="changeForm">
          <div class="cont-search" style="display: flex; flex-direction: row;">
            <div class="buscar-input">
              <label for="getUsername" style="font-weight:bold;">Username:</label>
              <input type="text" class="form-control" id="getUsername" name="getUsername" placeholder="Type your username">
            </div>
            <div class="buscar-btn">
              <button id="btnBuscar" type="submit">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
<form action="" id="passForm">


    <!-- Aquí están los inputs para mostrar los datos -->
    <div class="row">
      <div class="col-md-6 ms-auto">
        <label for="showname" style="font-weight:bold;">Name:</label>
        <input type="text" id="showname" class="form-control" name="showname" >
        
        <label for="showsurname" style="font-weight:bold;">Surname:</label>
        <input type="text" id="showsurname" class="form-control" name="showsurname" >
        
        <label for="showlastname" style="font-weight:bold;">Lastname:</label>
        <input type="text" id="showlastname" class="form-control" name="showlastname" >
      </div>
      <div class="col-md-6 ms-auto">
        <label for="showusername" style="font-weight:bold;">Username:</label>
        <input type="text" id="showusername" class="form-control" name="showusername" >

        <label for="pass" style="font-weight:bold;">New Password:</label>
        <input type="password" id="pass" class="form-control" name="pass" placeholder="Type your new password">
        <label for="confitmPassword" style="font-weight:bold;">Confirm New Password:</label>
        <input type="password" id="confitmPassword" class="form-control" name="confitmPassword" placeholder="Confirm your new password">
      </div>
    </div>
  </div>
</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="../Js/jquery-3.5.1.min.js"></script>

<script src="../Js/validatePass.js"></script>

<script src="../Js/jsGral.js"></script> 


</body>
</html>