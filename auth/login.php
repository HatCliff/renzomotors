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
    $_SESSION['tipo_persona'] = $row['tipo_persona'];
    // Suponiendo que ya has obtenido estos datos del usuario desde la base de datos o formulario de inicio de sesión
    $_SESSION['rut'] = $row['rut'];
    $_SESSION['correo'] = $row['correo'];
    $_SESSION['nombre'] = $row['nombre'];
    $_SESSION['apellido'] = $row['apellido'];
// Y cualquier otro dato que necesites almacenar

    //CAMIAR POR NOMBRE USUARIO;
    $_SESSION['usuario'] = $row;
    //$_SESSION['usuario'] = "".$row['email']."";
    if($row['tipo_persona'] == 'usuario'){
        header('Location: /xampp/renzomotors/index.php');
    }
    else if($row['tipo_persona'] == 'administrador'){
        header('Location: /xampp/renzomotors/admin/indexadmin.php');
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