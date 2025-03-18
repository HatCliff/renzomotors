<?php
$host = "localhost";
$usuario = "root";      
$contrasena = "hola2";       
$base_datos = "renzo_motors10";  

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

?>
