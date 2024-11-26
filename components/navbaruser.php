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
                style="width: 40px; height: 40px;  filter: invert(1); ">
            RenzoMotors     
        </a>
        <a></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Buscador
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href='<?php echo $carpetaMain; ?>pages/buscador_vehiculo.php'>Vehículo</a></li>
                        <li><a class="dropdown-item" href="<?php echo $carpetaMain; ?>pages/accesorios/buscador_accesorio.php">Accesorios</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/arriendo.php' class="nav-link active" aria-current="page">Arriendo de vehiculo</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/sucursales/mantenimientos.php' class="nav-link active" aria-current="page">Mantenimientos</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/c_seguro/seguro.php' class="nav-link active" aria-current="page">Cotización seguro</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/comparador.php' class="nav-link active" aria-current="page">Comparador</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/prueba_manejo/test_manejo.php' class="nav-link active" aria-current="page">Prueba de Manejo</a>
                </li>
                <?php
                if (isset($_SESSION['usuario'])) {
                    // Si el usuario ha iniciado sesión, muestra el icono de perfil y la opción de cerrar sesión
                    echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Perfil
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/perfil.php">Ver Perfil</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/favoritos/favoritos.php">Ver Mis Favoritos</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/centro_ayuda.php">Ayuda</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/solicitudes_usuario.php">Ver Mis Ayuda</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'auth/logout.php">Cerrar Sesión</a></li>
                            </ul>
                          </li>';
                } else {
                    // Si no hay una sesión activa, muestra el botón de unirse
                    echo '<li class="nav-item d-flex justify-content-center">
                             <a href="' . $carpetaMain . 'pages/register.php" class="btn btn-light">
                                 <i class="fas fa-sign-in-alt"></i> Únetenos
                             </a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
