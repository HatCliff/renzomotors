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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
 
        body {
            background-color: #e6e6e6;
        }
        .dropdown-menu { max-height: 200px; overflow-y: auto; }
 

        .banner {
            position: relative;
            background-image: url('src/images/banner1.jpg'); 
            background-size: cover;
            background-position: center;
            border-bottom-left-radius:10px ;
            border-bottom-right-radius:10px ;
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
        .info-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.2s ease;
        }
        .info-card:hover {
            transform: scale(1.05);
        }
        .info-card .icon {
            font-size: 40px;
            color: #f1c40f; 
            margin-bottom: 10px;
        }
        .custom-container {
            background-color: #f8f9fa; 
            border-radius: 10px;
            padding: 40px;
        }
        .sucursales-banner {
            position: relative;
            background-image: url('./src/images/sucursal_banner.jpeg'); 
            background-size: cover;
            background-position: center;
            height: 60vh;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
        }
        .mantenimiento-banner {
            position: relative;
            background-image: url('./src/images/mechanic.jpg'); 
            background-size: cover;
            background-position: center;
            height: 60vh;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
        }

        .sucursales-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px 30px;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
        }

        .sucursales-search-container select,
        .sucursales-search-container button {
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin: 5px 0;
            width: 100%;
        }

        .sucursales-search-container button {
            background-color: #f1c40f;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .sucursales-search-container button:hover {
            background-color: #e1b307;
        }
        .card {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
    .card img {
      height: 200px;
      object-fit: cover;
    }
    .card-link {
      text-decoration: none;
      color: inherit;
    }
    .card-link:hover {
      text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
        color: #007bff; 
    }

    #carouselContent > div:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    .custom-hr {
        border: none;
        height: 1px;
        background: linear-gradient(to right, rgba(0, 0, 0, 0), #6c757d, rgba(0, 0, 0, 0));
        margin: 2rem 0; 
    }
    </style>
</head>
<body class="pt-5 mt-3">
    <div class="banner mb-4">
        <div class="overlay text-center pt-5">
            <h1 class="text-white">ENCUENTRA AHORA TU AUTO IDEAL CON RENZOMOTORS</h1>
            <div class="search-container mt-4 d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                <select id="estado-vehiculo" class="form-select w-100 w-md-auto">
                    <option value="estado">Estado</option>
                </select>
                <select id="tipo-vehiculo" class="form-select w-100 w-md-auto">
                    <option value="">Tipo de auto</option>
                </select>
                <select id="marca" class="form-select w-100 w-md-auto">
                    <option value="">Marca</option>

                </select>
                <select id="modelo" class="form-select w-100 w-md-auto">
                    <option value="">Modelo</option>
                </select>
                <button class="btn btn-warning w-100 w-md-auto" id="buscar">VER AUTOS</button>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 mt-4">
        <h1 class="text-center mb-4 fw-bold">Explora nuestras marcas</h1>
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary me-3" id="prevSlide" style="font-size: 1.5rem; border-radius: 50%; height: 40px; width: 40px;">&#8249;</button>

            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex gap-4" id="carouselContent" style="transition: transform 0.5s ease;">
                    <?php

                    $query = "SELECT id_marca, nombre_marca, logo_marca FROM marca";
                    $result = mysqli_query($conexion, $query);

                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                                <div class='text-center' style='min-width: 120px;'> 
                                    <a href='pages/buscador_vehiculo.php?estado=&tipo=&marca={$row['id_marca']}' style='text-decoration: none; color: inherit;'>
                                        <div class='p-3 border rounded shadow-sm bg-white'>
                                            <img src='admin/mantenedores/marcas/logos/{$row['logo_marca']}' alt='{$row['nombre_marca']}' class='img-fluid rounded' style='height: 60px; object-fit: contain;'>
                                        </div>
                                        <p class='mt-2 mb-0 text-secondary fw-medium small'>{$row['nombre_marca']}</p>
                                    </a>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p class='text-center text-muted'>No hay marcas disponibles.</p>";
                    }
                    ?>
                </div>
            </div>
            <button class="btn btn-outline-secondary ms-3" id="nextSlide" style="font-size: 1.5rem; border-radius: 50%; height: 40px; width: 40px;">&#8250;</button>
        </div>
    </div>

    <div class="custom-hr"></div>



    <div class="container my-5">
        <h1 class="text-center mb-4 fw-bold">Nuestros Servicios</h1>
        <div class="row g-4">

        <!--Accesorios -->
        <div class="col-md-4">
            <a href="pages/accesorios/buscador_accesorio.php" class="card card-link h-100">
            <img src="src/images/accesorios_card.jpeg" class="card-img-top" alt="Accesorios">
            <div class="card-body text-center">
                <h5 class="card-title">🎯 Accesorios para tu auto</h5>
                <p class="card-text">Encuentra los mejores accesorios para personalizar y equipar tu vehículo.</p>
            </div>
            </a>
        </div>

        <!-- Cotizar Seguros -->
        <div class="col-md-4">
            <a href="pages/c_seguro/seguro.php" class="card card-link h-100">
            <img src="src/images/seguros_card.jpg" class="card-img-top" alt="Seguros">
            <div class="card-body text-center">
                <h5 class="card-title">🛡️ Cotiza tu Seguro</h5>
                <p class="card-text">Obtén las mejores opciones de seguros para tu tranquilidad.</p>
            </div>
            </a>
        </div>

        <!-- Arrienda tu Vehículo -->
        <div class="col-md-4">
            <a href="pages/arriendo.php" class="card card-link h-100">
            <img src="src/images/arrendar_card.jpg" class="card-img-top" alt="Arrienda tu Vehículo">
            <div class="card-body text-center">
                <h5 class="card-title">🚗 Arrienda un Vehículo</h5>
                <p class="card-text">¡Arrienda uno de los multiples vehículos que tenemos para tí!</p>
            </div>
            </a>
        </div>

        </div>
    </div>

   <!-- Tarjeta para contratar SOAP -->
    <div class="container my-4">
        <a href="pages/soap/soap.php" class="text-decoration-none">
            <div class="card text-white bg-secondary-subtle shadow-lg" style="border-radius: 12px;">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4">
                        <img src="src/images/seguro_soap_card.jpg" 
                            alt="Contrata el SOAP" 
                            class="img-fluid rounded-start" 
                            style="object-fit: cover; height: 100%; border-top-left-radius: 12px; border-bottom-left-radius: 12px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title text-black fw-bold">Contrata tu SOAP ahora</h2>
                            <p class="card-text text-black mb-4">
                                Protege tu vehículo y cumple con la ley contratando el Seguro Obligatorio de Accidentes Personales (SOAP). 
                                ¡Rápido, fácil y 100% online!
                            </p>
                            <span class="btn btn-light btn-lg fw-bold text-succes">Contratar SOAP</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="container mantenimiento-banner">
        <div class="col-lg-5 mb-4 mb-lg-0 d-flex justify-content-center">
                <h1>¿Problemas con tu auto?</h1>
                <button class="btn mt-3" style="background: linear-gradient(90deg, #0B8347 0%, #008040 52%, #000000 100%); color: #fff;" onclick="window.location.href='pages/sucursales/mantenimientos.php'">
                    Haz tu mantenimiento con nosotros
                </button>
            </div>
        </div>
    </div>

    <div class="custom-hr"></div>

    <h1 class="text-center mb-4 fw-bold">Siempre cerca de tí, encuentra tu Sucursal RenzoMotors</h1>
    <div class="container sucursales-banner">
        
        <div class="sucursales-overlay">
            <h1 class="text-white">Descubre nuestras sucursales</h1>
            <div class="sucursales-search-container d-flex flex-column flex-md-row justify-content-center align-items-center">
                <form action="pages/sucursales/sucursales.php" method="GET">
                    <select name="zona" id="zona" class="form-select">
                        <option value="">Selecciona una región</option>
                        <?php
                        $query = "SELECT DISTINCT zona_sucursal FROM sucursal";
                        $result = mysqli_query($conexion, $query);

                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['zona_sucursal']}'>{$row['zona_sucursal']}</option>";
                            }
                        } else {
                            echo "<option value=''>No hay regiones disponibles</option>";
                        }
                        ?>
                    </select>

                    <select name="sucursal" id="sucursal" class="form-select">
                        <option value="">Selecciona una sucursal</option>
                    </select>

                    <button type="submit" class="btn btn-warning">Ver sucursal</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="custom-container">
            <h2 class="text-center mb-4">Nuestro compromiso, tu confianza</h2>
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">📍</div>
                        <h4>+20</h4>
                        <p>Ciudades</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🏪</div>
                        <h4>+50</h4>
                        <p>Sucursales</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🔧</div>
                        <h4>+30</h4>
                        <p>Talleres</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🏆</div>
                        <h4>+30</h4>
                        <p>Marcas</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🤝</div>
                        <h4>+5.000</h4>
                        <p>Colaboradores</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🚗</div>
                        <h4>+1.000</h4>
                        <p>Vehículos vendidos al mes</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">🚙</div>
                        <h4>+500</h4>
                        <p>Vehículos comprados al mes</p>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-card">
                        <div class="icon">😊</div>
                        <h4>Miles</h4>
                        <p>de clientes felices</p>
                    </div>
                </div>
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
        fetch('get_vehiculos.php?action=getEstados')
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

        fetch(`get_vehiculos.php?action=getTiposVehiculo&estado=${estado}&marca=${marca}&modelo=${modelo}`)
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

        fetch(`get_vehiculos.php?action=getMarcas&estado=${estado}&tipo=${tipo}&modelo=${modelo}`)
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

        fetch(`get_vehiculos.php?action=getModelos&estado=${estado}&tipo=${tipo}&marca=${marca}`)
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
<script>
        document.getElementById('zona').addEventListener('change', function () {
            const zonaSeleccionada = this.value;

            // Limpiar opciones anteriores
            const sucursalSelect = document.getElementById('sucursal');
            sucursalSelect.innerHTML = '<option value="">Selecciona una sucursal</option>';

            if (zonaSeleccionada) {
                // Realizar una solicitud AJAX para obtener las sucursales de la región seleccionada
                fetch(`get_sucursales.php?zona=${zonaSeleccionada}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(sucursal => {
                                const option = document.createElement('option');
                                option.value = sucursal.id_sucursal;
                                option.textContent = sucursal.nombre_sucursal;
                                sucursalSelect.appendChild(option);
                            });
                        } else {
                            sucursalSelect.innerHTML = '<option value="">No hay sucursales disponibles</option>';
                        }
                    });
            }
        });
    </script>
</html>
