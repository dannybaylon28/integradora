<?php
// INICIALIZAR SESION
session_start();
 
// ELIMINAR VARIABLES DE SESION
$_SESSION = array();
 
// DESTRUIR SESION
session_destroy();
 
// REDIRECCION PAGINA DE INICIO
header("location: login.php");
exit;
?>