<?php
include './config/conexion.php';


session_start();
if (isset($_SESSION['tipo_persona'])) {
    if ($_SESSION['tipo_persona'] == 'administrador') {
        include './admin/navbaradmin.php';
    } else {
        include './components/navbaruser.php';
    }
}
else{
    include './components/navbaruser.php';
}

// Consulta de sucursales
$query_sucursales = "SELECT id_sucursal, nombre_sucursal FROM sucursal ORDER BY zona_sucursal";
$resultado_sucursales = mysqli_query($conexion, $query_sucursales);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Ajustes generales para una apariencia limpia */

        .dropdown-menu { max-height: 200px; overflow-y: auto; }
        /* Estilos adicionales para hacer la página más adaptable */

        .banner {
            position: relative;
            background-image: url('src/images/banner1.jpg'); /* Coloca aquí la URL de tu imagen */
            background-size: cover;
            background-position: center;
            height: 60vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .search-container {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .search-container select,
        .search-container button {
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body class="pt-5 mt-3">
    <div class="banner">
        <div class="overlay text-center py-5">
            <h1 class="text-white">ENCUENTRA AHORA TU AUTO IDEAL CON RENZOMOTORS</h1>
            <div class="search-container mt-4 d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                <select id="estado-vehiculo" class="form-select w-100 w-md-auto">
                    <option value="estado">Estado</option>
                    <!-- Opciones dinámicas cargadas desde la base de datos -->
                </select>
                <select id="tipo-vehiculo" class="form-select w-100 w-md-auto">
                    <option value="">Tipo de auto</option>
                    <!-- Opciones dinámicas cargadas desde la base de datos -->
                </select>
                <select id="marca" class="form-select w-100 w-md-auto">
                    <option value="">Marca</option>
                    <!-- Opciones dinámicas cargadas desde la base de datos -->
                </select>
                <select id="modelo" class="form-select w-100 w-md-auto">
                    <option value="">Modelo</option>
                    <!-- Opciones dinámicas cargadas desde la base de datos -->
                </select>
                <button class="btn btn-warning w-100 w-md-auto" id="buscar">VER AUTOS</button>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-dark me-3" id="prevSlide" style="font-size: 1.5rem;">&#8249;</button>
            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex gap-3" id="carouselContent" style="transition: transform 0.5s ease;">
                    <?php
                    include 'config/conexion.php'; // Conexión a la base de datos
                    $query = "SELECT id_marca,nombre_marca, logo_marca FROM marca";
                    $result = mysqli_query($conexion, $query);

                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc( $result)) {
                            echo "
                                <div class='text-center' style='min-width: 90px;'> <!-- Reduce el ancho mínimo -->
                                    <a href='pages/buscador_vehiculo.php?estado=&tipo=&marca={$row['id_marca']}' style='text-decoration: none;'>
                                        <div class='p-3 border rounded bg-white'>
                                            <img src='admin/mantenedores/marcas/logos/{$row['logo_marca']}' alt='{$row['nombre_marca']}' class='img-fluid' style='height: 60px;'>
                                        </div>
                                        <p class='mt-2 mb-0 small'>{$row['nombre_marca']}</p>
                                    </a>
                                </div>

                            ";
                        }
                    } else {
                        echo "<p>No hay marcas disponibles.</p>";
                    }
                    ?>
                </div>
            </div>
            <button class="btn btn-link text-dark ms-3" id="nextSlide" style="font-size: 1.5rem;">&#8250;</button>
        </div>
    </div>

    <div class="container mt-5 pt-5">
        <!-- Sección Sucursales -->
        <div class="row">
            <div class="col-lg-3 mb-4">
                <h5>Nuestras Sucursales</h5>
                <div class="list-group">
                    <?php
                    if ($resultado_sucursales->num_rows > 0) {
                        while ($row = $resultado_sucursales->fetch_assoc()) {
                            echo '<label class="list-group-item">';
                            echo "<a href='pages/sucursales/sucursales.php?suc={$row['id_sucursal']}' style='text-decoration: none'>{$row['nombre_sucursal']}</a>";
                            echo '</label>';
                        }
                    } else {
                        echo "No se encontraron sucursales.";
                    }
                    ?>
                </div>
            </div>

            <!-- Sección Novedades de Vehículos -->
            <div class="col-lg-9">
                <div class="row mb-4">
                    <!-- Aquí podrías añadir tarjetas dinámicas o contenido adicional -->
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row align-items-center text-center text-lg-start my-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img class="img-fluid rounded" src="./src/images/mechanic.jpg" alt="Servicio técnico">
            </div>
            <div class="col-lg-6">
                <h1>¿Problemas con tu auto?</h1>
                <button class="btn mt-3" style="background: linear-gradient(90deg, #0B8347 0%, #008040 52%, #000000 100%); color: #fff;">
                    Haz tu mantenimiento con nosotros
                </button>
            </div>
        </div>
    </div>

    <?php include './components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect = document.getElementById('estado-vehiculo');
    const tipoSelect = document.getElementById('tipo-vehiculo');
    const marcaSelect = document.getElementById('marca');
    const modeloSelect = document.getElementById('modelo');
    const buscarBtn = document.getElementById('buscar');

    // Cargar estados (opciones estáticas)
    const cargarEstados = () => {
        fetch('backend.php?action=getEstados')
            .then(res => res.json())
            .then(data => {
                estadoSelect.innerHTML = '<option value="">Estado</option>';
                data.forEach(estado => {
                    estadoSelect.innerHTML += `<option value="${estado.value}">${estado.label}</option>`;
                });
            });
    };

    // Cargar tipos de vehículos dinámicamente
    const cargarTipos = () => {
        const estado = estadoSelect.value;
        const marca = marcaSelect.value;
        const modelo = modeloSelect.value;

        fetch(`backend.php?action=getTiposVehiculo&estado=${estado}&marca=${marca}&modelo=${modelo}`)
            .then(res => res.json())
            .then(data => {
                tipoSelect.innerHTML = '<option value="">Tipo de auto</option>';
                data.forEach(tipo => {
                    tipoSelect.innerHTML += `<option value="${tipo.id_tipo_vehiculo}">${tipo.nombre_tipo_vehiculo}</option>`;
                });
            });
    };

    // Cargar marcas dinámicamente
    const cargarMarcas = () => {
        const estado = estadoSelect.value;
        const tipo = tipoSelect.value;
        const modelo = modeloSelect.value;

        fetch(`backend.php?action=getMarcas&estado=${estado}&tipo=${tipo}&modelo=${modelo}`)
            .then(res => res.json())
            .then(data => {
                marcaSelect.innerHTML = '<option value="">Marca</option>';
                data.forEach(marca => {
                    marcaSelect.innerHTML += `<option value="${marca.id_marca}">${marca.nombre_marca}</option>`;
                });
            });
    };

    // Cargar modelos dinámicamente
    const cargarModelos = () => {
        const estado = estadoSelect.value;
        const tipo = tipoSelect.value;
        const marca = marcaSelect.value;

        fetch(`backend.php?action=getModelos&estado=${estado}&tipo=${tipo}&marca=${marca}`)
            .then(res => res.json())
            .then(data => {
                modeloSelect.innerHTML = '<option value="">Modelo</option>';
                data.forEach(modelo => {
                    modeloSelect.innerHTML += `<option value="${modelo.id_vehiculo}">${modelo.nombre_modelo}</option>`;
                });
            });
    };

    // Actualizar los filtros dinámicamente según el cambio
    estadoSelect.addEventListener('change', () => {
        cargarTipos();
        cargarMarcas();
        cargarModelos();
    });

    tipoSelect.addEventListener('change', () => {
        cargarMarcas();
        cargarModelos();
    });

    marcaSelect.addEventListener('change', () => {
        cargarTipos();
        cargarModelos();
    });

    modeloSelect.addEventListener('change', () => {
        cargarTipos();
        cargarMarcas();
    });

    // Redirigir al presionar "VER AUTOS"
    buscarBtn.addEventListener('click', () => {
        const modelo = modeloSelect.value;
        const estado = estadoSelect.value;
        const tipo = tipoSelect.value;
        const marca = marcaSelect.value;

        if (modelo) {
            window.location.href = `pages/vehiculo.php?id=${modelo}`;
        } else {
            const queryParams = new URLSearchParams({ estado, tipo, marca }).toString();
            window.location.href = `pages/buscador_vehiculo.php?${queryParams}`;
        }
    });

    // Cargar los estados iniciales
    cargarEstados();
});
</script>
<script>
    const carouselContent = document.getElementById('carouselContent');
    const prevSlide = document.getElementById('prevSlide');
    const nextSlide = document.getElementById('nextSlide');

    let scrollPosition = 0;
    const scrollStep = 150; // Ajusta el desplazamiento por clic
    const totalWidth = carouselContent.scrollWidth / 2; // Mitad del contenido duplicado

    nextSlide.addEventListener('click', () => {
        scrollPosition += scrollStep;
        if (scrollPosition >= totalWidth) {
            // Reinicia suavemente al inicio
            scrollPosition = 0;
            carouselContent.style.transition = 'none';
            carouselContent.style.transform = `translateX(0px)`;
            setTimeout(() => {
                carouselContent.style.transition = 'transform 0.5s ease';
                scrollPosition += scrollStep;
                carouselContent.style.transform = `translateX(-${scrollPosition}px)`;
            }, 50);
        } else {
            carouselContent.style.transform = `translateX(-${scrollPosition}px)`;
        }
    });

    prevSlide.addEventListener('click', () => {
        scrollPosition -= scrollStep;
        if (scrollPosition < 0) {
            // Reinicia suavemente al final
            scrollPosition = totalWidth - scrollStep;
            carouselContent.style.transition = 'none';
            carouselContent.style.transform = `translateX(-${totalWidth}px)`;
            setTimeout(() => {
                carouselContent.style.transition = 'transform 0.5s ease';
                carouselContent.style.transform = `translateX(-${scrollPosition}px)`;
            }, 50);
        } else {
            carouselContent.style.transform = `translateX(-${scrollPosition}px)`;
        }
    });
</script>
</html>
