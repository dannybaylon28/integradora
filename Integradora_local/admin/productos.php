<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE HA INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
   
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Favicon -->
<link href="../img/Logo-icon.png" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="/https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="../lib/animate/animate.min.css" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="../css/style.css" rel="stylesheet">

     <!-- JavaScript Libraries -->
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <style>
body {
  background-image: url('../img/fondo-body-abstract.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-color: black;
}

        .wrapper {
            width: 600px;
             margin: 0 auto;
            display: flex;
            justify-content: center;
        }

        table {
            color: white;
            margin: 0 auto;
        }

        tr td {
            color: white;
        }

        th {
            color: white;
        }

        table tr td:last-child {
            width: 120px;
            color: white;
        }

        .transparent-black-bg {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            width: 900px;
        }

        .btn-add-product {
            border-radius: 15px;
            background-color: #5BC0BE;
            color: white;
            font-weight: bold;
        }

        .btn-add-product:hover {
            background-color: #3C8F8D;
        }


    </style>


    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            // OCULTAR EL MENSAJE DE ERROR DESPUÉS DE 10 SEGUNDOS
            setTimeout(function() {
                $(".alert").slideUp();
            }, 10000);
        });
    </script>
</head>
<body>

            <!-- Navbar & Carousel Start -->
<div class="container-fluid position-relative p-0" >
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <br>
            <h1 class="m-0">Productos en español</h1>
            <br>
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse" style="margin-top: 50px;">
                <div class="navbar-nav ms-auto py-0">
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu m-0">
                        </div>
                    </div>
                    <div class="nav-item dropdown" style="margin-top: -25px;">
                    <a href="cotizaciones.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #ACE894; color: black;">Cotizaciones</a>
                    <a href="products_ingles/products.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #1B065E; color: white;">Productos en inglés</a>
                    <a href="index.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #5BC0BE; color: white;">Inicio</a>
                    <a href="logout.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #a5243d; color: white;">Cerrar sesión</a>
                        <div class="dropdown-menu m-0">
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                        </div>
                    </div>
            </div>
    </div>
</div>
    <!-- Navbar & Carousel End -->

<br><br><br><br><br><br>

    <div class="wrapper">
        <div class="container-fluid transparent-black-bg">
            <div class="row">
                <div class="col-md-12">
                    <div class=" clearfix text-center">
                        <h2 class="pull-left" style="color: white;">Datos</h2>
                        <a href="create_productos.php" class="btn btn-add-product pull-right"><i class="fa fa-plus col-3"></i> Agregar producto</a>   
                    </div>

                    <br>

                    <?php
                    // VERIFICACION SI HAY MENSAJE DE ERROR AL QUERER ELIMINAR PRODUCTO
                    if (isset($_GET['error'])) {
                        $error_message = urldecode($_GET['error']);
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }

                    // CONEXION A LA BASE
                    require_once "../config.php";

                    $sql = "CALL ObtenerProductos()";
                    if ($result = $mysqli->query($sql)) {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Nombre</th>";
                            echo "<th>Descripción</th>";
                            echo "<th>Características</th>";
                            echo "<th>Imagen</th>";
                            echo "<th>Acción</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_array()) {
                                echo "<tr>";
                                echo "<td>" . $row['IdProductos'] . "</td>";
                                echo "<td>" . $row['Nombre_producto'] . "</td>";
                                echo "<td>" . $row['Descripcion'] . "</td>";
                                echo "<td>" . $row['Caracteristicas'] . "</td>";
                                echo "<td>" . $row['URL_imagen'] . "</td>";
                                echo "<td>";
                                echo '<a href="update_productos.php?id=' . $row['IdProductos'] . '" class="mr-3" title="Actualizar registro" data-toggle="tooltip"><span class="bi bi-pencil-square"></span></a>';
                                echo '<a href="delete_productos.php?id=' . $row['IdProductos'] . '" title="Eliminar registro" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            $result->free();

                        } else {
                            echo '<div class="alert alert-danger"><em>No existen productos</em></div>';
                        }
                    } else {
                        echo "Algo salió mal. Por favor, intenta nuevamente más tarde.";
                    }

                    // CIERRE DE CONEXIÓN
                    $mysqli->close();
                    ?>

                </div>

            </div>
        </div>

    </div>
</body>
</html>