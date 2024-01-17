<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE HA INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once '../config.php';

$error_registrosoli = "";

if (isset($_POST['estado_solicitud'], $_POST['id_solicitud'])) {
    $estado = $_POST['estado_solicitud'];
    $idSolicitud = $_POST['id_solicitud'];

    // ACTUALIZACION ESTADO DE SOLICITUD
    $updateSql = "CALL ActualizarEstadoSolicitud(?, ?)";
    $stmt = $mysqli->prepare($updateSql);
    $stmt->bind_param("is", $idSolicitud, $estado);

    if ($stmt->execute()) {
        if ($estado === 'Contestada') {
            // DATOS DE SOLICITUD
            $selectSql = "CALL SeleccionarSolicitud(?)";
            $stmt = $mysqli->prepare($selectSql);
            $stmt->bind_param("i", $idSolicitud);
            $stmt->execute();
            $selectResult = $stmt->get_result();
            $stmt->close();

            if ($selectResult && $selectResult->num_rows > 0) {
                $row = $selectResult->fetch_assoc();

                // ID ADMIN LOGEADO
                $administradorId = $_SESSION["id"];

                // NOMBRE ADMIN LOGEADO
                $nombreAdministrador = "";
                $selectAdminSql = "CALL ObtenerUsername(?)";
                $stmt = $mysqli->prepare($selectAdminSql);
                $stmt->bind_param("i", $administradorId);
                $stmt->execute();
                $stmt->bind_result($nombreAdministrador);
                $stmt->fetch();
                $stmt->close();

                // INSERT TABLA COTICACIONES
                $nombreCliente = $mysqli->real_escape_string($row['Nombre_cliente']);
                $emailCliente = $mysqli->real_escape_string($row['Email']);
                $comentarios = $mysqli->real_escape_string($row['Comentarios']);
                $fecha = $mysqli->real_escape_string($row['Fecha']);
                $estadoSolicitud = $mysqli->real_escape_string($row['Estado_solicitud']);

                // NOMBRE DE PRODUCTOS SELECCIONADOS
                $productosSeleccionados = "";
                $selectProductosSql = "CALL ObtenerNombresProductos(?)";
                $stmt = $mysqli->prepare($selectProductosSql);
                $stmt->bind_param("i", $idSolicitud);
                $stmt->execute();
                $selectProductosResult = $stmt->get_result();
                $stmt->close();

                if ($selectProductosResult && $selectProductosResult->num_rows > 0) {
                    while ($rowProducto = $selectProductosResult->fetch_assoc()) {
                        $productosSeleccionados .= $rowProducto['Nombre_producto'] . ", ";
                    }
                    $productosSeleccionados = rtrim($productosSeleccionados, ", ");
                }

                $insertSql = "CALL InsertarCotizacion(?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($insertSql);
                $stmt->bind_param("isssssss", $administradorId, $nombreCliente, $emailCliente, $productosSeleccionados, $comentarios, $fecha, $nombreAdministrador, $estadoSolicitud);

                if ($stmt->execute()) {
                    // ELIMINAR DATOS DE LA TABLA SOLICITUDES_HAS_PRODUCTOS
                    $deleteSql = "CALL EliminarRelacionesProductoSolicitud(?)";
                    $stmt = $mysqli->prepare($deleteSql);
                    $stmt->bind_param("i", $idSolicitud);

                    if ($stmt->execute()) {
                        // ELIMINAR SOLICITUD DE TABLA SOLICITUDES
                        $deleteSql = "CALL EliminarSolicitud(?)";
                        $stmt = $mysqli->prepare($deleteSql);
                        $stmt->bind_param("i", $idSolicitud);

                        if ($stmt->execute()) {
                            // REDIRECCION PAGINA PRINCIPAL
                            header("Location: cotizaciones.php");
                            exit();
                        } else {
                            // ERROR ELIMINAR SOLICITUD
                            $error_registrosoli = "Error al eliminar la solicitud de la tabla solicitudes. Por favor, intenta nuevamente.";
                        }
                    } else {
                        // ERROR ELIMINAR REFERENCIA TABLA SOLICITUDES_HAS_PRODUCTOS
                        $error_registrosoli = "Error al eliminar la referencia en la tabla solicitudes_has_productos. Por favor, intenta nuevamente.";
                    }
                } else {
                    // ERROR INSERCION EN TABLA COTIZACION
                    $error_registrosoli = "Error al insertar los datos en la tabla cotizaciones. Por favor, intenta nuevamente.";
                }
            } else {
                // ERROR OBTENER DATOS TABLA SOLICITUD
                $error_registrosoli = "No se encontró la solicitud especificada. Por favor, intenta nuevamente.";
            }
        } else {
            // REDIRECCION A TABLA ANTERIOR
            header("Location: cotizaciones.php");
            exit();
        }
    } else {
        // ERROR ACTUALIZACION TABLA
        $error_registrosoli = "Error al actualizar el estado de la solicitud. Por favor, intenta nuevamente.";
    }
} else {
    // MENSAJE DE ERROR
    $error_registrosoli = "No se recibieron los parámetros necesarios. Por favor, intenta nuevamente.";
}
?>