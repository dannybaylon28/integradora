<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE A INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once '../config.php';

// DATOS TABLA COTIZACIONES
$selectSql = "CALL ObtenerCotizaciones()";
$result = $mysqli->query($selectSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Almacén cotizaciones</title>
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

        .btn-regresar {
            background-color: #a5243d;
            color: white;
            border-radius: 10px;
            padding: 5px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-regresar:hover {
            background-color: #5d001f;
            transform: scale(1.1);
            color: white;
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

    <div class="container-lg">
        <h2 class="text-white">Cotizaciones contestadas</h2>
    <table class="table mt-3">
         <thead>
                <tr>
                    <th>Nombre del cliente</th>
                    <th>Correo electrónico</th>
                    <th>Selección de producto</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                    <th>Nombre del administrador</th>
                    <th>Estado de la solicitud</th>
             </tr>
         </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Nombre_cliente'] . "</td>";
                        echo '<td><a href="mailto:' . $row['Email'] . '">' . $row['Email'] . '</a></td>';
                        echo "<td>" . $row['Seleccion_producto'] . "</td>";
                        echo "<td>" . $row['Comentarios'] . "</td>";
                        echo "<td>" . $row['Fecha'] . "</td>";
                        echo "<td>" . $row['Nombre_admin'] . "</td>";
                        echo "<td>" . $row['Estado_solicitud'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No se encontraron registros en la tabla cotizaciones.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class=" text-center mb-5">
        <a href="cotizaciones.php" class="btn btn-regresar col-4">Regresar a la página anterior</a>
    </div>
</body>

</html>

<?php
// CIERRE CONEXION
$mysqli->close();
?>