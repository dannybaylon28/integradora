<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LBC Suppliers - Products</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/Logo-icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
         .image-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
         }
        .custom-img-size {
            max-width: 400px;
            max-height: 300px;
            width: auto;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->

<!-- Topbar Start -->
<div class="container-fluid bg-dark px-5 d-none d-lg-block" style="height: 40px;">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 40px;">
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>614-278-1051</small>
                    <small class="text-light"><i class="fa fa-envelope-open me-2"></i>baylon@lbcsuppliers.com</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center ms-auto" style="padding-top: 5px;">
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Topbar End -->


 <!-- Navbar Start -->
 <div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">
            <h1 class="m-0"></i><img src="../img/logo-LBc.png" alt="Image" style="height: 55px; width: 120px;"></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
       <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="nosotros.html" class="nav-item nav-link ">About Us</a>
                <div class="nav-item dropdown">
                    <a href="actividades.html" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">What We Do</a>
                    <div class="dropdown-menu m-0">
                        <a href="actividades.html" class="dropdown-item">Activities</a>
                        <a href="servicios.html" class="dropdown-item">Services</a>
                        
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="productos.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Products</a>
                    <div class="dropdown-menu m-0">
                        <a href="productos.php" class="dropdown-item active">Catalog</a>
                        <a href="solicitud.php" class="dropdown-item">Make a Quotation</a>
                        
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="../admin/login.php" class="btn btn-primary py-2 px-4 ms-3" style="background-color: #061429; color: white;">Admin</a>
        </div>
    </nav>

    <div class="container-fluid bg-primary py-5 bg-header" style="margin-bottom: 90px;">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white animated zoomIn">Product Catalog</h1>
                <a href="" class="h5 text-white">LBC</a>
                <a href="" class="h5 text-white">Suppliers & Services</a>
            </div>
        </div>
    </div>
</div>
<!-- Navbar End -->



    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


<!-- Blog Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Blog list Start -->
            <div class="col-lg-17">
                <div class="row g-5">
                    <?php
                    require_once '../config.php';

                    if (isset($_GET['error'])) {
                        $error_message = $_GET['error'];
                        echo '<script>alert("' . htmlspecialchars($error_message) . '");</script>';
                    }

                    $products_per_page = 6;
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $start_from = ($page - 1) * $products_per_page;

                    $sql = "CALL GetProductsPag(?, ?)";

                    if ($stmt = mysqli_prepare($mysqli, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ii", $start_from, $products_per_page);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_array()) {
                                ?>
                                <div class="col-md-4 wow slideInUp" data-wow-delay="0.1s">
                                    <div class="blog-item bg-light rounded overflow-hidden">
                                        <div class="blog-img position-relative overflow-hidden">
                                            <div class="image-container">
                                                <img class="img-fluid custom-img-size" src="../<?php echo $row['URL_images'] ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h4 class="mb-3"><?php echo $row['Name_product'] ?></h4>
                                            <p><?php echo shortenText($row['Description'], 150); ?></p>
                                            <a class="text-uppercase" href="leermas.php?id=<?php echo $row['idProducts']; ?>">Read More... <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            $result->free();
                        } else {
                            echo "No hay productos disponibles.";
                        }

                        mysqli_stmt_close($stmt);
                    }
                    ?>
                </div>
            </div>
            <!-- Blog list End -->

            <div class="col-12 wow slideInUp" data-wow-delay="0.1s">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg m-0">
                        <?php
                        // Obtener el número total de páginas
                        $sql_count = "CALL TotalProducts()";
                        if ($result = $mysqli->query($sql_count)) {
                            $row = $result->fetch_assoc();
                            $total_pages = ceil($row['total'] / $products_per_page);
                            $result->free();

                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . ($page === $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="btn-center wow fadeInUp" data-wow-delay="0.2s">
    <div class="btn-container">
        <a href="solicitud.php" class="btn btn-primary btn-lg btn-animate">MAKE A QUOTATION</a>
    </div>
</div>
    </div>
</div>

<style>
     .btn-animate {
        animation: fadeInUp 0.8s ease-out;
        animation-delay: 0.5s;
    }

    .btn-container {
        display: flex;
        justify-content: center;
    }

    .btn-primary {
        background-color: #5bc0de;
        color: #ffffff;
        border-color: #5bc0de;
        font-size: 1.2rem; /* Tamaño de fuente del botón */
        padding: 0.5rem 1rem; /* Espaciado interno del botón */
        border-radius: 5px; /* Borde redondeado */
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
        background-color: #17a2b8;
        transform: scale(1.05); /* Efecto de aumento de tamaño al pasar el mouse */
    }

    /* Estilos para centrar el botón en la mitad de la página */
    .btn-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 576px) {
        .btn-primary {
            font-size: 1rem;
            padding: 0.3rem 0.7rem;
        }
    }
</style>

<?php
function shortenText($text, $max_length)
{
    if (strlen($text) > $max_length) {
        $shortened_text = substr($text, 0, $max_length);
        $shortened_text .= '...';
        return $shortened_text;
    }
    return $text;
}
?>
<!-- Blog End -->

    <!-- Vendor Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 mb-5">
            <div class="bg-white">
                <div class="owl-carousel vendor-carousel">
                    <img src="../img/marca1.png" alt="">
                    <img src="../img/marca2.png" alt="">
                    <img src="../img/marca3.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
    

    <!-- Footer Start -->
<div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-4 col-md-6 footer-about">
                <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 bg-primary p-4">
                    <a href="index.html" class="navbar-brand">
                        <h1 class="m-0 text-white"><img src="../img/logo-LBc.png" alt="Image" style="height: 120px; width: 200px;"><i></i></h1>
                    </a>
                    <br>
                    <p class="mt-3 mb-4">“Committed to Safety, <br> Efficiency, and Quality"</p>
                    <p>LBC Suppliers & Services S.A. de C.V.</p>
                   
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="row gx-5">
                    <div class="col-lg-4 col-md-12 pt-5 mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Keep In Touch</h3>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            <p class="mb-0">Ave. Francisco Villa #7503
                                Col. Panamericana
                                Chihuahua, Chih. C.P. 31210</p>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bi bi-envelope-open text-primary me-2"></i>
                            <p class="mb-0"><a href="mailto:baylon@Ibcsuppliers.com">baylon@lbcsuppliers.com</a></p>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bi bi-telephone text-primary me-2"></i>
                            <p class="mb-0"><a href="tel:+526142781051">+52 614-278-1051</a></p>
                        </div>             
                    </div>
                    <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Links</h3>
                        </div>
                        <div class="link-animated d-flex flex-column justify-content-start">
                            <a class="text-light mb-2" href="index.html"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-light mb-2" href="nosotros.html"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                            <a class="text-light mb-2" href="actividades.html"><i class="bi bi-arrow-right text-primary me-2"></i>What We Do</a>
                            <a class="text-light mb-2" href="productos.php"><i class="bi bi-arrow-right text-primary me-2"></i>Products</a>
                            <a class="text-light" href="contact.html"><i class="bi bi-arrow-right text-primary me-2"></i>Contact</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Distributors</h3>
                        </div>
                        <div class="link-animated d-flex flex-column justify-content-start">
                            <a class="text-light mb-2" href="https://www.eagleresearchcorp.com/"><i class="bi bi-arrow-right text-primary me-2"></i>Eagle Research Corporation</a>
                            <a class="text-light mb-2" href="https://www.sick.com/mx/es/"><i class="bi bi-arrow-right text-primary me-2"></i>SICK | Sensor Intelligence</a>
                            <a class="text-light" href="https://www.ge.com/digital/"><i class="bi bi-arrow-right text-primary me-2"></i>GE Intelligent Platforms</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-white" style="background: #061429;">
    <div class="container text-center">
        <div class="row justify-content-end">
            <div class="col-lg-8 col-md-6">
                <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                    <p class="mb-0">&copy; <a class="text-white border-bottom" href="#">LBC Suppliers & Services</a>. All Rights Reserved. 
                    
                    Designed by <a class="text-white border-bottom" href="team.html">Ricardo T., Daniel B., Brandon C.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

    <style>
        /* Estilos básicos del interruptor */
        .toggle-switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 30px;
          border-radius: 15px;
          background-color: #2196F3;
        }
      
        /* Estilos del círculo deslizante */
        .toggle-switch input[type="checkbox"] {
          opacity: 0;
          width: 0;
          height: 0;
        }
      
        /* Estilos del círculo deslizante */
        .toggle-switch input[type="checkbox"] + .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          bottom: 0;
          background-color: #2196F3;
          border-radius: 15px;
          transition: 1.s;
          left: 0; /* Agregamos left inicialmente a 0 */
        }
      
        /* Estilo del círculo deslizante en el estado encendido */
        .toggle-switch input[type="checkbox"]:checked + .slider {
          background-color: #2196F3;
          right: calc(100% - 26px); /* Movemos el círculo deslizante a la derecha */
        }
      
        /* Estilos de las imágenes */
        .toggle-switch .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 30px;
          bottom: 2px;
          background-image: url('../img/icono-ing.png');
          background-size: cover;
          border-radius: 50%;
          transition: 1.5s;
          background-color: #2196F3;
        }
      
        /* Estilo de la imagen en el estado encendido */
        .toggle-switch input[type="checkbox"]:checked + .slider:before {
          background-image: url('../img/icono-ing.png');
        }
      </style>
      
      <script>
        
        const toggleSwitch = document.querySelector('input[type="checkbox"]');
        toggleSwitch.addEventListener('change', () => {
          if (toggleSwitch.checked) {
            // Cambiar a la página de inglés
            window.location.href = '../productos.php';
          } else {
            // Cambiar a la página de español
            window.location.href = 'LBC SUPPLIERS (Integradora) -INGLES-/index.html';
          }
        });
      </script>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


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