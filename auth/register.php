<?php 

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$rut = $_POST['rut'];
$correo = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];

if($nombre == '' || $apellido == '' || $rut == '' || $correo == '' || $contrasenia == ''){
    
    $_SESSION['error'] = 'Campos vacios';
    $_SESSION['error_code'] = 401;


    header('Location: /xampp/renzomotors/pages/register.php');
    
    exit();
}

$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

$query = "INSERT into usuario_registrado (nombre, apellido, rut, contrasenia, correo) VALUES ('$nombre', '$apellido', '$rut', '$contrasenia','$correo')";
$result = mysqli_query($conexion, $query);






?>