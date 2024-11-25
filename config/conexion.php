<?php
$host = "localhost";
$usuario = "root";      
$contrasena = "";       
$base_datos = "renzo_motors";  

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

?>
