<?php 

$email = $_POST['email'];
$password = $_POST['password'];
if($email == '' || $password == ''){
    header('Location: /pages/login.php');
}

//require_once './../config/conexion.php';

if($email == 'test1@example.com' || $password == 'pass'){
    session_start();
    $_SESSION['usuario'] = $email;
    header('Location: /pages/dashboard');
}




?>