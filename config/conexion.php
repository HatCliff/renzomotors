<?php
$host = "localhost";
$usuario = "root";      
$contrasena = "";       
$base_datos = "renzo_motors_prueba";  

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

?>
