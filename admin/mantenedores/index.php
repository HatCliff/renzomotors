 <?php 
//Si no hay una sesión iniciada, redirigir al login
    // if(!isset($_SESSION['usuario'])){
    //     header('Location: /renzomotors/pages/login');
    // }
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body>
    <?php
    include './components/navbar.php';
    echo "prueba";
    ?>
    <div class="container mt-5 pt-5">
        <h1>Bienvenido a RenzoMotors</h1>
        <p>Tu automotora de confianza</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
