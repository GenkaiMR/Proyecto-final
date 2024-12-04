<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <script src="../Js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="../css/inicioAdmin.css">
    <link rel="icon" href="../imagenes/icono.png" type="imagen/png">
</head>
<body>
<?php 
session_start();
include '../footer-nav/header.php'
?>
    <section class="nav-section">
    <div class="navbar">
        <div  class="nav-option">
        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon icon-tabler icon-tabler-file-description" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M14 3v4a1 1 0 0 0 1 1h4" />
  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
  <path d="M9 17h6" />
  <path d="M9 13h6" />
</svg>
            <a href="orders.php">Production Orders</a>
        </div>
        
        <div  class="nav-option">
        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon icon-tabler icon-tabler-clipboard" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
  <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
</svg>
            <a href="request.php">Orders</a>
        </div>

        <div class="nav-option">
        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon icon-tabler icon-tabler-math-symbols" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M3 12l18 0" />
  <path d="M12 3l0 18" />
  <path d="M16.5 4.5l3 3" />
  <path d="M19.5 4.5l-3 3" />
  <path d="M6 4l0 4" />
  <path d="M4 6l4 0" />
  <path d="M18 16l.01 0" />
  <path d="M18 20l.01 0" />
  <path d="M4 18l4 0" />
</svg>
            <a href="productsForm.php">Products & Formulation</a>
        </div>

        <div class="nav-option">
        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon icon-tabler icon-tabler-friends" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M7 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
  <path d="M5 22v-5l-1 -1v-4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4l-1 1v5" />
  <path d="M17 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
  <path d="M15 22v-4h-2l2 -6a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1l2 6h-2v4" />
</svg>
            <a href="costumers.php">Costumers</a>
        </div>

        

        <div  class="nav-option">
        <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon icon icon-tabler icon-tabler-users" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
  <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
</svg>
            <a href="employeesUsers.php">Employees & Users</a>
        </div>

        
        
    </div>
    </section>

    <section  class="main-section">

    <div class="contenido">
        <h1><?php include "../conexion/showName.php"?></h1>
        <div class="user-icon">
            <img src="../imagenes/user.png" alt="user">
        </div>
        <p> User: <?php echo $_SESSION['nombreUsuario']; ?></p>
        <?php include "../conexion/showInfoEmp.php"?>
    </section>

    <div class="footer-container">
    <?php include '../footer-nav/footer.php'; ?>   
    </div>
</body>
</html>