<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../../config/conexion.php");
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['tipo_persona'] === 'administrador') {

        $rut_user = $_SESSION['rut'];
        $permisos = "SELECT p.* FROM permiso p
                                 JOIN rol_permiso rp ON rp.id_permiso = p.id_permiso
                                 JOIN rol r ON r.id_rol = rp.id_rol
                                 JOIN administrador a ON a.id_rol = r.id_rol
                                 WHERE a.rut_administrador = '$rut_user'";
        $result_permisos = $conexion->query($permisos);
        $lista_permisos = [];
        while ($permiso = $result_permisos->fetch_assoc()) {
            $lista_permisos[] = $permiso['nombre_permiso'];
            // echo "{$permiso['nombre_permiso']}";
        }

        if (in_array('Mantenedores', $lista_permisos)) {
            include("../navbaradmin.php");
        } else {
            header('Location: dashboard.php');
        }
    } else {
        header('Location: ../../index.php');
    }
} else {
    header('Location: ../../pages/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedores</title>
    <style>
        .accordion-item {
            background-color: #000000;
            color: #ffffff;
            border: 1px solid #444444;
        }

        .accordion-button {
            background-color: #333333;
            color: #ffffff;
            border: none;
        }

        .accordion-button:not(.collapsed) {
            background-color: #555555;
            color: #ffffff;
            box-shadow: inset 0 -1px 5px rgba(0, 0, 0, 0.3);
        }

        .accordion-button:hover {
            background-color: #444444;
            color: #dddddd;
        }

        .accordion-body {
            background-color: #222222;
            color: #ffffff;
        }
    </style>
</head>

<body class="container pt-5 mt-3">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="text-center mb-4">Sección de Mantenedores</h1>
            <div class="accordion" id="AcordeonVehiculos">

                <!-- Acordeón Vehículos -->
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
                                <li><a class="list-group-item"
                                        href='../mantenedores/anios/mantenedor_anios.php'>Años</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/marcas/mantenedor_marcas.php'>Marcas</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/colores/mantenedor_colores.php'>Colores Vehículos</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/paises/mantenedor_paises.php'>Países</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/promociones/mantenedor_promociones.php'>Promociones</a>
                                </li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/ruedas/mantenedor_ruedas.php'>Ruedas</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/tipo_combustible/mantenedor_tipo_combustibles.php'>Tipos
                                        de Combustibles</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/transmision/mantenedor_transmisiones.php'>Transmisiones</a>
                                </li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/tipo_vehiculo/mantenedor_tipo_vehiculos.php'>Tipo de
                                        Vehículos</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/vehiculo/mantenedor_vehiculos.php'>Vehículos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Acordeón Accesorios -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            🛠️ Accesorios
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item"
                                        href='../mantenedores/accesorios/mantenedor_accesorios.php'>Accesorios</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/tipo_accesorio/mantenedor_tipo_accesorios.php'>Tipo de
                                        Accesorios</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Acordeón Seguros -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            💳 Seguros y Financiamientos
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item"
                                        href='../mantenedores/financiamiento/mantenedor_financiamientos.php'>Financiamientos</a>
                                </li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/proveedores/mantenedor_proveedores.php'>Proveedores de
                                        Seguros</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/seguros/mantenedor_seguros.php'>Seguros</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/tipos_cobertura/mantenedor_tipo_coberturas.php'>Tipos de
                                        Coberturas</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/tipo_pagos/mantenedor_tipo_pagos.php'>Tipos de Pago</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Acordeón Sucursales -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            🏢 Sucursales y Personal
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#AcordeonVehiculos">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li><a class="list-group-item"
                                        href='../mantenedores/permisos/mantenedor_permisos.php'>Permisos</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/roles/mantenedor_roles.php'>Roles</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/servicios/mantenedor_servicios.php'>Servicios</a></li>
                                <li><a class="list-group-item"
                                        href='../mantenedores/sucursales/mantenedor_sucursales.php'>Sucursales</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>