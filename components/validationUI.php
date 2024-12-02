<?php
function success($yes, $message) {
    $icon = $yes ? "bi bi-check-circle-fill text-success" : "bi bi-x-circle-fill text-danger";
    $status = $yes ? "Aprobado" : "Rechazado";
    $button = $yes ? "btn-success" : "btn-danger";
    $alertClass = $yes ? "alert-success" : "alert-danger";
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Estado de Reserva</title>
        <!-- Bootstrap CSS CDN -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous'>
        <!-- Bootstrap Icons CDN -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
        <style>
            body {
                font-family: 'Montserrat', sans-serif;


            }
            .back {
    position: absolute; /* Asegura que el fondo cubra toda la pantalla */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('/xampp/renzomotors/components/background.png');
    background-repeat: repeat;
    background-size: auto;
    background-position: top left;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: -1; /* Coloca el fondo detrás del contenido */
}

.center-blur {
    position: relative;
    z-index: 1; /* Asegura que el contenido quede por encima del fondo */
    padding: 1rem;
    background-color: rgba(0, 0, 0, 0); /* Fondo blanco semitransparente */
    backdrop-filter: blur(10px); /* Aplica el desenfoque */
    border-radius: 10px; /* Redondea los bordes */
}
            }
            h1 {
                z-index: 1;
                color: black; /* Color del texto principal */
                font-size: 2rem; /* Tamaño del texto */
            }

            .card {
                width: 24rem;
            }

            .card-body {
                padding: 2rem;
            }

            .card-title {
                margin-top: 1rem;
            }

            .btn {
                margin-top: 1rem;
            }

        </style>
    </head>
    <body>
        <div class='d-flex justify-content-center align-items-center vh-100 back'>
        <div class='center-blur'>
            <div class='card text-center rounded shadow '>
                <div class='card-body'>
                    <i class='$icon' style='font-size: 2rem;'></i>
                    <h1 class='card-title mt-2'>$status</h1>
                    <p class='card-text' style='font-size: 1.2rem;'>$message</p>
                    <a href='http://localhost/xampp/renzomotors' class='btn $button'>Volver</a>
                </div>
            </div>
        </div>
        </div>
    </body>
    </html>
    ";
}

function error($code, $message) {
    // Establece las variables de sesión
    $_SESSION['error_code'] = $code;
    $_SESSION['error'] = $message;

    // Comprueba si se solicitó limpiar las variables de sesión
    if (isset($_POST['clear_error'])) {
        unset($_SESSION['error_code']);
        unset($_SESSION['error']);
    }

    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <!-- Bootstrap CSS CDN -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous'>
    </head>
    <body>
    
        <div class='mx-auto fcol-3 fixed-top alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error $code:</strong> $message
            <form method='post' style='display:inline;'>
                <button type='submit' name='clear_error' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </form>
        </div>  

    <!-- Bootstrap JS CDN -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js' crossorigin='anonymous'></script>
    </body>
    </html>
    ";
}

?>