<?php
session_start();
include('../config/conexion.php');


$query = "SELECT nombre_seguro, descripcion_seguro, precio_seguro FROM seguro";
$resultado = mysqli_query($conexion, $query);

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}

?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E6E6E6;
        }

        .card{
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-custom{
            background-color: #747871;

        }
        
    </style>
</head>

<body class="mt-5 pt-5">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                <div class="col-md-4 mb-4" >
                    <div class="card text-center">
                        <img src="https://plazamaule.cl/wp-content/uploads/2023/06/banco-chile.png"
                            class="card-img-top mx-auto mt-3" alt="Logo Banco" style="width: 50%; height: auto;">
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold mb-2 "><?php echo $row['nombre_seguro']; ?></h5>
                            <p class="card-text"><?php echo $row['descripcion_seguro']; ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <span class="text-success"><?php echo number_format($row['precio_seguro'], 0, ',', '.'); ?>
                                CLP</span>
                            <a href="../pages/contratacion_seguro.php" class="btn btn-custom">Contratar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>