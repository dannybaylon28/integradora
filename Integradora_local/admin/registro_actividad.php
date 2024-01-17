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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro actividad</title>

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
            background-image: url('../img/fondo-body-abstract.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            background-color: black;
        }

        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        td {
            color: white;
        }
        tr {
            color: white;
        }
        th {
            color: white;
        }

        table tr td:last-child {
            width: 120px;
        }

        .container-fluid {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .btn-regresar {
            border-radius: 15px;
            background-color: #D33A49;
            color: white;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-regresar:hover {
            background-color: #A11520;
        }
    </style>
</head>
<body> 

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <a href="index.php" class="btn btn-regresar col-3 ">Regresar</a>
                <br> <br>
                    <h2 class="text-center text-white">Tabla de mensajes</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // CONEXION A LA BASE DE DATOS
                            require_once "../config.php";

                            // ELIMINAR REGISTROS EXCEDENTES DE 40
                            $sqlEliminarRegistros = "CALL EliminarRegistrosExcedentes()";
                            $mysqli->query($sqlEliminarRegistros);

                            // OBTENER MENSAJES
                            $sqlObtenerMensajes = "CALL ObtenerMensajes()";
                            if ($result = $mysqli->query($sqlObtenerMensajes)) {
                                $rowCount = $result->num_rows;

                                if ($rowCount > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['IdMensaje'] . "</td>";
                                        echo "<td>" . $row['Mensaje'] . "</td>";
                                        echo "<td>" . $row['Fecha'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No se encontraron registros.</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Oops! Something went wrong. Please try again later.</td></tr>';
                            }

                            // CIERRE DE CONEXION
                            $mysqli->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        
    </div>
    
</body>
</html>
