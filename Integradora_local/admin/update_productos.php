<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE HA INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../config.php";

// VARIABLES
$nombre = $descripcion = $caracteristicas = $imagen = "";
$nombre_err = $descripcion_err = $caracteristicas_err = $imagen_err = "";
$error_message = "";

// VALIDACION DE CAMPOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // NOMBRE
    $input_nombre = trim($_POST["Nombre_producto"]);
    if (empty($input_nombre)) {
        $nombre_err = "Por favor ingrese un nombre.";
    } else {
        $nombre = $input_nombre;
    }

    // DESCRIPCION
    $input_desc = trim($_POST["Descripcion"]);
    if (empty($input_desc)) {
        $descripcion_err = "Por favor ingrese una descripción.";
    } else {
        $descripcion = $input_desc;
    }

    // CARACTERISTICAS
    $input_car = trim($_POST["Caracteristicas"]);
    if (empty($input_car)) {
        $caracteristicas_err = "Por favor ingrese sus características.";
    } else {
        $caracteristicas = $input_car;
    }

    // IMAGEN ACTUAL (RUTA)
    $imagen_actual = "../" . $_POST["URL_imagen"];

    // VERIFICACION DE SELECCION NUEVA IMAGEN
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === 0 && !empty($_FILES['nueva_imagen']['name'])) {
        $imagen_temp = $_FILES['nueva_imagen']['tmp_name'];
        $imagen_err = $_FILES['nueva_imagen']['error'];

        // ELIMINACION IMAGEN ACTUAL
        if (file_exists($imagen_actual)) {
            unlink($imagen_actual);
        }

        // GUARDAR IMAGEN SELECCIONADA
        $target_dir = "../img/";
        $imagen = $_FILES['nueva_imagen']['name'];
        $target_file = $target_dir . basename($imagen);

        // MOVER IMAGEN A CARPETA
        if (move_uploaded_file($imagen_temp, $target_file)) {
            // ACTUALIZACION DE RUTA EN TABLA PRODUCTOS
            $imagen = "img/" . $imagen;
        } else {
            $error_message = "Error al cargar la nueva imagen.";
        }
    } else {
        // MANTENER IMAGEN ACTUAL
        $imagen = $_POST["URL_imagen"];
    }

    if (empty($nombre_err) && empty($descripcion_err) && empty($caracteristicas_err)) {
        // ACTUALIZAR DATOS
        $sql = "CALL ActualizarProducto(?,?,?,?,?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // VARIABLES PARAMETROS
            $stmt->bind_param("ssssi", $nombre, $descripcion, $caracteristicas, $imagen, $_POST["id"]);

            // Intentar ejecutar la declaración preparada
            if ($stmt->execute()) {
                // REDIRECCION PAGINA
                header("location: productos.php");
                exit();
            } else {
                $error_message = "Algo falló. Por favor intente más tarde.";
            }
        }

        // CIERRE
        $stmt->close();
    }

    // CIERRE CONEXION
    $mysqli->close();
} else {
    // VERIFICAR SI EL ID ES VALIDO
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // GET DE ID
        $id = trim($_GET["id"]);

        // SELECCION
        $sql = "CALL SeleccionarProducto(?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // PARAMETRO ID
            $stmt->bind_param("i", $id);

            // EJECUCION
            if ($stmt->execute()) {
                // GET RESULTADO
                $result = $stmt->get_result();

                // VERIFICAR SI EL RESULTADO CONTIENE DATOS
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    $nombre = $row["Nombre_producto"];
                    $descripcion = $row["Descripcion"];
                    $caracteristicas = $row["Caracteristicas"];
                    $imagen = $row["URL_imagen"];
                }
                $error_message = "Algo falló. Por favor intente más tarde.";
            }
        }

        // CIERRE
        $stmt->close();

        // CIERRE CONEXION
        $mysqli->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Actualizar producto</title>
   
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
            background-image: url('../img/fondo-body-registeradmin.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
        }

        .wrapper {
            width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        .form-group {
            text-align: center;
        }

        img {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #5BC0BE;
            color: white;
            border-radius: 5px;
        }

        .custom-file-upload:hover {
            background-color: #3C8F8D;
        }


        .btn-primary {
            background-color: #5BC0BE;
            color: white;
            border-radius: 15px;
        }

        .btn-primary:hover {
            background-color: #3C8F8D;
        }

        .btn-secondary {
            background-color: #D33A49;
            color: white;
            border-radius: 15px;
        }

        .btn-secondary:hover {
            background-color: #A11520;
            
        }

        h2 {
            text-align: center;
            color: white;
        }

        label {
            font-weight: bold;
        }

        p {
            text-align: center;
        }

        /* Estilo adicional para errores de validación */
        .is-invalid {
            border-color: #FF4136 !important;
        }

        .invalid-feedback {
            color: #FF4136;
        }
    </style>
    <script>
        function mostrarError(mensaje) {
            var errorDiv = document.getElementById("errorDiv");
            errorDiv.innerHTML = '<div class="alert alert-danger">' + mensaje + '</div>';
        }
    </script>
</head>

<body>    
    <script>
        // MOSTRAR MENSAJE DE ERROR
        <?php if (!empty($error_message)) : ?>
            mostrarError("<?php echo $error_message; ?>");
        <?php endif; ?>
    </script>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Actualizar productos</h2>
                    <p>Por favor actualice los datos del producto</p>
                    <div id="errorDiv"></div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="Nombre_producto" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="Descripcion" class="form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>"><?php echo $descripcion; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descripcion_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Características</label>
                            <input type="text" name="Caracteristicas" class="form-control <?php echo (!empty($caracteristicas_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $caracteristicas; ?>">
                            <span class="invalid-feedback"><?php echo $caracteristicas_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Imagen actual</label>
                            <br>
                            <img src="../<?php echo $imagen; ?>" width="200" alt="Imagen actual">
                        </div>
                        <div class="form-group">
                            <label>Seleccionar nueva imagen</label>
                            <input type="file" name="nueva_imagen" class="form-control-file">
                        </div>
                        <input type="hidden" name="URL_imagen" value="<?php echo $imagen; ?>">
                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="productos.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
