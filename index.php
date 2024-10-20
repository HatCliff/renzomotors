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
<body class="pt-5 mt-4">
    <?php
        include('admin/navbaradmin.php');

    ?>


    <H1>pagina de users</H1>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>