<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE A INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Administradores</title>

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


    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            // OCULTAR MENSAJE DE ERROR DESPUES DE 7SEG
            setTimeout(function() {
                var errorMessage = document.getElementById("error-message");
                if (errorMessage) {
                    errorMessage.style.display = "none";
                }
            }, 7000);
        });
    </script>
</head>

<body>
<?php
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];
    echo '<div id="error-message" class="alert alert-danger">' . $errorMessage . '</div>';
}
?>

<!-- Navbar & Carousel Start -->
<div class="container-fluid position-relative p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img class="w-100" src="../img/carousel-admin.jpg" alt="Image" style="width: 100vw; height: 100vh;">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">LBC Suppliers & services S.A. de C.V.</h5>
                            <h1 class="display-4 text-white mb-md-4 animated zoomIn">ADMINISTRACIÓN</h1>
                            <a href="logout.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInRight">Cerrar sesión</a>
                            <br>
                            <a href="index.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Inicio</a>
                            <a href="cotizaciones.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInLeft">Cotizaciones</a>
                            <br>
                            <a href="register_admin.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInLeft">Agregar administrador</a>
                            <a href="delete_admin.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Eliminar administrador</a>
                            <br>
                            <a href="products_ingles/products.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInLeft">Productos en inglés</a>
                            <a href="registro_actividad.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Registro de actividad</a>
                            <a href="productos.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Productos en español</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Carousel End -->


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

</body>

</html>