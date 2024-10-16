<?php
$_ENV = parse_ini_file(__DIR__ . "/../.env");
if (isset($_SERVER['REQUEST_URI'])) {
    $currentUrl = $_SERVER['REQUEST_URI'];
    if (strpos($currentUrl, $_ENV["PREFIX"] . "/pages/dashboard.php") == false) {
?>
<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        
        <a class="navbar-brand" href='/'>
            <img src="/<?php echo $ENV["PREFIX"]; ?>/logo.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">
            RenzoMotors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/index.php' class="nav-link active" aria-current="page">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasMantenedores" role="button" aria-controls="offcanvasMantenedores">
                    ⌵    Mantenedores
                    </a>
                </li>
                <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Buscador
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href='/<?php echo $ENV["PREFIX"];?>pages/buscador_vehiculo.php'>Vehiculo</a></li>
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
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/vehiculo/mantenedor_vehiculos.php'>Mantenedor de Vehículos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/marcas/mantenedor_marcas.php'>Mantenedor de Marcas</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/paises/mantenedor_paises.php'>Mantenedor de Paises</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/anios/mantenedor_anios.php'>Mantenedor de Años</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/transmision/mantenedor_transmisiones.php'>Mantenedor de Transmisiones</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/tipo_vehiculo/mantenedor_tipo_vehiculos.php'>Mantenedor de Tipo de Vehiculos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/tipo_combustible/mantenedor_tipo_combustibles.php'>Mantenedor de Tipo de Combustibles</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/colores/mantenedor_colores.php'>Mantenedor de Colores Vehiculos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/sucursales/mantenedor_sucursales.php'>Mantenedor de Sucursales</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/servicios/mantenedor_servicios.php'>Mantenedor de Servicios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/accesorios/mantenedor_accesorios.php'>Mantenedor de Accesorios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/tipo_accesorio/mantenedor_tipo_accesorios.php'>Mantenedor de Tipo de Accesorios</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/seguros/mantenedor_seguros.php'>Mantenedor de Seguros</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/proveedores/mantenedor_proveedores.php'>Mantenedor de Proveedores de Seguros</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/tipos_cobertura/mantenedor_tipo_coberturas.php'>Mantenedor de Tipos de Coberturas</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/tipo_pagos/mantenedor_tipo_pagos.php'>Mantenedor de Tipos de Pago</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/financiamiento/mantenedor_financiamientos.php'>Mantenedor de Financiamientos</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/roles/mantenedor_roles.php'>Mantenedor de Roles</a></li>
            <li><a class="list-group-item text-bg-dark border-0" href='/<?php echo $ENV["PREFIX"]; ?>/admin/mantenedores/permisos/mantenedor_permisos.php'>Mantenedor de Permisos</a></li>
        </ul>
    </div>
</div>
<?php
    }
    else {
?>
<nav
    class="navbar navbar-expand-sm navbar-dark bg-dark"
>
    <div class="container">
        <a class="navbar-brand" href='/'>
            <!----<img src="/<?php echo $ENV["PREFIX"]; ?>/logo.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">-->
            RenzoMotors
        </a>
        <button
            class="navbar-toggler d-lg-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId"
            aria-controls="collapsibleNavId"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#" aria-current="page"
                        >Home
                        <span class="visually-hidden">(current)</span></a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="dropdownId"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Dropdown</a
                    >
                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownId"
                    >
                        <a class="dropdown-item" href="#"
                            >Action 1</a
                        >
                        <a class="dropdown-item" href="#"
                            >Action 2</a
                        >
                    </div>
                </li>
            </ul>
            <form class="d-flex my-2 my-lg-0">
                <input
                    class="form-control me-sm-2"
                    type="text"
                    placeholder="Search"
                />
                <button
                    class="btn btn-outline-success my-2 my-sm-0"
                    type="submit"
                >
                    Search
                </button>
            </form>
        </div>
    </div>
</nav>

<?php
    }
}
?>
