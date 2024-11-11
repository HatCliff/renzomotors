<?php
include('../config/conexion.php'); 
include('../components/navbaruser.php'); 

$query = "SELECT nombre_seguro, descripcion_seguro, precio_seguro FROM seguro";
$resultado = mysqli_query($conexion, $query);
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body{
            background: #E6E6E6;
        }
    </style>
</head>

<body class="pt-5">
    
    <div class="container mt-5">
        <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
            <div class="seguro-item">
                <div class="seguro-info">
                    <!-- Logo del banco (puedes personalizar este aspecto) -->
                    <img src="ruta/al/logo.png" alt="Logo Banco" class="logo-seguro">
                    <div class="seguro-texto">
                        <h3><?php echo $row['nombre_seguro']; ?></h3>
                        <p><?php echo $row['descripcion_seguro']; ?></p>
                    </div>
                </div>
                <div class="seguro-precio">
                    <span><?php echo number_format($row['precio_seguro'], 0, ',', '.'); ?> CLP</span>
                    <button href="./"  class="btn-contratar">Contratar</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>