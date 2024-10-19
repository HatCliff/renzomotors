<?php
$carpetaMain = 'http://localhost/xampp/renzomotors/';
$carpetaMantenedores = $carpetaMain . 'admin/mantenedores/'; 
?>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        
        <a class="navbar-brand" href='/'>
            <img src="<?php echo $carpetaMain; ?>logo.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">
            RenzoMotors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>index.php' class="nav-link active" aria-current="page">Inicio</a>
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
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>accesorios/mantenedor_accesorios.php'>Mantenedor de Accesorios</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>anios/mantenedor_anios.php'>Mantenedor de Años</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>colores/mantenedor_colores.php'>Mantenedor de Colores Vehículos</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>financiamiento/mantenedor_financiamientos.php'>Mantenedor de Financiamientos</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>marcas/mantenedor_marcas.php'>Mantenedor de Marcas</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>paises/mantenedor_paises.php'>Mantenedor de Países</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>proveedores/mantenedor_proveedores.php'>Mantenedor de Proveedores de Seguros</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>roles/mantenedor_roles.php'>Mantenedor de Roles</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>ruedas/mantenedor_ruedas.php'>Mantenedor de Ruedas</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>seguros/mantenedor_seguros.php'>Mantenedor de Seguros</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>servicios/mantenedor_servicios.php'>Mantenedor de Servicios</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>sucursales/mantenedor_sucursales.php'>Mantenedor de Sucursales</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>tipo_accesorio/mantenedor_tipo_accesorios.php'>Mantenedor de Tipo de Accesorios</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>tipos_cobertura/mantenedor_tipo_coberturas.php'>Mantenedor de Tipos de Coberturas</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>tipo_combustible/mantenedor_tipo_combustibles.php'>Mantenedor de Tipos de Combustibles</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>tipo_pagos/mantenedor_tipo_pagos.php'>Mantenedor de Tipos de Pago</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>transmision/mantenedor_transmisiones.php'>Mantenedor de Transmisiones</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>tipo_vehiculo/mantenedor_tipo_vehiculos.php'>Mantenedor de Tipo de Vehículos</a></li>
        <li><a class="list-group-item text-bg-dark border-0" href='<?php echo $carpetaMantenedores; ?>vehiculo/mantenedor_vehiculos.php'>Mantenedor de Vehículos</a></li>
    </ul>
    </div>

</div>