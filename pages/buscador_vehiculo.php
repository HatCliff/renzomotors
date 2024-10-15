<?php
include('../config/conexion.php'); 
include('../components/navbaruser.php'); 

$query = "SELECT v.*, m.nombre_marca, a.anio, p.nombre_pais
            FROM vehiculo v
            JOIN marca m ON v.id_marca = m.id_marca
            JOIN anio a ON v.id_anio = a.id_anio
            JOIN pais p ON v.id_pais = p.id_pais
            WHERE 1=1";

$resultado = mysqli_query($conexion, $query);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Limpiar'])) {
        $query = "SELECT v.*, m.nombre AS marca FROM vehiculos v JOIN marcas m ON v.id_marca = m.id_marca";
       
    } else {
        $nombre_modelo =  $_POST['modelo'] ?? '';
        $estado = $_POST['estado'] ?? [];
        $orden = $_POST['orden']?? '';
        $id_marcas = $_POST['id_marcas'] ?? [];
        $id_anios = $_POST['id_anios'] ?? [];
        $id_combustible = $_POST['id_combustible'] ?? [];
        $id_transmision = $_POST['id_transmision'] ?? [];
        
        if (!empty($id_marcas)) {
            $marcas_list = implode(',', array_map('intval', $id_marcas)); // Sanitizar
            $query .= " AND v.id_marca IN ($marcas_list)";
        }

        if (!empty($estado)) {
            $estado_list = implode(',', array_map('intval', $estado)); // Sanitizar
            $query .= " AND v.estado IN ($estado_list)";
        }

        if (!empty($id_anios)) {
            $anios_list = implode(',', array_map('intval', $id_anios)); // Sanitizar
            $query .= " AND v.id_anio IN ($anios_list)";
        }

        if (!empty($id_combustibles)) {
            $combustibles_list = implode(',', array_map('intval', $id_combustibles)); // Sanitizar
            $query .= " AND v.id_tipo_combustible IN ($combustibles_list)";
        }

        if (!empty($id_transmision)) {
            $transmision_list = implode(',', array_map('intval', $id_transmision)); // Sanitizar
            $query .= " AND v.id_transmision IN ($transmision_list)";
        }

        if ($orden == 'mayor_a_menor') {
            $query .= " ORDER BY precio DESC";
        } elseif ($orden == 'menor_a_mayor') {
            $query .= " ORDER BY precio ASC";
        }

        if(!empty($nombre_modelo)){
            $query .= " AND v.nombre_modelo LIKE '%$nombre_modelo%'";
        }
        
        $resultado = mysqli_query($conexion, $query);
        // Comprobar si no hay resultados
        if (mysqli_num_rows($resultado) == 0) {
            echo "<script>alert('No se encontraron resultados.');</script>";
        }
   
    }

}
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vehiculos</title>
    <!-- Dar color al fondo de la pagina -->
    <style>
        body{
            background: #E6E6E6;
        }
    </style>
</head>
<body class="pt-5">
    <div class="container mt-5 d-flex">
        <div class="row mb-4  ">
            <!-- buscador y filtros -->
            <div class="row mb-4">
                <h1 class="mb-4">Vehiculos</h1>
                <form method="POST" enctype="multipart/form-data" >
                    <div class="d-flex align-items-center">
                        <div class="col-5 me-5 ">
                            <input class="form-control" type="text" name="modelo" placeholder="Modelo del vehículo" aria-label="Modelo del vehículo">
                        </div>
                            
                        <div class="col-7 d-flex align-items-center">
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="estadoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="estadoDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="nuevo"> Nuevo
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="usado"> Usado
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="ordenDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ordenar por
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="ordenDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="mayor_a_menor"> Precio de mayor a menor
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="menor_a_mayor"> Precio de menor a mayor
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="financiamientoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Marca
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        // Consulta a la base de datos los tipos de financiamiento y sus datos
                                        $consulta = mysqli_query($conexion, "SELECT * FROM marca");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_marcas[]' value='{$row['id_marca']}' >";
                                            echo "{$row['nombre_marca']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="financiamientoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    año
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        // Consulta a la base de datos los tipos de financiamiento y sus datos
                                        $consulta = mysqli_query($conexion, "SELECT * FROM anio");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_anios[]' value='{$row['id_anio']}' >";
                                            echo "{$row['anio']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="financiamientoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    combustible
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        // Consulta a la base de datos los tipos de financiamiento y sus datos
                                        $consulta = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_anios[]' value='{$row['id_tipo_combustible']}' >";
                                            echo "{$row['nombre_tipo_combustible']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="financiamientoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    transmision
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        // Consulta a la base de datos los tipos de financiamiento y sus datos
                                        $consulta = mysqli_query($conexion, "SELECT * FROM transmision");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_anios[]' value='{$row['id_transmision']}' >";
                                            echo "{$row['nombre_transmision']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-4" >Aplicar Filtros</button>
                    
                    <button type="submit" name="Limpiar" id="Limpiar"class="btn btn-success mt-4" onclick="location.reload();" >Limpiar Filtros</button>
                                
                </form>
            </div>
        
            <!-- Muestra todos los vehiculos -->
            <div class="row">
                <?php
                    // Consulta para obtener todos vehiculos existentes
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        // Coloca cada vehiculo en tarjetas
                        echo"<div class='col-md-4 d-flex justify-content-center mb-4'>";
                            echo "<a href='vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none'>";
                                echo"<div class='card' style='width: 400px; background: #fffcf4; border-radius: 20px;'> ";
                                    // saca una foto asociada al vehiculo
                                    $id_vehiculo = $fila['id_vehiculo'];
                                    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");

                                    if ($foto = mysqli_fetch_assoc($fotos_resultado)){
                                        $ruta_imagen = '../admin/mantenedores/vehiculo/fotos_vehiculos/' . basename($foto['ruta_foto']);
                                        echo "<img src='$ruta_imagen' class='card-img-top ' alt='Foto vehículo' style='width: 100%; height: 300px; border-radius: 20px 20px 0 0'>";

                                        echo"
                                            <div class='card-img-overlay d-flex justify-content-start align-items-start p-3 text-center'>
                                                <h6 class='card-title border p-2' style='width: 90px; border-radius: 80px; border: 3px solid black; font-size:1rem; background: white;'>{$fila['estado_vehiculo']}</h6>
                                            </div>";
                                        $colores_resultado = mysqli_query($conexion, "SELECT c.codigo_color 
                                            FROM color_vehiculo vc
                                            JOIN color c ON vc.id_color = c.id_color
                                            WHERE vc.id_vehiculo = $id_vehiculo");
                                        while ($color = mysqli_fetch_assoc($colores_resultado)) {
                                            while ($color = mysqli_fetch_assoc($colores_resultado)) {
                                                $codigo_color = htmlspecialchars($color['codigo_color']); 
                                                echo "
                                                <div class='card-img-overlay d-flex align-self-center justify-content-end mt-5 text-center'>
                                                    <h6 class='card-title border p-2' style='width: 90px; border-radius: 80px; border: 3px solid black; font-size:1rem; background: $codigo_color;'>Color</h6>
                                                </div>";
                                            }
                                        }
                                        
                                    }

                                    echo "<div class='card-body m-4' >";
                                    $precio_formateado = number_format($fila['precio_modelo'], 0, ',', '.'); 
                                    echo "<h4 class='card-title' style='font-weight: bold'>{$fila['nombre_modelo']}</h4>
                                            <p class='card-text' style='color:426B1F; font-weight: bold; '>\$ " . $precio_formateado . " CLP  -  {$fila['anio']}</p>";
                                    echo"<p class='card-text' style='color: #6D6D6D; font-weight: bold;'>{$fila['nombre_pais']}</p>";
                                    echo"</div>";
                                echo"</div>";
                            echo "</a>";
                        echo"</div>";
                    }
                ?>
            </div>    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>