<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE A INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once '../config.php';

// DEFINICION VARIABLES
$nombre = $descripcion = $caracteristicas = "";
$nombre_err = $descripcion_err = $caracteristicas_err = "";

// VALIDACION DE CAMPOS ENVIADOS
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
        $caracteristicas_err = "Por favor ingrese las características.";
    } else {
        $caracteristicas = $input_car;
    }

    // IMAGEN
  // IMAGEN
if (isset($_FILES['URL_imagen'])) {
    $file = $_FILES['URL_imagen'];
    $nombre_imagen = $file['name'];
    $tipo = $file['type'];
    $ruta_provisional = $file['tmp_name'];
    $size = $file['size'];
    $carpeta = '../img/'; // Ruta a la carpeta donde deseas guardar las imágenes

    if ($tipo != 'image/png') {
        $imagen_err = "ERROR. Solo se permiten fotos en formato png";
    } else {
        $src = $carpeta . $nombre_imagen;
        move_uploaded_file($ruta_provisional, $src);
        $imagen = "img/" . $nombre_imagen;
    }
}

    if (empty($nombre_err) && empty($descripcion_err) && empty($caracteristicas_err) && empty($imagen_err)) {

        $sql = "CALL InsertarProducto(?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // PARAMETROS
            $stmt->bind_param("ssss", $nombre, $descripcion, $caracteristicas, $imagen);

            if ($stmt->execute()) {
                header("location: productos.php");
                exit();
            } else {
                echo "Algo falló. Por favor intente más tarde.";
            }
        }

        // CIERRE
        $stmt->close();
    }

    // CIERRE CONEXION
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrar producto</title>

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
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Ingresar registro</h2>
                    <p>Por favor, complete este formulario y envíelo para almacenar el producto.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                            <label>Imagen</label>
                            <input type="file" name="URL_imagen" class="form-control-file <?php echo (!empty($imagen_err)) ? 'is-invalid' : ''; ?>" accept="image/jpeg, image/jpg, image/png">
                            <span class="invalid-feedback"><?php echo $imagen_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="productos.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>