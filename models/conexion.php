<?php
$servername = "sql308.infinityfree.com";
$username = "if0_40616220";
$password = "KH5emM7h7cst";
$dbname = "if0_40616220_utacuarto1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Error de conexion: " . mysqli_connect_error());
}

// Forzar caracteres UTF-8 para evitar problemas con tildes/eñes
mysqli_set_charset($conn, "utf8");
?>