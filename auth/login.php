<?php
$ENV = parse_ini_file(__DIR__ . "/../.env");
require "./../config/conexion.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
if($email == '' || $password == ''){
    $_SESSION['error'] = 'Usuario o contraseña vacios';
    $_SESSION['error_code'] = 401;
    header('Location: /'.$ENV['PREFIX'].'/pages/login.php');
    exit();
}
$query = "SELECT * FROM usuarios WHERE email = '$email'";

$result = mysqli_query($conexion, $query);
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if(!password_verify($password, $row['password'])){
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        $_SESSION['error_code'] = 401;
        header('Location: /'.$ENV['PREFIX'].'/pages/login.php');
        exit();
    }
    //CAMIAR POR NOMBRE USUARIO;
    $_SESSION['usuario'] = $row;
    //$_SESSION['usuario'] = "".$row['email']."";
    header('Location: /'.$ENV['PREFIX'].'/pages/dashboard.php');
    exit();
}
else{
    $_SESSION['error'] = 'Usuario o contraseña incorrectos';
    $_SESSION['error_code'] = 401;
    header('Location: /'.$ENV['PREFIX'].'/pages/login.php');
    exit();
}
?>