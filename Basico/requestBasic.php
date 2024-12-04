<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
    <script src="../Js/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="../css/requestBasic.css">
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
    include '../conexion/connection.php';
    $connection = connection();
    $sql = "CALL SP_show_Pedidos()";
    $result = $connection->query($sql);

    ?>
    <section class="nav-section">
    <div class="navbar">
        <div class="info-cont">

        <div class="user-icon">
        <svg xmlns="http://www.w3.org/2000/svg" x-bind:width="size" x-bind:height="size" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-bind:stroke-width="stroke" stroke-linecap="round" stroke-linejoin="round" width="55" height="55" stroke-width="1.25">
            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
            <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"></path>
            </svg>
        </div>
        <div class="cont-data">
        <?php include "../conexion/showInfoEmp.php"?>
        <div class="flexi"><p class="bold">User:</p> <p> <?php echo $_SESSION['nombreUsuario']; ?></p></div>
        </div>
        </div>
    </div>
</section>

<!-- BOTONES DE NAVEGACIÓN -->

    <section class="buttons-section" >
    <div class="inicio-btn">
        <a href="../Basico/inicioBasic.php">HOME</a>
    </div>
    </section>

<div class="contenido">
    <div class="exo-2-uniquifier">
        <h1>ORDER</h1>
    </div>
</div>
    <!-- /BOTONES DE NAVEGACIÓN -->


<section class="main-section">

        <div class="table-container">
            <table id="">
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
                            echo "<tr><td colspan='5'>No data available</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
    </div>
</section>


    
    <div class="footer-container">
    <?php include '../footer-nav/footer.php'; ?>   
    </div>

</body>
</html>