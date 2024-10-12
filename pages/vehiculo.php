<?php
include('../config/conexion.php'); // Ajusta la ruta para conexion.php
include('../components/navbar.php'); // Ajusta la ruta para navbar.php
$id_fina = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vehiculos</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Países</h1>
        <div class="modal fade" id="exampleModalToggle"  aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Calculadora de financiamiento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                            include("calcu.php");
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary" data-bs-target="#exampleModalToggle"
            data-bs-toggle="modal">financiamiento</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

