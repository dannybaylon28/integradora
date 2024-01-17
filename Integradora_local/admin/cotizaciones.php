<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE A INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once '../config.php';

// SOLICITUDES CON PRODUCTOS
$sql = "CALL ObtenerSolicitudes()";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cotizaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

<style>
body {
  background-image: url('../img/fondo-navar.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

h1 {
    font-size: 2.5rem; /* Tamaño de fuente para pantallas grandes */
}

/* Para pantallas más pequeñas */
@media (max-width: 767px) {
    h1 {
        font-size: 1.8rem; /* Tamaño de fuente para pantallas pequeñas */
    }
}

        .table {
            color: white;
        }

        .table thead th {
            color: white;
        }

        .container-lg {
             background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            width: 900px;
        }


        button.btn {
            color: white;
        }

        button.btn[value="Pendiente"] {
            background-color: white;
            color: black;
            border: 2px solid black;
            border-radius: 10px;
            padding: 5px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        
        button.btn[value="Pendiente"]:hover {
            background-color: black;
            color: white;
            transform: scale(1.1);
        }

        button.btn[value="Contestada"] { 
        }
</style>


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

</head>

<body>

<!-- Navbar & Carousel Start -->
<div class="container-fluid position-relative p-0" >
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <br>
            <h1 class="m-0">Cotizaciones pendientes</h1>
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
                    <a href="almacen_cotizaciones.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #ACE894; color: black;">Almacén cotizaciones</a>
                    <a href="products_ingles/products.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #1B065E; color: white;">Productos en inglés</a>
                    <a href="productos.php" class="btn btn-primary py-1 px-2 ms-3" style="background-color: #1B065E; color: white;">Productos en español</a>
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

<br><br><br><br>

<div class="container-lg">
        <table class="table mt-3">
            <thead>
             <tr>
                    <th>Fecha</th>
                    <th>Nombre del cliente</th>
                    <th>Correo electrónico</th>
                    <th>Productos</th>
                    <th>Comentarios</th>
                    <th>Estado</th>
             </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['Fecha']; ?></td>
                        <td><?php echo $row['Nombre_cliente']; ?></td>
                        <td><a href="mailto:<?php echo $row['Email']; ?>"><?php echo $row['Email']; ?></a></td>
                        <td><?php echo $row['Productos']; ?></td>
                        <td><?php echo $row['Comentarios']; ?></td>
                        <td>
                            <form action="registro_cotizacion.php" method="post">
                                <select name="estado_solicitud" class="form-control">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Contestada">Contestada</option>
                                </select>
                                <input type="hidden" name="id_solicitud" value="<?php echo $row['IdSolicitudes']; ?>">
                                <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>


