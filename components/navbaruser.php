<?php
$carpetaMain = 'http://localhost/xampp/renzomotors/';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    *{
        font-family: "Montserrat", serif;
    }   
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<nav id='navbar' class="navbar navbar-expand-lg navbar-dark bg-black fixed-top ">
    <div class="container-fluid">
        <a class="navbar-brand" href='<?php echo $carpetaMain; ?>index.php'>
            <img src="<?php echo $carpetaMain; ?>logo.png" alt="Logo"
                style="width: 40px; height: 40px; filter: invert(1);">
            RenzoMotors
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
                    <a href='<?php echo $carpetaMain; ?>pages/sucursales/mantenimientos.php'
                        class="nav-link active">Mantenimientos</a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/c_seguro/seguro.php' class="nav-link active">Seguros</a>
                </li>

                <?php if (!isset($_SESSION['usuario'])) { ?>
                    <li class="nav-item">
                        <a href='<?php echo $carpetaMain; ?>pages/comparador/comparador.php' class="nav-link active">Comparador</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Servicios
                        </a>
                        <ul class="dropdown-menu" style="max-height : 400px;">
                            <li><a class="dropdown-item" href='<?php echo $carpetaMain; ?>pages/arriendo.php'
                                    class="nav-link active">Arriendo de
                                    vehículo</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href='<?php echo $carpetaMain; ?>pages/comparador/comparador.php'>Comparador</a></li>
                            <li><a class="dropdown-item" href='<?php echo $carpetaMain; ?>pages/soap/soap.php'
                                    class="nav-link active">Compra Tu SOAP</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href='<?php echo $carpetaMain; ?>pages/prueba_manejo/test_manejo.php'>Prueba de
                                    Manejo</a></li>
                            <li><a class="dropdown-item"
                                    href='<?php echo $carpetaMain; ?>pages/solicitudes_venta/venta_vehiculos.php'>Vendenos
                                    tu auto</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (isset($_SESSION['usuario'])) {
                    // Si el usuario ha iniciado sesión, muestra el icono de perfil y la opción de cerrar sesión
                    echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active btn btn-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Perfil
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="max-height : 800px;">
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/perfil/perfil.php?accion=0">Ver Perfil</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/favoritos/favoritos.php">Ver Mis Favoritos</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/solicitudes_usuario.php">Ver Mis Ayuda</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/prueba_manejo/mis_pruebas.php">Ver Pruebas de manejo</a></li>
                                <li><a class="dropdown-item" href="' . $carpetaMain . 'pages/solicitudes_venta/mis_solicitudes.php">Ver Mis solicitudes</a></li>
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
