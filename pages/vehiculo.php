<?php
include('../config/conexion.php'); 
include('../components/navbaruser.php'); 

$id_fina = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Vehiculos</title>

    <!-- Para dar style al pagina y modal -->
    <style>
        body{
            font-family: "Roboto", sans-serif;
        }
        .modal-dialog {
            max-width: 750px;
            margin: 20px auto; 
        }
        label{
            font-size:15px
        }
    </style>

</head>
<body class="pt-5">
    <div class="container-fluid mt-5 ">
        <div class="col">
            <h1>Informacion del vehiculo</h1>
            <!-- Modal de financiamiento -->
            <div class="modal fade" id="exampleModalToggle"  aria-hidden="true" aria-labelledby="exampleModalToggleLabel"tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between align-items-center" style="border-bottom: none;">
                            <h1 class="modal-title fs-5 text-center flex-grow-1" id="exampleModalToggleLabel" style="font-weight: bold; font-size: 24px;">CALCULADORA DE FINANCIAMIENTO</h1>
                            <button type="button" class="btn-close " style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid black;" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <?php
                                    include("financiamiento.php");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">financiamiento</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>