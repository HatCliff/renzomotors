<?php
require "./../config/conexion.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
if($email == '' || $password == ''){
    $_SESSION['error'] = 'Usuario o contraseña vacios';
    $_SESSION['error_code'] = 401;
    header('Location: /pages/login.php');
}

//require_once './../config/conexion.php';

if($email == 'test1@example.com' && $password == 'Pass123@'){
    session_start();
    $_SESSION['usuario'] = $email;
    echo $_SESSION['usuario'];
    header('Location: /pages/dashboard');
}
else{
    $_SESSION['error'] = 'Usuario o contraseña incorrectos';
    $_SESSION['error_code'] = 401;
    http_response_code(401);
    header('Location: /renzomotors/pages/login.php');
}




?>