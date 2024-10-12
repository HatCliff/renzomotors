<?php
include('../config/conexion.php'); // Ajusta la ruta para conexion.php
include('../components/navbar.php'); // Ajusta la ruta para navbar.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vehiculos</title>
    <style>
        body{
            background: #E6E6E6;
        }
        
    </style>
</head>

<body class="pt-5">
    
    <div class="container mt-5 d-flex">
        
        <div class="row mb-4  ">
                <div class="row mb-4">
                    <h1 class="mb-4">Vehiculos</h1>
                    <div class="col-6 d-flex align-items-center">
                        <input class="form-control" type="text" placeholder="Modelo del vehiculo" aria-label="Disabled input example" disabled>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-2 col-6">
                        <button type="button" class="btn btn-light me-2">Usado</button>
                        <button type="button" class="btn btn-light me-2">Transmision</button>
                        <button type="button" class="btn btn-light me-2">Combustible</button>
                        <button type="button" class="btn btn-light me-2">Marca</button>
                        <button type="button" class="btn btn-light me-2">Año</button>
                        <button type="button" class="btn btn-light">Ordenado por</button>
                    </div>
                </div>
                <div class="row">
                        <?php
                        // Consulta para obtener todos los datos del mantendeor 
                        $resultado = mysqli_query($conexion, "SELECT v.*, m.nombre_marca, a.anio, t.nombre_tipo_vehiculo, tr.nombre_transmision, c.nombre_tipo_combustible, p.nombre_pais
                                                                FROM vehiculos v
                                                                JOIN marcas m ON v.id_marca = m.id_marca
                                                                JOIN anios a ON v.id_anio = a.id_anio
                                                                JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
                                                                JOIN transmisiones tr ON v.id_transmision = tr.id_transmision
                                                                JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                                                                JOIN paises p ON v.id_pais = p.id_pais");

                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo"<div class='col-md-4 d-flex justify-content-center mb-4'>";
                                echo "<a href='vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none'>";
                                    echo"<div class='card' style='width: 400px; background: #fffcf4; border-radius: 20px;'> ";
                                        // Mostrar todas las fotos asociadas al mantenedor
                                        $id_vehiculo = $fila['id_vehiculo'];
                                        $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculos WHERE id_vehiculo = $id_vehiculo");

                                        if ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                                            $ruta_imagen = '../admin/mantenedores/vehiculo/fotos_vehiculos/' . basename($foto['ruta_foto']);
                                            echo "<img src='$ruta_imagen' class='card-img-top ' alt='Foto vehículo' style='width: 100%; height: 300px; border-radius: 20px 20px 0 0'>";
                                            echo"
                                            <div class='card-img-overlay d-flex justify-content-start align-items-start p-3 text-center'>
                                                <h6 class='card-title border p-2' style='width: 90px; border-radius: 80px; border: 3px solid black; font-size:1rem; background: white;'>{$fila['estado']}</h6>
                                            </div>";
                                        }
                                        echo "<div class='card-body m-4' >";
                                        $precio_formateado = number_format($fila['precio'], 0, ',', '.'); 
                                        echo "<h5 class='card-title' style='font-weight: bold'>{$fila['nombre_modelo']}</h5>
                                            <p class='card-text' style='color:426B1F; font-weight: bold; '>\$ " . $precio_formateado . " CLP  -  {$fila['anio']}</p>";
                                        echo"</div>";
                                    echo"</div>";
                                echo "</a>";
                            echo"</div>";
                        }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

