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
$query = "SELECT * FROM usuarios WHERE email = '$email'";

$result = mysqli_query($conexion, $query);
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if(!password_verify($password, $row['password'])){
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        $_SESSION['error_code'] = 401;
        header('Location: /pages/login.php');
    }
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION['usuario'] = $usuario;
    header('Location: /pages/dashboard.php  ');
}
else{
    $_SESSION['error'] = 'Usuario o contraseña incorrectos';
    $_SESSION['error_code'] = 401;
    header('Location: /pages/login.php');
}
?>