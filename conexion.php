<?php
$host = "f5bd4a28@us-cluster-east-01.k8s.cleardb.net/heroku_0bcf63a67107691?reconnect=true";
$usuario = "bf158755f83171";      
$contrasena = "f5bd4a28";       
$base_datos = "heroku_0bcf63a67107691";  

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
