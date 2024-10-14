<?php
$carpetaMain = 'http://localhost/xampp/renzomotors/';
?>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        
        <a class="navbar-brand" href='/'>
            <img src="<?php echo $carpetaMain; ?>/logo.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">
            RenzoMotors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>/index.php' class="nav-link active" aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasMantenedores" role="button" aria-controls="offcanvasMantenedores">
                    ⌵ Mantenedores
                    </a>
                </li>
                <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Buscador
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href='<?php echo $carpetaMain;?>pages/buscador_vehiculo.php'>Vehiculo</a></li>
                <li><a class="dropdown-item" href="#">Accesorios</a></li>
            </ul>
            </li>
            </ul>
        </div>
    </div>
</nav>

<!--  Mantenedores -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasMantenedores" aria-labelledby="offcanvasMantenedoresLabel" style="top: 56px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMantenedoresLabel">Mantenedores</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/vehiculo/mantenedor_vehiculos.php'>Mantenedor de Vehículos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/marcas/mantenedor_marcas.php'>Mantenedor de Marcas</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/paises/mantenedor_paises.php'>Mantenedor de Paises</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/anios/mantenedor_anios.php'>Mantenedor de Años</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/transmision/mantenedor_transmisiones.php'>Mantenedor de Transmisiones</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/tipo_vehiculo/mantenedor_tipo_vehiculos.php'>Mantenedor de Tipo de Vehiculos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/tipo_combustible/mantenedor_tipo_combustibles.php'>Mantenedor de Tipo de Combustibles</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/colores/mantenedor_colores.php'>Mantenedor de Colores Vehiculos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/sucursales/mantenedor_sucursales.php'>Mantenedor de Sucursales</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/servicios/mantenedor_servicios.php'>Mantenedor de Servicios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/accesorios/mantenedor_accesorios.php'>Mantenedor de Accesorios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/tipo_accesorio/mantenedor_tipo_accesorios.php'>Mantenedor de Tipo de Accesorios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/seguros/mantenedor_seguros.php'>Mantenedor de Seguros</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/proveedores/mantenedor_proveedores.php'>Mantenedor de Proveedores de Seguros</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/tipos_cobertura/mantenedor_tipo_coberturas.php'>Mantenedor de Tipos de Coberturas</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/tipo_pagos/mantenedor_tipo_pagos.php'>Mantenedor de Tipos de Pago</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/financiamiento/mantenedor_financiamientos.php'>Mantenedor de Financiamientos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/roles/mantenedor_roles.php'>Mantenedor de Roles</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMain; ?>/permisos/mantenedor_permisos.php'>Mantenedor de Permisos</a></li>
        </ul>
    </div>
</div>
