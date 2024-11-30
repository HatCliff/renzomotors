<?php
session_start();
include('../../config/conexion.php');

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../../components/navbaruser.php';
}
$rut = $_SESSION['rut'];


$query = "SELECT v.*, m.nombre_marca, a.anio, p.nombre_pais
          FROM vehiculo v
          JOIN marca m ON v.id_marca = m.id_marca
          JOIN anio a ON v.id_anio = a.id_anio
          JOIN pais p ON v.id_pais = p.id_pais
          JOIN vehiculo_favorito f ON v.id_vehiculo = f.id_vehiculo 
          WHERE f.rut = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $rut);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Vehículos Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #e6e6e6;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 22px;
            color: #d3d3d3;
            font-size: 24px;
            cursor: pointer;
            z-index: 999;
        }
        .favorite-checked {
            color: gold;
        }
        .favorite-unchecked {
            color: #d3d3d3;
        }
        .alert-session {
            display: none; 
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050; 
        }
        .card { background: #fffcf4; border-radius: 20px; overflow: hidden; transition: transform 0.3s ease; }
        .card:hover { transform: scale(1.05); }

        .accordion-button {
            background-color: #5c636a; 
            color: white;    
        }
        .no-style {
            list-style-type: none;
            padding-left: 0;  
        }
        .no-style .accordion-item {
            border-radius: 5px;      
            margin-bottom: 5px;       
            padding: 5px;             
            background-color: #f9f9f9; 
        }
        .accordion-button:not(.collapsed) {
            background-color: #426b42; 
            color: white;
        }
    </style>
    
</head>
<script>
    // Función para convertir los parámetros del formulario a una cadena de consulta (query string)
    function getQueryString() {
        const form = document.getElementById('filtroForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        return params.toString();  // Devuelve la cadena de parámetros 
    }

    // Llamada a history.replaceState solo si el formulario ha sido enviado
    window.addEventListener('load', function() {
        // Reemplazar la URL con los parámetros del filtro, pero sin recargar la página
        const queryString = getQueryString();
        if (queryString) {
            // Actualizar la URL sin recargar la página
            history.replaceState(null, '', '?' + queryString);
        }
    });
</script>
<body class="mt-5 pt-5">
<div class="container mt-5">
    <h1>Mis Vehículos Favoritos</h1>
    <div class="row">
    <?php
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $id_vehiculo = $fila['id_vehiculo'];
                        $isFavorito = false;
                        if (isset($_SESSION['rut'])) {
                            $id_usuario = $_SESSION['rut'];
                            $favorito_query = "SELECT * FROM vehiculo_favorito WHERE rut = '$id_usuario' AND id_vehiculo = $id_vehiculo";
                            $favorito_result = mysqli_query($conexion, $favorito_query);
                            $isFavorito = mysqli_num_rows($favorito_result) > 0;
                        }
                        echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch position-relative'>";

                        // Icono de favorito en la esquina superior derecha
                        echo "<div class='favorite-icon' id='icono-favorito-$id_vehiculo'>";
                        echo "<i class='fas fa-star " . ($isFavorito ? 'favorite-checked' : 'favorite-unchecked') . "' onclick='toggleFavorito(event, $id_vehiculo);'></i>";
                        echo "</div>";


                        // Contenido de la tarjeta
                        echo "<a href='vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none w-100'>";
                        echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>";

                        // Carrusel de fotos del vehículo
                        $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
                        echo "<div id='carousel{$id_vehiculo}' class='carousel slide' data-bs-ride='carousel'>";
                        echo "<div class='carousel-inner'>";
                        $active = "active";
                        while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                            $ruta_imagen = '../../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
                            echo "<div class='carousel-item $active'>";
                            echo "<div style='background-image: url($ruta_imagen); background-size: cover; background-position: center; height: 180px; border-radius: 15px 15px 0 0;'></div>";
                            echo "</div>";
                            $active = "";
                        }
                        echo "</div>";
                        echo "<button class='carousel-control-prev' type='button' data-bs-target='#carousel{$id_vehiculo}' data-bs-slide='prev'>
                                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                <span class='visually-hidden'>Previous</span>
                            </button>";
                        echo "<button class='carousel-control-next' type='button' data-bs-target='#carousel{$id_vehiculo}' data-bs-slide='next'>
                                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                <span class='visually-hidden'>Next</span>
                            </button>";
                        echo "</div>";

                        // Estado del vehículo (Nuevo o Usado)
                        echo "<div class='position-absolute p-2' style='top: 10px; left: 10px;'>
                                <span class='badge bg-light text-dark border' style='border-radius: 20px; padding: 5px 10px;'>{$fila['estado_vehiculo']}</span>
                            </div>";

                        // Información del vehículo
                        echo "<div class='card-body mt-1 text-center py-2'>";
                        $precio_formateado = number_format($fila['precio_modelo'], 0, ',', '.');
                        echo "<h5 class='card-title text-dark fw-bold mb-2'>{$fila['nombre_modelo']}</h5>";
                        echo "<p class='text-success fw-bold mb-2'>$ {$precio_formateado} CLP - {$fila['anio']}</p>";
                        echo "<p class='text-muted mb-2'>{$fila['nombre_pais']} </p>";
                        echo "</div>";

                        // Colores del vehículo en la parte inferior
                        $colores_resultado = mysqli_query($conexion, "SELECT c.codigo_color 
                                                                    FROM color_vehiculo vc
                                                                    JOIN color c ON vc.id_color = c.id_color
                                                                    WHERE vc.id_vehiculo = $id_vehiculo");
                        echo "<div class='d-flex justify-content-center align-items-center mb-2'>";
                        while ($color = mysqli_fetch_assoc($colores_resultado)) {
                            $codigo_color = htmlspecialchars($color['codigo_color']);
                            echo "<span style='background-color: $codigo_color; width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin: 0 5px;'></span>";
                        }
                        echo "</div>";

                        echo "</div>"; // Cierre de div.card
                        echo "</a>";   // Cierre de enlace
                        echo "</div>"; // Cierre de columna
                    }
                    ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
<script>
    function actualizar_fav(id_vehiculo, icono) {
        // Llama a verificar_favorito.php y actualiza el ícono directamente en el elemento pasado
        $.get('verificar_favorito.php', { id_vehiculo: id_vehiculo }, function (mensaje, estado) {
            // Verifica si el mensaje contiene "favorite-checked" para decidir el color y clase
            const isFavorito = mensaje.includes('favorite-checked');
            icono.classList.toggle('favorite-checked', isFavorito);
            icono.classList.toggle('favorite-unchecked', !isFavorito);
            icono.style.color = isFavorito ? '#FFD700' : '#CCCCCC';
        });
    }

    function toggleFavorito(event, id_vehiculo) {
        event.stopPropagation();

        <?php if (!isset($_SESSION['rut'])) : ?>
            let alert = document.getElementById('alertSession');
            alert.style.display = 'block';
            setTimeout(function () {
                alert.style.display = 'none';
            }, 3000);
            return;
        <?php endif; ?>

        var icono = event.target;
        var isFavorito = icono.classList.contains('favorite-checked');

        // AJAX para alternar el favorito
        const datos = { id_vehiculo: id_vehiculo, action: isFavorito ? 'remove' : 'add' };
        console.log("Datos enviados:", datos); // Esto imprimirá los datos en la consola del navegador

        $.post('toggle_favorito.php', datos, function (response) {
            console.log("Respuesta del servidor:", response); // Imprime la respuesta recibida
            if (response.success) {
                actualizar_fav(id_vehiculo, icono);
            } else {
                alert('Hubo un error al actualizar el favorito: ' + (response.error || ''));
            }
        }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", {
                textStatus: textStatus,
                errorThrown: errorThrown,
                responseText: jqXHR.responseText, // Verifica el contenido del error
            });
            alert("Error en la solicitud AJAX: " + textStatus + " - " + errorThrown);
        });
    }
</script>
</html>
