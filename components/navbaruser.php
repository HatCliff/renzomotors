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
                style="width: 40px; height: 40px; margin-right: 10px; filter: invert(1); ">
            RenzoMotors
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>index.php' class="nav-link active"
                        aria-current="page">Inicio</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Buscador
                    </a>
    
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href='<?php echo $carpetaMain; ?>pages/buscador_vehiculo.php'>Vehiculo</a></li>
                        <li><a class="dropdown-item" href="#">Accesorios</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href='<?php echo $carpetaMain; ?>pages/comparador.php' class="nav-link active"
                        aria-current="page">Comparador</a>
                </li>
                <?php
                if (isset($_SESSION['usuario'])) {
                } else {
                    // Si no hay una sesión activa, muestra el botón habilitado
                    echo '<li class="nav-item d-flex justify-content-center">
                             <a href="' . $carpetaMain . 'pages/register.php" class="btn btn-light">
                                 <i class="fas fa-sign-in-alt"></i> Únetenos
                             </a>';

                }
                ?>
            </ul>
        </div>
    </div>
</nav>