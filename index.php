<!DOCTYPE html>
<?php 
session_start();
if(isset($_SESSION['usuario'])){
    //header('Location: /pages/dashboard');
    //echo '<div>Dashboard</div>';
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<style>
    .offcanvas {
        /* background-color:#E6E6E6!important; Cambia este valor al color deseado */
        background: linear-gradient(to bottom right,#2D441D,85%,#528526);
    }
    .accordion-item {
        background-color:#F8FFE5; /* Color de fondo del acordeón */
        border-color: #324C1F; /* Color del borde del acordeón */
        color: black; /* Color del texto */
    }
    .accordion-button {
        background-color:#E6E6E6; /* Color de fondo de los botones del acordeón */
        color: black; /* Color del texto */
    }
    .accordion-button:not(.collapsed) {
        background-color: #426B1F; /* Color de fondo cuando está expandido */
        color: #ffffff; /* Color del texto */
    }
    .list-group-item {
        background-color: #F8FFE5; /* Color de fondo de los elementos de la lista */
    }
    .list-group {
        list-style-type: none; /* Elimina las viñetas */
        padding-left: 0; /* Opcional: elimina el margen izquierdo */
    }
    .navbar {
        background-color: #2D441D;
        color: white;
        
        /* !important;*/ /* Color de fondo del navbar */
    }
    .nav-link, .nav-item, .navbar-brand {
        color: white !important; /* Color de los enlaces y la marca */
    }
    body{
            background: #E6E6E6;
        }

    nav a:hover{
        background-color:#E6E6E6; /* Color de fondo de los botones del acordeón */
        color: black !important; 
        border-radius: 20px;
    }
</style>
<body class="pt-5 mt-4">
    <?php
        include('admin/navbaradmin.php');

    ?>
    <img src="image.png"class="img-fluid" alt="">

    <H1>pagina de users</H1>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>