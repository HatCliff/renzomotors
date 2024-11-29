<?php
$carpetaMain = 'http://localhost/xampp/renzomotors/';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href='<?php echo $carpetaMain; ?>index.php'>
            <img src="<?php echo $carpetaMain; ?>logo.png" alt="Logo"
                style="width: 40px; height: 40px; filter: invert(1);">
            RenzoMotors
        </a>
        <!-- boton ayuda  -->
        <a class="nav-link active ms-3" href="<?php echo $carpetaMain; ?>pages/centro_ayuda.php" style="color: white;">
            <i class="fas fa-question-circle"></i> Ayuda
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <!-- Buscador -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Buscador
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/buscador_vehiculo.php'>Vehículo</a></li>
                        <li><a class="dropdown-item"
                                href="<?php echo $carpetaMain; ?>pages/accesorios/buscador_accesorio.php">Accesorios</a>
                        </li>
                    </ul>
                </li>

                <!-- Opciones principales -->
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/arriendo.php' class="nav-link active">Arriendo de
                        vehículo</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/sucursales/mantenimientos.php'
                        class="nav-link active">Mantenimientos</a>

                </li>
                <li class="nav-item">




                    <!-- Servicios agrupados -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Servicios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/c_seguro/seguro.php'>Cotización seguro</a></li>
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/comparador.php'>Comparador</a></li>
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/prueba_manejo/test_manejo.php'>Prueba de
                                Manejo</a></li>
                    </ul>
                </li>

                <!-- Vende tu auto -->
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/solicitudes_venta/venta_vehiculos.php'
                        class="nav-link active">Véndenos tu auto</a>
                </li>

                <!-- Usuario -->
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-user-circle"></i> Perfil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo $carpetaMain; ?>pages/perfil.php">Ver Perfil</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo $carpetaMain; ?>pages/favoritos/favoritos.php">Mis
                                    Favoritos</a></li>
                            <li><a class="dropdown-item" href="<?php echo $carpetaMain; ?>pages/solicitudes_usuario.php">Mis
                                    Solicitudes</a></li>
                            <li><a class="dropdown-item" href="<?php echo $carpetaMain; ?>auth/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?php echo $carpetaMain; ?>pages/register.php" class="btn btn-light">
                            <i class="fas fa-sign-in-alt"></i> Únete
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>