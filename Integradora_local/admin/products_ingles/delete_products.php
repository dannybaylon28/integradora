<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once '../../config.php';

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $product_id = trim($_GET['id']);

    try {
        $selectSql = "CALL SelectProduct(?)";
        $stmt = $mysqli->prepare($selectSql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $selectResult = $stmt->get_result();
        $stmt->close();

        if ($selectResult && $selectResult->num_rows > 0) {
            $row = $selectResult->fetch_assoc();
            $image_url = $row['URL_images'];

            $deleteSql = "CALL DeleteProduct(?)";
            $stmt = $mysqli->prepare($deleteSql);
            $stmt->bind_param("i", $product_id);

            if ($stmt->execute()) {
                if (unlink("../../" . $image_url)) {
                    header("location: products.php");
                    exit();
                } else {
                    throw new Exception("Error deleting the product image.");
                }
            } else {
                throw new mysqli_sql_exception();
            }
        } else {
            throw new Exception("The specified product was not found.");
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = "Error deleting the product. There are still pending requests for this product.";
        header("location: products.php?error=" . urlencode($error_message));
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        header("location: products.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
