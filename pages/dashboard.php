<?php 
//Si no hay una sesión iniciada, redirigir al login
    if(!isset($_SESSION['usuario'])){
        header('Location: /login');
    }
?>