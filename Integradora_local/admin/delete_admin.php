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
    header("location:  index.php?error=No tienes acceso a este apartado.");
    exit;
}

// ARCHIVO CONFIG
require_once "../config.php";

// Variable para almacenar el mensaje de error
$error_message = "";

// ELIMINAR ADMINISTRADOR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEliminar = $_POST["idEliminar"];

    if (in_array($idEliminar, [1, 2, 3])) {
        $error_message = "Estos administradores no se pueden eliminar.";
    } else {
        // ELIMINAR REGISTROS RELACIONADOS EN LA TABLA COTIZACIONES
        $sqlEliminarCotizaciones = "CALL EliminarCotizacionesAdministrador(?)";
        if ($stmtEliminarCotizaciones = mysqli_prepare($mysqli, $sqlEliminarCotizaciones)) {
            mysqli_stmt_bind_param($stmtEliminarCotizaciones, "i", $idEliminar);

            if (mysqli_stmt_execute($stmtEliminarCotizaciones)) {
                // ELIMINAR EL ADMINISTRADOR
                $sqlEliminarAdmin = "CALL EliminarAdministrador(?)";
                if ($stmtEliminarAdmin = mysqli_prepare($mysqli, $sqlEliminarAdmin)) {
                    mysqli_stmt_bind_param($stmtEliminarAdmin, "i", $idEliminar);

                    if (mysqli_stmt_execute($stmtEliminarAdmin)) {
                        header("location: delete_admin.php");
                        exit;
                    } else {
                        $error_message = "Algo salió mal al eliminar el administrador. Por favor, inténtalo de nuevo más tarde.";
                    }

                    mysqli_stmt_close($stmtEliminarAdmin);
                }
            } else {
                $error_message = "Algo salió mal al eliminar los registros relacionados en la tabla Cotizaciones. Por favor, inténtalo de nuevo más tarde.";
            }

            mysqli_stmt_close($stmtEliminarCotizaciones);
        }
    }
}

// CONSULTA OBTENER ADMINISTRADORES
$sqlAdmins = "CALL ObtenerAdministrador()";
$resultAdmins = $mysqli->query($sqlAdmins);

// CIERRE DE CONEXION
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administradores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
        body{
            background-image: url('../img/fondo-body-registeradmin.jpg');
            background-size: cover;
            background-repeat: no-repeat;
             background-attachment: fixed;
        }

        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        .btn-regresar {
            width: 200px;
            border-radius: 12px;
             margin: 5px;
             background-color: #880000; /* Color rojo obscuro */
             color: white;
             transition: background-color 0.3s; /* Transición de color */
        }

        .btn-regresar:hover {
        background-color: #c11c1c; /* Color rojo más claro al pasar el cursor */
}


        h2 {
            text-align: center;
            color: white;
        }

        .table {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px; /* Agregar un margen alrededor de la tabla */
            border-radius: 10px; /* Hacer el borde más circular */
            margin-top: 20px; /* Añadir un espacio entre el botón "Regresar" y la tabla */
        }

        .table th,
        .table td {
            color: white;
            text-align: center;
        }
    </style>

    <script>
        // BORRAR MENSAJE DE ERROR DESPUÉS DE 7SEG
        setTimeout(function () {
            var errorAlert = document.getElementById("errorAlert");
            if (errorAlert) {
                errorAlert.style.display = "none";
            }
        }, 7000);
    </script>
</head>

<body>
    <br>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if (!empty($error_message)) : ?>
                        <div id="errorAlert" class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <h2>Administradores</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultAdmins->num_rows > 0) :
                                while ($row = $resultAdmins->fetch_assoc()) :
                            ?>
                                    <tr>
                                        <td><?php echo $row['IdAdministradores']; ?></td>
                                        <td><?php echo $row['Username']; ?></td>
                                        <td>
                                            <?php if (!in_array($row['IdAdministradores'], [1, 2, 3])) : ?>
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                    <input type="hidden" name="idEliminar" value="<?php echo $row['IdAdministradores']; ?>">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este administrador?')">Eliminar</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3">No se encontraron administradores.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="container">
        <div class="row justify-content-center">
            <a href="index.php" class="btn btn-danger btn-regresar">Regresar</a>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
