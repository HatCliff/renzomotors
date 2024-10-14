<?php 
    if(!isset($_SESSION['usuario'])){
        header('Location: /login');
    }
    echo "<h1>Bienvenido ".$_SESSION['usuario']['nombre']."</h1>";
?>