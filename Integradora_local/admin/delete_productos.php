<?php
// INICIO DE SESION
session_start();

// COMPROBACION DE QUE SE A INICIADO SESION
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once '../config.php';

// VERIFICACION DE ID NO ESTE VACIO
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {

    // OBTENER ID DE PRODUCTO DE URL
    $producto_id = trim($_GET['id']);

    try {
        // SELECCIONAR URL_IMAGEN DEL PRODUCTO
        $selectSql = "CALL SeleccionarProducto(?)";
        $stmt = $mysqli->prepare($selectSql);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $selectResult = $stmt->get_result();
        $stmt->close();

        if ($selectResult && $selectResult->num_rows > 0) {
            $row = $selectResult->fetch_assoc();
            $urlImagen = $row['URL_imagen'];

            // ELIMINAR PRODUCTO
            $deleteSql = "CALL EliminarProducto(?)";
            $stmt = $mysqli->prepare($deleteSql);
            $stmt->bind_param("i", $producto_id);

            if ($stmt->execute()) {
                // ELIMINAR IMAGEN
                if (unlink("../" . $urlImagen)) {
                    // REDIRECCION PAGINA PRINCIPAL
                    header("location: productos.php");
                    exit();
                } else {
                    throw new Exception("Error al eliminar la imagen del producto.");
                }
            } else {
                throw new mysqli_sql_exception();
            }
        } else {
            throw new Exception("No se encontró el producto especificado.");
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = "Error al eliminar el producto. Aún existen solicitudes con este producto sin contestar.";
        // REDIRECCION A LA PAGINA PRODUCTOS CON EL MENSAJE DE ERROR
        header("location: productos.php?error=" . urlencode($error_message));
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        // REDIRECCION A LA PAGINA PRODUCTOS CON EL MENSAJE DE ERROR
        header("location: productos.php?error=" . urlencode($error_message));
        exit();
    }
}
?>