<?php
$host = "localhost";
$usuario = "root";      
$contrasena = "hola";       
$base_datos = "renzo_motors";  

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

?>
