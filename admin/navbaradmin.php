<?php
$carpetaMain = 'http://localhost/xampp/renzomotors/';
$carpetaMantenedores = $carpetaMain . 'admin/mantenedores/';
?>

<style>
    *{
        font-family: "Montserrat", serif;
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


<!-- NAV -->
<nav class="navbar navbar-expand-lg  navbar-dark bg-black fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand" href='<?php echo $carpetaMain; ?>index.php'>
            <img src="<?php echo $carpetaMain; ?>logo_tr.png" alt="Logo"
                style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">
            RenzoMotors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <?php
                $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                if (strpos($url, '/admin/mantenedores/') !== false || strpos($url, '/gestion/mantenedores.php') !== false) {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasMantenedores" role="button"
                                aria-controls="offcanvasMantenedores">
                                ⌵ Mantenedores
                            </a>
                        </li>
                        ';
                }
                if (strpos($url, '/solicitudes/') !== false) {
                    echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Solicitudes
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="centro_ayuda.php">Centro de Ayuda</a></li>
                                <li><a class="dropdown-item" href="solicitudes_autos.php">Solicitudes Venta</a></li>
                            </ul>
                        </li>
                        ';
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Buscador
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/buscador_vehiculo.php'>Vehiculo</a></li>
                        <li><a class="dropdown-item" href='<?php echo $carpetaMain; ?>pages/accesorios/buscador_accesorio.php'>Accesorios</a></li>
                    </ul>
                </li>
            </ul>
            <?php
            if ($_SERVER['REQUEST_URI'] !== '/xampp/renzomotors/admin/gestion/dashboard.php') {
                echo '<ul class="navbar-nav">  
                <a href="/xampp/renzomotors/admin/gestion/dashboard.php" class="btn btn-success">Dashboard</a>
                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> Perfil
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/perfil.php">Ver Perfil</a></li>
                                    <li><a class="dropdown-item" href="' . $carpetaMain . 'auth/logout.php">Cerrar Sesión</a></li>
                                </ul>
                </li>
            </ul>
            ';
            }
            else{
                echo '<ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Perfil
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/perfil.php">Ver Perfil</a></li>
                        <li><a class="dropdown-item" href="' . $carpetaMain . 'auth/logout.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
                ';
            }
            ?>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start text-bg-dark " tabindex="-1" id="offcanvasMantenedores"
    aria-labelledby="offcanvasMantenedoresLabel" style="top: 56px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-center" id="offcanvasMantenedoresLabel" style="color:white;">Mantenedores</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <div class="accordion" id="AcordeonVehiculos">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            🚗 Vehículos
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>anios/mantenedor_anios.php'>Años</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>marcas/mantenedor_marcas.php'>Marcas</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>colores/mantenedor_colores.php'>Colores
                                        Vehículos</a></li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>paises/mantenedor_paises.php'>Países</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>promociones/mantenedor_promociones.php'>Promociones</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>ruedas/mantenedor_ruedas.php'>Ruedas</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>tipo_combustible/mantenedor_tipo_combustibles.php'>Tipos
                                        de Combustibles</a></li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>transmision/mantenedor_transmisiones.php'>Transmisiones</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>tipo_vehiculo/mantenedor_tipo_vehiculos.php'>Tipo
                                        de Vehículos</a></li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>vehiculo/mantenedor_vehiculos.php'>Vehículos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            🛠️ Accesorios
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>accesorios/mantenedor_accesorios.php'>Accesorios</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>tipo_accesorio/mantenedor_tipo_accesorios.php'>Tipo
                                        de Accesorios</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            💳 Seguros y Financiamientos
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>financiamiento/mantenedor_financiamientos.php'>Financiamientos</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>proveedores/mantenedor_proveedores.php'>Proveedores
                                        de Seguros</a></li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>seguros/mantenedor_seguros.php'>Seguros</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>tipos_cobertura/mantenedor_tipo_coberturas.php'>Tipos
                                        de Coberturas</a></li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>tipo_pagos/mantenedor_tipo_pagos.php'>Tipos
                                        de Pago</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button  collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            🏢 Sucursales y Personal
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>permisos/mantenedor_permisos.php'>Permisos</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>roles/mantenedor_roles.php'>Roles</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>servicios/mantenedor_servicios.php'>Servicios</a>
                                </li>
                                <li><a class="list-group-item border-0"
                                        href='<?php echo $carpetaMantenedores; ?>sucursales/mantenedor_sucursales.php'>Sucursales</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </ul>
    </div>

</div>