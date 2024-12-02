<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php');


$query = "SELECT s.id_seguro, s.nombre_seguro, s.descripcion_seguro, s.precio_seguro, proveedor.imagen_proveedor 
          FROM seguro s
          JOIN proveedor ON s.id_proveedor = proveedor.id_proveedor";
$resultado = mysqli_query($conexion, $query);

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal
    include '../../components/navbaruser.php';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E6E6E6;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .banner {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                            url('../../src/images/seguros-banner.jpg'); 
            background-size: cover;
            background-position: center 85%;
            height: 25vh; 
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .banner h1 {
            font-size: 2rem; 
            margin: 0;
        }

        .banner h2 {
            font-size: 1rem; 
            font-weight: 300;
            margin: 0;
        }
    </style>
</head>

<body class="mt-5 pt-5">
    <div class="container banner">
        <h1 class="text-white">Protege tu Auto con los mejores seguros del mercado</h1>
        <h2>Encuentra el seguro perfecto para tu tranquilidad y la de tu vehículo.</h2>
    </div>    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card text-center shadow-sm rounded" style="background: #fffcf4;">
                        <!-- Mostrar el logo del proveedor -->
                        <img src="../../admin/mantenedores/proveedores/<?php echo $row['imagen_proveedor']; ?>"
                            alt="Logo de <?php echo $row['nombre_seguro']; ?>" class="card-img-top mt-3"
                            style="max-height: 50px; object-fit: contain;">

                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold mb-2"><?php echo $row['nombre_seguro']; ?></h5>
                            <p class="card-text text-muted" style="text-align: justify;"><?php echo $row['descripcion_seguro']; ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="color:#3c4043;">Desde
                                <?php echo number_format($row['precio_seguro'], 0, ',', '.'); ?> CLP</span>
                            <a href="contratacion_seguro.php?id_seguro=<?php echo $row['id_seguro']; ?>"
                                class="btn btn-warning">Cotizar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>