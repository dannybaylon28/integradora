<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE HA INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$administradorId = $_SESSION["id"];
if (!in_array($administradorId, [1, 2, 3])) {
    header("location: index.php?error=No tienes acceso a este apartado.");
    exit;
}

// ARCHIVO CONFIG
require_once "../config.php";
 
// DEFINIR VARIABLES
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$error_regadmin = "";
 
// DATOS FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // VALIDACION USERNAME
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor ingresa un nombre de usuario.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "El nombre de usuario solo puede contener letras, números y guiones bajos.";
    } else {
        // CONSULTA
        $sql = " SELECT IdAdministradores FROM administradores WHERE Username =?";
        
        if ($stmt = mysqli_prepare($mysqli, $sql)) {
            // VARIABLES COMO PARAMETROS
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // PARAMETROS
            $param_username = trim($_POST["username"]);
            
            // EJECUCION
            if (mysqli_stmt_execute($stmt)) {
                // ALMACEN RESULTADO
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                $error_regadmin = "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            // CERRAR LA INSTRUCCION
            mysqli_stmt_close($stmt);
        }
    }
    
    // VALIDACION CONTRASEÑA
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingresa una contraseña.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // VALIDAR CONFIRMACION CONTRASEÑA
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor confirma la contraseña.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
    
    // VERIFICACION DE ERRORES DE ENTRADA
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // INSERT
        $sql = "CALL InsertarAdministrador(?, ?)";
         
        if ($stmt = mysqli_prepare($mysqli, $sql)) {
            // VINCULACION DE VARIABLES
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // PARAMETROS
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            // EJECUCION
            if (mysqli_stmt_execute($stmt)) {
                header("location: registro_actividad.php");
                exit();
            } else {
                $error_regadmin = "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            // CIERRE
            mysqli_stmt_close($stmt);
        }
    }
    
    // CIERRE CONEXION
    mysqli_close($mysqli);
}
?>
 
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar administrador</title>
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
            font: 14px sans-serif;
            background-image: url('../img/fondo-body-registeradmin.jpg'); /* Reemplaza 'ruta/imagen-fondo.jpg' con la ruta de tu imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .wrapper {
            width: 340px;
            margin: 100px auto; /* Ajusta la distancia del formulario al centro verticalmente */
            font-size: 15px;
        }
        .wrapper form {
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.7); /* Color tenuemente blanco transparente */
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            border-radius: 20px; /* Borde más circular */
            color: white;
        }
        .wrapper h2 {
            margin: 0 0 15px;
            text-align: center; /* Centrar el título */
            font-family: 'Nunito', sans-serif; /* Cambia la fuente del título */
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 5px; /* Bordes más redondeados */
        }
        /* Estilos para los botones */
        .btn-primary {
            background-color: #061429; /* Color azul oscuro */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: rgba(0, 123, 255, 0.8); /* Color azul oscuro al pasar el ratón */
            color: white;
        }
        .btn-secondary {
            background-color: #a5243d; /* Color rojo */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #7c1e2c; /* Color rojo oscuro al pasar el ratón */
            color: white;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php if (!empty($error_regadmin)) : ?>
            <div class="alert alert-danger"><?php echo $error_regadmin; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <h2 style="color: white;">Registro</h2>
                <p>Llena todos los campos que se piden a continuación.</p>
            </div>
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirmación de contraseña</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-primary" value="Crear">
                <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>