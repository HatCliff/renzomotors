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
    <title>TEMPLATE PUBLIC</title>
</head>
<body>
    <?php
        include('./admin/mantenedores/index.php');
        echo 'Navbar goes here';
    ?>
</body>
</html>