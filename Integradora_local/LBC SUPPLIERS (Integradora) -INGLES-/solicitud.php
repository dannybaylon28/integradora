<?php
require_once '../config.php';

// VARIABLES
$nombre = $email = $comentarios = "";
$nombre_err = $email_err = $fecha_err = "";
$success_message = "";
$error_message = "";

// LISTA DE PRODUCTOS
$productos = array();
$sql = "CALL ObtenerProductos()";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[$row["IdProductos"]] = $row["Nombre_producto"];
    }
}
mysqli_free_result($result);

// VALIDACION CAMPOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // NOMBRE CLIENTE
    $input_nombre = trim($_POST["Nombre_cliente"]);
    if (empty($input_nombre)) {
        $nombre_err = "Por favor ingrese un nombre.";
    } elseif (!filter_var($input_nombre, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nombre_err = "Por favor ingrese un nombre válido.";
    } else {
        $nombre = $input_nombre;
    }

    // EMAIL
    $input_email = trim($_POST["Email"]);
    if (empty($input_email)) {
        $email_err = "Por favor ingrese un correo.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Por favor ingrese un correo válido.";
    } else {
        $email = $input_email;
    }

    // COMENTARIOS
    $input_comentario = trim($_POST["Comentarios"]);
    if (isset($input_comentario)) {
        $comentarios = $input_comentario;
    }

    // SELECCION DE PRODUCTOS
    $seleccion = array();
    if (isset($_POST["Seleccion_producto"])) {
        $seleccion = $_POST["Seleccion_producto"];
    }
    if (empty($seleccion)) {
        $error_message = "Por favor, seleccione al menos un producto.";
    } else {
        // FECHA DE ENVIO DE SOLICITUD
        if (empty($nombre_err) && empty($email_err)) {
            $fecha = date("Y-m-d");

            // SELECCION PRODUCTOS A TEXTO
            $seleccion_producto_texto = implode(", ", $seleccion);

            // SOLICITUD INSERTAR A LA BASE
            $sql = "CALL InsertarSolicitud(?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("sssss", $nombre, $email, $seleccion_producto_texto, $comentarios, $fecha);
                if ($stmt->execute()) {
                    $stmt->close();

                    // ID SOLICITUD INSERTADA
                    $result = $mysqli->query("SELECT LAST_INSERT_ID() AS id");
                    $row = $result->fetch_assoc();
                    $solicitud_id = $row['id'];
                    $result->free();

                    // INSERCION DE SELECCION DE PRODUCTOS A LA TABLA SOLIVITUDE_HAS_PRODUCTOS
                    foreach ($seleccion as $producto_id) {
                        $sql = "CALL InsertarRelacionSolicitudProducto(?, ?)";
                        if ($stmt = $mysqli->prepare($sql)) {
                            $stmt->bind_param("ii", $solicitud_id, $producto_id);
                            $stmt->execute();
                        }
                    }

                    $success_message = "Su solicitud ha sido enviada con éxito.";
                } else {
                    $error_message = "Algo falló. Por favor intente más tarde.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Make an Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
    .wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh; /* Ajusta el alto del formulario para ocupar el 100% de la altura vertical de la pantalla */
  margin-bottom: 150px;
}

/* Estilos para el contenedor del formulario */
.form-container {
  background-color: #f8f9fa;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  width: 100%;
  margin: 50px auto; /* Centrar el formulario y separarlo de la parte inferior */
}

/* Estilos para el título del formulario */
.form-title {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 20px;
  color: #061429;
  text-align: center; /* Centrar el título */
}

/* Estilos para los labels del formulario */
.form-label {
  font-size: 18px;
  font-weight: 500;
  color: #061429;
}

/* Estilos para los campos del formulario */
.form-control {
  border-radius: 10px;
  border: 1px solid #ced4da;
  margin-bottom: 20px;
  padding: 12px;
}

.form-control:focus {
  box-shadow: none;
}

/* Estilos para los botones */
.btn {
  border-radius: 30px;
  padding: 12px 30px;
  font-size: 16px;
  font-weight: 600;
  transition: all 0.3s ease;
}


.btn-primary:hover,
.btn-secondary:hover {
  transform: translateY(-3px);
}

/* Estilos para los checkbox */
.form-check {
  position: relative;
  padding-left: 35px;
  cursor: pointer;
  font-size: 18px;
}

.form-check input[type="checkbox"] {
  opacity: 0;
  
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #f8f9fa;
  border-radius: 5px;
  border: 2px solid #061429;
}

.form-check input[type="checkbox"]:checked ~ .checkmark:after {
  content: "";
  position: absolute;
  display: block;
  top: 6px;
  left: 9px;
  width: 6px;
  height: 12px;
  border: solid #061429;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

/* Animaciones */
.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-check {
  position: relative;
  padding-left: 35px;
  cursor: pointer;
  font-size: 18px;
}

.form-check input[type="checkbox"] {
  opacity: 0;
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #f8f9fa;
  border-radius: 5px;
  border: 2px solid #061429;
}

.form-check input[type="checkbox"]:checked ~ .checkmark {
  background-color: #4CAF50; /* Color verde */
  border-color: #4CAF50; /* Color verde */
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.form-check input[type="checkbox"]:checked ~ .checkmark:after {
  display: block;
  top: 6px;
  left: 9px;
  width: 6px;
  height: 12px;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
        
    </style>

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script>
        function limpiarCampos() {
            document.getElementById("nombre").value = "";
            document.getElementById("email").value = "";
            var checkboxes = document.getElementsByName("Seleccion_producto[]");
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
            document.getElementById("comentarios").value = "";
        }

        function redireccionar() {
        window.location.href = "productos.php";
    }
    </script>

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
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>+52 614-278-1051</small>
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
                    <a href="productos.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Productos</a>
                    <div class="dropdown-menu m-0">
                        <a href="productos.php" class="dropdown-item">Catalog</a>
                        <a href="solicitud.php" class="dropdown-item active">Make a Quotation</a>
                        
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="admin/login.php" class="btn btn-primary py-2 px-4 ms-3" style="background-color: #061429; color: white;">Admin</a>
        </div>
    </nav>

    <div class="container-fluid bg-primary py-4 bg-header" style="margin-bottom: 90px;">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <h1 class=" text-white animated zoomIn">Quotation</h1>
                <a class="h5 text-white">LBC</a>
                <a class="h5 text-white">Suppliers & Services</a>
            </div>
        </div>
    </div>
</div>
<!-- Navbar End -->

<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 form-title animate-fade-in text-center">Place an Order</h2>
                    <p class="animate-fade-in text-center">Please Enter The Order Details.</p>

                    <?php if (!empty($success_message)) : ?>
                        <div class="alert alert-success animate-fade-in"><?php echo $success_message; ?></div>
                    <?php elseif (!empty($error_message)) : ?>
                        <div class="alert alert-danger animate-fade-in"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-container animate-fade-in">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input id="nombre" type="text" name="Nombre_cliente" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input id="email" type="text" name="Email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Please, Select Your Products </label> <br> 
                            <?php foreach ($productos as $producto_id => $producto_nombre) : ?>
                                <br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input visually-hidden" type="checkbox" name="Seleccion_producto[]" value="<?php echo $producto_id; ?>">
                                        <span class="checkmark"></span>
                                        <?php echo $producto_nombre; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group"> <br>
                            <label class="form-label">Comments</label>
                            <textarea id="comentarios" name="Comentarios" class="form-control"><?php echo $comentarios; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"> Send Order</button>
                        <button type="button" class="btn btn-danger ml-2" onclick="limpiarCampos(), redireccionar()">Exit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

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
            window.location.href = '../solicitud.php';
          } else {
            // Cambiar a la página de español
            window.location.href = 'LBC SUPPLIERS (Integradora) -INGLES-/index.html';
          }
        });
      </script>
      

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

</html>
