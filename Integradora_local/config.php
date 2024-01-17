<?php
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    $host = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname= 'integradora';
    
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'u401760982_daniel');
    define('DB_PASSWORD', 'Odreboy2007');
    define('DB_NAME', 'u401760982_integradora');

    /* Attempt to connect to MySQL database */
    $mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);

    // Check connection
    if ($mysqli === false) {
        die("ERROR: No se pudo conectar con la base de datos. " . $mysqli->connect_error);
    }
?>
