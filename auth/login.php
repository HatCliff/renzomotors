<?php
$ENV = parse_ini_file(__DIR__ . "/../.env");
require "./../config/conexion.php";
session_start();

$correo = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];
if($correo == '' || $contrasenia == ''){
    $_SESSION['error'] = 'Usuario o contraseña vacios';
    $_SESSION['error_code'] = 401;
    header('Location: /xampp/renzomotors/pages/login.php');
    exit();
}
$query = "SELECT * FROM usuario_registrado WHERE correo = '$correo'";
try {
    $result = mysqli_query($conexion, $query);
} catch (Exception $e) {
    //mostrar error 
    $_SESSION['error'] = $e ;
    $_SESSION['error_code'] = 500;
    header('Location: /xampp/renzomotors/pages/login.php');
    exit();
}
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if(!password_verify($contrasenia, $row['contrasenia'])){
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        $_SESSION['error_code'] = 401;
        header('Location: /xampp/renzomotors/pages/login.php');
        exit();
    }
    //CAMIAR POR NOMBRE USUARIO;
    $_SESSION['usuario'] = $row;
    //$_SESSION['usuario'] = "".$row['email']."";
    if($row['tipo_persona'] == 'usuario'){
        header('Location: /xampp/renzomotors/index.php');
    }
    else{
        header('Location: /xampp/renzomotors/');
    }
    exit();
}
else{
    $_SESSION['error'] = 'Usuario o contraseña incorrectos';
    $_SESSION['error_code'] = 401;
    header('Location: /xampp/renzomotors/pages/login.php');
    exit();
}
?>